(window.webpackJsonp=window.webpackJsonp||[]).push([[28],{"5GCj":function(t,e,s){"use strict";s.r(e);var n={data:function(){return{record:{id:"",name:""},errors:[],records:[],columns:["name","id"]}},methods:{reset:function(){this.record={id:"",name:""}}},created:function(){this.table_options.headings={name:"Nombre",id:"Acción"},this.table_options.sortable=["name"],this.table_options.filterable=["name"],this.table_options.columnsClasses={name:"col-xs-10",id:"col-xs-2"}}},i=s("KHd+"),o=Object(i.a)(n,(function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"col-xs-2 text-center"},[s("a",{staticClass:"btn-simplex btn-simplex-md btn-simplex-primary",attrs:{href:"#",title:"Registros de las Funciones de Uso de los Bienes","data-toggle":"tooltip"},on:{click:function(e){return t.addRecord("add_use_function","use-functions",e)}}},[s("i",{staticClass:"icofont icofont-read-book ico-3x"}),t._v(" "),s("span",[t._v("Funciones de Uso")])]),t._v(" "),s("div",{staticClass:"modal fade text-left",attrs:{tabindex:"-1",role:"dialog",id:"add_use_function"}},[s("div",{staticClass:"modal-dialog vue-crud",attrs:{role:"document"}},[s("div",{staticClass:"modal-content"},[t._m(0),t._v(" "),s("div",{staticClass:"modal-body"},[t.errors.length>0?s("div",{staticClass:"alert alert-danger"},[s("div",{staticClass:"container"},[t._m(1),t._v(" "),s("strong",[t._v("Cuidado!")]),t._v(" Debe verificar los siguientes errores antes de continuar:\n                            "),s("button",{staticClass:"close",attrs:{type:"button","data-dismiss":"alert","aria-label":"Close"},on:{click:function(e){e.preventDefault(),t.errors=[]}}},[t._m(2)]),t._v(" "),s("ul",t._l(t.errors,(function(e){return s("li",[t._v(t._s(e))])})),0)])]):t._e(),t._v(" "),s("div",{staticClass:"row"},[s("div",{staticClass:"col-md-6"},[s("div",{staticClass:"form-group is-required"},[s("label",[t._v("Función de Uso:")]),t._v(" "),s("input",{directives:[{name:"model",rawName:"v-model",value:t.record.name,expression:"record.name"}],staticClass:"form-control input-sm",attrs:{type:"text",placeholder:"Nombre de la función de uso","data-toggle":"tooltip",title:"Indique el nombre de la nueva función de uso de un bien (requerido)"},domProps:{value:t.record.name},on:{input:function(e){e.target.composing||t.$set(t.record,"name",e.target.value)}}}),t._v(" "),s("input",{directives:[{name:"model",rawName:"v-model",value:t.record.id,expression:"record.id"}],attrs:{type:"hidden"},domProps:{value:t.record.id},on:{input:function(e){e.target.composing||t.$set(t.record,"id",e.target.value)}}})])])])]),t._v(" "),s("div",{staticClass:"modal-footer"},[s("div",{staticClass:"form-group"},[s("modal-form-buttons",{attrs:{saveRoute:"asset/use-functions"}})],1)]),t._v(" "),s("div",{staticClass:"modal-body modal-table"},[s("hr"),t._v(" "),s("v-client-table",{attrs:{columns:t.columns,data:t.records,options:t.table_options},scopedSlots:t._u([{key:"id",fn:function(e){return s("div",{staticClass:"text-center"},[s("button",{staticClass:"btn btn-warning btn-xs btn-icon btn-action",attrs:{title:"Modificar registro","data-toggle":"tooltip",type:"button"},on:{click:function(s){return t.initUpdate(e.index,s)}}},[s("i",{staticClass:"fa fa-edit"})]),t._v(" "),s("button",{staticClass:"btn btn-danger btn-xs btn-icon btn-action",attrs:{title:"Eliminar registro","data-toggle":"tooltip",type:"button"},on:{click:function(s){return t.deleteRecord(e.index,"use-functions")}}},[s("i",{staticClass:"fa fa-trash-o"})])])}}])})],1)])])])])}),[function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"modal-header"},[e("button",{staticClass:"close",attrs:{type:"button","data-dismiss":"modal","aria-label":"Close"}},[e("span",{attrs:{"aria-hidden":"true"}},[this._v("×")])]),this._v(" "),e("h6",[e("i",{staticClass:"icofont icofont-read-book ico-2x"}),this._v("\n                        Nueva Función de Uso\n                    ")])])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"alert-icon"},[e("i",{staticClass:"now-ui-icons objects_support-17"})])},function(){var t=this.$createElement,e=this._self._c||t;return e("span",{attrs:{"aria-hidden":"true"}},[e("i",{staticClass:"now-ui-icons ui-1_simple-remove"})])}],!1,null,null,null);e.default=o.exports},"KHd+":function(t,e,s){"use strict";function n(t,e,s,n,i,o,a,r){var c,l="function"==typeof t?t.options:t;if(e&&(l.render=e,l.staticRenderFns=s,l._compiled=!0),n&&(l.functional=!0),o&&(l._scopeId="data-v-"+o),a?(c=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),i&&i.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(a)},l._ssrRegister=c):i&&(c=r?function(){i.call(this,(l.functional?this.parent:this).$root.$options.shadowRoot)}:i),c)if(l.functional){l._injectStyles=c;var d=l.render;l.render=function(t,e){return c.call(e),d(t,e)}}else{var u=l.beforeCreate;l.beforeCreate=u?[].concat(u,c):[c]}return{exports:t,options:l}}s.d(e,"a",(function(){return n}))}}]);