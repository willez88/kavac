(window.webpackJsonp=window.webpackJsonp||[]).push([[17],{"KHd+":function(t,e,a){"use strict";function o(t,e,a,o,r,s,i,l){var n,d="function"==typeof t?t.options:t;if(e&&(d.render=e,d.staticRenderFns=a,d._compiled=!0),o&&(d.functional=!0),s&&(d._scopeId="data-v-"+s),i?(n=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),r&&r.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(i)},d._ssrRegister=n):r&&(n=l?function(){r.call(this,this.$root.$options.shadowRoot)}:r),n)if(d.functional){d._injectStyles=n;var c=d.render;d.render=function(t,e){return n.call(e),c(t,e)}}else{var u=d.beforeCreate;d.beforeCreate=u?[].concat(u,n):[n]}return{exports:t,options:d}}a.d(e,"a",function(){return o})},lsdl:function(t,e,a){"use strict";a.r(e);var o={props:{payroll_socioeconomic_id:Number},data:function(){return{record:{id:"",full_name_twosome:"",id_number_twosome:"",birthdate_twosome:"",payroll_staff_id:"",marital_status_id:"",payroll_childrens:[]},errors:[],payroll_staffs:[],marital_status:[]}},methods:{reset:function(){this.record={id:"",full_name_twosome:"",id_number_twosome:"",birthdate_twosome:"",payroll_staff_id:"",marital_status_id:"",payroll_childrens:[]}},getSocioeconomic:function(){var t=this;axios.get("/payroll/socioeconomics/"+this.payroll_socioeconomic_id).then(function(e){t.record=e.data.record})},addPayrollChildren:function(){this.record.payroll_childrens.push({first_name:"",last_name:"",id_number:"",birthdate:""})}},created:function(){this.getPayrollStaffs(),this.getMaritalStatus(),this.record.payroll_childrens=[]},mounted:function(){this.payroll_socioeconomic_id&&this.getSocioeconomic()}},r=a("KHd+"),s=Object(r.a)(o,function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"row"},[a("div",{staticClass:"col-12"},[a("div",{staticClass:"card"},[a("div",{staticClass:"card-header"},[a("h6",{staticClass:"card-title"},[t._v("Registrar los Datos Socioeconómicos")]),t._v(" "),a("div",{staticClass:"card-btns"},[a("a",{staticClass:"btn btn-sm btn-primary btn-custom",attrs:{href:"#",title:"Ir atrás","data-toggle":"tooltip"},on:{click:function(e){return t.redirect_back(t.route_list)}}},[a("i",{staticClass:"fa fa-reply"})]),t._v(" "),t._m(0)])]),t._v(" "),a("div",{staticClass:"card-body"},[t.errors.length>0?a("div",{staticClass:"alert alert-danger"},[a("ul",t._l(t.errors,function(e){return a("li",[t._v(t._s(e))])}),0)]):t._e(),t._v(" "),a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-4"},[a("div",{staticClass:"form-group is-required"},[a("label",[t._v("Trabajador:")]),t._v(" "),a("select2",{attrs:{options:t.payroll_staffs},model:{value:t.record.payroll_staff_id,callback:function(e){t.$set(t.record,"payroll_staff_id",e)},expression:"record.payroll_staff_id"}}),t._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:t.record.id,expression:"record.id"}],attrs:{type:"hidden"},domProps:{value:t.record.id},on:{input:function(e){e.target.composing||t.$set(t.record,"id",e.target.value)}}})],1)]),t._v(" "),a("div",{staticClass:"col-md-4"},[a("div",{staticClass:"form-group is-required"},[a("label",[t._v("Estado Civil:")]),t._v(" "),a("select2",{attrs:{options:t.marital_status},model:{value:t.record.marital_status_id,callback:function(e){t.$set(t.record,"marital_status_id",e)},expression:"record.marital_status_id"}})],1)])]),t._v(" "),2==t.record.marital_status_id?a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-4"},[a("div",{staticClass:"form-group"},[a("label",[t._v("Nombres y apellidos de la pareja del trabajador:")]),t._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:t.record.full_name_twosome,expression:"record.full_name_twosome"}],staticClass:"form-control input-sm",attrs:{type:"text"},domProps:{value:t.record.full_name_twosome},on:{input:function(e){e.target.composing||t.$set(t.record,"full_name_twosome",e.target.value)}}})])]),t._v(" "),a("div",{staticClass:"col-md-4"},[a("div",{staticClass:"form-group"},[a("label",[t._v("Cédula de Identidad de la pareja del trabajador:")]),t._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:t.record.id_number_twosome,expression:"record.id_number_twosome"}],staticClass:"form-control input-sm",attrs:{type:"text"},domProps:{value:t.record.id_number_twosome},on:{input:function(e){e.target.composing||t.$set(t.record,"id_number_twosome",e.target.value)}}})])]),t._v(" "),a("div",{staticClass:"col-md-4"},[a("div",{staticClass:"form-group"},[a("label",[t._v("fecha de nacimiento de la pareja del trabajador:")]),t._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:t.record.birthdate_twosome,expression:"record.birthdate_twosome"}],staticClass:"form-control input-sm",attrs:{type:"date"},domProps:{value:t.record.birthdate_twosome},on:{input:function(e){e.target.composing||t.$set(t.record,"birthdate_twosome",e.target.value)}}})])])]):t._e(),t._v(" "),a("hr"),t._v(" "),a("h6",{staticClass:"card-title"},[t._v("\n\t\t\t\t\tHijos del Trabajador "),a("i",{staticClass:"fa fa-plus-circle cursor-pointer",on:{click:t.addPayrollChildren}})]),t._v(" "),t._l(t.record.payroll_childrens,function(e,o){return a("div",{staticClass:"row"},[a("div",{staticClass:"col-3"},[a("div",{staticClass:"form-group is-required"},[a("input",{directives:[{name:"model",rawName:"v-model",value:e.first_name,expression:"payroll_children.first_name"}],staticClass:"form-control input-sm",attrs:{type:"text",placeholder:"Nombres del hijo del trabajador","data-toggle":"tooltip",title:"Indique los nombres del hijo del trabajador"},domProps:{value:e.first_name},on:{input:function(a){a.target.composing||t.$set(e,"first_name",a.target.value)}}})])]),t._v(" "),a("div",{staticClass:"col-3"},[a("div",{staticClass:"form-group is-required"},[a("input",{directives:[{name:"model",rawName:"v-model",value:e.last_name,expression:"payroll_children.last_name"}],staticClass:"form-control input-sm",attrs:{type:"text",placeholder:"Apellidos del hijo del trabajador","data-toggle":"tooltip",title:"Indique los apellidos del hijo del trabajador"},domProps:{value:e.last_name},on:{input:function(a){a.target.composing||t.$set(e,"last_name",a.target.value)}}})])]),t._v(" "),a("div",{staticClass:"col-2"},[a("div",{staticClass:"form-group"},[a("input",{directives:[{name:"model",rawName:"v-model",value:e.id_number,expression:"payroll_children.id_number"}],staticClass:"form-control input-sm",attrs:{type:"text",placeholder:"Cédula de Identidad del hijo del trabajador","data-toggle":"tooltip",title:"Indique la cédula de indentidad del hijo del trabajador"},domProps:{value:e.id_number},on:{input:function(a){a.target.composing||t.$set(e,"id_number",a.target.value)}}})])]),t._v(" "),a("div",{staticClass:"col-2"},[a("div",{staticClass:"form-group is-required"},[a("input",{directives:[{name:"model",rawName:"v-model",value:e.birthdate,expression:"payroll_children.birthdate"}],staticClass:"form-control input-sm",attrs:{type:"date",placeholder:"Fecha de Nacimiento del hijo del trabajador","data-toggle":"tooltip",title:"Indique la fecha de nacimiento del hijo del trabajador"},domProps:{value:e.birthdate},on:{input:function(a){a.target.composing||t.$set(e,"birthdate",a.target.value)}}})])]),t._v(" "),a("div",{staticClass:"col-1"},[a("div",{staticClass:"form-group"},[a("button",{staticClass:"btn btn-sm btn-danger btn-action",attrs:{type:"button",title:"Eliminar este dato","data-toggle":"tooltip","data-placement":"right"},on:{click:function(e){return t.removeRow(o,t.record.payroll_childrens)}}},[a("i",{staticClass:"fa fa-minus-circle"})])])])])})],2),t._v(" "),a("div",{staticClass:"card-footer pull-right"},[a("button",{staticClass:"btn btn-default btn-icon btn-round",attrs:{"data-toggle":"tooltip",type:"button",title:"Borrar datos del formulario"},on:{click:t.reset}},[a("i",{staticClass:"fa fa-eraser"})]),t._v(" "),a("button",{staticClass:"btn btn-warning btn-icon btn-round",attrs:{type:"button","data-toggle":"tooltip",title:"Cancelar y regresar"},on:{click:function(e){return t.redirect_back(t.route_list)}}},[a("i",{staticClass:"fa fa-ban"})]),t._v(" "),a("button",{staticClass:"btn btn-success btn-icon btn-round",attrs:{type:"button"},on:{click:function(e){return t.createRecord("payroll/socioeconomics")}}},[a("i",{staticClass:"fa fa-save"})])])])])])},[function(){var t=this.$createElement,e=this._self._c||t;return e("a",{staticClass:"card-minimize btn btn-card-action btn-round",attrs:{href:"#",title:"Minimizar","data-toggle":"tooltip"}},[e("i",{staticClass:"now-ui-icons arrows-1_minimal-up"})])}],!1,null,null,null);e.default=s.exports}}]);