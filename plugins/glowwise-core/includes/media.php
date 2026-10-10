<?php
if (!defined('ABSPATH')) { exit; }
/* Variant photographs are durable catalog metadata, independent of the theme. */
function gw_validate_images($records,$product) {
    if (!is_array($records) || count($records)>12) { return new WP_Error('invalid_images','Use at most twelve variant image records.'); }
    $labels=array_column($product['variants']??[],'label');$clean=[];
    foreach ($records as $label=>$image) {
        if (!in_array($label,$labels,true) || !is_array($image)) { return new WP_Error('invalid_images','Each photograph must match an exact checked variant.'); }
        $id=absint($image['attachmentId']??0);
        if (!$id || get_post_type($id)!=='attachment' || !in_array(get_post_mime_type($id),['image/jpeg','image/png','image/webp','image/avif'],true)) { return new WP_Error('invalid_images','Choose an uploaded JPEG, PNG, WebP or AVIF attachment.'); }
        foreach (['source','licenseUrl'] as $key) { if (!gw_valid_http_url($image[$key]??'')) { return new WP_Error('invalid_images','Provide the photo source and usage-rights URL.'); } }
        foreach (['alt','credit','license'] as $key) { if (!is_string($image[$key]??null) || !trim($image[$key]) || strlen($image[$key])>400) { return new WP_Error('invalid_images','Alternative text, credit and licence are required (up to 400 characters).'); } }
        $date=is_string($image['checked']??null)?DateTimeImmutable::createFromFormat('!Y-m-d',$image['checked']):false;
        if (!$date || $date->format('Y-m-d')!==$image['checked'] || $image['checked']>gmdate('Y-m-d')) { return new WP_Error('invalid_images','Use the actual rights-check date.'); }
        $clean[$label]=['attachmentId'=>$id,'source'=>esc_url_raw($image['source']),'licenseUrl'=>esc_url_raw($image['licenseUrl']),'checked'=>$image['checked']];
        foreach (['alt','credit','license'] as $key) { $clean[$label][$key]=sanitize_text_field($image[$key]); }
    }
    return $clean;
}
function gw_product_images($id,$product) {
    $records=get_post_meta($id,'_gw_variant_images',true);$valid=gw_validate_images(is_array($records)?$records:[],$product);if (is_wp_error($valid)) { return []; }
    $images=[];
    foreach ($valid as $label=>$record) {
        $image=wp_get_attachment_image_src($record['attachmentId'],'large');if (!$image) { continue; }
        $images[$label]=['src'=>$image[0],'width'=>$image[1],'height'=>$image[2],'srcset'=>wp_get_attachment_image_srcset($record['attachmentId'],'large')?:'']+array_diff_key($record,['attachmentId'=>true]);
    }
    return $images;
}
add_action('add_meta_boxes_gw_product',function() { add_meta_box('gw_variant_images','Verified variant photographs','gw_images_metabox','gw_product','normal','default'); });
function gw_images_metabox($post) {
    wp_nonce_field('gw_images_save','gw_images_nonce');$images=get_post_meta($post->ID,'_gw_variant_images',true);
    echo '<p>Upload a photograph in Media, then record its attachment ID under the exact pack/model label. Record the actual rights status: an open licence, owner-owned photo, or the explicitly owner-authorised demonstration use. Public visibility is not an open licence; never invent permission. Empty object {} clears photographs without changing product facts.</p><p>Record fields: attachmentId, source, licenseUrl, license, credit, alt, checked (YYYY-MM-DD). These fields are public attribution; do not put private permission correspondence in them.</p><textarea class="widefat code" name="gw_variant_images" rows="12">'.esc_textarea(wp_json_encode(is_array($images)?$images:(object)[],JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES)).'</textarea>';
}
add_action('save_post_gw_product',function($id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE || wp_is_post_revision($id) || !isset($_POST['gw_images_nonce']) || !current_user_can('edit_post',$id) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['gw_images_nonce'])),'gw_images_save')) { return; }
    $json=wp_unslash($_POST['gw_variant_images']??'');$records=is_string($json)?json_decode($json,true):null;
    $valid=gw_validate_images($records,get_post_meta($id,'_gw_data',true));
    if (is_wp_error($valid)) { set_transient('gw_image_error_'.get_current_user_id(),$valid->get_error_message(),120);return; }
    update_post_meta($id,'_gw_variant_images',$valid);
});
add_action('admin_notices',function() { $error=get_transient('gw_image_error_'.get_current_user_id());if ($error) { echo '<div class="notice notice-error"><p>Photographs unchanged: '.esc_html($error).'</p></div>';delete_transient('gw_image_error_'.get_current_user_id()); } });
