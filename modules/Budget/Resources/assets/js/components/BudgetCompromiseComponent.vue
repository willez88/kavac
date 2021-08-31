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
                               data-original-title="Buscar documento" title="Buscar documento" data-toggle="modal"
                               data-target="#add_source" v-if="record.institution_id">
                                <i class="fa fa-search"></i>
                            </a>
                            <a class="btn btn-sm btn-default btn-action btn-tooltip" href="javascript:void(0)"
                               data-original-title="Quitar documento de origen" title="Quitar documento de origen"
                               v-if="(document_number!=='')" data-toggle="tooltip">
                                <i class="icofont icofont-eraser"></i>
                            </a>
                        </label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group is-required">
                        <input type="text" v-model="record.source_document" class="form-control input-sm"
                               title="Indique el número de documento de origen que genera el compromiso"
                               data-toggle="tooltip" :readonly="(document_number!=='')">
                    </div>
                </div>
                <!-- Modal para agregar documentos de origen que generaron un precompromiso -->
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
                                    <div class="col-md-12 pad-top-20">
                                        <table class="table table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Código</th>
                                                    <th>Fecha</th>
                                                    <th>Monto</th>
                                                    <th>Sel.</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(source, index) in document_sources">
                                                    <td>{{ source.sourceable.code }}</td>
                                                    <td>{{ format_date(source.created_at) }}</td>
                                                    <td>{{ source.budget_stages[0].amount }}</td>
                                                    <td>
                                                        <a href="#" data-original-title="Agregar documento"
                                                           class="btn btn-sm btn-info btn-action btn-tooltip"
                                                           @click="addDocument(source.id)">
                                                            <i class="fa fa-plus-circle"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default btn-sm btn-round btn-modal-close"
                                        data-dismiss="modal">
                                    Cerrar
                                </button>
                                <!--<button type="button" @click="addDocument"
                                        class="btn btn-primary btn-sm btn-round btn-modal-save">
                                    Agregar
                                </button>-->
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
                        <ckeditor :editor="ckeditor.editor" id="description" data-toggle="tooltip"
                                  title="Indique una descripción para el compromiso" :config="ckeditor.editorConfig"
                                  class="form-control" name="description" tag-name="textarea" rows="3"
                                  v-model="record.description"></ckeditor>
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
                                    <th class="col-4">Acción Específica</th>
                                    <th class="col-2">Cuenta</th>
                                    <th class="col-3">Descripción</th>
                                    <th class="col-2">Monto</th>
                                    <th class="col-1">
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
                                    <td class="text-right">{{ formatToCurrency(account.amount, '') }}</td>
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
                <!-- Modal para agregar cuentas presupuestarias -->
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
                                    <div class="col-12" v-if="hasDocumentSelected()">
                                        {{ setItemCompromise() }}
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group is-required">
                                            <label>Acción Específica:</label>
                                            <select2 :options="specific_actions"
                                                     @input="getAccounts"
                                                     v-model="specific_action_id"/>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group is-required">
                                            <label>Cuenta:</label>
                                            <select2 :options="accounts" v-model="account_id"/>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Concepto:</label>
                                            <input type="text" class="form-control input-sm" data-toggle="tooltip"
                                                   v-model="account_concept"
                                                   title="Indique el concepto de la cuenta presupuestaria a agregar">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 mt-4">
                                        <div class="form-group is-required">
                                            <label>Monto:</label>
                                            <input type="number" onfocus="$(this).select()"
                                                   class="form-control input-sm"
                                                   data-toggle="tooltip"
                                                   title="Indique el monto a asignar para la cuenta seleccionada"
                                                   v-model="account_amount">
                                        </div>
                                    </div>
                                    <div class="col-md-3 mt-4">
                                        <div class="form-group">
                                            <label>Impuesto:</label>
                                            <select class="select2" v-model="account_tax_id">
                                                <option value="">Seleccione</option>
                                                <option :value="tax.id" v-for="tax in taxes">
                                                    {{ tax.name }} {{ tax.histories[0].percentaje }}%
                                                </option>
                                            </select>
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
                    tax_accounts: [],
                    documentToCompromise: {}
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
                account_concept: '',
                account_amount: 0,
                account_tax_id: '',

                /**
                 * Campos temporales para agregar documentos al compromiso
                 */
                document_sources: [],
                document_number: '',
            }
        },
        watch: {
            record: {
                deep: true,
                handler: function() {
                    //
                }
            }
        },
        methods: {
            /**
             * Inicializa las variables del compromiso a registrar
             *
             * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             */
            reset: function() {
                /**
                 * Campos con información a ser almacenada
                 */
                this.record.id = '';
                this.record.institution_id = '';
                this.record.compromised_at = '';
                this.record.accounts = [];
                this.record.tax_accounts = [];
                this.source_document = '';
                this.description = '';
                this.errors = [];

                /**
                 * Campos temporales para agregar las cuentas presupuestarias a comprometer
                 */
                this.specific_action_id = '';
                this.account_id = '';
                this.account_concept = '';
                this.account_amount = 0;
                this.account_tax_id = '';

                /**
                 * Campos temporales para agregar documentos al compromiso
                 */
                this.document_sources = [];
                this.document_number = '';
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
                    message: `Esta seguro de eliminar esta cuenta del compromiso actual?`,
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
                            vm.record.accounts.splice(index, 1);
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
            async addAccount() {
                const vm = this;

                if (
                    !vm.specific_action_id && !vm.account_id && !vm.account_concept && !vm.account_amount &&
                    !vm.account_tax_id
                ) {
                    vm.showMessage(
                        'custom', 'Alerta!', 'warning', 'screen-error', 'Debe indicar todos los datos solicitados'
                    );
                    return;
                }

                let specificAction = {};
                let account = {};
                await vm.getSpecificActionDetail(vm.specific_action_id).then(detail => specificAction = detail.record);
                await vm.getAccountDetail(vm.account_id).then(detail => account = detail.record);
                vm.record.accounts.push({
                    'spac_description': `${specificAction.specificable.code}-${specificAction.code} | ${specificAction.name}`,
                    'code': account.code,
                    'description': vm.account_concept,
                    'amount': vm.account_amount,
                    'specific_action_id': vm.specific_action_id,
                    'account_id': vm.account_id,
                    'tax_id': vm.account_tax_id
                });

                bootbox.confirm({
                    title: "Agregar cuenta",
                    message: `Desea agregar otra cuenta?`,
                    buttons: {
                        cancel: {
                            label: '<i class="fa fa-times"></i> Cancelar'
                        },
                        confirm: {
                            label: '<i class="fa fa-check"></i> Confirmar'
                        }
                    },
                    callback: function (result) {
                        if (!result) {
                            $("#add_account").find('.close').click();
                        }

                        vm.specific_action_id = '';
                        vm.account_id = '';
                        vm.account_concept = '';
                        vm.account_amount = 0;
                        vm.account_tax_id = '';
                    }
                });
            },
            /**
             * Agrega un documento al compromiso
             *
             * @method     addDocument
             *
             * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             */
            addDocument(sourceId) {
                const vm = this;
                vm.record.documentToCompromise = JSON.parse(JSON.stringify(vm.document_sources.filter(doc => {
                    return doc.id === sourceId;
                })[0]));
            },
            /**
             * Obtiene las Acciones Específicas
             *
             * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             * @param {string} type Tipo de registro
             */
            async getSpecificActions() {
                const vm = this;
                vm.loading = true;
                vm.specific_actions = [];
                vm.accounts = [];

                if (vm.record.compromised_at && vm.record.source_document && vm.record.institution_id) {
                    let year = vm.record.compromised_at.split("-")[0];
                    let url = `${window.app_url}/budget/get-group-specific-actions/${year}/1/${vm.record.institution_id}`;
                    await axios.get(url).then(response => {
                        vm.specific_actions = response.data;
                    }).catch(error => {
                        console.error(error);
                    });
                } else {
                    $("#add_account").find('.close').click();
                    bootbox.alert('Debe indicar los datos del compromiso antes de agregar cuentas');
                }

                vm.loading = false;
            },
            /**
             * Obtiene las cuentas presupuestarias formuladas de la acción específica seleccionada
             *
             * @method    getAccounts
             *
             * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             */
            async getAccounts() {
                const vm = this;
                vm.loading = true;
                vm.accounts = [];

                if (vm.specific_action_id) {
                    let specificActionId = vm.specific_action_id;
                    let compromisedAt = vm.record.compromised_at;
                    await axios.get(
                        `${window.app_url}/budget/get-opened-accounts/${specificActionId}/${compromisedAt}`
                    ).then(response => {
                        if (response.data.result) {
                            vm.accounts = response.data.records;
                        }
                        if (response.data.records.length === 1 && response.data.records[0].id === "") {
                            vm.showMessage(
                                'custom', 'Alerta!', 'danger', 'screen-error',
                                `No existen cuentas aperturadas para esta acción específica o con saldo para la fecha
                                seleccionada`
                            );
                        }
                    }).catch(error => {
                        console.error(error);
                    });
                }

                vm.loading = false;
            },
            /**
             * Obtiene los registros precomprometidos que aún no han sido comprometidos
             *
             * @method     getDocumentSources
             *
             * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             *
             * @license    [description]
             *
             * @return     {[type]}              [description]
             */
            getDocumentSources() {
                let vm = this;
                let appUrl = window.app_url;
                let institutionId = vm.record.institution_id;
                let year = window.execution_year;
                vm.loading = true;
                axios.get(
                    `${appUrl}/budget/compromises/get-document-sources/${institutionId}/${year}`
                ).then(response => {
                    vm.document_sources = response.data.records;
                    vm.loading = false;
                }).catch(error => {
                    console.warn(error);
                });
            },
            /**
             * Determina si se ha seleccionado un documento desde otras fuentes para ser comprometido
             *
             * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             *
             * @return    {Boolean}              Devuelve verdadero si tiene un documento seleccionado,
             *                                   de lo contrario devuelve falso
             */
            hasDocumentSelected() {
                const vm = this;
                let compromise = vm.record.documentToCompromise;
                return (
                    typeof(compromise.budget_compromise_details)!=='undefined' &&
                    compromise.budget_compromise_details.length > 0
                );
            },
            /**
             * Muestra el item del compromiso proveniente de fuentes externas que se esta comprometiendo
             *
             * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             *
             * @return {String} Texto con información del ítem a comprometer
             */
            setItemCompromise() {
                const vm = this;
                let totalItems = vm.record.documentToCompromise.budget_compromise_details.length;
                let currentItem = vm.record.accounts.length;
                return `Item ${currentItem} / ${totalItems}`;
            }
        },
        created() {

        },
        mounted() {
            let vm = this;
            vm.reset();
            vm.getInstitutions();
            vm.getTaxes();

            $("#add_source").on('shown.bs.modal', function() {
                /** Carga los documentos que faltan por comprometer */
                vm.getDocumentSources();
            }).on('hide.bs.modal', function() {
                /** @type array Inicializa el arreglo de los documentos por comprometer */
                vm.document_sources = [];
            });

            $("#add_account").on('shown.bs.modal', function() {
                if (vm.specific_actions.length === 0) {
                    /** Carga las acciones específicas para la respectiva formulación */
                    vm.getSpecificActions();
                }
            }).on('hide.bs.modal', function() {
                /** @type {Array} Inicializa el arreglo de acciones específicas a seleccionar */
                vm.specific_actions = [];
                /** @type array Inicializa el arreglo de las cuentas presupuestarias seleccionadas */
                vm.accounts = [];
            });
        }
    };
</script>
