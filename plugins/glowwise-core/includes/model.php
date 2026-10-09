<?php
if (!defined('ABSPATH')) { exit; }
function gw_categories() {
    return ['skincare'=>'Skincare','haircare'=>'Haircare','bodycare'=>'Bodycare','fragrance'=>'Fragrance','beard-grooming'=>'Beard & grooming','grooming-tools'=>'Grooming tools'];
}
function gw_types() { return ['sunscreen'=>'Sunscreen','face-cleanser'=>'Face cleanser','shampoo'=>'Shampoo','body-lotion'=>'Body lotion','eau-de-parfum'=>'Eau de parfum','beard-oil'=>'Beard oil','beard-trimmer'=>'Beard trimmer']; }
function gw_register_model() {
    register_post_type('gw_product', ['labels'=>['name'=>'Glowwise products','singular_name'=>'Product','add_new_item'=>'Add researched product','edit_item'=>'Edit product'], 'public'=>true,'show_in_rest'=>false,'menu_icon'=>'dashicons-products','supports'=>['title','editor','excerpt','revisions'],'rewrite'=>['slug'=>'products','with_front'=>false],'has_archive'=>'explore','map_meta_cap'=>true]);
    register_taxonomy('gw_category',['gw_product','post'],['labels'=>['name'=>'Grooming categories','singular_name'=>'Grooming category'],'public'=>true,'hierarchical'=>true,'show_in_rest'=>true,'rewrite'=>['slug'=>'categories','with_front'=>false,'hierarchical'=>false]]);
    register_taxonomy('gw_type','gw_product',['labels'=>['name'=>'Product types','singular_name'=>'Product type'],'public'=>false,'show_ui'=>true,'show_in_rest'=>false,'hierarchical'=>true,'rewrite'=>false]);
    register_post_type('gw_message',['labels'=>['name'=>'Private Glowwise inbox','singular_name'=>'Private message'],'public'=>false,'publicly_queryable'=>false,'exclude_from_search'=>true,'show_ui'=>true,'show_in_menu'=>true,'show_in_rest'=>false,'supports'=>['title'],'menu_icon'=>'dashicons-email','capabilities'=>['edit_post'=>'manage_options','read_post'=>'manage_options','delete_post'=>'manage_options','edit_posts'=>'manage_options','edit_others_posts'=>'manage_options','publish_posts'=>'do_not_allow','read_private_posts'=>'manage_options','create_posts'=>'do_not_allow','delete_posts'=>'manage_options'],'map_meta_cap'=>false]);
}
add_action('init','gw_register_model');
function gw_valid_http_url($url) {
    return is_string($url) && strlen($url)<=1000 && filter_var($url,FILTER_VALIDATE_URL) && in_array(strtolower(wp_parse_url($url,PHP_URL_SCHEME)),['http','https'],true);
}
function gw_validate_product($data) {
    if (!is_array($data)) { return new WP_Error('invalid_data','Product facts must be an object.'); }
    foreach (['brand','summary','strength','limitation','category','type','checked','source','retailer','variants','attributes'] as $field) { if (!array_key_exists($field,$data)) { return new WP_Error('missing_field','Missing field: '.$field); } }
    if (!is_string($data['category']) || !is_string($data['type']) || !isset(gw_categories()[$data['category']]) || !isset(gw_types()[$data['type']])) { return new WP_Error('invalid_taxonomy','Choose an approved category and product type.'); }
    $date=is_string($data['checked'])?DateTimeImmutable::createFromFormat('!Y-m-d',$data['checked']):false;
    if (!$date || $date->format('Y-m-d')!==$data['checked'] || $data['checked']>gmdate('Y-m-d')) { return new WP_Error('invalid_date','Use a real check date, not a future date.'); }
    $categoryForType=['sunscreen'=>'skincare','face-cleanser'=>'skincare','shampoo'=>'haircare','body-lotion'=>'bodycare','eau-de-parfum'=>'fragrance','beard-oil'=>'beard-grooming','beard-trimmer'=>'grooming-tools'];
    if ($categoryForType[$data['type']]!==$data['category']) { return new WP_Error('invalid_taxonomy','The category must match the product type.'); }
    if (!gw_valid_http_url($data['source']) || !gw_valid_http_url($data['retailer'])) { return new WP_Error('invalid_source','A real HTTP(S) source and retailer URL are required.'); }
    if (!is_array($data['variants']) || !count($data['variants']) || count($data['variants'])>12) { return new WP_Error('invalid_variants','Provide 1–12 checked variants.'); }
    $variants=[];$labels=[];
    foreach ($data['variants'] as $v) {
        if (!is_array($v) || empty($v['label']) || !is_string($v['label']) || !isset($v['price']) || !is_numeric($v['price']) || $v['price']<=0 || $v['price']>100000 || !gw_valid_http_url($v['source']??$data['retailer'])) { return new WP_Error('invalid_price','Every variant needs an identified pack/model, positive checked INR price and source.'); }
        foreach (['availability','priceBasis'] as $field) { if (isset($v[$field]) && (!is_string($v[$field]) || strlen($v[$field])>300)) { return new WP_Error('invalid_variant','Variant notes must be short text.'); } }
        $label=sanitize_text_field($v['label']);if (strlen($label)>100 || isset($labels[$label])) { return new WP_Error('invalid_variant','Variant labels must be unique and under 100 characters.'); }$labels[$label]=true;
        $variants[]=['label'=>$label,'price'=>round((float)$v['price'],2),'source'=>esc_url_raw($v['source']??$data['retailer']),'availability'=>sanitize_text_field($v['availability']??'Check at retailer'),'priceBasis'=>sanitize_text_field($v['priceBasis']??'Displayed item price; shipping extra if applicable')];
    }
    if (!is_array($data['attributes']) || count($data['attributes'])>18) { return new WP_Error('invalid_attributes','Attributes must be a bounded key/value object.'); }
    $attributes=[]; foreach ($data['attributes'] as $k=>$v) {
        if (!is_string($v) || strlen($v)>240 || !preg_match('/^[a-z][a-z0-9_-]{0,39}$/',$k)) { return new WP_Error('invalid_attribute','Use short named factual attributes and text values; unknowns stay unknown.'); }
        $attributes[$k]=sanitize_text_field($v);
    }
    $clean=[];foreach (['brand','summary','strength','limitation'] as $k) {
        if (!is_string($data[$k]) || strlen($data[$k])>1400 || trim($data[$k])==='') { return new WP_Error('invalid_text','Editorial fields must be non-empty, bounded text.'); }
        $clean[$k]=sanitize_textarea_field($data[$k]);
    }
    $clean+=['category'=>$data['category'],'type'=>$data['type'],'checked'=>$data['checked'],'source'=>esc_url_raw($data['source']),'retailer'=>esc_url_raw($data['retailer']),'variants'=>$variants,'attributes'=>$attributes,'imageRights'=>'Original Glowwise non-packaging illustration; no product photograph reused.'];
    if (isset($data['sources']) && (!is_array($data['sources']) || count($data['sources'])>10)) { return new WP_Error('invalid_sources','Use at most ten supporting source URLs.'); }
    $clean['sources']=[];foreach ($data['sources']??[] as $u) { if (!gw_valid_http_url($u)) { return new WP_Error('invalid_sources','Every supporting source must be an HTTP(S) URL.'); } $clean['sources'][]=esc_url_raw($u); }
    return $clean;
}
add_action('add_meta_boxes',function () { add_meta_box('gw_product_facts','Verified facts and editorial selection','gw_product_metabox','gw_product','normal','high'); });
function gw_product_metabox($post) {
    $d=get_post_meta($post->ID,'_gw_data',true);$d=is_array($d)?$d:[];
    wp_nonce_field('gw_product_save','gw_product_nonce');
    echo '<p>Change facts here; native title/body are editable above. Publishing requires complete checked facts. Taxonomies follow the selected fields. These records remain when the theme changes.</p>';
    foreach (['brand'=>'Brand','summary'=>'Why consider it','strength'=>'Useful distinction','limitation'=>'Limitations','checked'=>'Last checked (YYYY-MM-DD)','source'=>'Primary factual source URL','retailer'=>'Retailer destination URL'] as $k=>$label) {
        echo '<p><label for="gw-'.$k.'"><strong>'.esc_html($label).'</strong></label><br><textarea class="widefat" id="gw-'.$k.'" name="gw_facts['.$k.']" rows="'.(in_array($k,['summary','strength','limitation'])?2:1).'">'.esc_textarea($d[$k]??'').'</textarea></p>';
    }
    foreach (['category'=>gw_categories(),'type'=>gw_types()] as $k=>$options) { echo '<p><label>'.esc_html(ucfirst($k)).' <select name="gw_facts['.$k.']">';foreach ($options as $v=>$label) { echo '<option value="'.esc_attr($v).'" '.selected($d[$k]??'',$v,false).'>'.esc_html($label).'</option>'; } echo '</select></label></p>'; }
    foreach (['variants'=>'Variants: JSON array with label, price, source, availability and priceBasis','attributes'=>'Verified attributes: JSON object; use unknown where not documented','sources'=>'Additional source URLs: JSON array'] as $k=>$label) { echo '<p><label><strong>'.esc_html($label).'</strong><textarea class="widefat code" name="gw_json['.$k.']" rows="5">'.esc_textarea(wp_json_encode($d[$k]??($k==='attributes'?(object)[]:[]),JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES)).'</textarea></label></p>'; }
}
add_action('save_post_gw_product',function ($id) {
    if (!empty($GLOBALS['gw_validation_draft']) || defined('DOING_AUTOSAVE') && DOING_AUTOSAVE || wp_is_post_revision($id) || !isset($_POST['gw_product_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['gw_product_nonce'])),'gw_product_save') || !current_user_can('edit_post',$id)) { return; }
    $raw=wp_unslash($_POST['gw_facts']??[]);$raw=is_array($raw)?$raw:[];foreach (['variants','attributes','sources'] as $k) { $json=$_POST['gw_json'][$k]??'';$raw[$k]=is_string($json)?json_decode(wp_unslash($json),true):null; }
    $d=gw_validate_product($raw);
    if (is_wp_error($d)) { set_transient('gw_edit_error_'.get_current_user_id(),$d->get_error_message(),120); $GLOBALS['gw_validation_draft']=true; wp_update_post(['ID'=>$id,'post_status'=>'draft']); unset($GLOBALS['gw_validation_draft']);return; }
    update_post_meta($id,'_gw_data',$d);wp_set_object_terms($id,$d['category'],'gw_category');wp_set_object_terms($id,$d['type'],'gw_type');
    delete_transient('gw_catalog');
});
add_filter('wp_insert_post_data',function($data,$postarr) {
    if (($data['post_type']??'')==='gw_product' && $data['post_status']==='publish') {
        if (!empty($GLOBALS['gw_validation_draft'])) { $data['post_status']='draft'; }
        elseif (!isset($_POST['gw_product_nonce']) && is_wp_error(gw_validate_product(get_post_meta($postarr['ID']??0,'_gw_data',true)))) { $data['post_status']='draft'; }
    }return $data;
},10,2);
add_action('admin_notices',function () { $e=get_transient('gw_edit_error_'.get_current_user_id());if ($e) { echo '<div class="notice notice-error"><p>Product kept in draft: '.esc_html($e).'</p></div>';delete_transient('gw_edit_error_'.get_current_user_id()); } });
add_action('save_post',function($id) { if (get_post_type($id)==='gw_product') { delete_transient('gw_catalog'); } });
add_action('deleted_post',function() { delete_transient('gw_catalog'); });
add_action('add_meta_boxes_post',function() { add_meta_box('gw_guide_research','Glowwise research record','gw_guide_metabox','post','normal','high'); });
function gw_guide_metabox($post) {
    wp_nonce_field('gw_guide_save','gw_guide_nonce');
    echo '<p><label>Last factual check (YYYY-MM-DD)<input type="date" name="gw_guide_checked" value="'.esc_attr(get_post_meta($post->ID,'_gw_checked',true)).'" max="'.esc_attr(gmdate('Y-m-d')).'"></label></p>';
    foreach (['_gw_sources'=>'Supporting HTTP(S) source URLs, one per line (up to 10)','_gw_product_slugs'=>'Related published product slugs, one per line (up to 12)'] as $key=>$label) {
        $values=get_post_meta($post->ID,$key,true);echo '<p><label>'.esc_html($label).'<textarea class="widefat" name="'.esc_attr($key).'" rows="5">'.esc_textarea(is_array($values)?implode("\n",$values):'').'</textarea></label></p>';
    }
    echo '<p>Edit inline citations and article text in the native editor. Update the check date only after actually rechecking the facts; this field is not an automatic freshness promise.</p>';
}
add_action('save_post_post',function($id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE || wp_is_post_revision($id) || !isset($_POST['gw_guide_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['gw_guide_nonce'])),'gw_guide_save') || !current_user_can('edit_post',$id)) { return; }
    $checked=wp_unslash($_POST['gw_guide_checked']??'');$date=is_string($checked)?DateTimeImmutable::createFromFormat('!Y-m-d',$checked):false;
    $sourceText=wp_unslash($_POST['_gw_sources']??'');$slugText=wp_unslash($_POST['_gw_product_slugs']??'');
    $sources=is_string($sourceText)?array_values(array_filter(array_map('trim',explode("\n",$sourceText)))):[];
    $slugs=is_string($slugText)?array_values(array_unique(array_filter(array_map('trim',explode("\n",$slugText))))):[];
    $invalidSlugs=array_filter($slugs,function($slug) { if (!preg_match('/^[a-z0-9-]{1,150}$/',$slug)) { return true; }$product=get_page_by_path($slug,OBJECT,'gw_product');return !$product || !gw_product($product->ID); });
    if (!$date || $date->format('Y-m-d')!==$checked || $checked>gmdate('Y-m-d') || count($sources)>10 || array_filter($sources,fn($u)=>!gw_valid_http_url($u)) || count($slugs)>12 || $invalidSlugs) {
        set_transient('gw_guide_error_'.get_current_user_id(),'Research fields were not saved. Use a real check date, at most ten HTTP(S) sources and twelve valid product slugs.',120);return;
    }
    update_post_meta($id,'_gw_checked',$checked);update_post_meta($id,'_gw_sources',$sources);update_post_meta($id,'_gw_product_slugs',$slugs);
    delete_transient('gw_guide_error_'.get_current_user_id());
});
add_action('admin_notices',function() { $error=get_transient('gw_guide_error_'.get_current_user_id());if ($error) { echo '<div class="notice notice-error"><p>'.esc_html($error).'</p></div>';delete_transient('gw_guide_error_'.get_current_user_id()); } });
