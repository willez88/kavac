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
                columns: ['name', 'email', 'phone', 'products']
            }
        },
        created() {
            this.table_options.headings = {
                'name': 'Nombre y apellido',
                'email': 'Correo',
                'phone': 'Teléfono',
                'products': 'Productos'
            };
            this.table_options.sortable = ['name', 'email', 'phone', 'products'];
            this.table_options.filterable = ['name', 'email', 'phone', 'products'];
            this.table_options.columnsClasses = {
                'name': 'col-md-2',
                'email': 'col-md-2',
                'phone': 'col-md-2',
                'products': 'col-md-4'
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
