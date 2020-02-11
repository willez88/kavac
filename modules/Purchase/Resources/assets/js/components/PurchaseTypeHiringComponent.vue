<template>
    <div class="col-xs-2 text-center">
        <a class="btn-simplex btn-simplex-md btn-simplex-primary"
           href="#" title="Registros de tipos de compras"
           data-toggle="tooltip"
           @click="addRecord('add_purchase_type_hiring', '/purchase/type_hiring', $event)">
            <i class="fa fa-tag ico-3x"></i>
            <span>Tipos de<br>contratación</span>
        </a>
        <div class="modal fade text-left" tabindex="-1" role="dialog" id="add_purchase_type_hiring">
            <div class="modal-dialog vue-crud" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h6>
                            <i class="icofont icofont-box inline-block"></i>
                            Tipo de contratación
                        </h6>
                    </div>
                    <div class="modal-body">
                        <purchase-show-errors ref="purchaseTypesErrors" />

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group is-required">
                                    <label class="control-label" for="record_date">Fecha
                                    </label>
                                    <input type="date" class="form-control" id="record_date" v-model="record.date"
                                            tabindex="1">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="purchase_type_operation_id">Tipo:</label><br>
                                    <select2 :options="type_operations" id="purchase_type_operation_id" 
                                            placeholder="Tipo de contratación"
                                            v-model="record.purchase_type_operation_id">
                                            </select2>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group is-required">
                                    <label for="record_ut">Unidades tributarias:</label>
                                    <input type="number" id="record_ut" class="form-control" v-model="record.ut" 
                                            title="Indique las unidades tributarias">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class='form-group'>
                                    <label class='control-label'>Activa</label>
                                    <div class='col-12'>
                                        <input id='active'
                                             data-on-label='SI' data-off-label='NO' 
                                             name='active' 
                                             type='checkbox' 
                                             class='form-control bootstrap-switch'
                                             v-model='record.active'>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group">
                            <modal-form-buttons :saveRoute="'/purchase/type_hiring'"></modal-form-buttons>
                        </div>
                    </div>
                    <div class="modal-body modal-table">
                        <v-client-table :columns="columns" :data="records" :options="table_options">}
                            <div slot="date" slot-scope="props">
                                <strong>{{ format_date(props.row.date) }}</strong>
                            </div>
                            <div slot="ut" slot-scope="props">
                                <strong>{{ props.row.ut+' UT' }}</strong>
                            </div>
                            <div slot="active" slot-scope="props" class="text-center">
                                <div v-if="props.row.active">
                                    <span class="badge badge-success"><strong>Activa</strong></span>
                                </div>
                                <div v-else>
                                    <span class="badge badge-warning"><strong>Inactiva</strong></span>
                                </div>
                            </div>
                            <div slot="id" slot-scope="props" class="text-center">
                                <div class="d-inline-flex">
                                    <button @click="loadData(props.row)"
                                            class="btn btn-warning btn-xs btn-icon btn-action"
                                            title="Modificar registro"
                                            data-toggle="tooltip">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button @click="deleteRecord(props.index,'/purchase/type_hiring')"
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
                columns: ['date', 'purchase_type_operation.name', 'ut', 'active', 'id'],
                record: {
                    date:'',
                    purchase_type_operation_id:'',
                    ut:'0.00',
                    active:false,
                },
                type_operations:[],
                purchaseProcesses:[],
                edit:false,
            }
        },
        methods: {
            /**
             * Método que borra todos los datos del formulario
             *
             * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
             */
            reset() {
                this.edit = false;
                this.record = {
                    id: '',
                    date: '',
                    purchase_type_operation: '',
                    ut: '',
                    active: false,
                };
            },

            createRecord(url){
                this.record.active = $('#active').prop('checked');
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
            },
        },
        created() {
            this.table_options.headings = {
                'date': 'Fecha',
                'purchase_type_operation.name': 'Tipo',
                'ut': 'Unidades tributarias',
                'active': 'Estatus',
                'id':'Acción'
            };
            this.table_options.sortable = ['date', 'purchase_type_operation.name', 'ut', 'active'];
            this.table_options.filterable = ['date', 'purchase_type_operation.name', 'ut', 'active'];
            this.table_options.columnsClasses = {
                'date': 'col-xs-2 text-center',
                'purchase_type_operation.name': 'col-xs-4',
                'ut': 'col-xs-3',
                'active': 'col-xs-2',
                'id': 'col-xs-1'
            };
        },
        mounted(){
            axios.get('/purchase/get-type-operations').then(response=>{
                this.type_operations = response.data.records;
            });
        },
    };
</script>
