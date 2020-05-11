<template>
	<div class="text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary"
		   href="#" title="Registros Tabuladores de Nómina" data-toggle="tooltip"
		   @click="addRecord('add_tabulator', 'salary-tabulators', $event)">
			<i class="icofont icofont-table ico-3x"></i>
			<span>Tabuladores de Nónima</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_tabulator">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-table ico-2x"></i>
							 Nuevo Tabulador
						</h6>
					</div>

					<div class="modal-body">
                		<div class="alert alert-danger" v-if="errors.length > 0">
                            <div class="container">
                                <div class="alert-icon">
                                    <i class="now-ui-icons objects_support-17"></i>
                                </div>
                                <strong>Cuidado!</strong> Debe verificar los siguientes errores antes de continuar:
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                                        @click.prevent="errors = []">
                                    <span aria-hidden="true">
                                        <i class="now-ui-icons ui-1_simple-remove"></i>
                                    </span>
                                </button>
                                <ul>
                                    <li v-for="error in errors">{{ error }}</li>
                                </ul>
                            </div>
                        </div>
						<div class="row">
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-4">
										<div class=" form-group is-required">
											<label>Código</label>
											<input type="text" placeholder="Código del tabulador" data-toggle="tooltip"
                                                   title="Indique el código del nuevo tabulador (requerido)"
													class="form-control input-sm" v-model="record.code">
											<input type="hidden" v-model="record.id">
										</div>
									</div>
									<div class="col-md-8">
										<div class=" form-group is-required">
											<label>Nombre</label>
											<input type="text" placeholder="Nombre del tabulador" data-toggle="tooltip"
                                                   class="form-control input-sm" v-model="record.name">
										</div>
									</div>
									<div class="col-md-4">
										<div class=" form-group">
											<label>¿Activa?</label>
											<div class="col-12">
                                                <div class="col-12 bootstrap-switch-mini">
    												<input type="checkbox" id="sel_active" data-toggle="tooltip"
                                                           name="active" class="form-control bootstrap-switch"
                                                           title="Indique si el tabulador esta activo"
    												       data-on-label="SI" data-off-label="NO"
    												       v-model="record.active" value="true">
                                                </div>
											</div>
										</div>
									</div>
									<div class="col-md-8">
										<div class=" form-group is-required">
											<label>Tipo de Personal</label>
											<select2 :options="payroll_staff_types"
                                                     v-model="record.payroll_staff_type_id"></select2>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group is-required">
											<label>Institución:</label>
											<select2 :options="institutions" v-model="record.institution_id"></select2>
					                    </div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>Moneda:</label>
											<select2 :options="currencies" v-model="record.currency_id"></select2>
					                    </div>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label>Descripción:</label>
                                    <ckeditor :editor="ckeditor.editor" id="description_tabulator" data-toggle="tooltip"
                                              title="Indique alguna descripción asociada al tabulador"
                                              :config="ckeditor.editorConfig" class="form-control"
                                              name="description_tabulator" tag-name="textarea" rows="2"
                                              v-model="record.description"></ckeditor>
			                    </div>
							</div>
						</div>

						<ul class="nav nav-tabs custom-tabs justify-content-center" role="tablist">
	                        <li class="nav-item">
	                            <a class="nav-link active" data-toggle="tab" href="#horizontal" id="tab_horizontal"
                                   role="tab">
	                                Escalafón Horizontal
	                            </a>
	                        </li>

	                        <li class="nav-item">
	                            <a class="nav-link" data-toggle="tab" href="#vertical" id="tab_vertical" role="tab">
	                                Escalafón Vertical
	                            </a>
	                        </li>
	                    </ul>

	                    <div class="tab-content">
	                    	<div class="tab-pane active" id="horizontal" role="tabpanel">
	                    		<div class="row">
		                			<div class="col-md-12">
		                				<strong>Agrupar por</strong>
		                			</div>
									<div class="col-md-3">
										<div class=" form-group">
											<label>Experiencia Laboral</label>
											<div class="col-12">
                                                <div class="col-12 bootstrap-switch-mini">
    												<input type="checkbox" name="group_by_years_h" value="experience"
    												       class="form-control bootstrap-switch bootstrap-switch-mini sel_clasification"
                                                           id="sel_experience_h" data-on-label="SI" data-off-label="NO">
                                                </div>
											</div>
										</div>
									</div>

									<div class="col-md-3">
										<div class=" form-group">
											<label>Antigüedad</label>
											<div class="col-12">
                                                <div class="col-12 bootstrap-switch-mini">
    												<input type="checkbox" name="group_by_years_h" value="antiquity"
                                                           class="form-control bootstrap-switch bootstrap-switch-mini sel_clasification" id="sel_antiquity_h" data-on-label="SI"
                                                           data-off-label="NO">
                                                </div>
											</div>
										</div>
									</div>

									<div class="col-md-3">
										<div class=" form-group">
											<label>Grado de Instrucción</label>
											<div class="col-12">
                                                <div class="col-12 bootstrap-switch-mini">
    												<input type="checkbox" name="group_by_clasification_h"
                                                           class="form-control bootstrap-switch bootstrap-switch-mini sel_clasification" value="instruction_degree"
                                                           id="sel_instruction_degree_h" data-on-label="SI"
                                                           data-off-label="NO">
                                                </div>
											</div>
										</div>
									</div>

									<div class="col-md-3">
										<div class=" form-group">
											<label>Cargo</label>
											<div class="col-12">
                                                <div class="col-12 bootstrap-switch-mini">
    												<input type="checkbox" name="group_by_clasification_h"
                                                           value="position" class="form-control bootstrap-switch bootstrap-switch-mini sel_clasification" id="sel_position_h"
                                                           data-on-label="SI" data-off-label="NO">
                                                </div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class=" form-group is-required">
											<label>Escalafón Salarial:</label>
											<select2 id="salary_scale_h_select" :options="payroll_salary_scales_h"
                                                     @input="loadSalaryScale('horizontal')"
                                                     v-model="record.payroll_horizontal_salary_scale_id">
											</select2>
										</div>
									</div>
								</div>
	                    	</div>
	                    	<div class="tab-pane" id="vertical" role="tabpanel">
	                    		<div class="row">
		                			<div class="col-md-12">
		                				<strong>Agrupar por</strong>
		                			</div>
									<div class="col-md-3">
										<div class=" form-group">
											<label>Experiencia Laboral</label>
											<div class="col-12">
                                                <div class="col-12 bootstrap-switch-mini">
    												<input type="checkbox" name="group_by_years_v" value="experience"
                                                           id="sel_experience_v" data-on-label="SI" data-off-label="NO"
                                                           class="form-control bootstrap-switch bootstrap-switch-mini sel_clasification">
                                                </div>
											</div>
										</div>
									</div>

									<div class="col-md-3">
										<div class=" form-group">
											<label>Antigüedad</label>
											<div class="col-12">
                                                <div class="col-12 bootstrap-switch-mini">
    												<input type="checkbox" name="group_by_years_v" value="antiquity"
                                                           id="sel_antiquity_v" data-on-label="SI" data-off-label="NO"
                                                           class="form-control bootstrap-switch bootstrap-switch-mini sel_clasification">
                                                </div>
											</div>
										</div>
									</div>

									<div class="col-md-3">
										<div class=" form-group">
											<label>Grado de Instrucción</label>
											<div class="col-12">
                                                <div class="col-12 bootstrap-switch-mini">
    												<input type="checkbox" name="group_by_clasification_v"
                                                           value="instruction_degree" id="sel_instruction_degree_v"
                                                           class="form-control bootstrap-switch bootstrap-switch-mini sel_clasification" data-on-label="SI" data-off-label="NO">
                                                </div>
											</div>
										</div>
									</div>

									<div class="col-md-3">
										<div class=" form-group">
											<label>Cargo</label>
											<div class="col-12">
                                                <div class="col-12 bootstrap-switch-mini">
    												<input type="checkbox" name="group_by_clasification_v"
                                                           value="position" id="sel_position_v"
                                                           class="form-control bootstrap-switch bootstrap-switch-mini sel_clasification" data-on-label="SI" data-off-label="NO">
                                                </div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class=" form-group is-required">
											<label>Escalafón Salarial:</label>
											<select2 id="salary_scale_v_select" :options="payroll_salary_scales_v"
                                                     @input="loadSalaryScale('vertical')"
                                                     v-model="record.payroll_vertical_salary_scale_id">
											</select2>
										</div>
									</div>
								</div>
	                    	</div>
	                    </div>
	                    <!-- Visible para ambos escalafones -->
	                    <div class="modal-table"
							 v-if="((record.payroll_horizontal_salary_scale_id > 0)
								&& (payroll_salary_scale_h.payroll_scales.length > 0))
								|| ((record.payroll_vertical_salary_scale_id > 0)
								&& (payroll_salary_scale_v.payroll_scales.length > 0))">
							<table class="table table-hover table-striped table-responsive  table-assignment"
								   v-if="record.payroll_horizontal_salary_scale_id > 0">
								<thead>
									<th :colspan="1 + payroll_salary_scale_h.payroll_scales.length">
										<strong>{{ record.name }}</strong>
									</th>
								</thead>
								<tbody>
									<tr class="text-center">
										<th>Nombre:</th>
										<th
											v-for="(field_h, index) in payroll_salary_scale_h.payroll_scales">
											{{field_h.name}}
										</th>
									</tr>
									<tr class="text-center"
										v-if="payroll_salary_scale_v.payroll_scales.length == 0">
										<th>Incidencia:</th>
										<td class="td-with-border"
											v-for="(field_h, index) in payroll_salary_scale_h.payroll_scales">
											<div>
												<input type="number" :id="'salary_scale_h_' + field_h.id"
                                                       class="form-control input-sm" data-toggle="tooltip" min="0"
                                                       step=".01" onfocus="this.select()">
											</div>
										</td>
									</tr>

									<tr class="text-center" v-else
										v-for="(field_v, index_v) in payroll_salary_scale_v.payroll_scales">
										<th
											v-if="((record.payroll_vertical_salary_scale_id > 0) &&
												(payroll_salary_scale_v.payroll_scales.length > 0))">
											{{field_v.name}}
										</th>
										<td class="td-with-border"
											v-for="(field_h, index_h) in payroll_salary_scale_h.payroll_scales">
											<div>
												<input type="number" class="form-control input-sm"
                                                       :id="'salary_scale_' + field_v.id + '_' + field_h.id"
													   data-toggle="tooltip" min="0" step=".01" onfocus="this.select()">
											</div>
										</td>
									</tr>
								</tbody>
							</table>
							<table  class="table table-hover table-striped table-responsive  table-assignment"
								    v-else-if="record.payroll_horizontal_salary_scale_id == ''
								   		&& record.payroll_vertical_salary_scale_id > 0
								   		&& payroll_salary_scale_v.payroll_scales.length > 0">
								<thead>
									<th colspan="2">
										<strong>{{ record.name }}</strong>
									</th>
								</thead>
								<tbody>
									<tr class="text-center">
										<th>Código</th>
										<th>Incidencia</th>
									</tr>
									<tr class="text-center"
										v-for="(field, index) in payroll_salary_scale_v.payroll_scales">
										<th>
											{{field.name}}
										</th>
										<td>
											<div>
												<input type="number" :id="'salary_scale_v_' + field.id"
                                                       class="form-control input-sm" data-toggle="tooltip" min="0"
													   step=".01" onfocus="this.select()">
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
			        </div>
			        <div class="modal-footer">
                        <div class="form-group">
                            <modal-form-buttons :saveRoute="'payroll/salary-tabulators'"></modal-form-buttons>
                        </div>
                    </div>
                    <div class="modal-body modal-table">
	                	<hr>
	                	<v-client-table :columns="columns" :data="records" :options="table_options">
	                		<div slot="id" slot-scope="props" class="text-center">
	                			<button @click="exportRecord(props.index, $event)"
                                        class="btn btn-primary btn-xs btn-icon btn-action"
                                        title="Descargar/Exportar tabulador" data-toggle="tooltip" type="button">
	                                <i class="fa fa-download"></i>
	                            </button>
	                			<button @click="editRecord(props.index, $event)"
		                				class="btn btn-warning btn-xs btn-icon btn-action"
		                				title="Modificar registro" data-toggle="tooltip" type="button">
		                			<i class="fa fa-edit"></i>
		                		</button>
		                		<button @click="deleteRecord(props.index, 'salary-tabulators')"
										class="btn btn-danger btn-xs btn-icon btn-action" title="Eliminar registro"
                                        data-toggle="tooltip" type="button">
									<i class="fa fa-trash-o"></i>
								</button>
	                		</div>
	                	</v-client-table>
	                </div>
		        </div>
		    </div>
		</div>
	</div>
