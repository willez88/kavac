<template>
    <section id="TechnicalSupportDiagnosticAssetFormComponent">
        <a class="btn btn-default btn-xs btn-icon btn-action"
           href="#" title="Diagnosticar equipo" data-toggle="tooltip"
           @click="addRecord('diagnostic-asset-form',route_list, $event)">
            <i class=""></i>
        </a>

        <div class="modal fade text-left" tabindex="-1" role="dialog" id="diagnostic-asset-form">
            <div class="modal-dialog vue-crud" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h6>

                            Diagnóstico del bien registrado
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
                                <div class="form-group">
                                    <label>Descripción del Diagnóstico</label>
                                    <ckeditor :editor="ckeditor.editor" data-toggle="tooltip"
                                              title="Indique una descripción del diagnóstico"
                                              :config="ckeditor.editorConfig" class="form-control"
                                              tag-name="textarea" rows="3" v-model="record.diagnostic"></ckeditor>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Piezas de Reparación</label>
                                    <ckeditor :editor="ckeditor.editor" data-toggle="tooltip"
                                              title="Indique piezas de reparación" :config="ckeditor.editorConfig"
                                              class="form-control" tag-name="textarea" rows="3"></ckeditor>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Herramientas</label>
                                    <ckeditor :editor="ckeditor.editor" data-toggle="tooltip"
                                              title="Indique las herramientas utilizadas"
                                              :config="ckeditor.editorConfig" class="form-control"
                                              tag-name="textarea" rows="3"></ckeditor>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin: 10px 0">
                            <h6 class="card-title cursor-pointer" @click="addField()" >
                                Piezas de reparación <i class="fa fa-plus-circle"></i>
                            </h6>
                        </div>
                        <div class="row" style="margin: 20px 0">

                            <div class="col-6" v-for="(field, index) in record.technical_support_repair_parts">
                                <div class="d-inline-flex">
                                    <div class="col-5">
                                        <div class="form-group">
                                            <input  class="form-control input-sm"
                                                    type="text"
                                                    placeholder="Nombre de la pieza de reparación"
                                                    data-toggle="tooltip"
                                                    title="Indique el nombre de la pieza de reparación"
                                                    v-model="field.name">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="form-group">
                                            <input  class="form-control input-sm"
                                                    type="text"
                                                    placeholder="Descripción de la pieza de reparación"
                                                    data-toggle="tooltip"
                                                    title="Indique una descripción de la pieza de reparación (opcional)"
                                                    v-model="field.description">
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <button class="btn btn-sm btn-danger btn-action"
                                                    type="button"
                                                    @click="removeRow(index, record.technical_support_repair_parts)"
                                                    title="Eliminar este dato"
                                                    data-toggle="tooltip">
                                                <i class="fa fa-minus-circle"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button"
                                class="btn btn-default btn-sm btn-round btn-modal-close"
                                data-dismiss="modal">
                            Cerrar
                        </button>
                        <button type="button"
                                @click="createRecord('technicalsupport/repairs/assign-repair-manager')"
                                class="btn btn-primary btn-sm btn-round btn-modal-save">
                            Guardar
                        </button>
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
                    id: '',
                    state: '',
                    user_id: '',
                },

                records: [],
                errors: []
            }
        },
        props: {
            assetid: Number,
        },
        created() {
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
                    state: '',
                    user_id: '',
                };
            },
            /**
             * Inicializa los registros base del formulario
             *
             * @author Henry Paredes <hparedes@cenditel.gob.ve>
             */
            initRecords(url,modal_id){
                const vm = this;
                vm.errors = [];
                var fields = {};
                axios.get(url).then(response => {
                    if (typeof(response.data.record) !== "undefined") {
                        fields = response.data.record;
                    }
                    if ($("#" + modal_id).length) {
                        $("#" + modal_id).modal('show');
                    }
                }).catch(error => {
                    if (typeof(error.response) !== "undefined") {
                        if (error.response.status == 403) {
                            vm.showMessage(
                                'custom', 'Acceso Denegado', 'danger', 'screen-error', error.response.data.message
                            );
                        }
                        else {
                            vm.logs('resources/js/all.js', 343, error, 'initRecords');
                        }
                    }
                });
            },
            createRecord(url, list = true, reset = true) {
                const vm = this;
                vm.loading = true;

                axios.patch('/' + url + '/' + vm.assetid, vm.record).then(response => {
                    if (typeof(response.data.redirect) !== "undefined") {
                        location.href = response.data.redirect;
                    }
                    else {
                        vm.errors = [];
                        if (reset) {
                            vm.reset();
                        }
                        if (list) {
                            vm.readRecords(url);
                        }
                        vm.loading = false;
                        vm.showMessage('store');
                    }

                }).catch(error => {
                    vm.errors = [];
                    if (typeof(error.response) !="undefined") {
                        for (var index in error.response.data.errors) {
                            if (error.response.data.errors[index]) {
                                vm.errors.push(error.response.data.errors[index][0]);
                            }
                        }
                    }
                    vm.loading = false;
                });
            }
        },
    }
</script>
