<template>
    <div class="text-center">
        <img :src="url" alt="Imagen" class="img-fluid default-image-style" id="showImage"
             title="Click para cargar o modificar la imagen" data-toggle="tooltip" @click="selectImage('image')"
             :style="{'width': imgWidth, 'height': imgHeight}">
        <input type="file" id="image" name="image" class="hide-image-file" @change="uploadImage('image')"
               accept="image/*">
        <div class="row" :class="{'row-delete-img': (!id)}" v-if="id !== ''">
            <div class="col-12">
                <div class="text-center">
                    <a id="imgDelete" href="javascript:void(0)" @click.prevent="deleteImage(true)"
                       class="btn btn-primary btn-simple btn-img-action" title="Eliminar imagen"
                       data-toggle="tooltip">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                id: '',
                url: '',
            }
        },
        props: {
            imgWidth: {
                type: String,
                required: false,
                default: '64px',
            },
            imgHeight: {
                type: String,
                required: false,
                default: '64px',
            },
            imgDefault: {
                type: String,
                required: false,
                default: '/images/no-image2.png'
            },
            imgId: {
                type: Number,
                required: false,
                default: ''
            }
        },
        watch: {
            imgDefault: function(newVal, oldVal) {
                this.url = this.imgDefault
                this.id = this.imgId;
            }
        },
        methods: {
            /**
             * Método realiza la acción para seleccionar una imagen a cargar
             *
             * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             *
             * @param {string} el   Identificador del elemento para seleccionar el archivo de imagen
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
                    axios.post(`${process.env.MIX_APP_URL}/upload-image`, formData, {
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
                        vm.url = `${process.env.MIX_APP_URL}/${response.data.image_url}`;
                        vm.$emit('changeImage', vm.id);
                        $('#imgDelete').tooltip({delay: {hide:100}});
                    }).catch(error => {
                        vm.logs('ImageManagementComponent', 120, error, 'uploadImage');
                    });
                }
                else {
                    axios.put(`${process.env.MIX_APP_URL}/upload-image/${id}`).then(response => {
                        // Lógica para actualizar una imagen
                    }).catch(error => {
                        vm.logs('ImageManagementComponent', 127, error, 'uploadImage');
                    });
                }
            },
            /**
             * Realiza la acción para eliminar una imagen
             *
             * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             *
             * @param      {boolean}    force_delete    Condición que indica si la imagen será eliminada permanentemente
             *
             * @return     {boolean}    Retorna falso si ocurrió un error al eliminar la imagen
             */
            deleteImage: function(force_delete) {
                let vm = this;
                var force_delete = (typeof(force_delete) !== undefined && force_delete)
                       ? {force_delete: force_delete} : {};
                if (vm.id) {
                    bootbox.confirm("Esta seguro de querer eliminar la imagen?", function(result) {
                        if (result) {
                            // Determinar si el valor es un arreglo de ids. Ej. 1,2,3,4,5,etc
                            axios.delete(`${process.env.MIX_APP_URL}/upload-image/${vm.id}`, force_delete).then(response => {
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
                                    vm.url = `${process.env.MIX_APP_URL}/images/no-image2.png`;

                                }
                            }).catch(error => {
                                vm.logs('ImageManagementComponent', 165, error, 'deleteImage');
                            });
                        }
                    });
                }
            }
        },
        mounted() {
            let vm = this;
            vm.url = (vm.imgDefault) ? vm.imgDefault : `${process.env.MIX_APP_URL}/images/no-image2.png`;
        }
    };
</script>
