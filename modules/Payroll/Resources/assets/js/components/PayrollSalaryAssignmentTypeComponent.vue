<template>
	<div class="col-xs-2 text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary"
		   href="#" title="Tipos de Asignaciones de Nómina" data-toggle="tooltip"
		   @click="addRecord('add_assignment_type', 'salary-assignment-types', $event)">
			<i class=""></i>
			<span>Tipos de Asignaciones</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_assignment_type">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class=""></i>
							Nuevo Tipo de Asignación
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
								<div class="form-group is-required">
									<label>Tipo de Asignación:</label>
									<input type="text" placeholder="Nombre del Tipo de Asignación" data-toggle="tooltip"
										   title="Indique el nombre del Nuevo Tipo de Asignación (requerido)"
										   class="form-control input-sm" v-model="record.name">
									<input type="hidden" v-model="record.id">
			                    </div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Descripción:</label>
									<input type="text" placeholder="Descripción del Tipo de Asignación" data-toggle="tooltip"
										   title="Indique una breve descripción del Nuevo Tipo de Asignación (opcional)"
										   class="form-control input-sm" v-model="record.description">
			                    </div>
							</div>
						</div>

						<div class="modal-table">
		                	<hr>
		                	<v-client-table :columns="columns" :data="records" :options="table_options">
		                		<div slot="id" slot-scope="props" class="text-center">
		                			<button @click="initUpdate(props.index, $event)"
			                				class="btn btn-warning btn-xs btn-icon btn-action"
			                				title="Modificar registro" data-toggle="tooltip" type="button">
			                			<i class="fa fa-edit"></i>
			                		</button>
			                		<button @click="deleteRecord(props.index, 'salary-assignment-types')"
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
	                	<button type="button" @click="createRecord('payroll/salary-assignment-types')"
	                			class="btn btn-primary btn-sm btn-round btn-modal-save">
	                		Guardar
		                </button>

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
					description: '',
				},
				errors: [],
				records: [],
				columns: ['name', 'description', 'id'],
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
		},
		methods: {
			reset() {
				this.record = {
					id: '',
					name: '',
					description: '',
				}
				this.errors = [];
			},

		},
	};
</script>

