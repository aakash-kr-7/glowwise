/* Basic, explicit-consent GA4. No free text, contact fields or query strings. */
const id=window.Glowwise?.analyticsId;
let loaded=false;
export function trackEvent(name) {
  // Fixed names only: never send lists, identifiers, budgets, search or form text.
  if(!loaded||window['ga-disable-'+id]||typeof window.gtag!=='function'||!['finder_complete','compare_add','save_product','retailer_click'].includes(name))return;
  window.gtag('event',name,{page_location:location.origin+location.pathname,page_referrer:''});
}
export function enableAnalytics() {
  if(loaded||!/^G-[A-Z0-9]+$/.test(id||''))return;
  const path=location.pathname;
  // Only known editorial/catalog routes. Forms, errors and search are excluded.
  if(!/^\/(?:$|explore\/(?:page\/\d+\/)?$|categories\/(?:[a-z-]+\/)?$|products\/[a-z0-9-]+\/$|guides\/(?:[a-z0-9-]+\/|page\/\d+\/)?$|about\/$|how-we-select\/$|disclosures\/$|accessibility\/$|finder\/$|compare\/$|saved\/$)/.test(path)||document.body.classList.contains('error404')||new URLSearchParams(location.search).has('s'))return;
  loaded=true;
  window['ga-disable-'+id]=false;
  window.dataLayer=window.dataLayer||[];
  window.gtag=function(){window.dataLayer.push(arguments);};
  window.gtag('consent','default',{analytics_storage:'granted',ad_storage:'denied',ad_user_data:'denied',ad_personalization:'denied'});
  window.gtag('js',new Date());
  window.gtag('config',id,{send_page_view:false,allow_google_signals:false,allow_ad_personalization_signals:false,cookie_expires:5184000,cookie_flags:'SameSite=Lax;Secure',page_location:location.origin+path,page_referrer:''});
  window.gtag('event','page_view',{page_location:location.origin+path,page_title:document.title,page_referrer:''});
  const script=document.createElement('script');script.async=true;script.id='gw-analytics-sdk';script.src='https://www.googletagmanager.com/gtag/js?id='+id;document.head.append(script);
}
export function disableAnalytics() {
  if(!id)return false;
  window['ga-disable-'+id]=true;
  document.querySelector('#gw-analytics-sdk')?.remove();
  // Denied cookie access must never interrupt essential tools.
  try {
    for(const part of document.cookie.split(';')) {
      const name=part.trim().split('=')[0];
      if(!/^_ga(?:_|$)/.test(name))continue;
      for(const domain of ['',location.hostname,'.'+location.hostname])document.cookie=name+'=; Max-Age=0; path=/; Secure; SameSite=Lax'+(domain?'; domain='+domain:'');
    }
  } catch { /* Browser denied cookie access; rejection still prevents loading. */ }
  // A reload unloads the already accepted SDK, with rejection persisted first.
  return loaded;
}
