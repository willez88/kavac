<template>
    <div class="col-md-2 text-center">
        <a class="btn-simplex btn-simplex-md btn-simplex-primary"
           href="#" title="Registros de procesos de compras"
           data-toggle="tooltip"
           @click="addRecord('add_process', '/purchase/processes', $event)">
            <i class="icofont icofont-law-document ico-3x"></i>
            <span>Procesos de Compras</span>
        </a>
        <div class="modal fade text-left" tabindex="-1" role="dialog" id="add_process">
            <div class="modal-dialog vue-crud" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h6>
                            <i class="icofont icofont-law-document inline-block"></i>
                            Proceso de Compra
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
                                    <label for="">
                                        <input type="checkbox" class="form-control bootstrap-switch"
                                               name="exists" data-toggle="tooltip" data-on-label="SI"
                                               data-off-label="NO" title="Indique si el proceso existe"
                                               value="true" data-record="exists">
                                        ¿El proceso existe?
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6" v-if="exists">
                                <div class="form-group">
                                    <select2 :options="processes" @input="getListDocuments"
                                             v-model="record.id"></select2>
                                </div>
                            </div>
                        </div>
                        <div class="row" v-if="!exists">
                            <div class="col-md-6">
                                <div class="form-group is-required">
                                    <label>Nombre:</label>
                                    <input type="hidden" v-model="record.id">
                                    <input type="text" placeholder="Nombre del proceso"
                                           data-toggle="tooltip" v-model="record.name"
                                           title="Indique el nombre del proceso de compra (requerido)"
                                           class="form-control input-sm">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group is-required">
                                    <label>Descripción:</label>
                                    <textarea class="form-control input-sm" rows="3" v-model="record.description"
                                              placeholder="Descripción del proceso de compra"
                                              data-toggle="tooltip"
                                              title="Indique la descripción para el proceso de compra (requerido)"></textarea>
                                </div>
                            </div>
                        </div>
                        <h6 class="text-center text-info">DOCUMENTOS A CONSIGNAR</h6>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="accordion" id="documentsList" v-for="(list, index) in listSelectDocuments">
                                    <h6 class="mb-0" style="text-transform:uppercase;font-weight:bold;">
                                        <button class="btn btn-link" type="button" data-toggle="collapse" rel="tooltip" 
                                                :data-target="'#collapseDocumentsList'+index" 
                                                aria-expanded="true" :aria-controls="'collapseDocumentsList'+index" 
                                                title="Presione para mostrar u ocultar la lista de documentos">
                                            {{ index+1 }}. {{ list.title }}
                                        </button>
                                    </h6>
                                    <hr>
                                    <div :id="'collapseDocumentsList'+index" class="collapse" :class="{'show': (index===0)}" :aria-labelledby="'heading'+index" data-parent="#documentsList">
                                        <div class="card-body">
                                            <ul class="feature-list list-group list-group-flush">
                                                <li class="list-group-item" v-for="(document, idx) in list.documents">
                                                    <div class="feature-list-indicator bg-info"></div>
                                                    <div class="feature-list-content p-0">
                                                        <div class="feature-list-content-wrapper">
                                                            <div class="feature-list-content-left mr-2">
                                                                <label class="custom-control custom-checkbox">
                                                                    <p-check class="p-icon p-smooth p-plain p-curve"
                                                                             color="primary-o" 
                                                                             :value="list.id + '_' + idx" 
                                                                             v-model="record.list_documents">
                                                                        <i slot="extra" class="icon fa fa-check"></i>
                                                                    </p-check>
                                                                </label>
                                                            </div>
                                                            <div class="feature-list-content-left">
                                                                <div class="feature-list-subheading">
                                                                    {{ document }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group">
                            <modal-form-buttons :saveRoute="'purchase/processes'"></modal-form-buttons>
                        </div>
                    </div>
                    <div class="modal-body modal-table">
                        <v-client-table :columns="columns" :data="records" :options="table_options">
                            <div slot="require_documents" slot-scope="props" class="text-center">
                                <span v-if="props.row.require_documents">SI</span>
                                <span v-else>NO</span>
                            </div>
                            <div slot="id" slot-scope="props" class="text-center">
                                <button @click="initUpdate(props.index, $event)"
                                        class="btn btn-warning btn-xs btn-icon btn-round"
                                        title="Modificar registro" data-toggle="tooltip" type="button">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button @click="deleteRecord(props.index, '/purchase/processes')"
                                        class="btn btn-danger btn-xs btn-icon btn-round"
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
    .accordion hr {
        margin-top:0;
        margin-bottom: 0;
    }
    .accordion h6 .btn {
        font-size: 1em;
        font-weight: bold;
        text-transform: uppercase;
    }
    .accordion .card-body {
        padding-top: 0;
    }
    .accordion .list-group-item {padding:0;}
    .custom-control-input:checked ~ .custom-control-label::before {
        color: #fff;
        border-color: #f96332;
        background-color: #f96332;
    }
</style>

<script>
    export default {
        data() {
            return {
                record: {
                    id: '',
                    name: '',
                    description: '',
                    require_documents: false,
                    list_documents: []
                },
                exists: false,
                errors: [],
                records: [],
                processes: [],
                listSelectDocuments: [],
                columns: ['name', 'description', 'require_documents', 'id'],
            }
        },
        watch: {
            exists: function() {
                this.record.id = (this.exists) ? this.record.id : '';
            }
        },
        methods: {
            /**
             * Método que borra todos los datos del formulario
             *
             * @method  reset
             *
             * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             */
            reset() {
                this.record = {
                    id: '',
                    name: '',
                    description: '',
                    require_documents: false,
                    list_documents: []
                };
                this.exists = false;
                this.errors = [];
                this.getProcesses();
                this.getListDocuments();
            },
            /**
             * Método que obtiene los procesos registrados
             *
             * @method  getProcesses
             *
             * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             */
            getProcesses() {
                const vm = this;
                axios.get('/purchase/get-processes').then(response => {
                    vm.processes = response.data;
                }).catch(error => {
                    console.log(error);
                });
            },
            /**
             * Método que obtiene un listado de documentos a solicitar para los procesos de compras
             *
             * @method     getListDocuments
             *
             * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             */
            getListDocuments() {
                const vm = this;
                vm.loading = true;
                vm.record.list_documents = [];
                axios.post('/purchase/get-process-documents', {id: vm.record.id}).then(response => {
                    vm.listSelectDocuments = response.data.records;
                    vm.record.list_documents = [];
                    
                    if (response.data.selected !== null) {
                        vm.record.list_documents = JSON.parse(response.data.selected);
                    }
                    vm.loading = false;
                }).catch(error => {
                    console.log(error);
                })
            }
        },
        created() {
            let vm = this;
            vm.table_options.headings = {
                'name': 'Nombre',
                'description': 'Descripción',
                'require_documents': 'Solicita Documentos',
                'id': 'Acción'
            };
            vm.table_options.sortable = ['name', 'description'];
            vm.table_options.filterable = ['name', 'description'];
            vm.table_options.columnsClasses = {
                'name': 'col-md-2',
                'description': 'col-md-6',
                'require_documents': 'col-md-2',
                'id': 'col-md-2'
            };
        },
        mounted() {
            let vm = this;
            vm.switchHandler('exists');
            $('input[name=exists].bootstrap-switch').on('switchChange.bootstrapSwitch', function() {
                vm.exists = $(this).is(':checked');
            });
        }
    };
</script>
