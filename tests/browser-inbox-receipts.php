<?php
/** Verify and remove only two explicitly disposable browser acceptance receipts. */
if (!defined('WP_CLI') || !WP_CLI) { exit; }
$expected=['DC7E1703C870'=>'STAGE4 DISPOSABLE CONTACT TEST','8D05934361FC'=>'STAGE4 DISPOSABLE CORRECTION TEST'];
$checks=[];
foreach ($expected as $receipt=>$subject) {
    $found=[];
    foreach (get_posts(['post_type'=>'gw_message','post_status'=>'private','numberposts'=>200]) as $p) {
        $m=get_post_meta($p->ID,'_gw_message',true);
        if (($m['receipt']??'')===$receipt) { $found[]=[$p,$m]; }
    }
    if (count($found)!==1) { throw new RuntimeException('Expected one disposable browser receipt'); }
    [$p,$m]=$found[0];
    if ($m['subject']!==$subject || $m['email']!=='acceptance@example.invalid' || $m['name']!=='Glowwise acceptance test') { throw new RuntimeException('Refuse to remove a non-test message'); }
    wp_set_current_user(0);
    if (current_user_can('read_post',$p->ID) || current_user_can('manage_options')) { throw new RuntimeException('Anonymous private access'); }
    $public=get_posts(['s'=>$receipt,'post_status'=>'publish']);
    if ($public) { throw new RuntimeException('Private receipt in public search'); }
    $checks[]=['kind'=>$m['kind'],'savedInPrivateInbox'=>true,'anonymousReadDenied'=>true,'publicSearchAbsent'=>true,'retentionExpiresAfter90Days'=>abs($m['expires']-(strtotime($m['received'])+90*DAY_IN_SECONDS))<3];
    wp_delete_post($p->ID,true);
    if (get_post($p->ID)) { throw new RuntimeException('Disposable cleanup failed'); }
}
WP_CLI::line(wp_json_encode(['capturedUTC'=>gmdate('c'),'purpose'=>'Actual browser contact/correction receipts independently verified in private WordPress inbox; only labelled test records removed','checks'=>$checks,'disposableRecordsRemoved'=>2,'rawContactDataExcluded'=>true],JSON_PRETTY_PRINT));
