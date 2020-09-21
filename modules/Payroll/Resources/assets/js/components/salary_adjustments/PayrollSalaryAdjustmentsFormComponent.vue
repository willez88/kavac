<template>
    <section id="PayrollSalaryAdjustmentsFormComponent">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title">Ajustes en tablas salariales</h6>
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
                <section class="form-horizontal">
                    <div id="salaryAdjustmentsForm" v-if="panel == 'Form'">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- fecha de generación -->
                                <div class="form-group is-required">
                                    <label>Fecha de generación:</label>
                                    <input type="date" readonly
                                           data-toggle="tooltip"
                                           title="Fecha de generación del ajuste salarial"
                                           class="form-control input-sm"
                                           v-model="record.created_at">
                                </div>
                                <!-- ./fecha de generación -->
                            </div>
                            <div class="col-md-6">
                                <!-- fecha del aumento -->
                                <div class="form-group is-required">
                                    <label>Fecha del aumento:</label>
                                    <input type="date" data-toggle="tooltip"
                                           title="Fecha del aumento salarial"
                                           class="form-control input-sm"
                                           v-model="record.increase_of_date">
                                </div>
                                <!-- ./fecha del aumento -->
                            </div>
                            <div class="col-md-6">
                                <!-- tabulador salarial -->
                                <div class="form-group is-required">
                                    <label>Tabulador salarial:</label>
                                    <select2 :options="payroll_salary_tabulators"
                                             @input="showRecord()"
                                             v-model="record.payroll_salary_tabulator_id">
                                    </select2>
                                </div>
                                <!-- ./tabulador salarial -->
                            </div>
                            <div class="col-md-6">
                                <!-- tipo de aumento -->
                                <div class="form-group is-required">
                                    <label>Tipo de aumento:</label>
                                    <select2 :options="increase_of_types"
                                             v-model="record.increase_of_type">
                                    </select2>
                                </div>
                                <!-- ./tipo de aumento -->
                            </div>
                            <div class="col-md-6"
                                 v-if="record.increase_of_type == 'percentage'
                                    || record.increase_of_type == 'absolute_value'">
                                <!-- valor -->
                                <div class="form-group is-required">
                                    <label>Valor:</label>
                                    <input type="text"
                                           data-toggle="tooltip" title="Indique el valor"
                                           class="form-control input-sm"
                                           v-input-mask data-inputmask="
                                                'alias': 'numeric',
                                                'allowMinus': 'false',
                                                'digits': '2'"
                                           v-model="record.value">
                                </div>
                                <!-- ./valor -->
                            </div>
                        </div>
                    </div>
                    <div id="salaryAdjustmentsShow" v-else>
                        <div class="modal-table"
                             v-if="(payroll_salary_tabulator &&
                                (((payroll_salary_tabulator.payroll_horizontal_salary_scale_id > 0)
                                && (payroll_salary_tabulator.payroll_horizontal_salary_scale.payroll_scales) &&
                                (payroll_salary_tabulator.payroll_horizontal_salary_scale.payroll_scales.length > 0))
                                || ((payroll_salary_tabulator.payroll_vertical_salary_scale_id > 0)
                                && (payroll_salary_tabulator.payroll_vertical_salary_scale.payroll_scales) &&
                                (payroll_salary_tabulator.payroll_vertical_salary_scale.payroll_scales.length > 0))))">
                            
                            <table class="table table-hover table-striped table-responsive"
                                   v-if="((payroll_salary_tabulator.payroll_horizontal_salary_scale_id > 0)
                                      && (payroll_salary_tabulator.payroll_vertical_salary_scale_id == null))">
                                <thead>
                                    <th :colspan="1 + payroll_salary_tabulator.payroll_horizontal_salary_scale.payroll_scales.length"
                                        v-if="payroll_salary_tabulator.payroll_horizontal_salary_scale.payroll_scales">
                                        <strong>{{ payroll_salary_tabulator.name }}</strong>
                                    </th>
                                </thead>
                                <tbody>
                                    <tr class="text-center">
                                        <th>Nombre:</th>
                                        <th
                                            v-for="(field_h, index) in
                                            payroll_salary_tabulator.payroll_horizontal_salary_scale.payroll_scales">
                                            {{ field_h.name }}
                                        </th>
                                    </tr>
                                    <tr class="text-center"
                                        v-if="payroll_salary_tabulator.payroll_vertical_salary_scale_id == null">
                                        <th>Incidencia:</th>
                                        <td class="td-with-border"
                                            v-for="(field_h, index) in
                                            payroll_salary_tabulator.payroll_horizontal_salary_scale.payroll_scales">
                                            <div>
                                                <input type="text" :id="'salary_scale_h_' + field_h.id"
                                                       class="form-control input-sm" data-toggle="tooltip"
                                                       :disabled="record.increase_of_type != 'different'"
                                                       onfocus="this.select()"
                                                       :value="getScaleValue(null, field_h.id)">
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="text-center"
                                        v-else
                                        v-for="(field_v, index_v) in
                                        payroll_salary_tabulator.payroll_vertical_salary_scale.payroll_scales">
                                        <th>
                                            {{field_v.name}}
                                        </th>
                                        <td class="td-with-border"
                                            v-for="(field_h, index_h) in
                                            payroll_salary_tabulator.payroll_horizontal_salary_scale.payroll_scales">
                                            <div>
                                                <input type="text"
                                                       :id="'salary_scale_' + field_v.id + '_' + field_h.id"
                                                       class="form-control input-sm" data-toggle="tooltip"
                                                       :disabled="record.increase_of_type != 'different'"
                                                       onfocus="this.select()"
                                                       :value="getScaleValue(field_v.id, field_h.id)">
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table table-hover table-striped table-responsive table-assignment"
                                   v-else-if="payroll_salary_tabulator.payroll_horizontal_salary_scale_id == null
                                           && payroll_salary_tabulator.payroll_vertical_salary_scale_id > 0">
                                <thead>
                                    <th colspan="2">
                                        <strong>{{ payroll_salary_tabulator.name }}</strong>
                                    </th>
                                </thead>
                                <tbody>
                                    <tr class="text-center">
                                        <th>Nombre</th>
                                        <th>Incidencia</th>
                                    </tr>
                                    <tr class="text-center"
                                        v-for="(field, index) in
                                        payroll_salary_tabulator.payroll_vertical_salary_scale.payroll_scales">
                                        <th>
                                            {{field.name}}
                                        </th>
                                        <td>
                                            <div>
                                                <input type="text" :id="'salary_scale_v_' + field.id"
                                                       class="form-control input-sm" data-toggle="tooltip"
                                                       :disabled="record.increase_of_type != 'different'"
                                                       onfocus="this.select()"
                                                       :value="getScaleValue(field.id, null)">
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div style="padding-bottom: 20px;">
                        <div class="pull-right"
                             v-if="panel == 'Form'">
                            <button type="button" @click="loadSalaryScales()"
                                    class="btn btn-primary btn-wd btn-sm"
                                    :disabled="isDisableNext()"
                                    data-toggle="tooltip" title="">
                                Siguiente
                            </button>
                        </div>
                        <div class="pull-left"
                             v-else>
                            <button type="button" @click="changePanel('Form')"
                                    class="btn btn-default btn-wd btn-sm"
                                    data-toggle="tooltip" title="">
                                Regresar
                            </button>
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
                <button type="button" @click="createRecord(route_create)"
                        class="btn btn-success btn-icon btn-round">
                    <i class="fa fa-save"></i>
                </button>
            </div>

        </div>
    </section>
