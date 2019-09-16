<template>
	<div class="col-md-2 text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary" 
		   href="#" title="Registros de documentos a solicitar" 
		   data-toggle="tooltip" 
		   @click="addRecord('add_required_doc', '/required-documents/' + model + '/' + module, $event)">
			<i class="icofont icofont-copy-alt ico-3x"></i>
			<span>Documentos Requeridos</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_required_doc">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-copy-alt inline-block"></i> 
							Documentos Requeridos
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
									<label>Nombre:</label>
									<input type="text" 
										   placeholder="Nombre del documento requerido" 
										   data-toggle="tooltip" v-model="record.name" 
										   title="Indique el nombre del documento a solicitar (requerido)" class="form-control input-sm">
			                    </div>
							</div>
							<div class="col-md-12">
								<div class="form-group is-required">
									<label>Descripción:</label>
									<textarea class="form-control input-sm" rows="3" 
											  title="Indique la descripción para el documento a solicitar" 
											  placeholder="Descripción del documento a solicitar" 
											  v-model="record.description" data-toggle="tooltip"></textarea>
			                    </div>
							</div>
						</div>
	                </div>
	                <div class="modal-footer">
	                	<div class="form-group">
	                		<button type="button" data-dismiss="modal" 
		                			class="btn btn-default btn-sm btn-round btn-modal-close">
		                		Cerrar
		                	</button>
		                	<button type="button" @click="createRecord('required-documents/' + model + '/' + module)" 
		                			class="btn btn-primary btn-sm btn-round btn-modal-save">
		                		Guardar
			                </button>
	                	</div>
	                </div>
	                <div class="modal-body modal-table">
	                	<v-client-table :columns="columns" :data="records" :options="table_options">
	                		<div slot="id" slot-scope="props" class="text-center">
	                			<button @click="initUpdate(props.index, $event)" 
		                				class="btn btn-warning btn-xs btn-icon btn-round" 
		                				title="Modificar registro" data-toggle="tooltip" type="button">
		                			<i class="fa fa-edit"></i>
		                		</button>
		                		<button @click="deleteRecord(props.index, '/required-documents/' + model + '/' + module)" 
										class="btn btn-danger btn-xs btn-icon btn-round" 
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
					description: '',
				},
				errors: [],
				records: [],
				columns: ['name', 'description', 'id'],
			}
		},
		props: ['module', 'model'],
		methods: {
			/**
			 * Método que borra todos los datos del formulario
			 * 
			 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
			 */
			reset() {
				this.record = {
					id: '',
					name: '',
					description: '',
				};
			},
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
				'name': 'col-md-3',
				'description': 'col-md-7',
				'id': 'col-md-2'
			};
		},
	};
</script>
