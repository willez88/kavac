<template>
	<div class="col-md-2 text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary" 
		   href="#" title="Registros de Categorias Generales de Bienes" data-toggle="tooltip" 
		   @click="initRequest('categories',$event)">
			<i class="icofont icofont-read-book ico-3x"></i>
			<span>Categorias<br>Generales</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_category">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-read-book ico-2x"></i> 
							Nueva Categoria General de Bienes
						</h6>
					</div>
					<div class="modal-body">
						<div class="alert alert-danger" v-if="errors.length > 0">
							<ul>
								<li v-for="error in errors">{{ error }}</li>
							</ul>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>Tipo de Bien:</label>
									<select2 :options="types"
											 v-model="record.asset_type_id"></select2>
									<input type="hidden" v-model="record.id">
			                    </div>
							</div>
					
							<div class="col-md-6">
								<div class="form-group is-required">
									<label>Código de la Categoría General:</label>
									<input type="text" placeholder="Código de Categoría General" data-toggle="tooltip" 
										   title="Indique el código de la nueva Categoría General (requerido)" 
										   class="form-control input-sm" v-model="record.code">
			                    </div>
							</div>
							<div class="col-md-6">
								<div class="form-group is-required">
									<label>Categoría General:</label>
									<input type="text" placeholder="Nueva Categoría General" data-toggle="tooltip" 
										   title="Indique la nueva Categoría General (requerido)" 
										   class="form-control input-sm" v-model="record.name">
			                    </div>
							</div>

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
		                		<button @click="deleteRecord(props.index, 'categories')" 
										class="btn btn-danger btn-xs btn-icon btn-action" 
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

	                	<button type="button"  @click="createRecord('asset/categories')"
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
					id: '',
					asset_type_id: '',
					name: '',
					code: ''
				},
				errors: [],
				records: [],
				types: [],
				columns: ['type.name', 'name', 'code', 'id'],
			}
		},
		created() {
			this.table_options.headings = {
				'type.name': 'Tipo de Bien',
				'name': 'Categoria General',
				'code': 'Código',
				'id': 'Acción'
			};
			this.table_options.sortable = ['type.name','name', 'code'];
			this.table_options.filterable = ['type.name','name', 'code'];

			
		},
		methods: {
			/**
			 * Método que borra todos los datos del formulario
			 * 
			 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
			 */
			reset() {
				this.record = {
					id: '',
					asset_type_id: '',
					name: '',
					code: ''
				};
			},
			initRequest(url,event){
				this.getTypes();
				this.addRecord('add_category', url, event);
			},
			/**
			 * Inicializa los registros base del formulario
			 *
			 * @author Henry Paredes (henryp2804@gmail.com)
			 */
			getTypes() {
				axios.get('/asset/get-types').then(response => {
					this.types = response.data;
				});
			}

		}
	};
</script>