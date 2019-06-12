<template>
	<div class="col-md-2 text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary" 
		   href="" title="Registros de Clasificador de Bienes" 
		   data-toggle="tooltip" 
		   @click="addRecord('add_clasification', 'clasifications',$event)">
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
									<select2 :options="types" @input="checkType()" 
											 v-model="record.type_id"></select2>
									<input type="hidden" v-model="record.id">
			                    </div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Tipo de Bienes:</label>
									<input type="text" placeholder="Nuevo Tipo de Bienes" data-toggle="tooltip" 
										   id ="type_id"
										   title="Indique el nuevo Tipo de Bienes (requerido)" 
										   class="form-control input-sm" v-model="type.name">
			                    </div>
							</div>
					

							<div class="col-md-4">
								<div class="form-group">
									<label>Categoría General:</label>
									<select2 :options="categories" @input="checkCategory" 
											 v-model="record.category_id"></select2>
			                    </div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Código de la Categoría:</label>
									<input type="text" placeholder="Código de la Categoría" data-toggle="tooltip"
											id="category_code_id"
										    title="Indique el código de la nueva Categoría (requerido)" 
										    class="form-control input-sm" v-model="category.code">
			                    </div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Categoría General:</label>
									<input type="text" placeholder="Nueva Categoría General" data-toggle="tooltip" 
											id="category_name_id"
											title="Indique la nueva Categoría General (requerido)" 
											class="form-control input-sm" v-model="category.name">
			                    </div>
							</div>				

							<div class="col-md-4">
								<div class="form-group">
									<label>Subcategoría:</label>
									<select2 :options="subcategories" @input="checkSubcategory"
											 v-model="record.subcategory_id"></select2>
			                    </div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Código de la SubCategoría:</label>
									<input type="text" placeholder="Código de la SubCategoría" data-toggle="tooltip"
											id="subcategory_code_id"
										    title="Indique el código de la nueva SubCategoría (requerido)" 
										    class="form-control input-sm" v-model="subcategory.code">
			                    </div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Subcategoría:</label>
									<input type="text" placeholder="Nueva SubCategoría" data-toggle="tooltip" 
											id="subcategory_name_id"
										    title="Indique la nueva Subcategoría(requerido)" 
										    class="form-control input-sm" v-model="subcategory.name">
			                    </div>
							</div>
														

							<div class="col-md-6">
								<div class="form-group is-required">
									<label>Código de la Categoría Específica:</label>
									<input type="text" placeholder="Código de la Categoría Específica" data-toggle="tooltip" 
										   title="Indique el código de la nueva Categoría Específica (requerido)" 
										   class="form-control input-sm" v-model="record.code">
			                    </div>
							</div>
							<div class="col-md-6">
								<div class="form-group is-required">
									<label>Categoría Especifica:</label>
									<input type="text" placeholder="Nueva Categoría Específica" data-toggle="tooltip" 
										   title="Indique la nueva Categoría Específica (requerido)" 
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
		                		<button @click="deleteRecord(props.index, 'clasifications')" 
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
	                	<button type="button" @click="createClasification('asset/clasifications')" 
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
					name: '',
					code: ''
				},
				type:{
					id: '',
					name: ''
				},
				category: {
					id: '',
					code: '',
					name: ''
				},
				subcategory: {
					id: '',
					code: '',
					name: ''
				},

				errors: [],
				records: [],
				types: [],
				categories: [],
				subcategories: [],
				columns: ['subcategory.category.type.name','subcategory.category.name','subcategory.name', 'name', 'code', 'id'],
			}
		},
		created() {
			this.getTypes();
			this.table_options.headings = {
				'subcategory.category.type.name': 'Tipo de Bien',
				'subcategory.category.name': 'Categoria General',
				'subcategory.name': 'Subcategoria',
				'name': 'Categoria Especifica',
				'code': 'Código',
				'id': 'Acción'
			};
			this.table_options.sortable = ['subcategory.category.type.name', 'subcategory.category.name','subcategory.name','name', 'code'];
			this.table_options.filterable = ['subcategory.category.type.name', 'subcategory.category.name','subcategory.name','name', 'code'];

		},
		methods: {
			/**
			 * Método que borra todos los datos del formulario
			 * 
			 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
			 */
			reset() {
				this.errors = [];
				this.record = {
					id: '',
					type_id: '',
					category_id: '',
					subcategory_id: '',
					name: '',
					code: ''
				};
				this.type = {
					id: '',
					name: '',
					code: ''
				};
				this.category = {
					id: '',
					name: '',
					code: ''
				};
				this.subcategory = {
					id: '',
					name: '',
					code: ''
				};
			},
			/**
			 * Inicializa los registros base del formulario
			 *
			 * @author Henry Paredes (henryp2804@gmail.com)
			 */
			getTypes() {
				let vm = this;				

				axios.get('/asset/get-types').then(response => {
					$.each(response.data, function() {
			        	if (this.id === 1){
				            vm.types.push({
				            	id: '-1',
				            	text: 'Agregar Nuevo Tipo de Bienes'
				            });

				            vm.types.push({
				            	id: this.id,
				            	text: this.text
				            });
				        }
				        else {
				        	vm.types.push({
			               		id: this.id,
								text: this.text
			                });
			            }
			        });
				});
			},
			/**
			 * Obtiene las Categorias del Tipo de Bien seleccionado
			 * 
			 * @author Henry Paredes (henryp2804@gmail.com)
			 */
			getCategories() {
				let vm = this;
				var first = true;

				if (this.record.type_id > 0 ) {
					axios.get('/asset/get-categories/' + this.record.type_id).then(response => {
						vm.categories = [];
						$.each(response.data, function() {
							
							if ( first === true ){
								first = false;
								vm.categories.push({
				               		id: this.id,
									text: this.text
				                });
				                vm.categories.push({
					            	id: '-1',
					            	text: 'Agregar Nueva Categoria General de Bienes'
					            });
							}
					        else {
					        	vm.categories.push({
				               		id: this.id,
									text: this.text
				                });
				            }
				        });
					});
				}
				else if (this.record.type_id == -1 ) {
					vm.categories= [{
						id: '',
						text: 'Seleccione...'
					},{
						id: '-1',
						text: 'Agregar Nueva Categoria General de Bienes'
					}]
				}
			},
			/**
			 * Obtiene las Subcategorias de la Categoria seleccionada
			 * 
			 * @author Henry Paredes (henryp2804@gmail.com)
			 */
			getSubcategories() {
				let vm = this;
				var first = true;
				
				if (this.record.category_id > 0) {
					axios.get('/asset/get-subcategories/' + this.record.category_id).then(response => {
						vm.subcategories= [];
						$.each(response.data, function() {
							
							if ( first === true ){
								first = false;
								vm.subcategories.push({
				               		id: this.id,
									text: this.text
				                });
				                vm.subcategories.push({
					            	id: '-1',
					            	text: 'Agregar Nueva Subcategoria de Bienes'
					            });
							}
					        else {
					        	vm.subcategories.push({
				               		id: this.id,
									text: this.text
				                });
				            }
				        });
					});
				}
				else if (this.record.category_id == -1 ) {
					vm.subcategories= [{
						id: '',
						text: 'Seleccione...'
					},{
						id: '-1',
						text: 'Agregar Nueva subcategoria de Bienes'
					}]
				}
			},
			checkType(){
				let index = this.record.type_id;				
				$("#type_id").attr('disabled', (index > 0));
				if (index > 0){
					$("#type_id").closest('.form-group').removeClass('is-required');
				}else
					$("#type_id").closest('.form-group').addClass('is-required');
				this.getCategories();
			},
			checkCategory(){
				let index = this.record.category_id;				
				$("#category_name_id").attr('disabled', (index > 0));
				$("#category_code_id").attr('disabled', (index > 0));

				if (index > 0){
					$("#category_name_id").closest('.form-group').removeClass('is-required');
					$("#category_code_id").closest('.form-group').removeClass('is-required');
				}else{
					$("#category_name_id").closest('.form-group').addClass('is-required');
					$("#category_code_id").closest('.form-group').addClass('is-required');
				}
				this.getSubcategories();
			},
			checkSubcategory(){
				let index = this.record.subcategory_id;
				$("#subcategory_name_id").attr('disabled', (index > 0));
				$("#subcategory_name_id").attr('required', (index > 0));
				$("#subcategory_code_id").attr('disabled', (index > 0));
				$("#subcategory_code_id").attr('required', (index > 0));

				if (index > 0){
					$("#subcategory_name_id").closest('.form-group').removeClass('is-required');
					$("#subcategory_code_id").closest('.form-group').removeClass('is-required');
				}else{
					$("#subcategory_name_id").closest('.form-group').addClass('is-required');
					$("#subcategory_code_id").closest('.form-group').addClass('is-required');
				}
			},
			createClasification(url) {
				const vm = this;
				if (this.record.id) {
					this.updateRecord(url);
				}
				else {
					var fields = {
						id: this.record.id,
						type_id: this.record.type_id,
						category_id: this.record.category_id,
						subcategory_id: this.record.subcategory_id,
						name: this.record.name,
						code: this.record.code,

						type: {
							name: this.type.name,
						},
						category: {
							code: this.category.code,
							name: this.category.name,
						},
						subcategory: {
							code: this.subcategory.code,
							name: this.subcategory.name,
						}
					};
					
					axios.post('/' + url, fields).then(response => {
						vm.reset();
						vm.readRecords(url);
						vm.showMessage('store');
					}).catch(error => {
						vm.errors = [];

						if (typeof(error.response) !="undefined") {
							for (var index in error.response.data.errors) {
								if (error.response.data.errors[index]) {
									vm.errors.push(error.response.data.errors[index][0]);
								}
							}
						}
					});
				}
				
			},
			initUpdate(index, event) {
				this.errors = [];
				var field = this.records[index - 1];
				this.record = {
					id: field.id,
					type_id: field.subcategory.category.asset_type_id,
					category_id: field.subcategory.asset_category_id,
					subcategory_id: field.asset_subcategory_id,
					code: field.code,
					name: field.name,
				};
				event.preventDefault();
			},
			updateRecord(url) {
				const vm = this;
				var fields = {};
				for (var index in this.record) {
					fields[index] = this.record[index];
				}
				axios.patch('/' + url + '/' + this.record.id, fields).then(response => {
					vm.readRecords(url);
					vm.reset();
					vm.showMessage('update');
				}).catch(error => {
					vm.errors = [];

					if (typeof(error.response) !="undefined") {
						for (var index in error.response.data.errors) {
							if (error.response.data.errors[index]) {
								vm.errors.push(error.response.data.errors[index][0]);
							}
						}
					}
				});
		    },
		},
	}
</script>