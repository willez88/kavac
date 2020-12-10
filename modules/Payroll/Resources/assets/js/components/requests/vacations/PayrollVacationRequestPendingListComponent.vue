<template>
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
        
        <div slot="id" slot-scope="props" class="text-center">
            <div class="d-inline-flex">
                <payroll-review-vacation-request-pending-form
                    :route_show="'payroll/vacation-requests/show/' + props.row.id"
                    :id="props.row.id">
                </payroll-review-vacation-request-pending-form>
            </div>
        </div>
    </v-client-table>
</template>

<script>
    export default {
        data() {
            return {
                records: [],
                columns: ['code', 'date', 'payroll_staff', 'id']
            }
        },
        created() {
            const vm = this;
            vm.table_options.headings = {
                'code':          'Código',
                'date':          'Fecha de la solicitud',
                'payroll_staff': 'Trabajador',
                'id':            'Acción'
            };
            vm.table_options.sortable   = ['code', 'date', 'payroll_staff'];
            vm.table_options.sortable   = ['code', 'date', 'payroll_staff'];
        },
        mounted () {
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
