<template>
	<div class="text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary"
		   href="#" title="Registro de Asignaciones de Nómina" data-toggle="tooltip"
		   @click="addRecord('add_assignment', 'salary-assignments', $event)">
			<i class="icofont icofont-bill-alt ico-3x"></i>
			<span>Asignaciones</span>
		</a>
		<div class="modal fade text-left" role="dialog" id="add_assignment">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-bill-alt ico-2x"></i>
							Nueva Asignación
						</h6>
					</div>

					<div class="modal-body">

						<ul class="nav nav-tabs custom-tabs justify-content-center" role="tablist">
	                        <li class="nav-item">
	                            <a class="nav-link" data-toggle="tab" href="#define" id="definition_assignment" role="tab">
	                                <i class="ion-compose"></i> Definir Asignación
	                            </a>
	                        </li>
	                        <li class="nav-item">
	                            <a class="nav-link" data-toggle="tab" href="#view" id="viewer_assignment" role="tab">
	                                <i class="ion-eye"></i> Visualizar Asignación
	                            </a>
	                        </li>
	                    </ul>
	                    <div class="tab-content">
	                    	<div class="tab-pane active" id="define" role="tabpanel">
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
									<div class="col-md-2">
										<div class="form-group is-required">
											<label>Código:</label>
											<input type="text" placeholder="Código" data-toggle="tooltip"
												   title="Indique el código de la nueva asignación salarial (requerido)"
												   class="form-control input-sm" v-model="record.code">
											<input type="hidden" v-model="record.id">
					                    </div>
									</div>
									<div class="col-md-4">
										<div class=" form-group is-required">
											<label>Nombre:</label>
											<input type="text" placeholder="Nombre de la asignación"
															data-toggle="tooltip"
															title="Indique un nombre asociado a la asignación"
															class="form-control input-sm"
															v-model="record.name">
										</div>
									</div>
									<div class="col-md-2">
										<div class=" form-group">
											<label>¿Activa?</label>
											<div class="col-12" data-toggle="tooltip"
												 title="¿La asignación se encuentra activa actualmente?">
                                                <div class="col-12 bootstrap-switch-mini">
    												<input type="checkbox" class="form-control bootstrap-switch"
                                                           data-toggle="tooltip" name="active"
                                                           title="Indique si la asignación esta activa"
                                                           data-on-label="SI" data-off-label="NO"
                                                           v-model="record.active" value="true">
                                                </div>
											</div>
										</div>
									</div>
									<div class="col-md-2">
										<div class=" form-group">
											<label>¿Incide sobre SB.?</label>
											<div class="col-12" data-toggle="tooltip"
												 title="¿Incide sobre el sueldo base?">
                                                <div class="col-12 bootstrap-switch-mini">
    												<input type="checkbox" class="form-control bootstrap-switch"
                                                           name="incidence" data-on-label="SI" data-off-label="NO"
                                                           v-model="record.incidence" value="true">
                                                </div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<label>Descripción:</label>
													<textarea  data-toggle="tooltip" rows="1"
															   title="Indique alguna descripción asociada a la asignación"
															   class="form-control"
                                                               v-model="record.description"></textarea>
							                    </div>
											</div>
					                    </div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<div class="col-md-12">
												<strong>Tipo de Incidencia</strong>
											</div>
											<div class="col-md-4">
												<div class=" form-group">
													<label>Valor Absoluto</label>
													<div class="col-12">
                                                        <div class="col-12 bootstrap-switch-mini">
    														<input type="radio" name="incidence_type" value="Valor Neto"
                                                                   id="sel_neto_value"
                                                                   class="form-control bootstrap-switch bootstrap-switch-mini sel_incidence_value"
    																data-on-label="SI" data-off-label="NO">
                                                        </div>
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class=" form-group">
													<label>Unidad Tributaria</label>
													<div class="col-12">
                                                        <div class="col-12 bootstrap-switch-mini">
    														<input type="radio" name="incidence_type"
                                                                   value="Unidad Tributaria" id="sel_tax_unit"
                                                                   class="form-control bootstrap-switch bootstrap-switch-mini sel_incidence_value"
                                                                   data-on-label="SI" data-off-label="NO">
                                                        </div>
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class=" form-group">
													<label>Porcentaje</label>
													<div class="col-12">
                                                        <div class="col-12 bootstrap-switch-mini">
    														<input type="radio" name="incidence_type" value="Porcentaje"
                                                                   id="sel_percent"
                                                                   class="form-control bootstrap-switch bootstrap-switch-mini sel_incidence_value"
                                                                   data-on-label="SI" data-off-label="NO">
                                                        </div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<div class=" form-group is-required">
											<label>Institución:</label>
											<select2 :options="institutions" v-model="record.institution_id"></select2>
										</div>
									</div>
									<div class="col-md-4">
										<div class=" form-group is-required">
											<label>Tipo de Asignación</label>
											<select2 :options="payroll_salary_assignment_types"
                                                     v-model="record.payroll_salary_assignment_type_id"></select2>
										</div>
									</div>
									<div class="col-md-4">
										<div class=" form-group is-required">
											<label>¿Asignar a?</label>
											<select2 :options="payroll_assign_to" @input="getAssignableType()"
                                                     v-model="record.payroll_assign_to_id">
											</select2>
										</div>
									</div>
									<div class="col-md-4">
										<div class=" form-group is-required">
											<label>Periodicidad</label>
											<select2 :options="payroll_periodicities"
                                                     v-model="record.payroll_periodicity_id"></select2>
										</div>
									</div>
									<div class="col-md-4"
										v-if="viewAssignableTypes()">
										<div class=" form-group is-required">
											<label id="assignable_type_label"></label>
											<label v-if="record.payroll_assign_to_id == 1">
												Tipo de Personal:
											</label>
											<label v-if="record.payroll_assign_to_id == 2">
												Tipo de Cargo:
											</label>
											<label v-if="record.payroll_assign_to_id == 4">
												Trabajador:
											</label>
											<label v-if="record.payroll_assign_to_id == 5">
												Tabulador:
											</label>
											<select2 :options="assignable_types"
                                                     v-model="record.assignable_id"></select2>
										</div>
									</div>
								</div>
								<div class="modal-table"
									v-show="((this.record.payroll_salary_scale_id > 0) &&
										(this.payroll_salary_scale.payroll_scales.length > 0))">
									<table class="table table-hover table-striped table-responsive  table-assignment">
										<thead>
											<th :colspan="1 + payroll_salary_scale.payroll_scales.length">
												<strong>{{ payroll_salary_scale.name }}</strong>
											</th>
										</thead>
										<tbody>
											<tr class="text-center">
												<th>Código:</th>
												<td v-for="(field,index) in payroll_salary_scale.payroll_scales">
													{{field.code}}
												</td>
											</tr>
											<tr class="text-center">
												<th>Nombre:</th>
												<td v-for="(field,index) in payroll_salary_scale.payroll_scales">
													{{ field.name}}
												</td>
											</tr>
											<tr class="text-center">
												<th>Incidencia :</th>
												<td class="td-with-border"
													v-for="(field,index) in payroll_salary_scale.payroll_scales">
													<div>
														<input type="number" class="form-control input-sm" data-toggle="tooltip" min="0" step=".01" :id="'payroll_scale_incidence_value_'+field.id" onfocus="this.select()">
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
	                    	<div class="tab-pane" id="view" role="tabpanel">
	                    		<div v-if="payroll_salary_scale.payroll_scales.length > 0">
		                    		<div class="row">
		                    			<div class="col-4 offset-md-8">
											<div class="float-right">
												<button type="button" class="btn btn-sm btn-warning btn-import"
                                                        @click="exportRecord('payroll/salary-assignments/export')"
                                                        title="Presione para exportar la información."
														data-toggle="tooltip" v-if="this.record.id">
													<i class="fa fa-download"></i>
													Exportar
												</button>
											</div>
										</div>
		                    		</div>
		                    		<div class="row">
										<table class="table table-hover table-striped table-responsive  table-assignment">
											<thead>
												<tr>
													<th :colspan="1 + payroll_salary_scale.payroll_scales.length">
														{{ record.name }}
													</th>
												</tr>
											</thead>
											<tbody>
												<tr class="text-center">
													<th>{{ payroll_salary_scale.name}}</th>
													<td v-for="(field,index) in payroll_salary_scale.payroll_scales">
														{{field.name}}
													</td>
												</tr>
												<tr class="text-center">
													<th>
														{{ record.incidence_type }}</th>
													<td v-for="(field,index) in payroll_salary_scale.payroll_scales">

													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
								<div v-else>
									<div class="alert alert-danger">
										<ul>
											<li>No se a definido ninguna tabla !</li>
										</ul>
									</div>
								</div>
	                    	</div>
	                    </div>
	                    <div class="modal-footer">
	                        <div class="form-group">
	                            <modal-form-buttons :saveRoute="'payroll/salary-assignments'"></modal-form-buttons>
	                        </div>
	                    </div>
						<div class="modal-body modal-table">
		                	<hr>
		                	<v-client-table :columns="columns" :data="records" :options="table_options">
		                		<div slot="id" slot-scope="props" class="text-center">
		                			<button @click="initUpdate(props.index, $event)"
			                				class="btn btn-warning btn-xs btn-icon 	btn-action"
			                				title="Modificar registro" data-toggle="tooltip" type="button">
			                			<i class="fa fa-edit"></i>
			                		</button>
			                		<button @click="deleteRecord(props.index, 'salary-assignments')"
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
	</div>