</template>

<script>
    import moment from 'moment';
    export default {
        data() {
            return {
                record: {
                    id:                          '',
                    value:                       '',
                    increase_of_date:            '',
                    increase_of_type:            '',
                    payroll_salary_tabulator_id: ''
                },

                payroll_salary_tabulator:  {},
                payroll_salary_tabulators: [],
                increase_of_types:         [
                    { id: '',               text: 'Seleccione...'},
                    { id: 'percentage',     text: 'Porcentual'},
                    { id: 'absolute_value', text: 'Valor absoluto'},
                    { id: 'different',      text: 'Diferente'}
                ],
                errors:                    [],
                records:                   [],
                panel:                     'Form'
            }
        },
        created() {
            const vm = this;
            vm.reset();
            vm.getPayrollSalaryTabulators();
        },
        mounted() {
            const vm = this;
            vm.record.created_at = moment(String(new Date())).format('YYYY-MM-DD');
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
                    id:                          '',
                    value:                       '',
                    increase_of_date:            '',
                    increase_of_type:            '',
                    payroll_salary_tabulator_id: ''
                };
                vm.record.created_at = moment(String(new Date())).format('YYYY-MM-DD');
            },
            /**
             * Reescribe el método showRecord para cambiar su comportamiento por defecto
             * Método que muestra datos de un registro seleccionado
             *
             * @author    Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             * @author    Henry Paredes <hparedes@cenditel.gob.ve>
             */
            showRecord() {
                const vm = this;
                let url = '';
                if (vm.record.payroll_salary_tabulator_id > 0) {
                    if (typeof(vm.route_show) !== "undefined" && vm.route_show) {
                        if (vm.route_show.indexOf("{id}") >= 0) {
                            url = vm.route_show.replace("{id}", vm.record.payroll_salary_tabulator_id);
                        } else {
                            url = vm.route_show + '/' + vm.record.payroll_salary_tabulator_id;
                        }
                        axios.get(url).then(response => {
                            if (typeof(response.data.record) !== "undefined") {
                                vm.payroll_salary_tabulator = response.data.record;
                            }
                        }).catch(error => {
                            if (typeof(error.response) !== "undefined") {
                                if (error.response.status == 403) {
                                    vm.showMessage(
                                        'custom', 'Acceso Denegado', 'danger', 'screen-error', error.response.data.message
                                    );
                                }
                                else {
                                    vm.logs('resources/js/all.js', 343, error, 'showRecord');
                                }
                            }
                        });
                    }
                }
            },
            /**
             * Método que habilita o deshabilita el botón siguiente
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve>
             */
            isDisableNext() {
                const vm = this;
                if ((vm.record.increase_of_date != '') && (vm.record.increase_of_type != '') &&
                    (vm.record.payroll_salary_tabulator_id != '')) {
                    if (vm.record.increase_of_type == 'different') {
                        return false;
                    } else if (vm.record.value != '') {
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
                if (panel == 'Show') {
                    complete = !vm.isDisableNext();
                } else {
                    complete = true;
                }
                if (complete == true) {
                    vm.panel    = panel;
                }
            },
            /**
             * Método que obtiene la información de los escalafones salariales seleccionados
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve>
             *
             */
            loadSalaryScales() {
                const vm = this;
                vm.changePanel('Show');
            },
            /**
             * Método que obtiene el valor de la escala según sea el caso
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve>
             *
             * @param    {integer}    vertical      Identificador único del escalafón vertical. Este campo es opcional
             * @param    {integer}    horizontal    Identificador único del escalafón horizontal. Este campo es opcional
             *
             */
            getScaleValue(vertical, horizontal) {
                const vm = this;
                let value = 0;
                $.each(vm.payroll_salary_tabulator.payroll_salary_tabulator_scales, function(index, field) {
                    if (field["payroll_vertical_scale_id"] == vertical &&
                        field["payroll_horizontal_scale_id"] == horizontal) {
                        if (vm.record.increase_of_type == 'percentage') {
                            value = JSON.parse(field.value) * JSON.parse(vm.record.value) / 100;
                        } else if (vm.record.increase_of_type == 'absolute_value') {
                            value = JSON.parse(field.value) + JSON.parse(vm.record.value);
                        } else {
                            value = JSON.parse(field.value);
                        }
                    }
                });
                return value;

            }
        }
    };
</script>
