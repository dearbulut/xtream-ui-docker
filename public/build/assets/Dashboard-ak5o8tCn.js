import{r as n,z as c,m as h,i as d,o as a,b as t,h as v,u as x,q as m,a as r,j as w,t as o}from"./app-wF5SolYh.js";import{_ as g}from"./AppLayout-DCUwBhsa.js";/* empty css            */import"./useToast-BYzZ-uBf.js";import"./XMarkIcon-BhqYf4eJ.js";const u={class:"py-12"},_={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},f={key:0,class:"text-center"},p={key:1,class:"grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3"},k={class:"bg-white overflow-hidden shadow rounded-lg"},y={class:"p-5"},M={class:"flex items-center"},b={class:"ml-5 w-0 flex-1"},C={class:"flex items-baseline"},B={class:"text-2xl font-semibold text-gray-900"},V={class:"ml-2"},z={class:"text-sm font-medium text-green-600"},H={class:"bg-white overflow-hidden shadow rounded-lg"},j={class:"p-5"},T={class:"flex items-center"},D={class:"ml-5 w-0 flex-1"},S={class:"text-2xl font-semibold text-gray-900"},A={class:"bg-white overflow-hidden shadow rounded-lg"},L={class:"p-5"},N={class:"flex items-center"},U={class:"ml-5 w-0 flex-1"},E={class:"text-2xl font-semibold text-gray-900"},q={class:"bg-white overflow-hidden shadow rounded-lg"},$={class:"p-5"},F={class:"flex items-center"},G={class:"ml-5 w-0 flex-1"},I={class:"text-2xl font-semibold text-gray-900"},J={class:"bg-white overflow-hidden shadow rounded-lg"},K={class:"p-5"},O={class:"flex items-center"},P={class:"ml-5 w-0 flex-1"},Q={class:"text-2xl font-semibold text-gray-900"},st={__name:"Dashboard",setup(R){const e=n({totalChannels:0,activeChannels:0,totalMovies:0,totalSeries:0,totalCategories:0,totalUsers:0}),i=n(!0);return c(async()=>{try{const l=await window.xtreamApi.get("/panel_api.php",{params:{action:"get_dashboard_stats"}});e.value=l.data}catch(l){console.error("Error fetching dashboard stats:",l)}finally{i.value=!1}}),(l,s)=>(a(),h(g,null,{header:d(()=>s[0]||(s[0]=[t("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"}," Dashboard ",-1)])),default:d(()=>[v(x(m),{title:"Dashboard"}),t("div",u,[t("div",_,[i.value?(a(),r("div",f,s[1]||(s[1]=[t("div",{class:"inline-flex items-center px-4 py-2 font-semibold leading-6 text-sm text-gray-500"},[t("svg",{class:"animate-spin -ml-1 mr-3 h-5 w-5 text-gray-500",xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24"},[t("circle",{class:"opacity-25",cx:"12",cy:"12",r:"10",stroke:"currentColor","stroke-width":"4"}),t("path",{class:"opacity-75",fill:"currentColor",d:"M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"})]),w(" Loading... ")],-1)]))):(a(),r("div",p,[t("div",k,[t("div",y,[t("div",M,[s[3]||(s[3]=t("div",{class:"flex-shrink-0"},[t("svg",{class:"h-6 w-6 text-gray-400",xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24",stroke:"currentColor"},[t("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"})])],-1)),t("div",b,[t("dl",null,[s[2]||(s[2]=t("dt",{class:"text-sm font-medium text-gray-500 truncate"}," Total Channels ",-1)),t("dd",C,[t("div",B,o(e.value.totalChannels),1),t("div",V,[t("span",z,o(e.value.activeChannels)+" active ",1)])])])])])])]),t("div",H,[t("div",j,[t("div",T,[s[5]||(s[5]=t("div",{class:"flex-shrink-0"},[t("svg",{class:"h-6 w-6 text-gray-400",xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24",stroke:"currentColor"},[t("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"})])],-1)),t("div",D,[t("dl",null,[s[4]||(s[4]=t("dt",{class:"text-sm font-medium text-gray-500 truncate"}," Total Movies ",-1)),t("dd",S,o(e.value.totalMovies),1)])])])])]),t("div",A,[t("div",L,[t("div",N,[s[7]||(s[7]=t("div",{class:"flex-shrink-0"},[t("svg",{class:"h-6 w-6 text-gray-400",xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24",stroke:"currentColor"},[t("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"})])],-1)),t("div",U,[t("dl",null,[s[6]||(s[6]=t("dt",{class:"text-sm font-medium text-gray-500 truncate"}," Total Series ",-1)),t("dd",E,o(e.value.totalSeries),1)])])])])]),t("div",q,[t("div",$,[t("div",F,[s[9]||(s[9]=t("div",{class:"flex-shrink-0"},[t("svg",{class:"h-6 w-6 text-gray-400",xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24",stroke:"currentColor"},[t("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"})])],-1)),t("div",G,[t("dl",null,[s[8]||(s[8]=t("dt",{class:"text-sm font-medium text-gray-500 truncate"}," Total Categories ",-1)),t("dd",I,o(e.value.totalCategories),1)])])])])]),t("div",J,[t("div",K,[t("div",O,[s[11]||(s[11]=t("div",{class:"flex-shrink-0"},[t("svg",{class:"h-6 w-6 text-gray-400",xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24",stroke:"currentColor"},[t("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"})])],-1)),t("div",P,[t("dl",null,[s[10]||(s[10]=t("dt",{class:"text-sm font-medium text-gray-500 truncate"}," Total Users ",-1)),t("dd",Q,o(e.value.totalUsers),1)])])])])])]))])])]),_:1}))}};export{st as default};