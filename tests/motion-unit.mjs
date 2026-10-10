import {readFile} from 'node:fs/promises';import vm from 'node:vm';import assert from 'node:assert/strict';
const source=(await readFile('theme/glowwise/assets/src/motion.js','utf8')).replace(/^import .*;\s*$/mg,'');
function fixture(reduced,elements=[{}]){let animations=[],reverts=0,change;const media={matches:reduced,addEventListener:(event,fn)=>change=fn};const gsap={registerPlugin(){},context(fn){fn();return{revert(){reverts++;}};},fromTo(el,from,to){animations.push({from,to});},utils:{toArray:()=>elements}};vm.runInNewContext(source,{gsap,ScrollTrigger:{},matchMedia:()=>media});return{media,animations,get reverts(){return reverts;},change:()=>change()};}
let f=fixture(true);assert.equal(f.animations.length,0);
f=fixture(false);assert.equal(f.animations.length,1);assert.equal(f.animations[0].to.repeat,undefined);assert.equal(f.animations[0].to.scrollTrigger.once,true);assert.equal(f.animations[0].from.opacity,undefined);
f.media.matches=true;f.change();assert.equal(f.reverts,1);assert.equal(f.animations.length,1);
f.media.matches=false;f.change();assert.equal(f.animations.length,2);
f=fixture(false,[]);assert.equal(f.animations.length,0);
console.log('PASS: finite reveals, initially reduced motion, preference changes restore layout, no hidden content and empty-page safety. Unit doubles; no OS emulation claim.');
