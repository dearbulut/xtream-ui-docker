import{o as t,a as l,y as n,n as o}from"./app-wF5SolYh.js";const c={__name:"Badge",props:{color:{type:String,default:"gray",validator:e=>["gray","danger","warning","success","info","primary","purple","pink"].includes(e)}},setup(e){return(r,a)=>(t(),l("span",{class:o(["inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium",{"bg-gray-100 text-gray-800":e.color==="gray","bg-red-100 text-red-800":e.color==="danger","bg-yellow-100 text-yellow-800":e.color==="warning","bg-green-100 text-green-800":e.color==="success","bg-blue-100 text-blue-800":e.color==="info","bg-indigo-100 text-indigo-800":e.color==="primary","bg-purple-100 text-purple-800":e.color==="purple","bg-pink-100 text-pink-800":e.color==="pink"}])},[n(r.$slots,"default")],2))}};export{c as _};