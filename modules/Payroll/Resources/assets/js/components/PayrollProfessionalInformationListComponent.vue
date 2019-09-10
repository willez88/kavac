<template>
    <div>
        <v-client-table :columns="columns" :data="records" :options="table_options">
    		<div slot="id" slot-scope="props" class="text-center">
    			<button @click="show_info(props.row.id)" v-if="route_show"
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
        <div class="modal fade" tabindex="-1" role="dialog" id="show_professional_information">
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
                                    <input type="text" data-toggle="tooltip" class="form-control"
                                        disabled="true" id="payroll_staff">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Grado de Instrucción</label>
                                    <input type="text" data-toggle="tooltip" class="form-control"
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
                                    <input type="text" data-toggle="tooltip" class="form-control"
                                        disabled="true" id="instruction_degree_name">
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>¿Es Estudiante?</label>
                                    <input id="is_student" class="form-control bootstrap-switch"
                                        data-on-label="SI" data-off-label="NO" type="checkbox">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tipo de Estudio</label>
                                    <input type="text" data-toggle="tooltip" class="form-control"
                                        disabled="true" id="payroll_study_type">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Nombre del Programa de Estudio</label>
                                    <input type="text" data-toggle="tooltip" class="form-control"
                                        disabled="true" id="study_program_name">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Horario de Clase</label>
                                    <textarea class="form-control" disabled="true"
                                        id="class_schedule">
                                    </textarea>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Idioma</label>
                                    <input type="text" data-toggle="tooltip" class="form-control"
                                        disabled="true" id="payroll_language">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Dominio del Idioma</label>
                                    <input type="text" data-toggle="tooltip" class="form-control"
                                        disabled="true" id="payroll_language_level">
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
		},

		mounted() {
			this.initRecords(this.route_list, '');
		},

        methods: {
            reset() {

            },

            show_info(id) {
                axios.get('/payroll/professional-informations/' + id).then(response => {
					this.record = response.data.record;
                    $('#payroll_staff').val(this.record.payroll_staff.first_name + ' ' + this.record.payroll_staff.last_name);
                    $('#payroll_instruction_degree').val(this.record.payroll_instruction_degree.name);
                    $('#instruction_degree_name').val(this.record.instruction_degree_name);
                    (this.record.is_student) ? $('#is_student').bootstrapSwitch('state', true) : $('#is_student').bootstrapSwitch('state', false);
                    $('#payroll_study_type').val( (this.record.payroll_study_type) ? this.record.payroll_study_type.name : ' ' );
                    $('#study_program_name').val(this.record.study_program_name);
                    $('#class_schedule').val(this.record.class_schedule);
                    $('#payroll_language').val(this.record.payroll_language.name);
                    $('#payroll_language_level').val(this.record.payroll_language_level.name);
				});
                $('#show_professional_information').modal('show');
            }
        }
    };
</script>
