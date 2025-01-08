import{c as L,g as Oe,r as q,w as qe,o as d,a as v,b as e,d as N,v as B,e as Ce,F,f as se,t as x,h as m,i as p,u as y,j,k as Re,l as $,m as D,n as Ee,P as Le,p as ae}from"./app-wF5SolYh.js";import{_ as Ne}from"./AdminLayout-F-YtpbF-.js";import{_ as C}from"./Button-COWAl97y.js";import{o as b,_ as De,u as Fe}from"./useToast-BYzZ-uBf.js";import{_ as Me}from"./Badge-D0Q5MHX0.js";import{_ as Ae}from"./Modal-BH8njDpj.js";/* empty css            */import"./portal-CSVhat62.js";import"./XMarkIcon-BhqYf4eJ.js";import"./hidden-BqmzDmTH.js";import"./transition-CkXZVhaw.js";var P,le;function we(){if(le)return P;le=1;function t(r){var o=typeof r;return r!=null&&(o=="object"||o=="function")}return P=t,P}var V,de;function Ge(){if(de)return V;de=1;var t=typeof L=="object"&&L&&L.Object===Object&&L;return V=t,V}var U,ce;function Te(){if(ce)return U;ce=1;var t=Ge(),r=typeof self=="object"&&self&&self.Object===Object&&self,o=t||r||Function("return this")();return U=o,U}var W,ue;function Be(){if(ue)return W;ue=1;var t=Te(),r=function(){return t.Date.now()};return W=r,W}var H,me;function Pe(){if(me)return H;me=1;var t=/\s/;function r(o){for(var a=o.length;a--&&t.test(o.charAt(a)););return a}return H=r,H}var z,fe;function Ve(){if(fe)return z;fe=1;var t=Pe(),r=/^\s+/;function o(a){return a&&a.slice(0,t(a)+1).replace(r,"")}return z=o,z}var J,ge;function ke(){if(ge)return J;ge=1;var t=Te(),r=t.Symbol;return J=r,J}var X,xe;function Ue(){if(xe)return X;xe=1;var t=ke(),r=Object.prototype,o=r.hasOwnProperty,a=r.toString,s=t?t.toStringTag:void 0;function f(c){var l=o.call(c,s),n=c[s];try{c[s]=void 0;var i=!0}catch{}var g=a.call(c);return i&&(l?c[s]=n:delete c[s]),g}return X=f,X}var Y,ve;function We(){if(ve)return Y;ve=1;var t=Object.prototype,r=t.toString;function o(a){return r.call(a)}return Y=o,Y}var K,pe;function He(){if(pe)return K;pe=1;var t=ke(),r=Ue(),o=We(),a="[object Null]",s="[object Undefined]",f=t?t.toStringTag:void 0;function c(l){return l==null?l===void 0?s:a:f&&f in Object(l)?r(l):o(l)}return K=c,K}var Q,_e;function ze(){if(_e)return Q;_e=1;function t(r){return r!=null&&typeof r=="object"}return Q=t,Q}var Z,ye;function Je(){if(ye)return Z;ye=1;var t=He(),r=ze(),o="[object Symbol]";function a(s){return typeof s=="symbol"||r(s)&&t(s)==o}return Z=a,Z}var ee,he;function Xe(){if(he)return ee;he=1;var t=Ve(),r=we(),o=Je(),a=NaN,s=/^[-+]0x[0-9a-f]+$/i,f=/^0b[01]+$/i,c=/^0o[0-7]+$/i,l=parseInt;function n(i){if(typeof i=="number")return i;if(o(i))return a;if(r(i)){var g=typeof i.valueOf=="function"?i.valueOf():i;i=r(g)?g+"":g}if(typeof i!="string")return i===0?i:+i;i=t(i);var h=f.test(i);return h||c.test(i)?l(i.slice(2),h?2:8):s.test(i)?a:+i}return ee=n,ee}var te,be;function Ye(){if(be)return te;be=1;var t=we(),r=Be(),o=Xe(),a="Expected a function",s=Math.max,f=Math.min;function c(l,n,i){var g,h,R,k,_,T,S=0,re=!1,I=!1,M=!0;if(typeof l!="function")throw new TypeError(a);n=o(n)||0,t(i)&&(re=!!i.leading,I="maxWait"in i,R=I?s(o(i.maxWait)||0,n):R,M="trailing"in i?!!i.trailing:M);function A(u){var w=g,O=h;return g=h=void 0,S=u,k=l.apply(O,w),k}function $e(u){return S=u,_=setTimeout(E,n),re?A(u):k}function je(u){var w=u-T,O=u-S,ne=n-w;return I?f(ne,R-O):ne}function ie(u){var w=u-T,O=u-S;return T===void 0||w>=n||w<0||I&&O>=R}function E(){var u=r();if(ie(u))return oe(u);_=setTimeout(E,je(u))}function oe(u){return _=void 0,M&&g?A(u):(g=h=void 0,k)}function Se(){_!==void 0&&clearTimeout(_),S=0,g=T=h=_=void 0}function Ie(){return _===void 0?k:oe(r())}function G(){var u=r(),w=ie(u);if(g=arguments,h=this,T=u,w){if(_===void 0)return $e(T);if(I)return clearTimeout(_),_=setTimeout(E,n),A(T)}return _===void 0&&(_=setTimeout(E,n)),k}return G.cancel=Se,G.flush=Ie,G}return te=c,te}var Ke=Ye();const Qe=Oe(Ke),Ze={class:"bg-white p-4 rounded-lg shadow"},et={class:"grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4"},tt=["value"],st={class:"flex items-end space-x-2"},rt={__name:"Filters",props:{filters:{type:Object,default:()=>({})},types:{type:Object,required:!0}},emits:["filter"],setup(t,{emit:r}){const o=t,a=r,s=q({search:o.filters.search||"",type:o.filters.type||"",from_date:o.filters.from_date||"",to_date:o.filters.to_date||""}),f=()=>{a("filter",s.value)},c=()=>{s.value={search:"",type:"",from_date:"",to_date:""},a("filter",s.value)};return qe(()=>s.value.search,Qe(l=>{a("filter",s.value)},300)),(l,n)=>(d(),v("div",Ze,[e("form",{onSubmit:Re(f,["prevent"])},[e("div",et,[e("div",null,[n[4]||(n[4]=e("label",{class:"block text-sm font-medium text-gray-700"}," Search ",-1)),N(e("input",{type:"text","onUpdate:modelValue":n[0]||(n[0]=i=>s.value.search=i),class:"mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm",placeholder:"Search logs..."},null,512),[[B,s.value.search]])]),e("div",null,[n[6]||(n[6]=e("label",{class:"block text-sm font-medium text-gray-700"}," Type ",-1)),N(e("select",{"onUpdate:modelValue":n[1]||(n[1]=i=>s.value.type=i),class:"mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"},[n[5]||(n[5]=e("option",{value:""},"All Types",-1)),(d(!0),v(F,null,se(t.types,(i,g)=>(d(),v("option",{key:g,value:g},x(i),9,tt))),128))],512),[[Ce,s.value.type]])]),e("div",null,[n[7]||(n[7]=e("label",{class:"block text-sm font-medium text-gray-700"}," From Date ",-1)),N(e("input",{type:"date","onUpdate:modelValue":n[2]||(n[2]=i=>s.value.from_date=i),class:"mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"},null,512),[[B,s.value.from_date]])]),e("div",null,[n[8]||(n[8]=e("label",{class:"block text-sm font-medium text-gray-700"}," To Date ",-1)),N(e("input",{type:"date","onUpdate:modelValue":n[3]||(n[3]=i=>s.value.to_date=i),class:"mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"},null,512),[[B,s.value.to_date]])]),e("div",st,[m(C,{type:"submit",class:"w-full"},{icon:p(()=>[m(y(b.FilterIcon),{class:"w-4 h-4"})]),default:p(()=>[n[9]||(n[9]=j(" Filter "))]),_:1}),m(C,{type:"button",onClick:c,variant:"secondary",class:"w-full"},{icon:p(()=>[m(y(b.RefreshIcon),{class:"w-4 h-4"})]),default:p(()=>[n[10]||(n[10]=j(" Reset "))]),_:1})])])],32)]))}},it={class:"grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4"},ot={class:"bg-white overflow-hidden shadow rounded-lg"},nt={class:"p-5"},at={class:"flex items-center"},lt={class:"flex-shrink-0"},dt={class:"ml-5 w-0 flex-1"},ct={class:"flex items-baseline"},ut={class:"text-2xl font-semibold text-gray-900"},mt={class:"bg-white overflow-hidden shadow rounded-lg"},ft={class:"p-5"},gt={class:"flex items-center"},xt={class:"flex-shrink-0"},vt={class:"ml-5 w-0 flex-1"},pt={class:"flex items-baseline"},_t={class:"text-2xl font-semibold text-gray-900"},yt={class:"bg-white overflow-hidden shadow rounded-lg"},ht={class:"p-5"},bt={class:"flex items-center"},wt={class:"flex-shrink-0"},Tt={class:"ml-5 w-0 flex-1"},kt={class:"flex items-baseline"},$t={class:"text-2xl font-semibold text-gray-900"},jt={class:"bg-white overflow-hidden shadow rounded-lg"},St={class:"p-5"},It={class:"flex items-center"},Ot={class:"flex-shrink-0"},qt={class:"ml-5 w-0 flex-1"},Ct={class:"flex items-baseline"},Rt={class:"text-2xl font-semibold text-gray-900"},Et={__name:"Stats",props:{stats:{type:Object,required:!0}},setup(t){return(r,o)=>(d(),v("div",it,[e("div",ot,[e("div",nt,[e("div",at,[e("div",lt,[m(y(b.DocumentTextIcon),{class:"h-6 w-6 text-gray-400"})]),e("div",dt,[e("dl",null,[o[0]||(o[0]=e("dt",{class:"text-sm font-medium text-gray-500 truncate"}," Total Logs ",-1)),e("dd",ct,[e("div",ut,x(t.stats.total),1)])])])])])]),e("div",mt,[e("div",ft,[e("div",gt,[e("div",xt,[m(y(b.ClockIcon),{class:"h-6 w-6 text-gray-400"})]),e("div",vt,[e("dl",null,[o[1]||(o[1]=e("dt",{class:"text-sm font-medium text-gray-500 truncate"}," Today's Logs ",-1)),e("dd",pt,[e("div",_t,x(t.stats.today),1)])])])])])]),e("div",yt,[e("div",ht,[e("div",bt,[e("div",wt,[m(y(b.CalendarIcon),{class:"h-6 w-6 text-gray-400"})]),e("div",Tt,[e("dl",null,[o[2]||(o[2]=e("dt",{class:"text-sm font-medium text-gray-500 truncate"}," This Week ",-1)),e("dd",kt,[e("div",$t,x(t.stats.this_week),1)])])])])])]),e("div",jt,[e("div",St,[e("div",It,[e("div",Ot,[m(y(b.ChartBarIcon),{class:"h-6 w-6 text-gray-400"})]),e("div",qt,[e("dl",null,[o[3]||(o[3]=e("dt",{class:"text-sm font-medium text-gray-500 truncate"}," This Month ",-1)),e("dd",Ct,[e("div",Rt,x(t.stats.this_month),1)])])])])])])]))}},Lt={},Nt={class:"animate-spin h-5 w-5 text-indigo-600",xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24"};function Dt(t,r){return d(),v("svg",Nt,r[0]||(r[0]=[e("circle",{class:"opacity-25",cx:"12",cy:"12",r:"10",stroke:"currentColor","stroke-width":"4"},null,-1),e("path",{class:"opacity-75",fill:"currentColor",d:"M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"},null,-1)]))}const Ft=De(Lt,[["render",Dt]]),Mt={class:"flex flex-col"},At={class:"-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8"},Gt={class:"py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8"},Bt={class:"shadow overflow-hidden border-b border-gray-200 sm:rounded-lg"},Pt={class:"min-w-full divide-y divide-gray-200"},Vt={class:"bg-white divide-y divide-gray-200"},Ut={key:0},Wt={colspan:"6",class:"px-6 py-4 text-center"},Ht={key:1},zt={class:"px-6 py-4 whitespace-nowrap"},Jt={class:"px-6 py-4"},Xt={class:"text-sm text-gray-900"},Yt={class:"px-6 py-4 whitespace-nowrap"},Kt={class:"flex items-center"},Qt={key:0,class:"flex-shrink-0 h-8 w-8"},Zt=["src","alt"],es={class:"ml-2"},ts={class:"text-sm font-medium text-gray-900"},ss={class:"text-sm text-gray-500"},rs={class:"px-6 py-4 whitespace-nowrap text-sm text-gray-500"},is={class:"px-6 py-4 whitespace-nowrap"},os={class:"text-sm text-gray-900"},ns={class:"text-sm text-gray-500"},as={class:"px-6 py-4 whitespace-nowrap text-right text-sm font-medium"},ls={class:"space-y-4"},ds={class:"mt-1 text-sm text-gray-900"},cs={class:"mt-1 text-sm text-gray-900"},us={key:0},ms={class:"mt-1 text-sm text-gray-900 bg-gray-50 p-4 rounded-md overflow-auto"},fs={__name:"Table",props:{logs:{type:Array,required:!0},loading:{type:Boolean,default:!1}},setup(t){const r=q(null),o=a=>{r.value=a};return(a,s)=>{var f,c;return d(),v("div",Mt,[e("div",At,[e("div",Gt,[e("div",Bt,[e("table",Pt,[s[3]||(s[3]=e("thead",{class:"bg-gray-50"},[e("tr",null,[e("th",{scope:"col",class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"}," Type "),e("th",{scope:"col",class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"}," Description "),e("th",{scope:"col",class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"}," User "),e("th",{scope:"col",class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"}," IP Address "),e("th",{scope:"col",class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"}," Date "),e("th",{scope:"col",class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"}," Details ")])],-1)),e("tbody",Vt,[t.loading?(d(),v("tr",Ut,[e("td",Wt,[m(Ft)])])):t.logs.length?$("",!0):(d(),v("tr",Ht,s[1]||(s[1]=[e("td",{colspan:"6",class:"px-6 py-4 text-center text-gray-500"}," No activity logs found. ",-1)]))),(d(!0),v(F,null,se(t.logs,l=>(d(),v("tr",{key:l.id},[e("td",zt,[m(Me,{color:l.type.color},{default:p(()=>[j(x(l.type.text),1)]),_:2},1032,["color"])]),e("td",Jt,[e("div",Xt,x(l.description),1)]),e("td",Yt,[e("div",Kt,[l.user.avatar?(d(),v("div",Qt,[e("img",{class:"h-8 w-8 rounded-full",src:l.user.avatar,alt:l.user.name},null,8,Zt)])):$("",!0),e("div",es,[e("div",ts,x(l.user.name),1),e("div",ss,x(l.user.email),1)])])]),e("td",rs,x(l.ip_address),1),e("td",is,[e("div",os,x(l.time_ago),1),e("div",ns,x(l.created_at),1)]),e("td",as,[m(C,{variant:"secondary",onClick:n=>o(l)},{icon:p(()=>[m(y(b.InformationCircleIcon),{class:"w-4 h-4"})]),default:p(()=>[s[2]||(s[2]=j(" Details "))]),_:2},1032,["onClick"])])]))),128))])])])])]),m(Ae,{show:!!r.value,onClose:s[0]||(s[0]=l=>r.value=null),title:(c=(f=r.value)==null?void 0:f.type)==null?void 0:c.text},{default:p(()=>{var l,n,i;return[e("div",ls,[e("div",null,[s[4]||(s[4]=e("h4",{class:"text-sm font-medium text-gray-500"},"Description",-1)),e("p",ds,x((l=r.value)==null?void 0:l.description),1)]),e("div",null,[s[5]||(s[5]=e("h4",{class:"text-sm font-medium text-gray-500"},"User Agent",-1)),e("p",cs,x((n=r.value)==null?void 0:n.user_agent),1)]),(i=r.value)!=null&&i.metadata?(d(),v("div",us,[s[6]||(s[6]=e("h4",{class:"text-sm font-medium text-gray-500"},"Metadata",-1)),e("pre",ms,"            "+x(JSON.stringify(r.value.metadata,null,2))+`
          `,1)])):$("",!0)])]}),_:1},8,["show","title"])])}}},gs={key:0,class:"flex flex-wrap -mb-1"},xs=["innerHTML"],vs={__name:"Pagination",props:{links:Array},setup(t){return(r,o)=>t.links.length>3?(d(),v("div",gs,[(d(!0),v(F,null,se(t.links,(a,s)=>(d(),v(F,{key:s},[a.url===null?(d(),v("div",{key:0,class:"mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded",innerHTML:a.label},null,8,xs)):(d(),D(y(Le),{key:1,class:Ee(["mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-indigo-500 focus:text-indigo-500",{"bg-white":a.active}]),href:a.url,innerHTML:a.label},null,8,["class","href","innerHTML"]))],64))),128))])):$("",!0)}},ps={class:"py-12"},_s={class:"mx-auto max-w-7xl sm:px-6 lg:px-8"},ys={class:"overflow-hidden bg-white shadow-sm sm:rounded-lg"},hs={class:"p-6 bg-white border-b border-gray-200"},bs={class:"mb-6"},ws={class:"mb-6"},Ts={class:"mb-6 flex justify-end space-x-4"},ks={class:"overflow-x-auto"},$s={class:"mt-6"},Fs={__name:"Index",props:{logs:Object,filters:Object,types:Object,stats:Object,can:Object},setup(t){const r=t,o=q(!1),a=q(!1),s=q(!1),{showToast:f}=Fe(),c=i=>{o.value=!0,Inertia.get(route("activity-logs.index"),{...i},{preserveState:!0,preserveScroll:!0,onFinish:()=>{o.value=!1}})},l=async()=>{try{a.value=!0,await ae.post(route("activity-logs.export"),r.filters),f({type:"success",message:"Export started. You will be notified when it is completed."})}catch{f({type:"error",message:"Failed to start export."})}finally{a.value=!1}},n=async()=>{if(confirm("Are you sure you want to clean up old activity logs?"))try{s.value=!0;const i=await ae.post(route("activity-logs.cleanup"));f({type:"success",message:i.data.message}),Inertia.reload()}catch{f({type:"error",message:"Failed to clean up activity logs."})}finally{s.value=!1}};return(i,g)=>(d(),D(Ne,{title:"Activity Logs"},{header:p(()=>g[0]||(g[0]=[e("h2",{class:"text-xl font-semibold leading-tight text-gray-800"}," Activity Logs ",-1)])),default:p(()=>[e("div",ps,[e("div",_s,[e("div",ys,[e("div",hs,[e("div",bs,[m(rt,{filters:t.filters,types:t.types,onFilter:c},null,8,["filters","types"])]),e("div",ws,[m(Et,{stats:t.stats},null,8,["stats"])]),e("div",Ts,[t.can.export?(d(),D(C,{key:0,onClick:l,disabled:a.value},{icon:p(()=>[m(y(b.DownloadIcon),{class:"w-4 h-4"})]),default:p(()=>[j(" "+x(a.value?"Exporting...":"Export"),1)]),_:1},8,["disabled"])):$("",!0),t.can.cleanup?(d(),D(C,{key:1,onClick:n,disabled:s.value,variant:"danger"},{icon:p(()=>[m(y(b.TrashIcon),{class:"w-4 h-4"})]),default:p(()=>[j(" "+x(s.value?"Cleaning...":"Cleanup"),1)]),_:1},8,["disabled"])):$("",!0)]),e("div",ks,[m(fs,{logs:t.logs.data,loading:o.value},null,8,["logs","loading"])]),e("div",$s,[m(vs,{links:t.logs.meta.links},null,8,["links"])])])])])])]),_:1}))}};export{Fs as default};