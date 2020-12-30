<template>
    <section id="payrollBenefitsPoliciesFormComponent">
        <a class="btn-simplex btn-simplex-md btn-simplex-primary" href=""
           title="Registros de políticas de prestaciones" data-toggle="tooltip"
           @click="addRecord('add_payroll_benefits_policy', 'payroll/benefits-policies', $event)">
           <i class="icofont icofont-unity-hand ico-3x"></i>
           <span>Políticas de<br>Prestaciones</span>
        </a>
        <div class="modal fade text-left" tabindex="-1" role="dialog" id="add_payroll_benefits_policy">
            <div class="modal-dialog vue-crud" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h6>
                            <i class="icofont icofont-unity-hand ico-3x"></i>
                            Política de prestaciones sociales
                        </h6>
                    </div>
                    <div class="modal-body">
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
                        <div class="wizard-tabs with-border">
                            <ul class="nav wizard-steps"
                                v-if="panel == 'benefitsPolicyForm'">
                                <li class="nav-item active">
                                    <a href="#w-benefitsPolicyForm" data-toggle="tab"
                                       class="nav-link text-center" id="benefitsPolicyForm"
                                       @click="changePanel('benefitsPolicyForm')">
                                        <span class="badge">1</span>
                                        Definir Política de Prestaciones Sociales
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a :href="isDisableNext()?'#':'#w-benefitsPaymentForm'" data-toggle="tab"
                                       class="nav-link text-center" id="benefitsPaymentForm"
                                       @click="changePanel('benefitsPaymentForm')">
                                        <span class="badge">2</span>
                                        Definir Pago de Prestaciones Sociales
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav wizard-steps"
                                v-else>
                                <li class="nav-item">
                                    <a href="#w-benefitsPolicyForm" data-toggle="tab"
                                       class="nav-link text-center" id="benefitsPolicyForm"
                                       @click="changePanel('benefitsPolicyForm')">
                                        <span class="badge">1</span>
                                        Definir Política de Prestaciones Sociales
                                    </a>
                                </li>
                                <li class="nav-item active">
                                    <a href="#w-benefitsPaymentForm" data-toggle="tab"
                                       class="nav-link text-center" id="benefitsPaymentForm"
                                       @click="changePanel('benefitsPaymentForm')">
                                        <span class="badge">2</span>
                                        Definir Pago de Prestaciones Sociales
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <form class="form-horizontal">
                            <div class="tab-content">
                                <div id="w-benefitsPolicyForm" class="tab-pane p-3 active">
                                    <div class="row">
                                        <!-- nombre -->
                                        <div class="col-md-6">
                                            <div class="form-group is-required">
                                                <label>Nombre:</label>
                                                <input type="text" class="form-control input-sm"
                                                       placeholder="Nombre de política de prestaciones" data-toggle="tooltip"
                                                       title="Indique el nombre de la política de prestaciones sociales (requerido)"
                                                       v-model="record.name">
                                                <input type="hidden" v-model="record.id">
                                            </div>
                                        </div>
                                        <!-- ./nombre -->
                                        <!-- fecha de aplicación -->
                                        <div class="col-md-3">
                                            <div class="form-group is-required">
                                                <label>Desde:</label>
                                                <input type="date" id="start_date" placeholder="Desde"
                                                       data-toggle="tooltip" title="Indique la fecha de aplicación asociada a la política de prestaciones"
                                                       class="form-control input-sm" v-model="record.start_date">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Hasta:</label>
                                                <input type="date" id="end_date" placeholder="Hasta"
                                                       data-toggle="tooltip" title="Indique la fecha de aplicación asociada a la política de prestaciones"
                                                       class="form-control input-sm" v-model="record.end_date">
                                            </div>
                                        </div>
                                        <!-- ./fecha de aplicación -->
                                        <!-- activa -->
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>¿Activo?</label>
                                                <div class="col-12">
                                                    <p-check class="pretty p-switch p-fill p-bigger"
                                                             color="success" off-color="text-gray" toggle
                                                             data-toggle="tooltip"
                                                             title="¿La política de prestaciones se encuentra activa actualmente?"
                                                             v-model="record.active">
                                                        <label slot="off-label"></label>
                                                    </p-check>
                                                  </div>
                                            </div>
                                        </div>
                                        <!-- ./activa -->
                                        <!-- institución -->
                                        <div class="col-md-4">
                                            <div class="form-group is-required">
                                                <label>Institución:</label>
                                                <select2 :options="institutions" v-model="record.institution_id"></select2>
                                            </div>
                                        </div>
                                        <!-- ./institución -->
                                    </div>
                                    <div class="row" style="align-items: baseline;">
                                        <!-- días a cancelar por garantías de prestaciones sociales -->
                                        <div class="col-md-3">
                                            <div class="form-group is-required">
                                                <label>Días a cancelar por garantías de prestaciones sociales:</label>
                                                <input type="text" data-toggle="tooltip"
                                                       title="Indique la cantidad de días a otorgar para el pago de prestaciones"
                                                       class="form-control input-sm"
                                                       v-input-mask data-inputmask="
                                                            'alias': 'numeric',
                                                            'allowMinus': 'false',
                                                            'digits': 0"
                                                       v-model="record.benefit_days">
                                            </div>
                                        </div>
                                        <!-- ./días a cancelar por garantías de prestaciones sociales -->
                                        <!-- a partir del mes -->
                                        <div class="col-md-3">
                                            <div class="form-group is-required">
                                                <label>A partir del mes:</label>
                                                <input type="text" data-toggle="tooltip"
                                                       title="Indique la cantidad de meses necesarios para el pago de prestaciones"
                                                       class="form-control input-sm"
                                                       v-input-mask data-inputmask="
                                                            'alias': 'numeric',
                                                            'allowMinus': 'false',
                                                            'digits': 0"
                                                       v-model="record.minimum_number_months">
                                            </div>
                                        </div>
                                        <!-- ./a partir del mes -->
                                        <!-- días adicionales a otorgar por años de servicio -->
                                        <div class="col-md-3">
                                            <div class="form-group is-required">
                                                <label>Días adicionales a otorgar por año de servicio:</label>
                                                <input type="text" data-toggle="tooltip"
                                                       title="Indique la cantidad de días adicionales a otorgar por año de servicio"
                                                       class="form-control input-sm"
                                                       v-input-mask data-inputmask="
                                                            'alias': 'numeric',
                                                            'allowMinus': 'false',
                                                            'digits': 0"
                                                       v-model="record.additional_days_per_year">
                                            </div>
                                        </div>
                                        <!-- ./días adicionales a otorgar por años de servicio para el disfrute de vacaciones -->
                                        <!-- a partir del año -->
                                        <div class="col-md-3">
                                            <div class="form-group is-required">
                                                <label>A partir del año:</label>
                                                <input type="text" data-toggle="tooltip"
                                                       title="Indique la cantidad de años necesarios para agregar los días adicionales por año de servicio al pago de prestaciones"
                                                       class="form-control input-sm"
                                                       v-input-mask data-inputmask="
                                                            'alias': 'numeric',
                                                            'allowMinus': 'false',
                                                            'digits': 0"
                                                       v-model="record.minimum_number_years">
                                            </div>
                                        </div>
                                        <!-- ./a partir del año -->
                                        <!-- días adicionales máximos a otorgar por años de servicio -->
                                        <div class="col-md-3">
                                            <div class="form-group is-required">
                                                <label>Máximo de días adicionales a otorgar por año de servicio:</label>
                                                <input type="text" data-toggle="tooltip"
                                                       title="Indique la cantidad máxima de días adicionales a otorgar por año de servicio"
                                                       class="form-control input-sm"
                                                       v-input-mask data-inputmask="
                                                            'alias': 'numeric',
                                                            'allowMinus': 'false',
                                                            'digits': 0"
                                                       v-model="record.additional_maximum_days_per_year">
                                            </div>
                                        </div>
                                        <!-- ./días adicionales a otorgar por años de servicio para el disfrute de vacaciones -->
                                        <!-- días a cancelar por años de servicio ó fracción superior a seis meses, por interrupción de relación laboral -->
                                        <div class="col-md-3">
                                            <div class="form-group is-required">
                                                <label>Días a cancelar por interrupción de relación laboral:</label>
                                                <input type="text" data-toggle="tooltip"
                                                       title="Indique la cantidad de días a cancelar por años de servicio ó fracción superior a seis meses, por interrupción de relación laboral"
                                                       class="form-control input-sm"
                                                       v-input-mask data-inputmask="
                                                            'alias': 'numeric',
                                                            'allowMinus': 'false',
                                                            'digits': 0"
                                                       v-model="record.work_interruption_days">
                                            </div>
                                        </div>
                                        <!-- ./días a cancelar por años de servicio ó fracción superior a seis meses, por interrupción de relación laboral -->
                                        <!-- días a cancelar por mes trabajado -->
                                        <div class="col-md-3">
                                            <div class="form-group is-required">
                                                <label>Días a cancelar por mes trabajado:</label>
                                                <input type="text" data-toggle="tooltip"
                                                       title="Indique la cantidad de días a cancelar por mes trabajado"
                                                       class="form-control input-sm"
                                                       v-input-mask data-inputmask="
                                                            'alias': 'numeric',
                                                            'allowMinus': 'false',
                                                            'digits': 0"
                                                       v-model="record.month_worked_days">
                                            </div>
                                        </div>
                                        <!-- ./días a cancelar por mes trabajado -->
                                        <!-- anticipo de prestaciones -->
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>¿Permitir anticipo de prestaciones?</label>
                                                <div class="col-12">
                                                    <p-check class="pretty p-switch p-fill p-bigger"
                                                             color="success" off-color="text-gray" toggle
                                                             data-toggle="tooltip"
                                                             title="Indique si se habilita la solicitud de anticipo de prestaciones"
                                                             v-model="record.benefits_advance_payment">
                                                        <label slot="off-label"></label>
                                                    </p-check>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ./anticipo de prestaciones -->
                                        <!-- porcentaje de anticipo permitido -->
                                        <div class="col-md-3" v-if="record.benefits_advance_payment">
                                            <div class="form-group is-required">
                                                <label>Porcentaje de anticipo permitido:</label>
                                                <input type="text" data-toggle="tooltip"
                                                       title="Indique el porcentaje máximo permitido para el anticipo de prestaciones"
                                                       class="form-control input-sm"
                                                       v-input-mask data-inputmask="
                                                            'alias': 'numeric',
                                                            'allowMinus': 'false',
                                                            'digits': 0"
                                                       v-model="record.maximum_advance_percentage">
                                            </div>
                                        </div>
                                        <!-- ./porcentaje de anticipo permitido -->
                                        <!-- anticipos permitidos por año -->
                                        <div class="col-md-3" v-if="record.benefits_advance_payment">
                                            <div class="form-group is-required">
                                                <label>Anticipos permitidos por año:</label>
                                                <input type="text" data-toggle="tooltip"
                                                       title="Indique el número de anticipos permitidos por año"
                                                       class="form-control input-sm"
                                                       v-input-mask data-inputmask="
                                                            'alias': 'numeric',
                                                            'allowMinus': 'false',
                                                            'digits': 0"
                                                       v-model="record.number_advances_per_year">
                                            </div>
                                        </div>
                                        <!-- ./porcentaje de anticipo permitido -->
                                    </div>
                                </div>

                                <div id="w-benefitsPaymentForm" class="tab-pane p-3">
                                    <div class="row">
                                        <!-- salario a emplear -->
                                        <div class="col-md-6">
                                            <div class="form-group is-required">
                                                <label>Salario a emplear para el cálculo del bono vacacional:</label>
                                                <select2 :options="salary_types"
                                                         v-model="record.salary_type"></select2>
                                            </div>
                                        </div>
                                        <!-- ./salario a emplear -->
                                        <!-- tipo de pago de nómina -->
                                        <div class="col-md-6">
                                            <div class="form-group is-required">
                                                <label>Tipo de pago de nómina:</label>
                                                <select2 :options="payroll_payment_types"
                                                         v-model="record.payroll_payment_type_id"></select2>
                                            </div>
                                        </div>
                                        <!-- ./tipo de pago de nómina -->
                                    </div>
                                </div>
                            </div>
                            <div class="wizard-footer">
                                <div class="pull-right"
                                     v-if="panel == 'benefitsPolicyForm'">
                                    <button type="button" @click="changePanel('benefitsPaymentForm')"
                                            class="btn btn-primary btn-wd btn-sm"
                                            :disabled="isDisableNext()"
                                            data-toggle="tooltip" title="">
                                        Siguiente
                                    </button>
                                </div>
                                <div class="pull-left"
                                     v-else>
                                    <button type="button" @click="changePanel('benefitsPolicyForm')"
                                            class="btn btn-default btn-wd btn-sm"
                                            data-toggle="tooltip" title="">
                                        Regresar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group">
                            <modal-form-buttons :saveRoute="'payroll/benefits-policies'"></modal-form-buttons>
                        </div>
                    </div>
                    <div class="modal-body modal-table">
                        <v-client-table :columns="columns" :data="records" :options="table_options">
                            <div slot="application_date" slot-scope="props" class="text-center">
                                <span v-if="props.row.end_date">
                                    {{ props.row.start_date + ' - ' + props.row.end_date }}
                                </span>
                                <span v-else> {{ props.row.start_date + ' - No definido' }} </span>
                            </div>
                            <div slot="active" slot-scope="props" class="text-center">
                                <span v-if="props.row.active"> SI </span>
                                <span v-else> NO </span>
                            </div>
                            <div slot="id" slot-scope="props" class="text-center">
                                <button @click="initUpdate(props.row.id, $event)"
                                        class="btn btn-warning btn-xs btn-icon btn-action"
                                        title="Modificar registro" data-toggle="tooltip" type="button">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button @click="deleteRecord(props.row.id, 'payroll/benefits-policies')"
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
    </section>
