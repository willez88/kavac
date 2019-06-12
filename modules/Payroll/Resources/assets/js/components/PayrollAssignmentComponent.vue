<template>
	<div class="col-md-2 text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary" 
		   href="#" title="Registro de Asignaciones de Nómina" data-toggle="tooltip" 
		   @click="addRecord('add_assignment', 'assignments', $event)">
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
						<div class="alert alert-danger" v-if="errors.length > 0">
							<ul>
								<li v-for="error in errors">{{ error }}</li>
							</ul>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class=" form-group is-required">
									<label>Nombre de Asignación</label>
									<input type="text" placeholder="Nombre de la asignación" 
													data-toggle="tooltip"
													class="form-control input-sm"
													v-model="record.name">
									<input type="hidden" v-model="record.id">
								</div>
							</div>
							<div class="col-md-6">
								<div class=" form-group is-required">
									<label>Tipo de Asignación</label>
									<select2 :options="assignment_types"
										v-model="record.assignment_type_id"></select2>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class=" form-group is-required">
									<label>Tipo de Cargo</label>
									<select2 :options="position_types"
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
							<div class="col-md-4">
								<div class=" form-group">
									<label>¿Incide sobre el sueldo base?</label>
									<div class="col-12">
										<input type="checkbox" class="form-control bootstrap-switch" 
										   data-toggle="tooltip" name="active" 
										   title="Indique si la asignación tiene incidencia sobre el sueldo base"
										   data-on-label="SI" data-off-label="NO" 
										   v-model="record.active" value="true">
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<strong>Propiedades del Escalafón</strong>
							</div>
							<div class="col-md-12">
								<div class=" form-group is-required">
									<label>Nombre del Escalafón</label>
									<input type="text" placeholder="Nombre del Escalafón" 
													data-toggle="tooltip"
													class="form-control input-sm"
													v-model="record.salary_scale">
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
						<hr>
						<div class="row">
							<div class="col-md-6">
								<div class=" form-group">
									<label>Definir Escala</label>
									<div class="col-12">
										<input type="checkbox" class="form-control bootstrap-switch"
											name="new_salary_scale" id="sel_new_scale" 
											data-on-label="Si" data-off-label="No" value="true"
											v-model="record.new_salary_scale">
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class=" form-group">
									<label>Visualizar Escalafón</label>
									<div class="col-12">
										<input type="checkbox" class="form-control bootstrap-switch"
											name="view_salary_scale" id="sel_view_scale" 
											data-on-label="Si" data-off-label="No" value="true"
											v-model="record.view_salary_scale">
									</div>
								</div>
							</div>
						</div>
						<div class="row" v-show="this.record.new_salary_scale">
							<div class="col-md-12">
								<strong>Nueva Escala</strong>
							</div>
							<div class="col-md-6">
								<div class=" form-group is-required">
									<label>Nombre</label>
									<input type="text" placeholder="Nombre de la Escala" 
													data-toggle="tooltip"
													class="form-control input-sm"
													v-model="scale.name">
									<input type="hidden" v-model="scale.id">
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
							<div class="col-md-12">
								<button type="button" @click="addScale($event)"class="btn btn-sm btn-primary btn-custom float-right" 
										title="Agregar registro a la lista"
										data-toggle="tooltip">
									<i class="fa fa-plus-circle"></i>
									Agregar
								</button>
							</div>
						</div>
						<div class="row" v-show="this.record.view_salary_scale">
							<div v-if="this.record.name != ''">
								<hr>
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
										<tr class="config-row text-center" v-show="this.record.new_salary_scale">
											<th>Acción</th>
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
							<div v-else>
								<div class="col-md-12">
									<span><b>Table Not Defined</b></span>
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
			                		<button @click="deleteRecord(props.index, 'assignments')" 
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
	                	<button type="button" 
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
					active: '',
					salary_scale: '',
					incidence_value: '',
					assignment_type_id: '',
					periodicity_id: '',
					ladder_id: '',

					new_salary_scale: false,
					view_salary_scale: false,
				},

				scale: {
					id: '',
					name: '',
					value: '',
				},
				editIndex: null,
				errors: [],
				records: [],
				columns: ['name', 'assignment_type_id', 'periodicity_id', 'incidence_value', 'id'],

				ladders: [],
				position_types: [],
				assignment_types: [],

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
			this.switchHandler('incidence_value');
			this.switchHandler('new_salary_scale');
			this.switchHandler('view_salary_scale');

			
			$("#add_assignment").on('show.bs.modal', function() {
				vm.getPositionTypes();
				vm.getAssignmentTypes();
			});
		},
		methods: {
			reset() {
				this.record = {
					id: '',
					name: '',
					value: '',
					active: '',
					salary_scale: '',
					incidence_value: '',
					assignment_type_id: '',
					periodicity_id: '',
					ladder_id: '',

					new_salary_scale: false,
					view_salary_scale: false,
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
			removeScale(index,event){
				const vm = this;
				vm.ladders.splice(index, 1);
				vm.editIndex = null;
				event.preventDefault();
			}
		},
	};
</script>

