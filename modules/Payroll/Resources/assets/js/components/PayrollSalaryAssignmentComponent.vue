<template>
	<div class="col-md-2 text-center">
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
									<ul>
										<li v-for="error in errors">{{ error }}</li>
									</ul>
								</div>

								<div class="row">
									<div class="col-md-4">
										<div class=" form-group is-required">
											<label>Tipo de Asignación</label>
											<select2 :options="payroll_salary_assignment_types"
												v-model="record.assignment_type_id"></select2>
										</div>
									</div>
									<div class="col-md-4">
										<div class=" form-group is-required">
											<label>Tipo de Cargo</label>
											<select2 :options="payroll_position_types"
												v-model="record.position_type_id"></select2>
										</div>
									</div>
									<div class="col-md-4">
										<div class=" form-group is-required">
											<label>Periodicidad</label>
											<select2 :options="periodicities"
												v-model="record.periodicity_id"></select2>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<div class="col-md-8">
												<div class=" form-group is-required">
													<label>Nombre:</label>
													<input type="text" placeholder="Nombre de la asignación" 
																	data-toggle="tooltip"
																	class="form-control input-sm"
																	v-model="record.name">
													<input type="hidden" v-model="record.id">
												</div>
											</div>
											<div class="col-md-4">
												<div class=" form-group">
													<label>¿Activa?</label>
													<div class="col-12">
														<input type="checkbox" class="form-control bootstrap-switch" 
														   data-toggle="tooltip" name="active" 
														   title="Indique si la asignación esta activa"
														   data-on-label="SI" data-off-label="NO" 
														   v-model="record.active" value="true">
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<strong>Tipo de Incidencia</strong>
											</div>
											<div class="col-md-4">
												<div class=" form-group">
													<label>Valor Absoluto</label>
													<div class="col-12">
														<input type="radio" name="incidence_value" 
																value="Valor Neto" id="sel_neto_value" 
																class="form-control bootstrap-switch bootstrap-switch-mini sel_incidence_value" 
																data-on-label="SI" data-off-label="NO">
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class=" form-group">
													<label>Unidad Tributaria</label>
													<div class="col-12">
														<input type="radio" name="incidence_value" 
																value="Unidad Tributaria" id="sel_tax_unit" 
																class="form-control bootstrap-switch bootstrap-switch-mini sel_incidence_value" 
																data-on-label="SI" data-off-label="NO">
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class=" form-group">
													<label>Porcentaje</label>
													<div class="col-12">
														<input type="radio" name="incidence_value" 
																value="Porcentaje" id="sel_percent" 
																class="form-control bootstrap-switch bootstrap-switch-mini sel_incidence_value" 
																data-on-label="SI" data-off-label="NO">
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<strong>Propiedades del Escalafón</strong>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<label>Descripción:</label>
													<textarea  data-toggle="tooltip" 
															   title="Indique alguna descripción asociada a la asignación"
															   rows="2" 
															   class="form-control" v-model="record.description">
												   </textarea>
							                    </div>
											</div>
					                    </div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class=" form-group is-required">
											<label>Nombre del Escalafón</label>
											<input type="text" placeholder="Nombre del Escalafón" 
															data-toggle="tooltip"
															class="form-control input-sm"
															v-model="record.salary_scale">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Descripción:</label>
											<textarea  data-toggle="tooltip" 
													   title="Indique alguna descripción asociada al escalafón"
													   rows="1"
													   class="form-control" v-model="record.salary_scale_description">
										   </textarea>
					                    </div>
									</div>
								</div>
								<div class="row" v-show="this.ladders.length > 0">
									<table class="table table-hover table-striped table-responsive  table-assignment">
										<thead>
											<tr class="text-center">
												<th>{{ record.salary_scale}}:</th>
												<th v-for="(field,index) in ladders">
													{{field.name}}
												</th>
											</tr>
										</thead>
										<tbody>
											<tr class="selected-row text-center">
												<th>
													{{ record.incidence_value }}:</th>
												<td v-for="(field,index) in ladders">
													{{ field.value}}
												</td>
											</tr>
											<tr class="config-row text-center">
												<th>Acción:</th>
												<td v-for="(field,index) in ladders">
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
								<div class="row">
									<div class="col-md-12">
										<strong>Nueva Escala</strong>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group is-required">
													<label>Código:</label>
													<input type="text" placeholder="Código de la Escala" 
															data-toggle="tooltip"
															class="form-control input-sm"
															v-model="scale.code">
							                    </div>
											</div>
											<div class="col-md-6">
												<div class=" form-group is-required">
													<label>Valor de Incidencia</label>
													<input type="number" placeholder="Valor de Incidencia" 
																	min="0" step=".01"
																	data-toggle="tooltip"
																	class="form-control input-sm"
																	v-model="scale.value">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<div class=" form-group is-required">
													<label>Nombre:</label>
													<input type="text" placeholder="Nombre de la Escala" 
															data-toggle="tooltip"
															class="form-control input-sm"
															v-model="scale.name">
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<label>Descripción:</label>
													<textarea  data-toggle="tooltip" 
															   title="Indique alguna descripción asociada a la escala"
															   class="form-control input-sm"
															   rows="1" 
															   v-model="scale.description">
												   </textarea>
							                    </div>
											</div>
											<div class="col-md-12" style="margin-bottom:0px; margin-top: auto;">
												<button type="button" @click="addScale($event)"class="btn btn-sm btn-primary btn-custom float-right" 
														title="Agregar registro a la lista"
														data-toggle="tooltip">
													<i class="fa fa-plus-circle"></i>
													Agregar
												</button>
											</div>	
										</div>
									</div>
								</div>
	                    	</div>
	                   
	                    	<div class="tab-pane" id="view" role="tabpanel">
	                    		<div v-if="this.ladders.length > 0">
		                    		<div class="row">
		                    			<div class="col-md-12">
											<button type="button" class="btn btn-sm btn-success btn-custom float-right" 
													title="Exportar tabla en formato xls"
													data-toggle="tooltip">
												<i class="fa fa-file-excel-o"></i>
												Exportar
											</button>
										</div>
		                    		</div>
		                    		<div class="row">
										<table class="table table-hover table-striped table-responsive  table-assignment">
											<thead>
												<tr>
													<th :colspan="1 + ladders.length"><strong>{{ record.name }}</strong></th>
												</tr>
											</thead>
											<tbody>
												<tr class="text-center">
													<th>{{ record.salary_scale}}</th>
													<th v-for="(field,index) in ladders">
														{{field.name}}
													</th>
												</tr>
												<tr class="selected-row text-center">
													<th>
														{{ record.incidence_value }}</th>
													<td v-for="(field,index) in ladders">
														{{ field.value}}
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

						<div class="modal-table">
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

					<div class="modal-footer">

	                	<button type="button" class="btn btn-default btn-sm btn-round btn-modal-close" 
	                			data-dismiss="modal">
	                		Cerrar
	                	</button>
	                	<button type="button" @click="createRecord('payroll/salary-assignments')"
	                			class="btn btn-primary btn-sm btn-round btn-modal-save">
	                		Guardar
		                </button>

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
	.modal {
		overflow: auto !important;
	}
