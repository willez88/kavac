<template>
    <v-client-table :columns="columns" :data="records" :options="table_options">
        <div slot="id" slot-scope="props" class="text-center">
            <button @click="editForm(props.row.id)"
                    class="btn btn-warning btn-xs btn-icon btn-action"
                    title="Modificar registro" data-toggle="tooltip" type="button">
                <i class="fa fa-edit"></i>
            </button>
            <button @click="deleteRecord(props.index, '')"
                    class="btn btn-danger btn-xs btn-icon btn-action"
                    title="Eliminar registro" data-toggle="tooltip"
                    type="button">
                <i class="fa fa-trash-o"></i>
            </button>
        </div>
        <div slot="document_status" slot-scope="props" class="text-center">
            <span>{{ props.row.document_status.name }}</span>
        </div>
    </v-client-table>
</template>

<script>
    export default {
        data() {
            return {
                records: [],
                columns: ['compromised_at', 'code', 'description', 'document_status', 'id']
            }
        },
        created() {
            this.table_options.headings = {
                'compromised_at': 'Fecha',
                'code': 'Código',
                'description': 'Descripción',
                'document_status': 'Estatus',
                'id': 'Acción'
            };
            this.table_options.sortable = ['code', 'compromised_at', 'description'];
            this.table_options.filterable = ['code', 'compromised_at', 'description'];
            this.table_options.columnsClasses = {
                'compromised_at': 'col-md-2',
                'code': 'col-md-2',
                'description': 'col-md-4',
                'document_status': 'col-md-2',
                'id': 'col-md-2'
            };
        },
        mounted() {
            this.initRecords(this.route_list, '');
        },
        methods: {
            /**
             * Inicializa los datos del formulario
             *
             * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             */
            reset() {

            },
        }
    };
</script>