</template>

<style>
	.table-ladder thead tr.selected-row {
		background-color: #d1d1d1;
	}
	.table-ladder tbody tr.config-row {
		background-color: #fff;
	}
</style>

<script>
	export default {
		data() {
			return {
				record: {
					id: '',
					code: '',
					name: '',
					active: '',
					description: '',
					payroll_staff_type_id: '',
					institution_id: '',
					currency_id: '',

					payroll_horizontal_salary_scale_id: '',
					payroll_vertical_salary_scale_id: '',

					payroll_salary_tabulator_scales: [],
				},
				payroll_salary_scale_h: {
					id: '',
					name: '',
					code: '',
					description: '',
					active: '',
					payroll_scales: [],
					group_by_years: '',
					group_by_clasification: '',
				},

				payroll_salary_scale_v: {
					id: '',
					name: '',
					code: '',
					description: '',
					active: '',
					payroll_scales: [],
					group_by_years: '',
					group_by_clasification: '',
				},
				errors:  [],
				records: [],
				columns: ['name', 'description', 'id'],
				editIndex: null,

				group_by_years_v: '',
				group_by_years_h: '',
				group_by_clasification_v: '',
				group_by_clasification_h: '',

				institutions: [],
				currencies: [],
				payroll_staff_types: [],
				payroll_salary_scales_h: [],
				payroll_salary_scales_v: [],

			}
		},
		created() {
			this.table_options.headings = {
				'name': 'Nombre',
				'description': 'Descripción',
				'id': 'Acción'
			};
			this.table_options.sortable = ['name', 'description'];
			this.table_options.filterable = ['name', 'description'];
			this.table_options.columnsClasses = {
				'name': 'col-xs-4',
				'description': 'col-xs-6',
				'id': 'col-xs-2',
			};
		},
		methods: {
			reset() {
				const vm = this;
				var fields = [
					'sel_experience', 'sel_antiquity', 'sel_position', 'sel_instruction_degree'
				];
				vm.record = {
					id: '',
					code: '',
					name: '',
					active: '',
					description: '',
					payroll_staff_type_id: '',
					institution_id: '',
					currency_id: '',

					payroll_horizontal_salary_scale_id: '',
					payroll_vertical_salary_scale_id: '',

					payroll_salary_tabulator_scales: [],
				};
				vm.payroll_salary_scale_h = {
					id: '',
					name: '',
					code: '',
					description: '',
					active: '',
					payroll_scales: [],
					group_by_years: '',
					group_by_clasification: '',
				};
				vm.payroll_salary_scale_v = {
					id: '',
					name: '',
					code: '',
					description: '',
					active: '',
					payroll_scales: [],
					group_by_years: '',
					group_by_clasification: '',
				};
				vm.group_by_years_v = '';
				vm.group_by_years_h = '';
				vm.group_by_clasification_v = '';
				vm.group_by_clasification_h = '';


				vm.payroll_salary_scales_h = [];
				vm.payroll_salary_scales_v = [];
				vm.editIndex = null;
				vm.errors    = [];

				$("#sel_active").bootstrapSwitch('disabled', false);
				if($("#sel_active").is(':checked') == true)
					$("#sel_active").bootstrapSwitch('toggleState',false);

				$.each(fields, function(index, el) {
					$('#' + el + '_v').bootstrapSwitch('disabled', false);
					$('#' + el + '_h').bootstrapSwitch('disabled', false);
					if($('#' + el + '_v').is(':checked') == true)
						$('#' + el + '_v').bootstrapSwitch('toggleState',false);

					if($('#' + el + '_h').is(':checked') == true)
					    $('#' + el + '_h').bootstrapSwitch('toggleState',false);
				});

			},
			createRecord(url) {
				const vm = this;
				var payroll_scales = [];

				if ((vm.record.payroll_horizontal_salary_scale_id > 0
					&& vm.payroll_salary_scale_h.payroll_scales.length > 0)
					|| (vm.record.payroll_vertical_salary_scale_id > 0
					&& vm.payroll_salary_scale_v.payroll_scales.length > 0)) {

					if (vm.record.payroll_vertical_salary_scale_id == '') {
						$.each(vm.payroll_salary_scale_h.payroll_scales, function (index, campo) {
							var element = document.getElementById("salary_scale_h_" + campo.id);
							if (element) {
								var field = {
									payroll_horizontal_scale_id:   campo.id,
									payroll_horizontal_scale_code: campo.code,
									value:  element.value,
									ladder: 'horizontal',
								};
								payroll_scales.push(field);
							}
						});
					} else if (vm.record.payroll_horizontal_salary_scale_id == '') {
						$.each(vm.payroll_salary_scale_v.payroll_scales, function (index, campo) {
							var element = document.getElementById("salary_scale_v_" + campo.id);
							if (element) {
								var field = {
									payroll_vertical_scale_id:   campo.id,
									payroll_vertical_scale_code: campo.code,
									value:  element.value,
									ladder: 'vertical',
								};
								payroll_scales.push(field);
							}
						});
					} else {
						$.each(vm.payroll_salary_scale_v.payroll_scales, function (index_v, campo_v) {
							$.each(vm.payroll_salary_scale_h.payroll_scales, function (index_h, campo_h) {
								var element = document.getElementById(
									"salary_scale_" + campo_v.id + '_' + campo_h.id
								);
								if (element) {
									var field = {
										payroll_vertical_scale_id:   campo_v.id,
										payroll_vertical_scale_code: campo_v.code,
										payroll_horizontal_scale_id:   campo_h.id,
										payroll_horizontal_scale_code: campo_h.code,
										value:  element.value,
										ladder: 'mix',
									};
									payroll_scales.push(field);
								}
							});
						});
					}
					vm.record.payroll_salary_tabulator_scales = payroll_scales;
				}

				if (this.record.id) {
                	this.updateRecord(url);
	            }
	            else {
	                var fields = {};
	                for (var index in this.record) {
	                    fields[index] = this.record[index];
	                }
	                axios.post('/' + url, fields).then(response => {
	                    if (typeof(response.data.redirect) !== "undefined") {
	                        location.href = response.data.redirect;
	                    }
	                    else {
	                        vm.errors = [];
	                        vm.reset();
	                        vm.readRecords(url);
	                        vm.showMessage('store');
	                    }
	                }).catch(error => {
	                    vm.errors = [];

	                    if (typeof(error.response) !="undefined") {
	                        for (var index in error.response.data.errors) {
	                            if (error.response.data.errors[index]) {
	                                vm.errors.push(error.response.data.errors[index][0]);
	                            }
	                        }
	                    }
	                });
	            }
			},
			exportRecord(index, event) {
				const vm = this;
				var fields = vm.records[index - 1];
				window.open('/payroll/salary-tabulators/export/'+ fields.id);
				event.preventDefault();
			},
			editRecord(index, event) {
				const vm = this;
				vm.reset();
				vm.editIndex = index;
				var fields = vm.records[vm.editIndex - 1];
				var group_by_years = null;
				var group_by_clasification = null;
				var element = '';
				if (fields.payroll_horizontal_salary_scale_id > 0) {
					group_by_years 		      = fields.payroll_horizontal_salary_scale.group_by_years;
					group_by_clasification    = fields.payroll_horizontal_salary_scale.group_by_clasification;
					vm.payroll_salary_scale_h = fields.payroll_horizontal_salary_scale;
					if (group_by_years) {
						element = "sel_" + group_by_years + "_h";
						document.getElementById(element).click();
						group_by_years = null;
					}
					if (group_by_clasification) {
						element = "sel_" + group_by_clasification + "_h";
						document.getElementById(element).click();
						group_by_clasification = null;
					}
				}
				if (fields.payroll_vertical_salary_scale_id > 0) {
					group_by_years 		   = fields.payroll_vertical_salary_scale.group_by_years;
					group_by_clasification = fields.payroll_vertical_salary_scale.group_by_clasification;
					vm.payroll_salary_scale_v = fields.payroll_vertical_salary_scale;
					if (group_by_years) {
						element = "sel_" + group_by_years + "_v";
						document.getElementById(element).click();
					}
					if (group_by_clasification) {
						element = "sel_" + group_by_clasification + "_v";
						document.getElementById(element).click();
					}
				}
				vm.initUpdate(index, event);
			},
			disabledSwitch(element, ladder) {
				var value = $('#' + element).bootstrapSwitch('disabled');
				if(ladder == 'horizontal') {
					if((element == 'sel_experience_v') || (element == 'sel_antiquity_v')) {
						$('#sel_experience_v').bootstrapSwitch(
							'disabled',
							(element == 'sel_experience_v')?((value == true)?false:true):false
						);
						$('#sel_antiquity_v').bootstrapSwitch(
							'disabled',
							(element == 'sel_antiquity_v')?((value == true)?false:true):false
						);
					} else if((element == 'sel_instruction_degree_v') || (element == 'sel_position_v')) {
						$('#sel_instruction_degree_v').bootstrapSwitch(
							'disabled',
							(element == 'sel_instruction_degree_v')?((value == true)?false:true):false
						);
						$('#sel_position_v').bootstrapSwitch(
							'disabled',
							(element == 'sel_position_v')?((value == true)?false:true):false
						);
					}
				} else if(ladder == 'vertical') {
					if((element == 'sel_experience_h') || (element == 'sel_antiquity_h')) {
						$('#sel_experience_h').bootstrapSwitch(
							'disabled',
							(element == 'sel_experience_h')?((value == true)?false:true):false
						);
						$('#sel_antiquity_h').bootstrapSwitch(
							'disabled',
							(element == 'sel_antiquity_h')?((value == true)?false:true):false
						);
					} else if((element == 'sel_instruction_degree_h') || (element == 'sel_position_h')) {
						$('#sel_instruction_degree_h').bootstrapSwitch(
							'disabled',
							(element == 'sel_instruction_degree_h')?((value == true)?false:true):false
						);
						$('#sel_position_h').bootstrapSwitch(
							'disabled',
							(element == 'sel_position_h')?((value == true)?false:true):false
						);
					}
				}
			},
			getParamenters(target, value) {
				const vm = this;

				if (target == 'sel_position_h') {
					if ($('#sel_position_h').prop('checked')) {
						$('#sel_position_h').bootstrapSwitch('state', true, true);
						vm.group_by_clasification_h = value;
					}
					if ($('#sel_instruction_degree_h').prop('checked'))
						$('#sel_instruction_degree_h').bootstrapSwitch('state', false, true);
				}
				else if (target == 'sel_instruction_degree_h') {
					if ($('#sel_instruction_degree_h').prop('checked')) {
						$('#sel_instruction_degree_h').bootstrapSwitch('state', true, true);
						vm.group_by_clasification_h = value;
					}
					if ($('#sel_position_h').prop('checked'))
						$('#sel_position_h').bootstrapSwitch('state', false, true);
				}
				else if (target == 'sel_experience_h') {
					if ($('#sel_experience_h').prop('checked')) {
						$('#sel_experience_h').bootstrapSwitch('state', true, true);
						vm.group_by_years_h = value;
					}
					if ($('#sel_antiquity_h').prop('checked'))
						$('#sel_antiquity_h').bootstrapSwitch('state', false, true);
				}
				else if (target == 'sel_antiquity_h') {
					if ($('#sel_antiquity_h').prop('checked')) {
						$('#sel_antiquity_h').bootstrapSwitch('state', true, true);
						vm.group_by_years_h = value;
					}
					if ($('#sel_experience_h').prop('checked'))
						$('#sel_experience_h').bootstrapSwitch('state', false, true);
				}
				else if (target == 'sel_position_v') {
					if ($('#sel_position_v').prop('checked')) {
						$('#sel_position_v').bootstrapSwitch('state', true, true);
						vm.group_by_clasification_v = value;
					}
					if ($('#sel_instruction_degree_v').prop('checked'))
						$('#sel_instruction_degree_v').bootstrapSwitch('state', false, true);
				}
				else if (target == 'sel_instruction_degree_v') {
					if ($('#sel_instruction_degree_v').prop('checked')) {
						$('#sel_instruction_degree_v').bootstrapSwitch('state', true, true);
						vm.group_by_clasification_v = value;
					}
					if ($('#sel_position_v').prop('checked'))
						$('#sel_position_v').bootstrapSwitch('state', false, true);
				}
				else if (target == 'sel_experience_v') {
					if ($('#sel_experience_v').prop('checked')) {
						$('#sel_experience_v').bootstrapSwitch('state', true, true);
						vm.group_by_years_v = value;
					}
					if ($('#sel_antiquity_v').prop('checked'))
						$('#sel_antiquity_v').bootstrapSwitch('state', false, true);
				}
				else if (target == 'sel_antiquity_v') {
					if ($('#sel_antiquity_v').prop('checked')) {
						$('#sel_antiquity_v').bootstrapSwitch('state', true, true);
						vm.group_by_years_v = value;
					}
					if ($('#sel_experience_v').prop('checked'))
						$('#sel_experience_v').bootstrapSwitch('state', false, true);
				}
			},
			getPayrollSalaryScales(ladder = 'all') {
				const vm = this;
				var field = {
					institution_id: 		'',
					group_by_years: 		'',
					group_by_clasification: ''
				};

				if (ladder != 'all') {
					field = {
						institution_id: vm.record.institution_id,
						group_by_years: (ladder == 'vertical')
							? vm.group_by_years_v
							: vm.group_by_years_h,
						group_by_clasification: (ladder == 'vertical')
							? vm.group_by_clasification_v
							: vm.group_by_clasification_h,
					};
				};
				axios.post('/payroll/get-salary-scales', field).then(response => {
                    if (typeof(response.data) !== "undefined") {
                        if (ladder == 'horizontal') {
							vm.payroll_salary_scales_h = response.data;
						} else if (ladder == 'vertical') {
							vm.payroll_salary_scales_v = response.data;
						} else {
							vm.payroll_salary_scales_h = response.data;
							vm.payroll_salary_scales_v = response.data;
						}
                    }
                }).catch(error => {
                    if (typeof(error.response) !== "undefined") {
	                    if (error.response.status == 403) {
	                        vm.showMessage(
	                            'custom', 'Acceso Denegado', 'danger', 'screen-error', error.response.data.message
	                        );
	                    }
	                    else {
	                        vm.logs('modules/Payroll/Resources/assets/js/_all.js', 343, error, 'getPayrollSalaryScales');
	                    }
	                }
                });
			},
			loadSalaryScale(ladder) {
				const vm = this;

				if (ladder == 'horizontal') {
					if(vm.record.payroll_horizontal_salary_scale_id > 0) {
						var id = vm.record.payroll_horizontal_salary_scale_id;
						axios.get('/payroll/salary-scales/info/'+ id).then(response => {
							vm.payroll_salary_scale_h = response.data.record;
						});
					}
				} else if (ladder == 'vertical') {
					if(vm.record.payroll_vertical_salary_scale_id > 0) {
						var id = vm.record.payroll_vertical_salary_scale_id;
						axios.get('/payroll/salary-scales/info/'+ id).then(response => {
							vm.payroll_salary_scale_v = response.data.record;
						});
					}
				}
			},
		},
		mounted() {
			const vm = this;
			$("#add_tabulator").on('show.bs.modal', function() {
				vm.reset();
				vm.getPayrollStaffTypes();
				vm.getInstitutions();
				vm.getCurrencies();
			});
			vm.switchHandler('active');

			$('.sel_clasification').on('switchChange.bootstrapSwitch', function(e) {
				if (e.target.id != '') {
					if (!$('#sel_experience_h').prop('checked') && !$('#sel_antiquity_h').prop('checked'))
						vm.group_by_years_h = '';
					if (!$('#sel_position_h').prop('checked') && !$('#sel_instruction_degree_h').prop('checked'))
						vm.group_by_clasification_h = '';
					if (!$('#sel_experience_v').prop('checked') && !$('#sel_antiquity_v').prop('checked'))
						vm.group_by_years_v = '';
					if (!$('#sel_position_v').prop('checked') && !$('#sel_instruction_degree_v').prop('checked'))
						vm.group_by_clasification_v = '';
					if ($('#' + e.target.id).prop('checked'))
						vm.getParamenters(e.target.id, e.target.value);

				}
				if (e.target.id === "sel_experience_h") {
					if(vm.record.payroll_horizontal_salary_scale_id != -1) {
						vm.getPayrollSalaryScales('horizontal');
					}
					vm.disabledSwitch('sel_experience_v', 'horizontal');
				}
				else if (e.target.id === "sel_instruction_degree_h") {
					if(vm.record.payroll_horizontal_salary_scale_id != -1) {
						vm.getPayrollSalaryScales('horizontal');
					}
					vm.disabledSwitch('sel_instruction_degree_v', 'horizontal');
				}
				else if (e.target.id === "sel_antiquity_h") {
					if(vm.record.payroll_horizontal_salary_scale_id != -1) {
						vm.getPayrollSalaryScales('horizontal');
					}
					vm.disabledSwitch('sel_antiquity_v', 'horizontal');
				}
				else if (e.target.id === "sel_position_h") {
					if(vm.record.payroll_horizontal_salary_scale_id != -1) {
						vm.getPayrollSalaryScales('horizontal');
					}
					vm.disabledSwitch('sel_position_v', 'horizontal');
				}
				else if (e.target.id === "sel_experience_v") {
					if(vm.record.payroll_vertical_salary_scale_id != -1) {
						vm.getPayrollSalaryScales('vertical');
					}
					vm.disabledSwitch('sel_experience_h', 'vertical');
				}
				else if (e.target.id === "sel_instruction_degree_v") {
					if(vm.record.payroll_vertical_salary_scale_id != -1) {
						vm.getPayrollSalaryScales('vertical');
					}
					vm.disabledSwitch('sel_instruction_degree_h', 'vertical');
				}
				else if (e.target.id === "sel_antiquity_v") {
					if(vm.record.payroll_vertical_salary_scale_id != -1) {
						vm.getPayrollSalaryScales('vertical');
					}
					vm.disabledSwitch('sel_antiquity_h', 'vertical');
				}
				else if (e.target.id === "sel_position_v") {
					if(vm.record.payroll_vertical_salary_scale_id != -1) {
						vm.getPayrollSalaryScales('vertical');
					}
					vm.disabledSwitch('sel_position_h', 'vertical');
				}
			});

		},
		watch: {
			record: {
				deep: true,
				handler: function() {
					if (this.editIndex) {
						if (this.record.payroll_horizontal_salary_scale) {
							this.record.payroll_horizontal_salary_scale_id
								= this.record.payroll_horizontal_salary_scale.id;
							$("#salary_scale_h_select").val(this.record.payroll_horizontal_salary_scale_id).select2();
						};
						if (this.record.payroll_vertical_salary_scale) {
							this.record.payroll_vertical_salary_scale_id
								= this.record.payroll_vertical_salary_scale.id;
							$("#salary_scale_v_select").val(this.record.payroll_vertical_salary_scale_id).select2();
						}
						if (this.record.payroll_salary_tabulator_scales) {
							$.each(this.record.payroll_salary_tabulator_scales, function(index, field) {
								var name = (field.payroll_vertical_scale_id)
									? (field.payroll_horizontal_scale_id)
										? "salary_scale_" + field.payroll_vertical_scale_id + '_' + field.payroll_horizontal_scale_id
										: "salary_scale_v_" + field.payroll_vertical_scale_id
									:"salary_scale_h_" + field.payroll_horizontal_scale_id;
								var element = document.getElementById(name);
									if (element) {
										element.value = field.value;
									};
							});
						}
					}
				}
			}
		},
	};
</script>
