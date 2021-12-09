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
					</div>

					<hr>
					<h6 class="card-title">
						Estudios Universitarios <i class="fa fa-plus-circle cursor-pointer" @click="addPayrollStudies"></i>
					</h6>
					<div class="row" v-for="(payroll_study, index) in record.payroll_studies">
                        <div class="col-3">
							<div class="form-group is-required">
								<label>Nombre de la Universidad:</label>
								<input type="text" class="form-control input-sm"
									v-model="payroll_study.university_name"/>
							</div>
                        </div>
						<div class="col-2">
							<div class="form-group is-required">
								<label>Anño de Graduación:</label>
								<input type="text" class="form-control input-sm"
									v-model="payroll_study.graduation_year"/>
							</div>
						</div>
						<div class="col-3">
							<div class="form-group is-required">
								<label>Tipo de Estudio:</label>
								<select2 :options="payroll_study_types"
									v-model="payroll_study.payroll_study_type_id">
								</select2>
							</div>
						</div>
						<div class="col-3">
							<div class="form-group is-required">
								<label>Profesión:</label>
								<select2 :options="professions" v-model="payroll_study.profession_id">
								</select2>
							</div>
						</div>
						<div class="col-1">
							<div class="form-group">
								<br>
								<button class="btn btn-sm btn-danger btn-action" type="button"
									@click="removeRow(index, record.payroll_studies)"
									title="Eliminar este dato" data-toggle="tooltip" data-placement="right">
									<i class="fa fa-minus-circle"></i>
								</button>
							</div>
						</div>
					</div>

					<div class="row">
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
								<label for="class_schedules">
									Horario de Clase:
	                            </label>
								<div v-for="(document, index) in payroll_class_schedule.documents">
									<a :href="`/${document.url}`" target="_blank">Documento</a>
									<button class="btn btn-sm btn-danger btn-action" type="button"
	                                        @click="deleteDocument(index, payroll_class_schedule.documents)"
	                                        title="Eliminar este dato" data-toggle="tooltip">
	                                    <i class="fa fa-minus-circle"></i>
	                                </button>
								</div>
								<input id="class_schedules" name="class_schedules" type="file"
									accept=".odt, .pdf" @change="processFiles($event)" multiple>
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
					<h6 class="card-title">
						Capacitación y Reconocimientos <i class="fa fa-plus-circle cursor-pointer" @click="addPayrollCouAckFiles"></i>
					</h6>
					<!--Formulario de registros nuevos-->
					<div class="row" v-for="(payroll_cou_ack_file, index) in record.payroll_cou_ack_files">
						<div class="col-3">
							<div class="form-group is-required">
								<label>Nombre del Curso:</label>
								<input type="text" class="form-control input-sm"
									v-model="payroll_cou_ack_file.course_name"/>
							</div>
						</div>
						<div class="col-2">
							<div class="form-group">
								<label>Curso:</label>
								<div v-show="payroll_cou_ack_file.course_file_url">
									<a :href="`/${payroll_cou_ack_file.course_file_url}`" target="_blank">Documento</a>
								</div>
								<input :id="'course_'+index" type="file"
									accept=".png, .jpg, .pdf, .odt" @change="processFile($event, index)">
							</div>
						</div>
						<div class="col-3">
							<div class="form-group is-required">
								<label>Nombre del Reconocimiento:</label>
								<input type="text" class="form-control input-sm"
									v-model="payroll_cou_ack_file.ack_name"/>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label>Reconocimiento:</label>
								<div v-show="payroll_cou_ack_file.ack_file_url">
									<a :href="`/${payroll_cou_ack_file.ack_file_url}`" target="_blank">Documento</a>
								</div>
								<input :id="'acknowledgment_'+index" type="file"
									accept=".png, .jpg, .pdf, .odt" @change="processFile($event, index)">
							</div>
						</div>
						<div class="col-1">
							<div class="form-group">
								<br>
								<button class="btn btn-sm btn-danger btn-action" type="button"
									@click="removeRow(index, record.payroll_cou_ack_files)"
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
					class_schedule_ids: [],
					professions: [],
					payroll_languages: [],
					payroll_cou_ack_files: [],
					payroll_studies:[],
				},
				errors: [],
				payroll_staffs: [],
				payroll_instruction_degrees: [],
				professions: [],
				json_professions: [],
				payroll_study_types: [],
				payroll_languages: [],
				payroll_language_levels: [],
				payroll_class_schedule: '',
				payroll_cou_ack_files: [],
			}
		},
		methods: {

			getProfessional() {
				const vm = this;
				axios.get(`/payroll/professionals/${vm.payroll_professional_id}`).then(response => {
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
					for (const a in response.data.record.payroll_languages) {
						vm.record.payroll_languages.push({
							payroll_lang_id: response.data.record.payroll_languages[a].id,
							payroll_language_level_id: response.data.record.payroll_languages[a].pivot.payroll_language_level_id,
						});
					}
					vm.payroll_class_schedule = (response.data.record.payroll_class_schedule) ? response.data.record.payroll_class_schedule : {};
					for (const a in response.data.record.payroll_course.payroll_course_files) {
						var payroll_course_file = response.data.record.payroll_course.payroll_course_files[a];
                        var payroll_acknowledgment_file = response.data.record.payroll_acknowledgment.payroll_acknowledgment_files[a];
                        this.record.payroll_cou_ack_files.push({
                            course_name: payroll_course_file.name,
							course: {
								id: (payroll_course_file.image) ? payroll_course_file.image.id : payroll_course_file.documents[0].id,
								file_type: (payroll_course_file.image) ? 'img' : 'doc',
							},
							course_file_url: (payroll_course_file.image) ? payroll_course_file.image.url : payroll_course_file.documents[0].url,
                            ack_name: payroll_acknowledgment_file.name,
							ack: {
								id: (payroll_acknowledgment_file.image) ? payroll_acknowledgment_file.image.id : payroll_acknowledgment_file.documents[0].id,
								file_type: (payroll_acknowledgment_file.image) ? 'img' : 'doc',
							},
							ack_file_url: (payroll_acknowledgment_file.image) ? payroll_acknowledgment_file.image.url : payroll_acknowledgment_file.documents[0].url,
                        });
                    }
					vm.record.payroll_studies = response.data.record.payroll_studies;
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
					class_schedule_ids: [],
					professions: [],
					payroll_languages: [],
					payroll_cou_ack_files: [],
					payroll_studies: [],
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

			/**
			 * Agrega una nueva fila para el registro de cursos y reconocimientos
			 *
			 * @author William Páez <wpaez@cenditel.gob.ve>
			 */
			addPayrollCouAckFiles() {
				this.record.payroll_cou_ack_files.push({
					course_name: '',
					course: {
						id: '',
						file_type: '',
					},
					course_file_url: '',
					ack_name: '',
					ack: {
						id: '',
						file_type: '',
					},
					ack_file_url: '',
				});
			},

			/**
			 * Agrega una nueva Fila para el registro de estudios
			 *
			 * @author William Páez <wpaez@cenditel.gob.ve>
			 */
			addPayrollStudies() {
				this.record.payroll_studies.push({
					university_name: '',
					graduation_year: '',
					payroll_study_type_id: '',
					profession_id: '',
				});
			},

			/**
			 * Guarda multiples archivos y guarda los id en la variable correspondiente
			 * del objeto record
			 *
			 * @author William Páez <wpaez@cenditel.gob.ve>
			 */
			processFiles(event) {
                const vm = this;
                var inputFiles = document.querySelector(`#${event.currentTarget.id}`);
				for (var x = 0; x < inputFiles.files.length; x++) {
    				formData.append(`documents[${x}]`, inputFiles.files[x]);
				}
                axios.post('upload-document', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(response => {
					vm.record.class_schedule_ids = response.data.document_ids;
                    vm.showMessage(
	                    'custom', 'Éxito', 'success', 'screen-ok',
	                    'Documento cargado de manera existosa.'
	                );
                }).catch(error => {
                    vm.errors = [];
                    if (typeof(error.response) != "undefined") {
                        for (var index in error.response.data.errors) {
                            if (error.response.data.errors[index]) {
                                vm.errors.push(error.response.data.errors[index][0]);
                            }
                        }
                    }
                });
			},

			/**
			 * Guarda un archivo y guarda el id en la variable correspondiente del
			 * objeto record
			 *
			 * @author William Páez <wpaez@cenditel.gob.ve>
			 */
			processFile(event, index) {
				const vm = this;
				var inputFile = document.querySelector(`#${event.currentTarget.id}`);
				if( inputFile.files[0].type.match('image/png') || inputFile.files[0].type.match('image/jpeg') || inputFile.files[0].type.match('image/jpg') ) {
					formData.append("image", inputFile.files[0]);
					axios.post('upload-image', formData, {
	                    headers: {
	                        'Content-Type': 'multipart/form-data'
	                    }
	                }).then(response => {
						if( inputFile.id.match(`course_${index}`) ) {
							vm.record.payroll_cou_ack_files[index].course.id = response.data.image_id;
							vm.record.payroll_cou_ack_files[index].course.file_type = 'img';
						}
						else {
							vm.record.payroll_cou_ack_files[index].ack.id = response.data.image_id;
							vm.record.payroll_cou_ack_files[index].ack.file_type = 'img';
						}
	                    vm.showMessage(
		                    'custom', 'Éxito', 'success', 'screen-ok',
		                    'Documento cargado de manera existosa.'
		                );
	                }).catch(error => {
	                    vm.errors = [];
	                    if (typeof(error.response) != "undefined") {
	                        for (var index in error.response.data.errors) {
	                            if (error.response.data.errors[index]) {
	                                vm.errors.push(error.response.data.errors[index][0]);
	                            }
	                        }
	                    }
	                });
				}
				else {
					formData.append(`documents[${0}]`, inputFile.files[0]);
					axios.post('upload-document', formData, {
	                    headers: {
	                        'Content-Type': 'multipart/form-data'
	                    }
	                }).then(response => {
						if( inputFile.id.match(`course_${index}`) ) {
							vm.record.payroll_cou_ack_files[index].course.id = response.data.document_ids[0].id;
							vm.record.payroll_cou_ack_files[index].course.file_type = 'doc';
						}
						else {
							vm.record.payroll_cou_ack_files[index].ack.id = response.data.document_ids[0].id;
							vm.record.payroll_cou_ack_files[index].ack.file_type = 'doc';
						}
	                    vm.showMessage(
		                    'custom', 'Éxito', 'success', 'screen-ok',
		                    'Documento cargado de manera existosa.'
		                );
	                }).catch(error => {
	                    vm.errors = [];
	                    if (typeof(error.response) != "undefined") {
	                        for (var index in error.response.data.errors) {
	                            if (error.response.data.errors[index]) {
	                                vm.errors.push(error.response.data.errors[index][0]);
	                            }
	                        }
	                    }
	                });
				}
			},

			/**
			 * Elimina un documento
			 *
			 * @author William Páez <wpaez@cenditel.gob.ve>
			 */
			deleteDocument(index, documents) {
				axios.delete(`upload-document/${documents[index].id}`).then(response => {
					documents.splice(index, 1);
				});
			},

			/**
			 * Elimina una fila de capacitación y reconocimientos
			 *
			 * @author William Páez <wpaez@cenditel.gob.ve>
			 */
			deletePayrollCouAckFile() {

			},
		},
		created() {
			this.record.is_student = false;
			this.record.payroll_languages = [];
			this.record.professions = [];
			this.record.payroll_cou_ack_files = [];
			this.record.payroll_studies = [];
			this.getPayrollStaffs();
			this.getPayrollInstructionDegrees();
			this.getProfessions();
			this.getPayrollStudyTypes();
			this.getPayrollLanguages();
			this.getPayrollLanguageLevels();
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
