(window.webpackJsonp=window.webpackJsonp||[]).push([[5],{IOQ2:function(t,e,s){"use strict";s.r(e);var i={data:function(){return{record:{id:"",name:""},errors:[],records:[],columns:["name","id"]}},methods:{reset:function(){this.record={id:"",name:""}}},created:function(){this.table_options.headings={name:"Nombre",id:"Acción"},this.table_options.sortable=["name"],this.table_options.filterable=["name"],this.table_options.columnsClasses={name:"col-xs-10",id:"col-xs-2"}}},o=s("KHd+"),n=Object(o.a)(i,(function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"col-xs-2 text-center"},[s("a",{staticClass:"btn-simplex btn-simplex-md btn-simplex-primary",attrs:{href:"#",title:"Registros de Tipos de Bienes","data-toggle":"tooltip"},on:{click:function(e){return t.addRecord("add_type","types",e)}}},[s("i",{staticClass:"icofont icofont-read-book ico-3x"}),t._v(" "),t._m(0)]),t._v(" "),s("div",{staticClass:"modal fade text-left",attrs:{tabindex:"-1",role:"dialog",id:"add_type"}},[s("div",{staticClass:"modal-dialog vue-crud",attrs:{role:"document"}},[s("div",{staticClass:"modal-content"},[t._m(1),t._v(" "),s("div",{staticClass:"modal-body"},[t.errors.length>0?s("div",{staticClass:"alert alert-danger"},[s("div",{staticClass:"container"},[t._m(2),t._v(" "),s("strong",[t._v("Cuidado!")]),t._v(" Debe verificar los siguientes errores antes de continuar:\n                                "),s("button",{staticClass:"close",attrs:{type:"button","data-dismiss":"alert","aria-label":"Close"},on:{click:function(e){e.preventDefault(),t.errors=[]}}},[t._m(3)]),t._v(" "),s("ul",t._l(t.errors,(function(e){return s("li",[t._v(t._s(e))])})),0)])]):t._e(),t._v(" "),s("div",{staticClass:"row"},[s("div",{staticClass:"col-md-6"},[s("div",{staticClass:"form-group is-required"},[s("label",[t._v("Tipo de Bien:")]),t._v(" "),s("input",{directives:[{name:"model",rawName:"v-model",value:t.record.name,expression:"record.name"}],staticClass:"form-control input-sm",attrs:{type:"text",placeholder:"Nombre del Tipo de Bien","data-toggle":"tooltip",title:"Indique el nombre del Nuevo Tipo de Bien (requerido)"},domProps:{value:t.record.name},on:{input:function(e){e.target.composing||t.$set(t.record,"name",e.target.value)}}}),t._v(" "),s("input",{directives:[{name:"model",rawName:"v-model",value:t.record.id,expression:"record.id"}],attrs:{type:"hidden"},domProps:{value:t.record.id},on:{input:function(e){e.target.composing||t.$set(t.record,"id",e.target.value)}}})])])])]),t._v(" "),s("div",{staticClass:"modal-footer"},[s("div",{staticClass:"form-group"},[s("modal-form-buttons",{attrs:{saveRoute:"asset/types"}})],1)]),t._v(" "),s("div",{staticClass:"modal-body modal-table"},[s("hr"),t._v(" "),s("v-client-table",{attrs:{columns:t.columns,data:t.records,options:t.table_options},scopedSlots:t._u([{key:"id",fn:function(e){return s("div",{staticClass:"text-center"},[s("button",{staticClass:"btn btn-warning btn-xs btn-icon btn-action",attrs:{title:"Modificar registro","data-toggle":"tooltip",type:"button"},on:{click:function(s){return t.initUpdate(e.index,s)}}},[s("i",{staticClass:"fa fa-edit"})]),t._v(" "),s("button",{staticClass:"btn btn-danger btn-xs btn-icon btn-action",attrs:{title:"Eliminar registro","data-toggle":"tooltip",type:"button"},on:{click:function(s){return t.deleteRecord(e.index,"types")}}},[s("i",{staticClass:"fa fa-trash-o"})])])}}])})],1)])])])])}),[function(){var t=this.$createElement,e=this._self._c||t;return e("span",[this._v("Tipos"),e("br"),this._v("de Bienes")])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"modal-header"},[e("button",{staticClass:"close",attrs:{type:"button","data-dismiss":"modal","aria-label":"Close"}},[e("span",{attrs:{"aria-hidden":"true"}},[this._v("×")])]),this._v(" "),e("h6",[e("i",{staticClass:"icofont icofont-read-book ico-2x"}),this._v("\n\t\t\t\t\t\t\tNuevo Tipo de Bien\n\t\t\t\t\t\t")])])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"alert-icon"},[e("i",{staticClass:"now-ui-icons objects_support-17"})])},function(){var t=this.$createElement,e=this._self._c||t;return e("span",{attrs:{"aria-hidden":"true"}},[e("i",{staticClass:"now-ui-icons ui-1_simple-remove"})])}],!1,null,null,null);e.default=n.exports},"KHd+":function(t,e,s){"use strict";function i(t,e,s,i,o,n,a,r){var l,d="function"==typeof t?t.options:t;if(e&&(d.render=e,d.staticRenderFns=s,d._compiled=!0),i&&(d.functional=!0),n&&(d._scopeId="data-v-"+n),a?(l=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),o&&o.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(a)},d._ssrRegister=l):o&&(l=r?function(){o.call(this,(d.functional?this.parent:this).$root.$options.shadowRoot)}:o),l)if(d.functional){d._injectStyles=l;var c=d.render;d.render=function(t,e){return l.call(e),c(t,e)}}else{var u=d.beforeCreate;d.beforeCreate=u?[].concat(u,l):[l]}return{exports:t,options:d}}s.d(e,"a",(function(){return i}))}}]);