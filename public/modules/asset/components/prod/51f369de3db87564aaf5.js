(window.webpackJsonp=window.webpackJsonp||[]).push([[22],{"KHd+":function(t,e,s){"use strict";function a(t,e,s,a,r,o,n,i){var d,c="function"==typeof t?t.options:t;if(e&&(c.render=e,c.staticRenderFns=s,c._compiled=!0),a&&(c.functional=!0),o&&(c._scopeId="data-v-"+o),n?(d=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),r&&r.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(n)},c._ssrRegister=d):r&&(d=i?function(){r.call(this,(c.functional?this.parent:this).$root.$options.shadowRoot)}:r),d)if(c.functional){c._injectStyles=d;var l=c.render;c.render=function(t,e){return d.call(e),l(t,e)}}else{var u=c.beforeCreate;c.beforeCreate=u?[].concat(u,d):[d]}return{exports:t,options:c}}s.d(e,"a",(function(){return a}))},cs2j:function(t,e,s){"use strict";s.r(e);var a={data:function(){return{record:{id:"",date:"",asset_request_id:""},records:[],errors:[]}},props:{requestid:Number,state:String},methods:{reset:function(){this.record={id:"",date:"",asset_request_id:""}},initRecords:function(t,e){var s=this;s.errors=[];var a={};t="requests/vue-info/"+this.requestid;axios.get(t).then((function(t){void 0!==t.data.records&&(a=t.data.records,s.record={id:"",date:a.delivery_date,asset_request_id:s.requestid}),$("#"+e).length&&$("#"+e).modal("show")})).catch((function(t){void 0!==t.response&&(403==t.response.status?s.showMessage("custom","Acceso Denegado","danger","screen-error",t.response.data.message):s.logs("resources/js/all.js",343,t,"initRecords"))}))},viewMessage:function(){return this.showMessage("custom","Alerta","danger","screen-error","La solicitud está en un tramite que no le permite acceder a esta funcionalidad"),!1}}},r=s("KHd+"),o=Object(r.a)(a,(function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",[s("a",{staticClass:"btn btn-default btn-xs btn-icon btn-action",attrs:{href:"#",title:"Solicitud de Prorroga","data-toggle":"tooltip",disabled:"Aprobado"!=t.state&&"Pendiente por entrega"!=t.state},on:{click:function(e){"Aprobado"==t.state||"Pendiente por entrega"==t.state?t.addRecord("add_prorroga","request/request-extensions",e):t.viewMessage()}}},[s("i",{staticClass:"fa fa-calendar-plus-o"})]),t._v(" "),s("div",{staticClass:"modal fade text-left",attrs:{tabindex:"-1",role:"dialog",id:"add_prorroga"}},[s("div",{staticClass:"modal-dialog modal-xs"},[s("div",{staticClass:"modal-content"},[t._m(0),t._v(" "),s("div",{staticClass:"modal-body"},[t.errors.length>0?s("div",{staticClass:"alert alert-danger"},[s("div",{staticClass:"container"},[t._m(1),t._v(" "),s("strong",[t._v("Cuidado!")]),t._v(" Debe verificar los siguientes errores antes de continuar:\n\t\t\t\t\t\t\t"),s("button",{staticClass:"close",attrs:{type:"button","data-dismiss":"alert","aria-label":"Close"},on:{click:function(e){e.preventDefault(),t.errors=[]}}},[t._m(2)]),t._v(" "),s("ul",t._l(t.errors,(function(e){return s("li",[t._v(t._s(e))])})),0)])]):t._e(),t._v(" "),s("div",{staticClass:"row"},[s("div",{staticClass:"col-md-6"},[s("div",{staticClass:"form-group"},[s("label",[t._v("Fecha de Entrega Actual")]),t._v(" "),s("input",{directives:[{name:"model",rawName:"v-model",value:t.record.date,expression:"record.date"}],staticClass:"form-control input-sm",attrs:{type:"date","data-toggle":"tooltip",id:"delivery_date"},domProps:{value:t.record.date},on:{input:function(e){e.target.composing||t.$set(t.record,"date",e.target.value)}}}),t._v(" "),s("input",{directives:[{name:"model",rawName:"v-model",value:t.record.id,expression:"record.id"}],attrs:{type:"hidden"},domProps:{value:t.record.id},on:{input:function(e){e.target.composing||t.$set(t.record,"id",e.target.value)}}})])])])]),t._v(" "),s("div",{staticClass:"modal-footer"},[s("button",{staticClass:"btn btn-default btn-sm btn-round btn-modal-close",attrs:{type:"button","data-dismiss":"modal"}},[t._v("\n                \t\tCerrar\n                \t")]),t._v(" "),s("button",{staticClass:"btn btn-primary btn-sm btn-round btn-modal-save",attrs:{type:"button"},on:{click:function(e){return t.createRecord("asset/requests/request-extensions")}}},[t._v("\n                \t\tGuardar\n\t                ")])])])])])])}),[function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"modal-header"},[e("button",{staticClass:"close",attrs:{type:"button","data-dismiss":"modal","aria-label":"Close"}},[e("span",{attrs:{"aria-hidden":"true"}},[this._v("×")])]),this._v(" "),e("h6",[e("i",{staticClass:"icofont icofont-meeting-add ico-2x"}),this._v("\n\t\t\t\t\t\tSolicitud de Prorroga\n\t\t\t\t\t")])])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"alert-icon"},[e("i",{staticClass:"now-ui-icons objects_support-17"})])},function(){var t=this.$createElement,e=this._self._c||t;return e("span",{attrs:{"aria-hidden":"true"}},[e("i",{staticClass:"now-ui-icons ui-1_simple-remove"})])}],!1,null,null,null);e.default=o.exports}}]);