<template>
    <div>
        <a class="btn btn-info btn-xs btn-icon btn-action" 
           href="#" title="Ver información del registro" data-toggle="tooltip" 
           @click="addRecord('view_sale_bill', route_list , $event)">
            <i class="fa fa-info-circle"></i>
        </a>
        <div class="modal fade text-left" tabindex="-1" role="dialog" id="view_sale_bill">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h6>
                            <i class="icofont icofont-read-book ico-2x"></i> 
                             Información de la Factura Registrada
                        </h6>
                    </div>
                    
                    <div class="modal-body">
                        <ul class="nav nav-tabs custom-tabs justify-content-center" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" id="info_general" href="#general" role="tab">
                                    <i class="ion-android-person"></i> Información General
                                </a>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#products" role="tab" @click="loadProducts()">
                                    <i class="ion-arrow-swap"></i> Equipos Solicitados
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="general" role="tabpanel">
                                <div class="row">        
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong>Fecha de Registro</strong>
                                            <div class="row" style="margin: 1px 0">
                                                <span class="col-md-12" id="date_init">
                                                </span>
                                            </div>
                                            <input type="hidden" id="id">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong>RIF</strong>
                                            <div class="row" style="margin: 1px 0">
                                                <span class="col-md-12" id="sale_client_rif">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong>Nombre del cliente</strong>
                                            <div class="row" style="margin: 1px 0">
                                                <span class="col-md-12" id="sale_client_name">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong>Almacén</strong>
                                            <div class="row" style="margin: 1px 0">
                                                <span class="col-md-12" id="sale_warehouse">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong>Forma de pago</strong>
                                            <div class="row" style="margin: 1px 0">
                                                <span class="col-md-12" id="sale_payment_method">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong>Descuento</strong>
                                            <div class="row" style="margin: 1px 0">
                                                <span class="col-md-12" id="sale_discount">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong>Estado de la Solicitud</strong>
                                            <div class="row" style="margin: 1px 0">
                                                <span class="col-md-12" id="state">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="tab-pane" id="products" role="tabpanel">            
                                <div class="modal-table" v-if="records">
                                    <v-client-table :columns="columns" :data="records" :options="table_options">
                                        <div slot="code" slot-scope="props" class="text-center">
                                            <span>
                                                {{ props.row.sale_warehouse_inventory_product.code }} 
                                            </span>
                                        </div>
                                        <div slot="requested" slot-scope="props">
                                            <span >
                                                <b>Solicitados</b>
                                                {{ props.row.quantity }}
                                            </span>
                                        </div>
                                        <div slot="unit_value" slot-scope="props">
                                            <span>
                                                <b>Valor:</b> {{props.row.sale_warehouse_inventory_product.unit_value}}
                                            </span>
                                        </div>
                                        <div slot="price" slot-scope="props">
                                            <span>
                                                Precio total: {{ price(props.row.quantity, props.row.sale_warehouse_inventory_product.unit_value) }}
                                            </span>
                                        </div>
                                    </v-client-table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        
                        <button type="button" class="btn btn-default btn-sm btn-round btn-modal-close" 
                                data-dismiss="modal">
                            Cerrar
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
                records: [],
                errors: [],
                columns: [
                    'code',
                    'sale_warehouse_inventory_product.sale_setting_product.name',
                    'sale_warehouse_inventory_product.sale_setting_product.description',
                    'requested',
                    'unit_value',
                    'price'
                ],
            }
        },
        created() {
            this.table_options.headings = {
                'code': 'Código',
                'sale_warehouse_inventory_product.sale_setting_product.name': 'Nombre',
                'sale_warehouse_inventory_product.sale_setting_product.description': 'Descripción',
                'unit_value': 'Valor por unidad',
                'requested': 'Solicitados',
                'price': 'Precio total'
            };
            this.table_options.sortable = [
                'code',
                'sale_warehouse_inventory_product.sale_setting_product.name',
                'sale_warehouse_inventory_product.sale_setting_product.description',
                'unit_value',
                'requested',
                'price'
            ];
            this.table_options.filterable = [
                'code',
                'sale_warehouse_inventory_product.sale_setting_product.name',
                'sale_warehouse_inventory_product.sale_setting_product.description',
                'unit_value',
                'requested',
                'price'
            ];

        },
        methods: {            
            price(quantity, prod){
                const vm = this;
                var total = 0;
                if (quantity && prod) {
                    total += quantity*parseInt(prod['unit_value']);
                }
                return total;
            },
            /**
             * Método que borra todos los datos del formulario
             * 
             * @author  Daniel Contreras <dcontreras@cenditel.gob.ve>
             */
            reset() {
            },
            /**
             * Reescribe el método initRecords para cambiar su comportamiento por defecto
             * Inicializa los registros base del formulario
             *
             * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
             * @param {string} url Ruta que obtiene los datos a ser mostrado en listados
             * @param {string} modal_id Identificador del modal a mostrar con la información solicitada
             */
            initRecords(url, modal_id) {
                this.errors = [];
                this.reset();

                const vm = this;
                var fields = {};
                
                document.getElementById("info_general").click();
                axios.get(url).then(response => {
                    if (typeof(response.data.records) !== "undefined") {
                        fields = response.data.records;

                        $(".modal-body #id").val( fields.id );
                        document.getElementById('date_init').innerText = (fields.created_at)?fields.created_at:'';
                        document.getElementById('sale_warehouse').innerText = (fields.sale_warehouse)?fields.sale_warehouse.name:'';
                        document.getElementById('sale_client_rif').innerText = (fields.sale_client)?fields.sale_client.rif:'';
                        document.getElementById('sale_client_name').innerText = (fields.sale_client)?fields.sale_client.name_client:'';
                        document.getElementById('sale_payment_method').innerText = (fields.sale_payment_method)?fields.sale_payment_method.name:'';
                        document.getElementById('sale_discount').innerText = (fields.sale_discount)?fields.sale_discount.name:'N/A';
                        document.getElementById('state').innerText = (fields.state)?fields.state:'';
                        this.records = fields.sale_bill_inventory_products;
                    }
                    if ($("#" + modal_id).length) {
                        $("#" + modal_id).modal('show');
                    }
                }).catch(error => {
                    if (typeof(error.response) !== "undefined") {
                        if (error.response.status == 403) {
                            vm.showMessage(
                                'custom', 'Acceso Denegado', 'danger', 'screen-error', error.response.data.message
                            );
                        }
                        else {
                            vm.logs('resources/js/all.js', 343, error, 'initRecords');
                        }
                    }
                });

            },

            /**
             * Actualiza los productos asociados a la factura
             *
             * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
             */
            loadProducts() {
                const vm = this;
                var index = $(".modal-body #id").val();
                axios.get('/sale/bills/info/' + index).then(response => {
                    this.records = response.data.records.sale_bill_inventory_product;
                });
            }
        },
    }
</script>
