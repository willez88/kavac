<template>
	<section id="AssetForm">
		<div class="card-body">
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
						<li v-for="error in errors">{{ error }}</li>
					</ul>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4" id="helpInstitution">
					<div class="form-group is-required">
						<label>Institución:</label>
						<select2 :options="institutions"
								data-toggle="tooltip"
								title="Seleccione un registro de la lista"
								v-model="record.institution_id"></select2>
						<input type="hidden" v-model="record.id">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4" id="helpAssetType">
					<div class="form-group is-required">
						<label>Tipo de Bien:</label>
						<select2 :options="asset_types" id="asset_types_select"
								@input="(!assetid)? getAssetCategories():''"
								data-toggle="tooltip"
								title="Seleccione un registro de la lista"
								v-model="record.asset_type_id"></select2>
					</div>
				</div>
				<div class="col-md-4" id="helpAssetCategory">
					<div class="form-group is-required">
						<label>Categoria General:</label>
						<select2 :options="asset_categories" id="asset_categories_select"
								@input="(!assetid)? getAssetSubcategories():''"
								:disabled="(!this.record.asset_type_id != '')"
								data-toggle="tooltip"
								title="Seleccione un registro de la lista"
								v-model="record.asset_category_id"></select2>
					</div>
				</div>
				<div class="col-md-4" id="helpAssetSubCategory">
					<div class="form-group is-required">
						<label>Subcategoria:</label>
						<select2 :options="asset_subcategories" id="asset_subcategories_select"
								@input="(!assetid)? getAssetSpecificCategories():''"
								:disabled="(!this.record.asset_category_id != '')"
								data-toggle="tooltip"
								title="Seleccione un registro de la lista"
								v-model="record.asset_subcategory_id"></select2>
					</div>
				</div>
				<div class="col-md-4" id="helpAssetSpecificCategory">
					<div class="form-group is-required">
						<label>Categoria Específica:</label>
						<select2 :options="asset_specific_categories"
								:disabled="(!this.record.asset_subcategory_id != '')"
								@input="getAssetRequired()"
								data-toggle="tooltip"
								title="Seleccione un registro de la lista"
								v-model="record.asset_specific_category_id"></select2>
					</div>
				</div>
				<div class="col-md-8" id="helpAssetSpecification">
					<div class="form-group">
						<label>Especificaciones</label>
						<!--<textarea  data-toggle="tooltip" title="Indique las especificaciones del bien (opcional)"
                                   class="form-control" v-model="record.specifications" id="details"></textarea>-->
                        <ckeditor :editor="ckeditor.editor" v-model="record.specifications" id="details"
                                  title="Indique las especificaciones del bien (opcional)" data-toggle="tooltip"
                                  :config="ckeditor.editorConfig" tag-name="textarea"></ckeditor>
					</div>
				</div>
			</div>
			<div class="row">
				<hr>
				<div class="col-md-3" id="helpAssetAcquisitionType">
					<div class="form-group is-required">
						<label>Forma de Adquisición</label>
						<select2 :options="asset_acquisition_types"
								v-model="record.asset_acquisition_type_id"></select2>
					</div>
				</div>
				<div class="col-md-3" id="helpAssetAcquisitionYear">
					<div class="form-group is-required">
						<label>Fecha de Adquisición</label>
						<input type="date" placeholder="Fecha de Adquisición" data-toggle="tooltip"
							   title="Indique la fecha de adquisición"
							   class="form-control input-sm" v-model="record.acquisition_date">
					</div>
				</div>

				<div class="col-md-3" v-if="record.asset_type_id == 1">
					<div class="form-group is-required">
						<label>Proveedor</label>
						<select2 :options="proveedores"
								v-model="record.proveedor_id"></select2>
					</div>
				</div>

				<div class="col-md-3" id="helpAssetCondition">
					<div class="form-group is-required">
						<label>Condición Física</label>
						<select2 :options="asset_conditions"
								 data-toggle="tooltip"
								 title="Seleccione un registro de la lista"
								 v-model="record.asset_condition_id"></select2>
					</div>
				</div>

				<div class="col-md-3" id="helpAssetStatus">
					<div class="form-group is-required">
						<label>Estatus de Uso</label>
						<select2 :options="asset_status"
								 data-toggle="tooltip"
								 title="Seleccione un registro de la lista"
								 v-model="record.asset_status_id"></select2>
					</div>
				</div>

				<div class="col-md-3" id="helpAssetUseFunction"
					v-if="required.use_function == true">
					<div class="form-group is-required">
						<label>Función de Uso</label>
						<select2 :options="asset_use_functions"
								 data-toggle="tooltip"
								 title="Seleccione un registro de la lista"
								 v-model="record.asset_use_function_id"></select2>
					</div>
				</div>

				<div class="col-md-3" id="helpAssetSerial"
					v-if="required.serial == true">
					<div class="form-group is-required">
						<label>Serial</label>
						<input type="text" placeholder="Serial de Fabricación" data-toggle="tooltip"
							   title="Indique el serial de fabricación"
							   class="form-control input-sm" v-model="record.serial">
					</div>
				</div>
				<div class="col-md-3" id="helpAssetMarca"
					v-if="required.marca == true">
					<div class="form-group is-required">
						<label>Marca</label>
						<input type="text" placeholder="Marca" data-toggle="tooltip"
							   title="Indique la marca del bien"
							   class="form-control input-sm" v-model="record.marca">
					</div>
				</div>
				<div class="col-md-3" id="helpAssetModel"
					v-if="required.model == true">
					<div class="form-group is-required">
						<label>Modelo</label>
						<input type="text" placeholder="Modelo" data-toggle="tooltip"
							   title="Indique el modelo del bien"
							   class="form-control input-sm" v-model="record.model">
					</div>
				</div>
				<div class="col-md-3" id="helpAssetValue">
					<div class="form-group is-required">
						<label>Valor</label>
						<input type="number" min="0" step=".01"
								placeholder="Precio por unidad" data-toggle="tooltip"
								title="Indique el precio del bien"
								class="form-control input-sm" v-model="record.value">
					</div>
				</div>
				<div class="col-md-3" id="helpAssetCurrency">
					<div class="form-group is-required">
						<label>Moneda</label>
						<select2 :options="currencies"
								 v-model="record.currency_id"></select2>
					</div>
				</div>
				<div class="col-md-3" id="helpAssetQuantity"
					v-if="record.id == ''">
					<div class="form-group is-required">
						<label>Cantidad</label>
						<input type="number" min="0" placeholder="Cantidad" data-toggle="tooltip"
							   title="Indique la cantidad del bien a registrar"
							   class="form-control input-sm" v-model="record.quantity">
					</div>
				</div>
			</div>
			<div v-if="required.address == true">
				<hr>
				<h6 class="card-title text-uppercase">Ubicación</h6>
				<div class="row">
					<div class="col-md-3" id="helpAssetCountry">
						<div class="form-group is-required">
							<label>Pais:</label>
							<select2 :options="countries" id="country_select"
									 @input="getEstates()"
									 v-model="record.country_id"></select2>
						</div>
					</div>
					<div class="col-md-3" id="helpAssetEstate">
						<div class="form-group is-required">
							<label>Estado:</label>
							<select2 :options="estates" id="estate_select"
									@input="getMunicipalities()"
									:disabled="(!this.record.country_id != '')"
									v-model="record.estate_id"></select2>
						</div>
					</div>
					<div class="col-md-3" id="helpAssetMunicipality">
						<div class="form-group is-required">
							<label>Municipio:</label>
							<select2 :options="municipalities" id="municipality_select"
									@input="getParishes()"
									:disabled="(!this.record.estate_id != '')"
									v-model="record.municipality_id"></select2>
						</div>
					</div>
					<div class="col-md-3" id="helpAssetParish">
						<div class="form-group is-required">
							<label>Parroquia:</label>
							<select2 :options="parishes" id="parish_select"
									 :disabled="(!this.record.municipality_id != '')"
									 v-model="record.parish_id"></select2>
						</div>
					</div>
					<div class="col-md-6" id="helpAssetAddress">
						<div class="form-group is-required">
							<label>Dirección</label>
							<textarea  data-toggle="tooltip" title="Indique dirección física del bien"
                                       class="form-control" v-model="record.address" id="direction">
						   </textarea>
						</div>
					</div>

				</div>
			</div>
		</div>

		<div class="card-footer text-right">
			<div class="row">
				<div class="col-md-3 offset-md-9" id="helpParamButtons">
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

		        	<button type="button"  @click="createRecord('asset/registers')"
		        			class="btn btn-success btn-icon btn-round btn-modal-save"
		        			title="Guardar registro">
		        		<i class="fa fa-save"></i>
		            </button>
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
					asset_specific_category_id: '',

					asset_acquisition_type_id: '',
					acquisition_date: '',
					institution_id: '',
					proveedor_id: '',
					asset_condition_id: '',
					asset_status_id: '',
					asset_use_function_id: '',
					serial: '',
					marca: '',
					model: '',
					value: '',
					quantity: '',

					country_id: '',
					estate_id: '',
					municipality_id: '',
					parish_id: '',
					address: '',

					specifications: '',
					currency_id: '',

				},
				required: {},

				records: [],
				errors: [],

				institutions: [],
				asset_types: [],
				asset_categories: [],
				asset_subcategories: [],
				asset_specific_categories: [],

				asset_acquisition_types: [],
				proveedores: [],
				asset_conditions: [],
				asset_status: [],
				asset_use_functions: [],

				countries: [],
				estates: [],
				municipalities: [],
				parishes: [],
				currencies: [],
			}
		},
		props: {
			assetid: Number,
		},
		methods: {
			reset() {
				this.record = {
					id: '',
					asset_type_id: '',
					asset_category_id: '',
					asset_subcategory_id: '',
					asset_specific_category_id: '',

					asset_acquisition_type_id: '',
					acquisition_date: '',
					institution_id: '',
					proveedor_id: '',
					asset_condition_id: '',
					asset_status_id: '',
					asset_use_function_id: '',
					serial: '',
					marca: '',
					model: '',
					value: '',
					quantity: '',

					country_id: '',
					estate_id: '',
					municipality_id: '',
					parish_id: '',
					address: '',

					specifications: '',
					currency_id: '',

				};

			},
			/**
			 * Obtiene los datos de las formas de adquisición de los bienes institucionales registrados
			 *
			 * @author Henry Paredes <hparedes@cenditel.gob.ve>
			 */
			getAssetAcquisitionTypes() {
				const vm = this;
				vm.asset_acquisition_types = [];
				axios.get('/asset/get-acquisition-types').then(response => {
					vm.asset_acquisition_types = response.data;
				});
			},
			/**
			 * Obtiene los datos de la condición física de los bienes institucionales
			 *
			 * @author Henry Paredes <hparedes@cenditel.gob.ve>
			 */
			getAssetConditions() {
				const vm = this;
				vm.asset_conditions = [];
				axios.get('/asset/get-conditions').then(response => {
					vm.asset_conditions = response.data;
				});
			},
			/**
			 * Obtiene los datos de los estatus de uso de los bienes institucionales
			 *
			 * @author Henry Paredes <hparedes@cenditel.gob.ve>
			 */
			getAssetStatus() {
				const vm = this;
				vm.asset_status = [];
				axios.get('/asset/get-status').then(response => {
					vm.asset_status = response.data;
				});
			},
			/**
			 * Obtiene los datos de las funciones de uso de los bienes institucionales
			 *
			 * @author Henry Paredes <hparedes@cenditel.gob.ve>
			 */
			getAssetUseFunctions() {
				const vm = this;
				vm.asset_use_functions = [];
				axios.get('/asset/get-use-functions').then(response => {
					vm.asset_use_functions = response.data;
				});
			},
			/**
			 * Metodo que carga la información en el formulario de edición
			 *
			 * @param [Integer] $id Identificador único del registro a editar
			 * @author Henry Paredes <hparedes@cenditel.gob.ve>
			 */
			loadForm(id){
				const vm = this;
	            axios.get('/asset/registers/info' + '/' + id).then(response => {
	                if(typeof(response.data.records != "undefined")){
	                    vm.record = response.data.records;
	                }
	            });
	            vm.getAssetTypes();
	            setTimeout(function() {
	            	/** Se definen los eventos */
		            $('#asset_types_select').on('change', function(){
		            	vm.getAssetCategories();
		            });
		            $('#asset_categories_select').on('change', function(){
		            	vm.getAssetSubcategories();
		            });
		            $('#asset_subcategories_select').on('change', function(){
		            	vm.getAssetSpecificCategories();
		            });
		            /** Se cargan los selects dependientes */
		            vm.record.asset_type_id = vm.record.asset_type.id;
					setTimeout(function () {
						vm.record.asset_category_id = vm.record.asset_category.id;
						setTimeout(function () {
							vm.record.asset_subcategory_id = vm.record.asset_subcategory.id;
							setTimeout(function () {
								vm.record.asset_specific_category_id = vm.record.asset_specific_category.id;
								}, 1000);
						}, 1000);
					}, 1000);
				}, 1000);
			},

			/**
			 * Reescribe el método getEstates para cambiar su comportamiento por defecto
			 * Obtiene los Estados del Pais seleccionado
			 *
			 */
			getEstates() {
				const vm = this;
				vm.estates = [];

				if (vm.record.country_id) {
					axios.get('/get-estates/' + this.record.country_id).then(response => {
						vm.estates = response.data;
					});
				}
				else if ((vm.assetid)&&(vm.record.country_id == '')) {
					axios.get('/get-estates').then(response => {
						vm.estates = response.data;
					});
				}
			},

			/**
			 * * Reescribe el método getMunicipalities para cambiar su comportamiento por defecto
			 * Obtiene los Municipios del Estado seleccionado
			 *
			 */
			getMunicipalities() {
				const vm = this;
				vm.municipalities = [];

				if (vm.record.estate_id) {
					axios.get('/get-municipalities/' + this.record.estate_id).then(response => {
						vm.municipalities = response.data;
					});
				}
				else if ((vm.assetid)&&(vm.record.country_id == '')) {
					axios.get('/get-municipalities').then(response => {
						vm.municipalities = response.data;
					});
				}
			},

			/**
			 * Reescribe el método getParishes para cambiar su comportamiento por defecto
			 * Obtiene las parroquias del municipio seleccionado
			 *
			 */
			getParishes() {
				const vm = this;
				vm.parishes = [];

				if (this.record.municipality_id) {
					axios.get('/get-parishes/' + this.record.municipality_id).then(response => {
						vm.parishes = response.data;
					});
				}
				else if ((vm.assetid)&&(vm.record.country_id == '')) {
					axios.get('/get-parishes/' + this.record.municipality_id).then(response => {
						vm.parishes = response.data;
					});
				}
			},
			getAssetRequired() {
				const vm = this;
				vm.required = {};

				if (vm.record.asset_specific_category_id) {
					axios.get('/asset/get-required/' + this.record.asset_specific_category_id).then(response => {
						vm.required = response.data.record;
					});
				}
			},
		},
		created() {
			this.getInstitutions();
			this.getAssetAcquisitionTypes();
			this.getAssetConditions();
			this.getAssetStatus();
			this.getAssetUseFunctions();
			this.getCountries();
			this.getCurrencies();
		},
		mounted() {
			if(this.assetid){
				this.loadForm(this.assetid);
			}
			else{
                this.getAssetTypes();
            }

            /*$.each(['details', 'direction'], function(index, element_id) {
                CkEditor.create(document.querySelector(`#${element_id}`), {
                    toolbar: [
                        'heading', '|',
                        'bold', 'italic', 'blockQuote', 'link', 'numberedList', 'bulletedList', '|',
                        'insertTable'
                    ],
                    language: window.currentLocale,
                }).then(editor => {
                    window.editor = editor;
                }).catch(error => {
                    console.warn(error);
                });
            });*/
		},
	};
</script>
