<?php
/** VM-only disposable import fixture; never edits an existing owner record. */
if (!defined('WP_CLI') || !WP_CLI) { exit; }
$GLOBALS['gw_import_checks']=[];
function gw_assert_import($name,$pass) { $GLOBALS['gw_import_checks'][]=['test'=>$name,'pass'=>(bool)$pass];if (!$pass) { throw new RuntimeException($name); } }
$slug='gw-disposable-import-'.bin2hex(random_bytes(6));$path=tempnam(sys_get_temp_dir(),'gw-import-');$id=0;
$record=['kind'=>'page','slug'=>$slug,'title'=>'Disposable import fixture','html'=>'<p>Explicitly disposable original fixture.</p>'];
$command='glowwise import '.escapeshellarg($path);
try {
    file_put_contents($path,wp_json_encode(['categories'=>[],'records'=>[$record]]));
    $one=WP_CLI::runcommand($command,['return'=>'stdout','launch'=>false]);$p=get_page_by_path($slug);$id=$p->ID;
    gw_assert_import('First import creates one fixture',str_contains($one,'"created":1'));
    $two=WP_CLI::runcommand($command,['return'=>'stdout','launch'=>false]);
    gw_assert_import('Repeat import creates no duplicate',str_contains($two,'"unchanged":1') && count(get_posts(['post_type'=>'page','post_status'=>'any','name'=>$slug]))===1);
    wp_update_post(['ID'=>$id,'post_title'=>'Owner edited disposable fixture']);$record['title']='Changed source fixture';file_put_contents($path,wp_json_encode(['records'=>[$record]]));
    $three=WP_CLI::runcommand($command,['return'=>'stdout','launch'=>false]);
    gw_assert_import('Changed seed preserves later WordPress edit',str_contains($three,'"editedSkipped":1') && get_post($id)->post_title==='Owner edited disposable fixture');
    $export=json_decode(WP_CLI::runcommand('glowwise export',['return'=>'stdout','launch'=>false]),true,512,JSON_THROW_ON_ERROR);
    gw_assert_import('Export contains only published content kinds',!array_filter($export['records'],fn($r)=>!in_array($r['kind'],['page','post','gw_product'],true)));
    gw_assert_import('Export categories round-trip with descriptions',is_array($export['categories']['skincare']) && isset($export['categories']['skincare']['description']));
    gw_assert_import('Export excludes accounts/private message bodies',!isset($export['users']) && !array_filter($export['records'],fn($r)=>isset($r['email'])||isset($r['message'])));
    $original=$GLOBALS['wp_query'];$q=new WP_Query(['post_type'=>'gw_product','paged'=>2]);$q->is_post_type_archive=true;$GLOBALS['wp_query']=$q;
    gw_assert_import('Clean archive pagination self-canonical rule',apply_filters('wpseo_canonical','')===home_url('/explore/page/2/'));
    $_GET=['type'=>'sunscreen'];gw_assert_import('Filtered catalog noindex rule',gw_utility_noindex());$_GET=[];
    gw_assert_import('Development remains globally non-indexable',(int)get_option('blog_public')===0);
    $GLOBALS['wp_query']=$original;
} finally { if ($id) { wp_delete_post($id,true); }unlink($path); }
gw_assert_import('Disposable import fixture removed',get_page_by_path($slug)===null);
WP_CLI::line(wp_json_encode(['capturedUTC'=>gmdate('c'),'purpose'=>'Repeatable import, owner-edit preservation, portable export and canonical/noindex rules on actual WordPress; launch gate retained','checks'=>$GLOBALS['gw_import_checks']],JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES));
