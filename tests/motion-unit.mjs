// Test the real motion module with isolated media/GSAP doubles, not OS emulation.
import {readFile} from 'node:fs/promises';import vm from 'node:vm';import assert from 'node:assert/strict';
const source=(await readFile('theme/glowwise/assets/src/motion.js','utf8')).replace(/^import .*;\s*$/mg,'');
function fixture(reduced){let tweens=0,reverts=0,change,visibility,click;const pauses=[];const control={textContent:'',disabled:false,setAttribute:(k,v)=>control[k]=v,addEventListener:(event,fn)=>click=fn};const media={matches:reduced,addEventListener:(event,fn)=>change=fn};const document={hidden:false,querySelector:s=>s==='[data-motion-pause]'?control:{},addEventListener:(event,fn)=>visibility=fn};const gsap={registerPlugin(){},context(fn){fn();return {revert(){reverts++;}};},to(){tweens++;return {paused:v=>pauses.push(v)};},fromTo(){},utils:{toArray:()=>[]}};vm.runInNewContext(source,{document,gsap,ScrollTrigger:{},matchMedia:()=>media});return {control,media,document,get tweens(){return tweens;},get reverts(){return reverts;},pauses,change:()=>change(),click:()=>click(),visibility:()=>visibility()};}
let f=fixture(true);assert.equal(f.tweens,0);assert.equal(f.control.disabled,true);assert.equal(f.control.textContent,'Motion reduced');
f=fixture(false);assert.equal(f.tweens,1);f.click();assert.equal(f.control['aria-pressed'],'true');assert.equal(f.pauses.at(-1),true);f.click();assert.equal(f.pauses.at(-1),false);
f.document.hidden=true;f.visibility();assert.equal(f.pauses.at(-1),true);
f.media.matches=true;f.change();assert.equal(f.reverts,1);assert.equal(f.control.disabled,true);
console.log('PASS: reduced-motion initial state, pause/resume, hidden document and live preference change; isolated unit checks, not OS browser emulation.');
