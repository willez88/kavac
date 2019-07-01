<template>
    <v-client-table :columns="columns" :data="records" :options="table_options">
		<div slot="id" slot-scope="props" class="text-center">
			<button @click="show_info(props.row.id)" v-if="route_show"
    				class="btn btn-info btn-xs btn-icon btn-action btn-tooltip"
    				title="Ver registro" data-toggle="tooltip" data-placement="bottom" type="button">
    			<i class="fa fa-eye"></i>
    		</button>
            <div class="modal fade" tabindex="-1" role="dialog" id="show_staff">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
        					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
        						<span aria-hidden="true">×</span>
        					</button>
        					<h6>
        						<i class="icofont icofont-read-book ico-2x"></i>
        						Información Detallada de Datos Personales
        					</h6>
        				</div>
                        <div class="modal-body">
                            <div class="row">
        						<div class="col-md-4">
        							<div class="form-group">
        								<label>Código</label>
        								<input type="text" data-toggle="tooltip" class="form-control"
                                            disabled="true" id="code">
        							</div>
        						</div>
                                <div class="col-md-4">
        							<div class="form-group">
        								<label>Nombres</label>
        				        		<input type="text" data-toggle="tooltip" class="form-control"
                                            disabled="true" id="first_name">
        				            </div>
        				        </div>
                                <div class="col-md-4">
        							<div class="form-group">
        								<label>Apellidos</label>
        				        		<input type="text" data-toggle="tooltip" class="form-control"
                                            disabled="true" id="last_name">
        				            </div>
        				        </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
        							<div class="form-group">
        								<label>Nacionalidad</label>
        				        		<input type="text" data-toggle="tooltip" class="form-control"
                                            disabled="true" id="payroll_nationality">
        				            </div>
        				        </div>
                                <div class="col-md-4">
        							<div class="form-group">
        								<label>Cédula de Identidad</label>
        				        		<input type="text" data-toggle="tooltip" class="form-control"
                                            disabled="true" id="id_number">
        				            </div>
        				        </div>
                                <div class="col-md-4">
        							<div class="form-group">
        								<label>Pasaporte</label>
        				        		<input type="text" data-toggle="tooltip" class="form-control"
                                            disabled="true" id="passport">
        				            </div>
        				        </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
        							<div class="form-group">
        								<label>Correo Electrónico</label>
        				        		<input type="text" data-toggle="tooltip" class="form-control"
                                            disabled="true" id="email">
        				            </div>
        				        </div>
                                <div class="col-md-4">
        							<div class="form-group">
        								<label>Fecha de Nacimiento</label>
        				        		<input type="text" data-toggle="tooltip" class="form-control"
                                            disabled="true" id="birthdate">
        				            </div>
        				        </div>
                                <div class="col-md-4">
        							<div class="form-group">
        								<label>Género</label>
        				        		<input type="text" data-toggle="tooltip" class="form-control"
                                            disabled="true" id="payroll_gender">
        				            </div>
        				        </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
        							<div class="form-group">
        								<label>Nombres y Apellidos de la Persona de Contacto</label>
        				        		<input type="text" data-toggle="tooltip" class="form-control"
                                            disabled="true" id="emergency_contact">
        				            </div>
        				        </div>
                                <div class="col-md-4">
        							<div class="form-group">
        								<label>Teléfono de la Persona de Contacto</label>
        				        		<input type="text" data-toggle="tooltip" class="form-control"
                                            disabled="true" id="emergency_phone">
        				            </div>
        				        </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
        							<div class="form-group">
        								<label>País</label>
        				        		<input type="text" data-toggle="tooltip" class="form-control"
                                            disabled="true" id="country">
        				            </div>
        				        </div>
                                <div class="col-md-4">
        							<div class="form-group">
        								<label>Estado</label>
        				        		<input type="text" data-toggle="tooltip" class="form-control"
                                            disabled="true" id="estate">
        				            </div>
        				        </div>
                                <div class="col-md-4">
        							<div class="form-group">
        								<label>Municipio</label>
        				        		<input type="text" data-toggle="tooltip" class="form-control"
                                            disabled="true" id="municipality">
        				            </div>
        				        </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
        							<div class="form-group">
        								<label>Parroquia</label>
        				        		<input type="text" data-toggle="tooltip" class="form-control"
                                            disabled="true" id="parish">
        				            </div>
        				        </div>
                                <div class="col-md-4">
        							<div class="form-group">
        								<label>Dirección</label>
        				        		<input type="text" data-toggle="tooltip" class="form-control"
                                            disabled="true" id="address">
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
				columns: ['first_name', 'last_name', 'id_number', 'email', 'id'],
			}
		},

        created() {
			this.table_options.headings = {
                'first_name': 'Nombres',
				'last_name': 'Apellidos',
                'id_number': 'Cédula de Identidad',
                'email': 'Correo Electrónico',
				'id': 'Acción'
			};
            this.table_options.sortable = ['first_name', 'last_name', 'id_number'];
			this.table_options.filterable = ['first_name', 'last_name', 'id_number'];
		},

		mounted() {
			this.initRecords(this.route_list, '');
		},

        methods: {
            reset() {

            },

            show_info(id) {
                axios.get('/payroll/staffs/info/' + id).then(response => {
					var record = response.data.record;
                    $('#code').val(record.code);
                    $('#first_name').val(record.first_name);
                    $('#last_name').val(record.last_name);
                    $('#payroll_nationality').val(record.payroll_nationality);
                    $('#id_number').val(record.id_number);
                    $('#passport').val(record.passport);
                    $('#email').val(record.email);
                    $('#birthdate').val(record.birthdate);
                    $('#payroll_gender').val(record.payroll_gender);
                    $('#emergency_contact').val(record.emergency_contact);
                    $('#emergency_phone').val(record.emergency_phone);
                    $('#country').val(record.country);
                    $('#estate').val(record.estate);
                    $('#municipality').val(record.municipality);
                    $('#parish').val(record.parish);
                    $('#address').val(record.address);
				});
                $('#show_staff').modal('show');
            }
        }
    };
</script>
