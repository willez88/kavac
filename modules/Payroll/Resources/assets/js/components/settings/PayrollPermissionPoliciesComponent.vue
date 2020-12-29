<template>
    <div class="col-xs-2 text-center">
        <a class="btn-simplex btn-simplex-md btn-simplex-primary" href=""
           title="Registros de políticas de perimisos" data-toggle="tooltip"
           @click="addRecord('add_payroll-permission-policies', 'payroll/permission-policies', $event)">
           <i class="icofont icofont-briefcase-alt-1 ico-3x"></i>
           <span>Políticas de Permisos</span>
        </a>
        <div class="modal fade text-left" tabindex="-1" role="dialog" id="add_payroll-permission-policies">
            <div class="modal-dialog vue-crud" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h6>
                            <i class="icofont icofont-briefcase-alt-1 ico-3x"></i>
                            Políticas de Permisos
                        </h6>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" v-if="errors.length > 0">
                            <ul>
                                <li v-for="error in errors">{{ error }}</li>
                            </ul>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group is-required">
                                    <label for="name">Nombre:</label>
                                    <input type="text" id="name" placeholder="Nombre"
                                           class="form-control input-sm" v-model="record.name" data-toggle="tooltip"
                                           title="Indique el nombre del permiso">
                                    <input type="hidden" name="id" id="id" v-model="record.id">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group is-required">
                                    <label for="institutions">Institución</label>
                                    <select2 :options="institutions"
                                             v-model="record.institution_id"></select2>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group is-required">
                                    <label for="anticipation_day">Días de anticipación:</label>
                                    <input type="number" id="anticipation_day"
                                           placeholder="Días de anticipación para solicitar el permiso"
                                           class="form-control input-sm" v-model="record.anticipation_day"
                                           data-toggle="tooltip"
                                           title="Indique el día de anticipación para solicitar el permiso">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12"> <h6> Dias de validación del permiso </h6> </div>
                            <div class="col-md-6">
                                <div class="form-group is-required">
                                    <label for="day_min">Rango mínimo:</label>
                                    <input type="number" id="day_min" placeholder="Rango mínimo para solicitar permiso"
                                           class="form-control input-sm" v-model="record.day_min" data-toggle="tooltip"
                                           title="Indique el número mínimo para solicitar permiso">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group is-required">
                                    <label for="day_max">Rango máximo:</label>
                                    <input type="number" id="day_max" placeholder="Rango máximo para solicitar permiso"
                                           class="form-control input-sm" v-model="record.day_max" data-toggle="tooltip"
                                           title="Indique el número máximo para solicitar permiso">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group">
                            <modal-form-buttons :saveRoute="'payroll/permission-policies'"></modal-form-buttons>
                        </div>
                    </div>
                    <div class="modal-body modal-table">
                        <v-client-table :columns="columns" :data="records" :options="table_options">
                            <div slot="id" slot-scope="props" class="text-center">
                                <button @click="initUpdate(props.row.id, $event)"
                                        class="btn btn-warning btn-xs btn-icon btn-action"
                                        title="Modificar registro" data-toggle="tooltip" type="button">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button @click="deleteRecord(props.index, 'permission-policies')"
                                        class="btn btn-danger btn-xs btn-icon btn-action"
                                        title="Eliminar registro" data-toggle="tooltip"
                                        type="button">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                            </div>
                        </v-client-table>
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
                record: {
                    id:               '',
                    name:             '',
                    anticipation_day: '',
                    day_min:          '',
                    day_max:          '',
                    institution_id:   ''
                },
                errors:       [],
                records:      [],
                institutions: [],
                columns:      ['name', 'anticipation_day', 'day_min', 'day_max', 'id'],
            }
        },
        methods: {
            /**
             * Método que borra todos los datos del formulario
             *
             *
             */
            reset() {
                this.record = {
                    id:               '',
                    name:             '',
                    anticipation_day: '',
                    day_min:          '',
                    day_max:          '',
                    institution_id:   ''
                };
            },
            deleteRecord(index, url) {
                var url = (url)?url:this.route_delete;
                var records = this.records;
                var confirmated = false;
                var index = index - 1;
                const vm = this;

                bootbox.confirm({
                    title: "¿Eliminar registro?",
                    message: "¿Está seguro de eliminar este registro?",
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
                            confirmated = true;
                            axios.delete(url + '/' + records[index].id).then(response => {
                                if (typeof(response.data.error) !== "undefined") {
                                    /** Muestra un mensaje de error si sucede algún evento en la eliminación */
                                    vm.showMessage('custom', 'Alerta!', 'warning', 'screen-error', response.data.message);
                                    return false;
                                }
                                records.splice(index, 1);
                                vm.showMessage('destroy');
                            }).catch(error => {
                                vm.logs('mixins.js', 498, error, 'deleteRecord');
                            });
                        }
                    }
                });

                if (confirmated) {
                    this.records = records;
                    this.showMessage('destroy');
                }
            },
        },
        created() {
            this.table_options.headings = {
                'name': 'Nombre',
                'anticipation_day': 'Dias de anticipación',
                'day_min': 'Número mínimo de permiso',
                'day_max': 'Número máximo de permiso',
                'id': 'Acción'
            };
            this.table_options.sortable = ['name'];
            this.table_options.filterable = ['name'];
            this.table_options.columnsClasses = {
                'name': 'col-md-3',
                'anticipation_day': 'col-md-3',
                'day_min': 'col-md-3',
                'day_max': 'col-md-3',
                'id': 'col-md-2'
            };
        },
        mounted() {
            const vm = this;
            vm.getInstitutions();
        },
    };
</script>
