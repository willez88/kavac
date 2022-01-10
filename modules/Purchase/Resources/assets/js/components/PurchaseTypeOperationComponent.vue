<template>
    <div class="col-xs-2 text-center">
        <a class="btn-simplex btn-simplex-md btn-simplex-primary"
           href="#" title="Registros de tipos de compras"
           data-toggle="tooltip"
           @click="addRecord('add_purchase_type_operation', '/purchase/type_operations', $event)">
            <i class="fa fa-bookmark-o ico-3x"></i>
            <span>Tipos de<br>Operaciones</span>
        </a>
        <div class="modal fade text-left" tabindex="-1" role="dialog" id="add_purchase_type_operation">
            <div class="modal-dialog vue-crud" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h6>
                            <i class="icofont icofont-box inline-block"></i>
                            Tipos de operaciones de compra
                        </h6>
                    </div>
                    <div class="modal-body">
                        <purchase-show-errors ref="purchaseErrors" />

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
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Descripción:</label>
                                    <ckeditor :editor="ckeditor.editor" data-toggle="tooltip"
                                              title="Indique la descripción para tipo de compra"
                                              :config="ckeditor.editorConfig" class="form-control" tag-name="textarea"
                                              rows="3" v-model="record.description"
                                              placeholder="Descripción del tipo de compra"></ckeditor>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group">
                            <modal-form-buttons :saveRoute="'purchase/type_operations'"></modal-form-buttons>
                        </div>
                    </div>
                    <div class="modal-body modal-table">
                        <v-client-table :columns="columns" :data="records" :options="table_options">
                            <div slot="description" slot-scope="props">
                                <p v-html="props.row.description"></p>
                            </div>
                            <div slot="id" slot-scope="props" class="text-center">
                                <div class="d-inline-flex">
                                    <button @click="loadData(props.row)"
                                            class="btn btn-warning btn-xs btn-icon btn-action"
                                            title="Modificar registro"
                                            data-toggle="tooltip">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button @click="deleteRecord(props.index,'/purchase/type_operations')"
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
                columns: ['name', 'description', 'id'],
                record: {
                    name:'',
                    description:'',
                },
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
                    name: '',
                    description: '',
                };
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
                'id': 'Acción'
            };
            this.table_options.sortable = ['name', 'description'];
            this.table_options.filterable = ['name', 'description'];
            this.table_options.columnsClasses = {
                'name': 'col-xs-5',
                'description': 'col-xs-6',
                'id': 'col-xs-1'
            };
        },
        watch:{
            errors:function(res) {
                const vm = this;
                vm.$refs.purchaseErrors.reset();
                vm.$refs.purchaseErrors.showAlertMessages(res);
            }
        }
    };
</script>
