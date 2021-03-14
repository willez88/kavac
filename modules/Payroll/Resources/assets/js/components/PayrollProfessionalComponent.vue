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
								<v-multiselect :options="json_professions" v-if="payroll_professional_id" track_by="name"
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
                                    <div class="col-12 bootstrap-switch-mini">
    									<input id="is_student" name="is_student" type="checkbox"
                                               class="form-control bootstrap-switch" data-toggle="tooltip"
                                               data-on-label="SI" data-off-label="NO"
                                               title="Indique si el trabajador es estudiante o no"
                                               v-model="record.is_student" value="true"/>
                                    </div>
								</div>
							</div>
						</div>
					</div>

					<div class="row d-none" id="block_student">
						<div class="col-md-4">
							<div class="form-group">
								<label>Tipo de Estudio:</label>
								<select2 :options="payroll_study_types" v-model="record.payroll_study_type_id">
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
								<label for="class_schedule">
									Horario de Clase:
	                            </label>
								<input id="class_schedule" name="class_schedule" type="file"
									accept=".odt, .pdf" multiple>
							</div>
						</div>
					</div>

					<hr>
					<h6 class="card-title">
						Detalles de Idiomas <i class="fa fa-plus-circle cursor-pointer" @click="addPayrollLanguages"></i>
					</h6>
					<div class="row" v-for="(payroll_language, index) in record.payroll_languages">
                        <div class="col-3">
							<div class="form-group is-required">
								<label>Idioma:</label>
								<select2 :options="payroll_languages"
									v-model="payroll_language.payroll_lang_id">
								</select2>
							</div>
                        </div>
						<div class="col-3">
							<div class="form-group is-required">
								<label>Nivel de Idioma:</label>
								<select2 :options="payroll_language_levels"
									v-model="payroll_language.payroll_language_level_id">
								</select2>
							</div>
						</div>
						<div class="col-1">
							<div class="form-group">
								<br>
								<button class="btn btn-sm btn-danger btn-action" type="button"
									@click="removeRow(index, record.payroll_languages)"
									title="Eliminar este dato" data-toggle="tooltip" data-placement="right">
									<i class="fa fa-minus-circle"></i>
								</button>
							</div>
						</div>
					</div>
					<hr>

					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label for="course">
									Cursos:
	                            </label>
								<input id="course" name="course" type="file"
									accept=".png, .jpg, .pdf, .odt" multiple>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="acknowledgments">
									Reconocimientos:
	                            </label>
								<input id="acknowledgments" name="acknowledgments" type="file"
									accept=".png, .jpg, .pdf, .odt" @change="processFiles()" multiple>
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
	                <button type="button" @click="createRecord('payroll/professionals')"
	                	class="btn btn-success btn-icon btn-round">
	                	<i class="fa fa-save"></i>
		            </button>
		        </div>

			</div>
		</div>
	</div>
</template>
<script>
	var formData = new FormData();
	export default {
		props: {
			payroll_professional_id: Number,
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
					professions: [],
					payroll_languages: [],
				},
				errors: [],
				payroll_staffs: [],
				payroll_instruction_degrees: [],
				professions: [],
				json_professions: [],
				payroll_study_types: [],
				payroll_languages: [],
				payroll_language_levels: [],
			}
		},
		methods: {

			getProfessional() {
				const vm = this;
				axios.get('/payroll/professionals/' + vm.payroll_professional_id).then(response => {
					vm.record.id = response.data.record.id;
					vm.record.payroll_staff_id = response.data.record.payroll_staff_id;
					vm.record.payroll_instruction_degree_id = response.data.record.payroll_instruction_degree_id;
					vm.record.instruction_degree_name = response.data.record.instruction_degree_name;
					vm.record.is_student = response.data.record.is_student;
					vm.record.payroll_study_type_id = response.data.record.payroll_study_type_id;
					vm.record.study_program_name = response.data.record.study_program_name;
					vm.record.class_schedule = response.data.record.class_schedule;
					vm.record.professions = response.data.record.professions;
					vm.record.payroll_staff = response.data.record.payroll_staff;
					vm.record.payroll_study_type = response.data.record.payroll_study_type;
					vm.record.payroll_instruction_degree = response.data.record.payroll_instruction_degree;
					//vm.record.payroll_languages = response.data.record.payroll_languages;

					for (const a in response.data.record.payroll_languages) {
						vm.record.payroll_languages.push({
							payroll_lang_id: response.data.record.payroll_languages[a].id,
							payroll_language_level_id: response.data.record.payroll_languages[a].pivot.payroll_language_level_id,
						});
					}
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
					professions: [],
					payroll_languages: []
				};
			},

			/**
			 * Agrega una nueva Fila para el registro de idiomas
			 *
			 * @author William Páez <wpaez@cenditel.gob.ve>
			 */
			addPayrollLanguages() {
				this.record.payroll_languages.push({
					payroll_lang_id: '',
					payroll_language_level_id: '',
				});
			},

			processFiles() {
                const vm = this;
                var inputFile = document.querySelector('#acknowledgments');
				var tam = inputFile.files.length;
				console.log(tam);
				for (var x = 0; x < tam; x++) {
    				formData.append('acknowledgments[]', document.getElementById('acknowledgments').files[x]);
				}
                /*axios.post('upload-image.store', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(response => {
                	console.log(response.data.image_id);
                	console.log(response.data.image_url);
                    vm.showMessage(
	                    'custom', 'Éxito', 'success', 'screen-ok',
	                    'Documento cargado de manera existosa.'
	                );
                }).catch(error => {
                    vm.errors = [];
                    if (typeof(error.response) !="undefined") {
                        for (var index in error.response.data.errors) {
                            if (error.response.data.errors[index]) {
                                vm.errors.push(error.response.data.errors[index][0]);
                            }
                        }
                    }
                });*/
			}
		},
		created() {
			this.record.payroll_languages = [];
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
			if(this.payroll_professional_id) {
				this.getProfessional();
				this.getJsonProfessions();
			}
			this.switchHandler('is_student');
		},
		watch: {
			record: {
				deep: true,
				handler: function() {
					const vm = this;
					if (vm.record.is_student) {
						$('#is_student').bootstrapSwitch('state', true, true);
						$('#block_student').removeClass('d-none');
					}
					else {
						$('#block_student').addClass('d-none');
					}
				}
			}
		}
	};
</script>
