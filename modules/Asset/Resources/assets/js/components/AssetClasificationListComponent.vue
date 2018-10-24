<template>
        <div class="col-md-6">
            <div class="form-group">
                <label>Tipo de Bien:</label>
                <select2 :options="types" v-model="record.type_id"></select2>
                <input type="hidden" v-model="record.id">
            </div>
        </div>

                                                <button onclick="openmodal( <?php echo($asset->id) ?> );" 
                                                        class="btn btn-info btn-xs btn-icon btn-round"  
                                                data-toggle="tooltip" title="Informacion Bien">
                                                    <i class="fa fa-info-circle"></i>
                                                </button>
</template>

<script>
    export default {
        data() {
            return {
                record: {
                        id: '',
                        type_id: ''
                    },
                errors: [],
                records: [],
                types: []
            }
        },
        mounted() {
        },
        methods: {
            /**
             * Método que borra todos los datos del formulario
             * 
             * @author  Ing. Roldan Vargas (rvargas at cenditel.gob.ve / roldandvg@gmail.com)
             */
            reset() {
                this.record = {
                    id: '',
                    type_id: ''
                };
            },
            initRecords() {
                axios.get('/asset/vue-list').then(response => {
                    this.types = response.data;
                });
            }

        }
    }
</script>