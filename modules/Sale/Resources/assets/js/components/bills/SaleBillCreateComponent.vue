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
                    <b>Datos del cliente</b>
                </div>
                <div class="col-md-3" id="saleHelpClientsRif">
                    <div class="form-group is-required">
                        <label>Cédula o RIF:</label>
                        <select2 :options="sale_clients_rif"
                                 v-model="record.sale_client_id"></select2>
                    </div>
                </div>
                <div class="col-md-3">
                    <div id="saleHelpClientsName">
                        <div class="form-group is-required" v-show="record.sale_client_id != 0">
                            <label>Nombre o razón social:</label>
                            <select2 :options="sale_clients_name" :disabled="true"
                                     v-model="record.sale_client_id"></select2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div id="saleHelpClientsAddress">
                        <div class="form-group is-required" v-show="record.sale_client_id != 0">
                            <label>Dirección:</label>
                            <select2 :options="sale_clients_address" :disabled="true"
                                    v-model="record.sale_client_id"></select2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div id="saleHelpClientsFiscalAddress" v-show="record.sale_client_id != 0">
                        <div class="form-group is-required">
                            <label>Dirección Fiscal:</label>
                            <select2 :options="sale_clients_fiscal_address" :disabled="true"
                                    v-model="record.sale_client_id"></select2>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            
            <div class="row" id="saleHelpSectionProducts">
                <div class="col-md-12">
                    <b>Selección de productos o servicios</b>
                </div>
                <div class="col-md-3" id="saleHelpProductName">
                    <div class="form-group is-required">
                        <label>Almacén:</label>
                        <select2 :options="sale_warehouse" v-model="record.sale_warehouse_id"></select2>
                    </div>
                </div>
                <div class="col-md-3" id="SaleHelpProductCurrency">
                    <div class="form-group is-required">
                        <label>Forma de pago:</label>
                        <select2 :options="currencies"
                                v-model="record.currency_id"></select2>
                    </div>
                </div>
                <div class="col-md-3" id="SaleHelpPaymentMethod">
                    <div class="form-group is-required">
                        <label>Forma de cobro:</label>
                        <select2 :options="sale_payment_method"
                                v-model="record.sale_payment_method_id"></select2>
                    </div>
                </div>
                <div class="col-md-3" id="SaleHelpDiscountSwitch">
                    <div class="form-group col-md-3">
                        <label class="control-label">Descuento:</label>
                        <div class="col-12">
                            <div class="bootstrap-switch-mini">
                                <input type="checkbox" class="form-control bootstrap-switch"
                                    name="discount" data-toggle="tooltip" title="Indique si desea aplicar algún descuento"
                                    data-on-label="SI" data-off-label="NO" value="true" data-record="discount">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3" id="SaleHelpDiscount">
                    <div class="form-group is-required" v-if="discount">
                        <label>Descuento:</label>
                        <select2 :options="sale_discount"
                                v-model="record.sale_discount_id"></select2>
                    </div>
                </div>
            </div>
            <div>
                <hr>
                <v-client-table id="saleHelpTable"
                    @row-click="toggleActive" :columns="columns" :data="records" :options="table_options">
                    <div slot="h__check" class="text-center">
                        <label class="form-checkbox">
                            <input type="checkbox" v-model="selectAll" @click="select()" class="cursor-pointer">
                        </label>
                    </div>

                    <div slot="check" slot-scope="props" class="text-center">
                        <label class="form-checkbox">
                            <input type="checkbox" class="cursor-pointer" :value="props.row.id" :id="'checkbox_'+props.row.id" v-model="selected">
                        </label>
                    </div>
                    <div slot="description" slot-scope="props">
                        <span>
                            <b> {{ (props.row.sale_setting_product)?
                                'Nombre: ':'' }} </b>
                            {{ (props.row.sale_setting_product)?
                                props.row.sale_setting_product.name + '.':''
                            }} <br>
                        </span>
                        <span>
                            <b>Valor:</b> {{props.row.unit_value}} {{(props.row.currency)?props.row.currency.acronym:''}}
                        </span>
                    </div>
                    <div slot="inventory" slot-scope="props">
                        <span>
                            <b>Almacén:</b> {{
                                props.row.sale_warehouse_institution_warehouse.sale_warehouse.name
                                }} <br>
                            <b>Existencia:</b> {{ props.row.exist }}<br>
                            <b>Reservados:</b> {{ (props.row.reserved === null)? '0':props.row.reserved }}
                        </span>
                    </div>
                    <div slot="requested" slot-scope="props" >
                        <div>
                            <input type="number" class="form-control table-form input-sm" data-toggle="tooltip" min=0 :max="props.row.exist" :id="'sale_bill_product_'+props.row.id" onfocus="this.select()" @input="selectElement(props.row.id)">
                        </div>
                    </div>
                </v-client-table>
            </div>
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

                    <button type="button"  @click="createBill('sale/bills')"
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
                    sale_warehouse_id: '',
                    sale_client_id: '',
                    sale_payment_method_id: '',
                    currency_id: '',
                    sale_discount_id: '',
                    institution_id: '',
                    sale_setting_products: [],
                },
                
                records: [],
                columns: ['check', 'code', 'description', 'inventory', 'requested'],
                errors: [],
                selected: [],
				selectAll: false,
                discount: false,

                table_options: {
					rowClassCallback(row) {
						var checkbox = document.getElementById('checkbox_' + row.id);
						return ((checkbox)&&(checkbox.checked))? 'selected-row cursor-pointer' : 'cursor-pointer';
					},
					headings: {
						'code': 'Código',
						'description': 'Descripción',
						'inventory': 'Inventario',
						'requested': 'Solicitados',
					},
					sortable: ['code', 'description', 'inventory', 'requested'],
					filterable: ['code', 'description', 'inventory', 'requested']
				},
                
                sale_clients_rif: [],
                sale_clients_name: [],
                sale_clients_address: [],
                sale_clients_fiscal_address: [],
                sale_discount: [],
                sale_warehouse: [],
                currencies: [],
                sale_payment_method: [],

                /** Revisar */
                editIndex: null,
            }
        },
        watch: {
            discount: function() {
                this.discount.id = (this.discount) ? this.record.id : '';
            }
        },
        props: {
            billid: Number, 
        },
        methods: {
            createBill(url){
				const vm = this;
				vm.record.sale_setting_products = [];
				var complete = true;
                if(!vm.selected.length > 0){
                	bootbox.alert("Debe agregar almenos un elemento a la solicitud");
					return false;
				};
                $.each(vm.selected,function(index,campo){
                    var value = document.getElementById("sale_bill_product_"+campo).value;
                    if (value == "") {
						bootbox.alert("Debe ingresar la cantidad solicitada para cada producto seleccionado");
						complete = false;
						return;
					}
                    vm.record.sale_setting_products.push(
                        {id:campo, requested:value});

                });
                if (complete == true)
                	vm.createRecord(url)
			},
            toggleActive({ row }) {
				const vm = this;
				var checkbox = document.getElementById('checkbox_' + row.id);

				if((checkbox)&&(checkbox.checked == false)){
					var index = vm.selected.indexOf(row.id);
					if (index >= 0){
						vm.selected.splice(index,1);
					}
					else
						checkbox.click();
				}
				else if ((checkbox)&&(checkbox.checked == true)) {
					var index = vm.selected.indexOf(row.id);
					if (index >= 0)
						checkbox.click();
					else
						vm.selected.push(row.id);
				}
            },

            reset() {
                this.record = {
                    id: '',
                    sale_setting_products: [],
                },
                this.editIndex = null;
            },
            select() {
				const vm = this;
				vm.selected = [];
				$.each(vm.records, function(index,campo){
					var checkbox = document.getElementById('checkbox_' + campo.id);

					if(!vm.selectAll)
						vm.selected.push(campo.id);
					else if(checkbox && checkbox.checked){
						checkbox.click();
					}
				});
			},
			selectElement(id) {
				var input = document.getElementById('sale_bill_product_' + id);
	            var checkbox = document.getElementById('checkbox_' + id);
	            if ((input.value == '')||(input.value == 0)){
	                if(checkbox.checked){
	                    checkbox.click();
	                }
	            }
	            else if(!checkbox.checked){
	                checkbox.click();
	            }
			},
            getSaleWarehouse() {
                const vm = this;
                vm.sale_warehouse = [];

                axios.get('/sale/get-salewarehousemethod/' + vm.record.institution_id).then(response => {
                    vm.sale_warehouse = response.data;
                });
            },

            getSaleClientsRif() {
                const vm = this;
                vm.sale_clients_rif = [];

                axios.get('/sale/get-sale-clients-rif/').then(response => {
                    vm.sale_clients_rif = response.data;
                });
            },

            getSaleClientsName() {
                const vm = this;
                vm.sale_clients_name = [];

                axios.get('/sale/get-sale-clients-name/').then(response => {
                    vm.sale_clients_name = response.data;
                });
            },

            getSaleClientsAddress() {
                const vm = this;
                vm.sale_clients_address = [];

                axios.get('/sale/get-sale-clients-address/').then(response => {
                    vm.sale_clients_address = response.data;
                });
            },

            getSaleClientsFiscalAddress() {
                const vm = this;
                vm.sale_clients_fiscal_address = [];

                axios.get('/sale/get-sale-clients-fiscal-address/').then(response => {
                    vm.sale_clients_fiscal_address = response.data;
                });
            },

            getSalePaymentMethod() {
                const vm = this;
                vm.sale_payment_method = [];

                axios.get('/sale/get-paymentmethod/').then(response => {
                    vm.sale_payment_method = response.data;
                });
            },

            getSaleDiscount() {
                const vm = this;
                vm.sale_discount = [];

                axios.get('/sale/get-discountmethod/').then(response => {
                    vm.sale_discount = response.data;
                });
            },

            loadInventoryProduct(current) {
                const vm = this;
                vm.loading = true;
                var fields = {};
                for (var index in this.record) {
                    fields[index] = this.record[index];
                }
                fields["current"] = current;
                axios.post("/sale/reports/inventory-products/vue-list", fields).then(response => {
                    if (typeof(response.data.records) != "undefined") {
                        vm.records = response.data.records;
                    }
                    vm.loading = false;
                }).catch(error => {
                    if (typeof(error.response) != "undefined") {
                        console.log("error");
                    }
                    vm.loading = false;
                });
            },
        },
        created() {
            

            this.getSaleClientsRif();
            this.getSaleClientsName();
            this.getSaleClientsAddress();
            this.getSalePaymentMethod();
            this.getSaleClientsFiscalAddress();
            this.getSaleWarehouse();
            this.getSaleDiscount();
            this.loadInventoryProduct('inventory-products');
            this.getCurrencies();
            this.switchHandler('type_search');

            if (this.receptionid) {
                this.loadReception(this.receptionid);
            }
        },
        mounted() {
            let vm = this;
            vm.switchHandler('discount');
            $('input[name=discount].bootstrap-switch').on('switchChange.bootstrapSwitch', function() {
                vm.discount = $(this).is(':checked');
            });
        }
    };
    </script>
