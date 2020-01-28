<template>
	<div class="card">
		<div class="card-header">
			<h6 class="card-title text-uppercase">Nuevo Ingreso al Almacén</h6>
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
				<div class="col-md-12">
					<b>Seleccione el destino de los productos</b>
				</div>

				<div class="col-md-4">
					<div class="form-group is-required">
						<label>Nombre de la Institución:</label>
						<select2 :options="institutions" @input="getWarehouses"
						v-model="record.institution_id"></select2>
						<input type="hidden" v-model="record.id">
                    </div>
				</div>

				<div class="col-md-4">
					<div class="form-group is-required">
						<label>Nombre del Almacén:</label>
						<select2 :options="warehouses" @input="getWarehouseProducts"
						v-model="record.warehouse_id"></select2>
                    </div>
				</div>
			</div>
			<hr>
			
			<div class="row">
				<div class="col-md-12">
					<b>Ingrese los Productos a la solicitud</b>
				</div>
				<div class="col-md-3">
					<div class="form-group is-required">
						<label>Nombre del Producto:</label>
						<select2 :options="warehouse_products" @input="getWarehouseProductAttributes" v-model="warehouse_inventory_product.warehouse_product_id"></select2>
                    </div>
				</div>
				<div class="col-md-3">
					<div class="form-group is-required">
						<label>Cantidad:</label>
						<input type="number" min="1" placeholder="Cantidad del Producto" data-toggle="tooltip" 								   
							   class="form-control input-sm"
							   v-model="warehouse_inventory_product.quantity">
                    </div>
				</div>
				<div class="col-md-3">
					<div class="form-group is-required">
						<label>Valor:</label>
						<input type="number" min="0" placeholder="Valor por unidad del producto" data-toggle="tooltip" step=".01"
							   class="form-control input-sm"
							   v-model="warehouse_inventory_product.unit_value">
                    </div>
				</div>
				<div class="col-md-3">
					<div class="form-group is-required">
						<label>Moneda</label>
						<select2 :options="currencies"
								 v-model="warehouse_inventory_product.currency_id"></select2>
					</div>
				</div>
			</div>
			<div class="row" v-show="warehouse_inventory_product.warehouse_product_attributes.length > 0">
				<hr>
				<div class="col-md-12">
					<b>Características del Producto</b>
				</div>
				<div class="col-md-3" v-for="attribute in warehouse_inventory_product.warehouse_product_attributes">
					<div class="form-group">
						<label>{{attribute.name.charAt(0).toUpperCase() + attribute.name.slice(1) }}:</label>
						<input type="text" placeholder="" data-toggle="tooltip"
						   class="form-control input-sm" :id="attribute.name"
						   v-model="attribute.value">
	                </div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<button type="button" @click="addProduct($event)" class="btn btn-sm btn-primary btn-custom float-right" 
							title="Agregar registro a la lista"
							data-toggle="tooltip">
						<i class="fa fa-plus-circle"></i>
						Agregar
					</button>
				</div>
			</div>
			<hr>
			<v-client-table :columns="columns" :data="records" :options="table_options">
				<div slot="name" slot-scope="props" class="text-center">
					<span>
						{{ (props.row.warehouse_product)?props.row.warehouse_product.name:'N/A' }}
					</span>
				</div>
				<div slot="warehouse_product_attributes" slot-scope="props">
					<span>
						<div v-for="att in props.row.warehouse_product_attributes">
							<b>{{att.name +":"}}</b> {{ att.value}}
						</div>
							<b>Valor:</b> {{props.row.unit_value}} {{(props.row.currency)?props.row.currency.name:''}}
					</span>
				</div>
				<div slot="id" slot-scope="props" class="text-center">
					<div class="d-inline-flex">
						<button @click="editProduct(props.index, $event)" 
                				class="btn btn-warning btn-xs btn-icon btn-action" 
                				title="Modificar registro" data-toggle="tooltip" type="button">
                			<i class="fa fa-edit"></i>
                		</button>
	                	
                		<button @click="removeProduct(props.index, $event)" 
								class="btn btn-danger btn-xs btn-icon btn-action" 
								title="Eliminar registro" data-toggle="tooltip" 
								type="button">
							<i class="fa fa-trash-o"></i>
						</button>
					</div>
				</div>
			</v-client-table>

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

        	<button type="button"  @click="createReception('warehouse/receptions')"
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
					institution_id: '',
					warehouse_id: '',
					warehouse_inventory_products: [],

				},
				warehouse_inventory_product: {
					id: '',
					quantity: '',
					unit_value:'',
					currency_id: '',
					warehouse_product_id: '',
					warehouse_product_attributes: [],
				},
				
				columns: ['name', 'quantity', 'warehouse_product_attributes', 'id'],
				records: [],
				errors: [],
				
				setting: {
					id: '',
				},
				
				institutions: [],
				warehouses: [],
				warehouse_products: [],
				currencies: [],

				/** Revisar */
				editIndex: null,
				warehouse_product_attributes: [],
			}
		},
		props: {
		receptionid: Number, 
		},
		methods: {
			reset() {
				this.warehouse_inventory_product = {
					id: '',
					quantity: '',

					unit_value:'',
					currency_id: '',
					currency_name: '',

					warehouse_product_id: '',
					warehouse_product_name: '',

					warehouse_product_attributes: [],
				},
				this.editIndex = null;
				this.warehouse_product_attributes.map(function (campo, key) {
					var element = document.getElementById(campo.name);
		            if(element)
		                element.value = '';
				});

			},

			getWarehouses() {
				const vm = this;
				vm.warehouses = [];

				if (vm.record.institution_id != '') {
					axios.get('/warehouse/get-warehouses/' + vm.record.institution_id).then(response => {
						vm.warehouses = response.data;
					});
				}
			},

			getWarehouseProducts() {
				const vm = this;
				vm.warehouse_products = [];

				if (vm.record.warehouse_id != '') {
					axios.get('/warehouse/get-warehouse-products/').then(response => {
						vm.warehouse_products = response.data;
					});
				}
			},

			getWarehouseProductAttributes() {
				const vm = this;
				var product_id = vm.warehouse_inventory_product.warehouse_product_id;
				vm.warehouse_product_attributes = [];

				if (product_id != '') {
					axios.get('/warehouse/attributes/product/' + product_id).then(response => {
						if (typeof response.data.records !== "undefined") {
							vm.warehouse_product_attributes = response.data.records;
							if ((vm.editIndex == null) || (vm.record.id == '')) {
								vm.warehouse_inventory_product.warehouse_product_attributes = [];
		                        $.each(vm.warehouse_product_attributes, function(index, attribute) {
		                            var value = attribute.warehouse_product_value;
		                            vm.warehouse_inventory_product.warehouse_product_attributes.push({
		                            	name:attribute.name,
		                            	value:""
		                            });
		                        });
		                    }
						}
					});
				}
			},		

			addProduct(event) {
				const vm = this;

				var att = [];
				var currency_name = '';
				var warehouse_product_name = '';
				
				vm.warehouse_product_attributes.map(function(campo, index) {
					var element = document.getElementById(campo.name);
					var field = { name: campo.name, value: element.value };
					att.push(field);
				});
				event.preventDefault();

				if (vm.warehouse_inventory_product.warehouse_product_id != '') {
					$.each(vm.warehouse_products, function(index, campo) {
			            if (campo.id == vm.warehouse_inventory_product.warehouse_product_id)
			                warehouse_product_name = campo.text;
			        });
				}
			    if (vm.warehouse_inventory_product.currency_id != '') {
			        $.each(vm.currencies, function(index, campo) {
			            if (campo.id == vm.warehouse_inventory_product.currency_id)
			                currency_name = campo.text;
			        });
			    }
			    vm.warehouse_inventory_product.warehouse_product = {
			    	name: warehouse_product_name,
			    }
			    vm.warehouse_inventory_product.currency = {
			    	name: currency_name,
			    }
			    vm.warehouse_inventory_product.warehouse_product_attributes = att;

				if (this.editIndex === null) {					
					vm.records.push(vm.warehouse_inventory_product);
					vm.reset();
				}
				else if (this.editIndex >= 0 ) {				
					vm.records.splice(this.editIndex, 1);
					vm.records.push(vm.warehouse_inventory_product);
					vm.reset();
				}
			},

			editProduct(index, event) {
				this.reset();
				this.editIndex = index-1;
				this.warehouse_inventory_product = this.records[index - 1];

				
				$.each(this.warehouse_inventory_product.warehouse_product_attributes, function(index, campo) {
					var element = document.getElementById(campo.name);
					if(element)
						element.value = campo.value;
				});
				event.preventDefault();
			},

			removeProduct(index, event) {
				this.records.splice(index-1, 1);
			},

			createReception(url) {
				const vm = this;
				vm.record.warehouse_inventory_products = vm.records;
				vm.createRecord('warehouse/receptions');
			},
			loadReception(id) {
				const vm = this;
	            
	            axios.get('/warehouse/receptions/info/' + id).then(response => {
	                vm.record = response.data.records;
	                vm.record.institution_id = vm.record.warehouse_institution_warehouse_end.institution_id;
	                vm.record.warehouse_id = vm.record.warehouse_institution_warehouse_end.warehouse_id;

	                $.each(vm.record.warehouse_inventory_product_movements, function(index, campo) {
	                	var atts = [];
	                	$.each(campo.warehouse_inventory_product.warehouse_product_values, function(index, field) {
	                		var name = field.warehouse_product_attribute.name;
	                		var value = field.value;
	                		atts.push({name:name, value:value});
	                	});
                        var warehouse_inventory_product = {
							id: '',
							quantity: campo.quantity,
							unit_value: campo.new_value,
							currency_id: campo.warehouse_inventory_product.currency_id,
							currency: {
								name: campo.warehouse_inventory_product.currency.name,
							},
							warehouse_product_id: campo.warehouse_inventory_product.warehouse_product_id,
							warehouse_product: {
								name: campo.warehouse_inventory_product.warehouse_product.name,
							},
							warehouse_product_attributes: atts,
						};
						vm.records.push(warehouse_inventory_product);
                    });
	            });
	        },
		},
		created() {
			this.table_options.headings = {
				'name': 'Producto',
				'quantity': 'Cantidad',
				'warehouse_product_attributes': 'Detalles',
				'id': 'Acción'
			};
			this.table_options.sortable = ['name', 'quantity'];
			this.table_options.filterable = ['name', 'quantity'];

			this.getInstitutions();
			this.getWarehouses();
			this.getCurrencies();

			if (this.receptionid) {
				this.loadReception(this.receptionid);
			}

			


		},
	};
</script>
