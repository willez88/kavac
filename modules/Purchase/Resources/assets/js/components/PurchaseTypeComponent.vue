<template>
    <div class="col-xs-2 text-center">
        <a class="btn-simplex btn-simplex-md btn-simplex-primary"
           href="#" title="Registros de tipos de compras"
           data-toggle="tooltip"
           @click="addRecord('add_purchase_types', '/purchase/purchase_types', $event)">
            <i class="fa fa-tag ico-3x"></i>
            <span>Tipos de<br>Compras</span>
        </a>
        <div class="modal fade text-left" tabindex="-1" role="dialog" id="add_purchase_types">
            <div class="modal-dialog vue-crud" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h6>
                            <i class="icofont icofont-box inline-block"></i>
                            Tipos de Compras
                        </h6>
                    </div>
                    <div class="modal-body">
                        <purchase-show-errors ref="purchaseTypesErrors" />

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group is-required">
                                    <label>Nombre:</label>
                                    <input type="text"
                                           placeholder="Nombre del tipo de compra"
                                           data-toggle="tooltip" v-model="record.name"
                                           title="Indique el nombre del tipo de compra (requerido)"
                                           class="form-control input-sm">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="purchase_process">Proceso de compra:</label><br>
                                    <select2 :options="purchaseProcesses" id="purchase_process" 
                                            placeholder="Proceso de compra asociado"
                                            v-model="record.purchase_processes_id">
                                            </select2>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group is-required">
                                    <label>Descripción:</label>
                                    <textarea class="form-control input-sm" rows="3"
                                              title="Indique la descripción para tipo de compra"
                                              placeholder="Descripción del tipo de compra"
                                              v-model="record.description" data-toggle="tooltip"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group">
                            <modal-form-buttons :saveRoute="'/purchase/purchase_types'"></modal-form-buttons>
                        </div>
                    </div>
                    <div class="modal-body modal-table">
                        <v-client-table :columns="columns" :data="records" :options="table_options">
                            <div slot="id" slot-scope="props" class="text-center">
                                <div class="d-inline-flex">
                                    <button @click="loadData(props.row)"
                                            class="btn btn-warning btn-xs btn-icon btn-action"
                                            title="Modificar registro"
                                            data-toggle="tooltip">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button @click="deleteRecord(props.index,'/purchase/purchase_types')"
                                            class="btn btn-danger btn-xs btn-icon btn-action" 
                                            title="Eliminar registro" 
                                            data-toggle="tooltip" >
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                </div>
                            </div>
                        </v-client-table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                records:[],
                errors:[],
                columns: ['name', 'description', 'purchase_process.name', 'id'],
                record: {
                    name:'',
                    description:'',
                    purchase_processes_id:'',
                },
                purchaseProcesses:[],
                edit:false,
            }
        },
        methods: {
            /**
             * Método que borra todos los datos del formulario
             *
             * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             */
            reset() {
                this.edit = false;
                this.record = {
                    id: '',
                    name: '',
                    description: '',
                    purchase_processes_id: ''
                };
            },

            getPurchaseProcess(){
                axios.get('/purchase/get-processes', this.record).then(response=>{
                    this.purchaseProcesses = response.data
                });
            },
            createRecord(url){
                if (!this.edit) {
                    axios.post(url,this.record).then(response=>{
                        this.records = response.data.records;
                        this.showMessage("store");
                        this.reset();
                    });
                }else if(this.edit && this.record.id){
                    axios.put(url+'/'+this.record.id, this.record).then(response=>{
                        this.records = response.data.records;
                        this.showMessage("update");
                        this.reset();
                    });
                }
            },
            loadData(record){
                this.edit = true;
                this.record = record;
            }
        },
        created() {
            this.table_options.headings = {
                'name': 'Nombre',
                'description': 'Descripción',
                'purchase_process.name': 'Proceso de compra',
                'id': 'Acción'
            };
            this.table_options.sortable = ['name', 'description', 'purchase_process.name'];
            this.table_options.filterable = ['name', 'description', 'purchase_process.name'];
            this.table_options.columnsClasses = {
                'name': 'col-xs-2',
                'description': 'col-xs-4',
                'purchase_process.name': 'col-xs-4',
                'id': 'col-xs-1'
            };
        },
        mounted(){
            this.getPurchaseProcess();
        }
    };
</script>
