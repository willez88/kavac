<template>
	<div>
		<div class="card-body">
			<div class="row mb-3">
				<div class="col-2">
					<div class="form-group">
						<label for="" class="control-label"
							>Años de formulación</label
						>
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<select2
							v-model="params.year"
							:options="years"
						></select2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-6">
					<div class="form-group is-required mt-3">
						<label class="control-label">Desde</label
						><input
							v-model="params.start_date"
							class="form-control input-sm"
							type="date"
						/>
					</div>
				</div>
				<div class="col-6">
					<div class="form-group is-required mt-3">
						<label class="control-label">Hasta</label
						><input
							v-model="params.end_date"
							class="form-control input-sm"
							type="date"
						/>
					</div>
				</div>
			</div>
			<hr />
			<div class="row">
				<div class="col-6 mt-4">
					<label for="">
						<div class="col-12 bootstrap-switch-mini">
							<input
								v-model="isProject"
								type="radio"
								name="project"
								:value="1"
								id="project"
								class="form-control bootstrap-switch bootstrap-switch-mini sel_pry_acc"
								data-on-label="SI"
								data-off-label="NO"
								@change="change"
							/>
							Proyecto
						</div>
					</label>
					<div class="mt-4">
						<select2
							v-model="params.project_id"
							:options="projects"
							id="project_id"
							:disabled="isProject !== 1"
						></select2>
					</div>
				</div>
				<div class="col-6 mt-4">
					<label for="">
						<div class="col-12 bootstrap-switch-mini">
							<input
								v-model="isProject"
								type="radio"
								name="centralized_action"
								:value="0"
								class="form-control bootstrap-switch bootstrap-switch-mini sel_pry_acc"
								id="centralized_action"
								data-on-label="SI"
								data-off-label="NO"
								@change="change"
							/>
							Acción Centralizada
						</div>
					</label>
					<div class="mt-4">
						<select2
							v-model="params.centralized_action_id"
							:options="centralizedActions"
							id="centralized_action_id"
							:disabled="isProject !== 0"
						></select2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12 mt-4">
					<div class="form-group">
						<label for="" class="control-label"
							>Formulaciones</label
						>
					</div>
					<div class="mt-4">
						<select2
							v-model="params.formulation_id"
							:options="formulations"
							id="project_id"
							:disabled="isFormulationsDisabled || loading"
						></select2>
					</div>
				</div>
			</div>
			<div class="row mt-4">
				<div class="col-md-12">
					<div class="d-flex justify-content-end">
						<button
							class="btn btn-primary btn-xs btn-icon btn-action mr-3"
							title="Generar reporte"
							data-toggle="tooltip"
							type="button"
							@click="getPdf"
						>
							<i class="fa fa-file-pdf-o"></i>
						</button>
						<button
							type="button"
							class="btn btn-sm btn-info float-right"
							title="Buscar registro"
							data-toggle="tooltip"
							@click="getData"
						>
							<i class="fa fa-search"></i>
						</button>
					</div>
				</div>
			</div>
		</div>
		<v-client-table
			class="text-center"
			:columns="columns"
			:data="records"
			:options="table_options"
		>
		</v-client-table>
	</div>
</template>

<script>
export default {
	props: {
		url: {
			type: String,
			required: true
		},
		pdf: {
			type: String,
			required: true
		},
		formulationsUrl: {
			type: String,
			required: true
		},
		years: {
			type: Array,
			required: true
		}
	},
	data() {
		return {
			isProject: 1,
			projects: [],
			centralizedActions: [],
			formulations: [],
			params: {
				year: '',
				start_date: '',
				end_date: '',
				project_id: '',
				centralized_action_id: '',
				formulation_id: ''
			},
			records: [],
			columns: ['code', 'total_real_amount', 'percentage', 'total'],
			loading: false
		};
	},
	async created() {
		this.table_options.headings = {
			code: 'Código',
			total_real_amount: 'Monto',
			percentage: '% Asignado',
			total: 'Total'
		};
		this.table_options.sortable = ['code', 'amount', '% assigned', 'total'];
		this.table_options.filterable = [
			'code',
			'total_real_amount',
			'percentage',
			'total'
		];
		this.table_options.columnsClasses = {
			code: 'col-md-3',
			total_real_amount: 'col-md-3',
			percentage: 'col-md-3',
			total: 'col-md-3'
		};

		await this.getProjects();
		await this.getCentralizedActions();
		await this.getFormulations();
	},
	watch: {
		'params.project_id': async function(newValue, _) {
			if (newValue === '') {
				this.formulations = [];
				return;
			}

			this.loading = true;

			this.formulations = await this.getFormulations();

			this.loading = false;
		},

		'params.centralized_action_id': async function(newValue, _) {
			if (newValue === '') {
				this.formulations = [];
				return;
			}

			this.loading = true;

			this.formulations = await this.getFormulations();

			this.loading = false;
		}
	},
	computed: {
		isFormulationsDisabled() {
			return this.formulations.length === 0;
		}
	},
	methods: {
		async getProjects() {
			const { data } = await axios.get('/budget/get-projects');

			this.projects = data;
		},
		async getCentralizedActions() {
			const { data } = await axios.get('/budget/get-centralized-actions');

			this.centralizedActions = data;
		},
		async getFormulations() {
			const config = {
				params: {
					is_project: this.isProject,
					id: this.isProject
						? this.params.project_id
						: this.params.centralized_action_id
				}
			};

			const { data } = await axios.get(this.formulationsUrl, config);

			return data;
		},
		change() {
			if (this.isProject) this.params.centralized_action_id = '';
			else this.params.project_id = '';
		},
		async getData() {
			if (
				this.params.formulation_id == null ||
				this.params.formulation_id === ''
			)
				return;

			const config = {
				params: {
					start_date: this.params.start_date,
					end_date: this.params.end_date,
					formulation_id: this.params.formulation_id
				}
			};

			this.loading = true;

			const { data } = await axios.get(this.url, config);

			this.loading = false;
			this.records = data.data;
		},
		getPdf() {
			window.open(
				`${this.pdf}?formulation_id=${this.params.formulation_id}&start_date=${this.params.start_date}&end_date=${this.params.end_date}`
			);
		}
	}
};
</script>
