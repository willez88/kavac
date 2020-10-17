    <template>
    <section id="SaleWarehouseReceptionForm">
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

    			<div class="col-md-4" id="saleHelpInstitution">
    				<div class="form-group is-required">
    					<label>Nombre de la Institución:</label>
                        <select2 :options="institutions" @input="getSaleWarehouse"
    					v-model="record.institution_id"></select2>
    					<input type="hidden" v-model="record.id">
                    </div>
    			</div>

    			<div class="col-md-4" id="saleHelpWarehouse">
    				<div class="form-group is-required">
    					<label>Nombre del Almacén:</label>
                        <select2 :options="sale_warehouse" @input="getSaleSettingProduct"
                        v-model="record.sale_warehouse_id"></select2>
                    </div>
    			</div>
    		</div>
    		<hr>
    		
    		<div class="row" id="saleHelpSectionProducts">
    			<div class="col-md-12">
    				<b>Ingrese los Productos a la solicitud</b>
    			</div>
    			<div class="col-md-3" id="saleHelpProductName">
    				<div class="form-group is-required">
    					<label>Nombre del Producto:</label>
                        <select2 :options="sale_setting_products" v-model="sale_warehouse_inventory_product.sale_setting_product_id"></select2>
                    </div>
    			</div>
    			<div class="col-md-3" id="saleHelpProductQuantity">
    				<div class="form-group is-required">
    					<label>Cantidad:</label>
    					<input type="number" min="1" placeholder="Cantidad del Producto" data-toggle="tooltip" 								   
    						   class="form-control input-sm"
    						   v-model="sale_warehouse_inventory_product.quantity">
                    </div>
    			</div>
    			<div class="col-md-3" id="saleHelpProductValue">
    				<div class="form-group is-required">
    					<label>Valor:</label>
    					<input type="number" min="0" placeholder="Valor por unidad del producto" data-toggle="tooltip" step=".01"
    						   class="form-control input-sm"
    						   v-model="sale_warehouse_inventory_product.unit_value">
                    </div>
    			</div>
    			<div class="col-md-3" id="SaleHelpProductCurrency">
    				<div class="form-group is-required">
    					<label>Moneda</label>
    					<select2 :options="currencies"
    							 v-model="sale_warehouse_inventory_product.currency_id"></select2>
    				</div>
    			</div>
                <div class="col-md-3" id="SaleHelpProductMeasurementUnit">
                    <div class="form-group is-required">
                        <label>Unidad de medida</label>
                        <select2 :options="measurement_units"
                                 v-model="sale_warehouse_inventory_product.measurement_unit_id"></select2>
                    </div>
                </div>
    		</div>
    		<div class="row" v-show="sale_warehouse_inventory_product.length > 0">
    			<hr>
    			<div class="col-md-12">
    				<b>Características del Producto</b>
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
    		<v-client-table id="saleHelpTable"
    			:columns="columns" :data="records" :options="table_options">
    			<div slot="name" slot-scope="props" class="text-center">
    				<span>
                    {{ (props.row.sale_setting_product)?props.row.sale_setting_product.name:'N/A' }}
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
    		<div class="row">
    			<div class="col-md-3 offset-md-9" id="saleHelpParamButtons">
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

    	        	<button type="button"  @click="createReception('sale/receptions')"
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
    				institution_id: '',
                    sale_warehouse_id: '',
    				sale_warehouse_inventory_products: [],

    			},
    			sale_warehouse_inventory_product: {
    				id: '',
    				quantity: '',
    				unit_value:'',
    				currency_id: '',
                    measurement_unit_id: '',
                    sale_setting_product_id: '',
    			},
    			
    			columns: ['name', 'quantity', 'id'],
    			records: [],
    			errors: [],
    			
    			setting: {
    				id: '',
    			},
    			
    			institutions: [],
                sale_warehouse: [],
    			sale_setting_products: [],
    			currencies: [],	
                measurement_units: [],

    			/** Revisar */
    			editIndex: null,
    		}
    	},
    	props: {
    	receptionid: Number, 
    	},
    	methods: {
    		reset() {
    			this.sale_warehouse_inventory_product = {
    				id: '',
    				quantity: '',

    				unit_value:'',
    				currency_id: '',
    				currency_name: '',
                    measurement_unit_id:'',
                    measurement_unit_name:'',

                    sale_setting_product_id: '',
                    sale_setting_product_name: '',
    			},
    			this.editIndex = null;
    		},

            getSaleWarehouse() {
    			const vm = this;
                vm.sale_warehouse = [];

    			if (vm.record.institution_id != '') {
    				axios.get('/sale/get-salewarehousemethod/' + vm.record.institution_id).then(response => {
                        vm.sale_warehouse = response.data;
    				});
    			}
    		},

    		getSaleSettingProduct() {
    			const vm = this;
    			vm.sale_setting_products = [];

                if (vm.record.sale_warehouse_id != '') {
    				axios.get('/sale/get-setting-product/').then(response => {
    					vm.sale_setting_products = response.data;
    				});
    			}
    		},

            getMeasurementUnits() {
                const vm = this;
                vm.measurement_units = [];

                axios.get('/sale/get-measurement-units').then(response => {
                    vm.measurement_units = response.data;
                });
            },

    		addProduct(event) {
    			const vm = this;

    			var att = [];
    			var currency_name = '';
                var measurement_unit_name = '';
                var sale_setting_product_name = '';
    			event.preventDefault();

                if (vm.sale_warehouse_inventory_product.sale_setting_product_id != '') {
    				$.each(vm.sale_setting_products, function(index, campo) {
                        if (campo.id == vm.sale_warehouse_inventory_product.sale_setting_product_id)
                            sale_setting_product_name = campo.text;
    		        });
    			}
                if (vm.sale_warehouse_inventory_product.currency_id != '') {
    		        $.each(vm.currencies, function(index, campo) {
    		            if (campo.id == vm.sale_warehouse_inventory_product.currency_id)
    		                currency_name = campo.text;
    		        });
    		    }
                if (vm.sale_warehouse_inventory_product.measurement_unit_id != '') {
                    $.each(vm.measurement_units, function(index, campo) {
                        if (campo.id == vm.sale_warehouse_inventory_product.measurement_unit_id)
                            measurement_unit_name = campo.text;
                    });
                }
                vm.sale_warehouse_inventory_product.sale_setting_product = {
                    name: sale_setting_product_name,
    		    }
    		    vm.sale_warehouse_inventory_product.currency = {
    		    	name: currency_name,
    		    }
                vm.sale_warehouse_inventory_product.measurement_unit = {
                    name: measurement_unit_name,
                }
                

    			if (this.editIndex === null) {					
    				vm.records.push(vm.sale_warehouse_inventory_product);
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
    			this.sale_warehouse_inventory_product = this.records[index - 1];

    			event.preventDefault();
    		},

    		removeProduct(index, event) {
    			this.records.splice(index-1, 1);
    		},

    		createReception(url) {
    			const vm = this;
    			vm.record.sale_warehouse_inventory_products = vm.records;
    			vm.createRecord('sale/receptions');
    		},
    		loadReception(id) {
    			const vm = this;
                
                axios.get('/sale/receptions/info/' + id).then(response => {
                    vm.record = response.data.records;
                    vm.record.institution_id = vm.record.sale_warehouse_institution_warehouse_end.institution_id;
                    vm.record.sale_warehouse_id = vm.record.sale_warehouse_institution_warehouse_end.sale_warehouse_id;

                    $.each(vm.record.sale_warehouse_inventory_products_movements, function(index, campo) {
                    	var atts = [];
                    	$.each(campo.sale_warehouse_inventory_product.sale_warehouse_product_values, function(index, field) {
                            var name = field.sale_setting_product.name;
                    		var value = field.value;
                    		atts.push({name:name, value:value});
                    	});
                        var sale_warehouse_inventory_product = {
    						id: '',
    						quantity: campo.quantity,
    						unit_value: campo.new_value,
    						currency_id: 
                            campo.sale_warehouse_inventory_product.currency_id,
    						currency: {
    							name: campo.sale_warehouse_inventory_product.currency.name,
    						},
                            measurement_unit_id: campo.sale_warehouse_inventory_product.measurement_unit_id,
                            measurement_unit: {
                                name: campo.sale_warehouse_inventory_product.measurement_unit.name,
                            }, 
                            sale_setting_product_id: campo.sale_warehouse_inventory_product.sale_setting_product_id,
                            sale_setting_product: {
                                name:
                                campo.sale_warehouse_inventory_product.sale_setting_product.name,
    						},
    					};
    					vm.records.push(sale_warehouse_inventory_product);
                    });
                });
            },
    	},
    	created() {
    		this.table_options.headings = {
    			'name': 'Producto',
    			'quantity': 'Cantidad',
    			'id': 'Acción'
    		};
    		this.table_options.sortable = ['name', 'quantity'];
    		this.table_options.filterable = ['name', 'quantity'];

    		this.getInstitutions();
            this.getSaleWarehouse();
    		this.getCurrencies();
            this.getMeasurementUnits();

    		if (this.receptionid) {
    			this.loadReception(this.receptionid);
    		}

    		


    	},
    };
    </script>
