<template>
    <v-client-table :columns="columns" :data="records" :options="table_options">
        <div slot="price" slot-scope="props" >
            <div>
                Precio total: {{ price(props.row.sale_bill_inventory_product) }}
            </div>
        </div>
        <div slot="state" slot-scope="props">
            <span>
                {{ (props.row.state)?props.row.state:'N/A' }}
            </span>
        </div>
        
        <div slot="id" slot-scope="props" class="text-center">
            <div class="d-inline-flex">
                 <sale-bill-info
                    :route_list="'/sale/bills/info/'+ props.row.id">
                </sale-bill-info>

                <button @click="approvedBill(props.index)" 
                        class="btn btn-success btn-xs btn-icon btn-action" title="Aceptar Solicitud"
                        data-toggle="tooltip" type="button"
                        :disabled="props.row.state != 'Pendiente'">
                    <i class="fa fa-check"></i>
                </button>
                <button @click="rejectedBill(props.index)" 
                        class="btn btn-danger btn-xs btn-icon btn-action" title="Rechazar Solicitud"
                        data-toggle="tooltip" type="button"
                        :disabled="props.row.state != 'Pendiente'">
                    <i class="fa fa-ban"></i>
                </button>
            </div>
        </div>
    </v-client-table>
</template>

<script>
    export default {
        data() {
            return {
                records: [],
                columns: ['code', 'sale_client.rif', 'sale_client.name_client', 'price', 'state', 'id']
            }
        },
        created() {
            this.table_options.headings = {
                'code': 'Código',
                'sale_client.rif': 'RIF',
                'sale_client.name_client': 'Nombre del cliente',
                'price': 'Monto',
                'state': 'Estado de la factura',
                'id': 'Acción'
            };
            this.table_options.sortable = ['code', 'sale_client.rif', 'sale_client.name_client', 'price', 'state'];
            this.table_options.filterable = ['code', 'sale_client.rif', 'sale_client.name_client', 'price', 'state'];
            this.table_options.columnsClasses = {
                'code': 'col-md-2',
                'sale_client.rif': 'col-md-2',
                'sale_client.name_client': 'col-md-2',
                'price': 'col-md-2',
                'state': 'col-md-2',
                'id': 'col-md-2'
            };
        },
        mounted () {
            this.initRecords(this.route_list, '');
        },
        methods: {
            price(prods){
                const vm = this;
                var total = 0;
                $.each(prods, function(index, prod) {
                    total += prod['quantity']*parseInt(prod['sale_warehouse_inventory_product']['unit_value']);
                });
                return total;
            },
            /**
             * Inicializa los datos del formulario
             *
             * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
             */
            reset() {
                
            },
            rejectedBill(index)
            {
                const vm = this;
                var dialog = bootbox.confirm({
                    title: 'Rechazar operación?',
                    message: "<p>¿Seguro que desea rechazar esta operación?. Una vez rechazada la operación no se podrán realizar cambios en la misma.<p>",
                    size: 'medium',
                    buttons: {
                        cancel: {
                            label: '<i class="fa fa-times"></i> Cancelar'
                        },
                        confirm: {
                            label: '<i class="fa fa-check"></i> Confirmar'
                        }
                    },
                    callback: function (result) {
                        if (result) {
                            var fields = vm.records[index-1];
                            var id = vm.records[index-1].id;

                            axios.put('/'+vm.route_update+'/bill-rejected/'+id, fields).then(response => {
                                if (typeof(response.data.redirect) !== "undefined")
                                    location.href = response.data.redirect;
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
                    }
                });
            },
            approvedBill(index)
            {
                const vm = this;
                var dialog = bootbox.confirm({
                    title: 'Aprobar operación?',
                    message: "<p>¿Seguro que desea aprobar esta operación?. Una vez aprobada la operación no se podrán realizar cambios en la misma.<p>",
                    size: 'medium',
                    buttons: {
                        cancel: {
                            label: '<i class="fa fa-times"></i> Cancelar'
                        },
                        confirm: {
                            label: '<i class="fa fa-check"></i> Confirmar'
                        }
                    },
                    callback: function (result) {
                        if (result) {
                            var fields = vm.records[index-1];
                            var id = vm.records[index-1].id;

                            axios.put('/'+vm.route_update+'/bill-approved/'+id, fields).then(response => {
                                if (typeof(response.data.redirect) !== "undefined")
                                    location.href = response.data.redirect;
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
                    }
                });
            },
        }
    };
</script>
