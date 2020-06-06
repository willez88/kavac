(window.webpackJsonp=window.webpackJsonp||[]).push([[25],{"/V+G":function(t,e,o){"use strict";o.r(e);var n={data:function(){return{records:[],errors:[],columns:["code","type","motive","created_at","state","id"],types:[{id:"",text:"Seleccione..."},{id:1,text:"Prestamo de Equipos (Uso Interno)"},{id:2,text:"Prestamo de Equipos (Uso Externo)"},{id:3,text:"Prestamo de Equipos para Agentes Externos"}]}},created:function(){this.table_options.headings={code:"Código",type:"Tipo de Solicitud",motive:"Motivo",created_at:"Fecha de Emisión",state:"Estado de la Solicitud",id:"Acción"},this.table_options.sortable=["code","type","motive","created_at","state"],this.table_options.filterable=["code","type","motive","created_at","state"]},mounted:function(){this.initRecords(this.route_list,"")},methods:{reset:function(){},deliverEquipment:function(t){var e=this,o=this.records[t-1],n=this.records[t-1].id;axios.put("/asset/requests/deliver-equipment/"+n,o).then((function(t){void 0!==t.data.redirect?location.href=t.data.redirect:(e.readRecords(url),e.reset(),e.showMessage("update"))})).catch((function(t){if(e.errors=[],void 0!==t.response)for(var o in t.response.data.errors)t.response.data.errors[o]&&e.errors.push(t.response.data.errors[o][0])}))},deleteRecord:function(t,e){e=e||this.route_delete;var o=this.records,n=!1,i=(t=t-1,this);bootbox.confirm({title:"Eliminar registro?",message:"Esta seguro de eliminar este registro?",buttons:{cancel:{label:'<i class="fa fa-times"></i> Cancelar'},confirm:{label:'<i class="fa fa-check"></i> Confirmar'}},callback:function(s){s&&(n=!0,axios.delete(e+"/"+o[t].id).then((function(t){if(void 0!==t.data.error)return i.showMessage("custom","Alerta!","warning","screen-error",t.data.message),!1;void 0!==t.data.redirect&&(location.href=t.data.redirect)})).catch((function(t){i.logs("mixins.js",498,t,"deleteRecord")})))}}),n&&void 0!==response.data.redirect&&(location.href=response.data.redirect)}}},i=o("KHd+"),s=Object(i.a)(n,(function(){var t=this,e=t.$createElement,o=t._self._c||e;return o("div",{staticClass:"col-md-12"},[o("hr"),t._v(" "),o("v-client-table",{attrs:{columns:t.columns,data:t.records,options:t.table_options},scopedSlots:t._u([{key:"code",fn:function(e){return o("div",{staticClass:"text-center"},[o("span",[t._v("\n\t\t\t\t"+t._s(e.row.code)+"\n\t\t\t")])])}},{key:"type",fn:function(e){return o("div",{staticClass:"text-center"},t._l(t.types,(function(n){return o("div",[e.row.type==n.id?o("span",[t._v("\n\t\t\t\t\t"+t._s(n.text)+"\n\t\t\t\t")]):t._e()])})),0)}},{key:"id",fn:function(e){return o("div",{staticClass:"text-center d-inline-flex"},[o("asset-request-info",{attrs:{route_list:"requests/vue-info/"+e.row.id}}),t._v(" "),o("asset-request-extension",{attrs:{requestid:e.row.id,state:e.row.state}}),t._v(" "),o("asset-request-event",{attrs:{id:e.row.id,state:e.row.state}}),t._v(" "),o("button",{staticClass:"btn btn-primary btn-xs btn-icon btn-action",attrs:{disabled:"Aprobado"!=e.row.state&&"Pendiente por entrega"!=e.row.state,"data-toggle":"tooltip",title:"Entregar Equipos",type:"button"},on:{click:function(o){return t.deliverEquipment(e.index)}}},[o("i",{staticClass:"icofont icofont-computer"})]),t._v(" "),o("button",{staticClass:"btn btn-warning btn-xs btn-icon btn-action",attrs:{disabled:"Pendiente"!=e.row.state,title:"Editar Solicitud","data-toggle":"tooltip",type:"button"},on:{click:function(o){return t.editForm(e.row.id)}}},[o("i",{staticClass:"icofont icofont-edit"})]),t._v(" "),o("button",{staticClass:"btn btn-danger btn-xs btn-icon btn-action",attrs:{title:"Eliminar registro","data-toggle":"tooltip",type:"button"},on:{click:function(o){return t.deleteRecord(e.index,"")}}},[o("i",{staticClass:"fa fa-trash-o"})])],1)}}])})],1)}),[],!1,null,null,null);e.default=s.exports},"KHd+":function(t,e,o){"use strict";function n(t,e,o,n,i,s,r,a){var c,d="function"==typeof t?t.options:t;if(e&&(d.render=e,d.staticRenderFns=o,d._compiled=!0),n&&(d.functional=!0),s&&(d._scopeId="data-v-"+s),r?(c=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),i&&i.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(r)},d._ssrRegister=c):i&&(c=a?function(){i.call(this,(d.functional?this.parent:this).$root.$options.shadowRoot)}:i),c)if(d.functional){d._injectStyles=c;var l=d.render;d.render=function(t,e){return c.call(e),l(t,e)}}else{var u=d.beforeCreate;d.beforeCreate=u?[].concat(u,c):[c]}return{exports:t,options:d}}o.d(e,"a",(function(){return n}))}}]);