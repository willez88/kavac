(window.webpackJsonp=window.webpackJsonp||[]).push([[4],{"KHd+":function(t,e,a){"use strict";function o(t,e,a,o,i,n,r,s){var l,d="function"==typeof t?t.options:t;if(e&&(d.render=e,d.staticRenderFns=a,d._compiled=!0),o&&(d.functional=!0),n&&(d._scopeId="data-v-"+n),r?(l=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),i&&i.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(r)},d._ssrRegister=l):i&&(l=s?function(){i.call(this,this.$root.$options.shadowRoot)}:i),l)if(d.functional){d._injectStyles=l;var c=d.render;d.render=function(t,e){return l.call(e),c(t,e)}}else{var m=d.beforeCreate;d.beforeCreate=m?[].concat(m,l):[l]}return{exports:t,options:d}}a.d(e,"a",function(){return o})},"zTB+":function(t,e,a){"use strict";a.r(e);function o(t,e,a){return e in t?Object.defineProperty(t,e,{value:a,enumerable:!0,configurable:!0,writable:!0}):t[e]=a,t}var i={data:function(){return{record:{id:"",name:"",acronym:""},errors:[],records:[],columns:["name","acronym","id"]}},methods:{reset:function(){this.record={id:"",name:"",acronym:""}}},created:function(){var t;this.table_options.headings={name:"Nombre",acronym:"Acrónimo",id:"Acción"},this.table_options.sortable=["name"],this.table_options.filterable=["name"],this.table_options.columnsClasses=(o(t={name:"col-md-5"},"name","col-md-5"),o(t,"id","col-md-2"),t)}},n=a("KHd+"),r=Object(n.a)(i,function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"text-center"},[a("a",{staticClass:"btn-simplex btn-simplex-md btn-simplex-primary",attrs:{href:"",title:"Registros de idiomas","data-toggle":"tooltip"},on:{click:function(e){return t.addRecord("add_payroll_language","languages",e)}}},[a("i",{staticClass:"icofont icofont-flag ico-3x"}),t._v(" "),a("span",[t._v("Idiomas")])]),t._v(" "),a("div",{staticClass:"modal fade text-left",attrs:{tabindex:"-1",role:"dialog",id:"add_payroll_language"}},[a("div",{staticClass:"modal-dialog vue-crud",attrs:{role:"document"}},[a("div",{staticClass:"modal-content"},[t._m(0),t._v(" "),a("div",{staticClass:"modal-body"},[t.errors.length>0?a("div",{staticClass:"alert alert-danger"},[a("ul",t._l(t.errors,function(e){return a("li",[t._v(t._s(e))])}),0)]):t._e(),t._v(" "),a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-6"},[a("div",{staticClass:"form-group is-required"},[a("label",{attrs:{for:"name"}},[t._v("Nombre:")]),t._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:t.record.name,expression:"record.name"}],staticClass:"form-control input-sm",attrs:{type:"text",id:"name",placeholder:"Nombre","data-toggle":"tooltip",title:"Indique el nombre del idioma (requerido)"},domProps:{value:t.record.name},on:{input:function(e){e.target.composing||t.$set(t.record,"name",e.target.value)}}}),t._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:t.record.id,expression:"record.id"}],attrs:{type:"hidden",name:"id",id:"id"},domProps:{value:t.record.id},on:{input:function(e){e.target.composing||t.$set(t.record,"id",e.target.value)}}})])]),t._v(" "),a("div",{staticClass:"col-md-6"},[a("div",{staticClass:"form-group is-required"},[a("label",{attrs:{for:"acronym"}},[t._v("Acrónimo:")]),t._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:t.record.acronym,expression:"record.acronym"}],staticClass:"form-control input-sm",attrs:{type:"text",id:"acronym",placeholder:"Acrónimo","data-toggle":"tooltip",title:"Indique el acrónimo del idioma (requerido)"},domProps:{value:t.record.acronym},on:{input:function(e){e.target.composing||t.$set(t.record,"acronym",e.target.value)}}})])])])]),t._v(" "),a("div",{staticClass:"modal-footer"},[a("div",{staticClass:"form-group"},[a("modal-form-buttons",{attrs:{saveRoute:"payroll/languajes"}})],1)]),t._v(" "),a("div",{staticClass:"modal-body modal-table"},[a("v-client-table",{attrs:{columns:t.columns,data:t.records,options:t.table_options},scopedSlots:t._u([{key:"id",fn:function(e){return a("div",{staticClass:"text-center"},[a("button",{staticClass:"btn btn-warning btn-xs btn-icon btn-action",attrs:{title:"Modificar registro","data-toggle":"tooltip",type:"button"},on:{click:function(a){return t.initUpdate(e.row.id,a)}}},[a("i",{staticClass:"fa fa-edit"})]),t._v(" "),a("button",{staticClass:"btn btn-danger btn-xs btn-icon btn-action",attrs:{title:"Eliminar registro","data-toggle":"tooltip",type:"button"},on:{click:function(a){return t.deleteRecord(e.row.id,"languages")}}},[a("i",{staticClass:"fa fa-trash-o"})])])}}])})],1)])])])])},[function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"modal-header"},[e("button",{staticClass:"close",attrs:{type:"button","data-dismiss":"modal","aria-label":"Close"}},[e("span",{attrs:{"aria-hidden":"true"}},[this._v("×")])]),this._v(" "),e("h6",[e("i",{staticClass:"icofont icofont-flag ico-3x"}),this._v("\n\t\t\t\t\t\t\tIdioma\n\t\t\t\t\t\t")])])}],!1,null,null,null);e.default=r.exports}}]);