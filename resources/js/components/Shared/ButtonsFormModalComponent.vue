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
            saveEvent: function() {
                this.$parent.createRecord(this.saveRoute);
            }
        },
        mounted() {
            
        }
    };
</script>
