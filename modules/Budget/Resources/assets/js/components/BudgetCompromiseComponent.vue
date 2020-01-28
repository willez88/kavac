<template>
    <div>
        <div class="card-body">
            <div class="alert alert-danger" v-if="errors.length > 0">
                <ul>
                    <li v-for="error in errors">{{ error }}</li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="" class="control-label">Institución</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group is-required">
                        <select2 :options="institutions" v-model="record.institution_id"></select2>
                        <input type="hidden" v-model="record.id">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="" class="control-label">Fecha</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group is-required">
                        <input type="date" class="form-control input-sm" v-model="record.compromised_at"
                               title="Indique la fecha del compromiso" id="compromised_at" data-toggle="tooltip">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="" class="control-label">
                            Documento Origen
                            <a class="btn btn-sm btn-info btn-action btn-tooltip" href="javascript:void(0)"
                               data-original-title="Buscar documento" data-toggle="modal"
                               data-target="#add_source">
                                <i class="fa fa-search"></i>
                            </a>
                        </label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group is-required">
                        <input type="text" v-model="record.source_document" class="form-control input-sm"
                               title="Indique el número de documento de origen que genera el compromiso"
                               data-toggle="tooltip">
                    </div>
                </div>
                <div class="modal fade" tabindex="-1" role="dialog" id="add_source">
                    <div class="modal-dialog vue-crud" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <h6>
                                    <i class="ion-arrow-graph-up-right"></i>
                                    Agregar documento
                                </h6>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group is-required">
                                            <label>Tipo de Documento:</label>
                                            <select2 :options="document_types" v-model="document_type_id"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group is-required">
                                            <label>Número de Documento:</label>
                                            <select2 :options="document_numbers" v-model="document_number_id"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default btn-sm btn-round btn-modal-close"
                                        data-dismiss="modal">
                                    Cerrar
                                </button>
                                <button type="button" @click="addDocument"
                                        class="btn btn-primary btn-sm btn-round btn-modal-save">
                                    Agregar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="" class="control-label">Descripción</label>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="form-group is-required">
                        <textarea v-model="record.description" class="form-control" rows="3" data-toggle="tooltip"
                                  title="Indique una descripción para el compromiso" id="description"></textarea>
                    </div>
                </div>
            </div>
            <hr>
            <div class="pad-top-40">
                <h6 class="text-center card-title">Cuentas presupuestarias de gastos</h6>
                <div class="row">
                    <div class="col-md-12 pad-top-20">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Acción Específica</th>
                                    <th>Cuenta</th>
                                    <th>Descripción</th>
                                    <th>Monto</th>
                                    <th>
                                        <a class="btn btn-sm btn-info btn-action btn-tooltip" href="#"
                                           data-original-title="Agregar cuenta presupuestaria" data-toggle="modal"
                                           data-target="#add_account">
                                            <i class="fa fa-plus-circle"></i>
                                        </a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(account, index) in record.accounts">
                                    <td>{{ account.spac_description }}</td>
                                    <td>{{ account.code }}</td>
                                    <td>{{ account.description }}</td>
                                    <td class="text-right">{{ account.amount }}</td>
                                    <td class="text-center">
                                        <input type="hidden" name="account_id[]" readonly
                                               :value="account.specific_action_id + '|' + account.account_id">
                                        <input type="hidden" name="budget_account_amount[]" readonly
                                               :value="account.amount">
                                        <a class="btn btn-sm btn-danger btn-action" href="#" @click="deleteAccount(index)"
                                           title="Eliminar este registro" data-toggle="tooltip">
                                            <i class="fa fa-minus-circle"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="pad-top-40">
                <h6 class="text-center card-title">Cuentas presupuestarias de impuestos</h6>
                <div class="row">
                    <div class="col-md-12 pad-top-20">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Acción Específica</th>
                                    <th>Cuenta</th>
                                    <th>Descripción</th>
                                    <th>Monto</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(tax_account, index) in record.tax_accounts" :id="tax_account.parent_account_id">
                                    <td>{{ tax_account.spac_description }}</td>
                                    <td>{{ tax_account.code }}</td>
                                    <td>{{ tax_account.description }}</td>
                                    <td class="text-right">{{ tax_account.amount }}</td>
                                    <td class="text-center">
                                        <input type="hidden" name="account_id[]" readonly
                                               :value="tax_account.specific_action_id + '|' + tax_account.account_id">
                                        <input type="hidden" name="budget_tax_account_amount[]" readonly
                                               :value="tax_account.amount">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal fade" tabindex="-1" role="dialog" id="add_account">
                    <div class="modal-dialog vue-crud" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <h6>
                                    <i class="ion-arrow-graph-up-right"></i>
                                    Agregar cuentas
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
                                        <div class="form-group is-required">
                                            <label>Acción Específica:</label>
                                            <select2 :options="specific_actions" v-model="specific_action_id"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group is-required">
                                            <label>Cuenta:</label>
                                            <select2 :options="accounts" v-model="account_id"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Descripción:</label>
                                        <input type="text" class="form-control" data-toggle="tooltip"
                                               v-model="account_description" readonly
                                               title="Denominación de la cuenta presupuestaria">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Concepto:</label>
                                        <input type="text" class="form-control" data-toggle="tooltip"
                                               v-model="account_concept"
                                               title="Indique el concepto de la cuenta presupuestaria a agregar">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group is-required">
                                            <label>Monto:</label>
                                            <input type="number" onfocus="$(this).select()"
                                                   class="form-control numeric"
                                                   data-toggle="tooltip"
                                                   title="Indique el monto a asignar para la cuenta seleccionada"
                                                   v-model="account_amount">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group is-required">
                                            <label>Impuesto:</label>
                                            <select2 :options="taxes" v-model="account_tax_id"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default btn-sm btn-round btn-modal-close"
                                        data-dismiss="modal">
                                    Cerrar
                                </button>
                                <button type="button" @click="addAccount"
                                        class="btn btn-primary btn-sm btn-round btn-modal-save">
                                    Agregar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-right">
            <button type="reset" class="btn btn-default btn-icon btn-round" data-toggle="tooltip"
                    title="Borrar datos del formulario" @click='reset'>
                <i class="fa fa-eraser"></i>
            </button>
            <button type="button" class="btn btn-warning btn-icon btn-round" data-toggle="tooltip"
                    title="Cancelar y regresar" @click="redirect_back(route_list)">
                <i class="fa fa-ban"></i>
            </button>
            <button type="button" class="btn btn-success btn-icon btn-round" data-toggle="tooltip"
                    title="Guardar registro" @click="createRecord('budget/compromises')">
                <i class="fa fa-save"></i>
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                record: {
                    id: '',
                    institution_id: '',
                    compromised_at: '',
                    source_document: '',
                    description: '',
                    accounts: [],
                    tax_accounts: []
                },
                errors: [],
                institutions: [],

                /**
                 * Campos temporales para agregar las cuentas presupuestarias a comprometer
                 */
                taxes: [],
                specific_actions: [],
                specific_action_id: '',
                accounts: [],
                account_id: '',
                account_description: '',
                account_concept: '',
                account_amount: 0,
                account_tax_id: '',

                /**
                 * Campos temporales para agregar documentos al compromiso
                 */
                document_types: [],
                document_type_id: '',
                document_numbers: [],
                document_number_id: ''
            }
        },
        methods: {
            /**
             * Inicializa las variables del compromiso a registrar
             *
             * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             */
            reset: function() {
                this.record.id = '';
                this.record.institution_id = '';
                this.record.compromised_at = '';
                this.record.accounts = [];
                this.record.tax_accounts = [];
                this.source_document = '';
                this.description = '';
                this.errors = [];
                this.institutions = [];

                /**
                 * Campos temporales para agregar las cuentas presupuestarias a comprometer
                 */
                this.taxes = [];
                this.specific_actions = [];
                this.specific_action_id = '';
                this.accounts = [];
                this.account_id = '';
                this.account_description = '';
                this.account_concept = '';
                this.account_amount = 0;
                this.account_tax_id = '';

                /**
                 * Campos temporales para agregar documentos al compromiso
                 */
                this.document_types = [];
                this.document_type_id = '';
                this.document_numbers = [];
                this.document_number_id = '';
            },
            /**
             * Elimina una cuenta del listado de cuentas agregadas
             *
             * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             * @param  {integer} index Índice del elemento a eliminar
             */
            deleteAccount(index) {
                let vm = this;
                bootbox.confirm({
                    title: "Eliminar cuenta?",
                    message: `Esta seguro de eliminar esta cuenta del registro de la modificación
                              presupuestaria?`,
                    buttons: {
                        cancel: {
                            label: '<i class="fa fa-times"></i> Cancelar'
                        },
                        confirm: {
                            label: '<i class="fa fa-check"></i> Confirmar'
                        }
                    },
                    callback: function (result) {
                        if (result) {
                            vm.budget_modification_accounts.splice(index, 1);
                        }
                    }
                });
            },
            /**
             * Agrega una cuenta presupuestaria al compromiso
             *
             * @method     addAccount
             *
             * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             */
            addAccount() {

            },
            /**
             * Agrega un documento al compromiso
             *
             * @method     addDocument
             *
             * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             */
            addDocument() {

            },
            /**
             * Obtiene las Acciones Específicas
             *
             * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             * @param {string} type Tipo de registro
             */
            getSpecificActions() {
            },
        },
        created() {

        },
        mounted() {
            let vm = this;
            vm.getInstitutions();
            vm.getSpecificActions();
        }
    };
</script>
