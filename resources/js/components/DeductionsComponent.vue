<template>
    <div class="col-xs-2 text-center">
        <a class="btn-simplex btn-simplex-md btn-simplex-primary"
           href="#" title="Registros de Deducciones" data-toggle="tooltip"
           @click="addRecord('add_deduction', 'deductions', $event)">
            <i class="icofont icofont-mathematical-alt-2 ico-3x"></i>
            <span>Deducciones</span>
        </a>
        <div class="modal fade text-left" tabindex="-1" role="dialog" id="add_deduction">
            <div class="modal-dialog vue-crud" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h6>
                            <i class="icofont icofont-mathematical-alt-2 inline-block"></i>
                            Deducción
                        </h6>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" v-if="errors.length > 0">
                            <ul>
                                <li v-for="error in errors">{{ error }}</li>
                            </ul>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nombre:</label>
                                    <input type="text" placeholder="Nombre" data-toggle="tooltip"
                                           title="Indique el nombre de la deducción (requerido)"
                                           class="form-control input-sm" v-model="record.name">
                                    <input type="hidden" v-model="record.id">
                                </div>
                                <div class="form-group" v-if="accountingAccount">
                                    <label>Cuenta Contable:</label>
                                    <select2 :options="accounting_accounts"
                                             v-model="record.accounting_account_id"></select2>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Descripción:</label>
                                    <textarea v-model="record.description" class="form-control" rows="3" data-toggle="tooltip"
                                              title="Indique la descripción de la deducción"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Fórmula</label>
                                    <input type="text" class="form-control input-sm" data-toggle="tooltip"
                                           title="Fórmula a aplicar para la deducción. Utilice la siguiente calculadora para establecer los parámetros de la fórmula" v-model="record.formula" readonly>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="offset-sm-3 col-sm-6 text-center">
                                            <div class="btn btn-info btn-sm btn-formula" data-toggle="tooltip"
                                                 title="presione para agregar este dígito" data-value="1">1</div>
                                            <div class="btn btn-info btn-sm btn-formula" data-toggle="tooltip"
                                                 title="presione para agregar este dígito" data-value="2">2</div>
                                            <div class="btn btn-info btn-sm btn-formula" data-toggle="tooltip"
                                                 title="presione para agregar este dígito" data-value="3">3</div>
                                            <div class="btn btn-info btn-sm btn-formula" data-toggle="tooltip"
                                                 title="presione para agregar el digno de suma" data-value="+">+</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="offset-sm-3 col-sm-6 text-center">
                                            <div class="btn btn-info btn-sm btn-formula" data-toggle="tooltip"
                                                 title="presione para agregar este dígito" data-value="4">4</div>
                                            <div class="btn btn-info btn-sm btn-formula" data-toggle="tooltip"
                                                 title="presione para agregar este dígito" data-value="5">5</div>
                                            <div class="btn btn-info btn-sm btn-formula" data-toggle="tooltip"
                                                 title="presione para agregar este dígito" data-value="6">6</div>
                                            <div class="btn btn-info btn-sm btn-formula" data-toggle="tooltip"
                                                 title="presione para agregar el signo de resta" data-value="-">-</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="offset-sm-3 col-sm-6 text-center">
                                            <div class="btn btn-info btn-sm btn-formula" data-toggle="tooltip"
                                                 title="presione para agregar este dígito" data-value="7">7</div>
                                            <div class="btn btn-info btn-sm btn-formula" data-toggle="tooltip"
                                                 title="presione para agregar este dígito" data-value="8">8</div>
                                            <div class="btn btn-info btn-sm btn-formula" data-toggle="tooltip"
                                                 title="presione para agregar este dígito" data-value="9">9</div>
                                            <div class="btn btn-info btn-sm btn-formula" data-toggle="tooltip"
                                                 title="presione para agregar el signo de multiplicación"
                                                 data-value="*">*</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="offset-sm-3 col-sm-6 text-center">
                                            <div class="btn btn-info btn-sm btn-formula-clear" data-toggle="tooltip"
                                                 title="Reinicia el campo de la fórmula"
                                                 @click="record.formula = ''">C</div>
                                            <div class="btn btn-info btn-sm btn-formula" data-toggle="tooltip"
                                                 title="presione para agregar este dígito" data-value="0">0</div>
                                            <div class="btn btn-info btn-sm btn-formula" data-toggle="tooltip"
                                                 title="presione para agregar el separador de decimales"
                                                 data-value=".">.</div>
                                            <div class="btn btn-info btn-sm btn-formula" data-toggle="tooltip"
                                                 title="presione para agregar el signo de división"
                                                 data-value="/">/</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="offset-sm-3 col-sm-6 col-btn-block text-center">
                                            <div class="btn btn-info btn-sm btn-formula btn-block" data-toggle="tooltip"
                                                 title="Variable a usar para el monto deducible cuando se realice el cálculo" data-value="monto">
                                                DEDUCIBLE
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Activa</label>
                                    <div class="col-md-12">
                                        <label for="">
                                            <input type="checkbox" class="form-control bootstrap-switch"
                                                   name="active" id="active" data-toggle="tooltip"
                                                   data-on-label="SI" data-off-label="NO"
                                                   title="Indique si la deducción se encuentra activa"
                                                   v-model.lazy="record.active" value="true"
                                                   data-record="active">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group">
                            <modal-form-buttons :saveRoute="'deductions'"></modal-form-buttons>
                        </div>
                    </div>
                    <div class="modal-body modal-table">
                        <v-client-table :columns="columns" :data="records" :options="table_options">
                            <div slot="active" slot-scope="props" class="text-center">
                                <span v-if="props.row.active === true" class="text-bold text-success">SI</span>
                                <span v-else class="text-bold text-danger">NO</span>
                            </div>
                            <div slot="accounting_account" slot-scope="props" class="text-center">
                                <span v-if="props.row.accounting_account !== null">
                                    {{ props.row.accounting_account.group }}.
                                    {{ props.row.accounting_account.subgroup }}.
                                    {{ props.row.accounting_account.item }}.
                                    {{ props.row.accounting_account.generic }}.
                                    {{ props.row.accounting_account.specific }}.
                                    {{ props.row.accounting_account.subspecific }}
                                </span>
                                <span v-else>
                                    NO REGISTRADA
                                </span>
                            </div>
                            <div slot="id" slot-scope="props" class="text-center">
                                <button @click="initUpdate(props.index, $event)"
                                        class="btn btn-warning btn-xs btn-icon btn-action"
                                        title="Modificar registro" data-toggle="tooltip" type="button">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button @click="deleteRecord(props.index, 'deductions')"
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
    </div>
