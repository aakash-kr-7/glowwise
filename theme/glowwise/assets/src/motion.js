import {gsap} from 'gsap';
import {ScrollTrigger} from 'gsap/ScrollTrigger';
gsap.registerPlugin(ScrollTrigger);
const media=matchMedia('(prefers-reduced-motion: reduce)');let context;
function setup(){context?.revert();context=null;if(media.matches){return;}context=gsap.context(()=>{gsap.utils.toArray('.manifesto,.category-section,.finder-feature').forEach(el=>gsap.fromTo(el,{y:12},{y:0,duration:.45,ease:'power2.out',scrollTrigger:{trigger:el,start:'top 95%',once:true}}));});}
// Finite reveals only. No continuous decorative motion or hidden content.
media.addEventListener('change',setup);setup();
