<template>
    <section>
        <v-client-table :columns="columns" :data="records" :options="table_options" ref="tableResults">
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
                <span>
                    {{ (props.row.sale_client.business_name) ? props.row.sale_client.business_name : '' }}
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
                    <button @click.prevent="setDetails('ServiceInfo', props.row.id, 'SaleServiceInfo')"
                            class="btn btn-info btn-xs btn-icon btn-action btn-tooltip"
                            title="Ver registro" data-toggle="tooltip" data-placement="bottom" type="button">
                        <i class="fa fa-eye"></i>
                    </button>
                    <button @click="editForm(props.row.id)"
                            class="btn btn-warning btn-xs btn-icon btn-action"
                            title="Modificar registro" data-toggle="tooltip" type="button" v-has-tooltip
                            :disabled="props.row.status != 'Pendiente'">
                        <i class="fa fa-edit"></i>
                    </button>
                    <button @click="deleteRecord(props.row.id, 'sale/services/delete')"
                            class="btn btn-danger btn-xs btn-icon btn-action"
                            title="Eliminar registro" data-toggle="tooltip" type="button" v-has-tooltip
                            :disabled="props.row.status != 'Pendiente'">
                        <i class="fa fa-trash-o"></i>
                    </button>
                </div>
            </div>
        </v-client-table>
        <sale-service-info
            ref="ServiceInfo">
        </sale-service-info>
    </section>
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
             * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
             */
            reset() {

            },
        }
    };
</script>
