<template>
    <section id="TechnicalSupportAssignRepairManagerFormComponent">
        <a class="btn btn-default btn-xs btn-icon btn-action"
           href="#" title="Asignar responsable de la reparación" data-toggle="tooltip"
           @click="addRecord('assign_request_' + id, route_show, $event)">
            <i class="fa fa-user-plus"></i>
        </a>

        <div class="modal fade text-left" tabindex="-1" role="dialog" :id="'assign_request_' + id">
            <div class="modal-dialog modal-xs">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h6>
                            Asignación de Responsable de la reparación
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
                                    <li v-for="error in errors">{{ error }}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Fecha de Inicio</label>
                                    <div class="input-group input-sm">
                                        <span class="input-group-addon">
                                            <i class="now-ui-icons ui-1_calendar-60"></i>
                                        </span>
                                        <input  id="start_date"
                                                type="date" class="form-control input-sm" 
                                                data-toogle="tooltip" 
                                                title="Indique la fecha de inicio de la reparación (opcional)"
                                                v-model="record.start_date">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Fecha tope de entrega</label>
                                    <div class="input-group input-sm">
                                        <span class="input-group-addon">
                                            <i class="now-ui-icons ui-1_calendar-60"></i>
                                        </span>
                                        <input  id="end_date"
                                                type="date" class="form-control input-sm" 
                                                data-toogle="tooltip" 
                                                title="Indique la fecha tope para realizar la reparación (opcional)"
                                                v-model="record.end_date">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group is-required">
                                    <label>Responsable de la reparación</label>
                                    <select2 :options="technicalSupportStaffs"
                                             id="user_select"
                                             v-model="record.user_id"></select2>
                                    <input type="hidden" v-model="record.id">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-default btn-sm btn-round btn-modal-close"
                                data-dismiss="modal">
                            Cerrar
                        </button>
                        <button type="button" @click="createRecord('technicalsupport/repairs')"
                                class="btn btn-primary btn-sm btn-round btn-modal-save">
                            Guardar
                        </button>
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
                    id: '',
                    state: '',
                    start_date: '',
                    end_date: '',
                    user_id: '',
                    technical_support_request_id: '',
                },
                technicalSupportStaffs: [],
                records: [],
                errors: [],
            }
        },
        props: {
            id: {
                type: Number,
                required: true
            }
        },
        created() {
            const vm = this;
            vm.getTechnicalSupportStaffs();

        },
        methods: {
            /**
             * Método que borra todos los datos del formulario
             *
             * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             */
            reset() {
                this.record = {
                    id: '',
                    state: '',
                    start_date: '',
                    end_date: '',
                    user_id: '',
                    technical_support_request_id: '',
                };
            },
            /**
             * Inicializa los registros base del formulario
             *
             * @author Henry Paredes <hparedes@cenditel.gob.ve>
             */
            initRecords(url,modal_id){
                const vm = this;

                vm.errors = [];
                var fields = {};

                axios.get(url).then(response => {
                    if (typeof(response.data.record.technical_support_request_repair) !== "undefined") {
                        fields = response.data.record.technical_support_request_repair;
                        vm.record = {
                            id: (fields !== null)
                                ? fields.technical_support_repair.id
                                : '',
                            state: (fields !== null)
                                ? fields.technical_support_repair.state
                                : '',
                            start_date: (fields !== null)
                                ? fields.technical_support_repair.start_date
                                : '',
                            end_date: (fields !== null)
                                ? fields.technical_support_repair.end_date
                                : '',
                            user_id: (fields !== null)
                                ? fields.technical_support_repair.user_id
                                : '',
                            technical_support_request_id: vm.id,
                        };
                    }
                    if ($("#" + modal_id).length) {
                        $("#" + modal_id).modal('show');
                    }
                }).catch(error => {
                    if (typeof(error.response) !== "undefined") {
                        if (error.response.status == 403) {
                            vm.showMessage(
                                'custom', 'Acceso Denegado', 'danger', 'screen-error', error.response.data.message
                            );
                        }
                        else {
                            vm.logs('resources/js/all.js', 343, error, 'initRecords');
                        }
                    }
                });
            },
        },
    }
</script>
