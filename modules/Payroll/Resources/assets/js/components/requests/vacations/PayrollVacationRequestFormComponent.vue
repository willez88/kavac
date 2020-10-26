<template>
    <section id="PayrollVacationRequestFormComponent">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title">Solicitud de vacaciones</h6>
                <div class="card-btns">
                    <a href="#" class="btn btn-sm btn-primary btn-custom" @click="redirect_back(route_list)"
                       title="Ir atrás" data-toggle="tooltip">
                        <i class="fa fa-reply"></i>
                    </a>
                    <a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar"
                       data-toggle="tooltip">
                        <i class="now-ui-icons arrows-1_minimal-up"></i>
                    </a>
                </div>
            </div>

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
                            <li v-for="error in errors">{{ error }}</li>
                        </ul>
                    </div>
                </div>
                <!-- ./mensajes de error -->
                <div class="row">
                    <!-- código de la solicitud -->
                    <div class="col-md-4">
                        <div class="form-group is-required">
                            <label>Código de la solicitud:</label>
                            <input type="text" readonly
                                   data-toggle="tooltip" title=""
                                   class="form-control input-sm">
                        </div>
                    </div>
                    <!-- ./código de la solicitud -->
                    <!-- fecha de la solicitud -->
                    <div class="col-md-4">
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
                    <div class="col-md-4">
                        <div class="form-group is-required">
                            <label>Trabajador:</label>
                            <select2 :options="payroll_staffs"
                                     @input="getPayrollStaffInfo()"
                                     v-model="record.payroll_staff_id">
                            </select2>
                        </div>
                    </div>
                    <!-- ./trabajador -->
                    <!-- días solicitudos -->
                    <div class="col-md-4">
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
                    <!-- año del período vacacional -->
                    <div class="col-md-4">
                        <div class="form-group is-required">
                            <label>Año del período vacacional:</label>
                            <select2 :options="vacation_period_years"
                                     v-model="record.vacation_period_year">
                            </select2>
                        </div>
                    </div>
                    <!-- ./año del período vacacional -->
                </div>
                <div class="row">
                    <!-- fecha de inicio de vacaciones -->
                    <div class="col-md-4">
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
                    <div class="col-md-4">
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
                <section class="row" v-if="payroll_staff['id'] > 0">
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
                        <div class="row">
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
                    </div>
                </section>
            </div>

            <div class="card-footer text-right">
                <button type="button" @click="reset()"
                        class="btn btn-default btn-icon btn-round" data-toggle="tooltip"
                        title="Borrar datos del formulario">
                    <i class="fa fa-eraser"></i>
                </button>
                <button type="button" @click="redirect_back(route_list)"
                        class="btn btn-warning btn-icon btn-round" data-toggle="tooltip"
                        title="Cancelar y regresar">
                    <i class="fa fa-ban"></i>
                </button>
                <button type="button" @click="createRecord('payroll/vacation-requests')"
                        class="btn btn-success btn-icon btn-round">
                    <i class="fa fa-save"></i>
                </button>
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
                    days_requested:       '',
                    vacation_period_year: '',
                    payroll_staff_id:     '',
                },

                errors:                [],
                records:               [],
                vacation_period_years: [],
                payroll_staffs:        [],
                payroll_staff:         {
                    id: '',
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
        created() {
            const vm = this;
            vm.reset();
        },
        mounted() {
            const vm = this;
            vm.getPayrollStaffs();
            if (!vm.payroll_id) {
                vm.record.created_at = vm.format_date(new Date(), 'YYYY-MM-DD');
            }
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
                    days_requested:       '',
                    vacation_period_year: '',
                    payroll_staff_id:     '',
                };
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
                    axios.get('/payroll/staffs/' + vm.record.payroll_staff_id).then(response => {
                        vm.payroll_staff = response.data.record;
                        axios.get('/payroll/get-vacation-policy').then(response => {
                            let vacation_policy = response.data.record;
                            let payroll_staff_date = vm.format_date(
                                vm.payroll_staff['payroll_employment_information']['start_date'],
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
                                    "text": i
                                });
                            }

                            document.getElementById('payroll_staff_first_name').innerText =
                                vm.payroll_staff['first_name']
                                    ? vm.payroll_staff['first_name']
                                    : 'No definido';
                            document.getElementById('payroll_staff_last_name').innerText =
                                vm.payroll_staff['last_name']
                                    ? vm.payroll_staff['last_name']
                                    : 'No definido';
                            document.getElementById('payroll_staff_start_date').innerText =
                                vm.payroll_staff['payroll_employment_information']
                                    ? vm.payroll_staff['payroll_employment_information']['start_date']
                                        ? vm.payroll_staff['payroll_employment_information']['start_date']
                                        : 'No definido'
                                    : 'No definido';
                            document.getElementById('payroll_staff_department').innerText =
                                vm.payroll_staff['payroll_employment_information']
                                    ? vm.payroll_staff['payroll_employment_information']['department']
                                        ? vm.payroll_staff['payroll_employment_information']['department']['name']
                                            ? vm.payroll_staff['payroll_employment_information']['department']['name']
                                            : 'No definido'
                                        : 'No definido'
                                    : 'No definido';
                            document.getElementById('payroll_staff_position').innerText =
                                vm.payroll_staff['payroll_employment_information']
                                    ? vm.payroll_staff['payroll_employment_information']['payroll_position']
                                        ? vm.payroll_staff['payroll_employment_information']['payroll_position']['name']
                                            ? vm.payroll_staff['payroll_employment_information']['payroll_position']['name']
                                            : 'No definido'
                                        : 'No definido'
                                    : 'No definido';

                            document.getElementById('vacation_days_to_antiquity').innerText = 
                                vacation_policy['additional_days_per_year'] && vacation_policy['vacation_days']
                                    ? (vacation_policy['additional_days_per_year'] * vm.vacation_period_years.length -1)
                                      + vacation_policy['vacation_days']
                                    : 'No definido';
                            document.getElementById('pending_days').innerText =
                                vacation_policy['additional_days_per_year'] && vacation_policy['vacation_days']
                                    ? (vacation_policy['additional_days_per_year'] * vm.vacation_period_years.length -1)
                                      + vacation_policy['vacation_days'] - vm.record['days_requested']
                                    : 'No definido';
                            vm.updatePendingDays();
                        });
                    });
                } else {
                    vm.payroll_staff = {
                        id: ''
                    };
                }
            },

            updatePendingDays() {
                const vm = this;
                let vacation_days_to_antiquity = document.getElementById('vacation_days_to_antiquity');
                if (vacation_days_to_antiquity) {
                    if (parseInt(vm.record['days_requested']) > parseInt(vacation_days_to_antiquity.innerText)) {
                        vm.record['days_requested'] = vacation_days_to_antiquity.innerText;
                    }
                    let pending_days = document.getElementById('pending_days');
                    if (pending_days) {
                        pending_days.innerText = vacation_days_to_antiquity.innerText -
                                                 vm.record['days_requested'];
                    }
                }
            }
        }
    };
</script>
