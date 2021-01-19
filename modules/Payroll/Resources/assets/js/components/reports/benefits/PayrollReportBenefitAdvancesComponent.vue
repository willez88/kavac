<template>
    <section id="PayrollReportBenefitAdvances">
        <div class="card-body">
            <div class="alert alert-danger" v-if="errors.length > 0">
                <ul>
                    <li v-for="error in errors">{{ error }}</li>
                </ul>
            </div>
			<div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Trabajador:</label>
                        <select2 :options="payroll_staffs"
                                 v-model="record.payroll_staff_id">
                        </select2>
                    </div>
                </div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group" style="text-align: right;">
						<label>Busqueda por Periodo</label>
						<div class="col-12">
                            <div class="col-12 bootstrap-switch-mini">
    							<input type="radio" name="type_search" value="period" id="sel_search_period"
    								   class="form-control bootstrap-switch bootstrap-switch-mini sel_type_search"
    								   data-on-label="SI" data-off-label="NO">
                            </div>
							<input type="hidden" v-model="record.type_search">
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class=" form-group">
						<label>Busqueda por Fecha </label>
						<div class="col-12">
                            <div class="col-12 bootstrap-switch-mini">
								<input type="radio" name="type_search" value="date" id="sel_search_date"
									   class="form-control bootstrap-switch bootstrap-switch-mini sel_type_search"
									   data-on-label="SI" data-off-label="NO">
                            </div>
						</div>
					</div>
				</div>
			</div>
			<div v-show="this.record.type_search == 'period'">
				<div class="row">
					<div class="col-md-4 offset-2">
						<div class="form-group">
							<label>Desde:</label>
							<div class="input-group input-sm">
			                    <span class="input-group-addon">
			                        <i class="now-ui-icons ui-1_calendar-60"></i>
			                    </span>
			                    <input type="date" data-toggle="tooltip" title="Indique la fecha minima de busqueda"
									   class="form-control input-sm" v-model="record.start_date">
			                </div>
	                    </div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Hasta:</label>
							<div class="input-group input-sm">
			                    <span class="input-group-addon">
			                        <i class="now-ui-icons ui-1_calendar-60"></i>
			                    </span>
			                    <input type="date" data-toggle="tooltip" title="Indique la fecha maxima de busqueda"
									   class="form-control input-sm" v-model="record.end_date">
			                </div>
	                    </div>
					</div>
				</div>
			</div>
			<div v-show="this.record.type_search == 'date'">
				<div class="col-md-4 offset-2">
					<div class="form-group">
						<label >Fecha</label>
    					<input type="date" class="form-control input-sm" data-toggle="tooltip"
                               title="Indique la fecha de solicitud" v-model="record.date">
    				</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<button type="button" class='btn btn-sm btn-info btn-custom float-right' data-toggle="tooltip"
							@click="filterRecords()" v-show="this.record.type_search != ''"
							title="Buscar registros">
						<i class="fa fa-search"></i>
					</button>
				</div>
			</div>
			<hr>
			<v-client-table :columns="columns" :data="records" :options="table_options">
                <div slot="payroll_staff" slot-scope="props">
                    <span>
                        {{
                            props.row.payroll_staff
                                ? props.row.payroll_staff.first_name + ' ' + props.row.payroll_staff.last_name
                                : 'No definido'
                        }}
                    </span>
                </div>
				<div slot="id" slot-scope="props" class="text-center">
					<div class="d-inline-flex">
						<button @click="createReport()" class="btn btn-primary btn-xs btn-icon btn-action"
                                title="Generar reporte" data-toggle="tooltip" type="button">
							<i class="fa fa-file-pdf-o"></i>
						</button>
					</div>
				</div>
			</v-client-table>
		</div>
	</div>
    </section>
</template>

<script>
	export default {
		data() {
			return {
				record: {
					id: '',
					payroll_staff_id: '',
					type_search: '',
					date: '',
					start_date: '',
					end_date: '',
				},

				records: [],
				errors: [],
				columns: ['payroll_staff','id'],
				payroll_staffs: []
			}
		},
		created() {
			this.table_options.headings = {
				'payroll_staff': 'Trabajador',
				'date': 'Fecha de la Solicitud',
				'id': 'Acción'
			};

			this.table_options.sortable = ['payroll_staff', 'date'];
			this.table_options.filterable = ['payroll_staff', 'date'];

			this.getPayrollStaffs();
		},
		mounted() {
			this.switchHandler('type_search');
		},

		methods: {
			reset() {
				this.record = {
					id: '',
					payroll_staff_id: '',
					type_search: '',
					date: '',
					start_date: '',
					end_date: '',
				};
			},

			createReport() {

				const vm = this;
				vm.loading = true;
				var fields = {};
				for (var index in this.records) {
					fields[index] = this.records[index];
				}


				axios.post('/payroll/reports/benefits/create' , fields).then(response => {
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
					vm.errors = [];

					if (typeof(error.response) !="undefined") {
						for (var index in error.response.data.errors) {
							if (error.response.data.errors[index]) {
								vm.errors.push(error.response.data.errors[index][0]);
							}
						}
					}
					vm.loading = false;
				});

			},
			filterRecords() {

				const vm = this;
				var url =  '/payroll/reports/search';

				var fields = {};
				if(vm.record.type_search == 'period'){
					url += '/period';
						fields = {
							start_date: vm.record.start_date,
							end_date: vm.record.end_date,
                            payroll_staff: vm.record.payroll_staff_id
						};
					}
				else if(vm.record.type_search == 'date'){
					url += '/date';


						fields = {
							date: vm.record.date,
							payroll_staff: vm.record.payroll_staff_id
						};
					}

				if(vm.record.type_search != ''){
					axios.post(url, fields).then(response => {
						vm.records = response.data.records;

					});
				}
			}
		},
    };
</script>
