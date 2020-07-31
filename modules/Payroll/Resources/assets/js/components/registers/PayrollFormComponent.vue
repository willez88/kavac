<template>
    <section id="PayrollFormComponent">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title">Generar Nómina</h6>
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
                                   title="Fecha de generación del registro de nómina"
                                   class="form-control input-sm" v-model="record.created_at">
                        </div>
                        <!-- ./fecha de generación -->
                    </div>
                    <div class="col-md-6">
                        <!-- nombre -->
                        <div class="form-group is-required">
                            <label>Nombre:</label>
                            <input type="text" placeholder="Nombre del concepto"
                                   data-toggle="tooltip"
                                   title="Indique el nombre del registro de nómina (requerido)"
                                   v-input-mask data-inputmask-regex="[a-zA-Z ]*"
                                   class="form-control input-sm" v-model="record.name">
                            <input type="hidden" v-model="record.id">
                        </div>
                        <!-- ./nombre -->
                    </div>
                    <div class="col-md-6">
                        <!-- tipo de pago de nómina -->
                        <div class="form-group is-required">
                            <label>Tipo de pago de nómina:</label>
                            <select2 :options="payroll_payment_types"
                                     @input="getPayrollPaymentPeriod()"
                                     v-model="record.payroll_payment_type_id"></select2>
                        </div>
                        <!-- ./tipo de pago de nómina -->
                    </div>
                    <div class="col-md-6">
                        <!-- período de pago -->
                        <div class="form-group is-required">
                            <label>Período de pago:</label>
                            <select2 :options="payroll_payment_periods" disabled
                                     v-model="record.payroll_payment_period_id"></select2>
                        </div>
                        <!-- ./período de pago -->
                    </div>
                    <div class="col-md-6">
                        <!-- conceptos -->
                        <div class="form-group is-required">
                            <label>Conceptos:</label>
                            <v-multiselect id="payroll_concepts"
                                           :options="payroll_concepts" track_by="text"
                                           :hide_selected="false"
                                           @input="getPayrollParameters()"
                                           v-model="record.payroll_concepts">
                            </v-multiselect>
                        </div>
                        <!-- ./conceptos -->
                    </div>
                </div>
                <div v-if="payroll_parameters.length > 0">
                    <hr>
                    <h6 class="card-title">Parámetros de nómina</h6>
                    <div class="row">
                        <!-- parámetros globales de nómina -->
                        <div class="col-md-6"
                             v-for="payroll_parameter in payroll_parameters">
                            <div class="form-group is-required">
                                <label>{{ payroll_parameter['code'] }}:</label>
                                <input :id="'parameter_' + payroll_parameter['code']"
                                       class="form-control input-sm"
                                       type="text" data-toggle="tooltip"
                                       :disabled="payroll_parameter['value'] != ''"
                                       :value="payroll_parameter['value']"
                                       v-if="payroll_parameter['value']">

                                <input :id="'parameter_' + payroll_parameter['code']"
                                       type="text" data-toggle="tooltip"
                                       :title="'Indique el parámetro '+ payroll_parameter['code'] + ' (requerido)'"
                                       class="form-control input-sm"
                                       v-input-mask data-inputmask-regex="^[0-9]+\.[0-9]{2}$"
                                       v-else>
                            </div>
                        
                        </div>
                        <!-- ./parámetros globales de nómina -->
                    </div>
                </div>
            </div>

            <div class="card-footer text-right">
                <button type="button" @click="reset"
                        class="btn btn-default btn-icon btn-round" data-toggle="tooltip" 
                        title="Borrar datos del formulario">
                    <i class="fa fa-eraser"></i>
                </button>
                <button type="button" @click="redirect_back(route_list)"
                        class="btn btn-warning btn-icon btn-round" data-toggle="tooltip"
                        title="Cancelar y regresar">
                    <i class="fa fa-ban"></i>
                </button>
                <button type="button" @click="createForm('payroll/registers')"
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
                    id:                        '',
                    name:                      '',
                    payroll_payment_type_id:   '',
                    payroll_payment_period_id: '',
                    payroll_concepts:          [],
                    payroll_parameters:        []
                },

                payroll_payment_types:   [],
                payroll_payment_periods: [],
                payroll_concepts:        [],
                payroll_parameters:      [],
                errors:                  [],
                records:                 []
            }
        },
        props: {
            payroll_id: {
                type: Number,
                required: false,
                default: ''
            }
        },
        created() {
            const vm = this;
            vm.reset();
            vm.getPayrollConcepts();
            vm.getPayrollPaymentTypes();
        },
        mounted() {
            const vm = this;
            if (vm.payroll_id) {

            } else {
                vm.record.created_at = moment(String(new Date())).format('YYYY-MM-DD');
            }
        },
        watch: {
            /**
             * Método que supervisa los cambios en el objeto record y actualiza el período de pago seleccionado
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve> | <henryp2804@gmail.com>
             */
            record: {
                deep: true,
                handler: function() {
                    const vm = this;
                    if (vm.record.payroll_payment_period_id == '') {
                        $.each(vm.payroll_payment_periods, function(index, field) {
                            if ((field['payment_status'] == 'pending') && (vm.record.payroll_payment_period_id == '')) {
                                vm.record.payroll_payment_period_id = field['id'];
                            }
                        });
                    }
                }
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
                    id:                        '',
                    name:                      '',
                    payroll_payment_type_id:   '',
                    payroll_payment_period_id: '',
                    payroll_concepts:          [],
                    payroll_parameters:        []
                };
                vm.record.created_at = moment(String(new Date())).format('YYYY-MM-DD');
            },
            /**
             * Método que obtiene un arreglo con los periodos de pago asociados al tipo de pago
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve>
             */
            getPayrollPaymentPeriod() {
                const vm = this;
                vm.payroll_parameters               = [];
                vm.record.payroll_concepts          = [];
                vm.payroll_payment_periods          = [];
                vm.record.payroll_payment_period_id = '';
                
                if (vm.record.payroll_payment_type_id > 0) {
                    axios.get('/payroll/get-payment-periods/' + vm.record.payroll_payment_type_id).then(response => {
                        vm.payroll_payment_periods = response.data.records;
                        vm.record.payroll_concepts = response.data.concepts;
                    });
                }
            },
            /**
             * Método que obtiene un arreglo con los parámetros de nómina asociados a un concepto
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve>
             */
            getPayrollParameters() {
                const vm = this;
                vm.payroll_parameters = [];
                if (vm.record.payroll_concepts.length > 0) {
                    var fields = {};
                    fields['payroll_concepts'] = vm.record['payroll_concepts']
                                                     ? vm.record['payroll_concepts']
                                                     : [];
                    axios.post('/payroll/get-parameters', fields).then(response => {
                        vm.payroll_parameters = response.data;
                    });
                }
            },
            createForm(url) {
                const vm   = this;
                vm.errors  = [];
                let result = true;
                let payroll_parameters = [];

                $.each(vm.payroll_parameters, function(index, field) {
                    let input = document.getElementById('parameter_' + field['code']);
                    payroll_parameters.push({
                        code:  field['code'],
                        value: input.value
                    });
                    if(input.value.trim() == '') {
                        bootbox.alert("Debe establecer todos los parámetros de nómina antes de continuar");
                        result = false;
                    };
                });
                if (result) {
                    vm.record.payroll_parameters = payroll_parameters;
                    vm.createRecord(url);
                }
            }
        }
    };
</script>