</template>

<script>
    export default {
        data() {
            return {
                record: {
                    id:                               '',
                    name:                             '',
                    start_date:                       '',
                    end_date:                         '',
                    benefit_days:                     '',
                    minimum_number_months:            '',
                    additional_days_per_year:         '',
                    minimum_number_years:             '',
                    additional_maximum_days_per_year: '',
                    work_interruption_days:           '',
                    month_worked_days:                '',
                    maximum_advance_percentage:       '',
                    number_advances_per_year:         '',
                    salary_type:                      '',
                    institution_id:                   '',
                    payroll_payment_type_id:          '',
                    active:                           false,
                    benefits_advance_payment:          false
                },

                errors:                [],
                records:               [],
                columns:               ['name', 'application_date', 'active', 'id'],
                institutions:          [],
                payroll_payment_types: [],
                salary_types:          [
                    {"id": "",                     "text": "Seleccione..."},
                    {"id": "base_salary",          "text": "Salario Base"},
                    {"id": "comprehensive_salary", "text": "Salario Integral"},
                    {"id": "normal_salary",        "text": "Salario Normal"},
                    {"id": "dialy_salary",         "text": "Salario Diario"}
                ],
                panel:                 'benefitsPolicyForm',
            }
        },
        created() {
            const vm = this;
            vm.table_options.headings = {
                'name':             'Nombre',
                'application_date': 'Fecha de aplicación',
                'active':           'Activo',
                'id':               'Acción'
            };
            vm.table_options.sortable       = ['name', 'application_date'];
            vm.table_options.filterable     = ['name', 'application_date'];
            vm.table_options.columnsClasses = {
                'id':          'col-xs-2'
            };
        },
        mounted() {
            const vm = this;
            $("#add_payroll_benefits_policy").on('show.bs.modal', function() {
                vm.reset();
                vm.getInstitutions();
                vm.getPayrollPaymentTypes();
            });
        },
        methods: {
            /**
             * Método que borra todos los datos del formulario
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve>
             */
            reset() {
                const vm  = this;
                vm.errors = [];
                vm.record = {
                    id:                               '',
                    name:                             '',
                    start_date:                       '',
                    end_date:                         '',
                    benefit_days:                     '',
                    minimum_number_months:            '',
                    additional_days_per_year:         '',
                    minimum_number_years:             '',
                    additional_maximum_days_per_year: '',
                    work_interruption_days:           '',
                    month_worked_days:                '',
                    maximum_advance_percentage:       '',
                    number_advances_per_year:         '',
                    salary_type:                      '',
                    institution_id:                   '',
                    payroll_payment_type_id:          '',
                    active:                           false,
                    benefits_advance_payment:          false
                };
                vm.panel  = 'benefitsPolicyForm';
                document.getElementById("benefitsPolicyForm").click();
            },
            /**
             * Método que habilita o deshabilita el botón siguiente
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve>
             */
            isDisableNext() {
                const vm = this;
                if (vm.record.benefits_advance_payment == true) {
                  if ((vm.record.name != '') &&
                      (vm.record.start_date != '') &&
                      (vm.record.institution_id != '') &&
                      (vm.record.benefit_days != '') &&
                      (vm.record.minimum_number_months != '') &&
                      (vm.record.additional_days_per_year != '') &&
                      (vm.record.minimum_number_years != '') &&
                      (vm.record.additional_maximum_days_per_year != '') &&
                      (vm.record.work_interruption_days != '') &&
                      (vm.record.month_worked_days != '') &&
                      (vm.record.maximum_advance_percentage != '') &&
                      (vm.record.number_advances_per_year != '')) {
                        return false;
                    } else {
                        return true;
                    }
                } else {
                    if ((vm.record.name != '') &&
                      (vm.record.start_date != '') &&
                      (vm.record.institution_id != '') &&
                      (vm.record.benefit_days != '') &&
                      (vm.record.minimum_number_months != '') &&
                      (vm.record.additional_days_per_year != '') &&
                      (vm.record.minimum_number_years != '') &&
                      (vm.record.additional_maximum_days_per_year != '') &&
                      (vm.record.work_interruption_days != '') &&
                      (vm.record.month_worked_days != '')) {
                        return false;
                    } else {
                        return true;
                    }
                }
            },
            /**
             * Método que cambia el panel de visualización
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve>
             *
             * @param     {string}     panel    Panel seleccionado
             */
            changePanel(panel) {
                const vm    = this;
                let complete;
                if (panel == 'benefitsPaymentForm') {
                    complete = !vm.isDisableNext();
                } else {
                    complete = true;
                }
                if (complete == true) {
                    vm.panel    = panel;
                    let element = document.getElementById(panel);
                    if (element) {
                        element.click();
                    }
                }
            }
        }
    };
</script>
