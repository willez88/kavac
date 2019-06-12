<template>
	<div class="row">
		<div class="col-7">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Registrar los Datos Profesionales</h6>
					<div class="card-btns">
						<a href="#" class="btn btn-sm btn-primary btn-custom" @click="redirect_back(route_list)"
						   title="Ir atrás" data-toggle="tooltip">
							<i class="fa fa-reply"></i>
						</a>
						<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar"
						   data-toggle="tooltip">
							<i class="now-ui-icons arrows-1_minimal-up"></i>
						</a>
					</div>
                </div>

				<div class="card-body">
					<div class="alert alert-danger" v-if="errors.length > 0">
						<ul>
							<li v-for="error in errors">{{ error }}</li>
						</ul>
					</div>

					<div class="row">
						<div class="col-md-4">
							<div class="form-group is-required">
								<label>Trabajador:</label>
								<select2 :options="payroll_staffs"
									v-model="record.payroll_staff_id">
								</select2>
								<input type="hidden" v-model="record.id">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group is-required">
								<label>Grado de Instrucción:</label>
								<select2 :options="payroll_instruction_degrees"
									v-model="record.payroll_instruction_degree_id" @input="showHide">
								</select2>
							</div>
						</div>
						<div class="col-md-4" id="block_profession">
							<div class="form-group is-required">
								<label>Profesión:</label>
								<select2 :options="professions"
									v-model="record.profession_id">
								</select2>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-4 d-none" id="block_idn">
							<div class="form-group">
								<label>Nombre de Especialización, Maestría o Doctorado:</label>
								<input type="text" class="form-control input-sm"
									v-model="record.instruction_degree_name"/>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>¿Es Estudiante?</label>
								<div class="col-md-12">
									<input id="is_student" type="checkbox" class="form-control bootstrap-switch hola"
										data-toggle="tooltip" data-on-label="SI" data-off-label="NO"
										title="Indique si el trabajador es estudiante o no"
										v-model="record.is_student" value="false"/>
								</div>
							</div>
						</div>
					</div>

					<div class="row d-none" id="block_student">
						<div class="col-md-4">
							<div class="form-group">
								<label>Tipo de Estudio:</label>
								<select2 :options="payroll_study_types"
									v-model="record.payroll_study_type_id">
								</select2>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Nombre del Programa de Estudio:</label>
								<input type="text" class="form-control input-sm"
									v-model="record.study_program_name"/>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Horario de Clase:</label>
								<textarea class="form-control"
									v-model="record.class_schedule">
								</textarea>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-4">
							<div class="form-group is-required">
								<label>Idioma:</label>
								<select2 :options="payroll_languages"
									v-model="record.payroll_language_id">
								</select2>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group is-required">
								<label>Nivel de Idioma:</label>
								<select2 :options="payroll_language_levels"
									v-model="record.payroll_language_level_id">
								</select2>
							</div>
						</div>
					</div>

					<hr>
	                <v-client-table :columns="columns" :data="records" :options="table_options">
	                	<div slot="id" slot-scope="props" class="text-center">
	                		<button @click="initUpdate(props.index, $event)"
		                		class="btn btn-warning btn-xs btn-icon btn-action"
		                		title="Modificar registro" data-toggle="tooltip" type="button">
		                		<i class="fa fa-edit"></i>
		                	</button>
		                	<button @click="deleteRecord(props.index, '/payroll/professional-informations')"
								class="btn btn-danger btn-xs btn-icon btn-action"
								title="Eliminar registro" data-toggle="tooltip"
								type="button">
								<i class="fa fa-trash-o"></i>
							</button>
	                	</div>
	                </v-client-table>

				</div>

				<div class="card-footer pull-right">
					<button class="btn btn-default btn-icon btn-round" data-toggle="tooltip" type="button"
						title="Borrar datos del formulario" @click="reset"><i class="fa fa-eraser"></i>
					</button>
	                <button type="button" @click="createRecord('payroll/professional-informations')"
	                	class="btn btn-success btn-icon btn-round">
	                	<i class="fa fa-save"></i>
		            </button>
		        </div>

			</div>
		</div>

		<div class="col-5">
			<div class="card">
				<div class="card-body">
					<pre>
						{{ $data }}
					</pre>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
	export default {
		data() {
			return {
				record: {
					id: '',
					payroll_staff_id: '',
					payroll_instruction_degree_id: '',
					profession_id: '',
					instruction_degree_name: '',
					is_student: '',
					payroll_study_type_id: '',
					study_program_name: '',
					class_schedule: '',
					payroll_language_id: '',
					payroll_language_level_id: ''
				},
				errors: [],
				records: [],
				payroll_staffs: [],
				payroll_instruction_degrees: [],
				professions: [],
				payroll_study_types: [],
				payroll_languages: [],
				payroll_language_levels: [],
				columns: ['payroll_staff.first_name', 'payroll_instruction_degree.name', 'profession.name', 'is_student', 'id'],
			}
		},
		methods: {
			getProfessionalInformations() {
				axios.get('professional-informations/vue-list').then(response => {
					this.records = response.data.records;
				});
			},

			getPayrollStaffs() {
				axios.get('socioeconomic-informations/staffs-list').then(response => {
					this.payroll_staffs = response.data;
				});
			},

			getPayrollInstructionDegrees() {
				axios.get('instruction-degrees/list').then(response => {
					this.payroll_instruction_degrees = response.data;
				});
			},

			getProfessions() {
				axios.get('professional-informations/professions-list').then(response => {
					this.professions = response.data;
				});
			},

			getPayrollStudyTypes() {
				axios.get('study-types/list').then(response => {
					this.payroll_study_types = response.data;
				});
			},

			getPayrollLanguages() {
				axios.get('languages/list').then(response => {
					this.payroll_languages = response.data;
				});
			},

			getPayrollLanguageLevels() {
				axios.get('language-levels/list').then(response => {
					this.payroll_language_levels = response.data;
				});
			},

			showHide() {
				if (this.record.payroll_instruction_degree_id == 6 || this.record.payroll_instruction_degree_id == 7 || this.record.payroll_instruction_degree_id == 8) {
					$('#block_idn').removeClass('d-none');
					$('#block_profession').addClass('d-none');
				}
				else if (this.record.payroll_instruction_degree_id == 1 || this.record.payroll_instruction_degree_id == 2 || this.record.payroll_instruction_degree_id == 3) {
					$('#block_idn').addClass('d-none');
					$('#block_profession').addClass('d-none');
				}
				else if (this.record.payroll_instruction_degree_id == 4 || this.record.payroll_instruction_degree_id == 5) {
					$('#block_idn').addClass('d-none');
					$('#block_profession').removeClass('d-none');
				}
			},

			reset() {
				this.record = {
					id: '',
					payroll_staff_id: '',
					payroll_instruction_degree_id: '',
					profession_id: '',
					instruction_degree_name: '',
					is_student: false,
					payroll_study_type_id: '',
					study_program_name: '',
					class_schedule: '',
					payroll_language_id: '',
					payroll_language_level_id: ''
				};
			},
		},
		created() {
			this.table_options.headings = {
				'payroll_staff.first_name': 'Trabajador',
				'payroll_instruction_degree.name': 'Grado de Instrucción',
				'profession.name': 'Profesión',
				'is_student': '¿Es Estudiante?',
				'id': 'Acción'
			};
			this.table_options.sortable = ['payroll_staff.first_name', 'payroll_instruction_degree.name', 'profession.name'];
			this.table_options.filterable = ['payroll_staff.first_name', 'payroll_instruction_degree.name', 'profession.name'];
			this.getProfessionalInformations();
			this.getPayrollStaffs();
			this.getPayrollInstructionDegrees();
			this.getProfessions();
			this.getPayrollStudyTypes();
			this.getPayrollLanguages();
			this.getPayrollLanguageLevels();
			this.record.is_student = false;
		},
		mounted() {
			this.switchHandler('is_student');
			const vm = this;
			$('.hola').on('switchChange.bootstrapSwitch', function(e) {
				e.target.id;
				if (vm.record.is_student) {
					vm.record.is_student = false;
					$('#block_student').addClass('d-none');
				}
				else {
					vm.record.is_student = true;
					$('#block_student').removeClass('d-none');
				}
			});
		}
	};
</script>
