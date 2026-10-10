<?php
if (!defined('WP_CLI') || !WP_CLI) { exit; }
$GLOBALS['gw_media_checks']=[];function media_check($name,$pass) { $GLOBALS['gw_media_checks'][]=['test'=>$name,'pass'=>(bool)$pass];if (!$pass) { throw new RuntimeException($name); } }
$post=get_page_by_path('plum-rice-water-spf-50',OBJECT,'gw_product');$p=gw_product($post->ID);$records=get_post_meta($post->ID,'_gw_variant_images',true);
media_check('Licensed photo only matches 50 g; default 80 g has no photo',isset($p['imageAssets']['50 g'])&&!isset($p['imageAssets']['80 g'])&&!isset($p['imageAssets']['30 g']));
media_check('Photo has native responsive dimensions and attribution',$p['imageAssets']['50 g']['width']>0&&$p['imageAssets']['50 g']['height']>0&&str_contains($p['imageAssets']['50 g']['credit'],'abhi127')&&str_contains($p['imageAssets']['50 g']['license'],'CC BY-SA'));
$wrong=['not a variant'=>$records['50 g']];media_check('Wrong pack rejected',is_wp_error(gw_validate_images($wrong,$p)));
$bad=$records;$bad['50 g']['source']='javascript:alert(1)';media_check('Unsafe source rejected',is_wp_error(gw_validate_images($bad,$p)));
$bad=$records;$bad['50 g']['checked']='2099-01-01';media_check('Future rights check rejected',is_wp_error(gw_validate_images($bad,$p)));
$bad=$records;$bad['50 g']['attachmentId']=$post->ID;media_check('Product post cannot impersonate photo attachment',is_wp_error(gw_validate_images($bad,$p)));
media_check('Empty image record is an honest valid fallback',gw_validate_images([],$p)===[]);
$old=$_POST;wp_set_current_user(0);$_POST=['gw_images_nonce'=>'invalid','gw_variant_images'=>'{}'];do_action('save_post_gw_product',$post->ID,get_post($post->ID),true);$_POST=$old;
media_check('Anonymous/invalid nonce cannot replace image metadata',get_post_meta($post->ID,'_gw_variant_images',true)===$records);
media_check('Catalogue counts and exact selected pack are unchanged',count(gw_catalog())===40&&gw_variant($p)['label']==='80 g');
WP_CLI::line(wp_json_encode(['capturedUTC'=>gmdate('c'),'purpose'=>'Non-destructive native photo metadata/security integration checks','checks'=>$GLOBALS['gw_media_checks']],JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES));
