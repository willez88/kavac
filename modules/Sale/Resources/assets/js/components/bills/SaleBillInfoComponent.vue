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
                            <a class="nav-link" data-toggle="tab" href="#products" role="tab">
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
                            <div class="modal-table" v-if="record.sale_bill_products">
                                <v-client-table :columns="columns" :data="Object.values(record.sale_bill_products)" :options="table_options">
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
                                                <input type="text" disabled placeholder="Total Sin IVA" id="bill_total_without_tax" title="Total sin IVA" v-model="record.bill_total_without_taxs" class="form-control input-sm">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-right">
                                        <div class="d-inline-flex align-items-center">
                                            <label class="font-weight-bold">IVA:</label>
                                            <div class="form-group">
                                                <input type="text" disabled placeholder="Total IVA" id="total_iva" title="Total IVA" v-model="(record.bill_totals - record.bill_total_without_taxs).toFixed(2)" class="form-control input-sm">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-right">
                                        <div class="d-inline-flex align-items-center">
                                            <label class="font-weight-bold">Total a pagar:</label>
                                            <div class="form-group">
                                                <input type="text" disabled placeholder="Total a pagar" id="bill_total" title="Total" v-model="record.bill_totals" class="form-control input-sm">
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
        },
    }
</script>
