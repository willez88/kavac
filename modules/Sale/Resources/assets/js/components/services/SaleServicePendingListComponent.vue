<template>
    <v-client-table :columns="columns" :data="records" :options="table_options">
        <div slot="state" slot-scope="props">
            <span>
                {{ (props.row.state)?props.row.state:'N/A' }}
            </span>
        </div>
        
        <div slot="id" slot-scope="props" class="text-center">
            <div class="d-inline-flex">
                 <!--sale-bill-info
                    :route_list="'/sale/bills/info/'+ props.row.id">
                </sale-bill-info-->

                <button @click="approvedService(props.index)" 
                        class="btn btn-success btn-xs btn-icon btn-action" title="Aceptar Solicitud"
                        data-toggle="tooltip" type="button"
                        :disabled="props.row.state != 'Pendiente'">
                    <i class="fa fa-check"></i>
                </button>
                <button @click="rejectedService(props.index)" 
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
                columns: ['code', 'application_date', 'sale_client.name_client', 'responsible_department', 'state', 'id']
            }
        },
        created() {
            this.table_options.headings = {
                'code': 'Código',
                'application_date': 'Fecha de solicitud',
                'sale_client.name_client': 'Nombre del cliente',
                'responsible_department': 'Unidad o departamento responsable',
                'state': 'Estado de la solicitud',
                'id': 'Acción'
            };
            this.table_options.sortable = ['code', 'application_date', 'sale_client.name_client', 'responsible_department', 'state'];
            this.table_options.filterable = ['code', 'application_date', 'sale_client.name_client', 'responsible_department', 'state'];
            this.table_options.columnsClasses = {
                'code': 'col-md-2',
                'application_date': 'col-md-2',
                'sale_client.name_client': 'col-md-2',
                'responsible_department': 'col-md-2',
                'state': 'col-md-2',
                'id': 'col-md-2'
            };
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
            rejectedService(index)
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

                            axios.put('/'+vm.route_update+'/serive-rejected/'+id, fields).then(response => {
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
            approvedService(index)
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

                            axios.put('/'+vm.route_update+'/service-approved/'+id, fields).then(response => {
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
