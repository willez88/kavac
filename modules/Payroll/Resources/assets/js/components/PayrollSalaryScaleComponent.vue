<template>
	<div class="text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary"
		   href="#" title="Registros de los escalafones salariales" data-toggle="tooltip"
		   @click="addRecord('add_salary_scale', 'salary-scale', $event)">
		   <i class="icofont icofont-growth ico-3x"></i>
			<span>Escalafones Salariales</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_salary_scale">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-growth ico-2x"></i>
							 Nuevo Escalafón Salarial
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
										<div class="form-group is-required">
											<label>Código:</label>
											<input type="text" placeholder="Código del escalafón salarial" data-toggle="tooltip"
												   title="Indique el código del nuevo escalafón salarial (requerido)"
												   class="form-control input-sm" v-model="record.code">
											<input type="hidden" v-model="record.id">
					                    </div>
									</div>
									<div class="col-md-8">
										<div class="form-group is-required">
											<label>Nombre:</label>
											<input type="text" placeholder="Nombre del escalafón salarial" data-toggle="tooltip"
												   title="Indique el nombre del nuevo escalafón salarial (requerido)"
												   class="form-control input-sm" v-model="record.name">
					                    </div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<div class=" form-group">
											<label>¿Activa?</label>
											<div class="col-12">
                                                <div class="col-12 bootstrap-switch-mini">
    												<input type="checkbox" class="form-control bootstrap-switch"
    												   data-toggle="tooltip" name="active"
    												   title="Indique si el escalafón esta activo"
    												   data-on-label="SI" data-off-label="NO"
    												   v-model="record.active" value="true">
                                                </div>
											</div>
										</div>
									</div>
									<div class="col-md-8">
										<div class="form-group is-required">
											<label>Institución:</label>
											<select2 :options="institutions"
														v-model="record.institution_id"></select2>
					                    </div>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>Descripción:</label>
                                            <ckeditor :editor="ckeditor.editor" id="description_scale"
                                                      title="Indique alguna descripción asociada al escalafón"
                                                      :config="ckeditor.editorConfig" class="form-control"
                                                      name="description" tag-name="textarea" rows="3"
                                                      data-toggle="tooltip" v-model="record.description"></ckeditor>
					                    </div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
                			<div class="col-md-12">
                				<strong>Agrupar por</strong>
                			</div>
							<div class="col-md-3">
								<div class=" form-group">
									<label>Experiencia Laboral</label>
									<div class="col-12">
                                        <div class="col-12 bootstrap-switch-mini">
    										<input type="checkbox" name="group_by_years" value="experience"
    										class="form-control bootstrap-switch bootstrap-switch-mini sel_clasification"
    										id="sel_experience" data-on-label="SI" data-off-label="NO">
                                        </div>
									</div>
								</div>
							</div>

							<div class="col-md-3">
								<div class=" form-group">
									<label>Antigüedad</label>
									<div class="col-12">
                                        <div class="col-12 bootstrap-switch-mini">
    										<input type="checkbox" name="group_by_years" value="antiquity"
    										class="form-control bootstrap-switch bootstrap-switch-mini sel_clasification"
    										id="sel_antiquity" data-on-label="SI" data-off-label="NO">
                                        </div>
									</div>
								</div>
							</div>

							<div class="col-md-3">
								<div class=" form-group">
									<label>Grado de Instrucción</label>
									<div class="col-12">
                                        <div class="col-12 bootstrap-switch-mini">
    										<input type="checkbox" name="group_by_clasification"
    										class="form-control bootstrap-switch bootstrap-switch-mini sel_clasification"
    										value="instruction_degree" id="sel_instruction_degree"
    										data-on-label="SI" data-off-label="NO">
                                        </div>
									</div>
								</div>
							</div>

							<div class="col-md-3">
								<div class=" form-group">
									<label>Cargo</label>
									<div class="col-12">
                                        <div class="col-12 bootstrap-switch-mini">
    										<input type="checkbox" name="group_by_clasification" value="position"
    										class="form-control bootstrap-switch bootstrap-switch-mini sel_clasification"
    										id="sel_position" data-on-label="SI" data-off-label="NO">
                                        </div>
									</div>
								</div>
							</div>
						</div>
						<div v-show="this.record.payroll_scales.length > 0">
							<hr>
							<h6 class="card-title">
								Escalas o Niveles del Escalafón
							</h6>
							<table class="table table-hover table-striped table-responsive  table-scale">
								<thead>
									<th :colspan="1 + record.payroll_scales.length">
										<strong>{{ record.name }}</strong>
									</th>
								</thead>
								<tbody>
									<tr class="selected-row text-center">
										<th>Código:</th>
										<th v-for="(field,index) in record.payroll_scales">
											{{field.code}}
										</th>
									</tr>
									<tr class="selected-row text-center">
										<th>Nombre:</th>
										<td v-for="(field,index) in record.payroll_scales">
											{{ field.name}}
										</td>
									</tr>
									<tr class="config-row text-center">
										<th>Acción:</th>
										<td v-for="(field,index) in record.payroll_scales">
											<div class="d-inline-flex">
												<button @click="editScale(index,$event)"
						                				class="btn btn-warning btn-xs btn-icon btn-action"
						                				title="Modificar registro" data-toggle="tooltip" type="button">
						                			<i class="fa fa-edit"></i>
						                		</button>
						                		<button @click="removeScale(index,$event)"
														class="btn btn-danger btn-xs btn-icon btn-action"
														title="Eliminar registro" data-toggle="tooltip"
														type="button">
													<i class="fa fa-trash-o"></i>
												</button>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div v-show="record.group_by_years != '' || record.group_by_clasification != ''">
							<hr>
							<div class="row">
								<div class="col-md-6">
									<h6 class="card-title">
										Nueva Escala o Nivel
									</h6>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group is-required">
												<label>Código:</label>
												<input type="text" placeholder="Código de la Escala"
														data-toggle="tooltip"
														title="Indique el código de la escala (requerido)"
														class="form-control input-sm"
														v-model="scale.code">
												<input type="hidden" v-model="scale.id">
						                    </div>
										</div>
										<div class="col-md-6">
											<div class=" form-group is-required">
												<label>Nombre:</label>
												<input type="text" placeholder="Nombre de la Escala"
														data-toggle="tooltip"
														title="Indique el nombre de la escala (requerido)"
														class="form-control input-sm"
														v-model="scale.name">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>Descripción:</label>
                                                <ckeditor :editor="ckeditor.editor" id="description_new_scale"
                                                          data-toggle="tooltip"
                                                          title="Indique alguna descripción asociada a la escala"
                                                          :config="ckeditor.editorConfig" class="form-control"
                                                          name="description_new_scale" tag-name="textarea" rows="2"
                                                          v-model="scale.description"></ckeditor>
						                    </div>
										</div>
									</div>
								</div>
								<div class="col-md-6"
									v-if="record.group_by_clasification &&
										record.group_by_clasification != '' &&
										record.group_by_years &&
			 							record.group_by_years != ''">
									<h6 class="card-title cursor-pointer" @click="addRequirement($event)">
										Requerimientos <i class="fa fa-plus-circle"></i>
									</h6>
									<div <div v-for="(requirement, index) in scale.payroll_scale_requirements">
										<div class="row">
											<div class="col-5">
												<div class=" form-group is-required">
													<label v-if="record.group_by_clasification == 'position'">Cargos</label>
													<label v-else>
													Grados de Instrucción</label>
													<select2 :options="(record.group_by_clasification == 'position')?payroll_positions:payroll_instruction_degrees"
														v-model="requirement.clasificable_id"></select2>
												</div>
											</div>
											<div class="col-5">
												<div class="form-group is-required">
													<label v-if="record.group_by_years == 'experience'">Años de Experiencia</label>
													<label v-else>
													Años de Antiguedad</label>
													<div class="d-inline-flex">
														<input type="number" placeholder="Desde"
															data-toggle="tooltip" min=0 max=30
															title="Indique la cantidad minima de años (requerido)"
															class="form-control input-sm" style="margin-right:15px;"
															v-model="requirement.scale_years_minimum">
														<input type="number" placeholder="Hasta"
															data-toggle="tooltip" min=0 max=30
															title="Indique la cantidad máxima de años (requerido)"
															class="form-control input-sm"
															v-model="requirement.scale_years_maximum">
													</div>
												</div>
											</div>
											<div class="col-1" style="margin-top: 26px;">
												<div class="form-group">
													<button class="btn btn-sm btn-danger btn-action" type="button"
															@click="removeRow(index, scale.payroll_scale_requirements)"
															title="Eliminar registro" data-toggle="tooltip"
															data-placement="right">
														<i class="fa fa-minus-circle"></i>
													</button>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6" v-else>
									<h6 class="card-title">
										Requerimiento
									</h6>
									<div class="row">
										<div class="col-md-6" v-if="record.group_by_clasification &&
																	record.group_by_clasification != ''">
											<div class=" form-group is-required">
												<label v-if="record.group_by_clasification == 'position'">Cargos</label>
												<label v-else>Grados de Instrucción</label>
												<select2 :options="(record.group_by_clasification == 'position')?payroll_positions:payroll_instruction_degrees" v-model="scale_requirement.clasificable_id"></select2>
											</div>
										</div>
										<div class="col-md-12" v-if="record.group_by_years &&
																	 record.group_by_years != ''">
											<label v-if="record.group_by_years == 'experience'">Años de Experiencia</label>
											<label v-else>Años de Antiguedad</label>
											<div class="col-md-12 d-inline-flex" style="padding-left:0px;">
												<div class="form-group is-required" style="margin-right:15px;">
													<input type="number" placeholder="Desde"
														data-toggle="tooltip" min=0 max=30
														title="Indique la cantidad minima de años (requerido)"
														class="form-control input-sm"
														v-model="scale_requirement.scale_years_minimum">
												</div>
												<div class="form-group is-required">
													<input type="number" placeholder="Hasta"
														data-toggle="tooltip" min=0 max=30
														title="Indique la cantidad máxima de años (requerido)"
														class="form-control input-sm"
														v-model="scale_requirement.scale_years_maximum">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<button type="button" @click="addScale($event)"
											class="btn btn-sm btn-primary btn-custom float-right"
											title="Agregar escala"
											data-toggle="tooltip">
										<i class="fa fa-plus-circle"></i>
										Agregar
									</button>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
                        <div class="form-group">
                            <modal-form-buttons :saveRoute="'payroll/salary-scale'"></modal-form-buttons>
                        </div>
                    </div>
					<div class="modal-body modal-table">
	                	<hr>
	                	<v-client-table :columns="columns" :data="records" :options="table_options">
	                		<div slot="description" slot-scope="props" class="text-center">
	                			<span>{{(props.row.description)?props.row.description:'N/A'}}</span>
	                		</div>
	                		<div slot="active" slot-scope="props" class="text-center">
	                			<span>{{ (props.row.active)?'Activo':'Inactivo' }}</span>
	                		</div>
	                		<div slot="id" slot-scope="props" class="text-center">
	                			<button @click="initUpdate(props.index, $event)"
		                				class="btn btn-warning btn-xs btn-icon btn-action"
		                				title="Modificar registro" data-toggle="tooltip" type="button">
		                			<i class="fa fa-edit"></i>
		                		</button>
		                		<button @click="deleteRecord(props.index, 'salary-scale')"
										class="btn btn-danger btn-xs btn-icon btn-action"
										title="Eliminar registro" data-toggle="tooltip"
										type="button">
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

