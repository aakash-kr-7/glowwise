<?php
/**
 * Plugin Name: Glowwise Core
 * Description: Durable researched catalog, matching, editing and private contact infrastructure.
 * Version: 1.0.0
 * Author: Imagine Utopia
 * License: GPL-2.0-or-later
 */
if (!defined('ABSPATH')) { exit; }
define('GW_CORE_VERSION', '1.0.0');
define('GW_CORE_DIR', __DIR__);
require_once __DIR__ . '/includes/model.php';
require_once __DIR__ . '/includes/media.php';
require_once __DIR__ . '/includes/catalog.php';
require_once __DIR__ . '/includes/contact.php';
require_once __DIR__ . '/includes/editorial.php';
require_once __DIR__ . '/includes/seo.php';
register_activation_hook(__FILE__, function () {
    gw_register_model();
    if (!wp_next_scheduled('gw_retention_daily')) { wp_schedule_event(time() + 3600, 'daily', 'gw_retention_daily'); }
    flush_rewrite_rules();
});
register_deactivation_hook(__FILE__, function () { wp_clear_scheduled_hook('gw_retention_daily'); flush_rewrite_rules(); });
if (defined('WP_CLI') && WP_CLI) { require_once __DIR__ . '/includes/import.php'; }
