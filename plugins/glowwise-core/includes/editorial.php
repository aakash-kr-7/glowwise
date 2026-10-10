<?php
if (!defined('ABSPATH')) { exit; }
function gw_editorial_author($id) {
    $saved=get_post_meta($id,'_gw_editorial_author',true);
    if (in_array($saved,['Aakash Kumar','Disa Bandhu'],true)) { return $saved; }
    $slug=get_post_field('post_name',$id);
    return in_array($slug,['shampoo-for-dry-frizzy-hair','beard-oil-benefits','trimmers-under-1500'],true)?'Aakash Kumar':'Disa Bandhu';
}
function gw_editorial_author_schema($id) {
    return ['@type'=>'Person','name'=>gw_editorial_author($id),'url'=>home_url('/about/'),'jobTitle'=>'Cofounder, Imagine Utopia'];
}
add_action('add_meta_boxes_post',function() { add_meta_box('gw_editorial_author','Glowwise editorial byline',function($post) {
    wp_nonce_field('gw_author_save','gw_author_nonce');
    echo '<p>Public editorial credit. This does not expose or change the WordPress login account.</p><label for="gw_editorial_author">Founder</label><select id="gw_editorial_author" name="gw_editorial_author">';
    foreach (['Aakash Kumar','Disa Bandhu'] as $name) { echo '<option '.selected(gw_editorial_author($post->ID),$name,false).'>'.esc_html($name).'</option>'; }
    echo '</select>';
}); });
add_action('save_post_post',function($id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE || wp_is_post_revision($id) || !isset($_POST['gw_author_nonce']) || !current_user_can('edit_post',$id) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['gw_author_nonce'])),'gw_author_save')) { return; }
    $name=sanitize_text_field(wp_unslash($_POST['gw_editorial_author']??''));
    if (in_array($name,['Aakash Kumar','Disa Bandhu'],true)) { update_post_meta($id,'_gw_editorial_author',$name); }
});
