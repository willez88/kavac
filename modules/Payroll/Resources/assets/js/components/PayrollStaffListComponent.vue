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
        </v-client-table>
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
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="code">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Trabajador</label>
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="payroll_staff">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Nacionalidad</label>
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="payroll_nationality">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Cédula de Identidad</label>
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="id_number">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Pasaporte</label>
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="passport">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Correo Electrónico</label>
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="email">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Fecha de Nacimiento</label>
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="birthdate">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Edad</label>
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="age">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Género</label>
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="payroll_gender">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Nombres y Apellidos de la Persona de Contacto</label>
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="emergency_contact">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Teléfono de la Persona de Contacto</label>
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="emergency_phone">
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>¿Posee una Discapacidad?</label>
                                    <div class="col-12 bootstrap-switch-mini">
                                        <input id="has_disability" class="form-control bootstrap-switch"
                                               data-on-label="SI" data-off-label="NO" type="checkbox"
                                               :value="record.has_disability">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4" v-show="record.has_disability">
                                <div class="form-group">
                                    <label>Discapacidad</label>
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="disability">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tipo de Sangre</label>
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="payroll_blood_type">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Seguro Social</label>
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="social_security">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>¿Posee Licencia de Conducir?</label>
                                    <div class="col-12 bootstrap-switch-mini">
                                        <input id="has_driver_license" class="form-control bootstrap-switch"
                                               data-on-label="SI" data-off-label="NO" type="checkbox"
                                               :value="record.has_driver_license">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4" v-show="record.has_driver_license">
                                <div class="form-group">
                                    <label>Grado de la Licencia de Conducir</label>
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="payroll_license_degree">
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>País</label>
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="country">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Estado</label>
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="estate">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Municipio</label>
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="municipality">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Parroquia</label>
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="parish">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Dirección</label>
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="address">
                                </div>
                            </div>
                        </div>

                        <hr>
                        <h6 class="card-title">
                            Números Telefónicos</i>
                        </h6>
                        <div class="row" v-for="phone in record.phones">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Tipo</label>
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="type" :value="phone.type">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Código de Área</label>
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="area_code" :value="phone.area_code">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Número</label>
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="number" :value="phone.number">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Extensión</label>
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="extension" :value="phone.extension">
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
                axios.get('/payroll/staffs/' + id).then(response => {
					this.record = response.data.record;
                    $('#code').val(this.record.code);
                    $('#payroll_staff').val(this.record.first_name + ' ' + this.record.last_name);
                    $('#payroll_nationality').val(this.record.payroll_nationality.name);
                    $('#id_number').val(this.record.id_number);
                    $('#passport').val(this.record.passport);
                    $('#email').val(this.record.email);
                    $('#birthdate').val(this.record.birthdate);
                    $('#age').val(response.data.age);
                    $('#payroll_gender').val(this.record.payroll_gender.name);
                    $('#emergency_contact').val(this.record.emergency_contact);
                    $('#emergency_phone').val(this.record.emergency_phone);
                    (this.record.has_disability) ? $('#has_disability').bootstrapSwitch('state', true) : $('#has_disability').bootstrapSwitch('state', false);
                    $('#disability').val(this.record.disability);
                    $('#payroll_blood_type').val(this.record.payroll_blood_type.name);
                    $('#social_security').val(this.record.social_security);
                    (this.record.has_driver_license) ? $('#has_driver_license').bootstrapSwitch('state', true) : $('#has_driver_license').bootstrapSwitch('state', false);
                    $('#payroll_license_degree').val( (this.record.payroll_license_degree) ? this.record.payroll_license_degree.name : ' ' );
                    $('#country').val(this.record.parish.municipality.estate.country.name);
                    $('#estate').val(this.record.parish.municipality.estate.name);
                    $('#municipality').val(this.record.parish.municipality.name);
                    $('#parish').val(this.record.parish.name);
                    $('#address').val(this.record.address);
				});
                $('#show_staff').modal('show');
            },
        }
    };
</script>
