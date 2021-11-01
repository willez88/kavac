<template>
    <v-client-table :columns="columns" :data="records" :options="table_options">
        <div slot="code" slot-scope="props">
            <span>
                {{ (props.row.code) ? props.row.code : '' }}
            </span>
        </div>
        <div slot="application_date" slot-scope="props">
            <span>
                {{ (props.row.created_at) ? props.row.created_at : '' }}
            </span>
        </div>
        <div slot="sale_client" slot-scope="props">
            <span>
                {{ (props.row.sale_client.name) ? props.row.sale_client.name : '' }}
            </span>
            <span>
                {{ (props.row.sale_client.business_name) ? props.row.sale_client.business_name : '' }}
            </span>
        </div>
        <div slot="department" slot-scope="props">
            <span v-for="sale_good in props.row.sale_goods">
                <span v-for="good in sale_good">
                    {{ (props.row.sale_goods) ? good.department.name : '' }}
                </span>
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
                        :disabled="props.row.status != 'Pendiente'">
                    <i class="fa fa-check"></i>
                </button>
                <button @click="rejectedService(props.index)" 
                        class="btn btn-danger btn-xs btn-icon btn-action" title="Rechazar Solicitud"
                        data-toggle="tooltip" type="button"
                        :disabled="props.row.status != 'Pendiente'">
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
                columns: ['code', 'application_date', 'sale_client', 'department', 'status', 'id']
            }
        },
        created() {
            this.table_options.headings = {
                'code': 'Código',
                'application_date': 'Fecha de solicitud',
                'sale_client': 'Nombre del cliente',
                'department': 'Unidad o departamento responsable',
                'status': 'Estado de la solicitud',
                'id': 'Acción'
            };
            this.table_options.sortable = ['code', 'application_date', 'sale_client', 'department', 'status'];
            this.table_options.filterable = ['code', 'application_date', 'sale_client', 'department', 'status'];
            this.table_options.columnsClasses = {
                'code': 'col-md-2',
                'application_date': 'col-md-2',
                'sale_client': 'col-md-2',
                'department': 'col-md-2',
                'status': 'col-md-2',
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
