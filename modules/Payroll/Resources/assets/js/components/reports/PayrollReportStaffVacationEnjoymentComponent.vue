<template>
	<section id="PayrollReportStaffVacationEnjoymentForm">
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
				<div class="col-md-4">
					<div class="form-group">
						<label>Desde:</label>
						<input
							id="start_date"
							type="date"
							name="start_date"
							class="form-control input-sm"
							v-model="record.start_date"
						/>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Hasta:</label>
						<input
							id="end_date"
							type="date"
							name="end_date"
							class="form-control input-sm"
							v-model="record.end_date"
						/>
					</div>
				</div>
				<!-- trabajador -->
				<div class="col-md-4">
					<div class="form-group">
						<label>Trabajador:</label>
						<select2
							:options="payroll_staffs"
							v-model="record.payroll_staff_id"
						>
						</select2>
					</div>
				</div>
				<!-- ./trabajador -->
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="d-flex justify-content-end">
						<button
							@click.prevent="
								createReport('staff-vacation-enjoyment')
							"
							class="btn btn-primary btn-xs btn-icon btn-action mr-3"
							title="Generar reporte"
							data-toggle="tooltip"
							type="button"
						>
							<i class="fa fa-file-pdf-o"></i>
						</button>
						<button
							type="button"
							class="btn btn-sm btn-info float-right"
							title="Buscar registro"
							data-toggle="tooltip"
							@click="searchRecords('staff-vacation-enjoyment')"
						>
							<i class="fa fa-search"></i>
						</button>
					</div>
				</div>
			</div>
			<hr />
			<v-client-table
				:columns="columns"
				:data="records"
				:options="table_options"
			>
				<div slot="payroll_staff" slot-scope="props">
					<span>
						{{
							props.row.payroll_staff
								? props.row.payroll_staff.first_name +
								  ' ' +
								  props.row.payroll_staff.last_name
								: 'No definido'
						}}
					</span>
				</div>
				<div slot="payroll_staff_start_date" slot-scope="props">
					<span>
						{{
							props.row.payroll_staff
								? props.row.payroll_staff.payroll_employment
									? props.row.payroll_staff.payroll_employment
											.start_date
									: 'No definido'
								: 'No definido'
						}}
					</span>
				</div>
				<div slot="year_antiquity" slot-scope="props">
					<span>
						{{
							getYearAntiquity(
								props.row.payroll_staff.payroll_employment
									.start_date
							)
						}}
					</span>
				</div>
				<div slot="vacation_period" slot-scope="props">
					<span>
						{{ props.row.start_date + ' - ' + props.row.end_date }}
					</span>
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
				id: '',
				current: '',
				start_date: '',
				end_date: '',
				payroll_staff_id: ''
			},

			errors: [],
			records: [],
			payroll_staffs: [],
			columns: [
				'payroll_staff',
				'payroll_staff_start_date',
				'year_antiquity',
				'vacation_period'
			]
		};
	},
	methods: {
		reset() {
			const vm = this;
			vm.record = {
				id: '',
				current: '',
				start_date: '',
				end_date: '',
				payroll_staff_id: ''
			};
		},
		createReport(current) {
			const vm = this;
			vm.loading = true;
			let fields = {
				current,
				payroll_staff_id: this.record.payroll_staff_id
			};
			axios
				.post(`/payroll/reports/${current}/create`, fields)
				.then(response => {
					if (typeof response.data.redirect !== 'undefined') {
						window.open(response.data.redirect, '_blank');
					} else {
						vm.reset();
					}
					vm.loading = false;
				})
				.catch(error => {
					if (typeof error.response != 'undefined') {
						console.log('error');
					}
					vm.loading = false;
				});
		},
		getYearAntiquity(start_date) {
			const vm = this;
			let payroll_staff_year = start_date.split('-')[0];
			let year_now = new Date().getFullYear();
			return year_now - parseInt(payroll_staff_year);
		},
		/**
		 * Método que permite realizar las busquedas y filtrado de los registros de la tabla
		 *
		 * @method    searchRecords
		 *
		 * @author    Henry Paredes <hparedes@cenditel.gob.ve> | <henryp2804@gmail.com>
		 */
		searchRecords(current) {
			const vm = this;
			vm.record.current = current;
			vm.loading = true;
			axios
				.post('/payroll/reports/vue-list', vm.record)
				.then(response => {
					if (typeof response.data.records !== 'undefined') {
						vm.records = response.data.records;
					}
					vm.loading = false;
				})
				.catch(error => {
					vm.errors = [];

					if (typeof error.response != 'undefined') {
						for (var index in error.response.data.errors) {
							if (error.response.data.errors[index]) {
								vm.errors.push(
									error.response.data.errors[index][0]
								);
							}
						}
					}
					vm.loading = false;
				});
		}
	},
	created() {
		const vm = this;
		vm.table_options.headings = {
			payroll_staff: 'Trabajador',
			payroll_staff_start_date: 'Fecha de ingreso',
			year_antiquity: 'Años en la institución',
			vacation_period: 'Período vacacional'
		};
		vm.table_options.sortable = [
			'payroll_staff',
			'payroll_staff_start_date',
			'year_antiquity',
			'vacation_period'
		];
		vm.table_options.filterable = [
			'payroll_staff',
			'payroll_staff_start_date',
			'year_antiquity',
			'vacation_period'
		];
	},
	async mounted() {
		const vm = this;
		vm.getPayrollStaffs();
		vm.initRecords(vm.route_list, '');
	}
};
</script>
