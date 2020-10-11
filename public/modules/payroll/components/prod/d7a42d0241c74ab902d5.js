(window.webpackJsonp=window.webpackJsonp||[]).push([[17],{ChC2:function(t,s,e){"use strict";e.r(s);var a={data:function(){return{records:[],record:[],columns:["payroll_staff.first_name","payroll_instruction_degree.name","professions","is_student","id"]}},created:function(){this.table_options.headings={"payroll_staff.first_name":"Trabajador","payroll_instruction_degree.name":"Grado de Instrucción",professions:"Profesión",is_student:"¿Es Estudiante?",id:"Acción"},this.table_options.sortable=["payroll_staff.first_name","payroll_instruction_degree.name"],this.table_options.filterable=["payroll_staff.first_name","payroll_instruction_degree.name"]},mounted:function(){this.initRecords(this.route_list,"")},methods:{reset:function(){},show_info:function(t){var s=this;axios.get("/payroll/professionals/"+t).then(function(t){s.record=t.data.record,$("#payroll_staff").val(s.record.payroll_staff.first_name+" "+s.record.payroll_staff.last_name),$("#payroll_instruction_degree").val(s.record.payroll_instruction_degree.name),$("#instruction_degree_name").val(s.record.instruction_degree_name),s.record.is_student?$("#is_student").bootstrapSwitch("state",!0):$("#is_student").bootstrapSwitch("state",!1),$("#payroll_study_type").val(s.record.payroll_study_type?s.record.payroll_study_type.name:" "),$("#study_program_name").val(s.record.study_program_name),$("#class_schedule").val(s.record.class_schedule)}),$("#show_professional").modal("show")}}},o=e("KHd+"),i=Object(o.a)(a,function(){var t=this,s=t.$createElement,e=t._self._c||s;return e("div",[e("v-client-table",{attrs:{columns:t.columns,data:t.records,options:t.table_options},scopedSlots:t._u([{key:"id",fn:function(s){return e("div",{staticClass:"text-center"},[t.route_show?e("button",{staticClass:"btn btn-info btn-xs btn-icon btn-action btn-tooltip",attrs:{title:"Ver registro","data-toggle":"tooltip","data-placement":"bottom",type:"button"},on:{click:function(e){return t.show_info(s.row.id)}}},[e("i",{staticClass:"fa fa-eye"})]):t._e(),t._v(" "),s.row.assigned?t._e():e("button",{staticClass:"btn btn-warning btn-xs btn-icon btn-action btn-tooltip",attrs:{title:"Modificar registro","data-toggle":"tooltip","data-placement":"bottom",type:"button"},on:{click:function(e){return t.editForm(s.row.id)}}},[e("i",{staticClass:"fa fa-edit"})]),t._v(" "),e("button",{staticClass:"btn btn-danger btn-xs btn-icon btn-action btn-tooltip",attrs:{title:"Eliminar registro","data-toggle":"tooltip","data-placement":"bottom",type:"button"},on:{click:function(e){return t.deleteRecord(s.index,"")}}},[e("i",{staticClass:"fa fa-trash-o"})])])}},{key:"professions",fn:function(s){return e("div",{staticClass:"text-center"},t._l(s.row.professions,function(s){return e("span",[e("div",[t._v("\n                    "+t._s(s.name)+"\n                ")])])}),0)}},{key:"is_student",fn:function(s){return e("div",{staticClass:"text-center"},[s.row.is_student?e("span",[t._v("SI")]):e("span",[t._v("NO")])])}}])}),t._v(" "),e("div",{staticClass:"modal fade",attrs:{tabindex:"-1",role:"dialog",id:"show_professional"}},[e("div",{staticClass:"modal-dialog modal-lg",attrs:{role:"document"}},[e("div",{staticClass:"modal-content"},[t._m(0),t._v(" "),e("div",{staticClass:"modal-body"},[e("div",{staticClass:"row"},[t._m(1),t._v(" "),t._m(2),t._v(" "),e("div",{staticClass:"col-md-4"},[e("div",{staticClass:"form-group"},[e("label",[t._v("Profesiones")]),t._v(" "),e("v-multiselect",{attrs:{options:t.record.professions?t.record.professions:[],track_by:"name",hide_selected:!1,selected:t.record.professions?t.record.professions:[]}})],1)]),t._v(" "),t._m(3)]),t._v(" "),e("hr"),t._v(" "),t._m(4),t._v(" "),e("div",{staticClass:"row"},[t._m(5),t._v(" "),t._m(6),t._v(" "),e("div",{staticClass:"col-md-4"},[e("div",{staticClass:"form-group"},[e("label",[t._v("Horario de Clase")]),t._v(" "),e("ckeditor",{staticClass:"form-control",attrs:{editor:t.ckeditor.editor,id:"class_schedule","data-toggle":"tooltip",title:"Indique el horario de clase",config:t.ckeditor.editorConfig,name:"class_schedule","tag-name":"textarea",rows:"4"}})],1)])]),t._v(" "),e("hr"),t._v(" "),t._m(7),t._v(" "),t._l(t.record.payroll_languages,function(s,a){return e("div",{staticClass:"row"},[e("div",{staticClass:"col-md-4"},[e("div",{staticClass:"form-group"},[e("label",[t._v("Idioma")]),t._v(" "),e("input",{staticClass:"form-control input-sm",attrs:{type:"text","data-toggle":"tooltip",disabled:"true"},domProps:{value:s.name}})])]),t._v(" "),e("div",{staticClass:"col-md-4"},[e("div",{staticClass:"form-group"},[e("label",[t._v("Dominio del Idioma")]),t._v(" "),e("input",{staticClass:"form-control input-sm",attrs:{type:"text","data-toggle":"tooltip",disabled:"true"},domProps:{value:t.record.payroll_language_levels[a].name}})])])])})],2)])])])],1)},[function(){var t=this.$createElement,s=this._self._c||t;return s("div",{staticClass:"modal-header"},[s("button",{staticClass:"close",attrs:{type:"button","data-dismiss":"modal","aria-label":"Close"}},[s("span",{attrs:{"aria-hidden":"true"}},[this._v("×")])]),this._v(" "),s("h6",[s("i",{staticClass:"icofont icofont-read-book ico-2x"}),this._v("\n                        Información Detallada de Datos Profesionales\n                    ")])])},function(){var t=this.$createElement,s=this._self._c||t;return s("div",{staticClass:"col-md-4"},[s("div",{staticClass:"form-group"},[s("label",[this._v("Trabajador")]),this._v(" "),s("input",{staticClass:"form-control input-sm",attrs:{type:"text","data-toggle":"tooltip",disabled:"true",id:"payroll_staff"}})])])},function(){var t=this.$createElement,s=this._self._c||t;return s("div",{staticClass:"col-md-4"},[s("div",{staticClass:"form-group"},[s("label",[this._v("Grado de Instrucción")]),this._v(" "),s("input",{staticClass:"form-control input-sm",attrs:{type:"text","data-toggle":"tooltip",disabled:"true",id:"payroll_instruction_degree"}})])])},function(){var t=this.$createElement,s=this._self._c||t;return s("div",{staticClass:"col-md-4"},[s("div",{staticClass:"form-group"},[s("label",[this._v("Nombre de la Especialización, Maestría o Doctorado")]),this._v(" "),s("input",{staticClass:"form-control input-sm",attrs:{type:"text","data-toggle":"tooltip",disabled:"true",id:"instruction_degree_name"}})])])},function(){var t=this.$createElement,s=this._self._c||t;return s("div",{staticClass:"row"},[s("div",{staticClass:"col-md-6"},[s("div",{staticClass:"form-group"},[s("label",[this._v("¿Es Estudiante?")]),this._v(" "),s("div",{staticClass:"col-12 bootstrap-switch-mini"},[s("input",{staticClass:"form-control bootstrap-switch",attrs:{id:"is_student","data-on-label":"SI","data-off-label":"NO",type:"checkbox"}})])])])])},function(){var t=this.$createElement,s=this._self._c||t;return s("div",{staticClass:"col-md-4"},[s("div",{staticClass:"form-group"},[s("label",[this._v("Tipo de Estudio")]),this._v(" "),s("input",{staticClass:"form-control input-sm",attrs:{type:"text","data-toggle":"tooltip",disabled:"true",id:"payroll_study_type"}})])])},function(){var t=this.$createElement,s=this._self._c||t;return s("div",{staticClass:"col-md-4"},[s("div",{staticClass:"form-group"},[s("label",[this._v("Nombre del Programa de Estudio")]),this._v(" "),s("input",{staticClass:"form-control input-sm",attrs:{type:"text","data-toggle":"tooltip",disabled:"true",id:"study_program_name"}})])])},function(){var t=this.$createElement,s=this._self._c||t;return s("div",{staticClass:"row"},[s("div",{staticClass:"col-md-3"},[s("h6",{staticClass:"card-title"},[this._v("\n                                Detalles de Idioma\n                            ")])])])}],!1,null,null,null);s.default=i.exports},"KHd+":function(t,s,e){"use strict";function a(t,s,e,a,o,i,r,n){var l,d="function"==typeof t?t.options:t;if(s&&(d.render=s,d.staticRenderFns=e,d._compiled=!0),a&&(d.functional=!0),i&&(d._scopeId="data-v-"+i),r?(l=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),o&&o.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(r)},d._ssrRegister=l):o&&(l=n?function(){o.call(this,this.$root.$options.shadowRoot)}:o),l)if(d.functional){d._injectStyles=l;var c=d.render;d.render=function(t,s){return l.call(s),c(t,s)}}else{var _=d.beforeCreate;d.beforeCreate=_?[].concat(_,l):[l]}return{exports:t,options:d}}e.d(s,"a",function(){return a})}}]);