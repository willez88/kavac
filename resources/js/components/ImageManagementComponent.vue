<template>
    <div>
        <img :src="url" alt="Imagen" class="img-fluid default-image-size" id="showImage" 
             title="Click para cargar o modificar la imagen" data-toggle="tooltip" @click="selectImage('image')">
        <input type="file" id="image" name="image" class="hide-image-file" @change="uploadImage('image')">
        <div class="row" :class="{'row-delete-img': (!id)}">
            <div class="col-12">
                <div class="text-center">
                    <a id="imgDelete" href="javascript:void(0)" @click="deleteImage(true)">Eliminar</a>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
    .default-image-size {
        width: 64px;
        height: 64px;
        cursor:pointer;
    }
    .hide-image-file {
        display:none;
    }
</style>

<script>
    export default {
        data() {
            return {
                id: '',
                url: '',
            }
        },
        methods: {
            /**
             * Método que borra todos los datos del formulario
             * 
             * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             */
            selectImage(el) {
                $(`#${el}`).click();
            },
            /**
             * Sube una imagen al servidor y la muestra en su respectivo elemento de imagen
             *
             * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             *
             * @param      {string}         el            Identificador del elemento que contiene el archivo de imagen
             * @param      {integer}        id            Identificador del la imagen a actualizar. Opcional
             *
             * @return     {boolean}        Retorna falso si ocurrió un error al cargar la imagen
             */
            uploadImage: function(el, id) {
                let vm = this;
                var id = (typeof(id) !== "undefined") ? id : '';
                var formData = new FormData();
                var imagefile = document.querySelector(`#${el}`);
                formData.append("image", imagefile.files[0]);

                if (!id) {
                    axios.post(`${window.app_url}/upload-image`, formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }).then(response => {
                        if (!response.data.result) {
                            vm.showMessage(
                                'custom',
                                'Error',
                                'growl-danger',
                                'screen-error',
                                `La imagen no se pudo cargar, verifique e intente de nuevo. 
                                Si el problema persiste contacte al administrador del sistema.`
                            );
                            return false;
                        }
                        vm.id = response.data.image_id;
                        vm.url = response.data.image_url;
                    }).catch(error => {
                        console.log(error);
                    });
                }
                else {
                    axios.put(`${window.app_url}/upload-image/${id}`).then(response => {
                        // Lógica para actualizar una imagen
                    }).catch(error => {
                        console.log(error);
                    });
                }
            },
            deleteImage: function(force_delete) {
                let vm = this;
                var force_delete = (typeof(force_delete) !== undefined && force_delete) 
                       ? {force_delete: force_delete} : {};
                if (vm.id) {
                    bootbox.confirm("Esta seguro de querer eliminar la imagen?", function(result) {
                        if (result) {
                            // Determinar si el valor es un arreglo de ids. Ej. 1,2,3,4,5,etc
                            axios.delete(`${window.app_url}/upload-image/${vm.id}`, force_delete).then(response => {
                                if (!response.data.result) {
                                    $.gritter.add({
                                        title: 'Error!',
                                        text: response.data.message,
                                        class_name: 'growl-danger',
                                        image: "/images/screen-error.png",
                                        sticky: false,
                                        time: 2500
                                    });
                                }
                                else {
                                    vm.id = '';
                                    vm.url = `${window.app_url}/images/no-image2.png`;
                                }
                            }).catch(error => {
                                console.log(error);
                            });
                        }
                    });
                }
            }
        },
        mounted() {
            let vm = this;
            vm.url = `${window.app_url}/images/no-image2.png`;
        }
    };
</script>
