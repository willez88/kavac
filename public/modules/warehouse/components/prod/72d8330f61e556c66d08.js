(window.webpackJsonp=window.webpackJsonp||[]).push([[23],{"KHd+":function(e,t,r){"use strict";function o(e,t,r,o,s,i,a,c){var n,d="function"==typeof e?e.options:e;if(t&&(d.render=t,d.staticRenderFns=r,d._compiled=!0),o&&(d.functional=!0),i&&(d._scopeId="data-v-"+i),a?(n=function(e){(e=e||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(e=__VUE_SSR_CONTEXT__),s&&s.call(this,e),e&&e._registeredComponents&&e._registeredComponents.add(a)},d._ssrRegister=n):s&&(n=c?function(){s.call(this,this.$root.$options.shadowRoot)}:s),n)if(d.functional){d._injectStyles=n;var l=d.render;d.render=function(e,t){return n.call(t),l(e,t)}}else{var u=d.beforeCreate;d.beforeCreate=u?[].concat(u,n):[n]}return{exports:e,options:d}}r.d(t,"a",function(){return o})},PcHB:function(e,t,r){"use strict";r.r(t);function o(e){return(o="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e})(e)}var s={data:function(){return{record:{id:"",motive:"",institution_id:"1",department_id:"",payroll_position_id:"",payroll_staff_id:"",created_at:"",warehouse_products:[]},editIndex:null,records:[],columns:["check","code","description","inventory","requested"],errors:[],selected:[],selectAll:!1,departments:[],payroll_positions:[],payroll_staffs:[],table_options:{rowClassCallback:function(e){var t=document.getElementById("checkbox_"+e.id);return t&&t.checked?"selected-row cursor-pointer":"cursor-pointer"},headings:{code:"Código",description:"Descripción",inventory:"Inventario",requested:"Solicitados"},sortable:["code","description","inventory","requested"],filterable:["code","description","inventory","requested"]}}},created:function(){this.getPayrollStaffs(),this.getPayrollPositions(),this.initForm("/warehouse/requests/vue-list-products"),this.requestid&&this.loadRequest(this.requestid)},props:{requestid:Number},methods:{toggleActive:function(e){var t=e.row,r=document.getElementById("checkbox_"+t.id);if(r&&0==r.checked)(o=this.selected.indexOf(t.id))>=0?this.selected.splice(o,1):r.click();else if(r&&1==r.checked){var o;(o=this.selected.indexOf(t.id))>=0?r.click():this.selected.push(t.id)}},reset:function(){this.record={id:"",motive:"",institution_id:"1",department_id:"",payroll_position_id:"",payroll_staff_id:"",created_at:"",warehouse_products:[]}},select:function(){var e=this;e.selected=[],$.each(e.records,function(t,r){var o=document.getElementById("checkbox_"+r.id);e.selectAll?o&&o.checked&&o.click():e.selected.push(r.id)})},selectElement:function(e){var t=document.getElementById("request_product_"+e),r=document.getElementById("checkbox_"+e);""==t.value||0==t.value?r.checked&&r.click():r.checked||r.click()},initForm:function(e){var t=this;t.requestid&&axios.get("/warehouse/requests/staff/info/"+t.requestid).then(function(e){if(void 0!==e.data.records){var r=e.data.records;t.record.institution_id=r.department.institution_id,t.getDepartments(),t.record.motive=r.motive,t.record.department_id=r.department_id}}),t.record.institution_id="1",t.getDepartments(),t.record.created_at=t.format_date(new Date),axios.get(e).then(function(e){void 0!==e.data.records&&(t.records=e.data.records)})},loadRequest:function(e){var t=this,r={};axios.get("/warehouse/requests/staff/info/"+e).then(function(e){o("undefined"!=e.data.records)&&(r=e.data.records,t.record={id:r.id,motive:r.motive,institution_id:"1",department_id:r.department_id,payroll_staff_id:r.payroll_staff_id,created_at:t.format_date(r.created_at)},$.each(r.request_product,function(e,r){var o=document.getElementById("request_product_"+r.warehouse_inventary_product_id);o&&(o.value=r.quantity,t.selected.push(r.warehouse_inventary_product_id))}))})},createRequest:function(e){var t=this;t.record.warehouse_products=[];var r=!0;if(!t.selected.length>0)return bootbox.alert("Debe agregar almenos un elemento a la solicitud"),!1;$.each(t.selected,function(e,o){var s=document.getElementById("request_product_"+o).value;if(""==s)return bootbox.alert("Debe ingresar la cantidad solicitada para cada producto seleccionado"),void(r=!1);t.record.warehouse_products.push({id:o,requested:s})}),1==r&&t.createRecord(e)}}},i=r("KHd+"),a=Object(i.a)(s,function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("section",{attrs:{id:"WarehouseRequestStaffForm"}},[r("div",{staticClass:"card-body"},[e.errors.length>0?r("div",{staticClass:"alert alert-danger"},[r("div",{staticClass:"container"},[e._m(0),e._v(" "),r("strong",[e._v("Cuidado!")]),e._v(" Debe verificar los siguientes errores antes de continuar:\n\t\t\t\t\t"),r("button",{staticClass:"close",attrs:{type:"button","data-dismiss":"alert","aria-label":"Close"},on:{click:function(t){t.preventDefault(),e.errors=[]}}},[e._m(1)]),e._v(" "),r("ul",e._l(e.errors,function(t){return r("li",[e._v(e._s(t))])}),0)])]):e._e(),e._v(" "),r("div",{staticClass:"row"},[e._m(2),e._v(" "),r("div",{staticClass:"col-md-4",attrs:{id:"helpWarehouseRequestDate"}},[r("div",{staticClass:"form-group is-required"},[r("label",[e._v("Fecha de la Solicitud")]),e._v(" "),r("input",{directives:[{name:"model",rawName:"v-model",value:e.record.created_at,expression:"record.created_at"}],staticClass:"form-control input-sm",attrs:{type:"text","data-toggle":"tooltip",title:"Fecha de la solicitud",readonly:"readonly"},domProps:{value:e.record.created_at},on:{input:function(t){t.target.composing||e.$set(e.record,"created_at",t.target.value)}}}),e._v(" "),r("input",{directives:[{name:"model",rawName:"v-model",value:e.record.id,expression:"record.id"}],attrs:{type:"hidden"},domProps:{value:e.record.id},on:{input:function(t){t.target.composing||e.$set(e.record,"id",t.target.value)}}})])]),e._v(" "),r("div",{staticClass:"col-md-8",attrs:{id:"helpWarehouseRequestMotive"}},[r("div",{staticClass:"form-group is-required"},[r("label",[e._v("Motivo de la Solicitud")]),e._v(" "),r("ckeditor",{staticClass:"form-control",attrs:{editor:e.ckeditor.editor,"data-toggle":"tooltip",title:"Indique el motivo de la solicitud (requerido)",config:e.ckeditor.editorConfig,"tag-name":"textarea",rows:"3"},model:{value:e.record.motive,callback:function(t){e.$set(e.record,"motive",t)},expression:"record.motive"}})],1)]),e._v(" "),r("div",{staticClass:"col-md-4",attrs:{id:"helpWarehouseRequestDepartment"}},[r("div",{staticClass:" form-group is-required"},[r("label",[e._v("Departamento")]),e._v(" "),r("select2",{attrs:{options:e.departments},model:{value:e.record.department_id,callback:function(t){e.$set(e.record,"department_id",t)},expression:"record.department_id"}})],1)]),e._v(" "),r("div",{staticClass:"col-md-4",attrs:{id:"helpWarehouseRequestPosition"}},[r("div",{staticClass:" form-group is-required"},[r("label",[e._v("Cargo")]),e._v(" "),r("select2",{attrs:{options:e.payroll_positions},model:{value:e.record.payroll_position_id,callback:function(t){e.$set(e.record,"payroll_position_id",t)},expression:"record.payroll_position_id"}})],1)]),e._v(" "),r("div",{staticClass:"col-md-4",attrs:{id:"helpWarehouseRequestStaff"}},[r("div",{staticClass:" form-group is-required"},[r("label",[e._v("Solicitante")]),e._v(" "),r("select2",{attrs:{options:e.payroll_staffs},model:{value:e.record.payroll_staff_id,callback:function(t){e.$set(e.record,"payroll_staff_id",t)},expression:"record.payroll_staff_id"}})],1)])]),e._v(" "),r("hr"),e._v(" "),r("v-client-table",{attrs:{id:"helpTable",columns:e.columns,data:e.records,options:e.table_options},on:{"row-click":e.toggleActive},scopedSlots:e._u([{key:"check",fn:function(t){return r("div",{staticClass:"text-center"},[r("label",{staticClass:"form-checkbox"},[r("input",{directives:[{name:"model",rawName:"v-model",value:e.selected,expression:"selected"}],staticClass:"cursor-pointer",attrs:{type:"checkbox",id:"checkbox_"+t.row.id},domProps:{value:t.row.id,checked:Array.isArray(e.selected)?e._i(e.selected,t.row.id)>-1:e.selected},on:{change:function(r){var o=e.selected,s=r.target,i=!!s.checked;if(Array.isArray(o)){var a=t.row.id,c=e._i(o,a);s.checked?c<0&&(e.selected=o.concat([a])):c>-1&&(e.selected=o.slice(0,c).concat(o.slice(c+1)))}else e.selected=i}}})])])}},{key:"description",fn:function(t){return r("div",{},[r("span",[r("b",[e._v(" "+e._s(t.row.warehouse_product?t.row.warehouse_product.name+": ":"")+" ")]),e._v("\n\t\t\t\t\t\t"+e._s(t.row.warehouse_product?t.row.warehouse_product.description:"")+"\n\t\t\t\t\t")]),e._v(" "),r("span",[e._l(t.row.warehouse_product_values,function(t){return r("div",[r("b",[e._v(e._s(t.warehouse_product_attribute.name+":"))]),e._v(" "+e._s(t.value)+"\n\t\t\t\t\t\t")])}),e._v(" "),r("b",[e._v("Valor:")]),e._v(" "+e._s(t.row.unit_value)+" "+e._s(t.row.currency?t.row.currency.name:"")+"\n\t\t\t\t\t")],2)])}},{key:"inventory",fn:function(t){return r("div",{},[r("span",[r("b",[e._v("Almacén:")]),e._v(" "+e._s(t.row.warehouse_institution_warehouse.warehouse.name)+" "),r("br"),e._v(" "),r("b",[e._v("Existencia:")]),e._v(" "+e._s(t.row.exist)),r("br"),e._v(" "),r("b",[e._v("Reservados:")]),e._v(" "+e._s(null===t.row.reserved?"0":t.row.reserved)+"\n\t\t\t\t\t")])])}},{key:"requested",fn:function(t){return r("div",{},[r("div",[r("input",{staticClass:"form-control table-form input-sm",attrs:{type:"number","data-toggle":"tooltip",min:"0",max:t.row.exist,id:"request_product_"+t.row.id,onfocus:"this.select()"},on:{input:function(r){return e.selectElement(t.row.id)}}})])])}}])},[r("div",{staticClass:"text-center",attrs:{slot:"h__check"},slot:"h__check"},[r("label",{staticClass:"form-checkbox"},[r("input",{directives:[{name:"model",rawName:"v-model",value:e.selectAll,expression:"selectAll"}],staticClass:"cursor-pointer",attrs:{type:"checkbox"},domProps:{checked:Array.isArray(e.selectAll)?e._i(e.selectAll,null)>-1:e.selectAll},on:{click:function(t){return e.select()},change:function(t){var r=e.selectAll,o=t.target,s=!!o.checked;if(Array.isArray(r)){var i=e._i(r,null);o.checked?i<0&&(e.selectAll=r.concat([null])):i>-1&&(e.selectAll=r.slice(0,i).concat(r.slice(i+1)))}else e.selectAll=s}}})])])])],1),e._v(" "),r("div",{staticClass:"card-footer text-right"},[r("div",{staticClass:"row"},[r("div",{staticClass:"col-md-3 offset-md-9",attrs:{id:"helpParamButtons"}},[r("button",{staticClass:"btn btn-default btn-icon btn-round",attrs:{type:"button",title:"Borrar datos del formulario"},on:{click:function(t){return e.reset()}}},[r("i",{staticClass:"fa fa-eraser"})]),e._v(" "),e._m(3),e._v(" "),r("button",{staticClass:"btn btn-success btn-icon btn-round btn-modal-save",attrs:{type:"button",title:"Guardar registro"},on:{click:function(t){return e.createRequest("warehouse/requests/staff")}}},[r("i",{staticClass:"fa fa-save"})])])])])])},[function(){var e=this.$createElement,t=this._self._c||e;return t("div",{staticClass:"alert-icon"},[t("i",{staticClass:"now-ui-icons objects_support-17"})])},function(){var e=this.$createElement,t=this._self._c||e;return t("span",{attrs:{"aria-hidden":"true"}},[t("i",{staticClass:"now-ui-icons ui-1_simple-remove"})])},function(){var e=this.$createElement,t=this._self._c||e;return t("div",{staticClass:"col-md-12"},[t("b",[this._v("Datos de la Solicitud")])])},function(){var e=this.$createElement,t=this._self._c||e;return t("button",{staticClass:"btn btn-warning btn-icon btn-round btn-modal-close",attrs:{type:"button","data-dismiss":"modal",title:"Cancelar y regresar"}},[t("i",{staticClass:"fa fa-ban"})])}],!1,null,null,null);t.default=a.exports}}]);