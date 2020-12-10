<template>
    <section id="payrollListComponent">
        <v-client-table :columns="columns" :data="records" :options="table_options">
            <div slot="id" slot-scope="props" class="text-center">
                <button @click="showRecord(props.row.id)"
                        class="btn btn-info btn-xs btn-icon btn-action"
                        data-toggle="tooltip" title="Ver información del registro"
                        data-placement="bottom" type="button">
                    <i class="fa fa-info-circle"></i>
                </button>
                <button
                        class="btn btn-primary btn-xs btn-icon btn-action"
                        data-toggle="tooltip" title="Imprimir registro"
                        data-placement="bottom" type="button">
                    <i class="fa fa-print"></i>
                </button>
                <button :disabled="props.row.payroll_payment_period.payment_status != 'pending'"
                        @click="editForm(props.row.id)"
                        class="btn btn-warning btn-xs btn-icon btn-action"
                        data-toggle="tooltip" title="Modificar registro"
                        data-placement="bottom" type="button">
                    <i class="fa fa-edit"></i>
                </button>
                <button :disabled="props.row.payroll_payment_period.payment_status != 'pending'"
                        @click="closeRecord(props.row.id)"
                        class="btn btn-default btn-xs btn-icon btn-action"
                        data-toggle="tooltip" title="Cerrar registro"
                        data-placement="bottom" type="button">
                    <i class="fa fa-unlock-alt"></i>
                </button>
            </div>
            <div slot="created_at" slot-scope="props">
                {{ format_timestamp(props.row.created_at) }}
                
            </div>
            <div slot="payroll_payment_period" slot-scope="props" class="text-center">
                {{
                    props.row.payroll_payment_period
                        ? format_date(props.row.payroll_payment_period.start_date) + ' - ' + format_date(props.row.payroll_payment_period.end_date)
                        : 'No definido'
                }}
                
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
                columns: ['created_at', 'name', 'payroll_payment_period', 'id'],
            }
        },
        created() {
            const vm = this;
            vm.table_options.headings = {
                'created_at':             'Fecha de generación',
                'name':                   'Nombre',
                'payroll_payment_period': 'Período de pago',
                'id':                     'Acción'
            };
            vm.table_options.sortable   = ['created_at', 'name', 'payroll_payment_period'];
            vm.table_options.filterable = ['created_at', 'name', 'payroll_payment_period'];
        },

        mounted() {
            const vm = this;
            vm.initRecords(vm.route_list, '');
        },
        methods: {
            reset() {
                //
            },
            closeRecord(id) {
                const vm = this;
                axios.patch("/payroll/registers/close/" + id, null).then(response => {
                    if (typeof(response.data.redirect) !== "undefined")
                        location.href = response.data.redirect;
                }).catch(error => {
                    vm.errors = [];
                    if (typeof(error.response) !="undefined") {
                        for (var index in error.response.data.errors) {
                            if (error.response.data.errors[index]) {
                                vm.errors.push(error.response.data.errors[index][0]);
                            }
                        }
                    }
                });
            }
        }
    };
</script>
