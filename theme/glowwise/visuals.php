<?php
if (!defined('ABSPATH')) { exit; }
function gw_icon($category) {
    $paths=[
        'skincare'=>'<path d="M12 3s-6 6.5-6 11a6 6 0 0 0 12 0c0-4.5-6-11-6-11Z"/><path d="M9 14a3 3 0 0 0 3 3"/>',
        'haircare'=>'<path d="M5 4h14a2 2 0 0 1 2 2v2H3V6a2 2 0 0 1 2-2Z"/><path d="M3 8v10m3-10v10m3-10v10m3-10v10m3-10v10m3-10v10m3-10v10"/>',
        'bodycare'=>'<path d="M8 13V6a1.5 1.5 0 0 1 3 0v6-8a1.5 1.5 0 0 1 3 0v8-6a1.5 1.5 0 0 1 3 0v7-4a1.5 1.5 0 0 1 3 0v6a6 6 0 0 1-6 6h-1a5 5 0 0 1-4-2l-5-5a1.5 1.5 0 0 1 2-2l2 1Z"/>',
        'fragrance'=>'<rect x="6" y="10" width="12" height="11" rx="2"/><path d="M10 10V6h4v4m-4-4V3h5m3 1h3m-3 3 2 1"/>',
        'beard-grooming'=>'<circle cx="6" cy="17" r="3"/><circle cx="18" cy="17" r="3"/><path d="m8 15 9-12m-1 12L7 3"/>',
        'grooming-tools'=>'<rect x="7" y="7" width="10" height="14" rx="3"/><path d="M7 7V3h10v4M10 3v4m4-4v4m-4 7h4"/>'
    ];
    return '<svg class="category-icon" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">'.($paths[$category]??$paths['skincare']).'</svg>';
}
function gw_product_media($p,$v,$detail=false) {
    $image=$p['imageAssets'][$v['label']]??null;$label=gw_types()[$p['type']]??$p['type'];
    echo '<figure class="product-media '.($image?'has-photo':'').'" data-product-media>';
    echo '<div class="product-identity" '.($image?'hidden':'').'><span class="identity-brand">'.esc_html($p['brand']).'</span><span class="identity-name">'.esc_html($p['name']).'</span><span class="identity-variant">'.esc_html($label.' / '.$v['label']).'</span><span class="photo-status">Product photo unavailable</span>';
    foreach (array_keys($p['imageAssets']??[]) as $photoVariant) { if ($photoVariant!==$v['label']) { echo '<a class="media-variant-link" href="'.esc_url(add_query_arg('variant',$photoVariant,$p['url'])).'">See '.esc_html($photoVariant).' photo ↗</a>'; } }
    echo '</div>';
    if ($image) {
        echo '<span class="photo-loading js-only" aria-hidden="true">Loading photograph…</span>';
        echo '<img data-product-photo src="'.esc_url($image['src']).'" srcset="'.esc_attr($image['srcset']).'" sizes="'.($detail?'(min-width: 900px) 45vw, 90vw':'(min-width: 900px) 30vw, (min-width: 600px) 45vw, 90vw').'" width="'.(int)$image['width'].'" height="'.(int)$image['height'].'" alt="'.esc_attr($image['alt']).'" loading="'.($detail?'eager':'lazy').'" decoding="async">';
        echo '<figcaption class="photo-credit"><a href="'.esc_url($image['source']).'" rel="external noopener">'.esc_html($image['credit']).'</a> · <a href="'.esc_url($image['licenseUrl']).'" rel="external noopener">'.esc_html($image['license']).'</a></figcaption>';
    }
    echo '</figure>';
}
function gw_editorial_label($slug) {
    $labels=['shampoo-for-dry-frizzy-hair'=>['Hair notes','Wash, with care.'],'sunscreen-for-oily-skin'=>['Skin notes','The daily SPF.'],'perfumes-under-1000'=>['Scent notes','A considered scent.'],'body-lotion-for-dry-skin'=>['Body notes','Everyday comfort.'],'face-wash-for-sensitive-skin'=>['Skin notes','A gentler cleanse.'],'beard-oil-benefits'=>['Grooming notes','Beyond the beard.'],'trimmers-under-1500'=>['Tool notes','A closer look.']];
    return $labels[$slug]??['Field notes','Care, considered.'];
}
