<?php
if (!defined('ABSPATH')) { exit; }
function gw_archive_metadata() {
    if (is_post_type_archive('gw_product')) { return ['Explore grooming products in India | Glowwise','Search researched grooming products by category, type, INR budget and source-verified attributes. Compare exact packs, sources and limitations.']; }
    if (is_home()) { return ['Grooming guides for everyday decisions | Glowwise','Original guides to skincare, haircare, bodycare, fragrance, beard care and grooming tools. Clear sources, checked prices and practical limitations.']; }
    if (is_tax('gw_category')) { $term=get_queried_object();return [$term->name.' products and guides | Glowwise',wp_strip_all_tags($term->description)]; }
    return null;
}
add_filter('wpseo_title',function($title) { $meta=gw_archive_metadata();$page=max(1,(int)get_query_var('paged'));return $meta?$meta[0].($page>1?' · Page '.$page:''):$title; });
add_filter('wpseo_breadcrumb_links',function($links) {
    if (is_singular('gw_product')) { $product=gw_product(get_queried_object_id());if ($product) { return [['url'=>home_url('/'),'text'=>'Home'],['url'=>home_url('/categories/'),'text'=>'Categories'],['url'=>home_url('/categories/'.$product['category'].'/'),'text'=>gw_categories()[$product['category']]],['text'=>$product['name']]]; } }
    return $links;
});
function gw_archive_description($description) { $meta=gw_archive_metadata();$page=max(1,(int)get_query_var('paged'));return $meta?$meta[1].($page>1?' Browse page '.$page.' of the edit.':''):$description; }
add_filter('wpseo_metadesc','gw_archive_description');
add_filter('wpseo_opengraph_desc','gw_archive_description');
add_filter('wpseo_opengraph_title',function($title) { $meta=gw_archive_metadata();$page=max(1,(int)get_query_var('paged'));return $meta?$meta[0].($page>1?' · Page '.$page:''):$title; });
function gw_utility_noindex() {
    return is_search() || is_author() || is_date() || is_tag() || is_page(['finder','compare','saved','privacy','terms','cookies-and-storage','sitemap']) || (is_post_type_archive('gw_product') && count(array_intersect(array_keys($_GET),['q','category','type','max-price','fragrance-free','finish','sort']))>0);
}
add_filter('wpseo_robots_array',function($robots) { if (gw_utility_noindex() || !get_option('blog_public')) { $robots['index']='noindex'; }return $robots; });
add_filter('wp_robots',function($robots) { if (gw_utility_noindex() || !get_option('blog_public')) { $robots['noindex']=true;unset($robots['index']); }return $robots; });
add_filter('wpseo_canonical',function($url) {
    if (is_post_type_archive('gw_product')) { $url=get_post_type_archive_link('gw_product');$page=max(1,(int)get_query_var('paged'));if ($page>1) { $url=trailingslashit($url).'page/'.$page.'/'; }if (gw_utility_noindex()) { $allowed=array_intersect_key(wp_unslash($_GET),array_flip(['q','category','type','max-price','fragrance-free','finish','sort']));ksort($allowed);$url=add_query_arg(array_map('sanitize_text_field',$allowed),$url); } }
    if (is_home()) { $url=home_url('/guides/');$page=max(1,(int)get_query_var('paged'));if ($page>1) { $url.='page/'.$page.'/'; } }
    return $url;
});
add_filter('wpseo_schema_organization',function($data) { $data['name']='Imagine Utopia';$data['founder']=[['@type'=>'Person','name'=>'Aakash Kumar'],['@type'=>'Person','name'=>'Disa Bandhu']];unset($data['address'],$data['sameAs'],$data['email'],$data['telephone']);return $data; });
add_filter('wpseo_schema_article',function($data) { $data['author']=['@type'=>'Organization','name'=>'Glowwise Editorial','url'=>home_url('/how-we-select/')];return $data; });
add_filter('wpseo_schema_graph',function($graph,$context) {
    $organizationID=home_url('/').'#organization';$hasOrganization=false;
    foreach ($graph as &$node) {
        if (($node['@type']??'')==='Organization') { $hasOrganization=true;$organizationID=$node['@id']; }
        if (($node['@type']??'')==='WebSite') { $node['publisher']=['@id'=>$organizationID]; }
        if (is_singular('post') && ($node['@type']??'')==='WebPage') { $node['author']=['@type'=>'Organization','name'=>'Glowwise Editorial','url'=>home_url('/how-we-select/')]; }
    }unset($node);
    if (!$hasOrganization) { $graph[]=['@type'=>'Organization','@id'=>$organizationID,'name'=>'Imagine Utopia','url'=>home_url('/about/'),'founder'=>[['@type'=>'Person','name'=>'Aakash Kumar'],['@type'=>'Person','name'=>'Disa Bandhu']]]; }
    // An editorial organization byline must not leave a personal account node behind.
    if (is_singular('post')) { $graph=array_values(array_filter($graph,fn($node)=>($node['@type']??'')!=='Person')); }
    if (is_singular('gw_product')) { $p=gw_product(get_queried_object_id());if ($p) { $graph[]=['@type'=>'Product','@id'=>$p['url'].'#product','url'=>$p['url'],'name'=>$p['name'],'description'=>$p['summary'],'brand'=>['@type'=>'Brand','name'=>$p['brand']],'category'=>gw_types()[$p['type']]]; } }
    return $graph;
},10,2);
add_filter('wpseo_sitemap_exclude_post_type',fn($excluded,$type)=>$type==='gw_message'?true:$excluded,10,2);
add_filter('wpseo_sitemap_exclude_taxonomy',fn($excluded,$tax)=>in_array($tax,['gw_type','category','post_tag'],true)?true:$excluded,10,2);
add_filter('wpseo_exclude_from_sitemap_by_post_ids',function($ids) { return array_merge($ids,get_posts(['post_type'=>'page','name'=>'','post_name__in'=>['finder','compare','saved','privacy','terms','cookies-and-storage','sitemap'],'fields'=>'ids','numberposts'=>30])); });
add_filter('wpseo_xml_sitemap_post_url',function($url,$post) { if ($post->post_type==='gw_message' || in_array($post->post_name,['finder','compare','saved','privacy','terms','cookies-and-storage','sitemap'],true)) { return false; }return $url; },10,2);
add_filter('wpseo_sitemap_exclude_author','__return_true');
add_filter('rest_endpoints',function($routes) { if (!current_user_can('list_users')) { foreach (array_keys($routes) as $route) { if (str_starts_with($route,'/wp/v2/users')) { unset($routes[$route]); } } }return $routes; });
remove_action('wp_head','print_emoji_detection_script',7);remove_action('wp_print_styles','print_emoji_styles');
add_action('template_redirect',function () { if (is_author() || is_date() || is_tag() || is_category()) { wp_safe_redirect(home_url('/guides/'),301);exit; } });
add_action('pre_get_posts',function($q) { if (!is_admin() && $q->is_main_query()) {
    if ($q->is_post_type_archive('gw_product')) { $q->set('posts_per_page',12);$q->set('orderby','title');$q->set('order','ASC'); }
    if ($q->is_home()) { $q->set('posts_per_page',6); }
    if ($q->is_tax('gw_category')) { $q->set('post_type',['post','gw_product']);$q->set('posts_per_page',24); }
} });
