<template>
    <div id="SaleBillInfo" class="modal fade" tabindex="-1" role="dialog"
         aria-labelledby="SaleBillInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="max-width:60rem">
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
                                        <strong>Tipo de persona</strong>
                                        <div class="row" style="margin: 1px 0">
                                            <span class="col-md-12">
                                                {{ record.type_person }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="record.type_person == 'Natural'" class="col-md-6">
                                    <div class="form-group">
                                        <strong>Nombre y apellido</strong>
                                        <div class="row" style="margin: 1px 0">
                                            <span class="col-md-12">
                                                {{ record.name }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="record.type_person == 'Natural'" class="col-md-6">
                                    <div class="form-group">
                                        <strong>Identificación</strong>
                                        <div class="row" style="margin: 1px 0">
                                            <span class="col-md-12">
                                                {{ record.id_number }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="record.type_person == 'Jurídica'" class="col-md-6">
                                    <div class="form-group">
                                        <strong>Nombre de la empresa</strong>
                                        <div class="row" style="margin: 1px 0">
                                            <span class="col-md-12">
                                                {{ record.name }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="record.type_person == 'Jurídica'" class="col-md-6">
                                    <div class="form-group">
                                        <strong>RIF</strong>
                                        <div class="row" style="margin: 1px 0">
                                            <span class="col-md-12">
                                                {{ record.rif }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>Teléfono de contacto  </strong>
                                        <div class="row" style="margin: 1px 0">
                                            <span class="col-md-12">
                                                {{ record.phone }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>Correo electrónico</strong>
                                        <div class="row" style="margin: 1px 0">
                                            <span class="col-md-12">
                                                {{ record.email }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>Forma de cobro</strong>
                                        <div class="row" style="margin: 1px 0">
                                            <span class="col-md-12">
                                                {{ record.sale_form_payment_id ? record.sale_form_payment.name_form_payment : '' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="products" role="tabpanel">
                            <div class="modal-table">
                                <v-client-table :columns="columns" :data="record.sale_bill_products" :options="table_options">
                                    <div slot="sale_warehouse_inventory_product_id" slot-scope="props" class="text-center">
                                        <span>
                                            {{ (props.row.sale_warehouse_inventory_product_id)? props.row.inventory_product_name : props.row.sale_goods_to_be_traded_name }}
                                        </span>
                                    </div>
                                    <div slot="sale_list_subservices_id" slot-scope="props" class="text-center">
                                        <span>
                                            {{ (props.row.sale_list_subservices_id)? props.row.sale_list_subservices_name : 'N/A' }}
                                        </span>
                                    </div>
                                    <div slot="measurement_unit" slot-scope="props" class="text-center">
                                        <span>
                                            {{ (props.row.measurement_unit_id)? props.row.measurement_unit_name : 'N/A' }}
                                        </span>
                                    </div>
                                    <div slot="currency" slot-scope="props" class="text-center">
                                        <span>
                                            {{ (props.row.currency_id)? props.row.currency_name : 'N/A' }}
                                        </span>
                                    </div>
                                    <div slot="product_tax_value" slot-scope="props" class="text-center">
                                        <span>
                                            {{ (props.row.history_tax_id)? props.row.history_tax_value : 'N/A' }}
                                        </span>
                                    </div>
                                </v-client-table>
                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <div class="d-inline-flex align-items-center">
                                            <label class="font-weight-bold">Total sin iva:</label>
                                            <div class="form-group">
                                                <input type="text" disabled placeholder="Total Sin IVA" id="bill_total_without_tax" title="Total sin IVA" v-model="record.bill_total_without_tax" class="form-control input-sm">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-right">
                                        <div class="d-inline-flex align-items-center">
                                            <label class="font-weight-bold">IVA:</label>
                                            <div class="form-group">
                                                <input type="text" disabled placeholder="Total IVA" id="total_iva" title="Total IVA" v-model="(record.bill_total - record.bill_total_without_tax).toFixed(2)" class="form-control input-sm">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-right">
                                        <div class="d-inline-flex align-items-center">
                                            <label class="font-weight-bold">Total a pagar:</label>
                                            <div class="form-group">
                                                <input type="text" disabled placeholder="Total a pagar" id="bill_total" title="Total" v-model="record.bill_total" class="form-control input-sm">
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
</template>

<script>
    export default {
        data() {
            return {
                record: {},
                errors: [],
                columns: [
                    'product_type',
                    'sale_warehouse_inventory_product_id',
                    'sale_list_subservices_id',
                    'measurement_unit',
                    'value',
                    'quantity',
                    'total_without_tax',
                    'product_tax_value',
                    'total',
                    'currency',
                ],
            }
        },
        created() {
            this.table_options.headings = {
                'product_type': 'Tipo de Producto',
                'sale_warehouse_inventory_product_id': 'Producto',
                'sale_list_subservices_id': 'Subservicio',
                'measurement_unit': 'Unidad de medida',
                'value': 'Precio unitario',
                'quantity': 'Cantidad de productos',
                'total_without_tax': 'Total sin iva',
                'product_tax_value': 'Iva',
                'total': 'Total',
                'currency': 'Moneda',
            };
            this.table_options.sortable = [
                'product_type',
                'sale_warehouse_inventory_product_id',
                'sale_list_subservices_id',
                'measurement_unit',
                'value',
                'quantity',
                'total_without_tax',
                'product_tax_value',
                'total',
                'currency',
            ];
            this.table_options.filterable = [
                'product_type',
                'sale_warehouse_inventory_product_id',
                'sale_list_subservices_id',
                'measurement_unit',
                'value',
                'quantity',
                'total_without_tax',
                'product_tax_value',
                'total',
                'currency',
            ];

        },
        methods: {            
            /**
             * Método que borra todos los datos del formulario
             * 
             * @author  Daniel Contreras <dcontreras@cenditel.gob.ve>
             */
            reset() {
            },

            /**
             * Método que carga los registros en la tabla de productos
             *
             * @author  Daniel Contreras <dcontreras@cenditel.gob.ve>
             */
            loadProducts(){
                const vm = this;

                vm.record.sale_bill_products = [];
                vm.record.bill_total_without_tax = 0;
                vm.record.bill_total = 0;

                for (let product of vm.record.sale_bill_inventory_product) {
                    let total_without_tax = parseFloat(product.value) * product.quantity;
                    let total = total_without_tax;
                    let history_tax_value = 0;

                    if (product.history_tax_id){
                        history_tax_value = product.history_tax.percentage * total_without_tax / 100;
                        total = total_without_tax + history_tax_value;
                    }

                    let bill_product = {
                        product_type: product.product_type,
                        sale_warehouse_inventory_product_id: product.sale_warehouse_inventory_product_id,
                        sale_goods_to_be_traded_id: product.sale_goods_to_be_traded_id,
                        sale_list_subservices_id: product.sale_list_subservices_id,
                        measurement_unit_id: product.measurement_unit_id,
                        currency_id: product.currency_id,
                        history_tax_id: product.history_tax_id,
                        value: product.value,
                        quantity: product.quantity,
                        total_without_tax: total_without_tax,
                        sale_goods_to_be_traded_name: product.sale_goods_to_be_traded ? product.sale_goods_to_be_traded.name : '',
                        inventory_product_name: product.sale_warehouse_inventory_product ? product.sale_warehouse_inventory_product.sale_setting_product.name : '',
                        measurement_unit_name: product.measurement_unit.name,
                        sale_list_subservices_name: product.sale_list_subservices ? product.sale_list_subservices.name : '',
                        currency_name: product.currency.symbol + ' - ' + product.currency.name,
                        history_tax_value: history_tax_value,
                        total: total,
                    };

                    vm.record.sale_bill_products.push(bill_product);
                }

                for (let bill_inventory_product of vm.record.sale_bill_products) {
                    vm.record.bill_total_without_tax += bill_inventory_product.total_without_tax;
                    vm.record.bill_total += bill_inventory_product.total;
                }
            },
        },
    }
</script>
