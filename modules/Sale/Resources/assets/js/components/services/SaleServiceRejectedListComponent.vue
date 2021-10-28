<template>
    <v-client-table :columns="columns" :data="records" :options="table_options">
        <div slot="code" slot-scope="props">
            <span>
                {{ (props.row.code) ? props.row.code : '' }}
            </span>
        </div>
        <div slot="application_date" slot-scope="props">
            <span>
                {{ (props.row.created_at) ? props.row.created_at : '' }}
            </span>
        </div>
        <div slot="sale_client" slot-scope="props">
            <span>
                {{ (props.row.sale_client.name) ? props.row.sale_client.name : '' }}
            </span>
        </div>
        <div slot="department" slot-scope="props">
            <span v-for="sale_good in props.row.sale_goods">
                <span v-for="good in sale_good">
                    {{ (props.row.sale_goods) ? good.department.name : '' }}
                </span>
            </span>
        </div>
        <div slot="id" slot-scope="props" class="text-center">
            <div class="d-inline-flex">
                 <!--sale-bill-info
                    :route_list="'/sale/bills/info/'+ props.row.id">
                </sale-bill-info-->

                <a class="btn btn-primary btn-xs btn-icon"
                        :href="'/sale/service/pdf/'+props.row.id"
                        title="Emitir pdf"
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
                columns: ['code', 'application_date', 'sale_client', 'department', 'status', 'id']
            }
        },
        created() {
            this.table_options.headings = {
                'code': 'Código',
                'application_date': 'Fecha de solicitud',
                'sale_client': 'Nombre del cliente',
                'department': 'Unidad o departamento responsable',
                'status': 'Estado de la solicitud',
                'id': 'Acción'
            };
            this.table_options.sortable = ['code', 'application_date', 'sale_client', 'department', 'status'];
            this.table_options.filterable = ['code', 'application_date', 'sale_client', 'department', 'status'];
            this.table_options.columnsClasses = {
                'code': 'col-md-2',
                'application_date': 'col-md-2',
                'sale_client': 'col-md-2',
                'department': 'col-md-2',
                'status': 'col-md-2',
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
             * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
             */
            reset() {
                
            },
            getSaleRejectedService() {
                const vm = this;

                axios.get('/sale/bills/vue-rejected-list/Rechazado').then(response => {
                    vm.records = response.data.records;
                });
            },
        },
        mounted() {
            let vm = this;

            vm.getSaleRejectedService();
        }
    };
</script>
