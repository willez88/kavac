<template>
    <section id="PayrollReportEmploymentStatusForm">
        <div class="card-body">
            <div class="alert alert-danger" v-if="errors.length > 0">
                <ul>
                    <li v-for="error in errors" :key="error">{{ error }}</li>
                </ul>
            </div>
       <div class="row">
                <div class="col-md-12">
                    <strong>Filtros</strong>
                </div>
        
                <!-- trabajador -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Trabajador:</label>
                        <select2 :options="payroll_staffs"
                                 v-model="record.payroll_staff_id">
                        </select2>
                    </div>
                </div>
           
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button type="button"
                            class='btn btn-sm btn-info float-right'
                            title="Buscar registro" data-toggle="tooltip"
                            @click="searchRecords('employment-status')">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
            <hr>


            <v-client-table :columns="columns" :data="records" :options="table_options">
                <div slot="payroll_staff" slot-scope="props">
                    <span>
                        {{
                            props.row.payroll_staff
                                ? props.row.payroll_staff.first_name + ' ' + props.row.payroll_staff.last_name
                                : 'No definido'
                        }}
                    </span>
                </div>
          
                 <div slot="active" slot-scope="props" class="text-center">
                    <span v-if="props.row.active">SI</span>
                    <span v-else>NO</span>
                </div>
         
                <div slot="id" slot-scope="props" class="text-center">
                    <button @click="show_info(props.row.id)" v-if="route_show"
                        class="btn btn-info btn-xs btn-icon btn-action btn-tooltip"
                        title="Ver registro" data-toggle="tooltip" data-placement="bottom" type="button">
                        <i class="fa fa-eye"></i>
                     </button>


                    <button @click="createReport(props.row.id, 'employment-status', $event)" 
                            class="btn btn-primary btn-xs btn-icon btn-action" 
                            title="Generar reporte" data-toggle="tooltip" 
                            type="button">
                        <i class="fa fa-file-pdf-o"></i>
                    </button>
                </div>
            </v-client-table>
            <div class="modal fade" tabindex="-1" role="dialog" id="show_employment">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h6>
                            <i class="icofont icofont-read-book ico-2x"></i>
                            Información Detallada de Datos Laborales y Personales
                        </h6>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Trabajador</label>
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="payroll_staff">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Fecha de ingreso a la administración pública</label>
                                    <input type="date" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="start_date_apn">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Fecha de ingreso a la institución</label>
                                    <input type="date" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="start_date">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Fecha de egreso de la institución</label>
                                    <input type="date" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="end_date">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>¿Está Activo?</label>
                                    <div class="col-12 bootstrap-switch-mini">
                                        <input id="active" class="form-control bootstrap-switch"
                                            data-on-label="SI" data-off-label="NO" type="checkbox">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4" v-if="!record.active">
                                <div class="form-group">
                                    <label>Tipo de la Inactividad</label>
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="payroll_inactivity_type">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Correo Institucional</label>
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="institution_email">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Descripción de las Funciones</label>
                                    <ckeditor :editor="ckeditor.editor" id="function_description" data-toggle="tooltip"
                                              :disabled="true" :config="ckeditor.editorConfig" class="form-control"
                                              name="function_description" tag-name="textarea" rows="3"></ckeditor>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tipo de Cargo</label>
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="payroll_position_type">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Cargo</label>
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="payroll_position">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tipo de Personal</label>
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="payroll_staff_type">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tipo de Contrato</label>
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="payroll_contract_type">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Institución</label>
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="institution">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Departamento</label>
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="department">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Género</label>
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="payroll_gender">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>¿Posee una Discapacidad?</label>
                                    <div class="col-12 bootstrap-switch-mini">
                                        <input id="has_disability" class="form-control bootstrap-switch"
                                               data-on-label="SI" data-off-label="NO" type="checkbox"
                                               :value="record.has_disability">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4" v-if="record.has_disability">
                                <div class="form-group">
                                    <label>Discapacidad</label>
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="payroll_disability">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tipo de Sangre</label>
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="payroll_blood_type">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Seguro Social</label>
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="social_security">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>¿Posee Licencia de Conducir?</label>
                                    <div class="col-12 bootstrap-switch-mini">
                                        <input id="has_driver_license" class="form-control bootstrap-switch"
                                               data-on-label="SI" data-off-label="NO" type="checkbox"
                                               :value="record.has_driver_license">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4" v-show="record.has_driver_license">
                                <div class="form-group">
                                    <label>Grado de la Licencia de Conducir</label>
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="payroll_license_degree">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Nacionalidad</label>
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="payroll_nationality">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Edad</label>
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="age">
                                </div>
                            </div>
                           
                        </div>
                    </div>
                </div>
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
                    current:          '',
                    id_number:       '',
                    institution_email:         '',
                    active: '',
                    payroll_staff_id: ''
                },
                
                errors:         [],
                records:        [],
                payroll_staffs: [],
                columns: ['payroll_staff','payroll_staff.id_number', 'institution_email','active', 'id'],
            }
        },
        methods: {
            reset() {
                const vm = this;
                vm.record = {
                    id:               '',
                    current:          '',
                    id_number:       '',
                    institution_email:         '',
                    active: '',
                    payroll_staff_id: ''
                }
            },


            show_info(id) {
                const vm = this;
                axios.get(`${window.app_url}/payroll/employments/${id}`).then(response => {
                    vm.record = response.data.record;
                    $('#payroll_staff').val(`${vm.record.payroll_staff.first_name} ${vm.record.payroll_staff.last_name}`);
                    $('#start_date_apn').val(vm.record.start_date_apn);
                    $('#start_date').val(vm.record.start_date);
                    $('#end_date').val(vm.record.end_date);
                    $('#active').bootstrapSwitch('state', (vm.record.active)?true:false);
                    $('#payroll_inactivity_type').val(
                        (vm.record.payroll_inactivity_type) ? vm.record.payroll_inactivity_type.name : ' '
                    );
                    $('#institution_email').val(vm.record.institution_email);
                    $('#function_description').val(vm.record.function_description);
                    $('#payroll_position_type').val(vm.record.payroll_position_type.name);
                    $('#payroll_position').val(vm.record.payroll_position.name);
                    $('#payroll_staff_type').val(vm.record.payroll_staff_type.name);
                    $('#institution').val(vm.record.department.institution.name);
                    $('#department').val(vm.record.department.name);
                    $('#payroll_contract_type').val(vm.record.payroll_contract_type.name);
                    $('#payroll_gender').val(vm.record.payroll_staff.payroll_gender.name);
                    $('#has_disability').bootstrapSwitch('state', (vm.record.payroll_staff.has_disability)?true:false);
                    $('#payroll_disability').val(
                        (vm.record.payroll_staff.payroll_disability) 
                        ? vm.record.payroll_staff.payroll_disability.name 
                        : ' '
                    );
                    $('#payroll_blood_type').val(vm.record.payroll_staff.payroll_blood_type.name);
                    $('#social_security').val(vm.record.payroll_staff.social_security);
                    $('#has_driver_license').bootstrapSwitch(
                        'state', (vm.record.payroll_staff.has_driver_license)?true:false
                    );
                    $('#payroll_license_degree').val(
                        (vm.record.payroll_staff.payroll_license_degree) 
                        ? vm.record.payroll_staff.payroll_license_degree.name 
                        : ' '
                    );
                     $('#payroll_nationality').val(vm.record.payroll_staff.payroll_nationality.name);
                     $('#birthdate').val(vm.record.payroll_staff.birthdate);
                     $('#age').val(response.data.age);
                });
                $('#show_employment').modal('show');
            },

            createReport(id, current, event) {
                const vm = this;
                vm.loading = true;
                let fields = {
                    id:      id,
                    current: current
                };
                event.preventDefault();
                axios.post(`${window.app_url}/payroll/reports/${current}/create`, fields).then(response => {
                    if (typeof(response.data.redirect) !== "undefined") {
                        window.open(response.data.redirect, '_blank');
                    }
                    else {
                        vm.reset();
                    }
                    vm.loading = false;
                }).catch(error => {
                    if (typeof(error.response) != "undefined") {
                        console.log("error");
                    }
                    vm.loading = false;
                });
            },

            /**
             * Método que permite realizar las busquedas y filtrado de los registros de la tabla
             *
             * @method    searchRecords
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve> | <henryp2804@gmail.com>
             */
            searchRecords(current) {
                const vm = this;
                vm.record.current = current;
                vm.loading = true;
                let fields = {};

                for (var index in vm.record) {
                    fields[index] = vm.record[index];
                }
                axios.post(`${window.app_url}/payroll/reports/vue-list`, fields).then(response => {
                    if (typeof(response.data.records) !== "undefined") {
                        vm.records = response.data.records;
                    }
                    vm.loading = false;
                }).catch(error => {
                    vm.errors = [];

                    if (typeof(error.response) !="undefined") {
                        for (var index in error.response.data.errors) {
                            if (error.response.data.errors[index]) {
                                vm.errors.push(error.response.data.errors[index][0]);
                            }
                        }
                    }
                    vm.loading = false;
                });
            }
        },
        created() {
            const vm = this;
            vm.table_options.headings = {
                'payroll_staff': 'Trabajador',
                'payroll_staff.id_number': 'Cedula',
                'institution_email': 'Correo Electrónico Institucional',
                'active': '¿Está activo?',
                'id': 'Acción'
            };
            vm.table_options.sortable   = [
               'payroll_staff.first_name', 'payroll_staff.id_number','institution_email','active'
            ];
            vm.table_options.filterable = [
               'payroll_staff.first_name', 'payroll_staff.id_number','institution_email','active'];
        },
        mounted() {
            const vm = this;
            vm.getPayrollStaffs();
            vm.initRecords(vm.route_list, '');
        }

    };
</script>
