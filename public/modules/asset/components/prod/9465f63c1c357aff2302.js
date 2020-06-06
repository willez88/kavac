(window.webpackJsonp=window.webpackJsonp||[]).push([[11],{"KHd+":function(t,s,a){"use strict";function e(t,s,a,e,i,n,o,r){var l,c="function"==typeof t?t.options:t;if(s&&(c.render=s,c.staticRenderFns=a,c._compiled=!0),e&&(c.functional=!0),n&&(c._scopeId="data-v-"+n),o?(l=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),i&&i.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(o)},c._ssrRegister=l):i&&(l=r?function(){i.call(this,(c.functional?this.parent:this).$root.$options.shadowRoot)}:i),l)if(c.functional){c._injectStyles=l;var d=c.render;c.render=function(t,s){return l.call(s),d(t,s)}}else{var v=c.beforeCreate;c.beforeCreate=v?[].concat(v,l):[l]}return{exports:t,options:c}}a.d(s,"a",(function(){return e}))},eWwq:function(t,s,a){"use strict";a.r(s);var e={data:function(){return{records:[],errors:[],columns:["asset.inventory_serial","asset.serial","asset.marca","asset.model"]}},created:function(){this.table_options.headings={"asset.inventory_serial":"Código","asset.serial":"Serial","asset.marca":"Marca","asset.model":"Modelo"},this.table_options.sortable=["asset.inventory_serial","asset.serial","asset.marca","asset.model"],this.table_options.filterable=["asset.inventory_serial","asset.serial","asset.marca","asset.model"],this.table_options.orderBy={column:"asset.id"}},methods:{reset:function(){},initRecords:function(t,s){this.errors=[],this.reset();var a=this,e={};document.getElementById("info_general").click(),axios.get(t).then((function(t){void 0!==t.data.records&&(e=t.data.records,$(".modal-body #id").val(e.id),document.getElementById("date").innerText=e.date?e.date:e.created_at,document.getElementById("motive").innerText=e.asset_disincorporation_motive?e.asset_disincorporation_motive.name:"N/A",document.getElementById("observation").innerText=e.observation?e.observation:"N/A"),$("#"+s).length&&$("#"+s).modal("show")})).catch((function(t){void 0!==t.response&&(403==t.response.status?a.showMessage("custom","Acceso Denegado","danger","screen-error",t.response.data.message):a.logs("resources/js/all.js",343,t,"initRecords"))}))},loadEquipment:function(){var t=this,s=$(".modal-body #id").val();axios.get("/asset/disincorporations/vue-info/"+s).then((function(s){t.records=s.data.records.asset_disincorporation_assets}))}}},i=a("KHd+"),n=Object(i.a)(e,(function(){var t=this,s=t.$createElement,a=t._self._c||s;return a("div",[a("a",{staticClass:"btn btn-info btn-xs btn-icon btn-action",attrs:{href:"#",title:"Ver información del registro","data-toggle":"tooltip"},on:{click:function(s){return t.addRecord("view_disincorporation",t.route_list,s)}}},[a("i",{staticClass:"fa fa-info-circle"})]),t._v(" "),a("div",{staticClass:"modal fade text-left",attrs:{tabindex:"-1",role:"dialog",id:"view_disincorporation"}},[a("div",{staticClass:"modal-dialog modal-lg"},[a("div",{staticClass:"modal-content"},[t._m(0),t._v(" "),a("div",{staticClass:"modal-body"},[t.errors.length>0?a("div",{staticClass:"alert alert-danger"},[a("ul",t._l(t.errors,(function(s){return a("li",[t._v(t._s(s))])})),0)]):t._e(),t._v(" "),a("ul",{staticClass:"nav nav-tabs custom-tabs justify-content-center",attrs:{role:"tablist"}},[t._m(1),t._v(" "),a("li",{staticClass:"nav-item"},[a("a",{staticClass:"nav-link",attrs:{"data-toggle":"tab",href:"#equipment",role:"tab"},on:{click:function(s){return t.loadEquipment()}}},[a("i",{staticClass:"ion-arrow-swap"}),t._v(" Equipos Desincorporados\n                            ")])])]),t._v(" "),a("div",{staticClass:"tab-content"},[t._m(2),t._v(" "),a("div",{staticClass:"tab-pane",attrs:{id:"equipment",role:"tabpanel"}},[a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-12"},[a("hr"),t._v(" "),a("v-client-table",{attrs:{columns:t.columns,data:t.records,options:t.table_options}})],1)])])])]),t._v(" "),t._m(3)])])])])}),[function(){var t=this.$createElement,s=this._self._c||t;return s("div",{staticClass:"modal-header"},[s("button",{staticClass:"close",attrs:{type:"button","data-dismiss":"modal","aria-label":"Close"}},[s("span",{attrs:{"aria-hidden":"true"}},[this._v("×")])]),this._v(" "),s("h6",[s("i",{staticClass:"icofont icofont-read-book ico-2x"}),this._v("\n\t\t\t\t\t\tInformación de la Desincorporación Registrada\n\t\t\t\t\t")])])},function(){var t=this.$createElement,s=this._self._c||t;return s("li",{staticClass:"nav-item"},[s("a",{staticClass:"nav-link active",attrs:{"data-toggle":"tab",href:"#general",id:"info_general",role:"tab"}},[s("i",{staticClass:"ion-android-person"}),this._v(" Información General\n                            ")])])},function(){var t=this,s=t.$createElement,a=t._self._c||s;return a("div",{staticClass:"tab-pane active",attrs:{id:"general",role:"tabpanel"}},[a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-6"},[a("div",{staticClass:"form-group"},[a("strong",[t._v("Fecha de la Desincorporación")]),t._v(" "),a("div",{staticClass:"row",staticStyle:{margin:"1px 0"}},[a("span",{staticClass:"col-md-12",attrs:{id:"date"}})]),t._v(" "),a("input",{attrs:{type:"hidden",id:"id"}})])]),t._v(" "),a("div",{staticClass:"col-md-6"},[a("div",{staticClass:"form-group"},[a("strong",[t._v("Motivo")]),t._v(" "),a("div",{staticClass:"row",staticStyle:{margin:"1px 0"}},[a("span",{staticClass:"col-md-12",attrs:{id:"motive"}})])])]),t._v(" "),a("div",{staticClass:"col-md-6"},[a("div",{staticClass:"form-group"},[a("strong",[t._v("Observaciones")]),t._v(" "),a("div",{staticClass:"row",staticStyle:{margin:"1px 0"}},[a("span",{staticClass:"col-md-12",attrs:{id:"observation"}})])])])])])},function(){var t=this.$createElement,s=this._self._c||t;return s("div",{staticClass:"modal-footer"},[s("button",{staticClass:"btn btn-default btn-sm btn-round btn-modal-close",attrs:{type:"button","data-dismiss":"modal"}},[this._v("\n                \t\tCerrar\n                \t")])])}],!1,null,null,null);s.default=n.exports}}]);