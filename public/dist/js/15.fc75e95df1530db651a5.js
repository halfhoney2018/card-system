webpackJsonp([15],{mkKm:function(e,t,a){"use strict";var o,l,s,i,n,r;Object.defineProperty(t,"__esModule",{value:!0}),o=a("Y81h"),l=a.n(o),s=a("V/8j"),i={components:{},data:function(){return{loading:!1,labelWidth:"0px",themes:[],form:{shop_theme:"",shop_theme_material_list_type:"",shop_theme_material_background:"",shop_theme_classic_list_type:""},formRules:{},themeMaterialNoBackground:!1}},watch:{loading:function(e,t){e?t||l.a.isStarted()||l.a.start():l.a.done()}},mounted:function(){this.getSet()},methods:{getSet:function(){var e=this;this.loading=!0,Object(s.g)().then(function(t){e.themes=t.data.themes,e.themes.forEach(function(t){"Material"===t.name?(e.form.shop_theme_material_list_type=t.config.list_type,e.form.shop_theme_material_background=t.config.background,e.themeMaterialNoBackground="0"===e.form.shop_theme_material_background):"Classic"===t.name&&(e.form.shop_theme_classic_list_type=t.config.list_type)}),e.form.shop_theme=t.data.default,e.loading=!1})},handleResetForm:function(){this.getSet()},handleSubmit:function(){var e=this;this.$refs.form.validate(function(t){t&&(e.loading=!0,e.themeMaterialNoBackground&&(e.form.shop_theme_material_background="0"),Object(s.g)(e.form).then(function(){e.loading=!1,e.$notify({title:"操作成功",message:"配置保存成功",type:"success"})}).catch(function(){e.loading=!1}))})}}},n={render:function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("el-card",[a("el-form",{directives:[{name:"loading",rawName:"v-loading.body",value:e.loading,expression:"loading",modifiers:{body:!0}}],ref:"form",attrs:{model:e.form,"label-width":e.labelWidth,rules:e.formRules}},[a("h2",{staticClass:"title"},[e._v("主题设置")]),e._v(" "),a("el-form-item",{staticClass:"item-container",attrs:{prop:"shop_theme"}},[a("span",{staticStyle:{display:"block"}},[e._v("默认主题")]),e._v(" "),a("el-select",{model:{value:e.form.shop_theme,callback:function(t){e.$set(e.form,"shop_theme",t)},expression:"form.shop_theme"}},e._l(e.themes,function(e){return a("el-option",{key:e.id,attrs:{label:e.name+" - "+e.description,value:e.name}})}))],1),e._v(" "),a("el-card",{directives:[{name:"show",rawName:"v-show",value:"Material"===e.form.shop_theme,expression:"form.shop_theme==='Material'"}],staticClass:"child-option"},[a("p",{staticClass:"child-option-title"},[e._v("默认主题设置")]),e._v(" "),a("el-form-item",{staticClass:"item-container"},[a("span",{staticStyle:{display:"block"}},[e._v("商品排列方式")]),e._v(" "),a("el-select",{model:{value:e.form.shop_theme_material_list_type,callback:function(t){e.$set(e.form,"shop_theme_material_list_type",t)},expression:"form.shop_theme_material_list_type"}},[a("el-option",{attrs:{value:"dropdown",label:"下拉式"}}),e._v(" "),a("el-option",{attrs:{value:"button",label:"按钮式"}})],1)],1),e._v(" "),a("el-form-item",{staticClass:"item-container"},[a("span",{staticStyle:{display:"block"}},[e._v("店铺背景")]),e._v(" "),a("el-input",{attrs:{type:"text",placeholder:"店铺背景(图片URL)",disabled:e.themeMaterialNoBackground},model:{value:e.form.shop_theme_material_background,callback:function(t){e.$set(e.form,"shop_theme_material_background",t)},expression:"form.shop_theme_material_background"}}),e._v(" "),a("el-checkbox",{attrs:{size:"small"},model:{value:e.themeMaterialNoBackground,callback:function(t){e.themeMaterialNoBackground=t},expression:"themeMaterialNoBackground"}},[e._v("\n          不显示背景图片\n        ")])],1)],1),e._v(" "),a("el-card",{directives:[{name:"show",rawName:"v-show",value:"Classic"===e.form.shop_theme,expression:"form.shop_theme==='Classic'"}],staticClass:"child-option"},[a("p",{staticClass:"child-option-title"},[e._v("默认主题设置")]),e._v(" "),a("el-form-item",{staticClass:"item-container"},[a("span",{staticStyle:{display:"block"}},[e._v("商品排列方式")]),e._v(" "),a("el-select",{model:{value:e.form.shop_theme_classic_list_type,callback:function(t){e.$set(e.form,"shop_theme_classic_list_type",t)},expression:"form.shop_theme_classic_list_type"}},[a("el-option",{attrs:{value:"dropdown",label:"下拉式"}}),e._v(" "),a("el-option",{attrs:{value:"button",label:"按钮式"}})],1)],1)],1)],1),e._v(" "),a("div",{staticClass:"text-center",staticStyle:{"margin-top":"24px"}},[a("el-button",{on:{click:e.handleResetForm}},[e._v("刷新")]),e._v(" "),a("el-button",{attrs:{type:"primary",loading:e.loading},nativeOn:{click:function(t){e.handleSubmit(t)}}},[e._v("保存更改")])],1)],1)},staticRenderFns:[]},r=a("VU/8")(i,n,!1,function(e){a("nJV7")},"data-v-1590af1a",null),t.default=r.exports},nJV7:function(e,t){}});