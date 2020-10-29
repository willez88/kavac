<template>
    <form class='form-horizontal'>
        <div class='card-body'>
            <div class='row'>
                <div class='col-md-6'>
                    <h6>
                        <i class="icofont icofont-file-pdf"></i> Verificar documentos PDF 
                    </h6>
                    <div class="form-group">
                        <label class="btn btn-primary">
                            <i class="fa fa-folder-open-o" aria-hidden="true"></i>&nbsp;Seleccionar un archivo
                            <input type="file" accept=".pdf" name="myfile">
                        </label>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <button class="btn btn-lg">
                    <i class="fa fa-ban"></i>
                    Cancelar
                </button>
                <button class="btn btn-lg btn-primary" @click="createRecord('digitalsignature/apiVerifysignfile')">
                    <i class="fa fa-save"></i>
                    Guardar
                </button>
            </div>
        </div>
    </form>
</template>

<script>
    export default {
        data() {
            return {
                record:{ 
                }
            }
        }
        
        methods: {
            onFileSelected (event) {
               const file = event.target.files[0];
               const formData = new FormData();
               formData.append("my-file", file);
               Vue.http.post(`server-url`, formData, {
                  headers: {
                    'Content-Type': 'multipart/form-data'
                  }
               })
                .then(res => {
                    //todo ok
                },
                error => {
                    //todo mal :P
                })
            }

            /**
             * @method    createRecord
             *
             * [createRecord Envia el documento PDf para verificar la firma electrónica ]
             *
             * @author Pedro Buitrago <pbuitrago@cenditel.gob.ve | pedrobui@gmail.com>
             *
             * @param  {string} url Ruta de la acción a ejecutar para la creación o actualización de datos
             */
            createRecord(url) {
                const vm = this;

                // Se almacena el documento PDF en un FormData
                let formData = new FormData();

                const file = event.target.files[0];

                axios.post(`${vm.domain}/${url}`, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(response => {
                    location.href = response.data.redirect;

                }).catch(err => {
                    vm.errors = {};
                });
            },
        }
    }
</script>