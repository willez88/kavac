<template>
    <section id="technicalSupportRequestInfo">
        <a class="btn btn-info btn-xs btn-icon btn-action" 
           href="#" title="Ver información de la reparación" data-toggle="tooltip" 
           @click="addRecord('view_repair_' + id, route_show, $event)">
            <i class="fa fa-info-circle"></i>
        </a>
        <div class="modal fade text-left" tabindex="-1" role="dialog" :id="'view_repair_' + id">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h6>
                            <i class="icofont icofont-read-book ico-2x"></i> 
                            Información de la Reparación Asignada
                        </h6>
                    </div>
                    
                    <div class="modal-body">
                        <div class="alert alert-danger" v-if="errors.length > 0">
                            <ul>
                                <li v-for="error in errors">{{ error }}</li>
                            </ul>
                        </div>
                        <ul class="nav nav-tabs custom-tabs justify-content-center" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" :href="'#general_' + id" :id="'info_general_' + id" role="tab">
                                    <i class="ion-android-person"></i> Información General
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" :href="'#equipment_' + id" role="tab">
                                    <i class="ion-arrow-swap"></i> Información del Equipo
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" :id="'general_' + id" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong>Fecha de Inicio</strong>
                                            <div class="row" style="margin: 1px 0">
                                                <span class="col-md-12">
                                                    {{ 
                                                        record.start_date
                                                        ? record.start_date
                                                        : 'No definido'
                                                    }}
                                                </span>
                                            </div>
                                            <input type="hidden" id="id">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong>Fecha tope de entrega</strong>
                                            <div class="row" style="margin: 1px 0">
                                                <span class="col-md-12">
                                                    {{
                                                        record.end_date
                                                        ? record.end_date
                                                        : 'No definido'
                                                    }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong>Estado de la Solicitud</strong>
                                            <div class="row" style="margin: 1px 0">
                                                <span class="col-md-12">
                                                    {{
                                                        record.state
                                                        ? record.state
                                                        : 'N/A'
                                                    }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong>Responsable</strong>
                                            <div class="row" style="margin: 1px 0">
                                                <span class="col-md-12">
                                                    {{
                                                        record.user
                                                        ? (record.user.profile
                                                            ? (record.user.profile.first_name
                                                                ? (record.user.profile.last_name
                                                                    ? (record.user.profile.first_name
                                                                      + ' ' 
                                                                      + record.user.profile.last_name)
                                                                    : record.user.profile.first_name)
                                                                : (record.user.name
                                                                    ? record.user.name
                                                                    : '' ))
                                                            : '')
                                                        : 'N/A'
                                                    }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" :id="'equipment_' + id" role="tabpanel">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm btn-round btn-modal-close" 
                                data-dismiss="modal">
                            Cerrar
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
                    end_date: '',
                    start_date: ''
                },

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
            //
        },
        methods: {
            /**
             * Método que borra todos los datos del formulario
             * 
             * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
             */
            reset() {
                const vm  = this;
                
                vm.errors = [];
                vm.record = {
                    id: '',
                    state: '',
                    end_date: '',
                    start_date: ''
                };
            },

            /**
             * Inicializa los registros base del formulario
             *
             * @author Henry Paredes <hparedes@cenditel.gob.ve>
             */
            initRecords(url,modal_id) {
                const vm = this;

                vm.reset();
                document.getElementById(`info_general_${vm.id}`).click();

                axios.get(url).then(response => {
                    if (typeof(response.data.record) !== "undefined") {
                        vm.record = response.data.record;
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
            }
        },
    }
</script>
