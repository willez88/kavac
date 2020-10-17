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
                </div>
                <section class="row" v-if="payroll_staff['id'] > 0">
                    <hr>
                    <div class="col-md-12">
                        <h6 class="card-title"> Información general del trabajador </h6>
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
                    </div>
                </section>
                <div class="row">
                    <!-- días solicitudos -->
                    <div class="col-md-4">
                        <div class="form-group is-required">
                            <label>Días solicitados:</label>
                            <input type="text"
                                   data-toggle="tooltip" title="Indique la cantidad de días solicitados"
                                   class="form-control input-sm"
                                   v-input-mask data-inputmask="
                                        'alias': 'numeric',
                                        'allowMinus': 'false'"
                                   v-model="record.days">
                        </div>
                    </div>
                    <!-- ./días solicitados -->
                    <!-- año del período vacacional -->
                    <div class="col-md-4">
                        <div class="form-group is-required">
                            <label>Año del período vacacional:</label>
                            <select2 :options="vacation_period_years"></select2>
                        </div>
                    </div>
                    <!-- ./año del período vacacional -->

                </div>
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
                    id: '',
                    payroll_staff_id: '',
                },
                errors:  [],
                records: [],
                vacation_period_years: [],
                payroll_staffs: [],
                payroll_staff: {
                    id: '',
                }
            }
        },
        props: {
            id: {
                type: Number,
                required: false,
                default: ''
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
                    id: '',
                    payroll_staff_id: '',
                };
                vm.record.created_at = vm.format_date(new Date(), 'YYYY-MM-DD');
            },
            getPayrollStaffInfo() {
                const vm = this;
                if (vm.record.payroll_staff_id > 0) {
                    axios.get('/payroll/staffs/' + vm.record.payroll_staff_id).then(response => {
                        vm.payroll_staff = response.data.record;
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
                    });
                } else {
                    vm.payroll_staff = {
                        id: ''
                    };
                }
            }
        }
    };
</script>
