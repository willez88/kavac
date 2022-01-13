<template>
	<section id="assetClasificationComponent">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary"
		   href="" title="Registros de Clasificador de Bienes"
		   data-toggle="tooltip"
		   @click="addRecord('add_clasification', 'asset/clasifications',$event)">
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
                            <div class="container">
                                <div class="alert-icon">
                                    <i class="now-ui-icons objects_support-17"></i>
                                </div>
                                <strong>Cuidado!</strong> Debe verificar los siguientes errores antes de continuar:
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                                        @click.prevent="errors = []">
                                    <span aria-hidden="true">
                                        <i class="now-ui-icons ui-1_simple-remove"></i>
                                    </span>
                                </button>
                                <ul>
                                    <li v-for="error in errors" :key="error">{{ error }}</li>
                                </ul>
                            </div>
                        </div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Tipo de bien:</label>
									<select2 :options="asset_types" @input="checkType()"
											 v-model="record.asset_type_id"></select2>
									<input type="hidden" v-model="record.id">
			                    </div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Tipo de bienes:</label>
									<input type="text" placeholder="Nuevo Tipo de Bienes" data-toggle="tooltip"
										   id ="type_id"
										   title="Indique el nuevo Tipo de Bienes (requerido)"
										   class="form-control input-sm" v-model="type.name">
			                    </div>
							</div>


							<div class="col-md-4">
								<div class="form-group">
									<label>Categoría general:</label>
									<select2 :options="asset_categories" @input="checkCategory"
											 v-model="record.category_id"></select2>
			                    </div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Código de la categoría:</label>
									<input type="text" placeholder="Código de la Categoría" data-toggle="tooltip"
											id="category_code_id"
										    title="Indique el código de la nueva Categoría (requerido)"
										    class="form-control input-sm" v-model="category.code">
			                    </div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Categoría general:</label>
									<input type="text" placeholder="Nueva Categoría General" data-toggle="tooltip"
											id="category_name_id"
											title="Indique la nueva Categoría General (requerido)"
											class="form-control input-sm" v-model="category.name">
			                    </div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label>Subcategoría:</label>
									<select2 :options="asset_subcategories" @input="checkSubcategory"
											 v-model="record.asset_subcategory_id"></select2>
			                    </div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Código de la subcategoría:</label>
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
									<label>Código de la categoría específica:</label>
									<input type="text" placeholder="Código de la Categoría Específica" data-toggle="tooltip"
										   title="Indique el código de la nueva Categoría Específica (requerido)"
										   class="form-control input-sm" v-model="record.code">
			                    </div>
							</div>
							<div class="col-md-6">
								<div class="form-group is-required">
									<label>Categoría especifica:</label>
									<input type="text" placeholder="Nueva Categoría Específica" data-toggle="tooltip"
										   title="Indique la nueva Categoría Específica (requerido)"
										   class="form-control input-sm" v-model="record.name">
			                    </div>
							</div>
						</div>
	                </div>

	                <div class="modal-body modal-table">

	                	<v-client-table :columns="columns" :data="records" :options="table_options">

	                		<div slot="id" slot-scope="props" class="text-center">
	                			<button @click="initUpdate(props.row.id, $event)"
		                				class="btn btn-warning btn-xs btn-icon btn-action" v-has-tooltip
		                				title="Modificar registro" data-toggle="tooltip" type="button">
		                			<i class="fa fa-edit"></i>
		                		</button>
		                		<button @click="deleteRecord(props.row.id, 'asset/clasifications')"
										class="btn btn-danger btn-xs btn-icon btn-action" v-has-tooltip
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
	                	<button type="button" @click="createClasification('asset/clasifications')"
	                			class="btn btn-primary btn-sm btn-round btn-modal-save">
	                		Guardar
		                </button>
		            </div>
		        </div>
		    </div>
		</div>
	</section>
</template>

