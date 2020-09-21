<template>
    <section id="payrollVacationPoliciesFormComponent">
        <a class="btn-simplex btn-simplex-md btn-simplex-primary" href=""
           title="Registros de políticas vacacionales" data-toggle="tooltip"
           @click="addRecord('add_payroll_vacation_policy', 'vacation-policies', $event)">
           <i class="icofont icofont-ui-flight ico-3x"></i>
           <span>Políticas<br>Vacacionales</span>
        </a>
        <div class="modal fade text-left" tabindex="-1" role="dialog" id="add_payroll_vacation_policy">
            <div class="modal-dialog vue-crud" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h6>
                            <i class="icofont icofont-ui-flight ico-3x"></i>
                            Política vacacional
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
                                v-if="panel == 'vacationPolicyForm'">
                                <li class="nav-item active">
                                    <a href="#w-vacationPolicyForm" data-toggle="tab"
                                       class="nav-link text-center" id="vacationPolicyForm"
                                       @click="changePanel('vacationPolicyForm')">
                                        <span class="badge">1</span>
                                        Definir Política Vacacional
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a :href="isDisableNext()?'#':'#w-vacationPaymentForm'" data-toggle="tab"
                                       class="nav-link text-center" id="vacationPaymentForm"
                                       @click="changePanel('vacationPaymentForm')">
                                        <span class="badge">2</span>
                                        Definir Pago de Vacaciones
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav wizard-steps"
                                v-else>
                                <li class="nav-item">
                                    <a href="#w-vacationPolicyForm" data-toggle="tab"
                                       class="nav-link text-center" id="vacationPolicyForm"
                                       @click="changePanel('vacationPolicyForm')">
                                        <span class="badge">1</span>
                                        Definir Política Vacacional
                                    </a>
                                </li>
                                <li class="nav-item active">
                                    <a href="#w-vacationPaymentForm" data-toggle="tab"
                                       class="nav-link text-center" id="vacationPaymentForm"
                                       @click="changePanel('vacationPaymentForm')">
                                        <span class="badge">2</span>
                                        Definir Pago de Vacaciones
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <form class="form-horizontal">
                            <div class="tab-content">
                                <div id="w-vacationPolicyForm" class="tab-pane p-3 active">
                                    <div class="row">
                                        <!-- nombre -->
                                        <div class="col-md-6">
                                            <div class="form-group is-required">
                                                <label>Nombre:</label>
                                                <input type="text" class="form-control input-sm"
                                                       placeholder="Nombre de política vacacional" data-toggle="tooltip"
                                                       title="Indique el nombre del tabulador (requerido)"
                                                       v-model="record.name">
                                                <input type="hidden" v-model="record.id">
                                            </div>
                                        </div>
                                        <!-- ./nombre -->
                                        <!-- fecha de aplicación -->
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Desde:</label>
                                                <input type="date" id="start_date" placeholder="Desde"
                                                       data-toggle="tooltip" title="Indique la fecha de aplicación asociada a la política vacacional"
                                                       class="form-control input-sm" v-model="record.start_date">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Hasta:</label>
                                                <input type="date" id="end_date" placeholder="Hasta"
                                                       data-toggle="tooltip" title="Indique la fecha de aplicación asociada a la política vacacional"
                                                       class="form-control input-sm" v-model="record.end_date">
                                            </div>
                                        </div>
                                        <!-- ./fecha de aplicación -->
                                        <!-- tipo de vacaciones -->
                                        <div class="col-md-6">
                                            <div class="form-group is-required">
                                                <label>Tipo de vacaciones:</label>
                                                <select2 :options="vacation_types"
                                                         v-model="record.vacation_type_id"></select2>
                                            </div>
                                        </div>
                                        <!-- ./relación de pago -->
                                    </div>
                                    <div class="row"
                                         v-if="record.vacation_type_id == 'collective_vacations'">
                                        <!-- fecha de inicio -->
                                        <div class="col-md-3">
                                            <div class="form-group is-required">
                                                <label>Fecha de inicio:</label>
                                                <input type="date" id="start_date_vacation" placeholder="Fecha de inicio"
                                                       data-toggle="tooltip" title="Indique la fecha del inicio del período vacacional"
                                                       class="form-control input-sm" v-model="record.start_date_vacation">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group is-required">
                                                <label>Fecha de Finalización:</label>
                                                <input type="date" id="end_date_vacation" placeholder="Fecha de Finalización"
                                                       data-toggle="tooltip" title="Indique la fecha de Finalización del período vacacional"
                                                       class="form-control input-sm" v-model="record.start_date_vacation">
                                            </div>
                                        </div>
                                        <!-- ./fecha de aplicación -->
                                        <!-- períodos vacacionales -->
                                        <div class="col-md-6">
                                            <div class="form-group is-required">
                                                <label> Períodos vacacionales acumulados por año:</label>
                                                <input type="text" data-toggle="tooltip"
                                                       title="Indique la cantidad de períodos vacacionales acumulados permitidos por año"
                                                       class="form-control input-sm"
                                                       v-input-mask data-inputmask="
                                                            'alias': 'numeric',
                                                            'allowMinus': 'false'"
                                                       v-model="record.vacation_period_per_year">
                                            </div>
                                        </div>
                                        <!-- ./períodos vacacionales -->
                                        <!-- adelanto de vacaciones -->
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>¿Permitir adelanto de disfrute de vacaciones?</label>
                                                <div class="col-12">
                                                    <p-check class="pretty p-switch p-fill p-bigger"
                                                             color="success" off-color="text-gray" toggle
                                                             data-toggle="tooltip"
                                                             title="Indique si se habilita el adelanto de disfrute de vacaciones"
                                                             v-model="record.vacation_advance">
                                                        <label slot="off-label"></label>
                                                    </p-check>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ./adelanto de vacaciones -->
                                        <!-- posterga de vacaciones -->
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>¿Permitir postergar el disfrute de vacaciones?</label>
                                                <div class="col-12">
                                                    <p-check class="pretty p-switch p-fill p-bigger"
                                                             color="success" off-color="text-gray" toggle
                                                             data-toggle="tooltip"
                                                             title="Indique si se habilita el adelanto de disfrute de vacaciones"
                                                             v-model="record.vacation_postpone">
                                                        <label slot="off-label"></label>
                                                    </p-check>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ./posterga de vacaciones -->
                                    </div>
                                    <div class="row"
                                         v-else-if="record.vacation_type_id == 'vacation_period'">
                                        <!-- días a otorgar para el disfrute de vacaciones -->
                                        <div class="col-md-3">
                                            <div class="form-group is-required">
                                                <label>Días a otorgar para el disfrute de vacaciones:</label>
                                                <input type="text" data-toggle="tooltip"
                                                       title="Indique la cantidad de días a otorgar para el disfrute de vacaciones"
                                                       class="form-control input-sm"
                                                       v-input-mask data-inputmask="
                                                            'alias': 'numeric',
                                                            'allowMinus': 'false'"
                                                       v-model="record.holidays">
                                            </div>
                                        </div>
                                        <!-- ./días a otorgar para el disfrute de vacaciones -->
                                        <!-- períodos vacacionales -->
                                        <div class="col-md-3">
                                            <div class="form-group is-required">
                                                <label> Períodos vacacionales por año:</label>
                                                <input type="text" data-toggle="tooltip"
                                                       title="Indique la cantidad de períodos vacacionales permitidos por año"
                                                       class="form-control input-sm"
                                                       v-input-mask data-inputmask="
                                                            'alias': 'numeric',
                                                            'allowMinus': 'false'"
                                                       v-model="record.vacation_period_per_year">
                                            </div>
                                        </div>
                                        <!-- ./períodos vacacionales -->
                                        <!-- días adicionales a otorgar por años de servicio para el disfrute de vacaciones -->
                                        <div class="col-md-3">
                                            <div class="form-group is-required">
                                                <label>Días a otorgar para el disfrute de vacaciones:</label>
                                                <input type="text" data-toggle="tooltip"
                                                       title="Indique la cantidad de días adicionales a otorgar por año de servicio para el disfrute de vacaciones"
                                                       class="form-control input-sm"
                                                       v-input-mask data-inputmask="
                                                            'alias': 'numeric',
                                                            'allowMinus': 'false'">
                                            </div>
                                        </div>
                                        <!-- ./días adicionales a otorgar por años de servicio para el disfrute de vacaciones -->
                                        <!-- días de disfrute de vacaciones mínimos por año -->
                                        <div class="col-md-3">
                                            <div class="form-group is-required">
                                                <label>Días de disfrute de vacaciones mínimo por año:</label>
                                                <input type="text" data-toggle="tooltip"
                                                       title="Indique la cantidad mínima de días para el disfrute de vacaciones por año"
                                                       class="form-control input-sm"
                                                       v-input-mask data-inputmask="
                                                            'alias': 'numeric',
                                                            'allowMinus': 'false'">
                                            </div>
                                        </div>
                                        <!-- ./días de disfrute de vacaciones mínimos por año -->
                                        <!-- días de disfrute de vacaciones máximo por años de servicio -->
                                        <div class="col-md-3">
                                            <div class="form-group is-required">
                                                <label>Días de disfrute de vacaciones máximo por año de servicio:</label>
                                                <input type="text" data-toggle="tooltip"
                                                       title="Indique la cantidad máxima de días para el disfrute de vacaciones por año de servicio"
                                                       class="form-control input-sm"
                                                       v-input-mask data-inputmask="
                                                            'alias': 'numeric',
                                                            'allowMinus': 'false'">
                                            </div>
                                        </div>
                                        <!-- ./días de disfrute de vacaciones máximos por año de servicio -->
                                        <!-- períodos vacacionales -->
                                        <div class="col-md-3">
                                            <div class="form-group is-required">
                                                <label> Períodos vacacionales acumulados por año:</label>
                                                <input type="text" data-toggle="tooltip"
                                                       title="Indique la cantidad de períodos vacacionales acumulados permitidos por año"
                                                       class="form-control input-sm"
                                                       v-input-mask data-inputmask="
                                                            'alias': 'numeric',
                                                            'allowMinus': 'false'">
                                            </div>
                                        </div>
                                        <!-- ./períodos vacacionales -->
                                        <!-- adelanto de vacaciones -->
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>¿Permitir adelanto de disfrute de vacaciones?</label>
                                                <div class="col-12">
                                                    <p-check class="pretty p-switch p-fill p-bigger"
                                                             color="success" off-color="text-gray" toggle
                                                             data-toggle="tooltip"
                                                             title="Indique si se habilita el adelanto de disfrute de vacaciones"
                                                             v-model="record.vacation_advance">
                                                        <label slot="off-label"></label>
                                                    </p-check>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ./adelanto de vacaciones -->
                                        <!-- posterga de vacaciones -->
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>¿Permitir postergar el disfrute de vacaciones?</label>
                                                <div class="col-12">
                                                    <p-check class="pretty p-switch p-fill p-bigger"
                                                             color="success" off-color="text-gray" toggle
                                                             data-toggle="tooltip"
                                                             title="Indique si se habilita el adelanto de disfrute de vacaciones"
                                                             v-model="record.vacation_postpone">
                                                        <label slot="off-label"></label>
                                                    </p-check>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ./posterga de vacaciones -->
                                     </div>
                                </div>

                                <div id="w-vacationPaymentForm" class="tab-pane p-3">
                                    <div class="row">
                                        <!-- salario a emplear -->
                                        <div class="col-md-6">
                                            <div class=" form-group is-required">
                                                <label>Salario a emplear:</label>
                                                <select2 :options="salary_types"
                                                         v-model="record.salary_type_id"></select2>
                                            </div>
                                        </div>
                                        <!-- ./salario a emplear -->
                                        <!-- antiguedad del trabajador -->
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>¿Antiguedad del trabajador?</label>
                                                <div class="col-12">
                                                    <p-check class="pretty p-switch p-fill p-bigger"
                                                             color="success" off-color="text-gray" toggle
                                                             data-toggle="tooltip"
                                                             title="Indique si el pago del bono vacacional se realiza de acuerdo a la antiguedad del trabajador">
                                                        <label slot="off-label"></label>
                                                    </p-check>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ./antiguedad del trabajador -->
                                        <!-- día de disfrute -->
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>¿Pago por día de disfrute?</label>
                                                <div class="col-12">
                                                    <p-radio class="pretty p-switch p-fill p-bigger"
                                                             color="success" off-color="text-gray" toggle
                                                             data-toggle="tooltip"
                                                             title="Indique si el pago del bono vacacional se realiza de acuerdo a los días de disfrute"
                                                             v-model="record.payment_calculation" value="enjoyment_days">
                                                        <label slot="off-label"></label>
                                                    </p-radio>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ./día de disfrute -->
                                        <!-- día general -->
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>¿Pago por día general?</label>
                                                <div class="col-12">
                                                    <p-radio class="pretty p-switch p-fill p-bigger"
                                                             color="success" off-color="text-gray" toggle
                                                             data-toggle="tooltip"
                                                             title="Indique si el pago del bono vacacional se realiza de acuerdo a los días generales"
                                                             v-model="record.payment_calculation" value="general_days">
                                                        <label slot="off-label"></label>
                                                    </p-radio>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ./día general -->
                                        <!-- días a otorgar para el pago de vacaciones -->
                                        <div class="col-md-6" v-if="record.payment_calculation == 'general_days'">
                                            <div class="form-group is-required">
                                                <label>Días a otorgar para el disfrute de vacaciones:</label>
                                                <input type="text" data-toggle="tooltip"
                                                       title="Indique la cantidad de días a otorgar para el pago de las vacaciones"
                                                       class="form-control input-sm"
                                                       v-input-mask data-inputmask="
                                                            'alias': 'numeric',
                                                            'allowMinus': 'false'">
                                            </div>
                                        </div>
                                        <!-- ./días a otorgar para el pago de vacaciones -->
                                    </div>
                                </div>
                            </div>
                            <div class="wizard-footer">
                                <div class="pull-right"
                                     v-if="panel == 'vacationPolicyForm'">
                                    <button type="button" @click="changePanel('vacationPaymentForm')"
                                            class="btn btn-primary btn-wd btn-sm"
                                            :disabled="isDisableNext()"
                                            data-toggle="tooltip" title="">
                                        Siguiente
                                    </button>
                                </div>
                                <div class="pull-left"
                                     v-else>
                                    <button type="button" @click="changePanel('vacationPolicyForm')"
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
                            <modal-form-buttons :saveRoute="'payroll/vacation-policies'"></modal-form-buttons>
                        </div>
                    </div>
                    <div class="modal-body modal-table">
                        <v-client-table :columns="columns" :data="records" :options="table_options">
                            <div slot="description" slot-scope="props">
                                <span v-html="props.row.description"></span>
                            </div>
                            <div slot="id" slot-scope="props" class="text-center">
                                <button @click="initUpdate(props.row.id, $event)"
                                        class="btn btn-warning btn-xs btn-icon btn-action"
                                        title="Modificar registro" data-toggle="tooltip" type="button">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button @click="deleteRecord(props.row.id, 'vacation-policies')"
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
                    id:               '',
                    name:             '',
                    start_date:       '',
                    end_date:         '',
                    vacation_type_id: '',
                    vacation_period_per_year: '',
                    vacation_advance:  false,
                    vacation_postpone: false,
                    payment_calculation: ''
                },
                errors:         [],
                records:        [],
                columns:        ['id'],
                vacation_types: [
                    {"id": "",                     "text": "Seleccione..."},
                    {"id": "collective_vacations", "text": "Vacaciones colectivas"},
                    {"id": "vacation_period",      "text": "Período vacacional"}
                ],
                salary_types:   [
                    {"id": "",                     "text": "Seleccione..."},
                    {"id": "base_salary",          "text": "Salario Base"},
                    {"id": "normal_salary",        "text": "Salario Normal"},
                    {"id": "dialy_salary",         "text": "Salario Diario"},
                    {"id": "comprehensive_salary", "text": "Salario Integral"}
                ],
                panel:   'vacationPolicyForm',
            }
        },
        created() {
            const vm = this;
            vm.table_options.headings = {
                'id':          'Acción'
            };
            vm.table_options.sortable       = ['name', 'description', 'sign'];
            vm.table_options.filterable     = ['name', 'description', 'sign'];
            vm.table_options.columnsClasses = {
                'id':          'col-xs-2'
            };
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
                    id:               '',
                    name:             '',
                    start_date:       '',
                    end_date:         '',
                    vacation_type_id: '',
                    vacation_period_per_year: '',
                    vacation_advance:  false,
                    vacation_postpone: false,
                    payment_calculation: ''
                };
                vm.panel  = 'vacationPolicyForm';
            },
            /**
             * Método que habilita o deshabilita el botón siguiente
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve>
             */
            isDisableNext() {
                const vm = this;
                return false;
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
                if (panel == 'vacationPaymentForm') {
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
            },
        }
    };
</script>
