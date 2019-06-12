<template>
	<div class="card">
		<div class="card-header">
			<h6 class="card-title text-uppercase">Registro Manual de Bienes Institucionales</h6>
			<div class="card-btns">
				<a href="#" class="btn btn-sm btn-primary btn-custom" @click="redirect_back(route_list)" 
				   title="Ir atrás" data-toggle="tooltip">
					<i class="fa fa-reply"></i>
				</a>
				<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar" 
				   data-toggle="tooltip">
					<i class="now-ui-icons arrows-1_minimal-up"></i>
				</a>
			</div>
		</div>
		<div class="card-body">
			<div class="alert alert-danger" v-if="errors.length > 0">
				<ul>
					<li v-for="error in errors">{{ error }}</li>
				</ul>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="form-group is-required">
						<label>Tipo de Bien:</label>
						<select2 :options="types" @input="getCategories()"
								v-model="record.type_id"></select2>
						<input type="hidden" v-model="record.id">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group is-required">
						<label>Categoria General:</label>
						<select2 :options="categories" @input="getSubcategories()"
								v-model="record.category_id"></select2>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group is-required">
						<label>Subcategoria:</label>
						<select2 :options="subcategories" @input="getSpecificCategories()"
								v-model="record.subcategory_id"></select2>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group is-required">
						<label>Categoria Específica:</label>
						<select2 :options="specific_categories"
								v-model="record.specific_category_id"></select2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<div class="form-group is-required">
						<label>Forma de Adquisición</label>
						<select2 :options="purchases"
								v-model="record.purchase_id"></select2>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group is-required">
						<label>Año de Adquisición</label>
						<input type="number" min="0" placeholder="Año de Adquisición" data-toggle="tooltip" 
							   title="Indique el año de adquisición" 
							   class="form-control input-sm" v-model="record.purchase_year">
					</div>
				</div>

				<div class="col-md-3">
					<div class="form-group is-required">
						<label>Ubicación</label>
						<select2 :options="departments"
								v-model="record.institution_id"></select2>
					</div>
				</div>

				<div class="col-md-3">
					<div class="form-group is-required">
						<label>Poveedor</label>
						<select2 :options="proveedores"
								v-model="record.proveedor_id"></select2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<div class="form-group is-required">
						<label>Condición Física</label>
						<select2 :options="conditions"
								v-model="record.condition_id"></select2>
					</div>
				</div>

				<div class="col-md-3">
					<div class="form-group is-required">
						<label>Estatus de Uso</label>
						<select2 :options="status"
								v-model="record.status_id"></select2>
					</div>
				</div>

				<div class="col-md-3" v-if="record.type_id == 2">
					<div class="form-group is-required">
						<label>Función de Uso</label>
						<select2 :options="uses"
								v-model="record.use_id"></select2>
					</div>
				</div>
				
				<div class="col-md-3">
					<div class="form-group is-required">
						<label>Serial</label>
						<input type="text" placeholder="Serial de Fabricación" data-toggle="tooltip" 
							   title="Indique el serial de fabricación" 
							   class="form-control input-sm" v-model="record.serial">
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group is-required">
						<label>Marca</label>
						<input type="text" placeholder="Marca" data-toggle="tooltip" 
							   title="Indique la marca del bien" 
							   class="form-control input-sm" v-model="record.marca">
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group is-required">
						<label>Modelo</label>
						<input type="text" placeholder="Modelo" data-toggle="tooltip" 
							   title="Indique el modelo del bien" 
							   class="form-control input-sm" v-model="record.model">
					</div>
				</div>

				<div class="col-md-3">
					<div class="form-group is-required">
						<label>Valor</label>
						<input type="number" min="0" placeholder="Precio por unidad" data-toggle="tooltip" 
							   title="Indique el precio del bien" 
							   class="form-control input-sm" v-model="record.value">
					</div>
				</div>

				<div class="col-md-3" v-if="((record.type_id == 2)&&(record.id == ''))">
					<div class="form-group is-required">
						<label>Cantidad</label>
						<input type="number" min="0" placeholder="Cantidad" data-toggle="tooltip" 
							   title="Indique la cantidad del bien a registrar" 
							   class="form-control input-sm" v-model="record.quantity">
					</div>
				</div>
			</div>
		</div>

		<div class="card-footer text-right">
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
					specific_category_id: '',

					purchase_id: '',
					purchase_year: '',
					institution_id: '',
					proveedor_id: '',
					condition_id: '',
					status_id: '',
					use_id: '',
					serial: '',
					marca: '',
					model: '',
					value: '',
					quantity: ''
				},
				
				records: [],
				errors: [],

				types: [],
				categories: [],
				subcategories: [],
				specific_categories: [],

				purchases: [],
				departments: [],
				proveedores: [],
				conditions: [],
				status: [],
				uses: [],
			}
		},
		props: {
		assetid: Number, 
		},
		methods: {
			reset() {
				this.record = {
					id: '',
					type_id: '',
					category_id: '',
					subcategory_id: '',
					specific_category_id: '',

					purchase_id: '',
					purchase_year: '',
					institution_id: '',
					proveedor_id: '',
					condition_id: '',
					status_id: '',
					use_id: '',
					serial: '',
					marca: '',
					model: '',
					value: '',
					quantity: ''
				};

			},
			createRecord(url) {
				const vm = this
				vm.errors = [];
				
				if (vm.record.id) {
					vm.updateRecord(url);
				}
				else{
					var fields = {};

					for (var index in this.record) {
						fields[index] = this.record[index];
					}
					axios.post('/' + url, fields).then(response => {
						if (response.data.result) {
	                        vm.showMessage('store');
	                        setTimeout(function() {
	                            window.location.href = '/asset/registers';
	                        }, 2000);
	                    }
					}).catch(error => {
						this.errors = [];

						if (typeof(error.response) !="undefined") {
							for (var index in error.response.data.errors) {
								if (error.response.data.errors[index]) {
									this.errors.push(error.response.data.errors[index][0]);
								}
							}
						}
					});
				}
			},
			updateRecord(url) {
				const vm = this;
				var fields = {};

				for (var index in vm.record) {
					fields[index] = vm.record[index];
				}
				axios.patch('/' + url + '/' + vm.record.id, fields).then(response => {
					if (response.data.result) {
                        vm.showMessage('update');
                        setTimeout(function() {
                            window.location.href = '/asset/registers';
                        }, 2000);
                    }
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

			/**
			 * Obtiene los datos de las formas de adquisición de los bienes institucionales registrados
			 *
			 * @author Henry Paredes (henryp2804@gmail.com)
			 */
			getPurchases() {
				const vm = this;
				vm.purchases = [];
				axios.get('/asset/get-purchases').then(response => {
					vm.purchases = response.data;
				});
			},
			/**
			 * Obtiene los datos de la condición física de los bienes institucionales
			 *
			 * @author Henry Paredes (henryp2804@gmail.com)
			 */
			getConditions() {
				const vm = this;
				vm.conditions = [];
				axios.get('/asset/get-conditions').then(response => {
					vm.conditions = response.data;
				});
			},
			/**
			 * Obtiene los datos de los estatus de uso de los bienes institucionales
			 *
			 * @author Henry Paredes (henryp2804@gmail.com)
			 */
			getStatus() {
				const vm = this;
				vm.status = [];
				axios.get('/asset/get-status').then(response => {
					vm.status = response.data;
				});
			},
			/**
			 * Obtiene los datos de los estatus de uso de los bienes institucionales
			 *
			 * @author Henry Paredes (henryp2804@gmail.com)
			 */
			getUses() {
				const vm = this;
				vm.uses = [];
				axios.get('/asset/get-uses').then(response => {
					vm.uses = response.data;
				});
			},
			loadForm(id){
				const vm = this;
	            axios.get('/asset/registers/info' + '/' + id).then(response => {
	                if(typeof(response.data.records != "undefined")){
	                    vm.record = response.data.records;
	                }
	            });
			}
		},
		created() {
			this.getTypes();
			this.getDepartments();
			this.getPurchases();
			this.getConditions();
			this.getStatus();
			this.getUses();
		},
		mounted() {
			if(this.assetid){
				this.loadForm(this.assetid);
			}
		},
	};
</script>
