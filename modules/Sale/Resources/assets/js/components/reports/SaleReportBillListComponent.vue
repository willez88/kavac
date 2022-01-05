<template>
    <div id="sale-report-bill-list">
        <v-client-table :columns="columns" :data="records" :options="table_options" ref="tableResults">
        </v-client-table>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                records: [],
                columns: ['code', 'created_at', 'name', 'product_name', 'price', 'currency', 'state', 'id']
            }
        },
        created() {
            this.table_options.headings = {
                'code': 'Código',
                'created_at': 'Fecha de emisión',
                'name': 'Nombre del cliente',
                'product_name': 'Nombre del producto',
                'price': 'Monto',
                'currency': 'Moneda',
                'state': 'Estado de la factura',
                'id': 'Acción'
            };
            this.table_options.sortable = ['code', 'created_at', 'name', 'product_name', 'price', 'currency', 'state'];
            this.table_options.filterable = ['code', 'created_at', 'name', 'product_name', 'price', 'currency', 'state'];
            this.table_options.columnsClasses = {
                'code': 'col-md-2',
				'created_at': 'col-md-2',
                'name': 'col-md-2',
                'product_name': 'col-md-2',
                'price': 'col-md-1',
                'currency': 'col-md-2',
                'state': 'col-md-2',
				'id': 'col-md-1'
			};
        },
        mounted () {
            this.initRecords(this.route_list, '');
        },
        methods: {
            /**
             * Inicializa los datos del formulario
             *
             * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
             */
            reset() {
            },
        }
    };
</script>
