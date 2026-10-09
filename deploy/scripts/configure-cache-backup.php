<?php
/** Actual installed plugin configuration, executed through WP-CLI only. */
if (!defined('WP_CLI') || !WP_CLI) { exit; }
if (!function_exists('wp_cache_setting')) { WP_CLI::error('WP Super Cache must be active.'); }
foreach (['cache_enabled'=>false,'super_cache_enabled'=>false,'wp_cache_not_logged_in'=>1,'cache_compression'=>1,'cache_rejected_uri'=>['wp-.*\.php','index\.php','/wp-json/','/contact/','/corrections/','/finder/','/compare/','/saved/','\?'],'wpsc_rejected_cookies'=>['wordpress_logged_in_','wp-postpass_','gw_form_guard']] as $key=>$value) {
    if (!wp_cache_setting($key,$value)) { WP_CLI::error('Could not persist safe cache setting: '.$key); }
}
if (function_exists('wp_cache_clear_cache')) { wp_cache_clear_cache(); }
update_option('updraft_dir','/srv/glowwise/updraft-private');
update_option('updraft_interval','manual');update_option('updraft_interval_database','manual');update_option('updraft_service',[]);
foreach (['plugins','themes','uploads','others'] as $entity) { update_option('updraft_include_'.$entity,1); }
WP_CLI::success('Development page caching disabled; dynamic/query/auth exclusions persisted. UpdraftPlus uses a private mounted directory, manual local-only backups.');
