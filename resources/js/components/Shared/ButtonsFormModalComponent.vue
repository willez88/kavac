<template>
    <div>
        <button type="button" class="btn btn-default btn-sm btn-round btn-modal-close" data-dismiss="modal">
            Cerrar
        </button>
        <button type="button" @click="saveEvent()" class="btn btn-primary btn-sm btn-round btn-modal-save">
            Guardar
        </button>
    </div>
</template>

<script>
    export default {
        props: {
            saveRoute: {
                type: String,
                required: true
            }
        },
        methods: {
            /**
             * Gestiona el evento que permite guardar un registro
             *
             * @method    saveEvent
             *
             * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             */
            saveEvent: function() {
                this.$parent.createRecord(this.saveRoute);
            }
        },
        mounted() {
            //Agregar aquí el código que sea necesario para personalizar el comportamiento de este componente
        }
    };
</script>
