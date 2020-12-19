<template>
    <div>
        <v-client-table :columns="columns" :data="records" :options="table_options">
            <div slot="code" slot-scope="props" class="text-center">
                <span>
                    {{ props.row.code }}
                </span>
            </div>

            <div slot="registered_by" slot-scope="props">
                <span>
                    {{ (props.row.user)?props.row.user.name:'No definido' }}
                </span>
            </div>
            <div slot="sale_warehouse_initial" slot-scope="props">
                <span>
                    {{ (props.row.sale_warehouse_institution_warehouse_initial)?props.row.sale_warehouse_institution_warehouse_initial.sale_warehouse.name:'N/A' }}
                </span>
            </div>
            <div slot="state" slot-scope="props">
                <span>
                    {{ (props.row.state)?props.row.state:'N/A' }}
                </span>
            </div>
            <div slot="id" slot-scope="props" class="text-center">
                <div class="d-inline-flex">

                    <sale-warehouse-reception-info
                        :route_list="'receptions/info/'+ props.row.id">
                    </sale-warehouse-reception-info>

                    <button @click="approvedRequest(props.index)"
                            class="btn btn-success btn-xs btn-icon btn-action" title="Aceptar Solicitud"
                            data-toggle="tooltip" type="button"
                            :disabled="props.row.state != 'Pendiente'">
                        <i class="fa fa-check"></i>
                    </button>
                    <button @click="rejectedRequest(props.index)"
                            class="btn btn-danger btn-xs btn-icon btn-action" title="Rechazar Solicitud"
                            data-toggle="tooltip" type="button"
                            :disabled="props.row.state != 'Pendiente'">
                        <i class="fa fa-ban"></i>
                    </button>
                </div>
            </div>
        </v-client-table>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                records: [],
                columns: ['code', 'registered_by', 'description', 'state', 'created_at', 'id']
            }
        },
        created() {
            this.table_options.headings = {
                'code': 'Código',
                'registered_by': 'Registrado por',
                'description': 'Descripción',
                'sale_warehouse_initial': 'Almacén',
                'state': 'Estado de la Solicitud',
                'created_at': 'Fecha de la Solicitud',
                'id': 'Acción'
            };
            this.table_options.sortable = [
                'code', 'registered_by', 'description', 'sale_warehouse_initial', 'state', 'created_at'
            ];
            this.table_options.filterable = [
                'code', 'registered_by', 'description', 'sale_warehouse_initial', 'state', 'created_at'
            ];
        },
        mounted () {
            this.initRecords(this.route_list, '');
        },
        methods: {
            /**
             * Inicializa los datos del formulario
             *
             * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
             */
            reset() {

            },
            rejectedRequest(index)
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

                            axios.put('/'+vm.route_update+'/reception-rejected/'+id, fields).then(response => {
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
            approvedRequest(index)
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

                            axios.put('/'+vm.route_update+'/reception-approved/'+id, fields).then(response => {
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
