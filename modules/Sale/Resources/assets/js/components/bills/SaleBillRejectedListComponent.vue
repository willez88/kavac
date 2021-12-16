<template>
    <v-client-table :columns="columns" :data="records" :options="table_options">
        <div slot="price" slot-scope="props" >
            <div>
                Precio total: {{ price(props.row.sale_bill_inventory_product) }}
            </div>
        </div>
        <div slot="state" slot-scope="props">
            <span>
                {{ (props.row.state)?props.row.state:'N/A' }}
            </span>
        </div>
        
        <div slot="id" slot-scope="props" class="text-center">
            <div class="d-inline-flex">
                 <!--sale-bill-info
                    :route_list="'/sale/bills/info/'+ props.row.id">
                </sale-bill-info-->

                <a class="btn btn-primary btn-xs btn-icon"
                        :href="'/sale/bills/pdf/'+props.row.id"
                        title="Emitir factura"
                        data-toggle="tooltip"
                        target="_blank">
                        <i class="fa fa-print" style="text-align: center;"></i>
                </a>

            </div>
        </div>
    </v-client-table>
</template>

<script>
    export default {
        data() {
            return {
                records: [],
                columns: ['code', 'sale_client.rif', 'sale_client.name_client', 'price', 'state', 'id']
            }
        },
        created() {
            this.table_options.headings = {
                'code': 'Código',
                'sale_client.rif': 'RIF',
                'sale_client.name_client': 'Nombre del cliente',
                'price': 'Monto',
                'state': 'Estado de la factura',
                'id': 'Acción'
            };
            this.table_options.sortable = ['code', 'sale_client.rif', 'sale_client.name_client', 'price', 'state'];
            this.table_options.filterable = ['code', 'sale_client.rif', 'sale_client.name_client', 'price', 'state'];
            this.table_options.columnsClasses = {
                'code': 'col-md-2',
                'sale_client.rif': 'col-md-2',
                'sale_client.name_client': 'col-md-2',
                'price': 'col-md-2',
                'state': 'col-md-2',
                'id': 'col-md-2'
            };
        },
        mounted () {
            this.initRecords(this.route_list, '');
        },
        methods: {
            price(prods){
                const vm = this;
                var total = 0;
                $.each(prods, function(index, prod) {
                    total += prod['quantity']*parseInt(prod['sale_warehouse_inventory_product']['unit_value']);
                });
                return total;
            },
            /**
             * Inicializa los datos del formulario
             *
             * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
             */
            reset() {
                
            },
            getSaleRejectedBill() {
                const vm = this;

                axios.get('/sale/bills/vue-rejected-list/Rechazado').then(response => {
                    vm.records = response.data.records;
                });
            },
        },
        mounted() {
            let vm = this;

            vm.getSaleRejectedBill();
        }
    };
</script>