</template>

<style>
	.table-assignment .form-control {
		border-radius:.25rem !important;
		padding: .375rem .1rem;
	    font-size: .6rem;
	    text-align: center;
	}
	.table-assignment tbody tr.selected-row {
		background-color: #d1d1d1;
	}
	.table-assignment tbody tr.config-row {
		background-color: #fff;
	}
	.table-assignment {
		margin: 0 auto !important;
	}
</style>

<script>
	export default {
		data() {
			return {
				record: {
					id: '',
					name: '',
					description:'',
					active: '',
					incidence: '',
					incidence_type: '',

					assignable_id: '',
					assignable_type: '',

					payroll_assign_to_id: '',
					payroll_salary_scale_id: '',

					periodicity_id: '',
					institution_id: '',

				},
				payroll_salary_scale: {
					id:'',
					name: '',
					description: '',
					active: '',
					payroll_scales: [],
				},

				scale: {
					id: '',
					name: '',
					code: '',
					description: '',
					value: '',
				},

				editIndex: null,
				errors: [],
				records: [],
				columns: ['name', 'payroll_salary_assignment_type_id', 'payroll_periodicity_id', 'incidence_type', 'id'],

				institutions: [],
				payroll_salary_scales: [],
				payroll_salary_assignment_types: [],
				assignable_types: [],

				payroll_periodicities: [
					{"id":"","text":"Seleccione..."},
					{"id":1,"text":"Mensual"},
					{"id":2,"text":"Bimensual"},
					{"id":3,"text":"Trimestral"},
					{"id":4,"text":"Cuatrimestral"},
					{"id":5,"text":"Semestral"},
					{"id":6,"text":"Anual"}
				],
				payroll_assign_to: [
					{"id": '', "text": "Seleccione..."},
					{"id": 1,  "text": "Tipo de Personal"},
					{"id": 2,  "text": "Tipo de Cargo"},
					{"id": 3,  "text": "Todos"},
					{"id": 4,  "text": "Trabajador"},
					{"id": 5,  "text": "Tabulador"},
				],
			}
		},
		created() {
			this.table_options.headings = {
				'name': 'Nombre',
				'payroll_salary_assignment_type_id': 'Tipo de Asignación',
				'payroll_periodicity_id': 'Periodicidad',
				'incidence_type': 'Tipo de Incidencia',
				'id': 'Acción'
			};
			this.table_options.sortable = ['name', 'payroll_salary_assignment_type_id', 'payroll_periodicity_id', 'incidence_type'];
			this.table_options.filterable = ['name', 'payroll_salary_assignment_type_id', 'payroll_periodicity_id', 'incidence_type'];
			this.table_options.columnsClasses = {
				'name': 'col-xs-2',
				'payroll_salary_assignment_type_id': 'col-xs-4',
				'payroll_periodicity_id': 'col-xs-2',
				'incidence_type': 'col-xs-2',
				'id': 'col-xs-2',
			}
		},
		mounted() {
			const vm = this;
			this.switchHandler('active');
			this.switchHandler('incidence');
			this.switchHandler('incidence_type');


			$("#add_assignment").on('show.bs.modal', function() {
				vm.getPayrollSalaryAssignmentTypes();
				vm.getInstitutions();
			});
		},
		methods: {
			reset() {
				this.record = {
					id: '',
					name: '',
					description:'',
					active: '',
					incidence: '',
					incidence_type: '',

					assignable_id: '',
					assignable_type: '',

					payroll_assign_to_id: '',
					payroll_salary_scale_id: '',

					periodicity_id: '',
					institution_id: ''
				};
				this.payroll_salary_scale = {
					id:'',
					name: '',
					description: '',
					active: '',
					payroll_scales: [],
				};
				this.resetScale();
				this.errors = [];
			},
			resetScale() {
				this.scale = {
					id: '',
					name: '',
					code: '',
					description: '',
					value: '',
				};
			},
			addScale(event) {
				const vm = this;
				var field = {};
				field = {
					id: vm.scale.id,
					name: vm.scale.name,
					value: vm.scale.value,
				};
				vm.scale = {
					id: '',
					name: '',
					value: '',
				};
				if(vm.editIndex == null)
					vm.payroll_salary_scale.payroll_scales.push(field);
				else if(vm.editIndex >= 0 ){
					vm.payroll_salary_scale.payroll_scales.splice(vm.editIndex, 1);
					vm.payroll_salary_scale.payroll_scales.push(field);
					vm.editIndex = null;
				}
				event.preventDefault();
			},
			editScale(index,event){
				const vm = this;
				vm.editIndex = index;
				vm.scale = vm.payroll_salary_scale.payroll_scales[index];
				event.preventDefault();
			},
			removeScale(index,event) {
				const vm = this;
				vm.payroll_salary_scale.payroll_scales.splice(index, 1);
				vm.editIndex = null;
				event.preventDefault();
			},
			createRecord(url) {
				const vm = this;
				console.log(vm.record);
			},
			exportRecord(url) {
				const vm = this;
				axios.get('/' + url + '/' + vm.record.id).then(response => {
					vm.showMessage('custom', null, null, null, 'Registro exportado exitosamente');
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
			},
			getAssignableType() {
				const vm = this;
				var url = '';
				vm.assignable_types = [];
				var element = document.getElementById('assignable_type_label');

				if (vm.record.payroll_assign_to_id > 0) {
					if (vm.record.payroll_assign_to_id == 1) {
						url = 'get-staff-types';

					} else if (vm.record.payroll_assign_to_id == 2) {
						url = 'get-position-types';
					} else if (vm.record.payroll_assign_to_id == 4) {
						url = 'get-staffs';
					} else if (vm.record.payroll_assign_to_id == 5) {
						url = 'get-salary-tabulators';
					} else if (vm.record.payroll_assign_to_id == 6) {
						url = 'get-salary-scales';
						return;
					}
					if (element && vm.record.payroll_assign_to_id != 3) {
						element = vm.payroll_assign_to[vm.record.payroll_assign_to_id].text;
						axios.get('/payroll/' + url).then(response => {
							vm.assignable_types = response.data;
						});
					}
				}
			},
			loadSalaryScale() {
				const vm = this;
				if(vm.record.payroll_salary_scale_id > 0) {
					var id = vm.record.payroll_salary_scale_id;
					axios.get('/payroll/salary-scales/info/' + id).then(response => {
						vm.payroll_salary_scale = response.data.record;
					});
				}

			},
			viewAssignableTypes() {
				const vm = this;
				return ((vm.record.payroll_assign_to_id != '' ) && (vm.record.payroll_assign_to_id != '3'))?true:false;
			}
		},
	};
</script>

