<template>
    <v-client-table :columns="columns" :data="records" :options="table_options">
        <div slot="state" slot-scope="props">
            <span>
                {{ (props.row.state)?props.row.state:'N/A' }}
            </span>
        </div>
    </v-client-table>
</template>

<script>
    export default {
        data() {
            return {
                records: [],
                columns: ['name', 'email', 'phone']
            }
        },
        created() {
            this.table_options.headings = {
                'name': 'Nombre y apellido',
                'email': 'Correo',
                'phone': 'Teléfono',
            };
            this.table_options.sortable = ['name', 'email', 'phone'];
            this.table_options.filterable = ['name', 'email', 'phone'];
            this.table_options.columnsClasses = {
                'name': 'col-md-4',
                'email': 'col-md-4',
                'phone': 'col-md-4',
            };
        },
        mounted () {
            this.initRecords(this.route_list, '');
        },
        methods: {
            reset() {
                
            },
        }
    };
</script>
