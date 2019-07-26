<template>
	<div>
		<a class="btn btn-success btn-xs btn-icon btn-action" 
		   href="#" title="Registros de Eventos" data-toggle="tooltip" 
		   :disabled="((state == 'Aprobado')||(state == 'Pendiente por entrega'))?false:true"
		   @click="((state == 'Aprobado')||(state == 'Pendiente por entrega'))?addRecord('add_event', 'requests/request-event', $event):viewMessage()">
		   <i class="fa fa-list-alt"></i>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_event">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-tasks-alt ico-2x"></i> 
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
											 data-toggle="tooltip"
											 title="Indique el tipo de evento ocurrido"
											 v-model="record.type">
									</select2>

									<input type="hidden" v-model="record.id">
			                    </div>
							</div>
							<div class="col-md-6">
								<div class="form-group is-required">
									<label>Descripción del Evento</label>
									<textarea  data-toggle="tooltip" 
											   title="Indique una descripción del evento" 
											   class="form-control" v-model="record.description"
											   id="description_event">
								   </textarea>
								</div>
							</div>
						</div>

	                </div>

	                <div class="modal-body modal-table">
	                	<hr>
	                	<v-client-table :columns="columns" :data="records" :options="table_options">
	                		<div slot="type" slot-scope="props" class="text-center">
								<div v-for="type in types">
									<span v-if="props.row.type == type.id">
										{{ type.text }}
									</span>
								</div>
							</div>
	                		<div slot="id" slot-scope="props" class="text-center">
	                			<button @click="initUpdate(props.index, $event)" 
		                				class="btn btn-warning btn-xs btn-icon btn-action" 
		                				title="Modificar registro" data-toggle="tooltip" type="button">
		                			<i class="fa fa-edit"></i>
		                		</button>
		                		<button @click="deleteRecord(props.index, 'requests/request-event')" 
										class="btn btn-danger btn-xs btn-icon btn-action" 
										title="Eliminar registro" data-toggle="tooltip" 
										type="button">
									<i class="fa fa-trash-o"></i>
								</button>
	                		</div>
	                	</v-client-table>
	                </div>

	                <div class="modal-footer">

		                <button type="button" class="btn btn-default btn-sm btn-round btn-modal-close"
	                			data-dismiss="modal">
	                		Cerrar
	                	</button>
	                	<button type="button" @click="createRequest('asset/requests/request-event')" 
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
					id:'',
					type: '',
					asset_request_id: '',
					description: '',

				},
				types: [],
				records: [],
				errors: [],
				columns: ['type', 'description', 'id'],
			}
		},
		props: {
			id: Number,
			state: String,
		},
		methods: {
			/**
			 * Método que borra todos los datos del formulario
			 * 
			 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
			 */
			reset() {
				this.record = {
					id:'',
					type: '',
					asset_request_id: '',
					description: '',
				};
			},
			createRequest(url){
				this.record.asset_request_id = this.id;
				this.createRecord(url);
			},

			getTypes() {
				axios.get('/asset/get-request-types').then(response => {
					this.types = response.data;
				});
			},
			viewMessage() {
            	const vm = this;
            	vm.showMessage('custom', 'Alerta', 'danger', 'screen-error', 'La solicitud está en un tramite que no le permite acceder a esta funcionalidad');
            	return false;
            },
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