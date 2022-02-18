<template>
    <section id="payrollPermissionPoliciesComponent">
        <a class="btn-simplex btn-simplex-md btn-simplex-primary" href=""
           title="Registros de políticas de perimisos" data-toggle="tooltip"
           @click="addRecord('add_payroll-permission-policies', 'payroll/permission-policies', $event)">
           <i class="icofont icofont-paper ico-3x"></i>
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
                            <i class="icofont icofont-paper ico-3x"></i>
                            Políticas de Permisos
                        </h6>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" v-if="errors.length > 0">
                            <div class="container">
                                <div class="alert-icon">
                                    <i class="now-ui-icons objects_support-17"></i>
                                </div>
                                <strong>Cuidado!</strong> Debe verificar los siguientes errores antes de continuar:
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                                        @click.prevent="errors = []">
                                    <span aria-hidden="true">
                                        <i class="now-ui-icons ui-1_simple-remove"></i>
                                    </span>
                                </button>
                                <ul>
                                    <li v-for="error in errors" :key="error">{{ error }}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group is-required">
                                    <label for="name">Nombre:</label>
                                    <input type="text" id="name" placeholder="Nombre"
                                           class="form-control input-sm" v-model="record.name" data-toggle="tooltip"
                                           title="Indique el nombre del permiso"
                                           v-input-mask data-inputmask-regex="[a-zA-Z ]*">
                                    <input type="hidden" name="id" id="id" v-model="record.id">
                                </div>
                            </div>
                            <!-- activa -->
                            <div class="col-md-6">
                               <div class="form-group">
                                  <label>¿Activo?</label>
                                    <div class="col-12">
                                        <p-check class="pretty p-switch p-fill p-bigger"
                                         color="success" off-color="text-gray" toggle
                                         data-toggle="tooltip"
                                         v-model="record.active">
                                         <label slot="off-label"></label>
                                        </p-check>
                                    </div>
                                </div>
                            </div>
                            <!-- ./activa -->
                            <div class="col-md-6">
                                <div class="form-group is-required">
                                    <label for="institutions">Organización</label>
                                    <select2 :options="institutions"
                                             v-model="record.institution_id"></select2>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group is-required">
                                    <label for="anticipation_day">Días de anticipación:</label>
                                    <input type="text" data-toggle="tooltip" id="anticipation_day"
                                           placeholder="Días de anticipación para solicitar el permiso"
                                           title="Indique el día de anticipación para solicitar el permiso"
                                           class="form-control input-sm"
                                           v-input-mask data-inputmask="
                                                'alias': 'numeric',
                                                'allowMinus': 'false',
                                                'digits': 0"
                                           v-model="record.anticipation_day">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12"> <h6> Dias solicitados para el permiso </h6> </div>
                            <div class="col-md-6">
                                <div class="form-group is-required">
                                    <label for="day_min">Rango mínimo:</label>
                                    <input type="text" data-toggle="tooltip" id="day_min"
                                           placeholder="Número mínimo de días del permiso"
                                           title="Indique el número mínimo de días permitidos para el permiso"
                                           class="form-control input-sm"
                                           v-input-mask data-inputmask="
                                                'alias': 'numeric',
                                                'allowMinus': 'false',
                                                'digits': 0"
                                           v-model="record.day_min">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group is-required">
                                    <label for="day_max">Rango máximo:</label>
                                    <input type="text" data-toggle="tooltip" id="day_max"
                                           placeholder="Número máximo de días del permiso"
                                           title="Indique el número máximo de días permitidos para el permiso"
                                           class="form-control input-sm"
                                           v-input-mask data-inputmask="
                                                'alias': 'numeric',
                                                'allowMinus': 'false',
                                                'digits': 0"
                                           v-model="record.day_max">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group">
                            <button type="button" class="btn btn-default btn-sm btn-round btn-modal-close" 
									@click="clearFilters" data-dismiss="modal">
								Cerrar
							</button>
							<button type="button" class="btn btn-warning btn-sm btn-round btn-modal btn-modal-clear" 
									@click="reset()">
								Cancelar
							</button>
							<button type="button" @click="createRecord('payroll/permission-policies')" 
									class="btn btn-primary btn-sm btn-round btn-modal-save">
								Guardar
							</button>
                        </div>
                    </div>
                    <div class="modal-body modal-table">
                        <v-client-table :columns="columns" :data="records" :options="table_options">
                            <div slot="day_range" slot-scope="props" class="text-center">
                                <span>{{props.row.day_min + ' - ' + props.row.day_max}}</span>
                            </div>
                            <div slot="active" slot-scope="props" class="text-center">
                                <span v-if="props.row.active">Si</span>
                                <span v-else>No</span>
                            </div>
                            <div slot="id" slot-scope="props" class="text-center">
                                <button @click="initUpdate(props.row.id, $event)"
                                        class="btn btn-warning btn-xs btn-icon btn-action"
                                        title="Modificar registro" data-toggle="tooltip" v-has-tooltip type="button">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button @click="deleteRecord(props.index, 'permission-policies')"
                                        class="btn btn-danger btn-xs btn-icon btn-action"
                                        title="Eliminar registro" data-toggle="tooltip" v-has-tooltip
                                        type="button">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                            </div>
                        </v-client-table>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
                    active:           false,
                    institution_id:   ''
                },
                errors:       [],
                records:      [],
                institutions: [],
                columns:      ['name', 'anticipation_day', 'day_range', 'active', 'id'],
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
                    active:           false,
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
                            url = (!url.includes('http://') || !url.includes('http://'))
                                  ? `${window.app_url}${(url.startsWith('/'))?'':'/'}${url}` : url;
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
                'name':             'Nombre',
                'anticipation_day': 'Dias de anticipación',
                'day_range':        'Rango de días solicitados',
                'active':           'Activo',
                'id':               'Acción'
            };
            this.table_options.sortable = ['name'];
            this.table_options.filterable = ['name'];
            this.table_options.columnsClasses = {
                'name':             'col-xs-2',
                'anticipation_day': 'col-xs-3',
                'day_range':        'col-xs-3',
                'active':           'col-xs-2',
                'id':               'col-xs-2'
            };
        },
        mounted() {
            const vm = this;
            $("#add_payroll-permission-policies").on('show.bs.modal', function() {
                vm.getInstitutions();
            });
        },
    };
</script>
