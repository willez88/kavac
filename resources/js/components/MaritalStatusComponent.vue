<template>
	<div class="col-md-2 text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary" href="" 
		   title="Registros de estados civiles" data-toggle="tooltip" 
		   @click="addRecord('add_marital_status', 'marital-status', $event)">
			<i class="fa fa-female ico-3x inline-block"></i>
			<i class="fa fa-male ico-3x nopadding-left"></i>
			<span>Estados<br>Civiles</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_marital_status">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="fa fa-female inline-block"></i>
							<i class="fa fa-male inline-block"></i> 
							Estado Civil
						</h6>
					</div>
					<div class="modal-body">
						<div class="alert alert-danger" v-if="errors.length > 0">
							<ul>
								<li v-for="error in errors">{{ error }}</li>
							</ul>
						</div>
						<div class="form-group is-required">
							<label for="marital_status_name">Nombre:</label>
							<input type="text" id="name" placeholder="Estado Civil" 
								   class="form-control input-sm" v-model="record.name" data-toggle="tooltip" 
								   title="Indique el nombre del estado civil (requerido)">
							<input type="hidden" name="id" id="id" v-model="record.id">
	                    </div>
	                </div>
	                <div class="modal-body modal-table">
	                	<hr>
	                	<v-client-table :columns="columns" :data="records" :options="table_options">
	                		<div slot="id" slot-scope="props" class="text-center">
	                			<button @click="initUpdate(props.index, $event)" 
		                				class="btn btn-warning btn-xs btn-icon btn-action" 
		                				title="Modificar registro" data-toggle="tooltip" type="button">
		                			<i class="fa fa-edit"></i>
		                		</button>
		                		<button @click="deleteRecord(props.index, 'marital-status')" 
										class="btn btn-danger btn-xs btn-icon btn-action" 
										title="Eliminar registro" data-toggle="tooltip" 
										type="button">
									<i class="fa fa-trash-o"></i>
								</button>
	                		</div>
	                	</v-client-table>
	                </div>
	                <div class="modal-footer">
	                	<button type="button" class="btn btn-default btn-sm btn-round btn-modal-close" data-dismiss="modal">
	                		Cerrar
	                	</button>
	                	<button type="button" @click="createRecord('marital-status')" class="btn btn-primary btn-sm btn-round btn-modal-save">
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
					name: ''
				},
				errors: [],
				records: [],
				columns: ['name', 'id'],
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
					name: ''
				};
			},
		},
		created() {
			this.table_options.headings = {
				'name': 'Nombre',
				'id': 'Acción'
			};
			this.table_options.sortable = ['name'];
			this.table_options.filterable = ['name'];
			this.table_options.columnsClasses = {
				'name': 'col-md-10',
				'id': 'col-md-2'
			};
		},
	};
</script>