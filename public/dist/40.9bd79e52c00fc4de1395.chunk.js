webpackJsonp([40],{286:function(e,t,r){"use strict";function n(e){u||r(979)}Object.defineProperty(t,"__esModule",{value:!0});var o=r(981),a=r.n(o),i=r(982),s=r.n(i),u=!1,d=r(1),l=n,c=d(a.a,s.a,!1,l,null,null);c.options.__file="src\\views\\advanced-router\\mutative-router.vue",c.esModule&&Object.keys(c.esModule).some(function(e){return"default"!==e&&"__"!==e.substr(0,2)})&&console.error("named exports are not supported in *.vue files."),t.default=c.exports},979:function(e,t,r){var n=r(980);"string"==typeof n&&(n=[[e.i,n,""]]),n.locals&&(e.exports=n.locals);r(17)("5cf45506",n,!1)},980:function(e,t,r){t=e.exports=r(16)(void 0),t.push([e.i,"\n.advanced-router {\n  height: 240px !important;\n}\n.advanced-router-tip-p {\n  padding: 10px 0;\n}\n",""])},981:function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default={name:"mutative-router",data:function(){var e=this;return{orderColumns:[{type:"index",title:"序号",width:60},{title:"订单号",key:"order_id",align:"center"},{title:"用户",key:"user_name"},{title:"详情",key:"show_more",align:"center",render:function(t,r){return t("Button",{props:{type:"text",size:"small"},on:{click:function(){var t={order_id:r.row.order_id};e.$router.push({name:"order-info",params:t})}}},"了解详情")}}],orderData:[{order_id:"1000001",user_name:"Aresn"},{order_id:"1000002",user_name:"Lison"},{order_id:"1000003",user_name:"lili"},{order_id:"1000004",user_name:"lala"}]}},computed:{avatorImage:function(){return localStorage.avatorImgPath}}}},982:function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var n=function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",[r("Row",[r("Col",{attrs:{span:"24"}},[r("Card",[r("p",{attrs:{slot:"title"},slot:"title"},[r("Icon",{attrs:{type:"ios-list"}}),e._v("\n                    订单详情(动态路由)\n                ")],1),e._v(" "),r("Row",{staticClass:"advanced-router",attrs:{type:"flex",justify:"center",align:"middle"}},[r("Table",{staticStyle:{width:"100%"},attrs:{columns:e.orderColumns,data:e.orderData}})],1)],1)],1)],1)],1)},o=[];n._withStripped=!0;var a={render:n,staticRenderFns:o};t.default=a}});