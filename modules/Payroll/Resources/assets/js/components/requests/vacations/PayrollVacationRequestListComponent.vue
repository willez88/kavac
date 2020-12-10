<template>
    <section id="payrollVacationRequestListComponent">
        <v-client-table :columns="columns" :data="records" :options="table_options">
            <div slot="date" slot-scope="props">
                <span> {{ format_date(props.row.created_at, 'YYYY-MM-DD') }} </span>
            </div>
            <div slot="payroll_staff" slot-scope="props">
                <span>
                    {{ 
                        props.row.payroll_staff
                            ? props.row.payroll_staff.id
                                ? props.row.payroll_staff.first_name + ' ' + props.row.payroll_staff.last_name
                                : 'No definido'
                            : 'No definido'

                    }}
                </span>
            </div>
            <div slot="status" slot-scope="props">
                <span v-if="props.row.status == 'approved'">
                    Aprobado
                </span>
                <span v-else-if="props.row.status == 'pending'">
                    Pendiente
                </span>
                <span v-else>
                    Rechazado
                </span>
            </div>
            <div slot="id" slot-scope="props" class="text-center">
                <div class="d-inline-flex ">
                    <payroll-vacation-request-show
                        :route_show="'payroll/vacation-requests/show/' + props.row.id"
                        :id="props.row.id">
                    </payroll-vacation-request-show>
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
                columns: ['code', 'date', 'payroll_staff', 'status', 'id'],
            }
        },
        created() {
            const vm = this;
            vm.table_options.headings = {
                'code':          'Código',
                'date':          'Fecha de la solicitud',
                'payroll_staff': 'Trabajador',
                'status':        'Estatus de la solicitud',
                'id':            'Acción'
            };
            vm.table_options.sortable   = ['code', 'date', 'payroll_staff', 'status'];
            vm.table_options.filterable = ['code', 'date', 'payroll_staff', 'status'];
        },

        mounted() {
            const vm = this;
            vm.initRecords(vm.route_list, '');
        },
        methods: {
            reset() {
                //
            },
        }
    };
</script>
