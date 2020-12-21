<template>
    <div class="col-xs-2 text-center">
        <a class="btn-simplex btn-simplex-md btn-simplex-primary" href title="Firmar PDF" data-toggle="tooltip"
           @click="addRecord('digitalsignature-apiVerifySign', '', $event)">
            <i class="icofont icofont-file-pdf ico-3x"></i>
            <span>Verificar firma PDF </span>
        </a>
        <div class="modal fade text-left" tabindex="-1" role="dialog" id="digitalsignature-apiVerifySign">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h6>
                            <i class="icofont icofont-file-pdf ico-2x"></i>
                            Verificar documentos PDF
                        </h6>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger mb-3" v-if="errors.length > 0">
                            <ul>
                                <li v-for="error in errors">{{ error }}</li>
                            </ul>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-sm btn-info btn-import" type="button" data-toggle="tooltip"
                                    @click="setFile('pdf')"
                                    title="Presione para subir el archivo. Los archivos permitidos son: .pdf">
                                <i class="fa fa-upload"></i>
                            </button>
                            <input id="pdf" class="d-none" type="file" name="file" accept=".pdf"
                                   @change="selectedFile('pdf')" required />
                            <label id="pdf-label" for="pdf"> Seleccionar archivo pdf </label>
                        </div>
                        <button class="btn btn-primary btn-sm btn-round btn-modal-close" @click="verifyFile()">
                            <i class="fa fa-search"></i>
                            Verificar
                        </button>
                        <div class="row" v-if="show">
                            <div class="col-12 pt-3">
                                <h6> Detalle de la firma </h6>
                                <p v-for="item in records"> {{ item }} </p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-default btn-sm btn-round btn-modal-close" type="button" data-dismiss="modal">
                            Cerrar
                        </button>
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
                errors: [],
                records: [],
                show: false,
                loading: false,
            }
        },

        methods: {
            /**
             * Método que borra todos los datos del formulario
             *
             * @author Yennifer Ramirez <yramirez@cenditel.gob.ve>
             */
            reset() {},

            /**
             * Método que escribe el valor del nombre del pdf del input type=file en el label en este
             *
             * @author Angelo Osorio <adosorio@cenditel.gob.ve> | <danielking.321@gmail.com>
             *
             * @param  {string} input_id id del input y prefijo del label donde se mostrará el nombre del pdf
             */
            selectedFile(input_id) {
                const id = document.getElementById.bind(document);
                let text = (id(`${input_id}`).files[0]) ? id(`${input_id}`).files[0].name : "Seleccionar archivo pdf";
                id(`${input_id}-label`).textContent = text;
            },

            /**
             * Método que sube el archivo pdf y retorna la respuesta al componente
             *
             * @author Angelo Osorio <adosorio@cenditel.gob.ve> | <danielking.321@gmail.com>
             */
            verifyFile() {
                const vm = this;
                let data = new FormData();
                let pdfToVerify = document.getElementById('pdf').files[0];
                data.append('pdf', pdfToVerify);
                vm.loading = true;
                axios.post('digitalsignature/apiVerifysignfile', data).then(function (response) {
                    vm.errors = [];
                    vm.records = (typeof(response.data.records) === 'string') ? JSON.parse(response.data.records) : response.data.records;
                    vm.show = true;
                    vm.loading = false;
                }).catch(error => {
                    vm.errors = [];
                    vm.loading = false;

                    if (typeof(error.response) !="undefined") {
                        for (var index in error.response.data.errors) {
                            if (error.response.data.errors[index]) {
                                vm.errors.push(error.response.data.errors[index][0]);
                            }
                        }
                    }
                });
            }
        },
    };
</script>