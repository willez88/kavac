<template>
    <v-client-table :columns="columns" :data="records" :options="table_options">
		<div slot="id" slot-scope="props" class="text-center">
			<button @click="showRecord(props.row.id)" v-if="route_show"
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
	</v-client-table>

    <div class="modal fade" tabindex="-1" role="dialog" id="show_professional_information">
		<div class="modal-dialog modal-lg">

			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
					<h6>
						<i class="icofont icofont-read-book ico-2x"></i>
						Datos Profesionales
					</h6>
				</div>

				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Código</label>
								<input type="text"
									data-toggle="tooltip"
									class="form-control"
									id="code"
									disabled="true">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Nombres</label>
				        		<input type="text"
									data-toggle="tooltip"
									class="form-control"
									id="first_name"
									disabled="true">
				            </div>
				        </div>

				        <div class="col-md-6">
							<div class="form-group">
								<label>Apellidos</label>
				        		<input type="text"
									data-toggle="tooltip"
									class="form-control"
									id="last_name"
									disabled="true">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Nacionalidad</label>
				        		<input type="text"
									data-toggle="tooltip"
									class="form-control"
									id="nationality"
									disabled="true">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Cédula de Identidad</label>
				        		<input type="text"
									data-toggle="tooltip"
									class="form-control"
									id="id_number"
									disabled="true">
							</div>
						</div>

				        <div class="col-md-6">
							<div class="form-group">
								<label>Pasaporte</label>
				        		<input type="text"
									data-toggle="tooltip"
									class="form-control"
									id="passport"
									disabled="true">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Correo Electrónico</label>
				        		<input type="text"
									data-toggle="tooltip"
									class="form-control"
									id="email"
									disabled="true">
							</div>
						</div>

				        <div class="col-md-6">
							<div class="form-group">
								<label>Fecha de Nacimiento</label>
				        		<input type="text"
									data-toggle="tooltip"
									class="form-control"
									id="birthdate"
									disabled="true">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Género</label>
								<input type="text"
									data-toggle="tooltip"
									class="form-control"
									id="gender"
									disabled="true">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Nombres y apellidos de la persona de contacto</label>
								<input type="text"
									data-toggle="tooltip"
									class="form-control"
									id="emergency_contact"
									disabled="true">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Teléfono de la persona de contacto</label>
								<input type="text"
									data-toggle="tooltip"
									class="form-control"
									id="emergency_phone"
									disabled="true">
							</div>
						</div>

				        <!--<div class="col-md-6">
							<div class="form-group">
								<label for="active">Activo</label>
								<input id="active" class="form-control bootstrap-switch" data-on-label="SI" data-off-label="NO" name="active" type="checkbox">
							</div>
						</div>-->

						<div class="col-md-6">
							<div class="form-group">
								<label>Páis</label>
				        		<input type="text"
									data-toggle="tooltip"
									class="form-control"
									id="country"
									disabled="true">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Estado</label>
				        		<input type="text"
									data-toggle="tooltip"
									class="form-control"
									id="estate"
									disabled="true">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Municipio</label>
				        		<input type="text"
									data-toggle="tooltip"
									class="form-control"
									id="municipality"
									disabled="true">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Parroquia</label>
				        		<input type="text"
									data-toggle="tooltip"
									class="form-control"
									id="parish"
									disabled="true">
							</div>
						</div>

				        <div class="col-md-6">
							<div class="form-group">
								<label>Dirección</label>
				        		<input type="text"
									data-toggle="tooltip"
									class="form-control"
									id="address"
									disabled="true">
							</div>
						</div>

				    </div>
				</div>

		    	<div class="modal-footer">
		        	<button type="button"
		            	    class="btn btn-warning btn-icon btn-round btn-modal-close"
		                	data-dismiss="modal"
		                	title="Cancelar y regresar">
		            	<i class="fa fa-ban"></i>
		        	</button>
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

            }
        }
    };
</script>
