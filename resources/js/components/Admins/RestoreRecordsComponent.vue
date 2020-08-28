<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Restaurar Registros eliminados</h6>
                    <div class="card-btns">
                        <a href="javascript:void(0)" class="card-minimize btn btn-card-action btn-round"
                           title="Minimizar" data-toggle="tooltip">
                            <i class="now-ui-icons arrows-1_minimal-up"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <b>Filtros</b>
                        </div>
                        <div class="form-group col-md-2">
                            <div class="input-group input-sm">
                                <span class="input-group-addon">
                                    <i class="now-ui-icons ui-1_calendar-60"></i>
                                </span>
                                <input type="date" class="form-control" data-toggle="tooltip" title="Desde la fecha"
                                       v-model="start_delete_at" placeholder="Fecha">
                            </div>
                        </div>
                        <div class="form-group col-md-2">
                            <div class="input-group input-sm">
                                <span class="input-group-addon">
                                    <i class="now-ui-icons ui-1_calendar-60"></i>
                                </span>
                                <input type="date" class="form-control" data-toggle="tooltip" title="Hasta la fecha"
                                       v-model="end_delete_at" placeholder="Fecha">
                            </div>
                        </div>
                        <div class="form-group col-md-2">
                            <div class="input-group input-sm">
                                <span class="input-group-addon">
                                    <i class="now-ui-icons design_app"></i>
                                </span>
                                <input type="text" class="form-control" data-toggle="tooltip" v-model="module_delete_at"
                                       title="Módulo en donde el registro fue eliminado" placeholder="Módulo">
                            </div>
                        </div>
                        <div class="form-group col-md-2">
                            <button type="button" class="btn btn-info btn-icon btn-xs px-3" data-toggle="tooltip"
                                    title="Buscar registros eliminados" @click="readRecords">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <span class="form-text text-muted">
                                A continuación se muestran los últimos 20 registros recientemente eliminados.
                                Si desea obtener mayor información, debe indicar los parámetros de búsqueda.
                            </span>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <v-client-table :columns="columns" :data="records" :options="table_options">
                                <div slot="registers" slot-scope="props" v-html="props.row.registers"></div>
                                <div slot="id" slot-scope="props" class="text-center">
                                    <button @click="restore(props.row.module, props.row.id)"
                                            class="btn btn-success btn-xs btn-icon btn-action"
                                            title="Restaurar registro" data-toggle="tooltip" type="button">
                                        <i class="fa fa-check"></i>
                                    </button>
                                </div>
                            </v-client-table>
                        </div>
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
                start_delete_at: '',
                end_delete_at: '',
                module_delete_at: '',
                records: [],
                columns: ['deleted_at', 'module', 'registers', 'id'],
            }
        },
        methods: {
            /**
             * Restaurar registro eliminado
             *
             * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             */
            restore(moduleClass, id) {
                const vm = this;
                vm.loading = true;
                axios.post('/app/restore-record', {
                    module: moduleClass,
                    id: id
                }).then(response => {
                    if (response.data.result) {
                        vm.readRecords();
                        vm.showMessage(
                            'custom', 'Éxito', 'success', 'screen-ok', 'Registro restaurado con éxito'
                        );
                    }
                    vm.loading = false;
                }).catch(error => {
                    console.error(error);
                });
            },
            /**
             * Método que obtiene los registros a mostrar
             *
             * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             *
             * @param  {string} url Ruta que obtiene todos los registros solicitados
             */
            readRecords() {
                const vm = this;
                vm.loading = true;
                axios.post('/app/deleted-records', {
                    start_delete_at: vm.start_delete_at,
                    end_delete_at: vm.end_delete_at,
                    module_delete_at: vm.module_delete_at
                }).then(response => {
                    if (response.data.result && typeof(response.data.records) !== "undefined") {
                        vm.records = response.data.records;
                    }
                    vm.loading = false;
                }).catch(error => {
                    console.error(error);
                });
            },
        },
        created() {
            const vm = this;
            vm.table_options.headings = {
                'deleted_at': 'Fecha',
                'module': 'Módulo',
                'registers': 'Registros',
                'id': 'Acción'
            };
            vm.table_options.sortable = ['deleted_at'];
            vm.table_options.filterable = ['deleted_at'];
            vm.table_options.columnsClasses = {
                'deleted_at': 'col-md-1',
                'module': 'col-md-4',
                'registers': 'col-md-6',
                'id': 'col-md-1'
            };
        },
        mounted() {
            const vm = this;

            vm.readRecords();
        }
    };
</script>
