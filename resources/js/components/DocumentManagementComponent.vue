<template></template>

<script>
    export default {
        data() {
            return {
                id : '',
                url: '',
                status: ''
            }
        },
        props: {
            docId: {
                type: Number,
                required: false,
                default: ''
            },
            docStatus: {
                type: String,
                required: false,
                default: ''
            }
        },
        methods: {
            /**
             * Método realiza la acción para seleccionar un documento a cargar
             *
             * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             *
             * @param      {string}         el    Identificador del elemento para seleccionar el documento a cargar
             */
            selectDocument: function(el) {
                $(`#${el}`).click();
            },
            /**
             * Método que ejecuta la acción para cargar el documento
             *
             * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             *
             * @param      {string}         el    Identificador del elemento que contiene el archivo del documento
             * @param      {integer}        id    Identificador del documento a actualizar
             *
             * @return     {boolean}        Retorna falso si ocurrió un error al cargar el documento
             */
            uploadDocument: function(el, id) {

            },
            /**
             * Método que ejecuta la acción para descargar un documento
             *
             * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             *
             * @param      {integer}        id    Identificador del documento a descargar
             *
             * @return     {boolean}        Retorna falso si ocurrió un error al descargar el documento
             */
            downloadDocument: function(id) {

            },
            /**
             * Método que permite eliminar un documento
             *
             * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             *
             * @param      {boolean}        force_delete    Indica si el registro será eliminado permanentemente
             *
             * @return     {boolean}        Retorna falso si ocurrió un error al eliminar el documento
             */
            deleteDocument: function(force_delete) {

            }
        }
    };
</script>
