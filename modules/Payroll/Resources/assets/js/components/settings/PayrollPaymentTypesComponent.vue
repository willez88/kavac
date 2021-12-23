<template>
    <section id="payrollPaymentTypesFormComponent">
        <a class="btn-simplex btn-simplex-md btn-simplex-primary" href=""
           title="Registros de tipos de pago" data-toggle="tooltip"
           @click="addRecord('add_payroll_payment_type', 'payroll/payment-types', $event)">
           <i class="icofont icofont icofont-law-document ico-3x"></i>
           <span>Tipos de<br>Pago</span>
        </a>
        <div class="modal fade text-left" tabindex="-1" role="dialog" id="add_payroll_payment_type">
            <div class="modal-dialog vue-crud" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h6>
                            <i class="icofont icofont-law-document ico-3x"></i>
                            Tipo de Pago de Nómina
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
                        <div class="row">
                            <!-- código -->
                            <div class="col-md-4">
                                <div class="form-group is-required">
                                    <label for="code">Código:</label>
                                    <input type="text" id="code" placeholder="Código" data-toggle="tooltip"
                                           title="Indique el códigoe del tipo de pago (requerido)"
                                           class="form-control input-sm" v-model="record.code">
                                    <input type="hidden" name="id" id="id" v-model="record.id">
                                </div>
                            </div>
                            <!-- ./código -->
                            <!-- nombre -->
                            <div class="col-md-4">
                                <div class="form-group is-required">
                                    <label for="name">Nombre:</label>
                                    <input type="text" id="name" placeholder="Nombre" data-toggle="tooltip"
                                           title="Indique el nombre del tipo de pago (requerido)"
                                           class="form-control input-sm" v-model="record.name">
                                </div>
                            </div>
                            <!-- ./nombre -->
                            <!-- periodicidad de pago -->
                            <div class="col-md-4">
                                <div class="form-group is-required">
                                    <label>Periodicidad de pago</label>
                                    <select2 :options="payment_periodicities"
                                             @input="record.periods_number = '';record.payroll_payment_periods = [];"
                                             v-model="record.payment_periodicity"></select2>
                                </div>
                            </div>
                            <!-- ./periodicidad de pago -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="periods">Períodos:</label>
                                    <input type="text" id="periods" placeholder="0" readonly
                                           data-toggle="tooltip" title="Número de períodos del tipo de pago"
                                           class="form-control input-sm" v-model="record.periods_number">
                                </div>
                            </div>
                            <!-- fecha de inicio -->
                            <div class="col-md-4">
                                <div class="form-group is-required">
                                    <label>Fecha de inicio del primer período:</label>
                                    <input type="date" id="start_date" placeholder="Fecha de inicio"
                                           data-toggle="tooltip" title="Indique la fecha de inicio del primer período"
                                           class="form-control input-sm"
                                           :min="start_operations_date" v-model="record.start_date">
                                </div>
                            </div>
                            <!-- ./fecha de inicio -->
                            <!-- relación de pago -->
                            <div class="col-md-4">
                                <div class="form-group is-required">
                                    <label>Relación de pago</label>
                                    <select2 :options="payment_relationships"
                                             v-model="record.payment_relationship"></select2>
                                </div>
                            </div>
                            <!-- ./relación de pago -->
                            <!-- correlativo al expediente de trabajador -->
                            <div class="col-md-4">
                                <div class=" form-group">
                                    <label>¿Correlativo al expediente del trabajador?</label>
                                    <div class="col-12">
                                        <p-check class="pretty p-switch p-fill p-bigger"
                                                 color="success" off-color="text-gray" toggle
                                                 data-toggle="tooltip"
                                                 title="¿El tipo de pago es correlativo al expediente del trabajador?"
                                                 v-model="record.correlative">
                                            <label slot="off-label"></label>
                                        </p-check>
                                    </div>
                                </div>
                            </div>
                            <!-- ./correlativo al expediente de trabajador -->
                            <!-- conceptos -->
                            <div class="col-md-8">
                                <div class="form-group is-required">
                                    <label>Conceptos:</label>
                                    <v-multiselect :options="payroll_concepts" track_by="text"
                                                   :hide_selected="false"
                                                   v-model="record.payroll_concepts">
                                    </v-multiselect>
                                </div>
                            </div>
                            <!-- ./conceptos -->
                            <!-- campos del expediente de trabajador -->
                            <div class="col-md-12"
                                 v-show="record.correlative">
                                <div class="form-group is-required">
                                    <label>Campos del expediente del trabajador:</label>
                                    <v-multiselect :options="associated_records" track_by="text"
                                                   :hide_selected="false"
                                                   v-model="record.associated_records">
                                    </v-multiselect>
                                </div>
                            </div>
                            <!-- ./campos del expediente de trabajador -->
                        </div>
                        <div class="row">
                            <div class="col-12 text-right"
                                 v-if="view_periods == true">
                                <button class="btn btn-primary btn-sm" type="button"
                                        @click="view_periods = false;"
                                        title="Ocultar períodos de nómina" data-toggle="tooltip">
                                    Ocultar períodos
                                </button>
                            </div>
                            <div class="col-12 text-right"
                                 v-else-if="record.payment_periodicity
                                    && record.start_date">
                                <button class="btn btn-primary btn-sm" type="button"
                                        @click="view_periods = true;"
                                        title="Ver períodos de nómina" data-toggle="tooltip">
                                    Ver períodos
                                </button>
                            </div>

                            <div class="col-12 modal-table"
                                 v-if="view_periods">
                                <v-client-table :columns="periods_columns" :data="record.payroll_payment_periods"
                                                :options="table_options">
                                    <div slot="payment_status" slot-scope="props" class="text-center">
                                        <span>
                                            {{
                                                (props.row.payment_status == 'pending')
                                                    ? 'Pendiente'
                                                    : 'Generado'
                                            }}
                                        </span>
                                    </div>
                                </v-client-table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group">
                            <modal-form-buttons :saveRoute="'payroll/payment-types'"></modal-form-buttons>
                        </div>
                    </div>
                    <div class="modal-body modal-table">
                        <v-client-table :columns="columns" :data="records" :options="table_options">
                            <div slot="payment_periodicity" slot-scope="props" class="text-center">
                                <span> {{ getPaymentPeriodicity(props.row.payment_periodicity) }} </span>
                            </div>
                            <div slot="id" slot-scope="props" class="text-center">
                                <button @click="initUpdate(props.row.id, $event)"
                                        class="btn btn-warning btn-xs btn-icon btn-action"
                                        title="Modificar registro" data-toggle="tooltip" type="button">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button @click="deleteRecord(props.index, 'payroll/payment-types')"
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
                    id:                      '',
                    code:                    '',
                    name:                    '',
                    payment_periodicity:     '',
                    periods_number:          '',
                    correlative:             false,
                    start_date:              '',
                    payment_relationship:    '',
                    payroll_concepts:        [],
                    associated_records:      [],
                    payroll_payment_periods: []

                },
                view_periods:          false,
                errors:                [],
                records:               [],
                columns:               ['code', 'name', 'payment_periodicity', 'id'],
                periods_columns:       ['number', 'start_date', 'start_day', 'end_date', 'end_day', 'payment_status'],
                payment_periodicities: [
                    {"id": "",              "text": "Seleccione..."},
                    {"id": "daily",         "text": "Diario"},
                    {"id": "weekly",        "text": "Semanal"},
                    {"id": "biweekly",      "text": "Quincenal"},
                    {"id": "monthly",       "text": "Mensual"},
                    {"id": "bimonthly",     "text": "Bimensual"},
                    {"id": "three-monthly", "text": "Trimestral"},
                    {"id": "four-monthly",  "text": "Cuatrimestral"},
                    {"id": "biannual",      "text": "Semestral"},
                    {"id": "annual",        "text": "Anual"},
                    {"id": "not_apply",     "text": "No Aplica"}
                ],
                payment_relationships: [
                    {"id": "",                           "text": "Seleccione..."},
                    {"id": "payroll",                    "text": "Nómina"},
                    {"id": "comprehensive_wages",        "text": "Salarios Integrales"},
                    {"id": "utilities",                  "text": "Utilidades"},
                    {"id": "vacations",                  "text": "Vacaciones"},
                    {"id": "social_benefits_guarantees", "text": "Garantías de prestaciones sociales"},
                    {"id": "social_benefit_interests",   "text": "Intereses de prestaciones sociales"},
                    {"id": "liquidations",               "text": "Liquidaciones"},
                    {"id": "ticket_basket",              "text": "Cesta ticket"},
                    {"id": "kindergarten",               "text": "Guardería"},
                    {"id": "special_payroll",            "text": "Nómina especial"},
                    {"id": "others",                     "text": "Otros"}
                ],
                days:                  [
                    'Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'
                ],
                payroll_concepts:      [],
                associated_records:    []
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
                'code':                'Código',
                'name':                'Nombre',
                'payment_periodicity': 'Periodicidad',
                'id':                  'Acción',
                'number':              'N°',
                'start_date':          'Inicio de Período',
                'start_day':           'Día Inicial',
                'end_date':            'Fin de Período',
                'end_day':             'Día Final',
                'payment_status':      'Status de Pago'
            };
            vm.table_options.sortable       = ['code', 'name', 'payment_periodicity', 'id'];
            vm.table_options.filterable     = ['code', 'name', 'payment_periodicity', 'id'];
            vm.table_options.columnsClasses = {
                'code':                'col-xs-4',
                'name':                'col-xs-4',
                'payment_periodicity': 'col-xs-2',
                'id':                  'col-xs-2'
            };
        },
        mounted() {
            const vm = this;
            $("#add_payroll_payment_type").on('show.bs.modal', function() {
                vm.reset();
                vm.getPayrollConcepts();
                vm.getOptions('payroll/get-associated-records');
            });
        },
        watch: {
            /**
             * Método que supervisa los cambios en el objeto record y actualiza el número de períodos
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve> | <henryp2804@gmail.com>
             */
            record: {
                deep: true,
                handler: function() {
                    if (this.record.payment_periodicity != '' && this.record.periods_number == '') {
                        let number = 0;
                        if (this.record.payment_periodicity == 'daily') {
                            number = 365;
                        } else if (this.record.payment_periodicity == 'weekly') {
                            number = 48;
                        } else if (this.record.payment_periodicity == 'biweekly') {
                            number = 24;
                        } else if (this.record.payment_periodicity == 'monthly') {
                            number = 12;
                        } else if (this.record.payment_periodicity == 'bimonthly') {
                            number = 6;
                        } else if (this.record.payment_periodicity == 'three-monthly') {
                            number = 4;
                        } else if (this.record.payment_periodicity == 'four-monthly') {
                            number = 3;
                        } else if (this.record.payment_periodicity == 'biannual') {
                            number = 2;
                        } else if (this.record.payment_periodicity == 'annual') {
                            number = 1;
                        } else {
                            number = 0;
                        }
                        this.record.periods_number = number;
                    };
                    if ((this.record.periods_number > 0) && (this.record.payroll_payment_periods) && (this.record.payroll_payment_periods.length == 0) && (this.record.start_date != '')) {
                        let array_start = '';
                        let array_end = '';
                        let number_day_start = '';
                        let number_day_end = '';
                        let current_date = this.record.start_date;
                        let start_date = '';
                        let end_date = '';
                        let start_day = '';
                        let end_day = '';

                        for (var i = 0; i <= this.record.periods_number - 1; i++) {
                            if (this.record.payment_periodicity == 'daily') {
                                start_date = this.add_period(String(current_date), i, 'days');
                                end_date = this.add_period(String(current_date), (i + 1), 'days');
                            } else if (this.record.payment_periodicity == 'weekly') {
                                start_date = this.add_period(String(current_date), (8 * i), 'days');
                                end_date = this.add_period(String(current_date), (8 * (i + 1)), 'days');
                            } else if (this.record.payment_periodicity == 'biweekly') {
                                start_date = this.add_period(String(current_date), (15 * i), 'days');
                                end_date = this.add_period(String(current_date), (15 * (i + 1)), 'days');
                            } else if (this.record.payment_periodicity == 'monthly') {
                                start_date = this.add_period(String(current_date), (1 * i), 'months');
                                end_date = this.add_period(String(current_date), (1 * (i + 1)), 'months');
                            } else if (this.record.payment_periodicity == 'bimonthly') {
                                start_date = this.add_period(String(current_date), (2 * i), 'months');
                                end_date = this.add_period(String(current_date), (2 * (i + 1)), 'months');
                            } else if (this.record.payment_periodicity == 'three-monthly') {
                                start_date = this.add_period(String(current_date), (3 * i), 'months');
                                end_date = this.add_period(String(current_date), (3 * (i + 1)), 'months');
                            } else if (this.record.payment_periodicity == 'four-monthly') {
                                start_date = this.add_period(String(current_date), (4 * i), 'months');
                                end_date = this.add_period(String(current_date), (4 * (i + 1)), 'months');
                            } else if (this.record.payment_periodicity == 'biannual') {
                                start_date = this.add_period(String(current_date), (6 * i), 'months');
                                end_date = this.add_period(String(current_date), (4 * (i + 1)), 'months');
                            } else if (this.record.payment_periodicity == 'annual') {
                                start_date = this.add_period(String(current_date), (1 * i), 'years');
                                end_date = this.add_period(String(current_date), (1 * (i + 1)), 'years');
                            }
                            /** Revisar: moment(String(current_date)).weekday();  retorna NaN */
                            array_start = start_date.split('/');
                            array_end = end_date.split('/');
                            number_day_start = new Date(array_start[2] + '/' + array_start[1] + '/' + array_start[0]).getDay();
                            number_day_end = new Date(array_end[2] + '/' + array_end[1] + '/' + array_end[0]).getDay();
                            this.record.payroll_payment_periods.push({
                                number:         i + 1,
                                start_date:     start_date,
                                start_day:      this.days[number_day_start],
                                end_date:       end_date,
                                end_day:        this.days[number_day_end],
                                payment_status: 'pending'

                            });
                        }
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
                const vm = this;
                vm.record = {
                    id:                      '',
                    code:                    '',
                    name:                    '',
                    payment_periodicity:     '',
                    periods_number:          '',
                    correlative:             false,
                    start_date:              '',
                    payment_relationship:    '',
                    payroll_concepts:        [],
                    associated_records:      [],
                    payroll_payment_periods: []
                };
                vm.view_periods = false;
            },
            /**
             * Reescribe el método "getOptions" para cambiar su comportamiento por defecto
             * Método que obtiene un arreglo con las opciones a listar
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve>
             */
            getOptions(url) {
                const vm = this;
                vm.associated_records = [];
                axios.get('/' + url).then(response => {
                    if (response.data.length > 0) {
                        $.each(response.data, function(index, field) {
                            if (typeof(field['children']) != 'undefined') {
                                $.each(field['children'], function(index, field) {
                                    vm.associated_records.push(field);
                                });
                            } else {
                                vm.associated_records.push(field);
                            }
                        });
                    }
                });
            },

            getPaymentPeriodicity(payment_periodicity) {
                const vm = this;
                let value = '';
                $.each(vm.payment_periodicities, function(index, field) {
                    if (field['id'] == payment_periodicity) {
                        value = field['text'];
                    }
                });
                return value;
            }
        }
    };
</script>
