webpackJsonp([27],{1020:function(t,e,a){var n=a(1021);"string"==typeof n&&(n=[[t.i,n,""]]),n.locals&&(t.exports=n.locals);a(17)("154c798d",n,!1)},1021:function(t,e,a){e=t.exports=a(16)(void 0),e.push([t.i,"\n.top {\n    margin-top: 15px\n}\n.pages {\n    text-align: right;\n    margin-top: 10px;\n    padding-right: 10px;\n}\n.form {\n    margin-right: 20px;\n}\n.be-inline-block {\n    /*display: inline-block;*/\n    /*line-height: 50px;*/\n    vertical-align: middle;\n}\n.button-warp{\n   /* margin-bottom: 15px;*/\n}\n.be-inline-block .btn{\n    margin-right: 15px;\n}\n.be-inline-block  .searth-input .ivu-input{\n    border-radius: 32px;\n}\n.demo-upload-list{\n    display: inline-block;\n    width: 60px;\n    height: 60px;\n    text-align: center;\n    line-height: 60px;\n    border: 1px solid transparent;\n    border-radius: 4px;\n    overflow: hidden;\n    background: #fff;\n    position: relative;\n    box-shadow: 0 1px 1px rgba(0,0,0,.2);\n    margin-right: 4px;\n}\n.demo-upload-list img{\n    width: 100%;\n    height: 100%;\n}\n",""])},1022:function(t,e,a){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var n=a(87),i=function(t){return t&&t.__esModule?t:{default:t}}(n),o=a(86),s=a(88),l=a(312);e.default={name:"ad-space-lists",data:function(){var t=this;return{tableTotal:20,current:1,loading:!0,columns:[{title:"编号",key:"id",width:100},{title:"广告位",key:"title"},{title:"展示位",key:"show_img",render:function(t,e){return""!=e.row.show_img?t("Img",{attrs:{src:s.base+e.row.show_img},style:{width:"100px","margin-top":"5px",height:"100px"}}):"null"}},{title:"数据模型",key:"model"},{title:"状态",key:"status",render:function(t,e){return 0==e.row.status?"正常":t("Font",{style:{color:"red"}},"关闭")}},{title:"备注",key:"remarks"},{title:"操作",key:"action",width:300,align:"center",render:function(e,a){return e("div",[(0,l.editButton)(function(){t.showCreate(a.row.id)},e),(0,l.deleteButton)(function(){t.remove(a.index,a.row.id)},e)])}}],data:[],searchParam:{},formItem:{},adModel:[],adFlag:!1,adTitle:"新增",ad:{id:0,title:"",show_img:"",model:"",remarks:"",status:0},uploadApiAction:o.uploadApiAction,defaultList:[],imgName:"",uploadList:[]}},mounted:function(){this.getDataList(),this.getAdModel(),this.uploadList=this.$refs.upload.fileList},methods:{getDataList:function(){var t=this;this.loading=!0;var e={page:this.current};(0,o.adSpaceListsAction)(e).then(function(e){t.loading=!1,t.data=e.data.list,t.tableTotal=e.data.total,console.log(t.data)}).catch(function(t){console.log(t)})},cancel:function(){},changePage:function(t){console.log(t),this.current=t,this.data=this.getDataList()},search:function(){this.searchParam=this.formItem,this.current=1,this.getDataList()},updateAd:function(){var t=this,e=this.ad;(0,o.adSpaceSaveAction)(e).then(function(e){console.log(e),t.$Message.info(e.data.msg),t.getDataList()}).catch(function(t){console.log(t)})},getAdModel:function(){var t=this,e={};(0,o.adSpaceGetAdModelAction)(e).then(function(e){t.adModel=e.data.list}).catch(function(t){console.log(t)})},showCreate:function(t){var e=this;if(this.adFlag=!0,t>0){this.adTitle="更改";var a={id:t};(0,o.adSpaceGetAction)(a).then(function(t){e.ad=(0,i.default)({},e.ad,{id:t.data.info.id,title:t.data.info.title,show_img:t.data.info.show_img,model:t.data.info.model,remarks:t.data.info.remarks,status:t.data.info.status}),""!=t.data.info.show_img?(e.defaultList=[],e.defaultList=e.defaultList.concat([{name:"图片",url:s.base+t.data.info.show_img,status:"finished"}]),e.uploadList=[(0,i.default)({},e.defaultList[0])]):e.uploadList=[]}).catch(function(t){console.log(t)})}else this.adTitle="新增",this.ad={}},remove:function(t,e){var a=this,n={id:e};(0,o.adSpaceDelAction)(n).then(function(e){a.$Message.info(e.data.msg),a.data.splice(t,1)}).catch(function(t){this.$Message.info("删除失败")})},handleSuccess:function(t,e){e.url=s.base+t.data.info,e.name="图片",this.ad.show_img=t.data.info,this.uploadList=[(0,i.default)({},e)]},handleFormatError:function(t){this.$Notice.warning({title:"格式",desc:"目前支持jpg、jpeg、png格式图片"})},handleMaxSize:function(t){this.$Notice.warning({title:"超出大小",desc:"最大为2M."})},handleBeforeUpload:function(){var t=this.uploadList.length<2;return t||this.$Notice.warning({title:"最多只能上传一张."}),t}}}},1023:function(t,e,a){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var n=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("Row",{attrs:{gutter:10}},[a("Col",{attrs:{span:"24"}},[a("Card",[a("p",{attrs:{slot:"title"},slot:"title"},[a("Icon",{attrs:{type:"pinpoint"}}),t._v("\n                广告位列表\n          ")],1),t._v(" "),a("Row",[a("Col",{attrs:{span:"16"}},[a("Row",{staticStyle:{"margin-bottom":"15px"},attrs:{justify:"center",align:"bottom"}},[a("Col",{attrs:{span:"3"}},[a("Button",{staticClass:"btn",attrs:{type:"primary",shape:"circle",icon:"plus-round"},on:{click:function(e){t.showCreate()}}},[t._v("新增")])],1)],1)],1)],1),t._v(" "),a("Row",[a("Col",{staticClass:"main-inner-content",attrs:{span:"24"}},[a("Table",{attrs:{stripe:"",columns:t.columns,data:t.data}})],1)],1),t._v(" "),a("Row",[a("Col",{staticClass:"pages",attrs:{span:"24"}},[a("Page",{attrs:{total:t.tableTotal,"page-size":20,current:1,"show-elevator":""},on:{"on-change":t.changePage}})],1)],1),t._v(" "),a("Modal",{attrs:{title:t.adTitle},on:{"on-ok":t.updateAd,"on-cancel":t.cancel},model:{value:t.adFlag,callback:function(e){t.adFlag=e},expression:"adFlag"}},[a("Form",{ref:"ad",staticClass:"form",attrs:{model:t.ad,"label-width":80}},[a("Form-item",{attrs:{label:"广告位标题",prop:"title"}},[a("Input",{attrs:{placeholder:"请输入广告位标题"},model:{value:t.ad.title,callback:function(e){t.$set(t.ad,"title",e)},expression:"ad.title"}})],1),t._v(" "),a("Form-item",{attrs:{label:"展示位",prop:"type"}},[[t._l(t.uploadList,function(e){return a("div",{staticClass:"demo-upload-list"},["finished"===e.status?[a("img",{attrs:{src:e.url}})]:[e.showProgress?a("Progress",{attrs:{percent:e.percentage,"hide-info":""}}):t._e()]],2)}),t._v(" "),a("Upload",{ref:"upload",staticStyle:{display:"inline-block",width:"58px"},attrs:{"show-upload-list":!1,"default-file-list":t.defaultList,"on-success":t.handleSuccess,format:["jpg","jpeg","png"],"max-size":2048,"on-format-error":t.handleFormatError,"on-exceeded-size":t.handleMaxSize,"before-upload":t.handleBeforeUpload,type:"drag",action:t.uploadApiAction}},[a("div",{staticStyle:{width:"58px",height:"58px","line-height":"58px"}},[a("Icon",{attrs:{type:"camera",size:"20"}})],1)])]],2),t._v(" "),a("Form-item",{attrs:{label:"数据模型",prop:"type"}},[a("Select",{model:{value:t.ad.model,callback:function(e){t.$set(t.ad,"model",e)},expression:"ad.model"}},t._l(t.adModel,function(e){return a("Option",{key:e.id,attrs:{value:e.id}},[t._v(t._s(e.title))])}))],1),t._v(" "),a("Form-item",{attrs:{label:"状态",prop:"type"}},[a("Select",{model:{value:t.ad.status,callback:function(e){t.$set(t.ad,"status",e)},expression:"ad.status"}},[a("Option",{attrs:{value:0}},[t._v("正常")]),t._v(" "),a("Option",{attrs:{value:1}},[t._v("冻结")])],1)],1),t._v(" "),a("Form-item",{attrs:{label:"备注",prop:"remarks"}},[a("Input",{attrs:{type:"textarea",autosize:{minRows:2,maxRows:5},placeholder:"请输入备注"},model:{value:t.ad.remarks,callback:function(e){t.$set(t.ad,"remarks",e)},expression:"ad.remarks"}})],1)],1)],1)],1)],1)],1)},i=[];n._withStripped=!0;var o={render:n,staticRenderFns:i};e.default=o},295:function(t,e,a){"use strict";function n(t){r||a(1020)}Object.defineProperty(e,"__esModule",{value:!0});var i=a(1022),o=a.n(i),s=a(1023),l=a.n(s),r=!1,d=a(1),c=n,u=d(o.a,l.a,!1,c,null,null);u.options.__file="src\\views\\ad\\AdSpaceLists.vue",u.esModule&&Object.keys(u.esModule).some(function(t){return"default"!==t&&"__"!==t.substr(0,2)})&&console.error("named exports are not supported in *.vue files."),e.default=u.exports},312:function(t,e,a){"use strict";Object.defineProperty(e,"__esModule",{value:!0});e.deleteButton=function(t,e){return e("Poptip",{props:{confirm:!0,title:"您确定要删除这条数据吗?",transfer:!0},on:{"on-ok":function(){t()}}},[e("Button",{style:{margin:"0 5px"},props:{type:"error",placement:"top",size:"small",icon:"trash-a"}},"删除")])},e.detailsButton=function(t,e){return e("Button",{props:{type:"primary",icon:"ios-eye-outline",size:"small"},style:{marginRight:"5px"},on:{click:function(){t()}}},"查看")},e.editButton=function(t,e){return e("Button",{props:{type:"primary",icon:"edit",size:"small"},style:{marginRight:"5px"},on:{click:function(){t()}}},"编辑")}}});