<script>
	export default {
		data() {
			return {
				record: {
					id: '',
					asset_type_id: '',
					asset_category_id: '',
					asset_subcategory_id: '',
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
				asset_types: [],
				asset_categories: [],
				asset_subcategories: [],
				columns: [
                    'asset_subcategory.asset_category.asset_type.name','asset_subcategory.asset_category.name',
                    'asset_subcategory.name', 'name', 'code', 'id'
                ],
			}
		},
		created() {
			this.table_options.headings = {
				'asset_subcategory.asset_category.asset_type.name': 'Tipo de Bien',
				'asset_subcategory.asset_category.name': 'Categoria General',
				'asset_subcategory.name': 'Subcategoria',
				'name': 'Categoria Especifica',
				'code': 'Código',
				'id': 'Acción'
			};
			this.table_options.sortable = [
                'asset_subcategory.asset_category.asset_type.name', 'asset_subcategory.asset_category.name',
                'asset_subcategory.name','name', 'code'
            ];
			this.table_options.filterable = [
                'asset_subcategory.asset_category.asset_type.name', 'asset_subcategory.asset_category.name',
                'asset_subcategory.name','name', 'code'
            ];

		},
		mounted() {
			this.getAssetTypes();
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
					asset_type_id: '',
					asset_category_id: '',
					asset_subcategory_id: '',
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
			 * @author Henry Paredes <hparedes@cenditel.gob.ve>
			 */
			getAssetTypes() {
				let vm = this;

				axios.get(`${window.app_url}/asset/get-types`).then(response => {
					$.each(response.data, function() {
			        	if (this.id === 1){
				            vm.asset_types.push({
				            	id: '-1',
				            	text: 'Agregar Nuevo Tipo de Bienes'
				            });

				            vm.asset_types.push({
				            	id: this.id,
				            	text: this.text
				            });
				        }
				        else {
				        	vm.asset_types.push({
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
			 * @author Henry Paredes <hparedes@cenditel.gob.ve>
			 */
			getAssetCategories() {
				let vm = this;
				var first = true;

				if (this.record.asset_type_id > 0 ) {
					axios.get(`${window.app_url}/asset/get-categories/${this.record.asset_type_id}`).then(response => {
						vm.asset_categories = [];
						$.each(response.data, function() {

							if ( first === true ){
								first = false;
								vm.asset_categories.push({
				               		id: this.id,
									text: this.text
				                });
				                vm.asset_categories.push({
					            	id: '-1',
					            	text: 'Agregar Nueva Categoria General de Bienes'
					            });
							}
					        else {
					        	vm.asset_categories.push({
				               		id: this.id,
									text: this.text
				                });
				            }
				        });
					});
				}
				else if (this.record.asset_type_id == -1 ) {
					vm.asset_categories= [{
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
			 * @author Henry Paredes <hparedes@cenditel.gob.ve>
			 */
			getAssetSubcategories() {
				let vm = this;
				var first = true;

				if (this.record.asset_category_id > 0) {
					axios.get(
						`${window.app_url}/asset/get-subcategories/${this.record.asset_category_id}`
					).then(response => {
						vm.asset_subcategories= [];
						$.each(response.data, function() {

							if ( first === true ){
								first = false;
								vm.asset_subcategories.push({
				               		id: this.id,
									text: this.text
				                });
				                vm.asset_subcategories.push({
					            	id: '-1',
					            	text: 'Agregar Nueva Subcategoria de Bienes'
					            });
							}
					        else {
					        	vm.asset_subcategories.push({
				               		id: this.id,
									text: this.text
				                });
				            }
				        });
					});
				}
				else if (this.record.asset_category_id == -1 ) {
					vm.asset_subcategories= [{
						id: '',
						text: 'Seleccione...'
					},{
						id: '-1',
						text: 'Agregar Nueva subcategoria de Bienes'
					}]
				}
			},
			checkType(){
				let index = this.record.asset_type_id;
				$("#type_id").attr('disabled', (index > 0));
				if (index > 0){
					$("#type_id").closest('.form-group').removeClass('is-required');
				}else {
					$("#type_id").closest('.form-group').addClass('is-required');
                }
				this.getAssetCategories();
			},
			checkCategory(){
				let index = this.record.asset_category_id;
				$("#category_name_id").attr('disabled', (index > 0));
				$("#category_code_id").attr('disabled', (index > 0));

				if (index > 0){
					$("#category_name_id").closest('.form-group').removeClass('is-required');
					$("#category_code_id").closest('.form-group').removeClass('is-required');
				}else{
					$("#category_name_id").closest('.form-group').addClass('is-required');
					$("#category_code_id").closest('.form-group').addClass('is-required');
				}
				this.getAssetSubcategories();
			},
			checkSubcategory(){
				let index = this.record.asset_subcategory_id;
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
				url = vm.setUrl(url);
				if (this.record.id) {
					this.updateRecord(url);
				}
				else {
					var fields = {
						id: this.record.id,
						asset_type_id: this.record.asset_type_id,
						asset_category_id: this.record.asset_category_id,
						asset_subcategory_id: this.record.asset_subcategory_id,
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

					axios.post(url, fields).then(response => {
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
			initUpdate(id, event) {
                const vm = this;
				this.errors = [];
				let recordEdit = JSON.parse(JSON.stringify(vm.records.filter((rec) => {
                    return rec.id === id;
                })[0])) || vm.reset();
				this.record = recordEdit;
				event.preventDefault();
			},
			updateRecord(url) {
				const vm = this;
				var fields = {};
				url = vm.setUrl(url);
				for (var index in this.record) {
					fields[index] = this.record[index];
				}
				axios.patch(url + '/' + this.record.id, fields).then(response => {
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
	};
</script>