<script>
	export default {
		data() {
			return {
				record: {
					id: '',
					name: '',
					code: '',
					description: '',
					active: '',
					payroll_scales: [],
					group_by_years: '',
					group_by_clasification: '',
					institution_id: '',
				},

				scale: {
					id: '',
					code: '',
					name: '',
					description: '',
					payroll_scale_requirements: [],
				},
				scale_requirement: {
					scale_years_minimum: '',
					scale_years_maximum: '',
					payroll_scale_id: '',
					clasificable_type: '',
					clasificable_id: '',
				},

				errors: [],
				records: [],
				columns: ['name', 'description', 'active', 'id'],
				editIndex: null,
				payroll_instruction_degrees: [],
				payroll_positions: [],
				institutions: [],
			}
		},
		methods: {
			/**
			 * Método que borra todos los datos del formulario
			 *
			 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
			 */
			reset() {
				this.record = {
					id: '',
					code: '',
					name: '',
					description: '',
					active: '',
					payroll_scales: [],
					group_by_years: '',
					group_by_clasification: '',
					institution_id: '',
				};
				this.payroll_positions = [];
				this.payroll_instruction_degrees = [];
				this.resetSwitch();
				this.resetScale();
			},
			resetSwitch() {
				const vm = this;
	            $.each(vm.record, function(el, value) {
	                if ($("input[name=" + el + "]").hasClass('bootstrap-switch')) {
	                    /** Si existen campos con la clase bootstrapSwitch los deshabilita */
	                    $("input[name=" + el + "].bootstrap-switch").bootstrapSwitch('state', value, true);
	                }
	            });
			},
			resetScale(reset_all = true) {
				this.scale = {
					id: '',
					name: '',
					code: '',
					description: '',
					payroll_scale_requirements: [],
				};
				this.scale_requirement = {
					scale_years_minimum: '',
					scale_years_maximum: '',
					payroll_scale_id: '',
					clasificable_type: '',
					clasificable_id: '',
				};
				this.editIndex = null;
				this.record.payroll_scales = (reset_all)?[]:this.record.payroll_scales;
			},
			addScale(event) {
				const vm = this;
				var field = {};
				if (vm.record.group_by_clasification == '' || vm.record.group_by_years == '') {
					vm.scale.payroll_scale_requirements = [vm.scale_requirement];
				}
				for (var index in vm.scale) {
					field[index] = vm.scale[index];
				}
				if(vm.editIndex == null)
					vm.record.payroll_scales.push(field);
				else {
					vm.record.payroll_scales[vm.editIndex] = field;
				}
				vm.resetScale(false);
				event.preventDefault();
			},
			addRequirement(event) {
				const vm = this;
				var field = {
					scale_years_minimum: '',
					scale_years_maximum: '',
					payroll_scale_id: '',
					clasificable_type: '',
					clasificable_id: '',
				};

				vm.scale.payroll_scale_requirements.push(field);
				event.preventDefault();
			},
			editScale(index,event){
				const vm = this;
				vm.editIndex = index;
				vm.scale = vm.record.payroll_scales[index];
				if (vm.record.group_by_clasification == null || vm.record.group_by_clasification == '' ||
					vm.record.group_by_years == null         || vm.record.group_by_years == '') {
					vm.scale_requirement = vm.scale.payroll_scale_requirements[0];
				}
				event.preventDefault();
			},
			removeScale(index,event) {
				const vm = this;
				vm.record.payroll_scales.splice(index, 1);
				vm.editIndex = null;
				event.preventDefault();
			},
			getParamenters(target, value) {
				const vm = this;

				if (target == 'sel_position') {
					if ($('#sel_position').prop('checked')) {
						$('#sel_position').bootstrapSwitch('state', true, true);
						vm.record.group_by_clasification = value;
					}
					vm.getPayrollPositions();
					if ($('#sel_instruction_degree').prop('checked'))
						$('#sel_instruction_degree').bootstrapSwitch('state', false, true);
				}
				else if (target == 'sel_instruction_degree') {
					if ($('#sel_instruction_degree').prop('checked')) {
						$('#sel_instruction_degree').bootstrapSwitch('state', true, true);
						vm.record.group_by_clasification = value;
					}
					vm.getPayrollInstructionDegrees();
					if ($('#sel_position').prop('checked'))
						$('#sel_position').bootstrapSwitch('state', false, true);
				}
				else if (target == 'sel_experience') {
					if ($('#sel_experience').prop('checked')) {
						$('#sel_experience').bootstrapSwitch('state', true, true);
						vm.record.group_by_years = value;
					}
					if ($('#sel_antiquity').prop('checked'))
						$('#sel_antiquity').bootstrapSwitch('state', false, true);
				}
				else if (target == 'sel_antiquity') {
					if ($('#sel_antiquity').prop('checked')) {
						$('#sel_antiquity').bootstrapSwitch('state', true, true);
						vm.record.group_by_years = value;
					}
					if ($('#sel_experience').prop('checked'))
						$('#sel_experience').bootstrapSwitch('state', false, true);
				}
			},
			/**
			 * Reescribe el método initUpdate para cambiar su comportamiento por defecto
	         * Método que carga el formulario con los datos a modificar
	         *
	         * @author Henry Paredes <hparedes@cenditel.gob.ve>
	         *
	         * @param  {integer} index Identificador del registro a ser modificado
	         * @param {object} event   Objeto que gestiona los eventos
	         */
	        initUpdate(index, event) {
	            let vm = this;
	            vm.reset();
	            vm.record = vm.records[index - 1];

	            $.each(vm.record, function(el, value) {
	                if ($("input[name=" + el + "]").hasClass('bootstrap-switch')) {
	                    /** verifica los elementos bootstrap-switch para seleccionar el que corresponda según los registros del sistema */
	                    $("input[name=" + el + "]").each(function() {
	                        if ($(this).val() === value) {
	                            $(this).bootstrapSwitch('state', value, true)
	                        }

	                    });
	                }
	                if (value === true || value === false) {
	                    $("input[name=" + el + "].bootstrap-switch").bootstrapSwitch('state', value, true);
	                }
	            });
	            if (vm.record.group_by_clasification == 'position')
					vm.getPayrollPositions();
				else if (vm.record.group_by_clasification == 'instruction_degree')
					vm.getPayrollInstructionDegrees();

	            event.preventDefault();
	        },
		},
		created() {
			this.table_options.headings = {
				'name': 'Nombre',
				'description': 'Descripción',
				'active': 'Estatus',
				'id': 'Acción'
			};
			this.table_options.sortable = ['name', 'description'];
			this.table_options.filterable = ['name', 'description'];
			this.table_options.columnsClasses = {
				'name': 'col-xs-4',
				'description': 'col-xs-4',
				'active': 'col-xs-2',
				'id': 'col-xs-2',
			};
		},
		mounted() {
			const vm = this;
			$("#add_salary_scale").on('show.bs.modal', function() {
				vm.reset();
				vm.getInstitutions();
			});
			vm.switchHandler('active');
			$('.sel_clasification').on('switchChange.bootstrapSwitch', function(e) {
				if (e.target.id != '') {
					vm.resetScale();
					if (!$('#sel_experience').prop('checked') && !$('#sel_antiquity').prop('checked'))
						vm.record.group_by_years = '';
					if (!$('#sel_position').prop('checked') && !$('#sel_instruction_degree').prop('checked'))
						vm.record.group_by_clasification = '';
					if ($('#' + e.target.id).prop('checked'))
						vm.getParamenters(e.target.id, e.target.value);
				}
			});

		},
	};
</script>
