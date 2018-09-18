<template>
	<div class="col-md-2 text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary" 
		   href="" title="Registros de Clasificador de Bienes" 
		   data-toggle="tooltip" @click="addRecord('add_clasification', 'asset/clasifications', $event)">
			<i class="icofont icofont-read-book ico-3x"></i>
			<span>Clasificador<br>Bienes</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_clasification">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-read-book ico-2x"></i> 
							Clasificación de Bienes
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
								<div class="form-group">
									<label>Tipo de Bien:</label>
									<select2 :options="types" @input="getCategories" 
											 v-model="record.type_id"></select2>
									<input type="hidden" v-model="record.id">
			                    </div>
							</div>
							<div class="col-md-6">
								<div class="form-group is-required">
									<label>Tipo de Bienes:</label>
									<input type="text" placeholder="Nuevo Tipo de Bienes" data-toggle="tooltip" 
										   title="Indique el nuevo Tipo de Bienes (requerido)" 
										   class="form-control input-sm" v-model="record.type">
			                    </div>
							</div>
					

							<div class="col-md-6">
								<div class="form-group">
									<label>Categoría General:</label>
									<select2 :options="categories" @input="getSubcategories" 
											 v-model="record.category_id"></select2>
			                    </div>
							</div>
							<div class="col-md-6">
								<div class="form-group is-required">
									<label>Categoría General:</label>
									<input type="text" placeholder="Nueva Categoría General" data-toggle="tooltip" 
										   title="Indique la nueva Categoría General (requerido)" 
										   class="form-control input-sm" v-model="record.category">
			                    </div>
							</div>
				

							<div class="col-md-6">
								<div class="form-group">
									<label>Subcategoría:</label>
									<select2 :options="subcategories"
											 v-model="record.subcategory_id"></select2>
			                    </div>
							</div>
							<div class="col-md-6">
								<div class="form-group is-required">
									<label>Subcategoría:</label>
									<input type="text" placeholder="Nueva SubCategoría" data-toggle="tooltip" 
										   title="Indique la nueva Subcategoría(requerido)" 
										   class="form-control input-sm" v-model="record.subcategory">
			                    </div>
							</div>
														

							<div class="col-md-12">
								<div class="form-group is-required">
									<label>Categoría Especifica:</label>
									<input type="text" placeholder="Nueva Categoría Específica" data-toggle="tooltip" 
										   title="Indique la nueva Categoría Específica (requerido)" 
										   class="form-control input-sm" v-model="record.specific_category">
			                    </div>
							</div>
						</div>
	                </div>
	                
	                <div class="modal-body modal-table">
	                    <table class="table table-hover table-striped dt-responsive nowrap datatable">
							<thead>
								<tr class="text-center">
									<th>Código</th>
									<th>Tipo de Bienes</th>
									<th>Categoría General</th>
									<th>Subcategoría</th>
									<th>Categoría Específica</th>
									<th>Acción</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="(rec, index) in records">
									<td>{{ rec.id }}</td>
									<td>{{ rec.type }}</td>
									<td>{{ rec.category }}</td>
									<td>{{ rec.subcategory }}</td>
									<td>{{ rec.specific_category }}</td>
									<td class="text-center" width="10%">
										<button @click="initUpdate(index, $event)" 
												class="btn btn-warning btn-xs btn-icon btn-round" 
												title="Modificar registro" data-toggle="tooltip" type="button">
											<i class="fa fa-edit"></i>
										</button>
										<button @click="deleteRecord(index, 'asset/clasifications')" 
												class="btn btn-danger btn-xs btn-icon btn-round" title="Eliminar registro" data-toggle="tooltip" type="button">
											<i class="fa fa-trash-o"></i>
										</button>
									</td>
								</tr>
							</tbody>
						</table>
	                </div>

	                <div class="modal-footer">
	                	<button type="button" 
	                			class="btn btn-warning btn-icon btn-round btn-modal-close" 
	                			data-dismiss="modal"
	                			title="Cancelar y regresar">
	                			<i class="fa fa-ban"></i>
	                	</button>

	                	<button type="button" @click="createRecord('asset/clasifications')" 
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
					type_id: '',
					category_id: '',
					subcategory_id: '',
					type: '',
					category: '',
					subcategory: '',
					specific_category: ''
				},
				errors: [],
				records: [],
				types: [],
				categories: [],
				subcategories: []
			}
		},
		mounted() {

		},
		methods: {
			/**
			 * Inicializa los registros base del formulario
			 *
			 * @author Henry Paredes (henryp2804@gmail.com)
			 */
			initRecords() {
				axios.get('/asset/get-types').then(response => {
					this.types = response.data;
				});
			},
			/**
			 * Obtiene las Categorias del Tipo de Bien seleccionado
			 * 
			 * @author Henry Paredes (henryp2804@gmail.com)
			 */
			getCategories() {
				if (this.record.type_id) {
					axios.get('/asset/get-categories/' + this.record.type_id).then(response => {
						this.categories = response.data;
					});
				}
			},
			/**
			 * Obtiene las Subcategorias de la Categoria seleccionada
			 * 
			 * @author Henry Paredes (henryp2804@gmail.com)
			 */
			getSubcategories() {
				if (this.record.category_id) {
					axios.get('/asset/get-subcategories/' + this.record.category_id).then(response => {
						this.subcategories = response.data;
					});
				}
			}
		},
	}
</script>