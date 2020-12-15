<template>
    <section id="payrollReviewVacationRequestPendingFormComponent">
        <a class="btn btn-default btn-xs btn-icon btn-action"
           href="#" title="Revisar solicitud" data-toggle="tooltip"
           @click="addRecord('view_review_vacation_request_pending' + id, route_show ,$event)">
           <i class="fa fa-filter"></i>
        </a>

        <div class="modal fade text-left" tabindex="-1" role="dialog" :id="'view_review_vacation_request_pending' + id">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h6>
                            Revisión de solicitud de vacaciones
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
                            <!-- código de la solicitud -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <strong>Código de la solicitud:</strong>
                                    <div class="row" style="margin: 1px 0">
                                        <span class="col-md-12" id="code">
                                            {{ record.code }}
                                        </span>
                                    </div>
                                    <input type="hidden" id="id">
                                </div>
                            </div>
                            <!-- ./código de la solicitud -->
                            <!-- fecha de la solicitud -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <strong>Fecha de la solicitud:</strong>
                                    <div class="row" style="margin: 1px 0">
                                        <span class="col-md-12" id="created_at">
                                            {{ record.created_at }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- ./fecha de la solicitud -->
                            <!-- trabajador -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <strong>Trabajador:</strong>
                                    <div class="row" style="margin: 1px 0">
                                        <span class="col-md-12" id="payroll_staff">
                                            {{
                                                record.payroll_staff
                                                ? record.payroll_staff.first_name + ' ' + record.payroll_staff.last_name
                                                : 'No definido'
                                            }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- ./trabajador -->
                            <!-- año del período vacacional -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <strong>Año del período vacacional:</strong>
                                    <div class="row" style="margin: 1px 0">
                                        <span class="col-md-12" id="vacation_period_year">
                                            {{ record.vacation_period_year }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- ./año del período vacacional -->
                            <!-- período -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <strong>Período:</strong>
                                    <div class="row" style="margin: 1px 0">
                                        <span class="col-md-12" id="days_requested">
                                            {{ record.start_date + ' - ' + record.end_date }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- ./período -->
                            <!-- días solicitudos -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <strong>Días solicitados:</strong>
                                    <div class="row" style="margin: 1px 0">
                                        <span class="col-md-12" id="days_requested">
                                            {{ record.days_requested }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- ./días solicitados -->
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group is-required">
                                    <label>Estatus de la solicitud</label>
                                    <select2 :options="status"
                                             @input="updateStatusParameters"
                                             v-model="record.status">
                                    </select2>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6" v-if="record.status == 'rejected'">
                                <div class="form-group is-required">
                                    <label>Motivo del rechazo</label>
                                    <ckeditor :editor="ckeditor.editor" id="motive" data-toggle="tooltip"
                                              title="Indique el motivo de la solicitud" :config="ckeditor.editorConfig"
                                              class="form-control" name="motive" tag-name="textarea" rows="3"
                                              v-model="record.status_parameters.motive">
                                    </ckeditor>
                                </div>
                            </div>
                            <div class="col-md-4" v-if="record.status == 'approved'">
                                <div class="form-group is required">
                                    <label>Fecha de reincorporación</label>
                                    <input type="date"
                                           data-toggle="tooltip"
                                           title="Fecha de reincorporación de trabajador"
                                           class="form-control input-sm" v-model="record.status_parameters.reincorporation_date">
                                </div>
                            </div>
                            <div class="col-md-4" v-if="record.status == 'approved'">
                                <div class="form-group is required">
                                    <label>Monto a pagar por concepto de bono vacacional</label>
                                    <input type="text"
                                           data-toggle="tooltip" title="Monto a pagar por concepto de bono vacacional"
                                           class="form-control input-sm"
                                           v-model="record.status_parameters.payment_amount"
                                           v-input-mask data-inputmask="
                                               'alias': 'numeric',
                                               'allowMinus': 'false'">
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm btn-round btn-modal-close"
                                data-dismiss="modal">
                            Cerrar
                        </button>
                        <button type="button" @click="updateRecord('/payroll/vacation-requests/review/')"
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
                    id:                   '',
                    code:                 '',
                    status:               '',
                    days_requested:       '',
                    vacation_period_year: '',
                    start_date:           '',
                    end_date:             '',
                    institution_id:       '',
                    payroll_staff_id:     '',
                    status_parameters:    ''
                },
                
                records: [],
                errors:  [],

                status: [
                    {"id":"pending","text":"Seleccione..."},
                    {"id":"approved","text":"Aprobado"},
                    {"id":"rejected","text":"Rechazado"}
                ],
            }
        },
        props: {
            id: {
                type:     Number,
                required: true
            },
        },
        methods: {
            /**
             * Método que borra todos los datos del formulario
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve>
             */
            reset() {
                const vm = this;
                vm.record = {
                    id:                   '',
                    code:                 '',
                    status:               '',
                    days_requested:       '',
                    vacation_period_year: '',
                    start_date:           '',
                    end_date:             '',
                    institution_id:       '',
                    payroll_staff_id:     '',
                    status_parameters:    ''
                };
            },
            /**
             * Reescribe el método initRecords para cambiar su comportamiento por defecto
             * Inicializa los registros base del formulario
             *
             * @author    Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             *
             * @param     {string}    url         Ruta que obtiene los datos a ser mostrado en listados
             * @param     {string}    modal_id    Identificador del modal a mostrar con la información solicitada
             */
            initRecords(url, modal_id) {
                const vm = this;
                vm.reset();
                url = (!url.includes('http://') || !url.includes('http://'))
                      ? `${window.app_url}${(url.startsWith('/'))?'':'/'}${url}` : url;

                axios.get(url).then(response => {
                    if (typeof(response.data.record) !== "undefined") {
                        let payrollVacationRequest = response.data.record;
                        vm.record = {
                            id:                   payrollVacationRequest['id'],
                            code:                 payrollVacationRequest['code'],
                            status:               payrollVacationRequest['status'],
                            days_requested:       payrollVacationRequest['days_requested'],
                            vacation_period_year: payrollVacationRequest['vacation_period_year'],
                            start_date:           payrollVacationRequest['start_date'],
                            end_date:             payrollVacationRequest['end_date'],
                            institution_id:       payrollVacationRequest['institution_id'],
                            payroll_staff_id:     payrollVacationRequest['payroll_staff_id'],
                            payroll_staff:        payrollVacationRequest['payroll_staff'],
                            status_parameters:    JSON.parse(payrollVacationRequest['status_parameters'])
                                                  ? JSON.parse(payrollVacationRequest['status_parameters'])
                                                  : {
                                                        reincorporation_date: '',
                                                        payment_amount:       '',
                                                        motive:               ''
                                                  },
                            created_at:           vm.format_date(payrollVacationRequest['created_at'], 'YYYY-MM-DD')
                        }
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
                            vm.logs('modules/payroll/resources/assets/js/components/requests/vacations/.js', 343, error, 'initRecords');
                        }
                    }
                });
            },
            updateStatusParameters() {
                const vm = this;
                vm.record.status_parameters = {
                    reincorporation_date: '',
                    payment_amount:       '',
                    motive:               ''
                };
            }
        },
    };
</script>
