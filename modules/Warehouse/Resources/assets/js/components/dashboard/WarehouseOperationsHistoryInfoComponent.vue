<template>
    <div>
        <a class="btn btn-info btn-xs btn-icon btn-action" 
           href="#" title="Ver información de la operación" data-toggle="tooltip" 
           @click="addRecord('view_operation', route_list, $event)">
            <i class="fa fa-info-circle"></i>
        </a>
        <div class="modal fade text-left" tabindex="-1" role="dialog" id="view_operation">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h6>
                            <i class="icofont icofont-read-book ico-2x"></i> 
                            Información de la Operación Registrada
                        </h6>
                    </div>
                    
                    <div class="modal-body">

                        <div class="alert alert-danger" v-if="errors.length > 0">
                            <ul>
                                <li v-for="error in errors">{{ error }}</li>
                            </ul>
                        </div>
                        <ul class="nav nav-tabs custom-tabs justify-content-center" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#general" id="info_general" role="tab">
                                    <i class="ion-android-person"></i> Información General
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#equipment" role="tab" @click="loadEquipment()">
                                    <i class="ion-arrow-swap"></i> Equipos
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="general" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong>Fecha de la Operación</strong>
                                            <div class="row" style="margin: 1px 0">
                                                <span class="col-md-12" id="created_at"></span>
                                            </div>
                                            <input type="hidden" id="url_search">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong>Tipo de Operación</strong>
                                            <div class="row" style="margin: 1px 0">
                                                <span class="col-md-12" id="type_operation"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <strong>Descripción</strong>
                                            <div class="row" style="margin: 1px 0">
                                                <span class="col-md-12" id="description"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="tab-pane" id="equipment" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12">
                                        <span class="text-muted">
                                            A continuación se muestran los equipos asociados a la operación.
                                        </span>
                                    </div>
                                </div>
                                <div class="modal-table">
                                    <hr>
                                    <v-client-table :columns="columns" :data="records" :options="table_options">
                                        <div slot="code" slot-scope="props" class="text-center">
                                            <span>
                                                {{ props.row.warehouse_inventory_product.code }} 
                                            </span>
                                        </div>
                                        <div slot="quantity" slot-scope="props">
                                            <span>
                                                {{ props.row.quantity }} 
                                                {{ (props.row.warehouse_inventory_product.warehouse_product.measurement_unit)
                                                        ? props.row.warehouse_inventory_product.warehouse_product.measurement_unit.acronym
                                                        : ''
                                                }}
                                            </span>
                                        </div>
                                        <div slot="unit_value" slot-scope="props">
                                            <span>
                                                {{ props.row.warehouse_inventory_product.unit_value }} 
                                                {{ (props.row.warehouse_inventory_product.currency)
                                                    ? props.row.warehouse_inventory_product.currency.symbol
                                                    : ''
                                                }}
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
                    'warehouse_inventory_product.warehouse_product.name',
                    'warehouse_inventory_product.warehouse_product.description',
                    'quantity',
                    'unit_value'
                ],
            }
        },
        props: {
            operation: Object,
        },
        created() {
            this.table_options.headings = {
                'code': 'Código',
                'warehouse_inventory_product.warehouse_product.name': 'Nombre',
                'warehouse_inventory_product.warehouse_product.description': 'Descripción',
                'quantity': 'Cantidad Agregada',
                'unit_value': 'Valor por Unidad'

            };
            this.table_options.sortable = [
                'code',
                'warehouse_inventory_product.name',
                'warehouse_inventory_product.description',
                'quantity',
                'unit_value'
            ];
            this.table_options.filterable = false;

        },
        methods: {
            /**
             * Método que borra todos los datos del formulario
             * 
             * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
             */
            reset() {
            },

            /**
             * Reescribe el método initRecords para cambiar el comportamiento por defecto
             * Inicializa los registros base del formulario
             *
             * @author Henry Paredes <hparedes@cenditel.gob.ve>
             */
            initRecords(url, modal_id) {
                const vm = this;
                vm.errors = [];
                vm.reset();
                
                document.getElementById("info_general").click();
                
                $(".modal-body #url_search").val( vm.operation.type_operation + '/' + vm.operation.code );
                document.getElementById('created_at').innerText = (vm.operation.created_at)?vm.operation.created_at:'N/A';
                document.getElementById('type_operation').innerText = 
                (vm.operation.type_operation == 'movements')?'Movimiento de almacén':(
                    (vm.operation.type_operation == 'requests')?'Solicitud de almacén':'N/A'
                );
                document.getElementById('description').innerText = (vm.operation.description)?vm.operation.description:'N/A';

                if ($("#" + modal_id).length) {
                    $("#" + modal_id).modal('show');
                }
            },
            loadEquipment() {
                var url_search = $(".modal-body #url_search").val();
                axios.get(this.route_list + '/' + url_search).then(response => {
                    this.records = response.data.records;
                });
            }
        },
    }
</script>
