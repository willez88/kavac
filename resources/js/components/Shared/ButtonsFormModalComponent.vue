<template>
    <div>
        <button type="button" class="btn btn-default btn-sm btn-round btn-modal-close" @click="clearFilters" data-dismiss="modal">
            Cerrar
        </button>
        <button type="button" @click="reset()" class="btn btn-warning btn-sm btn-round btn-modal btn-modal-clear">
            Cancelar
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
             * Reinicia los valores de los campos del formulario a su estado inicial
             *
             * @method    reset
             *
             * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             */
            reset: function() {
                this.$parent.reset();
            },
            /**
             * Gestiona el evento que permite guardar un registro
             *
             * @method    saveEvent
             *
             * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             */
            saveEvent: function() {
                this.$parent.createRecord(this.saveRoute);
            },
            /**
             * Reinicia los valores de los filtros de consulta
             *
             * @method    clearFilters
             *
             * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             */
            clearFilters: function() {
                $(".VueTables__search__input").val('');
                this.$parent.$children.forEach((child) => {
                    if (child.$el.className.startsWith('VueTables')) {
                        child._data.query = "";
                    }
                });
            }
        },
        mounted() {
            //Agregar aquí el código que sea necesario para personalizar el comportamiento de este componente
        }
    };
</script>
