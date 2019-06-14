<template>
    <v-client-table :columns="columns" :data="records" :options="table_options">
		<div slot="id" slot-scope="props" class="text-center">
			<button @click="prueba(props.row.id)" v-if="route_show"
    				class="btn btn-info btn-xs btn-icon btn-action btn-tooltip"
    				title="Ver registro" data-toggle="tooltip" data-placement="bottom" type="button">
    			<i class="fa fa-eye"></i>
    		</button>
            <div class="modal fade" tabindex="-1" role="dialog" id="show_professional_information">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
        					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
        						<span aria-hidden="true">×</span>
        					</button>
        					<h6>
        						<i class="icofont icofont-read-book ico-2x"></i>
        						Información de Datos Profesionales
        					</h6>
        				</div>
                        <div class="modal-body">
                            <div class="row">
        						<div class="col-md-4">
        							<div class="form-group">
        								<label>Trabajador</label>
        								<input type="text" data-toggle="tooltip" class="form-control" disabled="true" v-model="record.payroll_staff">
        							</div>
        						</div>
        						<div class="col-md-4">
        							<div class="form-group">
        								<label>Grado de Instrucción</label>
        				        		<input type="text" data-toggle="tooltip" class="form-control" disabled="true" v-model="record.payroll_instruction_degree">
        				            </div>
        				        </div>
                                <div class="col-md-4">
        							<div class="form-group">
        								<label>Profesión</label>
        				        		<input type="text" data-toggle="tooltip" class="form-control" disabled="true" v-model="record.profession">
        				            </div>
        				        </div>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="col-md-4">
        							<div class="form-group">
        								<label>¿Es Estudiante?</label>
                                        <input id="is_student" class="form-control bootstrap-switch" data-on-label="SI" data-off-label="NO" name="active" type="checkbox">
        				            </div>
        				        </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
        							<div class="form-group">
        								<label>Tipo de Estudio</label>
        				        		<input type="text" data-toggle="tooltip" class="form-control" disabled="true" v-model="record.payroll_study_type">
        				            </div>
        				        </div>
                                <div class="col-md-6">
        							<div class="form-group">
        								<label>Nombre del Programa de Estudio</label>
        				        		<input type="text" data-toggle="tooltip" class="form-control" disabled="true" v-model="record.study_program_name">
        				            </div>
        				        </div>
                                <div class="col-md-6">
        							<div class="form-group">
        								<label>Horario de Clase</label>
        				        		<textarea class="form-control" disabled="true" v-model="record.class_schedule">
                                        </textarea>
        				            </div>
        				        </div>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="col-md-6">
        							<div class="form-group">
        								<label>Idioma</label>
        				        		<input type="text" data-toggle="tooltip" class="form-control" disabled="true" v-model="record.payroll_language">
        				            </div>
        				        </div>
                                <div class="col-md-6">
        							<div class="form-group">
        								<label>Dominio del Idioma</label>
        				        		<input type="text" data-toggle="tooltip" class="form-control" disabled="true"v-model="record.payroll_language_level">
        				            </div>
        				        </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
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
	</v-client-table>
</template>
<script>
    export default {
        data() {
			return {
				records: [],
				columns: ['payroll_staff.first_name', 'payroll_instruction_degree.name', 'profession.name', 'is_student', 'id'],
			}
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
		},

		mounted() {
			this.initRecords(this.route_list, '');
		},

        methods: {
            reset() {

            },

            prueba(id) {
                axios.get('/payroll/professional-informations/' + id).then(response => {
					response.data.record;
                    (response.data.record.is_student) ? $('#is_student').bootstrapSwitch('state', true) : $('#is_student').bootstrapSwitch('state', false);
				});
                $('#show_professional_information').modal('show');
            }
        }
    };
</script>