</template>

<style>
    .btn-sm.btn-formula, .btn-sm.btn-formula-clear {
        font-size: .65rem;
        font-weight: bold;
    }
    .col-btn-block {
        padding-left: 36px;
        padding-right: 36px;
    }
</style>

<script>
    export default {
        data() {
            return {
                record: {
                    id: '',
                    accounting_account_id: '',
                    name: '',
                    description: '',
                    formula: '',
                    active: false
                },
                errors: [],
                records: [],
                accounting_accounts: [],
                columns: ['name', 'description', 'formula', 'accounting_account', 'active', 'id'],
            }
        },
        props: {
            accountingAccount: {
                type: Boolean,
                required: true,
                default: false
            }
        },
        methods: {
            /**
             * Método que borra todos los datos del formulario
             *
             * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             */
            reset() {
                this.record = {
                    id: '',
                    accounting_account_id: (this.accountingAccount) ? '' : null,
                    name: '',
                    description: '',
                    formula: '',
                    active: false
                };
            },
            /**
             * Obtiene un listado de cuentas patrimoniales
             *
             * @method     getAccountingAccounts
             *
             * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
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
                    vm.logs('DeductionsComponent', 258, error, 'getAccountingAccounts');
                });
            }
        },
        created() {
            this.table_options.headings = {
                'name': 'Nombre',
                'description': 'Descripción',
                'formula': 'Fórmula',
                'accounting_account': 'Cuenta Contable',
                'active': 'Activa',
                'id': 'Acción'
            };
            this.table_options.sortable = ['name', 'description'];
            this.table_options.filterable = ['name', 'description'];
            this.table_options.columnsClasses = {
                'name': 'col-md-2',
                'description': 'col-md-3',
                'formula': 'col-md-2',
                'accounting_account': 'col-md-2',
                'active': 'col-md-1',
                'id': 'col-md-2'
            };
        },
        mounted() {
            let vm = this;
            vm.switchHandler('active');
            $("#add_deduction").on('show.bs.modal', function() {
                vm.reset();
                if (vm.accountingAccount) {
                    vm.getAccountingAccounts();
                }
            });
            $('.btn-formula').on('click', function() {
                vm.record.formula += $(this).data('value');
            });
        }
    };
</script>
