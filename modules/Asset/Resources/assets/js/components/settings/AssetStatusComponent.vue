<template>
    <div class="col-xs-2 text-center">
        <a class="btn-simplex btn-simplex-md btn-simplex-primary"
           href="#" title="Registros de Estatus de Uso de los Bienes" data-toggle="tooltip"
           @click="addRecord('add_status', 'status', $event)">
            <i class="icofont icofont-read-book ico-3x"></i>
            <span>Estatus de Uso</span>
        </a>
        <div class="modal fade text-left" tabindex="-1" role="dialog" id="add_status">
            <div class="modal-dialog vue-crud" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h6>
                            <i class="icofont icofont-read-book ico-2x"></i>
                            Nuevo Estatus de Uso
                        </h6>
                    </div>
                    <div class="modal-body">
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group is-required">
                                    <label>Estatus de Uso:</label>
                                    <input type="text" placeholder="Nombre del estatus de uso"
                                        title="Indique el nombre del nuevo estatus de uso de un bien (requerido)"
                                        data-toggle="tooltip" class="form-control input-sm" v-model="record.name">
                                    <input type="hidden" v-model="record.id">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group">
                            <modal-form-buttons :saveRoute="'asset/status'"></modal-form-buttons>
                        </div>
                    </div>
                    <div class="modal-body modal-table">
                        <hr>
                        <v-client-table :columns="columns" :data="records" :options="table_options">
                            <div slot="id" slot-scope="props" class="text-center">
                                <button @click="initUpdate(props.index, $event)"
                                        class="btn btn-warning btn-xs btn-icon btn-action"
                                        title="Modificar registro" data-toggle="tooltip" type="button">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button @click="deleteRecord(props.index, 'status')"
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

<script>
    export default {
        data() {
            return {
                record: {
                    id:'',
                    name: ''
                },
                errors: [],
                records: [],
                columns: ['name', 'id'],
            }
        },
        methods: {
            /**
             * Método que borra todos los datos del formulario
             *
             * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             */
            reset()
            {
                this.record = {
                    id: '',
                    name: ''
                };
            },
        },
        created() {
            this.table_options.headings = {
                'name': 'Nombre',
                'id': 'Acción'
            };
            this.table_options.sortable = ['name'];
            this.table_options.filterable = ['name'];
            this.table_options.columnsClasses = {
                'name': 'col-xs-10',
                'id': 'col-xs-2'
            };
        },
    };
</script>
