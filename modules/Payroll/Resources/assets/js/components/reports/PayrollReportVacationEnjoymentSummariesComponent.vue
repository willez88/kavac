<template>
    <section id="PayrollReportVacationEnjoymentSummariesForm">
        <div class="card-body">
            <div class="alert alert-danger" v-if="errors.length > 0">
                <ul>
                    <li v-for="error in errors">{{ error }}</li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <strong>Filtros</strong>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Desde:</label>
                        <input type="month" name="fecha" id="fecha" class="form-control input-sm">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Hasta:</label>
                        <input type="month" name="fecha" id="fecha" class="form-control input-sm">
                    </div>
                </div>
                <!-- trabajador -->
                <div class="col-md-6">
                    <div class="form-group is-required">
                        <label>Trabajador:</label>
                        <select2 :options="payroll_staffs"
                                 v-model="record.payroll_staff_id">
                        </select2>
                    </div>
                </div>
                <!-- ./trabajador -->
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button type="button"
                            class='btn btn-sm btn-info float-right'
                            title="Buscar registro" data-toggle="tooltip">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
            <hr>
            <v-client-table :columns="columns" :data="records" :options="table_options">
                <div slot="id" slot-scope="props" class="text-center">
                    <button @click="showReport(props.row.id, 'vacation-enjoyment-summaries', $event)" 
                            class="btn btn-primary btn-xs btn-icon btn-action" 
                            title="Generar reporte" data-toggle="tooltip" 
                            type="button">
                        <i class="fa fa-file-pdf-o"></i>
                    </button>
                </div>
            </v-client-table>
        </div>
    </section>
</template>

<script>
    export default {
        data() {
            return {
                record: {
                    id:               '',
                    payroll_staff_id: ''
                },

                errors:         [],
                records:        [],
                payroll_staffs: [],
                columns:        ['payroll_staff', 'start_date', 'year', 'vacation_periods', 'id']
            }
        },
        methods: {
            reset() {
                const vm = this;
                vm.record = {
                    id:               '',
                    payroll_staff_id: '',
                }
            },
            createReport(id, current, event) {
                const vm = this;
                vm.loading = true;
                var fields = {};
                for (var index in this.record) {
                    fields[index] = this.record[index];
                }
                fields["current"] = current;
                axios.post("/payroll/reports/vacation-enjoyment-summaries/create", fields).then(response => {
                    if (response.data.result == false)
                        location.href = response.data.redirect;
                    else if (typeof(response.data.redirect) !== "undefined") {
                        window.open(response.data.redirect, '_blank');
                    }
                    else {
                        vm.reset();
                    }
                    vm.loading = false;
                }).catch(error => {
                    if (typeof(error.response) != "undefined") {
                        console.log("error");
                    }
                    vm.loading = false;
                });
            },
        },
        created() {
            this.table_options.headings = {
                'payroll_staff':    'Trabajador',
                'start_date':       'Fecha de ingreso',
                'year':             'Años en la institución',
                'vacation_periods': 'Períodos vacacionales',
                'id':               'Acción'
            };
            this.table_options.sortable = ['payroll_staff', 'start_date', 'year', 'vacation_periods'];
            this.table_options.filterable = ['payroll_staff', 'start_date', 'year', 'vacation_periods'];
        },
        mounted() {
            const vm = this;
            vm.getPayrollStaffs();
        }
    };
</script>
