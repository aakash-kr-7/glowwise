<?php
/** wp eval-file /srv/glowwise/scripts/import-visual-media.php */
if (!defined('WP_CLI') || !WP_CLI) { exit; }
function gw_visual_caption($record) {
    $id=$record['attachmentId']??0;if (!$id || get_post_field('post_excerpt',$id)) { return; }
    wp_update_post(['ID'=>$id,'post_excerpt'=>esc_html($record['credit']).' · <a href="'.esc_url($record['source']).'">Photo source</a> · <a rel="license" href="'.esc_url($record['licenseUrl']).'">'.esc_html($record['license']).'</a>']);
}
$post=get_page_by_path('plum-rice-water-spf-50',OBJECT,'gw_product');
if (!$post || !($product=gw_product($post->ID)) || !in_array('50 g',array_column($product['variants'],'label'),true)) { WP_CLI::error('Exact published product/50 g variant is required.'); }
$existing=get_post_meta($post->ID,'_gw_variant_images',true);
if (is_array($existing) && isset($existing['50 g'])) {
    if (!is_wp_error(gw_validate_images($existing,$product))) { gw_visual_caption($existing['50 g']); }
    WP_CLI::success('Existing variant image and edited caption preserved; missing native attribution filled; no duplicate attachment.');return;
}
require_once ABSPATH.'wp-admin/includes/file.php';require_once ABSPATH.'wp-admin/includes/media.php';require_once ABSPATH.'wp-admin/includes/image.php';
$sourceKey='openbeautyfacts-8904430201070-front-en-3';
$ids=get_posts(['post_type'=>'attachment','post_status'=>'inherit','numberposts'=>1,'fields'=>'ids','meta_key'=>'_gw_licensed_source','meta_value'=>$sourceKey]);
if ($ids) { $id=$ids[0]; }
else {
    $file='/srv/glowwise/content/licensed-media/plum-rice-water-50g.webp';if (!is_file($file)) { WP_CLI::error('Reviewed CC BY-SA asset missing.'); }
    $temporary=wp_tempnam('plum-rice-water-50g.webp');copy($file,$temporary);
    $id=media_handle_sideload(['name'=>'glowwise-plum-rice-water-50g.webp','tmp_name'=>$temporary],$post->ID,'Plum 2% Rice Water SPF 50 PA++++ sunscreen outer carton, 50 g');
    if (is_wp_error($id)) { @unlink($temporary);WP_CLI::error($id->get_error_message()); }
    update_post_meta($id,'_gw_licensed_source',$sourceKey);
}
$record=['attachmentId'=>$id,'source'=>'https://world.openbeautyfacts.org/cgi/product_image.pl?code=8904430201070&id=front_en','licenseUrl'=>'https://creativecommons.org/licenses/by-sa/3.0/','license'=>'CC BY-SA 3.0 · resized','credit'=>'Photo: abhi127 / Open Beauty Facts','alt'=>'Plum Rice Water & Niacinamide 2% Hybrid Sunscreen SPF 50 PA++++ outer carton, 50 g, held in a shop','checked'=>'2026-10-10'];
$records=is_array($existing)?$existing:[];$records['50 g']=$record;$valid=gw_validate_images($records,$product);if (is_wp_error($valid)) { WP_CLI::error($valid->get_error_message()); }
update_post_meta($id,'_wp_attachment_image_alt',$record['alt']);update_post_meta($post->ID,'_gw_variant_images',$valid);
gw_visual_caption($record);
WP_CLI::success(wp_json_encode(['product'=>$product['slug'],'variant'=>'50 g','nativeAttachment'=>true,'publishedImageVariants'=>array_keys(gw_product($post->ID)['imageAssets']),'otherVariantPhotos'=>false]));
