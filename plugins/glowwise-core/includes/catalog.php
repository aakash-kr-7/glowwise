<?php
if (!defined('ABSPATH')) { exit; }
function gw_product($id) {
    $p=get_post($id);if (!$p || $p->post_type!=='gw_product' || $p->post_status!=='publish') { return null; }
    $d=get_post_meta($p->ID,'_gw_data',true);if (is_wp_error(gw_validate_product($d))) { return null; }
    return ['id'=>$p->ID,'slug'=>$p->post_name,'name'=>html_entity_decode(get_the_title($p),ENT_QUOTES|ENT_HTML5,'UTF-8'),'url'=>get_permalink($p),'imageAssets'=>gw_product_images($p->ID,$d),'imageRights'=>'Variant-specific photographs with source and rights status; brand photographs are used for the owner-requested demo without an independently verified reuse licence. Missing variants use a disclosed fallback.']+$d;
}
function gw_catalog() {
    $ids=get_posts(['post_type'=>'gw_product','post_status'=>'publish','numberposts'=>200,'fields'=>'ids','orderby'=>'title','order'=>'ASC','suppress_filters'=>false]);
    return array_values(array_filter(array_map('gw_product',$ids)));
}
function gw_variant($product,$label='') { foreach ($product['variants'] as $v) { if ($v['label']===$label) { return $v; } }return $product['variants'][0]; }
function gw_validate_filters($params) {
    if (!is_array($params)) { return new WP_Error('invalid_filter','Filters must be an object.',['status'=>400]); }
    $allowed=['q','category','type','max-price','fragrance-free','finish','sort','page','per-page'];
    foreach ($params as $key=>$value) { if (!in_array($key,$allowed,true) || !is_scalar($value)) { return new WP_Error('invalid_filter','Unsupported or malformed filter.',['status'=>400]); } }
    $f=[];foreach (['q','category','type','fragrance-free','finish','sort'] as $k) { $f[$k]=sanitize_text_field((string)($params[$k]??'')); }
    if (strlen($f['q'])>100 || ($f['category'] && !isset(gw_categories()[$f['category']])) || ($f['type'] && !isset(gw_types()[$f['type']])) || !in_array($f['fragrance-free'],['','yes'],true) || !in_array($f['finish'],['','matte','natural','dewy'],true) || !in_array($f['sort'],['','name','price-asc','price-desc'],true)) { return new WP_Error('invalid_filter','Choose valid published filters.',['status'=>400]); }
    foreach (['max-price'=>100000,'page'=>100,'per-page'=>24] as $k=>$max) {
        $v=$params[$k]??($k==='page'?1:($k==='per-page'?12:0));if (!is_numeric($v) || (float)$v<0 || (float)$v>$max || ($k!=='max-price' && ((int)$v<1 || (float)$v!==(float)(int)$v))) { return new WP_Error('invalid_filter','Invalid '.$k.'.',['status'=>400]); }$f[$k]=$k==='max-price'?(float)$v:(int)$v;
    }
    return $f;
}
function gw_match_product($p,$f) {
    if ($f['category'] && $p['category']!==$f['category'] || $f['type'] && $p['type']!==$f['type']) { return null; }
    if ($f['q'] && stripos($p['name'].' '.$p['brand'].' '.$p['summary'],$f['q'])===false) { return null; }
    $eligible=array_values(array_filter($p['variants'],fn($v)=>!$f['max-price'] || $v['price']<=$f['max-price']));if (!$eligible) { return null; }
    if ($f['fragrance-free']==='yes' && ($p['attributes']['fragrance-free']??'unknown')!=='yes') { return null; }
    if ($f['finish'] && ($p['attributes']['finish']??'unknown')!==$f['finish']) { return null; }
    $p['selectedVariant']=$eligible[0];$reasons=['Published, source-checked '.$p['type'].' record'];
    if ($f['max-price']) { $reasons[]='Checked '.$eligible[0]['label'].' price â‚¹'.number_format($eligible[0]['price']).' fits your â‚¹'.number_format($f['max-price']).' item budget'; }
    if ($f['fragrance-free']) { $reasons[]='The source labels this formulation fragrance free'; }
    if ($f['finish']) { $reasons[]='Source-described '.$f['finish'].' finish'; }
    $p['matchReasons']=$reasons;return $p;
}
function gw_filter_catalog($filters) {
    $matches=[];foreach (gw_catalog() as $p) { $m=gw_match_product($p,$filters);if ($m) { $matches[]=$m; } }
    if (in_array($filters['sort'],['price-asc','price-desc'],true)) { usort($matches,fn($a,$b)=>($a['selectedVariant']['price']<=>$b['selectedVariant']['price'])*($filters['sort']==='price-desc'?-1:1)); }
    $total=count($matches);$pages=max(1,(int)ceil($total/$filters['per-page']));
    if ($filters['page']>$pages) { return new WP_Error('missing_page','This catalog page does not exist.',['status'=>404]); }
    return ['products'=>array_slice($matches,($filters['page']-1)*$filters['per-page'],$filters['per-page']),'total'=>$total,'pages'=>$pages,'page'=>$filters['page']];
}
function gw_comparison($items) {
    if (!is_array($items) || count($items)<1 || count($items)>3) { return new WP_Error('invalid_count','Choose up to three products.',['status'=>400]); }
    $products=[];$seen=[];$type=null;
    foreach ($items as $item) {
        $rawID=is_array($item)?($item['id']??null):$item;
        if ((!is_int($rawID) && !(is_string($rawID) && ctype_digit($rawID) && strlen($rawID)<=10)) || (int)$rawID<1) { return new WP_Error('invalid_product','Choose a valid published product reference.',['status'=>400]); }
        $id=(int)$rawID;$p=gw_product($id);
        if (!$p) { return new WP_Error('missing_product','A selected product is no longer published. Remove it and choose another.',['status'=>404]); }
        if (isset($seen[$id])) { return new WP_Error('duplicate_product','A product can appear only once.',['status'=>400]); }
        if ($type && $type!==$p['type']) { return new WP_Error('incompatible_type','Compare products of the same type. A '.$p['type'].' cannot be compared with a '.$type.'.',['status'=>422]); }
        $label=is_array($item)?($item['variant']??''):'';if (!is_string($label) || ($label && !in_array($label,array_column($p['variants'],'label'),true))) { return new WP_Error('missing_variant','A selected variant is no longer available in this record. Remove it and choose a current variant.',['status'=>400]); }
        $type=$p['type'];$seen[$id]=true;$p['selectedVariant']=gw_variant($p,$label);$products[]=$p;
    }
    return ['type'=>$type,'products'=>$products];
}
add_action('rest_api_init',function () {
    register_rest_route('glowwise/v1','/products',['methods'=>'GET','permission_callback'=>'__return_true','callback'=>function($r) { $f=gw_validate_filters($r->get_query_params());return is_wp_error($f)?$f:gw_filter_catalog($f); }]);
    register_rest_route('glowwise/v1','/products/(?P<id>\d+)',['methods'=>'GET','permission_callback'=>'__return_true','callback'=>function($r) { $p=gw_product($r['id']);return $p?:new WP_Error('missing_product','Product not found.',['status'=>404]); }]);
    register_rest_route('glowwise/v1','/finder',['methods'=>'POST','permission_callback'=>'__return_true','callback'=>function($r) { $f=gw_validate_filters($r->get_json_params()?:[]);return is_wp_error($f)?$f:gw_filter_catalog($f); }]);
    register_rest_route('glowwise/v1','/compare',['methods'=>'POST','permission_callback'=>'__return_true','callback'=>fn($r)=>gw_comparison($r->get_json_params()['items']??[])]);
});
add_filter('rest_post_dispatch',function($result,$server,$request) { if (str_starts_with($request->get_route(),'/glowwise/v1')) { $result=rest_ensure_response($result);$result->header('Cache-Control','private, no-store');$result->header('X-Robots-Tag','noindex'); }return $result; },10,3);
