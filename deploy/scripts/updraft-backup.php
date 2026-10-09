<?php
/** Operator-only full local backup. Raw UpdraftPlus logs stay private. */
if (!defined('WP_CLI') || !WP_CLI) { exit; }
global $updraftplus;
if (!is_object($updraftplus) || get_option('updraft_dir')!=='/srv/glowwise/updraft-private') { WP_CLI::error('Configure the private UpdraftPlus directory first.'); }
$updraftplus->backup_all(['nocloud'=>true,'label'=>'Glowwise private recovery']);
WP_CLI::success('Full local UpdraftPlus backup requested; inspect completion before relying on it.');
