import{c as ue,s as se,g,a as de,u as M,o as K,e as fe,b as c,h as ve,A as W,l as ce,f as pe}from"./XMarkIcon-BhqYf4eJ.js";import{D as X,r as y,G as Y,B as A,z as L,E as Z,H as C,w as me,J as x,n as he,K as P}from"./app-wF5SolYh.js";function ge(e){typeof queueMicrotask=="function"?queueMicrotask(e):Promise.resolve().then(e).catch(t=>setTimeout(()=>{throw t}))}function j(){let e=[],t={addEventListener(n,r,l,a){return n.addEventListener(r,l,a),t.add(()=>n.removeEventListener(r,l,a))},requestAnimationFrame(...n){let r=requestAnimationFrame(...n);t.add(()=>cancelAnimationFrame(r))},nextFrame(...n){t.requestAnimationFrame(()=>{t.requestAnimationFrame(...n)})},setTimeout(...n){let r=setTimeout(...n);t.add(()=>clearTimeout(r))},microTask(...n){let r={current:!0};return ge(()=>{r.current&&n[0]()}),t.add(()=>{r.current=!1})},style(n,r,l){let a=n.style.getPropertyValue(r);return Object.assign(n.style,{[r]:l}),this.add(()=>{Object.assign(n.style,{[r]:a})})},group(n){let r=j();return n(r),this.add(()=>r.dispose())},add(n){return e.push(n),()=>{let r=e.indexOf(n);if(r>=0)for(let l of e.splice(r,1))l()}},dispose(){for(let n of e.splice(0))n()}};return t}function ye(e){function t(){document.readyState!=="loading"&&(e(),document.removeEventListener("DOMContentLoaded",t))}typeof window<"u"&&typeof document<"u"&&(document.addEventListener("DOMContentLoaded",t),t())}let E=[];ye(()=>{function e(t){t.target instanceof HTMLElement&&t.target!==document.body&&E[0]!==t.target&&(E.unshift(t.target),E=E.filter(n=>n!=null&&n.isConnected),E.splice(10))}window.addEventListener("click",e,{capture:!0}),window.addEventListener("mousedown",e,{capture:!0}),window.addEventListener("focus",e,{capture:!0}),document.body.addEventListener("click",e,{capture:!0}),document.body.addEventListener("mousedown",e,{capture:!0}),document.body.addEventListener("focus",e,{capture:!0})});function be(e){let t={called:!1};return(...n)=>{if(!t.called)return t.called=!0,e(...n)}}function H(e,...t){e&&t.length>0&&e.classList.add(...t)}function F(e,...t){e&&t.length>0&&e.classList.remove(...t)}var D=(e=>(e.Finished="finished",e.Cancelled="cancelled",e))(D||{});function Ee(e,t){let n=j();if(!e)return n.dispose;let{transitionDuration:r,transitionDelay:l}=getComputedStyle(e),[a,i]=[r,l].map(o=>{let[u=0]=o.split(",").filter(Boolean).map(s=>s.includes("ms")?parseFloat(s):parseFloat(s)*1e3).sort((s,d)=>d-s);return u});return a!==0?n.setTimeout(()=>t("finished"),a+i):t("finished"),n.add(()=>t("cancelled")),n.dispose}function Q(e,t,n,r,l,a){let i=j(),o=a!==void 0?be(a):()=>{};return F(e,...l),H(e,...t,...n),i.nextFrame(()=>{F(e,...n),H(e,...r),i.add(Ee(e,u=>(F(e,...r,...t),H(e,...l),o(u))))}),i.add(()=>F(e,...t,...n,...r,...l)),i.add(()=>o("cancelled")),i.dispose}function h(e=""){return e.split(/\s+/).filter(t=>t.length>1)}let q=Symbol("TransitionContext");var Le=(e=>(e.Visible="visible",e.Hidden="hidden",e))(Le||{});function we(){return P(q,null)!==null}function Se(){let e=P(q,null);if(e===null)throw new Error("A <TransitionChild /> is used but it is missing a parent <TransitionRoot />.");return e}function Te(){let e=P(k,null);if(e===null)throw new Error("A <TransitionChild /> is used but it is missing a parent <TransitionRoot />.");return e}let k=Symbol("NestingContext");function B(e){return"children"in e?B(e.children):e.value.filter(({state:t})=>t==="visible").length>0}function _(e){let t=y([]),n=y(!1);L(()=>n.value=!0),Z(()=>n.value=!1);function r(a,i=g.Hidden){let o=t.value.findIndex(({id:u})=>u===a);o!==-1&&(M(i,{[g.Unmount](){t.value.splice(o,1)},[g.Hidden](){t.value[o].state="hidden"}}),!B(t)&&n.value&&(e==null||e()))}function l(a){let i=t.value.find(({id:o})=>o===a);return i?i.state!=="visible"&&(i.state="visible"):t.value.push({id:a,state:"visible"}),()=>r(a,g.Unmount)}return{children:t,register:l,unregister:r}}let ee=ue.RenderStrategy,Fe=X({props:{as:{type:[Object,String],default:"div"},show:{type:[Boolean],default:null},unmount:{type:[Boolean],default:!0},appear:{type:[Boolean],default:!1},enter:{type:[String],default:""},enterFrom:{type:[String],default:""},enterTo:{type:[String],default:""},entered:{type:[String],default:""},leave:{type:[String],default:""},leaveFrom:{type:[String],default:""},leaveTo:{type:[String],default:""}},emits:{beforeEnter:()=>!0,afterEnter:()=>!0,beforeLeave:()=>!0,afterLeave:()=>!0},setup(e,{emit:t,attrs:n,slots:r,expose:l}){let a=y(0);function i(){a.value|=c.Opening,t("beforeEnter")}function o(){a.value&=~c.Opening,t("afterEnter")}function u(){a.value|=c.Closing,t("beforeLeave")}function s(){a.value&=~c.Closing,t("afterLeave")}if(!we()&&se())return()=>Y(Ce,{...e,onBeforeEnter:i,onAfterEnter:o,onBeforeLeave:u,onAfterLeave:s},r);let d=y(null),w=A(()=>e.unmount?g.Unmount:g.Hidden);l({el:d,$el:d});let{show:p,appear:U}=Se(),{register:R,unregister:$}=Te(),f=y(p.value?"visible":"hidden"),V={value:!0},b=de(),S={value:!1},N=_(()=>{!S.value&&f.value!=="hidden"&&(f.value="hidden",$(b),s())});L(()=>{let v=R(b);Z(v)}),C(()=>{if(w.value===g.Hidden&&b){if(p.value&&f.value!=="visible"){f.value="visible";return}M(f.value,{hidden:()=>$(b),visible:()=>R(b)})}});let z=h(e.enter),I=h(e.enterFrom),te=h(e.enterTo),G=h(e.entered),ne=h(e.leave),re=h(e.leaveFrom),ae=h(e.leaveTo);L(()=>{C(()=>{if(f.value==="visible"){let v=K(d);if(v instanceof Comment&&v.data==="")throw new Error("Did you forget to passthrough the `ref` to the actual DOM node?")}})});function ie(v){let O=V.value&&!U.value,m=K(d);!m||!(m instanceof HTMLElement)||O||(S.value=!0,p.value&&i(),p.value||u(),v(p.value?Q(m,z,I,te,G,T=>{S.value=!1,T===D.Finished&&o()}):Q(m,ne,re,ae,G,T=>{S.value=!1,T===D.Finished&&(B(N)||(f.value="hidden",$(b),s()))})))}return L(()=>{me([p],(v,O,m)=>{ie(m),V.value=!1},{immediate:!0})}),x(k,N),fe(A(()=>M(f.value,{visible:c.Open,hidden:c.Closed})|a.value)),()=>{let{appear:v,show:O,enter:m,enterFrom:T,enterTo:Be,entered:$e,leave:Oe,leaveFrom:He,leaveTo:Me,...J}=e,le={ref:d},oe={...J,...U.value&&p.value&&ve.isServer?{class:he([n.class,J.class,...z,...I])}:{}};return W({theirProps:oe,ourProps:le,slot:{},slots:r,attrs:n,features:ee,visible:f.value==="visible",name:"TransitionChild"})}}}),Ae=Fe,Ce=X({inheritAttrs:!1,props:{as:{type:[Object,String],default:"div"},show:{type:[Boolean],default:null},unmount:{type:[Boolean],default:!0},appear:{type:[Boolean],default:!1},enter:{type:[String],default:""},enterFrom:{type:[String],default:""},enterTo:{type:[String],default:""},entered:{type:[String],default:""},leave:{type:[String],default:""},leaveFrom:{type:[String],default:""},leaveTo:{type:[String],default:""}},emits:{beforeEnter:()=>!0,afterEnter:()=>!0,beforeLeave:()=>!0,afterLeave:()=>!0},setup(e,{emit:t,attrs:n,slots:r}){let l=ce(),a=A(()=>e.show===null&&l!==null?(l.value&c.Open)===c.Open:e.show);C(()=>{if(![!0,!1].includes(a.value))throw new Error('A <Transition /> is used but it is missing a `:show="true | false"` prop.')});let i=y(a.value?"visible":"hidden"),o=_(()=>{i.value="hidden"}),u=y(!0),s={show:a,appear:A(()=>e.appear||!u.value)};return L(()=>{C(()=>{u.value=!1,a.value?i.value="visible":B(o)||(i.value="hidden")})}),x(k,o),x(q,s),()=>{let d=pe(e,["show","appear","unmount","onBeforeEnter","onBeforeLeave","onAfterEnter","onAfterLeave"]),w={unmount:e.unmount};return W({ourProps:{...w,as:"template"},theirProps:{},slot:{},slots:{...r,default:()=>[Y(Ae,{onBeforeEnter:()=>t("beforeEnter"),onAfterEnter:()=>t("afterEnter"),onBeforeLeave:()=>t("beforeLeave"),onAfterLeave:()=>t("afterLeave"),...n,...w,...d},r.default)]},attrs:{},features:ee,visible:i.value==="visible",name:"Transition"})}}});export{Ce as S,E as a,Fe as h,j as o,ge as t};