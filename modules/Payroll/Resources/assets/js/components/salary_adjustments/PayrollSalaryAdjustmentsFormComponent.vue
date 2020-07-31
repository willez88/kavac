<template>
    <section id="PayrollSalaryAdjustmentsFormComponent">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title">Actualizar tablas salariales</h6>
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
                                   data-toggle="tooltip"
                                   title="Indique el valor"
                                   class="form-control input-sm"
                                   v-input-mask data-inputmask-regex="^[0-9]+\.{0,1}[0-9]{2}$"
                                   v-model="record.value">
                        </div>
                        <!-- ./valor -->
                    </div>
                </div>
                <pre>
                    {{ payroll_salary_tabulator }}
                </pre>
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
                records:                   []
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
        }
    };
</script>
