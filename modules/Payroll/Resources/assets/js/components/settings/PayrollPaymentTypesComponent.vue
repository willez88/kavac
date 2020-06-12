<template>
    <section id="PayrollPaymentTypesComponent">
        <a class="btn-simplex btn-simplex-md btn-simplex-primary" href=""
           title="Registros de tipos de pago" data-toggle="tooltip"
           @click="addRecord('add_payroll_payment_type', 'payment-types', $event)">
           <i class=""></i>
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
                            <i class=""></i>
                            Tipo de Pago
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
                                    <input type="text" id="code" placeholder="Código"
                                           class="form-control input-sm" v-model="record.code" data-toggle="tooltip"
                                           title="Indique el códigoe del tipo de pago (requerido)">
                                    <input type="hidden" name="id" id="id" v-model="record.id">
                                </div>
                            </div>
                            <!-- ./código -->
                            <!-- nombre -->
                            <div class="col-md-4">
                                <div class="form-group is-required">
                                    <label for="name">Nombre:</label>
                                    <input type="text" id="name" placeholder="Nombre"
                                           class="form-control input-sm" v-model="record.name" data-toggle="tooltip"
                                           title="Indique el nombre del tipo de pago (requerido)">
                                </div>
                            </div>
                            <!-- ./nombre -->
                            <!-- cuenta contable -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Cuenta contable</label>
                                    <select2 :options="accounting_accounts"
                                             v-model="record.accounting_account_id"></select2>
                                </div>
                            </div>
                            <!-- ./cuenta contable -->
                            <!-- cuenta presupuestaria -->
                            <div class="col-md-4">
                                <div class="form-group is-required">
                                    <label>Cuenta presupuestario</label>
                                    <select2 :options="budget_accounts"
                                             v-model="record.budget_account_id"></select2>
                                </div>
                            </div>
                            <!-- ./cuenta presupuestaria -->
                            <!-- periodicidad de pago -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Periodicidad de pago</label>
                                    <select2 :options="payment_periodicities"
                                             v-model="record.payment_periodicity"></select2>
                                </div>
                            </div>
                            <!-- ./periodicidad de pago -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="periods">Períodos:</label>
                                    <input type="text" id="periods" placeholder="Número de períodos"
                                           class="form-control input-sm" v-model="record.description"
                                           data-toggle="tooltip" title="Número de períodos del tipo de pago">
                                </div>
                            </div>
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
                            <!-- fecha de inicio -->
                            <div class="col-md-4">
                                <div class="form-group is-required">
                                    <label>Fecha de inicio del primer período:</label>
                                    <input type="date" id="start_date" placeholder="Fecha de inicio"
                                           class="form-control input-sm" v-model="record.start_date"
                                           data-toggle="tooltip" title="Indique la fecha de inicio del primer período">
                                </div>
                            </div>
                            <!-- ./fecha de inicio -->
                            <!-- relación de pago -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Relación de pago</label>
                                    <select2 :options="payment_relationships"
                                             v-model="record.payment_relationship"></select2>
                                </div>
                            </div>
                            <!-- ./relación de pago -->
                            <div class="col-md-6"
                                 v-if="record.correlative">
                                <div class="form-group is-required">
                                    <label>Campos del expediente del trabajador:</label>
                                    <v-multiselect :options="associated_records" track_by="text"
                                                   :hide_selected="false" group-values="children"
                                                   group-label="text" v-model="record.associated_records">
                                    </v-multiselect>
                                </div>
                            </div>
                            <!-- conceptos -->
                            <div class="col-md-6">
                                <div class="form-group is-required">
                                    <label>Conceptos:</label>
                                    <v-multiselect :options="payroll_concepts" track_by="text"
                                                   :hide_selected="false"
                                                   v-model="record.payroll_concepts">
                                    </v-multiselect>
                                </div>
                            </div>
                            <!-- ./conceptos -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group">
                            <modal-form-buttons :saveRoute="'payroll/payment-types'"></modal-form-buttons>
                        </div>
                    </div>
                    <div class="modal-body modal-table">
                        <v-client-table :columns="columns" :data="records" :options="table_options">
                            <div slot="id" slot-scope="props" class="text-center">
                                <button @click="initUpdate(props.index, $event)"
                                        class="btn btn-warning btn-xs btn-icon btn-action"
                                        title="Modificar registro" data-toggle="tooltip" type="button">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button @click="deleteRecord(props.index, 'payment-types')"
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
                    id:                    '',
                    code:                  '',
                    name:                  '',
                    payment_periodicity:   '',
                    periods_number:        '',
                    correlative:           false,
                    start_date:            '',
                    payment_relationship:  '',
                    budget_account_id:     '',
                    accounting_account_id: '',
                    payroll_concepts:      [],
                    associated_records:    []

                },
                errors:                [],
                records:               [],
                columns:               ['code', 'name', 'payment_periodicity', 'id'],
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
                payroll_concepts:      [],
                budget_accounts:       [],
                accounting_accounts:   [],
                associated_records:    []
            }
        },
        created() {
            const vm = this;
            vm.table_options.headings = {
                'code':                'Código',
                'name':                'Nombre',
                'payment_periodicity': 'Periodicidad',
                'id':                  'Acción'
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
                vm.getAccountingAccounts();
                vm.getBudgetAccounts();
                vm.getOptions('payroll/get-associated-records');
            });
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
                    id:                    '',
                    code:                  '',
                    name:                  '',
                    payment_periodicity:   '',
                    periods_number:        '',
                    correlative:           false,
                    start_date:            '',
                    payment_relationship:  '',
                    budget_account_id:     '',
                    accounting_account_id: '',
                    payroll_concepts:      [],
                    associated_records:    []
                };
            },

            /**
             * Obtiene un listado de cuentas patrimoniales
             *
             * @author    Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             */
            getAccountingAccounts() {
                const vm = this;
                vm.accounting_accounts = [];
                axios.get('/accounting/accounts').then(response => {
                    if (response.data.records.length > 0) {
                        vm.accounting_accounts.push({
                            id: '',
                            text: 'Seleccione...'
                        });
                        $.each(response.data.records, function() {
                            vm.accounting_accounts.push({
                                id: this.id,
                                text: `${this.code} - ${this.denomination}`
                            });
                        });
                    }
                }).catch(error => {
                    vm.logs('PayrollPaymentTypesComponent', 258, error, 'getAccountingAccounts');
                });
            },

            /**
             * Obtiene un listado de cuentas presupuestarias
             *
             * @author    Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             */
            getBudgetAccounts() {
                const vm = this;
                vm.budget_accounts = [];
                axios.get('/budget/accounts/vue-list').then(response => {
                    if (response.data.records.length > 0) {
                        vm.budget_accounts.push({
                            id:   '',
                            text: 'Seleccione...'
                        });
                        $.each(response.data.records, function() {
                            vm.budget_accounts.push({
                                id:   this.id,
                                text: `${this.code} - ${this.denomination}`
                            });
                        });
                    }
                }).catch(error => {
                    vm.logs('PayrollPaymentTypesComponent', 258, error, 'getBudgetAccounts');
                });
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
                    vm.associated_records = response.data;
                });
            },
        }
    };
</script>
