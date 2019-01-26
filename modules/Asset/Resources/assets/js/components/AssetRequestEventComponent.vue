<template>
	<div>
		<a class="btn btn-success btn-xs btn-icon btn-round" 
		   href="#" title="Registros de Eventos" data-toggle="tooltip" 
		   @click="addRecord('add_event', 'requests/request-event', $event)">
		   <i class=""></i>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_event">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-read-book ico-2x"></i> 
							Nuevo Evento
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
									<label>Tipo de Evento:</label>
									<select2 :options="types"
										v-model="record.type_id">
									</select2>

									<input type="hidden" v-model="record.id">
			                    </div>
							</div>
							<div class="col-md-6">
								<div class="form-group is-required">
									<label>Descripción del Evento</label>
									<input  type="text" 
											data-toggle="tooltip" 
											class="form-control input-sm"
											v-model="record.description"
											id="description_event">
								</div>
							</div>
						</div>

	                </div>

	                <div class="modal-body modal-table">
	                	<hr>
	                	<v-client-table :columns="columns" :data="records" :options="table_options">
	                		<div slot="id" slot-scope="props" class="text-center">
	                			<button @click="initUpdate(props.index, $event)" 
		                				class="btn btn-warning btn-xs btn-icon btn-round" 
		                				title="Modificar registro" data-toggle="tooltip" type="button">
		                			<i class="fa fa-edit"></i>
		                		</button>
		                		<button @click="deleteRecord(props.index, 'requests/request-event')" 
										class="btn btn-danger btn-xs btn-icon btn-round" 
										title="Eliminar registro" data-toggle="tooltip" 
										type="button">
									<i class="fa fa-trash-o"></i>
								</button>
	                		</div>
	                	</v-client-table>
	                </div>

	                <div class="modal-footer">

	                	<button type="button" @click="reset()"
								class="btn btn-default btn-icon btn-round"
								title ="Borrar datos del formulario">
								<i class="fa fa-eraser"></i>
						</button>
	                	
	                	<button type="button" 
	                			class="btn btn-warning btn-icon btn-round btn-modal-close" 
	                			data-dismiss="modal"
	                			title="Cancelar y regresar">
	                			<i class="fa fa-ban"></i>
	                	</button>

	                	<button type="button" @click="createRequest('asset/requests/request-event')" 
	                			class="btn btn-success btn-icon btn-round btn-modal-save"
	                			title="Guardar registro">
	                		<i class="fa fa-save"></i>
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
					id:'',
					type_id: '',
					request_id: '',
					description: '',

				},
				types: [],
				records: [],
				errors: [],
				columns: ['type', 'description', 'id'],
			}
		},
		props: ['id'],
		methods: {
			/**
			 * Método que borra todos los datos del formulario
			 * 
			 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
			 */
			reset() {
				this.record = {
					id:'',
					type_id: '',
					request_id: '',
					description: '',
				};
			},
			createRequest(url){
				this.record.request_id = this.id;
				this.createRecord(url);
			},

			getTypes() {
				axios.get('/asset/get-request-types').then(response => {
					this.types = response.data;
				});
			}
		},
		created() {
			this.table_options.headings = {
				'type': 'Tipo',
				'description': 'Descripción',
				'id': 'Acción'
			};
			this.table_options.sortable = ['type'];
			this.table_options.filterable = ['type'];

			this.getTypes();
		},
	}
</script>