(window.webpackJsonp=window.webpackJsonp||[]).push([[17],{I90X:function(t,e,a){"use strict";a.r(e);var s={data:function(){return{records:[],errors:[],columns:["inventory_serial","serial","marca","model"]}},props:{operation:Object},created:function(){this.table_options.headings={inventory_serial:"Código",serial:"Serial",marca:"Marca",model:"Modelo"},this.table_options.sortable=["inventory_serial","serial","marca","model"],this.table_options.filterable=!1,this.table_options.orderBy={column:"inventory_serial"}},methods:{reset:function(){},initRecords:function(t,e){var a=this;a.errors=[],a.reset(),document.getElementById("info_general").click(),$(".modal-body #url_search").val(a.operation.type_operation+"/"+a.operation.code),document.getElementById("created_at").innerText=a.operation.created_at?a.operation.created_at:"N/A",document.getElementById("type_operation").innerText="registers"==a.operation.type_operation?"Registro de bienes":"asignations"==a.operation.type_operation?"Asignación de bienes":"requests"==a.operation.type_operation?"Solicitud de bienes":"disincorporations"==a.operation.type_operation?"Desincorporación de bienes":"N/A",document.getElementById("description").innerText=a.operation.description?a.operation.description:"N/A",$("#"+e).length&&$("#"+e).modal("show")},loadEquipment:function(){var t=this,e=$(".modal-body #url_search").val();axios.get(this.route_list+"/"+e).then((function(e){t.records=e.data.records}))}}},i=a("KHd+"),n=Object(i.a)(s,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("a",{staticClass:"btn btn-info btn-xs btn-icon btn-action",attrs:{href:"#",title:"Ver información de la operación","data-toggle":"tooltip"},on:{click:function(e){return t.addRecord("view_operation",t.route_list,e)}}},[a("i",{staticClass:"fa fa-info-circle"})]),t._v(" "),a("div",{staticClass:"modal fade text-left",attrs:{tabindex:"-1",role:"dialog",id:"view_operation"}},[a("div",{staticClass:"modal-dialog modal-lg"},[a("div",{staticClass:"modal-content"},[t._m(0),t._v(" "),a("div",{staticClass:"modal-body"},[t.errors.length>0?a("div",{staticClass:"alert alert-danger"},[a("ul",t._l(t.errors,(function(e){return a("li",[t._v(t._s(e))])})),0)]):t._e(),t._v(" "),a("ul",{staticClass:"nav nav-tabs custom-tabs justify-content-center",attrs:{role:"tablist"}},[t._m(1),t._v(" "),a("li",{staticClass:"nav-item"},[a("a",{staticClass:"nav-link",attrs:{"data-toggle":"tab",href:"#equipment",role:"tab"},on:{click:function(e){return t.loadEquipment()}}},[a("i",{staticClass:"ion-arrow-swap"}),t._v(" Equipos\n                            ")])])]),t._v(" "),a("div",{staticClass:"tab-content"},[t._m(2),t._v(" "),a("div",{staticClass:"tab-pane",attrs:{id:"equipment",role:"tabpanel"}},[t._m(3),t._v(" "),a("div",{staticClass:"modal-table"},[a("v-client-table",{attrs:{columns:t.columns,data:t.records,options:t.table_options},scopedSlots:t._u([{key:"inventory_serial",fn:function(e){return a("div",{staticClass:"text-center"},[a("span",[t._v("\n\t                                        "+t._s(e.row.asset?e.row.asset.inventory_serial:e.row.inventory_serial)+"\n\t                                    ")])])}},{key:"serial",fn:function(e){return a("div",{staticClass:"text-center"},[a("span",[t._v("\n\t                                        "+t._s(e.row.asset?e.row.asset.serial:e.row.serial)+"\n\t                                    ")])])}},{key:"marca",fn:function(e){return a("div",{staticClass:"text-center"},[a("span",[t._v("\n\t                                        "+t._s(e.row.asset?e.row.asset.marca:e.row.marca)+"\n\t                                    ")])])}},{key:"model",fn:function(e){return a("div",{staticClass:"text-center"},[a("span",[t._v("\n\t                                        "+t._s(e.row.asset?e.row.asset.model:e.row.model)+"\n\t                                    ")])])}}])})],1)])])]),t._v(" "),t._m(4)])])])])}),[function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"modal-header"},[e("button",{staticClass:"close",attrs:{type:"button","data-dismiss":"modal","aria-label":"Close"}},[e("span",{attrs:{"aria-hidden":"true"}},[this._v("×")])]),this._v(" "),e("h6",[e("i",{staticClass:"icofont icofont-read-book ico-2x"}),this._v("\n\t\t\t\t\t\tInformación de la Operación Registrada\n\t\t\t\t\t")])])},function(){var t=this.$createElement,e=this._self._c||t;return e("li",{staticClass:"nav-item"},[e("a",{staticClass:"nav-link active",attrs:{"data-toggle":"tab",href:"#general",id:"info_general",role:"tab"}},[e("i",{staticClass:"ion-android-person"}),this._v(" Información General\n                            ")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"tab-pane active",attrs:{id:"general",role:"tabpanel"}},[a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-6"},[a("div",{staticClass:"form-group"},[a("strong",[t._v("Fecha de la Operación")]),t._v(" "),a("div",{staticClass:"row",staticStyle:{margin:"1px 0"}},[a("span",{staticClass:"col-md-12",attrs:{id:"created_at"}})]),t._v(" "),a("input",{attrs:{type:"hidden",id:"url_search"}})])]),t._v(" "),a("div",{staticClass:"col-md-6"},[a("div",{staticClass:"form-group"},[a("strong",[t._v("Tipo de Operación")]),t._v(" "),a("div",{staticClass:"row",staticStyle:{margin:"1px 0"}},[a("span",{staticClass:"col-md-12",attrs:{id:"type_operation"}})])])]),t._v(" "),a("div",{staticClass:"col-md-12"},[a("div",{staticClass:"form-group"},[a("strong",[t._v("Descripción")]),t._v(" "),a("div",{staticClass:"row",staticStyle:{margin:"1px 0"}},[a("span",{staticClass:"col-md-12",attrs:{id:"description"}})])])])])])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"row"},[e("div",{staticClass:"col-md-12"},[e("span",{staticClass:"text-muted"},[this._v("\n\t                                    A continuación se muestran los equipos asociados a la operación.\n\t                                ")])])])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"modal-footer"},[e("button",{staticClass:"btn btn-default btn-sm btn-round btn-modal-close",attrs:{type:"button","data-dismiss":"modal"}},[this._v("\n                \t\tCerrar\n                \t")])])}],!1,null,null,null);e.default=n.exports},"KHd+":function(t,e,a){"use strict";function s(t,e,a,s,i,n,o,r){var l,c="function"==typeof t?t.options:t;if(e&&(c.render=e,c.staticRenderFns=a,c._compiled=!0),s&&(c.functional=!0),n&&(c._scopeId="data-v-"+n),o?(l=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),i&&i.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(o)},c._ssrRegister=l):i&&(l=r?function(){i.call(this,(c.functional?this.parent:this).$root.$options.shadowRoot)}:i),l)if(c.functional){c._injectStyles=l;var d=c.render;c.render=function(t,e){return l.call(e),d(t,e)}}else{var _=c.beforeCreate;c.beforeCreate=_?[].concat(_,l):[l]}return{exports:t,options:c}}a.d(e,"a",(function(){return s}))}}]);