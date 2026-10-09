<?php
/** Temporary administrator-only browser fixture. Remove from mu-plugins after use. */
if (!defined('ABSPATH')) { exit; }
add_action('admin_menu',function () {
    add_management_page('Owned storage-denied fixture','Owned storage-denied fixture','manage_options','glowwise-storage-fixture',function () {
        if (!current_user_can('manage_options')) { wp_die('Access denied',403); }
        echo '<div class="wrap"><h1>Owned storage-denied acceptance fixture</h1><p>The iframe loads the real public product page with an opaque sandbox origin. Browser storage is denied. This fixture is temporary and administrator-only.</p><iframe title="Real Glowwise with browser storage denied" sandbox="allow-scripts allow-forms" src="'.esc_url(home_url('/products/minimalist-b12-oat-cleanser/')).'" style="width:390px;max-width:100%;height:900px;border:1px solid #123f3f"></iframe></div>';
    });
});
