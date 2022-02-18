<template>
    <section id="assetStatusComponent">
        <a class="btn-simplex btn-simplex-md btn-simplex-primary"
           href="" title="Registros de Estatus de Uso de los Bienes" data-toggle="tooltip"
           @click="addRecord('add_status', 'asset/status', $event)">
            <i class="icofont icofont-rotation ico-3x"></i>
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
                            <i class="icofont icofont-rotation ico-2x"></i>
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
                                    <li v-for="error in errors" :key="error">{{ error }}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group is-required">
                                    <label>Estatus de uso:</label>
                                    <input type="text" placeholder="Nombre del estatus de uso"
                                        title="Indique el nombre del nuevo estatus de uso de un bien (requerido)"
                                        v-input-mask data-inputmask-regex="[a-zA-ZÁ-ÿ\s]*$"
                                        data-toggle="tooltip" class="form-control input-sm" v-model="record.name">
                                    <input type="hidden" v-model="record.id">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group">
                            <button type="button" class="btn btn-default btn-sm btn-round btn-modal-close" 
									@click="clearFilters" data-dismiss="modal">
								Cerrar
							</button>
							<button type="button" class="btn btn-warning btn-sm btn-round btn-modal btn-modal-clear" 
									@click="reset()">
								Cancelar
							</button>
							<button type="button" @click="createRecord('asset/status')" 
									class="btn btn-primary btn-sm btn-round btn-modal-save">
								Guardar
							</button>
                        </div>
                    </div>
                    <div class="modal-body modal-table">
                       
                        <v-client-table :columns="columns" :data="records" :options="table_options">
                            <div slot="id" slot-scope="props">
                                <button @click="initUpdate(props.row.id, $event)"
                                        class="btn btn-warning btn-xs btn-icon btn-action" v-has-tooltip
                                        title="Modificar registro" data-toggle="tooltip" type="button">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button @click="deleteRecord(props.row.id, 'asset/status')"
                                        class="btn btn-danger btn-xs btn-icon btn-action" v-has-tooltip
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
                'id':   'col-xs-2 text-center'
            };
        },
    };
</script>
