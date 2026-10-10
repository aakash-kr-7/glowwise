<?php
/** Operator-only, repeatable exact-variant photo import. Images are excluded from Git. */
if (!defined('WP_CLI') || !WP_CLI) { exit; }
$manifest='/srv/glowwise/content/demo-media-manifest.json';
$records=json_decode(file_get_contents($manifest),true);
if (!is_array($records)) { WP_CLI::error('Reviewed manifest required.'); }
require_once ABSPATH.'wp-admin/includes/file.php';require_once ABSPATH.'wp-admin/includes/media.php';require_once ABSPATH.'wp-admin/includes/image.php';
$count=['imported'=>0,'preserved'=>0,'families'=>[]];
foreach ($records as $r) {
    if (empty($r['file']) || !preg_match('/^[a-zA-Z0-9-]+\.webp$/',$r['file'])) { WP_CLI::error('Invalid photo filename.'); }
    $post=get_page_by_path($r['slug'],OBJECT,'gw_product');$product=$post?gw_product($post->ID):null;
    if (!$product || !in_array($r['variant'],array_column($product['variants'],'label'),true)) { WP_CLI::error('Exact product/variant missing: '.$r['slug']); }
    $existing=get_post_meta($post->ID,'_gw_variant_images',true);$existing=is_array($existing)?$existing:[];
    // Preserve licensed photographs and administrative edits rather than replace them.
    if (isset($existing[$r['variant']])) { $count['preserved']++;continue; }
    $file='/srv/glowwise/content/demo-media/'.$r['file'];
    if (!is_file($file) || hash_file('sha256',$file)!==$r['sha256']) { WP_CLI::error('Reviewed photo hash mismatch: '.$r['file']); }
    $key='demo-2026-10-10-'.$r['slug'].'-'.$r['variant'].'-'.$r['sha256'];
    $ids=get_posts(['post_type'=>'attachment','post_status'=>'inherit','numberposts'=>1,'fields'=>'ids','meta_key'=>'_gw_demo_source','meta_value'=>$key]);
    if ($ids) { $id=$ids[0]; }
    else {
        $temporary=wp_tempnam($r['file']);copy($file,$temporary);
        $id=media_handle_sideload(['name'=>$r['file'],'tmp_name'=>$temporary],$post->ID,$r['alt']);
        if (is_wp_error($id)) { @unlink($temporary);WP_CLI::error($id->get_error_message()); }
        update_post_meta($id,'_gw_demo_source',$key);
        update_post_meta($id,'_wp_attachment_image_alt',$r['alt']);
        wp_update_post(['ID'=>$id,'post_excerpt'=>esc_html($r['credit']).' · <a href="'.esc_url($r['source']).'">Photo source</a> · '.esc_html($r['rights'])]);
    }
    $record=array_intersect_key($r,array_flip(['source','licenseUrl','license','credit','alt','checked']));$record['attachmentId']=$id;
    $existing[$r['variant']]=$record;$clean=gw_validate_images($existing,$product);
    if (is_wp_error($clean)) { WP_CLI::error($clean->get_error_message()); }
    update_post_meta($post->ID,'_gw_variant_images',$clean);$count['imported']++;$count['families'][$r['slug']]=true;
}
$count['families']=count($count['families']);WP_CLI::success(wp_json_encode($count));
