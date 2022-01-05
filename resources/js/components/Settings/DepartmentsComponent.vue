<template>
	<div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 mt-2 mb-2 text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary"
		   href="javascript:void(0)" title="Registro de la estructura organizacional"
		   data-toggle="tooltip" @click="addRecord('add_department', 'departments', $event)">
			<i class="icofont icofont-architecture-alt ico-3x"></i>
			<span>Unidades / Dependencias</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_department">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-architecture-alt inline-block"></i>
							Unidades / Dependencias
						</h6>
					</div>
					<div class="modal-body">
						<form-errors :listErrors="errors"></form-errors>
						<div class="row">
							<div class="col-12 col-md-6">
								<div class="form-group is-required">
									<label>Organización:</label>
									<select2 :options="institutions" v-model="record.institution_id"
											 title="Organización a la cual pertenece" @input="getDepartments()"
											 data-toggle="tooltip"></select2>
									<input type="hidden" v-model="record.id">
			                    </div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group">
									<label>Depende de:</label>
									<select2 :options="departments" v-model="record.parent_id" id="parentId"
											 title="Unidad, Departamento o dependencia de la cual depende. No seleccionar si no es subordinada a otra dependencia"
											 data-toggle="tooltip"></select2>
			                    </div>
							</div>
							<div class="col-12 col-md-2">
								<div class="form-group">
									<label>Siglas:</label>
									<input type="text" class="form-control input-sm" data-toggle="tooltip"
										   title="Siglas o acrónimo para el departamento (si posee)"
										   placeholder="SIGLAS" v-model="record.acronym" v-is-text>
			                    </div>
							</div>
							<div class="col-12 col-md-10">
								<div class="form-group is-required">
									<label>Nombre:</label>
									<input type="text" class="form-control input-sm" data-toggle="tooltip"
										   placeholder="Nombre de la unidad, departamento o dependencia"
										   v-model="record.name" v-is-text>
			                    </div>
							</div>
							<div class="col-12 col-md-2">
								<div class="form-group is-required">
									<label>Solicita almacén:</label>
									<div class="col-12">
                                        <div class="bootstrap-switch-mini">
    										<input type="checkbox" class="form-control bootstrap-switch"
    											   data-toggle="tooltip" data-on-label="SI" data-off-label="NO"
    											   title="Indique si puede emitir solicitudes de almacén"
    											   v-model="record.issue_requests" value="true" name="issue_requests">
                                        </div>
									</div>
			                    </div>
							</div>
							<div class="col-12 col-md-2">
								<div class="form-group is-required">
									<label>Activo:</label>
									<div class="col-12">
                                        <div class="bootstrap-switch-mini">
    										<input type="checkbox" class="form-control bootstrap-switch" name="active"
    											   data-toggle="tooltip" title="Indique si se encuentra activo"
    											   data-on-label="SI" data-off-label="NO" value="true"
    											   v-model="record.active">
                                        </div>
									</div>
			                    </div>
							</div>
							<div class="col-12 col-md-2">
								<div class="form-group is-required">
									<label>Administrativo:</label>
									<div class="col-12">
                                        <div class="bootstrap-switch-mini">
    										<input type="checkbox" class="form-control bootstrap-switch"
    											   data-toggle="tooltip" title="Indique si la unidad, departamento o dependencia es del área administrativa" name="administrative"
    											   data-on-label="SI" data-off-label="NO" value="true"
    											   v-model="record.administrative">
                                        </div>
									</div>
			                    </div>
							</div>
						</div>
	                </div>
	                <div class="modal-footer">
	                	<div class="form-group">
	                		<modal-form-buttons :saveRoute="setUrl('departments')"></modal-form-buttons>
	                	</div>
	                </div>
	                <div class="modal-body modal-table">
	                	<v-client-table :columns="columns" :data="records" :options="table_options">
							<div slot="parent.name" slot-scope="props">
								<span v-if="props.row.parent">
									{{ props.row.parent.name }}
								</span>
								<span v-else>N/A</span>
							</div>
							<div slot="active" slot-scope="props">
								<span v-if="props.row.active">SI</span>
								<span v-else>NO</span>
							</div>
	                		<div slot="id" slot-scope="props" class="text-center">
	                			<button @click="initUpdate(props.row.id, $event)"
		                				class="btn btn-warning btn-xs btn-icon btn-action"
		                				title="Modificar registro" data-toggle="tooltip" type="button">
		                			<i class="fa fa-edit"></i>
		                		</button>
		                		<button @click="deleteRecord(props.row.id, 'departments')"
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
					institution_id: '',
					parent_id: '',
					acronym: '',
					name: '',
					issue_requests: false,
					active: false,
					administrative: false
				},
				institutions: [],
				departments: [],
				errors: [],
				records: [],
				columns: [
					'institution.acronym', 'parent.name', 'acronym', 'name', 'active', 'id'
				],
			}
		},
		watch: {
			record: {
				deep: true,
				handler: function(newValue, oldValue) {
					const vm = this;
					
					if (
						typeof(vm.record.parent) !== "undefined" && 
						vm.record.parent !== null && 
						vm.record.parent_id !== vm.record.parent.id && 
						!vm.record.parent_id
					) {
						setTimeout(() => {
							vm.record.parent_id = vm.record.parent.id;
						}, 3000);
					}
				}
			},
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
					institution_id: '',
					parent_id: '',
					acronym: '',
					name: '',
					issue_requests: false,
					active: false,
					administrative: false
				};
			},
		},
		created() {
			this.table_options.headings = {
				'institution.acronym': 'Organización',
				'parent.name': 'Depende de',
				'acronym': 'Siglas',
				'name': 'Nombre',
				'active': 'Activo',
				'id': 'Acción'
			};
			this.table_options.sortable = ['institution.acronym', 'parent.name', 'acronym', 'name'];
			this.table_options.filterable = ['institution.acronym', 'parent.name', 'acronym', 'name'];
			this.table_options.columnsClasses = {
				'institution.acronym': 'col-md-2',
				'parent.name': 'col-md-2',
				'acronym': 'col-md-2',
				'name': 'col-md-3',
				'active': 'col-md-1',
				'id': 'col-md-2'
			};
		},
		mounted() {
			let vm = this;
			$("#add_department").on('show.bs.modal', function() {
				vm.getInstitutions();
				vm.getDepartments();
			});
			vm.switchHandler('issue_requests');
			vm.switchHandler('active');
			vm.switchHandler('administrative');
		}
	};
</script>
