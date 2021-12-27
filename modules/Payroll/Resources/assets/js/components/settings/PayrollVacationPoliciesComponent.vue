<template>
    <section id="payrollVacationPoliciesFormComponent">
        <a class="btn-simplex btn-simplex-md btn-simplex-primary" href=""
           title="Registros de políticas vacacionales" data-toggle="tooltip"
           @click="addRecord('add_payroll_vacation_policy', 'payroll/vacation-policies', $event)">
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
                                        Política vacacional
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a :href="isDisableNext()?'#':'#w-vacationPaymentForm'" data-toggle="tab"
                                       class="nav-link text-center" id="vacationPaymentForm"
                                       @click="changePanel('vacationPaymentForm')">
                                        <span class="badge">2</span>
                                        Pago de vacaciones
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" data-toggle="tab"
                                       class="nav-link text-center" id="vacationRequestForm">
                                        <span class="badge">3</span>
                                        Solicitud de vacaciones
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav wizard-steps"
                                v-else-if="panel == 'vacationPaymentForm'">
                                <li class="nav-item">
                                    <a href="#w-vacationPolicyForm" data-toggle="tab"
                                       class="nav-link text-center" id="vacationPolicyForm"
                                       @click="changePanel('vacationPolicyForm')">
                                        <span class="badge">1</span>
                                        Política vacacional
                                    </a>
                                </li>
                                <li class="nav-item active">
                                    <a href="#w-vacationPaymentForm" data-toggle="tab"
                                       class="nav-link text-center" id="vacationPaymentForm"
                                       @click="changePanel('vacationPaymentForm')">
                                        <span class="badge">2</span>
                                        Pago de vacaciones
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" data-toggle="tab"
                                       class="nav-link text-center" id="vacationRequestForm">
                                        <span class="badge">3</span>
                                        Solicitud de vacaciones
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav wizard-steps"
                                v-else>
                                <li class="nav-item">
                                    <a href="#" data-toggle="tab"
                                       class="nav-link text-center" id="vacationPolicyForm">
                                        <span class="badge">1</span>
                                        Política vacacional
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#w-vacationPaymentForm" data-toggle="tab"
                                       class="nav-link text-center" id="vacationPaymentForm"
                                       @click="changePanel('vacationPaymentForm')">
                                        <span class="badge">2</span>
                                        Pago de vacaciones
                                    </a>
                                </li>
                                <li class="nav-item active">
                                    <a href="#" data-toggle="tab"
                                       class="nav-link text-center" id="vacationRequestForm">
                                        <span class="badge">3</span>
                                        Solicitud de vacaciones
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
                                            <div class="form-group is-required">
                                                <label>Desde:</label>
                                                <input type="date" id="start_date" placeholder="Desde"
                                                       data-toggle="tooltip" title="Indique la fecha de aplicación asociada a la política vacacional"
                                                       class="form-control input-sm"
                                                       :min="start_operations_date" :max="record.end_date"
                                                       v-model="record.start_date">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Hasta:</label>
                                                <input type="date" id="end_date" placeholder="Hasta"
                                                       data-toggle="tooltip" title="Indique la fecha de aplicación asociada a la política vacacional" :min="record.start_date"
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
                                                             title="¿La política vacacional se encuentra activa actualmente?"
                                                             v-model="record.active">
                                                        <label slot="off-label"></label>
                                                    </p-check>
                                                  </div>
                                            </div>
                                        </div>
                                        <!-- ./activa -->
                                        <!-- organización -->
                                        <div class="col-md-4">
                                            <div class="form-group is-required">
                                                <label>Organización:</label>
                                                <select2 :options="institutions" v-model="record.institution_id"></select2>
                                            </div>
                                        </div>
                                        <!-- ./organización -->
                                        <!-- tipo de vacaciones -->
                                        <div class="col-md-6">
                                            <div class="form-group is-required">
                                                <label>Tipo de vacaciones:</label>
                                                <select2 :options="vacation_types"
                                                         @input="switchTypeVacation()"
                                                         v-model="record.vacation_type"></select2>
                                            </div>
                                        </div>
                                        <!-- ./tipo de vacaciones -->
                                    </div>
                                    <div class="row"
                                         v-if="record.vacation_type == 'collective_vacations'">
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
                                        <!-- períodos vacacionales -->
                                        <div class="col-md-6">
                                            <div class="form-group is-required">
                                                <label> Períodos vacacionales acumulados permitidos por año:</label>
                                                <input type="text" data-toggle="tooltip"
                                                       title="Indique la cantidad de períodos vacacionales acumulados permitidos por año"
                                                       class="form-control input-sm"
                                                       v-input-mask data-inputmask="
                                                            'alias': 'numeric',
                                                            'allowMinus': 'false',
                                                            'digits': 0"
                                                       v-model="record.vacation_periods_accumulated_per_year">
                                            </div>
                                        </div>
                                        <!-- ./períodos vacacionales -->
                                    </div>
                                    <h6 class="card-title"
                                        v-if="record.vacation_type == 'collective_vacations'">
                                        Período Vacacional <i class="fa fa-plus-circle cursor-pointer"
                                                              title="Nuevo período vacacional" data-toggle="tooltip"
                                                              @click="addVacationPeriod()"></i>
                                    </h6>
                                    <div class="row" v-for="(vacation_period, index) in record.vacation_periods">
                                        <!-- fecha de inicio del período de vacaciones colectivas -->
                                        <div class="col-md-5">
                                            <div class="form-group is-required">
                                                <label>Fecha de inicio:</label>
                                                <input type="date" id="start_date_vacation" placeholder="Fecha de inicio"
                                                       data-toggle="tooltip" title="Indique la fecha del inicio del período vacacional"
                                                       class="form-control input-sm" v-model="vacation_period.start_date">
                                            </div>
                                        </div>
                                        <!-- ./fecha de inicio del período de vacaciones colectivas -->
                                        <!-- fecha de finalización del período de vacaciones colectivas -->
                                        <div class="col-md-5">
                                            <div class="form-group is-required">
                                                <label>Fecha de Finalización:</label>
                                                <input type="date" id="end_date_vacation" placeholder="Fecha de Finalización"
                                                       data-toggle="tooltip" title="Indique la fecha de Finalización del período vacacional" :min="vacation_period.start_date"
                                                       class="form-control input-sm" v-model="vacation_period.end_date">
                                            </div>
                                        </div>
                                        <!-- ./fecha de finalización del período de vacaciones colectivas -->
                                        <div class="col-1" style="align-self: flex-end;">
                                            <div class="form-group">
                                                <button class="btn btn-sm btn-danger btn-action" type="button"
                                                        @click="removeRow(index, record.vacation_periods)"
                                                        title="Eliminar registro" data-toggle="tooltip">
                                                    <i class="fa fa-minus-circle"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="align-items: baseline;"
                                         v-if="record.vacation_type == 'vacation_period'">
                                        <!-- días a otorgar para el pago de vacaciones -->
                                        <div class="col-md-3">
                                            <div class="form-group is-required">
                                                <label>Días a otorgar para el pago de vacaciones:</label>
                                                <input type="text" data-toggle="tooltip"
                                                       title="Indique la cantidad de días a otorgar para el pago de vacaciones"
                                                       class="form-control input-sm"
                                                       v-input-mask data-inputmask="
                                                            'alias': 'numeric',
                                                            'allowMinus': 'false',
                                                            'digits': 0"
                                                       v-model="record.vacation_days">
                                            </div>
                                        </div>
                                        <!-- ./días a otorgar para el pago de vacaciones -->
                                        <!-- períodos vacacionales -->
                                        <div class="col-md-3">
                                            <div class="form-group is-required">
                                                <label> Períodos vacacionales permitidos por año:</label>
                                                <input type="text" data-toggle="tooltip"
                                                       title="Indique la cantidad de períodos vacacionales permitidos por año"
                                                       class="form-control input-sm"
                                                       v-input-mask data-inputmask="
                                                            'alias': 'numeric',
                                                            'allowMinus': 'false',
                                                            'digits': 0"
                                                       v-model="record.vacation_period_per_year">
                                            </div>
                                        </div>
                                        <!-- ./períodos vacacionales -->
                                        <!-- días adicionales a otorgar por años de servicio para el disfrute de vacaciones -->
                                        <div class="col-md-3">
                                            <div class="form-group is-required">
                                                <label>Días de disfrute adicionales a otorgar por año de servicio:</label>
                                                <input type="text" data-toggle="tooltip"
                                                       title="Indique la cantidad de días adicionales a otorgar por año de servicio para el disfrute de vacaciones"
                                                       class="form-control input-sm"
                                                       v-input-mask data-inputmask="
                                                            'alias': 'numeric',
                                                            'allowMinus': 'false',
                                                            'digits': 0"
                                                       v-model="record.additional_days_per_year">
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
                                                            'allowMinus': 'false',
                                                            'digits': 0"
                                                       v-model="record.minimum_additional_days_per_year">
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
                                                            'allowMinus': 'false',
                                                            'digits': 0"
                                                       v-model="record.maximum_additional_days_per_year">
                                            </div>
                                        </div>
                                        <!-- ./días de disfrute de vacaciones máximos por año de servicio -->
                                        <!-- períodos vacacionales -->
                                        <div class="col-md-3">
                                            <div class="form-group is-required">
                                                <label> Períodos vacacionales acumulados permitidos por año:</label>
                                                <input type="text" data-toggle="tooltip"
                                                       title="Indique la cantidad de períodos vacacionales acumulados permitidos por año"
                                                       class="form-control input-sm"
                                                       v-input-mask data-inputmask="
                                                            'alias': 'numeric',
                                                            'allowMinus': 'false',
                                                            'digits': 0"
                                                       v-model="record.vacation_periods_accumulated_per_year">
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
                                        <!-- antiguedad del trabajador -->
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>¿Antiguedad del trabajador?</label>
                                                <div class="col-12">
                                                    <p-check class="pretty p-switch p-fill p-bigger"
                                                             color="success" off-color="text-gray" toggle
                                                             data-toggle="tooltip"
                                                             title="Indique si el pago del bono vacacional se realiza de acuerdo a la antiguedad del trabajador"
                                                             v-model="record.staff_antiquity">
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
                                        <div class="col-md-3" v-if="record.payment_calculation == 'general_days' && 
                                                                    record.vacation_type == 'collective_vacations'">
                                            <div class="form-group is-required">
                                                <label>Días a otorgar para el pago de vacaciones:</label>
                                                <input type="text" data-toggle="tooltip"
                                                       title="Indique la cantidad de días a otorgar para el pago de las vacaciones"
                                                       class="form-control input-sm"
                                                       v-input-mask data-inputmask="
                                                            'alias': 'numeric',
                                                            'allowMinus': 'false',
                                                            'digits': 0"
                                                       v-model="record.vacation_days">
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
                            <div slot="vacation_type" slot-scope="props">
                                <span v-if="props.row.vacation_type == 'collective_vacations'">
                                    Vacaciones colectivas
                                </span>
                                <span v-else-if="props.row.vacation_type == 'vacation_period'">
                                    Período vacacional
                                </span>
                            </div>
                            <div slot="id" slot-scope="props" class="text-center">
                                <button @click="initUpdate(props.row.id, $event)"
                                        class="btn btn-warning btn-xs btn-icon btn-action"
                                        title="Modificar registro" data-toggle="tooltip" type="button">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button @click="deleteRecord(props.row.id, 'payroll/vacation-policies')"
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
                    id:                                    '',
                    name:                                  '',
                    start_date:                            '',
                    end_date:                              '',
                    vacation_type:                         '',
                    vacation_periods_accumulated_per_year: '',
                    vacation_days:                         '',
                    vacation_period_per_year:              '',
                    additional_days_per_year:              '',
                    minimum_additional_days_per_year:      '',
                    maximum_additional_days_per_year:      '',
                    payment_calculation:                   '',
                    salary_type:                           '',
                    institution_id:                        '',
                    payroll_payment_type_id:               '',
                    vacation_periods:                      [],
                    active:                                false,
                    vacation_advance:                      false,
                    vacation_postpone:                     false,
                    staff_antiquity:                       false
                },

                errors:                [],
                records:               [],
                columns:               ['name', 'application_date', 'vacation_type', 'active', 'id'],
                institutions:          [],
                payroll_payment_types: [],
                vacation_types:        [
                    {"id": "",                     "text": "Seleccione..."},
                    {"id": "collective_vacations", "text": "Vacaciones colectivas"},
                    {"id": "vacation_period",      "text": "Período vacacional"}
                ],
                salary_types:          [
                    {"id": "",                     "text": "Seleccione..."},
                    {"id": "base_salary",          "text": "Salario Base"},
                    {"id": "comprehensive_salary", "text": "Salario Integral"},
                    {"id": "normal_salary",        "text": "Salario Normal"},
                    {"id": "dialy_salary",         "text": "Salario Diario"}
                ],
                panel:                 'vacationPolicyForm',
            }
        },
        props: {
            start_operations_date: {
                type:     Date,
                required: false,
                default:  ''
            }
        },
        created() {
            const vm = this;
            vm.table_options.headings = {
                'name':             'Nombre',
                'application_date': 'Fecha de aplicación',
                'vacation_type':    'Tipo de vacaciones',
                'active':           'Activa',
                'id':               'Acción'
            };
            vm.table_options.sortable       = ['name', 'application_date', 'vacation_type'];
            vm.table_options.filterable     = ['name', 'application_date', 'vacation_type'];
            vm.table_options.columnsClasses = {
                'id':          'col-xs-2'
            };
        },
        mounted() {
            const vm = this;
            $("#add_payroll_vacation_policy").on('show.bs.modal', function() {
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
                    id:                                    '',
                    name:                                  '',
                    start_date:                            '',
                    end_date:                              '',
                    vacation_type:                         '',
                    vacation_periods_accumulated_per_year: '',
                    vacation_days:                         '',
                    vacation_period_per_year:              '',
                    additional_days_per_year:              '',
                    minimum_additional_days_per_year:      '',
                    maximum_additional_days_per_year:      '',
                    payment_calculation:                   '',
                    salary_type:                           '',
                    institution_id:                        '',
                    payroll_payment_type_id:               '',
                    vacation_periods:                      [],
                    active:                                false,
                    vacation_advance:                      false,
                    vacation_postpone:                     false,
                    staff_antiquity:                       false
                };
                vm.panel  = 'vacationPolicyForm';
                document.getElementById("vacationPolicyForm").click();
            },
            /**
             * Método que habilita o deshabilita el botón siguiente
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve>
             */
            isDisableNext() {
                const vm = this;
                if (vm.record.vacation_type == 'collective_vacations') {
                    if ((vm.record.name != '') &&
                        (vm.record.start_date != '') &&
                        (vm.record.end_date != '') &&
                        (vm.record.institution_id != '') &&
                        (vm.record.vacation_periods != []) &&
                        (vm.record.vacation_periods_accumulated_per_year != '')) {
                        return false;
                    } else {
                        return true;
                    }

                } else if (vm.record.vacation_type == 'vacation_period') {
                    if ((vm.record.name != '') &&
                        (vm.record.start_date != '') &&
                        (vm.record.end_date != '') &&
                        (vm.record.institution_id != '') &&
                        (vm.record.vacation_days != '') &&
                        (vm.record.vacation_period_per_year != '') &&
                        (vm.record.additional_days_per_year != '') &&
                        (vm.record.minimum_additional_days_per_year != '') &&
                        (vm.record.maximum_additional_days_per_year != '') &&
                        (vm.record.vacation_periods_accumulated_per_year != '')) {
                        return false;
                    } else {
                        return true;
                    }
                } else {
                    return true;
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
            /**
             * Método que permite inicializar los campos del formulario según sea el tipo de vacaciones
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve>
             */
            switchTypeVacation() {
                const vm    = this;
                if (vm.record.vacation_type == 'collective_vacations') {
                    vm.record.vacation_days                         = '';
                    vm.record.vacation_period_per_year              = '';
                    vm.record.additional_days_per_year              = '';
                    vm.record.minimum_additional_days_per_year      = '';
                    vm.record.maximum_additional_days_per_year      = '';
                } else if (vm.record.vacation_type == 'vacation_period') {
                    vm.record.vacation_periods                      = [];
                    //vm.record.vacation_periods_accumulated_per_year = '';
                }
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
                this.errors = [];
                this.reset();
                const vm = this;

                url = (!url.includes('http://') || !url.includes('http://')) ? `${window.app_url}/${url}` : url;

                axios.get(url).then(response => {
                    if (typeof(response.data.records) !== "undefined") {
                        let records = [];
                        $.each(response.data.records, function(index, field) {
                            records.push({
                                id:                                    field['id'],
                                name:                                  field['name'],
                                start_date:                            field['start_date'],
                                end_date:                              field['end_date'],
                                active:                                field['active'],
                                institution_id:                        field['institution_id'],
                                institution:                           field['institution'],
                                vacation_type:                         field['vacation_type'],
                                vacation_periods:                      JSON.parse(field['vacation_periods']),
                                vacation_periods_accumulated_per_year: field['vacation_periods_accumulated_per_year'],
                                vacation_days:                         field['vacation_days'],
                                vacation_period_per_year:              field['vacation_period_per_year'],
                                additional_days_per_year:              field['additional_days_per_year'],
                                minimum_additional_days_per_year:      field['minimum_additional_days_per_year'],
                                maximum_additional_days_per_year:      field['maximum_additional_days_per_year'],
                                payment_calculation:                   field['payment_calculation'],
                                salary_type:                           field['salary_type'],
                                vacation_advance:                      field['vacation_advance'],
                                vacation_postpone:                     field['vacation_postpone'],
                                staff_antiquity:                       field['staff_antiquity'],
                                payroll_payment_type_id:               field['payroll_payment_type_id'],
                                payroll_payment_type:                  field['payroll_payment_type']
                            });
                        });
                        vm.records = records;
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
            /**
             * Reescribe el método initRecords para cambiar su comportamiento por defecto
             * Método que obtiene los registros a mostrar
             *
             * @author    Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             *
             * @param     {string}    url    Ruta que obtiene todos los registros solicitados
             */
            readRecords(url) {
                const vm = this;
                vm.loading = true;
                url = (!url.includes('http://') || !url.includes('http://'))
                      ? `${window.app_url}${(url.startsWith('/'))?'':'/'}${url}` : url;

                axios.get(url).then(response => {
                    if (typeof(response.data.records) !== "undefined") {
                        let records = [];
                        $.each(response.data.records, function(index, field) {
                            records.push({
                                id:                                    field['id'],
                                name:                                  field['name'],
                                start_date:                            field['start_date'],
                                end_date:                              field['end_date'],
                                active:                                field['active'],
                                institution_id:                        field['institution_id'],
                                institution:                           field['institution'],
                                vacation_type:                         field['vacation_type'],
                                vacation_periods:                      JSON.parse(field['vacation_periods']),
                                vacation_periods_accumulated_per_year: field['vacation_periods_accumulated_per_year'],
                                vacation_days:                         field['vacation_days'],
                                vacation_period_per_year:              field['vacation_period_per_year'],
                                additional_days_per_year:              field['additional_days_per_year'],
                                minimum_additional_days_per_year:      field['minimum_additional_days_per_year'],
                                maximum_additional_days_per_year:      field['maximum_additional_days_per_year'],
                                payment_calculation:                   field['payment_calculation'],
                                salary_type:                           field['salary_type'],
                                vacation_advance:                      field['vacation_advance'],
                                vacation_postpone:                     field['vacation_postpone'],
                                staff_antiquity:                       field['staff_antiquity'],
                                payroll_payment_type_id:               field['payroll_payment_type_id'],
                                payroll_payment_type:                  field['payroll_payment_type']
                            });
                        });
                        vm.records = records;
                    }
                    vm.loading = false;
                }).catch(error => {
                    vm.logs('mixins.js', 285, error, 'readRecords');
                });
            },
            /**
             * Método que agrega un nuevo período vacacional
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve>
             */
            addVacationPeriod() {
                const vm = this;
                vm.record.vacation_periods.push({
                    start_date: '',
                    end_date: ''
                });
            }
        }
    };
</script>
