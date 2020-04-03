<template>
    <section id="TechnicalSupportDeliverEquipmentFormComponent">
        <a class="btn btn-default btn-xs btn-icon btn-action"
           href="#" title="Entregar equipos" data-toggle="tooltip"
           @click="addRecord('deliver_equipment_form',route_list, $event)">
            <i class=""></i>
        </a>

        <div class="modal fade text-left" tabindex="-1" role="dialog" id="deliver_equipment_form">
            <div class="modal-dialog vue-crud" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h6>
                            Entrega de Equipos
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
                                    <label>Solución</label>
                                    <ckeditor :editor="ckeditor.editor" data-toggle="tooltip"
                                              title="Indique una descripción de la solución del equipo reparado"
                                              :config="ckeditor.editorConfig" class="form-control"
                                              tag-name="textarea" rows="3" v-model="record.solution"></ckeditor>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group is-required">
                                    <label>Entregar a</label>
                                    <select2 :options="technicalSupportOptions"
                                             id="supportOptions"
                                             v-model="record.solution"></select2>
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
                                @click="createRecord('technicalsupport/repairs/deliver-equipment')"
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
                    description: '',
                    solution: ''
                },

                records: [],
                errors: [],
                technicalSupportOptions: [
                    {id: '', text: 'Seleccione...'},
                    {id: 'Trabajador', text: 'Trabajador'},
                    {id: 'Bienes', text: 'Bienes'}
                ]
            }
        },
        props: {
            repair_id: Number,
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
                    description: '',
                    solution: ''
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

                axios.patch('/' + url + '/' + vm.repair_id, vm.record).then(response => {
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
