<template>
    <section id="PayrollVacationRequestForm">
        <div class="card-body">
            <!-- mensajes de error -->
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
            <!-- ./mensajes de error -->
            <div class="row">
                <!-- código de la solicitud -->
                <div class="col-md-4" v-if="id > 0" id="helpPayrollVacationRequestCode">
                    <div class="form-group is-required">
                        <label>Código de la solicitud:</label>
                        <input type="text" readonly
                               data-toggle="tooltip" title=""
                               class="form-control input-sm"
                               v-model="record.code">
                    </div>
                </div>
                <!-- ./código de la solicitud -->
                <!-- fecha de la solicitud -->
                <div class="col-md-4" id="helpPayrollVacationRequestDate">
                    <div class="form-group is-required">
                        <label>Fecha de la solicitud:</label>
                        <input type="date" readonly
                               data-toggle="tooltip"
                               title="Fecha de generación de la solicitud"
                               class="form-control input-sm" v-model="record.created_at">
                        <input type="hidden" v-model="record.id">
                    </div>
                </div>
                <!-- ./fecha de la solicitud -->
                <!-- trabajador -->
                <div class="col-md-4" id="helpPayrollVacationRequestStaff">
                    <div class="form-group is-required">
                        <label>Trabajador:</label>
                        <select2 :options="payroll_staffs"
                                 @input="getPayrollStaffInfo()"
                                 v-model="record.payroll_staff_id">
                        </select2>
                    </div>
                </div>
                <!-- ./trabajador -->
                <!-- año del período vacacional -->
                <div class="col-md-4" id="helpPayrollVacationPeriodYear">
                    <div class="form-group is-required">
                        <label>Año del período vacacional:</label>
                        <select2 :options="vacation_period_years"
                                 @input="getPayrollVacationPeriods()"
                                 v-model="record.vacation_period_year">
                        </select2>
                    </div>
                </div>
                <!-- ./año del período vacacional -->
                <!-- días solicitudos -->
                <div class="col-md-4" v-if="record.vacation_period_year > 0" id="helpPayrollVacationDaysRequested">
                    <div class="form-group is-required">
                        <label>Días solicitados:</label>
                        <input type="text"
                               data-toggle="tooltip" title="Indique la cantidad de días solicitados"
                               @input="updatePendingDays()"
                               class="form-control input-sm"
                               v-input-mask data-inputmask="
                                    'alias': 'numeric',
                                    'allowMinus': 'false',
                                    'digits': 0"
                               v-model="record.days_requested">
                    </div>
                </div>
                <!-- ./días solicitados -->
            </div>
            <div class="row">
                <!-- fecha de inicio de vacaciones -->
                <div class="col-md-4" id="helpPayrollVacationStartDate">
                    <div class="form-group is-required">
                        <label>Fecha de inicio de vacaciones:</label>
                        <input type="date"
                               data-toggle="tooltip"
                               title="Fecha de inicio de vacaciones"
                               class="form-control input-sm" v-model="record.start_date">
                    </div>
                </div>
                <!-- ./fecha de inicio de vacaciones -->
                <!-- fecha de culminación de vacaciones -->
                <div class="col-md-4" id="helpPayrollVacationEndDate">
                    <div class="form-group is-required">
                        <label>Fecha de culminación de vacaciones:</label>
                        <input type="date"
                               data-toggle="tooltip"
                               title="Fecha de culminación de vacaciones"
                               class="form-control input-sm" v-model="record.end_date">
                    </div>
                </div>
                <!-- ./fecha de culminación de vacaciones -->
            </div>
            <section class="row" v-show="payroll_staff['id'] > 0">
                <div class="col-md-12">
                    <h6 class="card-title"> Información del trabajador </h6>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong> Nombres: </strong>
                                <div class="row" style="margin: 1px 0">
                                    <span class="col-md-12" id="payroll_staff_first_name"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Apellidos:</strong>
                                <div class="row" style="margin: 1px 0">
                                    <span class="col-md-12" id="payroll_staff_last_name"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Fecha de ingreso:</strong>
                                <div class="row" style="margin: 1px 0">
                                    <span class="col-md-12" id="payroll_staff_start_date"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Cargo:</strong>
                                <div class="row" style="margin: 1px 0">
                                    <span class="col-md-12" id="payroll_staff_position"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Dependencia:</strong>
                                <div class="row" style="margin: 1px 0">
                                    <span class="col-md-12" id="payroll_staff_department"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row"  v-show="record.vacation_period_year > 0">
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Días de disfrute según antigüedad:</strong>
                                <div class="row" style="margin: 1px 0">
                                    <span class="col-md-12" id="vacation_days_to_antiquity"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Días pendientes:</strong>
                                <div class="row" style="margin: 1px 0">
                                    <span class="col-md-12" id="pending_days"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 with-border with-radius" :key="vacation_request_for_period['period']"
                             v-for="vacation_request_for_period in vacation_request_for_periods">
                            <div class="form-group">
                                <strong> Período: </strong>
                                <div class="row" style="margin: 1px 0">
                                    <span class="col-md-12"> {{ vacation_request_for_period['period'] }} </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <strong> Días Solicitados: </strong>
                                <div class="row" style="margin: 1px 0">
                                    <span class="col-md-12"> {{ vacation_request_for_period['days_requested'] }} </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <div class="card-footer text-right" id="helpParamButtons">
            <button type="button" @click="reset()"
                    class="btn btn-default btn-icon btn-round" data-toggle="tooltip"
                    title="Borrar datos del formulario" v-has-tooltip>
                <i class="fa fa-eraser"></i>
            </button>
            <button type="button" @click="redirect_back(route_list)"
                    class="btn btn-warning btn-icon btn-round" data-toggle="tooltip"
                    title="Cancelar y regresar" v-has-tooltip>
                <i class="fa fa-ban"></i>
            </button>
            <button type="button" @click="createRecord('payroll/vacation-requests')"
                    class="btn btn-success btn-icon btn-round" data-toggle="tooltip"
                    title="Guardar registro" v-has-tooltip>
                <i class="fa fa-save"></i>
            </button>
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
                    payroll_staff_id:     ''
                },

                errors:                       [],
                records:                      [],
                vacation_period_years:        [],
                payroll_staffs:               [],
                payroll_vacation_requests:    [],
                vacation_request_for_periods: [],
                payroll_vacation_policy:      {},
                payroll_staff:                {
                    id:                        '',
                    code:                      '',
                    first_name:                '',
                    last_name:                 '',
                    payroll_nationality_id:    '',
                    id_number:                 '',
                    passport:                  '',
                    email:                     '',
                    birthdate:                 '',
                    payroll_gender_id:         '',
                    emergency_contact:         '',
                    emergency_phone:           '',
                    parish_id:                 '',
                    address:                   '',
                    has_disability:            '',
                    disability:                '',
                    social_security:           '',
                    has_driver_license:        '',
                    payroll_license_degree_id: '',
                    payroll_blood_type_id:     ''
                }
            }
        },
        props: {
            id: {
                type:     Number,
                required: false,
                default:  ''
            }
        },
        mounted() {
            const vm = this;
            vm.getPayrollStaffs();
            vm.getPayrollVacationPolicy();
            if (vm.id > 0) {
                vm.showRecord(vm.id);
            } else {
                vm.record.created_at = vm.format_date(new Date(), 'YYYY-MM-DD');
            }
        },
        created() {
            const vm = this;
            vm.reset();
        },
        methods: {
            /**
             * Método que permite borrar todos los datos del formulario
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve>
             */
            reset() {
                const vm  = this;
                vm.record = {
                    id:                   '',
                    code:                 '',
                    status:               '',
                    days_requested:       '',
                    vacation_period_year: '',
                    start_date:           '',
                    end_date:             '',
                    institution_id:       '',
                    payroll_staff_id:     ''
                };
                vm.payroll_vacation_requests    = [];
                vm.vacation_request_for_periods = [];
                vm.record.created_at = vm.format_date(new Date(), 'YYYY-MM-DD');
            },
            /**
             * Método que obtiene la información del trabajador
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve>
             */
            getPayrollStaffInfo() {
                const vm = this;
                if (vm.record.payroll_staff_id > 0) {
                    axios.get(`${window.app_url}/payroll/staffs/${vm.record.payroll_staff_id}`).then(response => {
                        vm.payroll_staff = response.data.record;
                        axios.get(
                            `${window.app_url}/payroll/get-vacation-requests/${vm.record.payroll_staff_id}`
                        ).then(response => {
                            /**
                             * Extraer dias solicitados
                             * Número de periodos por año
                             * 
                             * Calcular según politica vacacional:
                             * periodos validos
                             * dias pendiente por periodo
                             * dias acumulados
                             */
                            vm.payroll_vacation_requests = response.data.records;
                            
                            let payroll_staff_date = vm.format_date(
                                vm.payroll_staff['payroll_employment']['start_date'],
                                'YYYY-MM-DD'
                            );
                            let payroll_staff_year = payroll_staff_date.split('-')[0];
                            let year_now = new Date().getFullYear();
                            
                            vm.vacation_period_years = [];
                            vm.vacation_period_years.push({
                                "id":   "",
                                "text": "Seleccione..."
                            });
                            for (var i = parseInt(payroll_staff_year); i <= year_now; i++) {
                                vm.vacation_period_years.push({
                                    "id":   i,
                                    "text": i,
                                    "yearId": i - parseInt(payroll_staff_year)
                                });
                            };

                            document.getElementById('payroll_staff_first_name').innerText =
                                vm.payroll_staff['first_name']
                                    ? vm.payroll_staff['first_name']
                                    : 'No definido';
                            document.getElementById('payroll_staff_last_name').innerText =
                                vm.payroll_staff['last_name']
                                    ? vm.payroll_staff['last_name']
                                    : 'No definido';
                            document.getElementById('payroll_staff_start_date').innerText =
                                vm.payroll_staff['payroll_employment']
                                    ? vm.payroll_staff['payroll_employment']['start_date']
                                        ? vm.payroll_staff['payroll_employment']['start_date']
                                        : 'No definido'
                                    : 'No definido';
                            document.getElementById('payroll_staff_department').innerText =
                                vm.payroll_staff['payroll_employment']
                                    ? vm.payroll_staff['payroll_employment']['department']
                                        ? vm.payroll_staff['payroll_employment']['department']['name']
                                            ? vm.payroll_staff['payroll_employment']['department']['name']
                                            : 'No definido'
                                        : 'No definido'
                                    : 'No definido';
                            document.getElementById('payroll_staff_position').innerText =
                                vm.payroll_staff['payroll_employment']
                                    ? vm.payroll_staff['payroll_employment']['payroll_position']
                                        ? vm.payroll_staff['payroll_employment']['payroll_position']['name']
                                            ? vm.payroll_staff['payroll_employment']['payroll_position']['name']
                                            : 'No definido'
                                        : 'No definido'
                                    : 'No definido';
                        });
                    });
                }
            },
            updatePendingDays() {
                const vm = this;
                let vacation_days_to_antiquity = document.getElementById('vacation_days_to_antiquity');
                if (vacation_days_to_antiquity) {
                    let pending_days = document.getElementById('pending_days');
                    if (pending_days) {
                        if (parseInt(vm.record['days_requested']) > parseInt(pending_days.innerText)) {
                            vm.record['days_requested'] = parseInt(pending_days.innerText);
                        }
                    }
                }
            },
            getPayrollVacationPolicy() {
                const vm = this;
                axios.get(`${window.app_url}/payroll/get-vacation-policy`).then(response => {
                    vm.payroll_vacation_policy = response.data.record;
                });
            },
            getPayrollVacationPeriods() {
                const vm = this;
                vm.vacation_request_for_periods = [];
                let days_requested = 0;
                let year = 0;
                if (vm.record.vacation_period_year > 0) {
                    $.each(vm.payroll_vacation_requests, function(index, field) {
                        if ((vm.record.vacation_period_year == field['vacation_period_year']) &&
                            (vm.record.id != field['id']) ) {
                            days_requested += field['days_requested'];
                            vm.vacation_request_for_periods.push({
                                period: field['start_date'] + ' - ' + field['end_date'],
                                days_requested: field['days_requested']
                            })
                        }
                    });
                    $.each(vm.vacation_period_years, function(index, field) {
                        if (field['id'] == vm.record.vacation_period_year) {
                            year = field['yearId'];
                        }
                    });

                    document.getElementById('vacation_days_to_antiquity').innerText = 
                        vm.payroll_vacation_policy['additional_days_per_year'] && vm.payroll_vacation_policy['vacation_days']
                            ? (vm.payroll_vacation_policy['additional_days_per_year'] * year) + vm.payroll_vacation_policy['vacation_days']
                            : 'No definido';
                    document.getElementById('pending_days').innerText =
                        vm.payroll_vacation_policy['additional_days_per_year'] && vm.payroll_vacation_policy['vacation_days']
                            ? (vm.payroll_vacation_policy['additional_days_per_year'] * year) + vm.payroll_vacation_policy['vacation_days'] - days_requested
                            : 'No definido';
                    vm.updatePendingDays();
                }
            },
            /**
             * Reescribe el método showRecord para cambiar su comportamiento por defecto
             * Método que muestra datos de un registro seleccionado
             *
             * @author    Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             *
             * @param    {integer}    id    Identificador del registro a mostrar
             */
            async showRecord(id) {
                const vm = this;
                await axios.get(`${window.app_url}/payroll/vacation-requests/show/${id}`).then(response => {
                    vm.record = response.data.record;
                    vm.record.created_at = vm.format_date(response.data.record.created_at, 'YYYY-MM-DD');
                });
            },

        }
    };
</script>
