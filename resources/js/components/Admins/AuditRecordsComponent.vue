<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">
                        Auditoría de registros
                        <a href="javascript:void(0)" title="haz click para ver la ayuda guiada de este elemento"
                           data-toggle="tooltip" class="btn-help" @click="initUIGuide(helpFile)">
                            <i class="ion ion-ios-help-outline cursor-pointer"></i>
                        </a>
                    </h6>
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
                        <div class="form-group col-md-2" id="helpAuditFilterFromDate">
                            <div class="input-group input-sm">
                                <span class="input-group-addon">
                                    <i class="now-ui-icons ui-1_calendar-60"></i>
                                </span>
                                <input type="date" class="form-control" data-toggle="tooltip" title="Desde la fecha"
                                       v-model="start_date" placeholder="Fecha">
                            </div>
                        </div>
                        <div class="form-group col-md-2" id="helpAuditFilterToDate">
                            <div class="input-group input-sm">
                                <span class="input-group-addon">
                                    <i class="now-ui-icons ui-1_calendar-60"></i>
                                </span>
                                <input type="date" class="form-control" data-toggle="tooltip" title="Hasta la fecha"
                                       v-model="end_date" placeholder="Fecha">
                            </div>
                        </div>
                        <div class="form-group col-md-2" id="helpAuditFilterUser">
                            <div class="input-group input-sm">
                                <span class="input-group-addon">
                                    <i class="now-ui-icons users_circle-08"></i>
                                </span>
                                <input type="text" class="form-control" data-toggle="tooltip" v-model="user"
                                       title="Consulta por usuario" placeholder="Usuario">
                            </div>
                        </div>
                        <div class="form-group col-md-2" id="helpAuditFilterModule">
                            <select v-model="module" class="form-control select2">
                                <option value="">Módulo</option>
                                <option :value="mod.originalName" v-for="mod in modules">{{ mod.name }}</option>
                            </select>
                            <!--<div class="input-group input-sm">
                                <span class="input-group-addon">
                                    <i class="now-ui-icons design_app"></i>
                                </span>
                                <input type="text" class="form-control" data-toggle="tooltip" v-model="module"
                                       title="Consulta por módulo de la aplicación" placeholder="Módulo">
                            </div>-->
                        </div>
                        <div class="form-group col-md-2" id="helpAuditFilterButton">
                            <button type="button" class="btn btn-info btn-icon btn-xs px-3" data-toggle="tooltip"
                                    title="Buscar registros del sistema" @click="readRecords">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <span class="form-text text-muted">
                                A continuación se muestran los 20 registros más recientes.
                                Si desea obtener mayor información, debe indicar los parámetros de búsqueda.
                            </span>
                        </div>
                    </div>
                    <hr>
                    <div class="row mg-bottom-20" id="helpAuditLeyend">
                        <div class="col-12 panel-legend" id="helpAuditLeyendNew">
                            <i class="ion-android-checkbox-blank text-success" title="Registros nuevos"
                               data-toggle="tooltip"></i>
                            <span>Nuevos</span>
                        </div>
                        <div class="col-12 panel-legend" id="helpAuditLeyendUpdate">
                            <i class="ion-android-checkbox-blank text-warning" title="Registros actualizados"
                               data-toggle="tooltip"></i>
                            <span>Actualizados</span>
                        </div>
                        <div class="col-12 panel-legend" id="helpAuditLeyendRestore">
                            <i class="ion-android-checkbox-blank text-info" title="Registros reestablecidos"
                               data-toggle="tooltip"></i>
                            <span>Restaurados después de eliminación</span>
                        </div>
                        <div class="col-12 panel-legend" id="helpAuditLeyendDelete">
                            <i class="ion-android-checkbox-blank text-danger" title="Registros eliminados"
                               data-toggle="tooltip"></i>
                            <span>Eliminados</span>
                        </div>
                    </div>
                    <div class="row" id="helpAuditTable">
                        <div class="col-12">
                            <v-client-table :columns="columns" :data="records" :options="table_options">
                                <div slot="status" slot-scope="props" v-html="props.row.status" class="text-center"></div>
                                <div slot="date" slot-scope="props" v-html="props.row.date" class="text-center">
                                    {{ props.row.date }}
                                </div>
                                <div slot="ip" slot-scope="props" v-html="props.row.ip" class="text-center">
                                    {{ props.row.ip }}
                                </div>
                                <div slot="users" slot-scope="props" v-html="props.row.users"></div>
                                <div slot="id" slot-scope="props" class="text-center">
                                    <button @click="details(props.row.id)"
                                            class="btn btn-info btn-xs btn-icon btn-action"
                                            title="Ver detalles del registro" data-toggle="tooltip" type="button">
                                        <i class="fa fa-eye"></i>
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
                start_date: '',
                end_date: '',
                user: '',
                module: '',
                records: [],
                columns: ['status', 'date', 'ip', 'module', 'users', 'id']
            }
        },
        props: {
            modules: {
                type: Array,
                required: false,
                default: null
            }
        },
        methods: {
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
                axios.post('/app/audit-records', {
                    start_date: vm.start_date,
                    end_date: vm.end_date,
                    user: vm.user,
                    module: vm.module
                }).then(response => {
                    if (response.data.result && typeof(response.data.records) !== "undefined") {
                        vm.records = response.data.records;
                    }
                    vm.loading = false;
                }).catch(error => {
                    console.error(error);
                    vm.loading = false;
                });
            },
            /**
             * Muestra los detalles de un registro seleccionado
             *
             * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             *
             * @param     {string}    id    Identificador del registro para el cual se desea mostrar los detalles
             */
            details(id) {
                const vm = this;
                vm.loading = true;
                axios.post('/app/audit-details', {
                    id: id
                }).then(response => {
                    if (response.data.result) {
                        let audit = response.data.audit;
                        let eventType = audit.event;
                        let eventText = '';
                        let className = '';
                        let prevRecord = 'N/A';
                        let nextRecord = 'N/A';

                        if (eventType === 'created') {
                            eventText = 'NUEVO';
                            className = 'success';
                        } else if (eventType === 'deleted') {
                            eventText = 'ELIMINADO';
                            className = 'danger';
                        } else if (eventType === 'restored') {
                            eventText = 'RESTAURADO';
                            className = 'info';
                        } else if (eventType === 'updated') {
                            eventText = 'ACTUALIZADO';
                            className = 'warning';
                        }

                        if (audit.old_values) {
                            prevRecord = '';
                            Object.keys(audit.old_values).forEach(key => {
                                prevRecord += `<b>${key}:</b> ${audit.old_values[key]}<br>`;
                            });
                        }
                        if (audit.new_values) {
                            nextRecord = '';
                            Object.keys(audit.new_values).forEach(key => {
                                nextRecord += `<b>${key}:</b> ${audit.new_values[key]}<br>`;
                            });
                        }

                        bootbox.dialog({
                            title: 'Registro',
                            message:    `<div class="row text-justify">
                                            <div class="col-12">
                                                <p>
                                                    <span class="badge badge-${className} mr-1">${eventText}</span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 text-left">
                                                <h5>Datos anteriores</h5>
                                                <div>${prevRecord}</div>
                                            </div>
                                            <div class="col-md-6 text-left">
                                                <h5>Datos nuevos</h5>
                                                <div>${nextRecord}</div>
                                            </div>
                                        </div>`,
                            size: 'large',
                            buttons: {
                                ok: {
                                    label: 'Cerrar',
                                    className: 'btn-primary',
                                    callback: function() {
                                        //
                                    }
                                }
                            }
                        });
                    }
                    vm.loading = false;
                }).catch(error => {
                    console.error(error);
                    vm.loading = false;
                });
            }
        },
        created() {
            const vm = this;
            vm.table_options.headings = {
                'status': '',
                'date': 'Fecha - Hora',
                'ip': 'IP',
                'module': 'Módulo',
                'users': 'Usuario',
                'id': 'Acción'
            };
            vm.table_options.sortable = ['date', 'ip', 'module', 'users'];
            vm.table_options.filterable = ['date', 'ip', 'module', 'users'];
            vm.table_options.columnsClasses = {
                'status': 'col-md-1',
                'date': 'col-md-2',
                'ip': 'col-md-1',
                'module': 'col-md-5',
                'users': 'col-md-2',
                'id': 'col-md-1'
            };
        },
        mounted() {
            const vm = this;
            vm.readRecords();
        }
    };
</script>
