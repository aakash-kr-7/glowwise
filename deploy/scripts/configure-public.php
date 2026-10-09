<?php
// Run through WP-CLI eval-file. This file handles public configuration only.
if (!defined('ABSPATH') || !defined('WP_CLI')) { exit; }
$config=json_decode(file_get_contents('/srv/glowwise/content/public-config.json'),true);
if (!is_array($config) || !preg_match('/^G-[A-Z0-9]+$/',$config['ga4MeasurementId']??'')) { WP_CLI::error('Invalid public measurement configuration.'); }
update_option('gw_ga4_measurement_id',$config['ga4MeasurementId']);
WP_CLI::success('Public analytics ID configured; consent remains required.');
