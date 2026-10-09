<?php
if (!defined('ABSPATH')) { exit; }
/** Repeatable imported records skip later WordPress edits unless explicitly forced. */
function gw_content_signature($id) {
    $p=get_post($id);return hash('sha256',wp_json_encode([$p->post_title,$p->post_content,$p->post_excerpt,get_post_meta($id,'_gw_data',true),get_post_meta($id,'_yoast_wpseo_metadesc',true),get_post_meta($id,'_yoast_wpseo_title',true),get_post_meta($id,'_gw_sources',true),get_post_meta($id,'_gw_checked',true),get_post_meta($id,'_gw_product_slugs',true),wp_get_post_terms($id,'gw_category',['fields'=>'slugs']),wp_get_post_terms($id,'gw_type',['fields'=>'slugs'])]));
}
WP_CLI::add_command('glowwise import',function($args,$assoc) {
    $path=$args[0]??'';if (!$path || !is_file($path)) { WP_CLI::error('Provide the reviewed content JSON path.'); }
    $input=json_decode(file_get_contents($path),true,512,JSON_THROW_ON_ERROR);$count=['created'=>0,'updated'=>0,'unchanged'=>0,'editedSkipped'=>0];$force=isset($assoc['force']);
    foreach (gw_categories() as $slug=>$name) { if (!term_exists($slug,'gw_category')) { wp_insert_term($name,'gw_category',['slug'=>$slug,'description'=>$input['categories'][$slug]['description']??'']); } }
    foreach (gw_types() as $slug=>$name) { if (!term_exists($slug,'gw_type')) { wp_insert_term($name,'gw_type',['slug'=>$slug]); } }
    foreach ($input['records'] as $record) {
        if (!in_array($record['kind'],['page','post','gw_product'],true) || !preg_match('/^[a-z0-9-]+$/',$record['slug'])) { WP_CLI::error('Invalid source identity.'); }
        $existing=get_posts(['post_type'=>$record['kind'],'post_status'=>'any','name'=>$record['slug'],'numberposts'=>1]);$id=$existing?$existing[0]->ID:0;
        $oldSignature=$id?get_post_meta($id,'_gw_import_signature',true):'';
        if ($id && (!$oldSignature || $oldSignature!==gw_content_signature($id)) && !$force) { $count['editedSkipped']++;continue; }
        $sourceHash=hash('sha256',wp_json_encode($record));if ($id && get_post_meta($id,'_gw_source_hash',true)===$sourceHash && !$force) { $count['unchanged']++;continue; }
        $data=null;if ($record['kind']==='gw_product') { $data=gw_validate_product($record['data']);if (is_wp_error($data)) { WP_CLI::error($record['slug'].': '.$data->get_error_message()); } }
        $id=wp_insert_post(['ID'=>$id,'post_type'=>$record['kind'],'post_status'=>'draft','post_name'=>$record['slug'],'post_title'=>$record['title'],'post_excerpt'=>$record['excerpt']??'','post_content'=>wp_kses_post($record['html']??''),'comment_status'=>'closed','ping_status'=>'closed'],true);
        if (is_wp_error($id)) { WP_CLI::error($id->get_error_message()); }
        if ($data) { update_post_meta($id,'_gw_data',$data);wp_set_object_terms($id,$data['category'],'gw_category');wp_set_object_terms($id,$data['type'],'gw_type'); }
        elseif (!empty($record['category'])) { wp_set_object_terms($id,$record['category'],'gw_category'); }
        update_post_meta($id,'_yoast_wpseo_title',$record['seoTitle']??$record['title'].' | Glowwise');update_post_meta($id,'_yoast_wpseo_metadesc',$record['description']??$record['excerpt']??'');
        update_post_meta($id,'_gw_sources',$record['sources']??[]);update_post_meta($id,'_gw_checked',$record['checked']??gmdate('Y-m-d'));
        if (!empty($record['guide_products'])) { update_post_meta($id,'_gw_product_slugs',$record['guide_products']); }
        wp_update_post(['ID'=>$id,'post_status'=>'publish']);update_post_meta($id,'_gw_source_hash',$sourceHash);update_post_meta($id,'_gw_import_signature',gw_content_signature($id));$count[$existing?'updated':'created']++;
    }
    $home=get_page_by_path('home');$guides=get_page_by_path('guides');if ($home && $guides) { update_option('show_on_front','page');update_option('page_on_front',$home->ID);update_option('page_for_posts',$guides->ID); }
    update_option('permalink_structure','/guides/%postname%/');if (isset($assoc['development'])) { update_option('blog_public',0); }update_option('blogname','Glowwise');update_option('blogdescription','Find your kind of good.');flush_rewrite_rules();
    WP_CLI::success(wp_json_encode($count));
});
WP_CLI::add_command('glowwise export',function($args) {
    $categories=[];foreach (gw_categories() as $slug=>$name) { $term=get_term_by('slug',$slug,'gw_category');$categories[$slug]=['name'=>$name,'description'=>$term?$term->description:'']; }
    $out=['exportedUTC'=>gmdate('c'),'categories'=>$categories,'records'=>[]];
    foreach (get_posts(['post_type'=>['gw_product','page','post'],'post_status'=>'publish','numberposts'=>200]) as $p) {
        $r=['kind'=>$p->post_type,'slug'=>$p->post_name,'title'=>$p->post_title,'excerpt'=>$p->post_excerpt,'html'=>$p->post_content,'seoTitle'=>get_post_meta($p->ID,'_yoast_wpseo_title',true),'description'=>get_post_meta($p->ID,'_yoast_wpseo_metadesc',true),'sources'=>get_post_meta($p->ID,'_gw_sources',true),'checked'=>get_post_meta($p->ID,'_gw_checked',true)];
        if ($p->post_type==='gw_product') { $r['data']=get_post_meta($p->ID,'_gw_data',true); }$terms=wp_get_post_terms($p->ID,'gw_category',['fields'=>'slugs']);$r['category']=$terms[0]??'';$r['guide_products']=get_post_meta($p->ID,'_gw_product_slugs',true);$out['records'][]=$r;
    }
    WP_CLI::line(wp_json_encode($out,JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES));
});
