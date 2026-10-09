<?php
/** Run through WP-CLI eval-file on the VM; never outputs private accounts/options. */
if (!defined('ABSPATH') || !defined('WP_CLI')) { exit; }
if (class_exists('WPSEO_Options')) {
    WPSEO_Options::set('company_or_person','company');WPSEO_Options::set('company_name','Imagine Utopia');WPSEO_Options::set('website_name','Glowwise');WPSEO_Options::set('website_alternate_name','');
    WPSEO_Options::set('disable-author',true);WPSEO_Options::set('disable-date',true);WPSEO_Options::set('noindex-author-wpseo',true);WPSEO_Options::set('noindex-archive-wpseo',true);
}
update_option('blog_public',0);update_option('default_comment_status','closed');update_option('default_ping_status','closed');update_option('comments_notify',0);update_option('moderation_notify',0);update_option('users_can_register',0);
foreach (get_users(['role'=>'administrator']) as $u) { wp_update_user(['ID'=>$u->ID,'display_name'=>'Glowwise Editorial','nickname'=>'Glowwise Editorial']); }
foreach (['hello-world'=>'post','sample-page'=>'page','privacy-policy'=>'page'] as $slug=>$kind) { $p=get_page_by_path($slug,OBJECT,$kind);if ($p && !get_post_meta($p->ID,'_gw_import_signature',true)) { wp_update_post(['ID'=>$p->ID,'post_status'=>'draft']); } }
if (function_exists('wp_cache_clear_cache')) { wp_cache_clear_cache(); }
// Development is protected; page cache remains disabled until launch review.
update_option('updraft_interval','manual');update_option('updraft_interval_database','manual');update_option('updraft_service',[]);
flush_rewrite_rules();WP_CLI::success('Publisher metadata, protected development, discussion and manual private backup policy configured.');
