// Isolated unit checks; these are not a browser or field analytics measurement.
import {readFile} from 'node:fs/promises';
import vm from 'node:vm';
import assert from 'node:assert/strict';
const source=(await readFile('theme/glowwise/assets/src/analytics.js','utf8')).replaceAll('export function','function')+'\nthis.enable=enableAnalytics;this.disable=disableAnalytics;this.track=trackEvent;';
function fixture(path='/',query='',denied=false){
 const scripts=[],events=[],cookies=[];
 const document={title:'Glowwise',body:{classList:{contains:()=>false}},querySelector:()=>null,createElement:()=>({}),head:{append:s=>scripts.push(s)}};
 Object.defineProperty(document,'cookie',{get(){if(denied)throw new Error('storage denied');return '_ga=test;_ga_STREAM=test';},set(value){if(denied)throw new Error('storage denied');cookies.push(value);}});
 const context={window:{Glowwise:{analyticsId:'G-XC6V3MXTJP'}},document,location:{pathname:path,search:query,origin:'https://glowwise.tech',hostname:'glowwise.tech'},URLSearchParams,Date};
 vm.createContext(context);vm.runInContext(source,context);return {context,scripts,events,cookies};
}
let checks=0;
function check(name,fn){fn();checks++;console.log('PASS '+name);}
check('No request or dataLayer before explicit enable',()=>{const f=fixture();assert.equal(f.scripts.length,0);assert.equal(f.context.window.dataLayer,undefined);});
check('Denied cookies do not throw or activate analytics',()=>{const f=fixture('/saved/','',true);assert.equal(f.context.disable(),false);assert.equal(f.scripts.length,0);});
check('Contact, corrections, 404 routes and search never load SDK',()=>{for(const [p,q] of [['/contact/',''],['/corrections/',''],['/unknown/',''],['/','?s=private+query']]){const f=fixture(p,q);f.context.enable();assert.equal(f.scripts.length,0);}});
check('Catalog query is stripped from all supplied event URLs',()=>{const f=fixture('/explore/','?q=private-query&max-price=250');f.context.enable();assert.equal(f.scripts.length,1);const entries=f.context.window.dataLayer.map(a=>Array.from(a));assert.ok(entries.some(a=>a[0]==='event'&&a[1]==='page_view'));for(const a of entries){if(a[2]?.page_location)assert.equal(a[2].page_location,'https://glowwise.tech/explore/');if(a[2]?.page_referrer!==undefined)assert.equal(a[2].page_referrer,'');}});
check('Repeated enable cannot double-load SDK',()=>{const f=fixture();f.context.enable();f.context.enable();assert.equal(f.scripts.length,1);});
check('Withdrawal disables stream, clears accessible cookies, requests unload',()=>{const f=fixture();f.context.enable();assert.equal(f.context.disable(),true);assert.equal(f.context.window['ga-disable-G-XC6V3MXTJP'],true);assert.equal(f.cookies.length,6);});
check('Fixed tool events require consent and exclude all supplied arbitrary data',()=>{const f=fixture('/finder/','?private=query');f.context.track('finder_complete');assert.equal(f.context.window.dataLayer,undefined);f.context.enable();const before=f.context.window.dataLayer.length;f.context.track('free_text');assert.equal(f.context.window.dataLayer.length,before);for(const name of ['finder_complete','compare_add','save_product','retailer_click'])f.context.track(name,{message:'private text',products:[1,2]});const events=f.context.window.dataLayer.slice(-4).map(a=>Array.from(a));assert.equal(events.length,4);for(const a of events){assert.deepEqual(Object.keys(a[2]).sort(),['page_location','page_referrer']);assert.equal(a[2].page_location,'https://glowwise.tech/finder/');}f.context.disable();const count=f.context.window.dataLayer.length;f.context.track('save_product');assert.equal(f.context.window.dataLayer.length,count);});
console.log(JSON.stringify({checks,pass:true,scope:'isolated unit rules, not browser telemetry'}));
