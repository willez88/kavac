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
                            <input type="text" readonly 
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
                                   class="form-control input-sm" v-model="record.name">
                            <input type="hidden" v-model="record.id">
                        </div>
                        <!-- ./nombre -->
                    </div>
                    <div class="col-md-6">
                        <!-- tipo de pago de nómina -->
                        <div class=" form-group is-required">
                            <label>Tipo de pago de nómina:</label>
                            <select2 :options="payroll_payment_types"
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
                            <v-multiselect :options="payroll_concepts" track_by="text"
                                           :hide_selected="false"
                                           v-model="record.payroll_concepts">
                            </v-multiselect>
                        </div>
                        <!-- ./conceptos -->
                    </div>
                    <div class="col-md-6">
                        <!-- parámetros globales de nómina -->
                        <div class="form-group is-required">
                            <label>Parámetros de nómina:</label>
                            <v-multiselect :options="payroll_parameters" track_by="text"
                                           :hide_selected="false"
                                           v-model="record.payroll_parameters">
                            </v-multiselect>
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
                <button type="button" @click="createRecord('payroll/registers')"
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
            vm.getOptions('payroll/get-parameters');
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
                    id:          '',
                    name:        '',
                    payroll_payment_type_id: ''
                };
            },
            /**
             * Método que obtiene un arreglo con las opciones a listar
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve>
             */
            getOptions(url) {
                const vm = this;
                vm.payroll_parameters = [];
                axios.get('/' + url).then(response => {
                    vm.payroll_parameters = response.data;
                });
            },
        }
    };
</script>
