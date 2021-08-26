<template>
    <section>
        <a class="btn btn-info btn-xs btn-icon btn-action"
           href="#" title="Cerrar solicitud" data-toggle="tooltip" v-has-tooltip
           @click="addRecord('view_close'+request_id, route_list, $event)">
           <i class="icofont icofont-zipped"></i>
        </a>
        <div class="modal fade text-left" tabindex="-1" role="dialog" :id="'view_close'+request_id">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h6>
                            <i class="icofont icofont-read-book ico-2x"></i>
                            Adjuntar Información
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
                                <strong>Fecha de verificación</strong>
                                <input type="date" id="date"
                                    class="form-control input-sm" data-toggle="tooltip"
                                    title="Indique la fecha de verificación">
                                    <input type="hidden" id="id">

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="input-group">
                                    <input id="file" name="file" class="d-none" type="file"
                                           accept=".doc, .pdf, .odt, .docx, .jpg, .png, .jpeg, .mp4, .avi" @change="processFiles()">
                                    <label for="file">
                                    <a class="btn btn-sm btn-primary btn-info text-light"> Subir archivo </a>
                                    </label>

                            </div>
                        </div>

                    </div>
                    <hr>
                    <v-client-table :columns="columns" :data="records" :options="table_options">

                        <div slot="id" slot-scope="props" class="text-center">
                                <div class="d-inline-flex">
                                    <button @click="deleteRecord(props.index, 'request-close')"
                                        class="btn btn-danger btn-xs btn-icon btn-action"
                                        title="Eliminar registro" data-toggle="tooltip" type="button">
                                        <i class="fa fa-trash-o"></i>
                                    </button>

                                </div>
                        </div>

                    </v-client-table>
                </div>
                    <div class="modal-footer">
                        <div class="form-group">
                            <modal-form-buttons saveRoute="citizenservice/request-close"></modal-form-buttons>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    var formData = new FormData();
    export default {
        data() {
            return {
                record: {
                    id: ''
                },
                records: [],
                errors: [],
                columns: ['file', 'size', 'state', 'id']
            }
        },
        mounted() {
            const vm = this;
            $('#view_close'+ vm.request_id).on('show.bs.modal', function() {
                vm.records = [];
                vm.readRecords(vm.route_list);
                $(".modal-body #id").val( vm.request_id );
                vm.record['id'] = $(".modal-body #id").val();
            });
        },
        created() {
            this.table_options.headings = {
                'file': 'Archivo',
                'size': 'Tamaño',
                'state': 'Estado',
                'id': 'Acción'
            };
            this.table_options.sortable = ['file', 'size', 'state'];
            this.table_options.filterable = ['file', 'size', 'state'];

        },
        props: {
            request_id: {
                type: Number
            },
        },
        methods: {
            /**
             * Método que borra todos los datos del formulario
             *
             *
             */
            reset() {
                const vm = this;
                vm.record = {
                    id: $(".modal-body #id").val()
                };
                vm.records = [];
            },

            deleteRecord(index, url) {
                var url = (url)?url:this.route_delete;
                var records = this.records;
                var confirmated = false;
                var index = index - 1;
                const vm = this;

                bootbox.confirm({
                    title: "¿Eliminar registro?",
                    message: "¿Está seguro de eliminar este registro?",
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
                            confirmated = true;
                            axios.delete(url + '/' + records[index].id).then(response => {
                                if (typeof(response.data.error) !== "undefined") {
                                    /** Muestra un mensaje de error si sucede algún evento en la eliminación */
                                    vm.showMessage('custom', 'Alerta!', 'warning', 'screen-error', response.data.message);
                                    return false;
                                }
                                records.splice(index, 1);
                                vm.showMessage('destroy');
                            }).catch(error => {
                                vm.logs('mixins.js', 498, error, 'deleteRecord');
                            });
                        }
                    }
                });

                if (confirmated) {
                    this.records = records;
                    this.showMessage('destroy');
                }
            },

            initRecords(url,modal_id){
                this.errors = [];
                this.reset();
                if ($("#" + modal_id).length) {
                    $("#" + modal_id).modal('show');
                }
            },
            processFiles() {
                const vm = this;
                var inputFile = document.querySelector('#file');
                formData.append("file", inputFile.files[0]);
                formData.append("request_id", $(".modal-body #id").val())
                axios.post('citizenservice/requests/validate-document', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(response => {
                    let field = {
                        id:    response.data.file_id,
                        url:   response.data.file_url,
                        file:  response.data.file_name ? response.data.file_name: 'No definido',
                        size:  response.data.file_size ? response.data.file_size: 'No definido',
                        state: 'Completado',
                    };
                    vm.records.push(field);
                    vm.showMessage(
                        'custom', 'Éxito', 'success', 'screen-ok',
                        'Documento cargado de manera existosa.'
                    );
                }).catch(error => {
                    vm.errors = [];

                    if (typeof(error.response) !="undefined") {
                        for (var index in error.response.data.errors) {
                            if (error.response.data.errors[index]) {
                                vm.errors.push(error.response.data.errors[index][0]);
                            }
                        }
                    }
                });
            },
        },

    };
</script>
