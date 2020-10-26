<template>
    <section id="payrollVacationRequestListComponent">
        <v-client-table :columns="columns" :data="records" :options="table_options">
            <div slot="id" slot-scope="props" class="text-center">
                <button @click="showRecord(props.row.id)"
                        class="btn btn-info btn-xs btn-icon btn-action"
                        data-toggle="tooltip" title="Ver información del registro"
                        data-placement="bottom" type="button">
                    <i class="fa fa-info-circle"></i>
                </button>
                <button @click="editForm(props.row.id)"
                        class="btn btn-warning btn-xs btn-icon btn-action"
                        data-toggle="tooltip" title="Modificar registro"
                        data-placement="bottom" type="button">
                    <i class="fa fa-edit"></i>
                </button>
                <button @click="deleteRecord(props.index, '')"
                        class="btn btn-danger btn-xs btn-icon btn-action btn-tooltip"
                        title="Eliminar registro" data-toggle="tooltip" data-placement="bottom"
                        type="button">
                    <i class="fa fa-trash-o"></i>
                </button>
            </div>
        </v-client-table>
    </section>
</template>
<script>
    export default {
        data() {
            return {
                record:  {},
                records: [],
                columns: ['code', 'created_at', 'payroll_staff', 'status', 'id'],
            }
        },
        created() {
            const vm = this;
            vm.table_options.headings = {
                'code':          'Código',
                'created_at':    'Fecha de la solicitud',
                'payroll_staff': 'Trabajador',
                'status':        'Estatus de la solicitud',
                'id':            'Acción'
            };
            vm.table_options.sortable   = ['code', 'created_at', 'payroll_staff', 'status'];
            vm.table_options.filterable = ['code', 'created_at', 'payroll_staff', 'status'];
        },

        mounted() {
            const vm = this;
            vm.initRecords(vm.route_list, '');
        },
        methods: {
            reset() {
                //
            }
        }
    };
</script>
