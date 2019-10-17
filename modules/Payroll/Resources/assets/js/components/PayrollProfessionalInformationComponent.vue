<template>
	<div class="row">
		<div class="col-12">
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
									v-model="record.payroll_instruction_degree_id">
								</select2>
							</div>
						</div>
						<div class="col-md-4" v-show="record.payroll_instruction_degree_id == 4 || record.payroll_instruction_degree_id == 5">
							<div class="form-group is-required">
								<label>Profesiones:</label>
								<v-multiselect :options="professions" v-if="payroll_professional_information_id" track_by="name"
									:hide_selected="false" :selected="record.professions" v-model="record.professions">
								</v-multiselect>
								<v-multiselect :options="professions" v-else track_by="text"
									:hide_selected="false" :selected="record.professions" v-model="record.professions">
								</v-multiselect>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-4" v-show="record.payroll_instruction_degree_id == 6 || record.payroll_instruction_degree_id == 7 ||
							record.payroll_instruction_degree_id == 8">
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
									<input id="is_student" type="checkbox" class="form-control bootstrap-switch"
										data-toggle="tooltip" data-on-label="SI" data-off-label="NO"
										title="Indique si el trabajador es estudiante o no"
										v-model="record.is_student" value="true"/>
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

					<hr>
					<h6 class="card-title">
						Detalles de Idiomas <i class="fa fa-plus-circle cursor-pointer" @click="addLanguage"></i>
					</h6>
					<div class="row" v-for="(language, index) in record.languages">
                        <div class="col-3">
							<div class="form-group is-required">
								<label>Idioma:</label>
								<select2 :options="payroll_languages"
									v-model="language.language_id">
								</select2>
							</div>
                        </div>
						<div class="col-3">
							<div class="form-group is-required">
								<label>Nivel de Idioma:</label>
								<select2 :options="payroll_language_levels"
									v-model="language.language_level_id">
								</select2>
							</div>
						</div>
						<div class="col-1">
							<div class="form-group">
								<br>
								<button class="btn btn-sm btn-danger btn-action" type="button"
									@click="removeRow(index, record.languages)"
									title="Eliminar este dato" data-toggle="tooltip" data-placement="right">
									<i class="fa fa-minus-circle"></i>
								</button>
							</div>
						</div>
					</div>

				</div>

				<div class="card-footer pull-right">
					<button class="btn btn-default btn-icon btn-round" data-toggle="tooltip" type="button"
						title="Borrar datos del formulario" @click="reset"><i class="fa fa-eraser"></i>
					</button>
					<button type="button" class="btn btn-warning btn-icon btn-round" data-toggle="tooltip"
							title="Cancelar y regresar" @click="redirect_back(route_list)">
						<i class="fa fa-ban"></i>
					</button>
	                <button type="button" @click="createRecord('payroll/professional-informations')"
	                	class="btn btn-success btn-icon btn-round">
	                	<i class="fa fa-save"></i>
		            </button>
		        </div>

			</div>
		</div>
	</div>
</template>
<script>
	export default {
		props: {
			payroll_professional_information_id: Number,
		},
		data() {
			return {
				record: {
					id: '',
					payroll_staff_id: '',
					payroll_instruction_degree_id: '',
					instruction_degree_name: '',
					is_student: '',
					payroll_study_type_id: '',
					study_program_name: '',
					class_schedule: '',
					payroll_language_id: '',
					payroll_language_level_id: '',
					professions: '',
					languages: [],
					payroll_languages: [],
					payroll_language_levels: []
				},
				errors: [],
				payroll_staffs: [],
				payroll_instruction_degrees: [],
				professions: [],
				payroll_study_types: [],
				payroll_languages: [],
				payroll_language_levels: [],
				var_test: []
			}
		},
		methods: {

			getProfessionalInformation() {
				axios.get('/payroll/professional-informations/' + this.payroll_professional_information_id).then(response => {
					this.record = response.data.record;
				});
			},

			reset() {
				this.record = {
					id: '',
					payroll_staff_id: '',
					payroll_instruction_degree_id: '',
					instruction_degree_name: '',
					is_student: false,
					payroll_study_type_id: '',
					study_program_name: '',
					class_schedule: '',
					payroll_language_id: '',
					payroll_language_level_id: ''
				};
			},

			/**
			 * Agrega una nueva columna para el registro de detalles de idiomas
			 *
			 * @author William Páez <wpaez@cenditel.gob.ve>
			 */
			addLanguage() {
				this.record.languages.push({
					language_id: '',
					language_level_id: '',
				});
			},
		},
		created() {
			this.record.languages = [];
			this.record.professions = [];
			this.getPayrollStaffs();
			this.getPayrollInstructionDegrees();
			this.getProfessions();
			this.getPayrollStudyTypes();
			this.getPayrollLanguages();
			this.getPayrollLanguageLevels();
			this.record.is_student = false;
		},
		mounted() {
			if(this.payroll_professional_information_id) {
				this.getProfessionalInformation();
			}
			//Falta revisión en esta rutina, a veces sale el error de recursión
			//No actualiza el campo switch al primer momento de cargar el componente
			const vm = this;
			vm.switchHandler('is_student');
			$('#is_student').on('switchChange.bootstrapSwitch', function(e) {
				e.target.id;
				if (vm.record.is_student) {
					vm.record.is_student = false;
					$('#is_student').bootstrapSwitch('state', false)
					$('#block_student').addClass('d-none');
					//alert('Falso');
				}
				else {
					vm.record.is_student = true;
					$('#is_student').bootstrapSwitch('state', true)
					$('#block_student').removeClass('d-none');
					//alert('Verdadero');
				}
			});
		}
	};
</script>
