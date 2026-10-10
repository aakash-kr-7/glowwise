const escape=v=>String(v??'').replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
const safeURL=(value,home)=>{try{const u=new URL(value,home);return /^https?:$/.test(u.protocol)?escape(u.href):'#';}catch{return '#';}};
export function productMedia(p,v,config){
 const image=p.imageAssets?.[v.label],type=config.types[p.type]||p.type;
 const identity=`<div class="product-identity" ${image?'hidden':''}><span class="identity-brand">${escape(p.brand)}</span><span class="identity-name">${escape(p.name)}</span><span class="identity-variant">${escape(type+' / '+v.label)}</span><span class="photo-status">Product photo unavailable</span></div>`;
 if(!image)return `<figure class="product-media" data-product-media>${identity}</figure>`;
 return `<figure class="product-media has-photo" data-product-media>${identity}<img data-product-photo src="${safeURL(image.src,config.home)}" srcset="${escape(image.srcset||'')}" sizes="(min-width: 900px) 30vw, (min-width: 600px) 45vw, 90vw" width="${Number(image.width)||1200}" height="${Number(image.height)||1600}" alt="${escape(image.alt)}" loading="lazy" decoding="async"><figcaption class="photo-credit"><a href="${safeURL(image.source,config.home)}" rel="external noopener">${escape(image.credit)}</a> · <a href="${safeURL(image.licenseUrl,config.home)}" rel="license">${escape(image.license)}</a></figcaption></figure>`;
}
export function recoverPhoto(image){
 const figure=image.closest('[data-product-media]');if(!figure)return;
 image.hidden=true;figure.classList.remove('has-photo');figure.classList.add('image-failure');
 const identity=figure.querySelector('.product-identity');identity.hidden=false;identity.querySelector('.photo-status').textContent='Product photo could not load';
}
