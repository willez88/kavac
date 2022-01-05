<template>
	<section id="PayrollReportVacationEnjoymentSummariesForm">
		<div class="card-body">
			<div class="alert alert-danger" v-if="errors.length > 0">
				<ul>
					<li v-for="error in errors" :key="error">{{ error }}</li>
				</ul>
			</div>

			<div class="row">
				<div class="col-md-12">
					<strong>Filtros</strong>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Períodos Vacacionales:</label>
						<select2
							:options="holidayPeriods"
							v-model="record.holiday_period"
						>
						</select2>
					</div>
				</div>
				<!-- trabajador -->
				<div class="col-md-6">
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
					<button
						type="button"
						class="btn btn-sm btn-info float-right"
						title="Buscar registro"
						data-toggle="tooltip"
						@click="searchRecords('vacation-enjoyment-summaries')"
					>
						<i class="fa fa-search"></i>
					</button>
				</div>
			</div>
			<hr />
			<div class="row">
				<div
					v-if="isPeriodSelected !== -1"
					class="col-md-4 with-border with-radius my-4"
				>
					<div class="form-group">
						<strong> Período Vacacional: </strong>
						<div class="row" style="margin: 1px 0">
							<span class="col-md-12">{{
								periodInfo.vacation_period_year
							}}</span>
						</div>
					</div>
					<div class="row">
						<div class="col-auto">
							<div class="form-group">
								<strong> Días por antigüedad: </strong>
								<div class="row" style="margin: 1px 0">
									<span class="col-md-12">{{
										periodInfo.days_old
									}}</span>
								</div>
							</div>
						</div>
						<div class="col-auto">
							<div class="form-group">
								<strong> Días Solicitados: </strong>
								<div class="row" style="margin: 1px 0">
									<span class="col-md-12">{{
										periodInfo.days_requested
									}}</span>
								</div>
							</div>
						</div>
						<div class="col-auto">
							<div class="form-group">
								<strong> Días Pendientes: </strong>
								<div class="row" style="margin: 1px 0">
									<span class="col-md-12">{{
										periodInfo.pending_days
									}}</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
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
				<div slot="holidayPeriods">
					<span
						class="d-block text-center"
						style="cursor: pointer"
						@click="setPeriodInfo(index)"
						v-for="(holidayPeriod, index) in payrollStaffPeriods"
						:key="index"
					>
						{{ holidayPeriod.vacation_period_year }}
					</span>
				</div>
				<div slot="id" slot-scope="props" class="text-center">
					<button
						@click.prevent="
							createReport(
								props.row.payroll_staff_id,
								'vacation-enjoyment-summaries'
							)
						"
						class="btn btn-primary btn-xs btn-icon btn-action"
						title="Generar reporte"
						data-toggle="tooltip"
						type="button"
					>
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
				id: '',
				current: '',
				holiday_period: '',
				payroll_staff_id: ''
			},

			errors: [],
			records: [],
			payrollStaffPeriods: [],
			holidayPeriods: [{ id: '', text: 'Todos' }],
			payroll_staffs: [],
			columns: [
				'payroll_staff',
				'payroll_staff_start_date',
				'year_antiquity',
				'holidayPeriods',
				'id'
			],
			isPeriodSelected: -1,
			periodInfo: {}
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
		createReport(id, current) {
			const vm = this;
			vm.loading = true;
			let fields = {
				id: id,
				current: current
			};
			axios.post(`${window.app_url}/payroll/reports/${current}/create`, fields).then(response => {
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
			console.log(this.records);
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
			axios.post(`${window.app_url}/payroll/reports/vue-list`, vm.record).then(response => {
				if (typeof response.data.records !== 'undefined') {
					vm.records = response.data.records;

					if (response.data.records.length) {
						vm.records = [vm.records[0]];

						vm.payrollStaffPeriods = response.data.records.map(
							({
								vacation_period_year,
								days_requested,
								days_old,
								pending_days
							}) => {
								return {
									vacation_period_year,
									days_requested,
									days_old,
									pending_days
								};
							}
						);
					}
				}
				vm.loading = false;
			}).catch(error => {
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
		},
		async getInstitutionStartYear() {
			const data = {
				current: 'vacation-enjoyment-summaries',
				need_institution_start_year: true
			};

			let { institutionStartYear } = (
				await axios.post(`${window.app_url}/payroll/reports/vue-list`, data)
			).data;

			const currentYear = new Date().getFullYear();

			let holidayPeriods = [{ id: '', text: 'Todos' }];

			while (institutionStartYear <= currentYear)
				holidayPeriods.push(institutionStartYear++);

			this.holidayPeriods = holidayPeriods.map((holidayPeriod, index) => {
				if (!index) return holidayPeriod;

				return {
					id: holidayPeriod,
					text: holidayPeriod
				};
			});
		},
		setPeriodInfo(index) {
			const vm = this;

			if (vm.isPeriodSelected !== index) {
				vm.periodInfo = vm.payrollStaffPeriods[index];
				vm.isPeriodSelected = index;
				return;
			}

			vm.isPeriodSelected = -1;
			vm.periodInfo = {};
		}
	},

	created() {
		const vm = this;
		vm.table_options.headings = {
			payroll_staff: 'Trabajador',
			payroll_staff_start_date: 'Fecha de ingreso',
			year_antiquity: 'Años en la institución',
			holidayPeriods: 'Período de disfrute de Vacaciones',
			id: 'Acción'
		};
		vm.table_options.sortable = [
			'payroll_staff',
			'payroll_staff_start_date',
			'year_antiquity'
		];
		vm.table_options.filterable = [
			'payroll_staff',
			'payroll_staff_start_date',
			'year_antiquity'
		];
	},
	async mounted() {
		const vm = this;
		vm.getPayrollStaffs();
		vm.getInstitutionStartYear();
		// vm.initRecords(vm.route_list, '');
	}
};
</script>
