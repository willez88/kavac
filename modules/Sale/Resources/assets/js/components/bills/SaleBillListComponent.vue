<template>
    <v-client-table :columns="columns" :data="records" :options="table_options">
        <div slot="product_name" slot-scope="props">
            <p v-for="product in props.row.sale_bill_inventory_product">
                {{ (product.product_type == 'Servicio') ? product.sale_goods_to_be_traded.name : product.sale_warehouse_inventory_product.sale_setting_product.name }}
            </p>
        </div>
        <div slot="price" slot-scope="props">
            <p v-for="product in props.row.sale_bill_inventory_product">
                {{ product.value }}
            </p>
        </div>
        <div slot="currency" slot-scope="props">
            <p v-for="product in props.row.sale_bill_inventory_product">
                {{ product.currency.symbol + ' - ' + product.currency.name }}
            </p>
        </div>
        <div slot="state" slot-scope="props">
            <span>
                {{ (props.row.state)?props.row.state:'N/A' }}
            </span>
        </div>
        <div slot="id" slot-scope="props" class="text-center">
            <div class="d-inline-flex">
                <sale-bill-info
                    :route_list="'/sale/bills/info/'+ props.row.id">
                </sale-bill-info>

                <button @click="editForm(props.row.id)"
                        class="btn btn-warning btn-xs btn-icon btn-action"
                        title="Modificar registro" data-toggle="tooltip" type="button"
                        :disabled="props.row.state != 'Pendiente'">
                    <i class="fa fa-edit"></i>
                </button>
                <button @click="deleteRecord(props.row.id, 'sale/bills/delete')"
                        class="btn btn-danger btn-xs btn-icon btn-action"
                        title="Eliminar registro" data-toggle="tooltip" type="button"
                        :disabled="props.row.state != 'Pendiente'">
                    <i class="fa fa-trash-o"></i>
                </button>
            </div>
        </div>
    </v-client-table>
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
