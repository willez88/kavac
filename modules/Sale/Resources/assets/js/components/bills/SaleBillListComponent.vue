<template>
    <v-client-table :columns="columns" :data="records" :options="table_options">
        <div slot="description" slot-scope="props">
            <span>
                Cliente: {{ (props.row.sale_client_id)?props.row.sale_client_id:'N/A' }}
                Almacén: {{ (props.row.sale_warehouse_id)?props.row.sale_warehouse_id:'N/A' }}
                Forma de pago: {{ (props.row.sale_payment_method_id)?props.row.sale_payment_method_id:'N/A' }}
            </span>
        </div>
        <div slot="inventory" slot-scope="props">
            <span>
                Descuento: {{ (props.row.sale_discount_id)?props.row.sale_discount_id:'N/A' }}
                Método de pago: {{ (props.row.currency_id)?props.row.currency_id:'N/A' }}
            </span>
        </div>
        <div slot="requested" slot-scope="props">
            <span>                
                {{ (props.row.sale_setting_products)?props.row.sale_setting_products:'N/A' }}
            </span>
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
                <button @click="deleteRecord(props.index, '')"
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
                columns: ['description', 'inventory', 'requested', 'state', 'id']
            }
        },
        created() {
            this.table_options.headings = {
                'description': 'Descripción',
                'inventory': 'Inventario',
                'requested': 'Solicitados',
                'state': 'Estado de la factura',
                'id': 'Acción'
            };
            this.table_options.sortable = ['description', 'inventory', 'requested', 'state'];
            this.table_options.filterable = ['description', 'inventory', 'requested', 'state'];
            this.table_options.columnsClasses = {
				'description': 'col-md-3',
                'inventory': 'col-md-3',
                'requested': 'col-md-2',
                'state': 'col-md-2',
				'id': 'col-md-2'
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
