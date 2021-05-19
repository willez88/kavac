<template>
    <v-client-table :columns="columns" :data="records" :options="table_options">
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
                columns: ['code', 'application_date', 'sale_client.name_client', 'responsible_department', 'state', 'id']
            }
        },
        created() {
            this.table_options.headings = {
                'code': 'Código',
                'application_date': 'Fecha de solicitud',
                'sale_client.name_client': 'Nombre del cliente',
                'responsible_department': 'Unidad o departamento responsable',
                'state': 'Estado de la solicitud',
                'id': 'Acción'
            };
            this.table_options.sortable = ['code', 'application_date', 'sale_client.name_client', 'responsible_department', 'state'];
            this.table_options.filterable = ['code', 'application_date', 'sale_client.name_client', 'responsible_department', 'state'];
            this.table_options.columnsClasses = {
                'code': 'col-md-2',
                'application_date': 'col-md-2',
                'sale_client.name_client': 'col-md-2',
                'responsible_department': 'col-md-2',
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
