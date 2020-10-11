(window.webpackJsonp=window.webpackJsonp||[]).push([[18],{"KHd+":function(e,t,i){"use strict";function r(e,t,i,r,o,s,c,a){var n,d="function"==typeof e?e.options:e;if(t&&(d.render=t,d.staticRenderFns=i,d._compiled=!0),r&&(d.functional=!0),s&&(d._scopeId="data-v-"+s),c?(n=function(e){(e=e||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(e=__VUE_SSR_CONTEXT__),o&&o.call(this,e),e&&e._registeredComponents&&e._registeredComponents.add(c)},d._ssrRegister=n):o&&(n=a?function(){o.call(this,this.$root.$options.shadowRoot)}:o),n)if(d.functional){d._injectStyles=n;var l=d.render;d.render=function(e,t){return n.call(t),l(e,t)}}else{var u=d.beforeCreate;d.beforeCreate=u?[].concat(u,n):[n]}return{exports:e,options:d}}i.d(t,"a",function(){return r})},qyYu:function(e,t,i){"use strict";i.r(t);function r(e){return(r="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e})(e)}var o={data:function(){return{record:{id:"",motive:"",institution_id:"1",department_id:"",budget_project_id:"",budget_centralized_action_id:"",budget_specific_action_id:"",created_at:"",warehouse_products:[]},editIndex:null,records:[],columns:["check","code","description","inventory","requested"],errors:[],selected:[],selectAll:!1,departments:[],budget_projects:[],budget_centralized_actions:[],budget_specific_actions:[],table_options:{rowClassCallback:function(e){var t=document.getElementById("checkbox_"+e.id);return t&&t.checked?"selected-row cursor-pointer":"cursor-pointer"},headings:{code:"Código",description:"Descripción",inventory:"Inventario",requested:"Solicitados"},sortable:["code","description","inventory","requested"],filterable:["code","description","inventory","requested"]}}},created:function(){this.getBudgetProjects(),this.getBudgetCentralizedActions(),this.initForm("/warehouse/requests/vue-list-products"),this.requestid&&this.loadRequest(this.requestid)},props:{requestid:Number},methods:{toggleActive:function(e){var t=e.row,i=document.getElementById("checkbox_"+t.id);if(i&&0==i.checked)(r=this.selected.indexOf(t.id))>=0?this.selected.splice(r,1):i.click();else if(i&&1==i.checked){var r;(r=this.selected.indexOf(t.id))>=0?i.click():this.selected.push(t.id)}},reset:function(){this.record={id:"",motive:"",institution_id:"1",department_id:"",budget_project_id:"",budget_centralized_action_id:"",budget_specific_action_id:"",created_at:"",warehouse_products:[]}},select:function(){var e=this;e.selected=[],$.each(e.records,function(t,i){var r=document.getElementById("checkbox_"+i.id);e.selectAll?r&&r.checked&&r.click():e.selected.push(i.id)})},selectElement:function(e){var t=document.getElementById("request_product_"+e),i=document.getElementById("checkbox_"+e);""==t.value||0==t.value?i.checked&&i.click():i.checked||i.click()},initForm:function(e){var t=this;t.requestid&&axios.get("/warehouse/requests/info/"+t.requestid).then(function(e){if(void 0!==e.data.records){var i=e.data.records;t.record.institution_id=i.department.institution_id,t.getDepartments(),t.record.motive=i.motive,t.record.department_id=i.department_id}}),t.record.institution_id="1",t.getDepartments(),t.record.created_at=t.format_date(new Date),axios.get(e).then(function(e){void 0!==e.data.records&&(t.records=e.data.records)})},loadRequest:function(e){var t=this,i={};axios.get("/warehouse/requests/info/"+e).then(function(e){r("undefined"!=e.data.records)&&(i=e.data.records,t.record={id:i.id,motive:i.motive,institution_id:"1",department_id:i.department_id,budget_project_id:"",budget_centralized_action_id:"",budget_specific_action_id:i.budget_specific_action_id,created_at:t.format_date(i.created_at)},$.each(i.request_product,function(e,i){var r=document.getElementById("request_product_"+i.warehouse_inventary_product_id);r&&(r.value=i.quantity,t.selected.push(i.warehouse_inventary_product_id))}))})},createRequest:function(e){var t=this;t.record.warehouse_products=[];var i=!0;if(!t.selected.length>0)return bootbox.alert("Debe agregar almenos un elemento a la solicitud"),!1;$.each(t.selected,function(e,r){var o=document.getElementById("request_product_"+r).value;if(""==o)return bootbox.alert("Debe ingresar la cantidad solicitada para cada producto seleccionado"),void(i=!1);t.record.warehouse_products.push({id:r,requested:o})}),1==i&&t.createRecord(e)}},watch:{budget_specific_actions:function(){$("#budget_specific_action_id").attr("disabled",this.budget_specific_actions.length<=1)}},mounted:function(){$(".sel_pry_acc").on("switchChange.bootstrapSwitch",function(e){$("#budget_project_id").attr("disabled","sel_project"!==e.target.id),$("#budget_centralized_action_id").attr("disabled","sel_centralized_action"!==e.target.id),"sel_project"===e.target.id?($("#budget_centralized_action_id").closest(".form-group").removeClass("is-required"),$("#budget_project_id").closest(".form-group").addClass("is-required")):"sel_centralized_action"===e.target.id&&($("#budget_centralized_action_id").closest(".form-group").addClass("is-required"),$("#budget_project_id").closest(".form-group").removeClass("is-required"))})}},s=i("KHd+"),c=Object(s.a)(o,function(){var e=this,t=e.$createElement,i=e._self._c||t;return i("section",{attrs:{id:"WarehouseRequestForm"}},[i("div",{staticClass:"card-body"},[e.errors.length>0?i("div",{staticClass:"alert alert-danger"},[i("div",{staticClass:"container"},[e._m(0),e._v(" "),i("strong",[e._v("Cuidado!")]),e._v(" Debe verificar los siguientes errores antes de continuar:\n\t\t\t\t\t"),i("button",{staticClass:"close",attrs:{type:"button","data-dismiss":"alert","aria-label":"Close"},on:{click:function(t){t.preventDefault(),e.errors=[]}}},[e._m(1)]),e._v(" "),i("ul",e._l(e.errors,function(t){return i("li",[e._v(e._s(t))])}),0)])]):e._e(),e._v(" "),i("div",{staticClass:"row"},[e._m(2),e._v(" "),i("div",{staticClass:"col-md-4",attrs:{id:"helpWarehouseRequestDate"}},[i("div",{staticClass:"form-group is-required"},[i("label",[e._v("Fecha de la Solicitud")]),e._v(" "),i("input",{directives:[{name:"model",rawName:"v-model",value:e.record.created_at,expression:"record.created_at"}],staticClass:"form-control input-sm",attrs:{type:"text","data-toggle":"tooltip",title:"Fecha de la solicitud",readonly:"readonly"},domProps:{value:e.record.created_at},on:{input:function(t){t.target.composing||e.$set(e.record,"created_at",t.target.value)}}}),e._v(" "),i("input",{directives:[{name:"model",rawName:"v-model",value:e.record.id,expression:"record.id"}],attrs:{type:"hidden"},domProps:{value:e.record.id},on:{input:function(t){t.target.composing||e.$set(e.record,"id",t.target.value)}}})])]),e._v(" "),i("div",{staticClass:"col-md-4",attrs:{id:"helpWarehouseRequestDepartment"}},[i("div",{staticClass:" form-group is-required"},[i("label",[e._v("Dependencia Solicitante")]),e._v(" "),i("select2",{attrs:{options:e.departments},model:{value:e.record.department_id,callback:function(t){e.$set(e.record,"department_id",t)},expression:"record.department_id"}})],1)]),e._v(" "),i("div",{staticClass:"col-md-4",attrs:{id:"helpWarehouseRequestMotive"}},[i("div",{staticClass:"form-group is-required"},[i("label",[e._v("Motivo de la Solicitud")]),e._v(" "),i("ckeditor",{staticClass:"form-control",attrs:{editor:e.ckeditor.editor,"data-toggle":"tooltip",title:"Indique el motivo de la solicitud (requerido)",config:e.ckeditor.editorConfig,"tag-name":"textarea",rows:"3"},model:{value:e.record.motive,callback:function(t){e.$set(e.record,"motive",t)},expression:"record.motive"}})],1)]),e._v(" "),i("div",{staticClass:"col-md-6",attrs:{id:"helpWarehouseRequestProject"}},[i("div",{staticClass:" form-group is-required"},[e._m(3),e._v(" "),i("select2",{attrs:{options:e.budget_projects,id:"budget_project_id",disabled:""},on:{input:function(t){return e.getBudgetSpecificActions("Project")}},model:{value:e.record.budget_project_id,callback:function(t){e.$set(e.record,"budget_project_id",t)},expression:"record.budget_project_id"}})],1)]),e._v(" "),i("div",{staticClass:"col-md-6",attrs:{id:"helpWarehouseRequestCentralizedAction"}},[i("div",{staticClass:" form-group is-required"},[e._m(4),e._v(" "),i("select2",{attrs:{options:e.budget_centralized_actions,id:"budget_centralized_action_id",disabled:""},on:{input:function(t){return e.getBudgetSpecificActions("CentralizedAction")}},model:{value:e.record.budget_centralized_action_id,callback:function(t){e.$set(e.record,"budget_centralized_action_id",t)},expression:"record.budget_centralized_action_id"}})],1)]),e._v(" "),i("div",{staticClass:"col-md-12",attrs:{id:"helpWarehouseRequestSpecificAction"}},[i("div",{staticClass:" form-group is-required"},[i("label",[e._v("Acción Específica")]),e._v(" "),i("select2",{attrs:{options:e.budget_specific_actions,id:"budget_specific_action_id",disabled:""},model:{value:e.record.budget_specific_action_id,callback:function(t){e.$set(e.record,"budget_specific_action_id",t)},expression:"record.budget_specific_action_id"}})],1)])]),e._v(" "),i("hr"),e._v(" "),i("v-client-table",{attrs:{id:"helpTable",columns:e.columns,data:e.records,options:e.table_options},on:{"row-click":e.toggleActive},scopedSlots:e._u([{key:"check",fn:function(t){return i("div",{staticClass:"text-center"},[i("label",{staticClass:"form-checkbox"},[i("input",{directives:[{name:"model",rawName:"v-model",value:e.selected,expression:"selected"}],staticClass:"cursor-pointer",attrs:{type:"checkbox",id:"checkbox_"+t.row.id},domProps:{value:t.row.id,checked:Array.isArray(e.selected)?e._i(e.selected,t.row.id)>-1:e.selected},on:{change:function(i){var r=e.selected,o=i.target,s=!!o.checked;if(Array.isArray(r)){var c=t.row.id,a=e._i(r,c);o.checked?a<0&&(e.selected=r.concat([c])):a>-1&&(e.selected=r.slice(0,a).concat(r.slice(a+1)))}else e.selected=s}}})])])}},{key:"description",fn:function(t){return i("div",{},[i("span",[i("b",[e._v(" "+e._s(t.row.warehouse_product?t.row.warehouse_product.name+": ":"")+" ")]),e._v("\n\t\t\t\t\t\t"+e._s(t.row.warehouse_product?t.row.warehouse_product.description:"")),i("br")]),e._v(" "),i("span",[e._l(t.row.warehouse_product_values,function(t){return i("div",[i("b",[e._v(e._s(t.warehouse_product_attribute.name+":"))]),e._v(" "+e._s(t.value)),i("br")])}),e._v(" "),i("b",[e._v("Valor:")]),e._v(" "+e._s(t.row.unit_value)+" "+e._s(t.row.currency?t.row.currency.name:"")+"\n\t\t\t\t\t")],2)])}},{key:"inventory",fn:function(t){return i("div",{},[i("span",[i("b",[e._v("Almacén:")]),e._v(" "+e._s(t.row.warehouse_institution_warehouse.warehouse.name)+" "),i("br"),e._v(" "),i("b",[e._v("Existencia:")]),e._v(" "+e._s(t.row.exist)),i("br"),e._v(" "),i("b",[e._v("Reservados:")]),e._v(" "+e._s(null===t.row.reserved?"0":t.row.reserved)+"\n\t\t\t\t\t")])])}},{key:"requested",fn:function(t){return i("div",{},[i("div",[i("input",{staticClass:"form-control table-form input-sm",attrs:{type:"number","data-toggle":"tooltip",min:"0",max:t.row.exist,id:"request_product_"+t.row.id,onfocus:"this.select()"},on:{input:function(i){return e.selectElement(t.row.id)}}})])])}}])},[i("div",{staticClass:"text-center",attrs:{slot:"h__check"},slot:"h__check"},[i("label",{staticClass:"form-checkbox"},[i("input",{directives:[{name:"model",rawName:"v-model",value:e.selectAll,expression:"selectAll"}],staticClass:"cursor-pointer",attrs:{type:"checkbox"},domProps:{checked:Array.isArray(e.selectAll)?e._i(e.selectAll,null)>-1:e.selectAll},on:{click:function(t){return e.select()},change:function(t){var i=e.selectAll,r=t.target,o=!!r.checked;if(Array.isArray(i)){var s=e._i(i,null);r.checked?s<0&&(e.selectAll=i.concat([null])):s>-1&&(e.selectAll=i.slice(0,s).concat(i.slice(s+1)))}else e.selectAll=o}}})])])])],1),e._v(" "),i("div",{staticClass:"card-footer text-right"},[i("div",{staticClass:"row"},[i("div",{staticClass:"col-md-3 offset-md-9",attrs:{id:"helpParamButtons"}},[i("button",{staticClass:"btn btn-default btn-icon btn-round",attrs:{type:"button",title:"Borrar datos del formulario"},on:{click:function(t){return e.reset()}}},[i("i",{staticClass:"fa fa-eraser"})]),e._v(" "),e._m(5),e._v(" "),i("button",{staticClass:"btn btn-success btn-icon btn-round btn-modal-save",attrs:{type:"button",title:"Guardar registro"},on:{click:function(t){return e.createRequest("warehouse/requests")}}},[i("i",{staticClass:"fa fa-save"})])])])])])},[function(){var e=this.$createElement,t=this._self._c||e;return t("div",{staticClass:"alert-icon"},[t("i",{staticClass:"now-ui-icons objects_support-17"})])},function(){var e=this.$createElement,t=this._self._c||e;return t("span",{attrs:{"aria-hidden":"true"}},[t("i",{staticClass:"now-ui-icons ui-1_simple-remove"})])},function(){var e=this.$createElement,t=this._self._c||e;return t("div",{staticClass:"col-md-12"},[t("b",[this._v("Datos de la Solicitud")])])},function(){var e=this.$createElement,t=this._self._c||e;return t("label",{staticClass:"mb-4"},[t("div",{staticClass:"bootstrap-switch-mini"},[t("input",{staticClass:"form-control bootstrap-switch bootstrap-switch-mini sel_pry_acc",attrs:{type:"radio",name:"project_centralized_action",value:"project",id:"sel_project","data-on-label":"SI","data-off-label":"NO"}}),this._v("\n    \t\t\t\t\t\t\tProyecto\n                            ")])])},function(){var e=this.$createElement,t=this._self._c||e;return t("label",{staticClass:"mb-4"},[t("div",{staticClass:"bootstrap-switch-mini"},[t("input",{staticClass:"form-control bootstrap-switch bootstrap-switch-mini sel_pry_acc",attrs:{type:"radio",name:"project_centralized_action",value:"project",id:"sel_centralized_action","data-on-label":"SI","data-off-label":"NO"}}),this._v("\n    \t\t\t\t\t\t\tAcción Centralizada\n                            ")])])},function(){var e=this.$createElement,t=this._self._c||e;return t("button",{staticClass:"btn btn-warning btn-icon btn-round btn-modal-close",attrs:{type:"button","data-dismiss":"modal",title:"Cancelar y regresar"}},[t("i",{staticClass:"fa fa-ban"})])}],!1,null,null,null);t.default=c.exports}}]);