(window.webpackJsonp=window.webpackJsonp||[]).push([[12],{"2xbQ":function(t,e,n){"use strict";n.r(e);var o={data:function(){return{records:[],columns:["code","motive","created","id"]}},created:function(){this.table_options.headings={code:"Código",motive:"Motivo",created:"Fecha de la Desincorporación",id:"Acción"},this.table_options.sortable=["code","motive","created"],this.table_options.filterable=["code","motive","created"],this.table_options.orderBy={column:"code"}},mounted:function(){this.initRecords(this.route_list,"")},methods:{reset:function(){}}},i=n("KHd+"),s=Object(i.a)(o,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("v-client-table",{attrs:{columns:t.columns,data:t.records,options:t.table_options},scopedSlots:t._u([{key:"code",fn:function(e){return n("div",{staticClass:"text-center"},[n("span",[t._v("\n\t\t\t"+t._s(e.row.code)+"\n\t\t")])])}},{key:"motive",fn:function(e){return n("div",{staticClass:"text-center"},[n("span",[t._v("\n\t\t\t"+t._s(e.row.asset_disincorporation_motive?e.row.asset_disincorporation_motive.name:"N/A")+"\n\t\t")])])}},{key:"created",fn:function(e){return n("div",{staticClass:"text-center"},[n("span",[t._v("\n\t\t\t"+t._s(e.row.date?e.row.date:e.row.created_at)+"\n\t\t")])])}},{key:"id",fn:function(e){return n("div",{staticClass:"text-center"},[n("div",{staticClass:"d-inline-flex"},[n("asset-disincorporation-info",{attrs:{route_list:"disincorporations/vue-info/"+e.row.id}}),t._v(" "),n("button",{staticClass:"btn btn-warning btn-xs btn-icon btn-action",attrs:{title:"Modificar registro","data-toggle":"tooltip",type:"button"},on:{click:function(n){return t.editForm(e.row.id)}}},[n("i",{staticClass:"fa fa-edit"})]),t._v(" "),n("button",{staticClass:"btn btn-danger btn-xs btn-icon btn-action",attrs:{title:"Eliminar registro","data-toggle":"tooltip",type:"button"},on:{click:function(n){return t.deleteRecord(e.index,"")}}},[n("i",{staticClass:"fa fa-trash-o"})])],1)])}}])})}),[],!1,null,null,null);e.default=s.exports},"KHd+":function(t,e,n){"use strict";function o(t,e,n,o,i,s,r,a){var c,d="function"==typeof t?t.options:t;if(e&&(d.render=e,d.staticRenderFns=n,d._compiled=!0),o&&(d.functional=!0),s&&(d._scopeId="data-v-"+s),r?(c=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),i&&i.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(r)},d._ssrRegister=c):i&&(c=a?function(){i.call(this,(d.functional?this.parent:this).$root.$options.shadowRoot)}:i),c)if(d.functional){d._injectStyles=c;var l=d.render;d.render=function(t,e){return c.call(e),l(t,e)}}else{var u=d.beforeCreate;d.beforeCreate=u?[].concat(u,c):[c]}return{exports:t,options:d}}n.d(e,"a",(function(){return o}))}}]);