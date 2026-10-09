<?php
/** VM-only integration checks: wp eval-file /srv/glowwise/tests/core-integration.php */
if (!defined('WP_CLI') || !WP_CLI) { exit; }
$GLOBALS['gw_test_checks']=[];$created=[];
function check($name,$condition) { $GLOBALS['gw_test_checks'][]=['test'=>$name,'pass'=>(bool)$condition];if (!$condition) { throw new RuntimeException($name); } }
try {
    $catalog=gw_catalog();check('36 published, validated product families',count($catalog)>=36);
    $categories=array_count_values(array_column($catalog,'category'));check('All six categories represented',count($categories)===6);
    $data=$catalog[0];foreach (['id','slug','name','url','selectedVariant','matchReasons'] as $k) { unset($data[$k]); }
    check('Impossible date rejected',is_wp_error(gw_validate_product(array_replace($data,['checked'=>'2026-02-31']))));
    check('Future date rejected',is_wp_error(gw_validate_product(array_replace($data,['checked'=>'2099-01-01']))));
    check('Unknown product type rejected',is_wp_error(gw_validate_product(array_replace($data,['type'=>'invented']))));
    check('Non-HTTP retailer rejected',is_wp_error(gw_validate_product(array_replace($data,['retailer'=>'javascript:alert(1)']))));
    $bad=$data;$bad['variants'][0]['price']=-1;check('Negative price rejected',is_wp_error(gw_validate_product($bad)));
    $bad=$data;$bad['variants'][]=$bad['variants'][0];check('Duplicate variant rejected',is_wp_error(gw_validate_product($bad)));
    check('Nested filter rejected',is_wp_error(gw_validate_filters(['q'=>['nested']])));
    check('Unknown filter rejected',is_wp_error(gw_validate_filters(['secret'=>'value'])));
    check('Out-of-range page rejected',is_wp_error(gw_validate_filters(['page'=>0])));
    $f=gw_validate_filters(['type'=>$catalog[0]['type'],'max-price'=>0.01]);$results=gw_filter_catalog($f);check('Honest budget no-match',!is_wp_error($results)&&$results['total']===0);
    $f=gw_validate_filters(['fragrance-free'=>'yes']);$results=gw_filter_catalog($f);check('Verified attribute filter contains only explicit yes',count($results['products'])>0 && !array_filter($results['products'],fn($p)=>($p['attributes']['fragrance-free']??'unknown')!=='yes'));
    $first=$catalog[0];$same=array_values(array_filter($catalog,fn($p)=>$p['type']===$first['type']&&$p['id']!==$first['id']));$different=array_values(array_filter($catalog,fn($p)=>$p['type']!==$first['type']));
    check('Same-type comparison succeeds',!is_wp_error(gw_comparison([$first['id'],$same[0]['id']])));
    check('Mixed-type comparison rejected',is_wp_error(gw_comparison([$first['id'],$different[0]['id']])));
    check('Fourth comparison item rejected',is_wp_error(gw_comparison([1,2,3,4])));
    check('Duplicate comparison rejected',is_wp_error(gw_comparison([$first['id'],$first['id']])));
    check('Stale variant rejected',is_wp_error(gw_comparison([['id'=>$first['id'],'variant'=>'deleted-pack']])));
    check('Nested comparison ID rejected',is_wp_error(gw_comparison([['id'=>['nested']]])));
    check('Boolean comparison ID rejected',is_wp_error(gw_comparison([true])));
    $draft=wp_insert_post(['post_type'=>'gw_product','post_status'=>'draft','post_title'=>'Glowwise disposable draft fixture','meta_input'=>['_gw_data'=>$data]],true);$created[]=$draft;
    check('Draft is absent from public model',gw_product($draft)===null);
    wp_set_current_user(0);$r=rest_do_request(new WP_REST_Request('GET','/glowwise/v1/products/'.$draft));check('Draft REST record denied',$r->get_status()===404);
    $r=rest_do_request(new WP_REST_Request('GET','/wp/v2/gw_message'));check('Private message REST type absent',$r->get_status()===404);
    $r=rest_do_request(new WP_REST_Request('GET','/wp/v2/users'));check('Anonymous account directory absent',$r->get_status()===404);
    check('Anonymous private inbox capability denied',!current_user_can('manage_options'));
    $subscriber=wp_insert_user(['user_login'=>'gw-disposable-'.bin2hex(random_bytes(6)),'user_pass'=>wp_generate_password(32,true,true),'user_email'=>'fixture@invalid.example','role'=>'subscriber']);check('Disposable subscriber created',!is_wp_error($subscriber));wp_set_current_user($subscriber);check('Subscriber cannot manage/read inbox',!current_user_can('manage_options')&&!current_user_can('edit_post',$draft));wp_set_current_user(0);
    check('Contact rejects absent CSRF',is_wp_error(gw_contact_submit([],home_url(),'')));
    $seed=bin2hex(random_bytes(24)).'.'.(time()+3600);$token=$seed.'.'.hash_hmac('sha256',$seed,wp_salt('nonce'));
    $form=['token'=>$token,'name'=>'Disposable test','email'=>'fixture@invalid.example','subject'=>'Disposable integration fixture','message'=>'This is an explicitly disposable automated test message.','kind'=>'contact','consent'=>'yes','website'=>''];
    check('Cross-origin contact rejected',is_wp_error(gw_contact_submit($form,'https://invalid.example',$token)));
    check('Token/cookie mismatch rejected',is_wp_error(gw_contact_submit($form,home_url(),'wrong')));
    check('Overlong contact rejected',is_wp_error(gw_contact_submit(array_replace($form,['message'=>str_repeat('x',3001)]),home_url(),$token)));
    check('Honeypot rejected',is_wp_error(gw_contact_submit(array_replace($form,['website'=>'spam']),home_url(),$token)));
    check('Correction needs supporting URL',is_wp_error(gw_contact_submit(array_replace($form,['kind'=>'correction']),home_url(),$token)));
    $_SERVER['HTTP_X_GW_CLIENT_IP']='fixture-'.bin2hex(random_bytes(6));$response=gw_contact_submit($form,home_url(),$token);check('Valid contact gets private storage receipt',!is_wp_error($response)&&preg_match('/^[A-F0-9]{12}$/',$response['receipt']));
    $messages=get_posts(['post_type'=>'gw_message','post_status'=>'private','name'=>'','s'=>'Message '.$response['receipt'],'numberposts'=>1]);check('Stored message remains private',count($messages)===1);$created[]=$messages[0]->ID;
    wp_set_current_user($subscriber);check('Subscriber cannot read/edit private message',!current_user_can('read_post',$messages[0]->ID)&&!current_user_can('edit_post',$messages[0]->ID));wp_set_current_user(0);
    check('Message omitted from public search',!in_array($messages[0]->ID,get_posts(['s'=>'Disposable integration fixture','post_status'=>'publish','fields'=>'ids'])));
    for ($i=0;$i<4;$i++) { $resp=gw_contact_submit($form,home_url(),$token);$m=get_posts(['post_type'=>'gw_message','post_status'=>'private','s'=>'Message '.$resp['receipt'],'numberposts'=>1]);$created[]=$m[0]->ID; }
    $limited=gw_contact_submit($form,home_url(),$token);check('Sixth hourly message is rate limited',is_wp_error($limited)&&$limited->get_error_code()==='rate_limit');
    $expired=wp_insert_post(['post_type'=>'gw_message','post_status'=>'private','post_title'=>'Disposable expired fixture','meta_input'=>['_gw_expires'=>time()-10,'_gw_message'=>['expires'=>time()-10]]]);$created[]=$expired;do_action('gw_retention_daily');check('Expired live fixture permanently removed',get_post($expired)===null);check('Unexpired fixture retained',get_post($messages[0]->ID)!==null);
    $invalid=wp_insert_post(['post_type'=>'gw_product','post_status'=>'publish','post_title'=>'Disposable invalid publication fixture']);$created[]=$invalid;check('Invalid product cannot publish',get_post_status($invalid)==='draft');
    $guide=wp_insert_post(['post_type'=>'post','post_status'=>'draft','post_title'=>'Disposable research editor fixture']);$created[]=$guide;
    $admins=get_users(['role'=>'administrator','fields'=>'ID']);wp_set_current_user($admins[0]);
    $_POST=['gw_guide_nonce'=>wp_create_nonce('gw_guide_save'),'gw_guide_checked'=>'2099-01-01','_gw_sources'=>'https://glowwise.tech/how-we-select/','_gw_product_slugs'=>$first['slug']];
    wp_update_post(['ID'=>$guide,'post_title'=>'Disposable invalid check-date fixture']);check('Guide admin rejects a future check date',get_post_meta($guide,'_gw_checked',true)==='');
    $_POST['gw_guide_checked']=gmdate('Y-m-d');wp_update_post(['ID'=>$guide,'post_title'=>'Disposable valid research fixture']);
    check('Guide admin persists validated sources/date/related product',get_post_meta($guide,'_gw_checked',true)===gmdate('Y-m-d') && get_post_meta($guide,'_gw_sources',true)===['https://glowwise.tech/how-we-select/'] && get_post_meta($guide,'_gw_product_slugs',true)===[$first['slug']]);
    wp_set_current_user($subscriber);$_POST['gw_guide_nonce']=wp_create_nonce('gw_guide_save');$_POST['_gw_sources']='https://invalid.example/';wp_update_post(['ID'=>$guide,'post_title'=>'Disposable denied metadata fixture']);
    check('Subscriber cannot change guide research metadata',get_post_meta($guide,'_gw_sources',true)===['https://glowwise.tech/how-we-select/']);$_POST=[];wp_set_current_user(0);
    check('Daily inbox retention scheduled',wp_next_scheduled('gw_retention_daily')!==false);
} finally {
    foreach ($created as $id) { if (is_int($id)&&$id>0) { wp_delete_post($id,true); } }
    if (isset($subscriber)&&is_int($subscriber)) { require_once ABSPATH.'wp-admin/includes/user.php';wp_delete_user($subscriber); }
    wp_set_current_user(0);
}
check('Disposable messages/products removed',!array_filter($created,fn($id)=>is_int($id)&&get_post($id)!==null));
WP_CLI::line(wp_json_encode(['capturedUTC'=>gmdate('c'),'purpose'=>'Real WordPress rule, REST, capability, CSRF, spam, retention and publication checks; disposable fixtures only','checks'=>$GLOBALS['gw_test_checks']],JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES));
