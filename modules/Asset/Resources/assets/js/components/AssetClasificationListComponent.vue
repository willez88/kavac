<template>
        <div class="col-md-6">
            <div class="form-group">
                <label>Tipo de Bien:</label>
                <select2 :options="types" v-model="record.type_id"></select2>
                <input type="hidden" v-model="record.id">
            </div>
        </div>
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

            initRecords() {
                axios.get('/asset/vue-list').then(response => {
                    this.types = response.data;
                });
            }

        }
    }
</script>