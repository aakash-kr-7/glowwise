<?php
if (!defined('ABSPATH')) { exit; }
require_once __DIR__.'/visuals.php';
add_action('customize_register',function($customizer) {
    $customizer->add_section('glowwise_home',['title'=>'Glowwise homepage','priority'=>30]);
    foreach (['hero_kicker'=>['Hero kicker','A compass for everyday care'],'hero_heading'=>['Hero headline','Find your kind of good.'],'hero_intro'=>['Hero introduction','Grooming that fits your life. Thoughtfully researched products, clear comparisons and a little less guesswork.'],'manifesto_heading'=>['Editorial heading','The right choice starts with the right questions.'],'manifesto_intro'=>['Editorial introduction','What’s in it? Which size fits your budget? What can it actually do? We connect the facts to the things that matter to you.'],'finder_intro'=>['Finder introduction','Tell us what you’re looking for. Our finder narrows the catalog using clear rules—and shows you why each product made the list.']] as $key=>$field) {
        $customizer->add_setting('gw_'.$key,['default'=>$field[1],'sanitize_callback'=>'sanitize_text_field']);
        $customizer->add_control('gw_'.$key,['label'=>$field[0],'section'=>'glowwise_home','type'=>'textarea']);
    }
});
add_action('after_setup_theme',function() { add_theme_support('title-tag');add_theme_support('html5',['search-form','gallery','caption','style','script']);add_theme_support('responsive-embeds');add_theme_support('editor-styles');add_editor_style('assets/src/site.css'); });
function gw_asset($name) {
    static $manifest=null;if ($manifest===null) { $path=get_template_directory().'/assets/dist/manifest.json';$manifest=is_file($path)?json_decode(file_get_contents($path),true):[]; }
    $key='theme/glowwise/assets/src/'.$name;$file=$manifest[$key]??'theme/glowwise/assets/src/'.$name;
    return get_template_directory_uri().'/'.substr($file,strlen('theme/glowwise/'));
}
add_action('wp_enqueue_scripts',function() {
    wp_enqueue_style('glowwise',gw_asset('site.css'),[],'1.0.0');wp_enqueue_script('glowwise',gw_asset('site.js'),[], '1.0.0', ['strategy'=>'defer','in_footer'=>true]);
    wp_enqueue_style('glowwise-visuals',gw_asset('visuals.css'),['glowwise'],'1.1.0');
    wp_add_inline_script('glowwise','window.Glowwise='.wp_json_encode(['analyticsId'=>get_option('gw_ga4_measurement_id',''),'api'=>rest_url('glowwise/v1/'),'home'=>home_url('/'),'assets'=>get_template_directory_uri().'/assets/','categories'=>function_exists('gw_categories')?gw_categories():[],'types'=>function_exists('gw_types')?gw_types():[]],JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS|JSON_HEX_QUOT).';','before');
    if (is_front_page()) { wp_enqueue_script('glowwise-motion',gw_asset('motion.js'),[], '1.0.0',['strategy'=>'defer','in_footer'=>true]); }
});
add_filter('script_loader_tag',function($tag,$handle) { return in_array($handle,['glowwise','glowwise-motion'],true)?str_replace('<script ','<script type="module" ',$tag):$tag; },10,2);
add_filter('the_generator','__return_empty_string');
add_filter('wpseo_add_opengraph_images',function($images) {
    $images->add_image(['url'=>get_template_directory_uri().'/assets/brand/glowwise-social.png','width'=>1024,'height'=>1024,'type'=>'image/png','alt'=>'Glowwise grooming discovery']);
});
function gw_link($slug) { return home_url('/'.trim($slug,'/').'/'); }
function gw_price($price) { return '₹'.number_format((float)$price,((float)$price==(int)$price)?0:2); }
function gw_breadcrumbs() { if (is_front_page()) { return; }echo '<nav class="breadcrumbs" aria-label="Breadcrumb"><a href="'.esc_url(home_url('/')).'">Home</a><span aria-hidden="true">/</span>';
    if (is_singular('gw_product')) { $product=gw_product(get_queried_object_id());echo '<a href="'.esc_url(gw_link('categories')).'">Categories</a><span aria-hidden="true">/</span>';if ($product) { echo '<a href="'.esc_url(gw_link('categories/'.$product['category'])).'">'.esc_html(gw_categories()[$product['category']]).'</a><span aria-hidden="true">/</span>'; } }
    elseif (is_singular('post')) { echo '<a href="'.esc_url(gw_link('guides')).'">Guides</a><span aria-hidden="true">/</span>'; }
    elseif (is_tax('gw_category')) { echo '<a href="'.esc_url(gw_link('categories')).'">Categories</a><span aria-hidden="true">/</span>'; }
    $name=is_tax()?single_term_title('',false):(is_home()?'Guides':(is_post_type_archive('gw_product')?'Explore':(is_404()?'Page not found':get_the_title())));echo '<span aria-current="page">'.esc_html($name).'</span></nav>';
}
function gw_product_card($p) { $v=$p['selectedVariant']??gw_variant($p); ?>
<article class="product-card" data-product="<?php echo (int)$p['id']; ?>" data-type="<?php echo esc_attr($p['type']); ?>">
 <?php gw_product_media($p,$v); ?>
 <div class="card-content"><p class="eyebrow"><?php echo esc_html($p['brand'].' · '.gw_types()[$p['type']]); ?></p><h3><a href="<?php echo esc_url($p['url']); ?>"><?php echo esc_html($p['name']); ?></a></h3><p><?php echo esc_html($p['summary']); ?></p><p class="price"><?php echo esc_html(gw_price($v['price'])); ?> <span><?php echo esc_html($v['label']); ?></span></p><p class="fine"><?php echo esc_html($v['availability']); ?> · Checked <?php echo esc_html($p['checked']); ?></p>
 <div class="card-actions"><button class="small-button js-only" data-save="<?php echo (int)$p['id']; ?>" aria-pressed="false" aria-label="Save <?php echo esc_attr($p['name']); ?>">Save <span aria-hidden="true">＋</span></button><button class="small-button js-only" data-compare="<?php echo (int)$p['id']; ?>" data-variant="<?php echo esc_attr($v['label']); ?>" aria-label="Compare <?php echo esc_attr($p['name']); ?>">Compare <span aria-hidden="true">↔</span></button><a class="text-link" href="<?php echo esc_url($p['url']); ?>">Details <span aria-hidden="true">↗</span></a></div></div>
</article><?php }
function gw_guide_card($post) { $cats=wp_get_post_terms($post->ID,'gw_category');$c=$cats&&!is_wp_error($cats)?$cats[0]->slug:'skincare'; ?>
<article class="guide-card"><div class="editorial-cover editorial-<?php echo esc_attr($c); ?>" aria-hidden="true"><?php $note=gw_editorial_label($post->post_name); ?><span class="editorial-kicker"><?php echo esc_html($note[0]); ?></span><span class="editorial-title"><?php echo esc_html($note[1]); ?></span><?php echo gw_icon($c); ?></div><p class="eyebrow"><?php echo esc_html(gw_categories()[$c]??'Guide'); ?> · Research, made useful</p><h3><a href="<?php echo esc_url(get_permalink($post)); ?>"><?php echo esc_html(get_the_title($post)); ?></a></h3><p><?php echo esc_html(get_the_excerpt($post)); ?></p><a class="text-link" href="<?php echo esc_url(get_permalink($post)); ?>">Read the guide <span aria-hidden="true">↗</span></a></article><?php }
function gw_category_cards() { foreach (gw_categories() as $slug=>$name) { ?>
<a class="category-card" href="<?php echo esc_url(gw_link('categories/'.$slug)); ?>"><?php echo gw_icon($slug); ?><span class="category-name"><?php echo esc_html($name); ?><span aria-hidden="true">↗</span></span></a><?php } }
function gw_intro($kicker,$title,$text) { echo '<header class="page-intro"><p class="eyebrow">'.esc_html($kicker).'</p><h1>'.esc_html($title).'</h1><p class="lede">'.esc_html($text).'</p></header>'; }
function gw_filters($values=[],$finder=false) { ?>
<form class="filters" method="get" action="<?php echo esc_url(gw_link('explore')); ?>" <?php echo $finder?'id="finder-form"':'id="catalog-filters"'; ?>>
<?php if (!$finder) { ?><label class="search-label">Search products<input type="search" name="q" maxlength="100" placeholder="A brand, product or ingredient" value="<?php echo esc_attr($values['q']??''); ?>"></label><?php } ?>
<div class="filter-fields"><label>Category<select name="category"><option value="">All categories</option><?php foreach (gw_categories() as $k=>$v) { echo '<option value="'.esc_attr($k).'" '.selected($values['category']??'',$k,false).'>'.esc_html($v).'</option>'; } ?></select></label>
<label>Product type<select name="type"><option value="">Any type</option><?php foreach (gw_types() as $k=>$v) { echo '<option value="'.esc_attr($k).'" '.selected($values['type']??'',$k,false).'>'.esc_html($v).'</option>'; } ?></select></label>
<label>Item budget (INR)<input name="max-price" type="number" min="1" max="100000" step="1" placeholder="No limit" value="<?php echo esc_attr(!empty($values['max-price'])?$values['max-price']:''); ?>"></label>
<label>Sunscreen finish<select name="finish"><option value="">No preference</option><?php foreach (['matte','natural','dewy'] as $v) { echo '<option value="'.$v.'" '.selected($values['finish']??'',$v,false).'>'.ucfirst($v).'</option>'; } ?></select></label>
<label class="check-label"><input name="fragrance-free" type="checkbox" value="yes" <?php checked($values['fragrance-free']??'','yes'); ?>> Source-labeled fragrance free</label>
<?php if (!$finder) { ?><label>Sort<select name="sort"><option value="name">Name A–Z</option><option value="price-asc" <?php selected($values['sort']??'','price-asc'); ?>>Price: low to high</option><option value="price-desc" <?php selected($values['sort']??'','price-desc'); ?>>Price: high to low</option></select></label><?php } ?></div>
<div class="actions"><button class="button" type="submit"><?php echo $finder?'Show my matches':'Apply filters'; ?> <span aria-hidden="true">↗</span></button><a class="button secondary" href="<?php echo esc_url(gw_link('explore')); ?>">Clear all</a></div>
<p class="fine">Budgets use the identified pack or model, before delivery. Unknown attributes never pass a verified-attribute filter. Availability can change.</p></form><?php }
