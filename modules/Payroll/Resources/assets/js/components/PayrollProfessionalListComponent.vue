<template>
    <div>
        <v-client-table :columns="columns" :data="records" :options="table_options">
    		<div slot="id" slot-scope="props" class="text-center">
    			<button @click="showInfo(props.row.id)" v-if="route_show"
        				class="btn btn-info btn-xs btn-icon btn-action btn-tooltip"
        				title="Ver registro" data-toggle="tooltip" data-placement="bottom" type="button">
        			<i class="fa fa-eye"></i>
        		</button>
    			<button @click="editForm(props.row.id)" v-if="!props.row.assigned"
        				class="btn btn-warning btn-xs btn-icon btn-action btn-tooltip"
        				title="Modificar registro" data-toggle="tooltip" data-placement="bottom" type="button">
        			<i class="fa fa-edit"></i>
        		</button>
        		<button @click="deleteRecord(props.index, '')"
    					class="btn btn-danger btn-xs btn-icon btn-action btn-tooltip"
    					title="Eliminar registro" data-toggle="tooltip" data-placement="bottom"
    					type="button">
    				<i class="fa fa-trash-o"></i>
    			</button>
    		</div>
            <div slot="professions" slot-scope="props" class="text-center">
                <span v-for="profession in props.row.professions">
                    <div>
                        {{ profession.name }}
                    </div>
                </span>
            </div>
            <div slot="is_student" slot-scope="props" class="text-center">
                <span v-if="props.row.is_student">SI</span>
                <span v-else>NO</span>
            </div>
    	</v-client-table>
        <div class="modal fade" tabindex="-1" role="dialog" id="show_professional">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h6>
                            <i class="icofont icofont-read-book ico-2x"></i>
                            Información Detallada de Datos Profesionales
                        </h6>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Trabajador</label>
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="payroll_staff">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Grado de Instrucción</label>
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="payroll_instruction_degree">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Profesiones</label>
                                    <v-multiselect :options="(record.professions) ? record.professions : []" track_by="name"
                                        :hide_selected="false" :selected="(record.professions) ? record.professions : []">
                                    </v-multiselect>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Nombre de la Especialización, Maestría o Doctorado</label>
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="instruction_degree_name">
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>¿Es Estudiante?</label>
                                    <div class="col-12 bootstrap-switch-mini">
                                        <input id="is_student" class="form-control bootstrap-switch"
                                            data-on-label="SI" data-off-label="NO" type="checkbox">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tipo de Estudio</label>
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="payroll_study_type">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Nombre del Programa de Estudio</label>
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="study_program_name">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Horario de Clase</label>
                                    <div v-for="(document, index) in payroll_class_schedule.documents">
    									<a :href="`/${document.url}`" target="_blank">Documento</a>
    								</div>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-md-3">
                                <h6 class="card-title">
                                    Detalles de Idioma
                                </h6>
                            </div>
                        </div>
                        <div class="row" v-for="(payroll_language, index) in record.payroll_languages">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Idioma</label>
                                    <select2 :options="payroll_languages"
    									v-model="payroll_language.id">
    								</select2>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Dominio del Idioma</label>
                                    <select2 :options="payroll_language_levels"
    									v-model="payroll_language.pivot.payroll_language_level_id">
    								</select2>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-3">
                                <h6 class="card-title">
                                    Capacitación y Reconocimientos
                                </h6>
                            </div>
                        </div>
                        <div class="row" v-for="(payroll_cou_ack_file, index) in payroll_cou_ack_files">
                            <div class="col-3">
    							<div class="form-group is-required">
    								<label>Nombre del Curso:</label>
    								<input type="text" class="form-control input-sm"
    									disabled="true" v-model="payroll_cou_ack_file.course_name"/>
    							</div>
    						</div>
                            <div class="col-2">
                                <div class="form-group">
                                    <label>Curso</label>
                                    <div>
                                        <a :href="`/${payroll_cou_ack_file.course_file_url}`" target="_blank">Documento</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
    							<div class="form-group is-required">
    								<label>Nombre del Reconocimiento:</label>
    								<input type="text" class="form-control input-sm"
    									disabled="true" v-model="payroll_cou_ack_file.ack_name"/>
    							</div>
    						</div>
                            <div class="col-2">
                                <div class="form-group">
                                    <label>Reconocimiento</label>
                                    <div>
                                        <a :href="`/${payroll_cou_ack_file.ack_file_url}`" target="_blank">Documento</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
			return {
				records: [],
                record: [],
				columns: ['payroll_staff.first_name', 'payroll_instruction_degree.name', 'professions', 'is_student', 'id'],
                payroll_class_schedule: '',
                payroll_cou_ack_files: [],
			}
		},

        created() {
			this.table_options.headings = {
                'payroll_staff.first_name': 'Trabajador',
				'payroll_instruction_degree.name': 'Grado de Instrucción',
				'professions': 'Profesión',
				'is_student': '¿Es Estudiante?',
				'id': 'Acción'
			};
            this.table_options.sortable = ['payroll_staff.first_name', 'payroll_instruction_degree.name'];
			this.table_options.filterable = ['payroll_staff.first_name', 'payroll_instruction_degree.name'];
            this.getPayrollLanguages();
			this.getPayrollLanguageLevels();
		},

		mounted() {
            const vm = this;
			vm.initRecords(vm.route_list, '');
            $('#show_professional').on('hidden.bs.modal', function (e) {
                vm.payroll_cou_ack_files = [];
            });
		},

        methods: {
            reset() {

            },

            showInfo(id) {
                const vm = this;
                axios.get(`/payroll/professionals/${id}`).then(response => {
					vm.record = response.data.record;
                    $('#payroll_staff').val(vm.record.payroll_staff.first_name + ' ' + vm.record.payroll_staff.last_name);
                    $('#payroll_instruction_degree').val(vm.record.payroll_instruction_degree.name);
                    $('#instruction_degree_name').val(vm.record.instruction_degree_name);
                    (vm.record.is_student) ? $('#is_student').bootstrapSwitch('state', true) : $('#is_student').bootstrapSwitch('state', false);
                    $('#payroll_study_type').val( (vm.record.payroll_study_type) ? vm.record.payroll_study_type.name : ' ' );
                    $('#study_program_name').val(vm.record.study_program_name);
                    vm.payroll_class_schedule = (response.data.record.payroll_class_schedule) ? response.data.record.payroll_class_schedule : {};
                    for (const a in response.data.record.payroll_course.payroll_course_files) {
                        var payroll_course_file = response.data.record.payroll_course.payroll_course_files[a];
                        var payroll_ack_file = response.data.record.payroll_acknowledgment.payroll_acknowledgment_files[a];
                        vm.payroll_cou_ack_files.push({
                            course_name: payroll_course_file.name,
                            course_file_url: (payroll_course_file.image) ? payroll_course_file.image.url : payroll_course_file.documents[0].url,
                            ack_name: payroll_ack_file.name,
                            ack_file_url: (payroll_ack_file.image) ? payroll_ack_file.image.url : payroll_ack_file.documents[0].url,
                        });
                    }
				});
                $('#show_professional').modal('show');
            }
        }
    };
</script>