</style>

<script>
	export default {
		data() {
			return {
				record: {
					id: '',
					name: '',
					value: '',
					active: true,
					incidence: '',
					description:'',
					salary_scale: '',
					salary_scale_description: '',
					position_type_id: '',
					incidence_value: '',
					assignment_type_id: '',
					periodicity_id: '',
					ladder_id: '',
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
				columns: ['name', 'assignment_type_id', 'periodicity_id', 'incidence_value', 'id'],

				ladders: [],
				payroll_position_types: [],
				payroll_salary_assignment_types: [],

				periodicities: [
					{"id":"","text":"Seleccione..."},
					{"id":1,"text":"Mensual"},
					{"id":2,"text":"Bimensual"},
					{"id":3,"text":"Trimestral"},
					{"id":4,"text":"Cuatrimestral"},
					{"id":5,"text":"Semestral"},
					{"id":6,"text":"Anual"}],
			}
		},
		created() {
			this.table_options.headings = {
				'name': 'Nombre',
				'assignment_type_id': 'Tipo de Asignación',
				'periodicity_id': 'Periodicidad',
				'incidence_value': 'Tipo de Incidencia',
				'id': 'Acción'
			};
			this.table_options.sortable = ['name', 'assignment_type_id', 'periodicity_id', 'incidence_value'];
			this.table_options.filterable = ['name', 'assignment_type_id', 'periodicity_id', 'incidence_value'];
		},
		mounted() {
			const vm = this;
			this.switchHandler('active');
			this.switchHandler('incidence');
			this.switchHandler('incidence_value');

			
			$("#add_assignment").on('show.bs.modal', function() {
				vm.getPayrollPositionTypes();
				vm.getPayrollSalaryAssignmentTypes();
			});
		},
		methods: {
			reset() {
				this.record = {
					id: '',
					name: '',
					value: '',
					active: '',
					incidence: '',
					description: '',
					salary_scale: '',
					salary_scale_description: '',
					position_type_id: '',
					incidence_value: '',
					assignment_type_id: '',
					periodicity_id: '',
					ladder_id: '',
				}
				this.resetScale();
				this.errors = [];
			},
			resetScale() {
				this.scale = {
					id: '',
					name: '',
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
					vm.ladders.push(field);
				else if(vm.editIndex >= 0 ){				
					vm.ladders.splice(vm.editIndex, 1);
					vm.ladders.push(field);
					vm.editIndex = null;
				}
				event.preventDefault();
			},
			editScale(index,event){
				const vm = this;
				vm.editIndex = index;
				vm.scale = vm.ladders[index];
				event.preventDefault();
			},
			removeScale(index,event) {
				const vm = this;
				vm.ladders.splice(index, 1);
				vm.editIndex = null;
				event.preventDefault();
			},
			createRecord(url) {
				const vm = this;
				var field = {
					record: vm.record,
					salary_scale: vm.ladders,
				};
				console.log(field);
			}
		},
	};
</script>

