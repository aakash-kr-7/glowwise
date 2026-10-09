<?php
if (!defined('ABSPATH')) { exit; }
function gw_contact_token() {
    $token=$_COOKIE['gw_form_guard']??'';
    if (!gw_token_valid($token)) { $seed=bin2hex(random_bytes(24)).'.'.(time()+3600);$token=$seed.'.'.hash_hmac('sha256',$seed,wp_salt('nonce'));setcookie('gw_form_guard',$token,['expires'=>time()+3600,'path'=>'/','secure'=>true,'httponly'=>true,'samesite'=>'Strict']);$_COOKIE['gw_form_guard']=$token; }
    return $token;
}
function gw_token_valid($token) {
    if (!is_string($token) || strlen($token)>200) { return false; }$parts=explode('.',$token);
    return count($parts)===3 && preg_match('/^[a-f0-9]{48}$/',$parts[0]) && ctype_digit($parts[1]) && (int)$parts[1]>time() && (int)$parts[1]<time()+3700 && hash_equals(hash_hmac('sha256',$parts[0].'.'.$parts[1],wp_salt('nonce')),$parts[2]);
}
function gw_contact_submit($input,$origin,$cookie) {
    if (!is_array($input) || $origin!==home_url() || !gw_token_valid($input['token']??'') || !is_string($cookie) || !hash_equals($cookie,$input['token'])) { return new WP_Error('csrf','Your form session expired or could not be verified. Refresh this page and try again.',['status'=>403]); }
    foreach (['name'=>80,'email'=>254,'message'=>3000,'subject'=>120,'source_page'=>1000,'reference'=>1000,'website'=>200] as $k=>$length) { if (!is_string($input[$k]??'') || mb_strlen($input[$k]??'')>$length) { return new WP_Error('length','A field is too long or has an invalid format.',['status'=>400]); } }
    $name=trim($input['name']??'');$email=trim($input['email']??'');$text=trim($input['message']??'');
    if ($name==='' || !is_email($email) || mb_strlen($text)<20 || mb_strlen($text)>3000 || strlen(trim($input['subject']??''))<3 || !in_array($input['kind']??'',['contact','correction'],true) || ($input['consent']??'')!=='yes') { return new WP_Error('validation','Enter your name, valid reply email, subject and a message of 20–3,000 characters, and agree to message handling.',['status'=>400]); }
    if (!empty($input['website'])) { return new WP_Error('spam','The submission could not be accepted. Please use the visible fields only.',['status'=>400]); }
    if (($input['kind']??'')==='correction' && (!gw_valid_http_url($input['source_page']??'') || !gw_valid_http_url($input['reference']??''))) { return new WP_Error('validation','For a correction, include the affected page and a supporting HTTP(S) source.',['status'=>400]); }
    // Caddy overwrites this header with its verified client_ip; never trust visitor-supplied forwarding headers here.
    $address=$_SERVER['HTTP_X_GW_CLIENT_IP']??($_SERVER['REMOTE_ADDR']??'unknown');
    $bucket=gmdate('Y-m-d-H');$key='gw_rate_'.hash_hmac('sha256',$address.'|'.$bucket,wp_salt('auth'));
    $count=(int)get_transient($key);if ($count>=5) { return new WP_Error('rate_limit','Too many messages from this connection. Wait an hour before trying again.',['status'=>429]); }set_transient($key,$count+1,2*HOUR_IN_SECONDS);
    $receipt=strtoupper(substr(bin2hex(random_bytes(12)),0,12));
    $id=wp_insert_post(['post_type'=>'gw_message','post_status'=>'private','post_title'=>'Message '.$receipt,'post_content'=>'','meta_input'=>['_gw_expires'=>time()+90*DAY_IN_SECONDS,'_gw_message'=>['receipt'=>$receipt,'name'=>sanitize_text_field($name),'email'=>sanitize_email($email),'subject'=>sanitize_text_field($input['subject']),'message'=>sanitize_textarea_field($text),'kind'=>$input['kind'],'source_page'=>esc_url_raw($input['source_page']??''),'reference'=>esc_url_raw($input['reference']??''),'received'=>gmdate('c'),'expires'=>time()+90*DAY_IN_SECONDS]]],true);
    if (is_wp_error($id) || !$id) { return new WP_Error('storage','We could not save your message. It has not been delivered; please try again later.',['status'=>503]); }
    return ['receipt'=>$receipt,'message'=>'Your message was saved in the private Glowwise inbox. Keep reference '.$receipt.'. No email confirmation is sent.'];
}
add_action('rest_api_init',function () {
    register_rest_route('glowwise/v1','/contact-token',['methods'=>'GET','permission_callback'=>'__return_true','callback'=>fn()=>['token'=>gw_contact_token()]]);
    register_rest_route('glowwise/v1','/contact',['methods'=>'POST','permission_callback'=>'__return_true','callback'=>function($r) { return gw_contact_submit($r->get_json_params()?:[],$r->get_header('origin'),$_COOKIE['gw_form_guard']??''); }]);
});
add_action('template_redirect',function () { if (is_page(['contact','corrections'])) { gw_contact_token();if (!defined('DONOTCACHEPAGE')) { define('DONOTCACHEPAGE',true); }nocache_headers(); } });
function gw_native_contact() {
    $result=gw_contact_submit(wp_unslash($_POST),$_SERVER['HTTP_ORIGIN']??'',$_COOKIE['gw_form_guard']??'');
    $route=($_POST['kind']??'')==='correction'?'corrections':'contact';
    $args=is_wp_error($result)?['form-error'=>$result->get_error_code()]:['received'=>$result['receipt']];
    wp_safe_redirect(add_query_arg($args,home_url('/'.$route.'/')).'#contact-form',303);exit;
}
add_action('admin_post_nopriv_gw_contact','gw_native_contact');add_action('admin_post_gw_contact','gw_native_contact');
add_action('add_meta_boxes_gw_message',function () { add_meta_box('gw_message_body','Private message (90-day retention)','gw_message_metabox','gw_message','normal','high'); });
function gw_message_metabox($post) {
    if (!current_user_can('manage_options')) { return; }$m=get_post_meta($post->ID,'_gw_message',true);
    foreach (($m?:[]) as $k=>$v) { echo '<p><strong>'.esc_html(ucwords(str_replace('_',' ',$k))).':</strong> '.nl2br(esc_html(is_scalar($v)?(string)$v:'')).'</p>'; }
    echo '<p>Use Move to Trash then permanent deletion for an approved early deletion request. Match the sender and receipt before deletion. No message is sent automatically.</p>';
}
add_action('gw_retention_daily',function () {
    $ids=get_posts(['post_type'=>'gw_message','post_status'=>['private','trash'],'numberposts'=>200,'fields'=>'ids','meta_query'=>[['key'=>'_gw_expires','value'=>time(),'compare'=>'<','type'=>'NUMERIC']]]);
    foreach ($ids as $id) { $m=get_post_meta($id,'_gw_message',true);if (is_array($m) && isset($m['expires']) && (int)$m['expires']<time()) { wp_delete_post($id,true); } }
});
add_filter('manage_gw_message_posts_columns',fn($c)=>['cb'=>$c['cb'],'title'=>'Private reference','date'=>'Received']);
add_filter('wp_sitemaps_post_types',function($types) { unset($types['gw_message']);return $types; });
