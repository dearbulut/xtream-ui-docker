import{n as je,E as be,d as V,q as _e,N as Ve,$ as Ie,z as Ue,u as ce}from"./portal-CSVhat62.js";import{f as fe,u as ve}from"./hidden-BqmzDmTH.js";import{t as Ee,a as pe,o as $e,h as me,S as ze}from"./transition-CkXZVhaw.js";import{i as Se,A as G,S as k,o as y,u as q,P as Y,N as F,T as Ye,t as qe,a as ae,l as Ge,b as I,w as Ke,c as ge,d as Je,r as Qe}from"./XMarkIcon-BhqYf4eJ.js";import{D as K,r as g,B as d,z as A,E as R,G as T,F as Xe,H as ne,w as J,I as Ze,J as oe,K as re,L as et,o as B,m as he,i as O,h as M,u as x,b as D,n as tt,a as Z,l as U,j as lt,t as at,y as ye}from"./app-wF5SolYh.js";function Te(e){if(!e)return new Set;if(typeof e=="function")return new Set(e());let t=new Set;for(let l of e.value){let n=y(l);n instanceof HTMLElement&&t.add(n)}return t}var xe=(e=>(e[e.None=1]="None",e[e.InitialFocus=2]="InitialFocus",e[e.TabLock=4]="TabLock",e[e.FocusLock=8]="FocusLock",e[e.RestoreFocus=16]="RestoreFocus",e[e.All=30]="All",e))(xe||{});let H=Object.assign(K({name:"FocusTrap",props:{as:{type:[Object,String],default:"div"},initialFocus:{type:Object,default:null},features:{type:Number,default:30},containers:{type:[Object,Function],default:g(new Set)}},inheritAttrs:!1,setup(e,{attrs:t,slots:l,expose:n}){let a=g(null);n({el:a,$el:a});let o=d(()=>Se(a)),r=g(!1);A(()=>r.value=!0),R(()=>r.value=!1),ot({ownerDocument:o},d(()=>r.value&&!!(e.features&16)));let s=rt({ownerDocument:o,container:a,initialFocus:d(()=>e.initialFocus)},d(()=>r.value&&!!(e.features&2)));st({ownerDocument:o,container:a,containers:e.containers,previousActiveElement:s},d(()=>r.value&&!!(e.features&8)));let i=je();function c(p){let v=y(a);v&&(h=>h())(()=>{q(i.value,{[V.Forwards]:()=>{Y(v,F.First,{skipElements:[p.relatedTarget]})},[V.Backwards]:()=>{Y(v,F.Last,{skipElements:[p.relatedTarget]})}})})}let m=g(!1);function b(p){p.key==="Tab"&&(m.value=!0,requestAnimationFrame(()=>{m.value=!1}))}function w(p){if(!r.value)return;let v=Te(e.containers);y(a)instanceof HTMLElement&&v.add(y(a));let h=p.relatedTarget;h instanceof HTMLElement&&h.dataset.headlessuiFocusGuard!=="true"&&(De(v,h)||(m.value?Y(y(a),q(i.value,{[V.Forwards]:()=>F.Next,[V.Backwards]:()=>F.Previous})|F.WrapAround,{relativeTo:p.target}):p.target instanceof HTMLElement&&k(p.target)))}return()=>{let p={},v={ref:a,onKeydown:b,onFocusout:w},{features:h,initialFocus:E,containers:P,...C}=e;return T(Xe,[!!(h&4)&&T(fe,{as:"button",type:"button","data-headlessui-focus-guard":!0,onFocus:c,features:ve.Focusable}),G({ourProps:v,theirProps:{...t,...C},slot:p,attrs:t,slots:l,name:"FocusTrap"}),!!(h&4)&&T(fe,{as:"button",type:"button","data-headlessui-focus-guard":!0,onFocus:c,features:ve.Focusable})])}}}),{features:xe});function nt(e){let t=g(pe.slice());return J([e],([l],[n])=>{n===!0&&l===!1?Ee(()=>{t.value.splice(0)}):n===!1&&l===!0&&(t.value=pe.slice())},{flush:"post"}),()=>{var l;return(l=t.value.find(n=>n!=null&&n.isConnected))!=null?l:null}}function ot({ownerDocument:e},t){let l=nt(t);A(()=>{ne(()=>{var n,a;t.value||((n=e.value)==null?void 0:n.activeElement)===((a=e.value)==null?void 0:a.body)&&k(l())},{flush:"post"})}),R(()=>{t.value&&k(l())})}function rt({ownerDocument:e,container:t,initialFocus:l},n){let a=g(null),o=g(!1);return A(()=>o.value=!0),R(()=>o.value=!1),A(()=>{J([t,l,n],(r,s)=>{if(r.every((c,m)=>(s==null?void 0:s[m])===c)||!n.value)return;let i=y(t);i&&Ee(()=>{var c,m;if(!o.value)return;let b=y(l),w=(c=e.value)==null?void 0:c.activeElement;if(b){if(b===w){a.value=w;return}}else if(i.contains(w)){a.value=w;return}b?k(b):Y(i,F.First|F.NoScroll)===Ye.Error&&console.warn("There are no focusable elements inside the <FocusTrap />"),a.value=(m=e.value)==null?void 0:m.activeElement})},{immediate:!0,flush:"post"})}),a}function st({ownerDocument:e,container:t,containers:l,previousActiveElement:n},a){var o;be((o=e.value)==null?void 0:o.defaultView,"focus",r=>{if(!a.value)return;let s=Te(l);y(t)instanceof HTMLElement&&s.add(y(t));let i=n.value;if(!i)return;let c=r.target;c&&c instanceof HTMLElement?De(s,c)?(n.value=c,k(c)):(r.preventDefault(),r.stopPropagation(),k(i)):k(n.value)},!0)}function De(e,t){for(let l of e)if(l.contains(t))return!0;return!1}function it(e){let t=Ze(e.getSnapshot());return R(e.subscribe(()=>{t.value=e.getSnapshot()})),t}function ut(e,t){let l=e(),n=new Set;return{getSnapshot(){return l},subscribe(a){return n.add(a),()=>n.delete(a)},dispatch(a,...o){let r=t[a].call(l,...o);r&&(l=r,n.forEach(s=>s()))}}}function dt(){let e;return{before({doc:t}){var l;let n=t.documentElement;e=((l=t.defaultView)!=null?l:window).innerWidth-n.clientWidth},after({doc:t,d:l}){let n=t.documentElement,a=n.clientWidth-n.offsetWidth,o=e-a;l.style(n,"paddingRight",`${o}px`)}}}function ct(){return qe()?{before({doc:e,d:t,meta:l}){function n(a){return l.containers.flatMap(o=>o()).some(o=>o.contains(a))}t.microTask(()=>{var a;if(window.getComputedStyle(e.documentElement).scrollBehavior!=="auto"){let s=$e();s.style(e.documentElement,"scrollBehavior","auto"),t.add(()=>t.microTask(()=>s.dispose()))}let o=(a=window.scrollY)!=null?a:window.pageYOffset,r=null;t.addEventListener(e,"click",s=>{if(s.target instanceof HTMLElement)try{let i=s.target.closest("a");if(!i)return;let{hash:c}=new URL(i.href),m=e.querySelector(c);m&&!n(m)&&(r=m)}catch{}},!0),t.addEventListener(e,"touchstart",s=>{if(s.target instanceof HTMLElement)if(n(s.target)){let i=s.target;for(;i.parentElement&&n(i.parentElement);)i=i.parentElement;t.style(i,"overscrollBehavior","contain")}else t.style(s.target,"touchAction","none")}),t.addEventListener(e,"touchmove",s=>{if(s.target instanceof HTMLElement){if(s.target.tagName==="INPUT")return;if(n(s.target)){let i=s.target;for(;i.parentElement&&i.dataset.headlessuiPortal!==""&&!(i.scrollHeight>i.clientHeight||i.scrollWidth>i.clientWidth);)i=i.parentElement;i.dataset.headlessuiPortal===""&&s.preventDefault()}else s.preventDefault()}},{passive:!1}),t.add(()=>{var s;let i=(s=window.scrollY)!=null?s:window.pageYOffset;o!==i&&window.scrollTo(0,o),r&&r.isConnected&&(r.scrollIntoView({block:"nearest"}),r=null)})})}}:{}}function ft(){return{before({doc:e,d:t}){t.style(e.documentElement,"overflow","hidden")}}}function vt(e){let t={};for(let l of e)Object.assign(t,l(t));return t}let L=ut(()=>new Map,{PUSH(e,t){var l;let n=(l=this.get(e))!=null?l:{doc:e,count:0,d:$e(),meta:new Set};return n.count++,n.meta.add(t),this.set(e,n),this},POP(e,t){let l=this.get(e);return l&&(l.count--,l.meta.delete(t)),this},SCROLL_PREVENT({doc:e,d:t,meta:l}){let n={doc:e,d:t,meta:vt(l)},a=[ct(),dt(),ft()];a.forEach(({before:o})=>o==null?void 0:o(n)),a.forEach(({after:o})=>o==null?void 0:o(n))},SCROLL_ALLOW({d:e}){e.dispose()},TEARDOWN({doc:e}){this.delete(e)}});L.subscribe(()=>{let e=L.getSnapshot(),t=new Map;for(let[l]of e)t.set(l,l.documentElement.style.overflow);for(let l of e.values()){let n=t.get(l.doc)==="hidden",a=l.count!==0;(a&&!n||!a&&n)&&L.dispatch(l.count>0?"SCROLL_PREVENT":"SCROLL_ALLOW",l),l.count===0&&L.dispatch("TEARDOWN",l)}});function pt(e,t,l){let n=it(L),a=d(()=>{let o=e.value?n.value.get(e.value):void 0;return o?o.count>0:!1});return J([e,t],([o,r],[s],i)=>{if(!o||!r)return;L.dispatch("PUSH",o,l);let c=!1;i(()=>{c||(L.dispatch("POP",s??o,l),c=!0)})},{immediate:!0}),a}let ee=new Map,W=new Map;function we(e,t=g(!0)){ne(l=>{var n;if(!t.value)return;let a=y(e);if(!a)return;l(function(){var r;if(!a)return;let s=(r=W.get(a))!=null?r:1;if(s===1?W.delete(a):W.set(a,s-1),s!==1)return;let i=ee.get(a);i&&(i["aria-hidden"]===null?a.removeAttribute("aria-hidden"):a.setAttribute("aria-hidden",i["aria-hidden"]),a.inert=i.inert,ee.delete(a))});let o=(n=W.get(a))!=null?n:0;W.set(a,o+1),o===0&&(ee.set(a,{"aria-hidden":a.getAttribute("aria-hidden"),inert:a.inert}),a.setAttribute("aria-hidden","true"),a.inert=!0)})}let Fe=Symbol("StackContext");var te=(e=>(e[e.Add=0]="Add",e[e.Remove=1]="Remove",e))(te||{});function mt(){return re(Fe,()=>{})}function gt({type:e,enabled:t,element:l,onUpdate:n}){let a=mt();function o(...r){n==null||n(...r),a(...r)}A(()=>{J(t,(r,s)=>{r?o(0,e,l):s===!0&&o(1,e,l)},{immediate:!0,flush:"sync"})}),R(()=>{t.value&&o(1,e,l)}),oe(Fe,o)}let ht=Symbol("DescriptionContext");function yt({slot:e=g({}),name:t="Description",props:l={}}={}){let n=g([]);function a(o){return n.value.push(o),()=>{let r=n.value.indexOf(o);r!==-1&&n.value.splice(r,1)}}return oe(ht,{register:a,slot:e,name:t,props:l}),d(()=>n.value.length>0?n.value.join(" "):void 0)}var wt=(e=>(e[e.Open=0]="Open",e[e.Closed=1]="Closed",e))(wt||{});let le=Symbol("DialogContext");function se(e){let t=re(le,null);if(t===null){let l=new Error(`<${e} /> is missing a parent <Dialog /> component.`);throw Error.captureStackTrace&&Error.captureStackTrace(l,se),l}return t}let z="DC8F892D-2EBD-447C-A4C8-A03058436FF4",bt=K({name:"Dialog",inheritAttrs:!1,props:{as:{type:[Object,String],default:"div"},static:{type:Boolean,default:!1},unmount:{type:Boolean,default:!0},open:{type:[Boolean,String],default:z},initialFocus:{type:Object,default:null},id:{type:String,default:null},role:{type:String,default:"dialog"}},emits:{close:e=>!0},setup(e,{emit:t,attrs:l,slots:n,expose:a}){var o,r;let s=(o=e.id)!=null?o:`headlessui-dialog-${ae()}`,i=g(!1);A(()=>{i.value=!0});let c=!1,m=d(()=>e.role==="dialog"||e.role==="alertdialog"?e.role:(c||(c=!0,console.warn(`Invalid role [${m}] passed to <Dialog />. Only \`dialog\` and and \`alertdialog\` are supported. Using \`dialog\` instead.`)),"dialog")),b=g(0),w=Ge(),p=d(()=>e.open===z&&w!==null?(w.value&I.Open)===I.Open:e.open),v=g(null),h=d(()=>Se(v));if(a({el:v,$el:v}),!(e.open!==z||w!==null))throw new Error("You forgot to provide an `open` prop to the `Dialog`.");if(typeof p.value!="boolean")throw new Error(`You provided an \`open\` prop to the \`Dialog\`, but the value is not a boolean. Received: ${p.value===z?void 0:e.open}`);let E=d(()=>i.value&&p.value?0:1),P=d(()=>E.value===0),C=d(()=>b.value>1),ie=re(le,null)!==null,[Le,ke]=_e(),{resolveContainers:Q,mainTreeNodeRef:ue,MainTreeNode:Ae}=Ve({portals:Le,defaultContainers:[d(()=>{var u;return(u=N.panelRef.value)!=null?u:v.value})]}),Ce=d(()=>C.value?"parent":"leaf"),de=d(()=>w!==null?(w.value&I.Closing)===I.Closing:!1),Oe=d(()=>ie||de.value?!1:P.value),Re=d(()=>{var u,f,$;return($=Array.from((f=(u=h.value)==null?void 0:u.querySelectorAll("body > *"))!=null?f:[]).find(S=>S.id==="headlessui-portal-root"?!1:S.contains(y(ue))&&S instanceof HTMLElement))!=null?$:null});we(Re,Oe);let Pe=d(()=>C.value?!0:P.value),Ne=d(()=>{var u,f,$;return($=Array.from((f=(u=h.value)==null?void 0:u.querySelectorAll("[data-headlessui-portal]"))!=null?f:[]).find(S=>S.contains(y(ue))&&S instanceof HTMLElement))!=null?$:null});we(Ne,Pe),gt({type:"Dialog",enabled:d(()=>E.value===0),element:v,onUpdate:(u,f)=>{if(f==="Dialog")return q(u,{[te.Add]:()=>b.value+=1,[te.Remove]:()=>b.value-=1})}});let Be=yt({name:"DialogDescription",slot:d(()=>({open:p.value}))}),j=g(null),N={titleId:j,panelRef:g(null),dialogState:E,setTitleId(u){j.value!==u&&(j.value=u)},close(){t("close",!1)}};oe(le,N);let Me=d(()=>!(!P.value||C.value));Ke(Q,(u,f)=>{u.preventDefault(),N.close(),et(()=>f==null?void 0:f.focus())},Me);let He=d(()=>!(C.value||E.value!==0));be((r=h.value)==null?void 0:r.defaultView,"keydown",u=>{He.value&&(u.defaultPrevented||u.key===Je.Escape&&(u.preventDefault(),u.stopPropagation(),N.close()))});let We=d(()=>!(de.value||E.value!==0||ie));return pt(h,We,u=>{var f;return{containers:[...(f=u.containers)!=null?f:[],Q]}}),ne(u=>{if(E.value!==0)return;let f=y(v);if(!f)return;let $=new ResizeObserver(S=>{for(let X of S){let _=X.target.getBoundingClientRect();_.x===0&&_.y===0&&_.width===0&&_.height===0&&N.close()}});$.observe(f),u(()=>$.disconnect())}),()=>{let{open:u,initialFocus:f,...$}=e,S={...l,ref:v,id:s,role:m.value,"aria-modal":E.value===0?!0:void 0,"aria-labelledby":j.value,"aria-describedby":Be.value},X={open:E.value===0};return T(ce,{force:!0},()=>[T(Ie,()=>T(Ue,{target:v.value},()=>T(ce,{force:!1},()=>T(H,{initialFocus:f,containers:Q,features:P.value?q(Ce.value,{parent:H.features.RestoreFocus,leaf:H.features.All&~H.features.FocusLock}):H.features.None},()=>T(ke,{},()=>G({ourProps:S,theirProps:{...$,...l},slot:X,attrs:l,slots:n,visible:E.value===0,features:ge.RenderStrategy|ge.Static,name:"Dialog"})))))),T(Ae)])}}}),Et=K({name:"DialogPanel",props:{as:{type:[Object,String],default:"div"},id:{type:String,default:null}},setup(e,{attrs:t,slots:l,expose:n}){var a;let o=(a=e.id)!=null?a:`headlessui-dialog-panel-${ae()}`,r=se("DialogPanel");n({el:r.panelRef,$el:r.panelRef});function s(i){i.stopPropagation()}return()=>{let{...i}=e,c={id:o,ref:r.panelRef,onClick:s};return G({ourProps:c,theirProps:i,slot:{open:r.dialogState.value===0},attrs:t,slots:l,name:"DialogPanel"})}}}),$t=K({name:"DialogTitle",props:{as:{type:[Object,String],default:"h2"},id:{type:String,default:null}},setup(e,{attrs:t,slots:l}){var n;let a=(n=e.id)!=null?n:`headlessui-dialog-title-${ae()}`,o=se("DialogTitle");return A(()=>{o.setTitleId(a),R(()=>o.setTitleId(null))}),()=>{let{...r}=e;return G({ourProps:{id:a},theirProps:r,slot:{open:o.dialogState.value===0},attrs:t,slots:l,name:"DialogTitle"})}}});const St={class:"fixed inset-0 z-10 overflow-y-auto"},Tt={class:"flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0"},xt={key:0,class:"absolute right-0 top-0 hidden pr-4 pt-4 sm:block"},Dt={class:"sm:flex sm:items-start"},Ft={class:"mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left"},Lt={class:"mt-2"},kt={key:1,class:"mt-5 sm:mt-4 sm:flex sm:flex-row-reverse"},Nt={__name:"Modal",props:{show:{type:Boolean,default:!1},title:{type:String,default:null},maxWidth:{type:String,default:"2xl"},closeable:{type:Boolean,default:!0}},emits:["close"],setup(e,{emit:t}){const l=e,n=t,a=()=>{l.closeable&&n("close")},o=computed(()=>({sm:"sm:max-w-sm",md:"sm:max-w-md",lg:"sm:max-w-lg",xl:"sm:max-w-xl","2xl":"sm:max-w-2xl"})[l.maxWidth]);return(r,s)=>(B(),he(x(ze),{appear:"",show:e.show,as:"template"},{default:O(()=>[M(x(bt),{as:"div",class:"relative z-10",onClose:a},{default:O(()=>[M(x(me),{as:"template",enter:"duration-300 ease-out","enter-from":"opacity-0","enter-to":"opacity-100",leave:"duration-200 ease-in","leave-from":"opacity-100","leave-to":"opacity-0"},{default:O(()=>s[0]||(s[0]=[D("div",{class:"fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"},null,-1)])),_:1}),D("div",St,[D("div",Tt,[M(x(me),{as:"template",enter:"duration-300 ease-out","enter-from":"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95","enter-to":"opacity-100 translate-y-0 sm:scale-100",leave:"duration-200 ease-in","leave-from":"opacity-100 translate-y-0 sm:scale-100","leave-to":"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"},{default:O(()=>[M(x(Et),{class:tt(["relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:p-6",x(o)])},{default:O(()=>[e.title||e.closeable?(B(),Z("div",xt,[e.closeable?(B(),Z("button",{key:0,type:"button",class:"rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2",onClick:a},[s[1]||(s[1]=D("span",{class:"sr-only"},"Close",-1)),M(x(Qe),{class:"h-6 w-6","aria-hidden":"true"})])):U("",!0)])):U("",!0),D("div",Dt,[D("div",Ft,[e.title?(B(),he(x($t),{key:0,as:"h3",class:"text-base font-semibold leading-6 text-gray-900"},{default:O(()=>[lt(at(e.title),1)]),_:1})):U("",!0),D("div",Lt,[ye(r.$slots,"default")])])]),r.$slots.footer?(B(),Z("div",kt,[ye(r.$slots,"footer")])):U("",!0)]),_:3},8,["class"])]),_:3})])])]),_:3})]),_:3},8,["show"]))}};export{Nt as _};