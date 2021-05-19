<template>
    <v-client-table :columns="columns" :data="records" :options="table_options">
        <div slot="state" slot-scope="props">
            <span>
                {{ (props.row.state)?props.row.state:'N/A' }}
            </span>
        </div>
        <div slot="id" slot-scope="props" class="text-center">
            <div class="d-inline-flex">
                <!--sale-service-info
                    :route_list="'/sale/services/info/'+ props.row.id">
                </sale-service-info-->

                <button @click="editForm(props.row.id)"
                        class="btn btn-warning btn-xs btn-icon btn-action"
                        title="Modificar registro" data-toggle="tooltip" type="button"
                        :disabled="props.row.state != 'Pendiente'">
                    <i class="fa fa-edit"></i>
                </button>
                <button @click="deleteRecord(props.row.id, 'sale/services/delete')"
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
             * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
             */
            reset() {

            },
        }
    };
</script>
