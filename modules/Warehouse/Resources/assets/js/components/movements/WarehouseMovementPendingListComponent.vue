<template>
    <v-client-table :columns="columns" :data="records" :options="table_options">
        <div slot="code" slot-scope="props" class="text-center">
            <span>
                {{ props.row.code }}
            </span>
        </div>
        <div slot="warehouse_initial" slot-scope="props">
            <span>
                {{ (props.row.warehouse_institution_warehouse_initial)?props.row.warehouse_institution_warehouse_initial.warehouse.name:'N/A' }}
            </span>
        </div>
        <div slot="warehouse_end" slot-scope="props">
            <span>
                {{ (props.row.warehouse_institution_warehouse_end)?props.row.warehouse_institution_warehouse_end.warehouse.name:'N/A' }}
            </span>
        </div>
        <div slot="state" slot-scope="props">
            <span>
                {{ (props.row.state)?props.row.state:'N/A' }}
            </span>
        </div>
        <div slot="id" slot-scope="props" class="text-center">
            <div class="d-inline-flex">

                <warehouse-movement-info 
                    :route_list="'movements/info/'+ props.row.id">
                </warehouse-movement-info>

                <warehouse-movement-confirm-create
                    :movementid="props.row.id"
                    route_update="warehouse/movements/movement-complete"
                    v-if="props.row.state == 'Aprobado'">
                </warehouse-movement-confirm-create>
                
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
</template>

<script>
    export default {
        data() {
            return {
                records: [],
                columns: ['code', 'warehouse_initial', 'warehouse_end', 'state', 'created_at', 'id']
            }
        },
        created() {
            this.table_options.headings = {
                'code': 'Código',
                'warehouse_initial': 'Origen',
                'warehouse_end': 'Destino',
                'state': 'Estado de la Solicitud',
                'created_at': 'Fecha de la Solicitud',
                'id': 'Acción'
            };
            this.table_options.sortable = [
                'code', 'warehouse_initial', 'warehouse_end', 'state', 'created_at'
            ];
            this.table_options.filterable = [
                'code', 'warehouse_initial', 'warehouse_end', 'state', 'created_at'
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

                            axios.put('/'+vm.route_update+'/movement-rejected/'+id, fields).then(response => {
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

                            axios.put('/'+vm.route_update+'/movement-approved/'+id, fields).then(response => {
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
