<template>
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Registrar los Datos Personales</h6>
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
								<label>Nombres</label>
								<input type="text" class="form-control input-sm" v-model="record.first_name"/>
                                <input type="hidden" v-model="record.id" v-is-text>
							</div>
						</div>
                        <div class="col-md-4">
							<div class="form-group is-required">
								<label>Apellidos</label>
								<input type="text" class="form-control input-sm" v-model="record.last_name" v-is-text/>
							</div>
						</div>
                        <div class="col-md-4">
							<div class="form-group is-required">
								<label>Nacionalidad</label>
								<select2 :options="payroll_nationalities"
                                         v-model="record.payroll_nationality_id"></select2>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-4">
							<div class="form-group is-required">
								<label>Cédula de Identidad</label>
								<input type="text" class="form-control input-sm" v-model="record.id_number" v-is-digits/>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Pasaporte</label>
								<input type="text" class="form-control input-sm" v-model="record.passport" v-is-digits/>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Correo Electrónico</label>
								<input type="email" class="form-control input-sm" v-model="record.email"/>
							</div>
						</div>
					</div>

                    <div class="row">
						<div class="col-md-4">
							<div class="form-group is-required">
								<label>Fecha de Nacimiento</label>
								<input type="date" class="form-control input-sm" v-model="record.birthdate"/>
							</div>
						</div>
                        <div class="col-md-4">
							<div class="form-group is-required">
								<label>Género</label>
								<select2 :options="payroll_genders" v-model="record.payroll_gender_id"></select2>
							</div>
						</div>
					</div>

                    <div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Nombres y Apellidos de la Persona de Contacto</label>
								<input type="text" class="form-control input-sm" v-model="record.emergency_contact"
                                       v-is-text/>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Teléfono de la Persona de Contacto</label>
								<input type="text" class="form-control input-sm" placeholder="+00-000-0000000"
                                       v-model="record.emergency_phone" v-input-mask
                                       data-inputmask="'mask': '+99-999-9999999'"/>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>¿Posee una Discapacidad?</label>
								<div class="col-md-12">
                                    <div class="col-12 bootstrap-switch-mini">
    									<input id="has_disability" name="has_disability" type="checkbox"
                                               class="form-control bootstrap-switch sel_has_disability"
                                               data-toggle="tooltip" data-on-label="SI" data-off-label="NO"
                                               title="Indique si el trabajador posee una discapacidad o no"
                                               v-model="record.has_disability" value="true"/>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4" v-if="record.has_disability">
							<div class="form-group is-required">
								<label>Discapacidad</label>
								<select2 :options="payroll_disabilities" v-model="record.payroll_disability_id">
                                </select2>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group is-required">
								<label>Tipo de Sangre</label>
								<select2 :options="payroll_blood_types" v-model="record.payroll_blood_type_id">
                                </select2>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Seguro Social</label>
								<input type="text" class="form-control input-sm" v-model="record.social_security"
                                       title="Indique el número de seguro social"/>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>¿Posee Licencia de Conducir?</label>
								<div class="col-md-12">
                                    <div class="col-12 bootstrap-switch-mini">
    									<input id="has_driver_license" name="has_driver_license" type="checkbox"
                                               class="form-control bootstrap-switch sel_has_driver_license"
                                               data-toggle="tooltip" data-on-label="SI" data-off-label="NO"
                                               title="Indique si el trabajador posee licencia de conducir o no"
                                               v-model="record.has_driver_license" value="true"/>
                                    </div>
								</div>
							</div>
						</div>
						<div class="col-md-4" v-if="record.has_driver_license">
							<div class="form-group is-required">
								<label>Grado de Licencia de Conducir</label>
								<select2 :options="payroll_license_degrees" v-model="record.payroll_license_degree_id">
                                </select2>
							</div>
						</div>
					</div>

                    <div class="row">
                        <div class="col-md-4">
							<div class="form-group is-required">
								<label>País</label>
								<select2 :options="countries" @input="getEstates" v-model="record.country_id"
                                         id="country_id"></select2>
							</div>
						</div>
                        <div class="col-md-4">
							<div class="form-group is-required">
								<label>Estado</label>
								<select2 :options="estates" @input="getMunicipalities" id="estate_id"
                                         v-model="record.estate_id"></select2>
							</div>
						</div>
                        <div class="col-md-4">
							<div class="form-group is-required">
								<label>Municipio</label>
								<select2 :options="municipalities" @input="getParishes" id="municipality_id"
                                         v-model="record.municipality_id"></select2>
							</div>
						</div>
					</div>

                    <div class="row">
                        <div class="col-md-4">
							<div class="form-group is-required">
								<label>Parroquia</label>
								<select2 :options="parishes" id="parish_id" v-model="record.parish_id"></select2>
							</div>
						</div>
                        <div class="col-md-4">
							<div class="form-group is-required">
								<label>Dirección</label>
								<input type="text" class="form-control input-sm" v-model="record.address"/>
							</div>
						</div>
                    </div>

					<div class="row">
						<div class="col-md-4">
							<div class="form-group is-required">
								<label>Talla de Uniforme</label>
								<input type="number" class="form-control input-sm" v-model="record.uniform_size"
                                       title="Indique la talla del uniforme" min="1"/>
							</div>
						</div>
                        <div class="col-md-4">
							<div class="form-group">
								<label>Historial Médico</label>
								<ckeditor :editor="ckeditor.editor" id="medical_history" data-toggle="tooltip"
	                                      title="Indique el historial médico" :config="ckeditor.editorConfig"
	                                      class="form-control" tag-name="textarea" rows="2"
	                                      v-model="record.medical_history">
	                            </ckeditor>
							</div>
						</div>
                    </div>

					<hr>
					<h6 class="card-title">
						Números Telefónicos <i class="fa fa-plus-circle cursor-pointer" @click="addPhone"></i>
					</h6>
                    <div class="row phone-row" v-for="(phone, index) in record.phones">
                        <div class="col-3">
                            <div class="form-group is-required">
                                <select data-toggle="tooltip" v-model="phone.type" class="select2"
                                        title="Seleccione el tipo de número telefónico" :data-phone-index="index">
                                    <option value="">Seleccione...</option>
                                    <option value="M">Móvil</option>
                                    <option value="T">Teléfono</option>
                                    <option value="F">Fax</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group is-required">
                                <input type="text" placeholder="Cod. Area" data-toggle="tooltip"
                                       title="Indique el código de área" v-model="phone.area_code"
                                       class="form-control input-sm" v-is-digits>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group is-required">
                                <input type="text" placeholder="Número" data-toggle="tooltip"
                                       title="Indique el número telefónico"
                                       v-model="phone.number" class="form-control input-sm" v-is-digits>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <input type="text" placeholder="Extensión" data-toggle="tooltip"
                                       title="Indique la extención telefónica (opcional)"
                                       v-model="phone.extension" class="form-control input-sm" v-is-digits>
                            </div>
                        </div>
                        <div class="col-1">
                            <div class="form-group">
                                <button class="btn btn-sm btn-danger btn-action" type="button"
                                        @click="removeRow(index, record.phones)"
                                        title="Eliminar este dato" data-toggle="tooltip">
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
					<button type="button" @click="createRecord('payroll/staffs')"
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
			payroll_staff_id: Number,
		},
		data() {
			return {
				record: {
					id: '',
					first_name: '',
					last_name: '',
					payroll_nationality_id: '',
					id_number: '',
					passport: '',
                    email: '',
                    birthdate: '',
                    payroll_gender_id: '',
					has_disability: '',
					payroll_disability_id: '',
					payroll_blood_type_id: '',
					social_security: '',
					has_driver_license: '',
					payroll_license_degree_id: '',
                    emergency_contact: '',
                    emergency_phone: '',
					country_id: '',
					estate_id: '',
					municipality_id: '',
                    parish_id: '',
                    address: '',
					uniform_size: '',
					medical_history: '',
					phones: [],
				},
				errors: [],
				payroll_nationalities: [],
				payroll_genders: [],
                countries: [],
				setEstate: '',
                estates: [],
                municipalities: [],
                parishes: [],
				payroll_license_degrees: [],
				payroll_blood_types: [],
				payroll_disabilities: [],
			}
		},
		methods: {
			/**
			 * Método que borra todos los datos del formulario
			 *
			 * @author  William Páez <wpaez@cenditel.gob.ve>
			 */
			reset() {

			},

			getStaff() {
				let vm = this;
				axios.get(`/payroll/staffs/${vm.payroll_staff_id}`).then(response => {
					vm.record = response.data.record;
					/*vm.record.id = response.data.record.id;
					vm.record.first_name = response.data.record.first_name;
					vm.record.last_name = response.data.record.last_name;
					vm.record.payroll_nationality_id = response.data.record.payroll_nationality_id;
					vm.record.id_number = response.data.record.id_number;
					vm.record.passport = response.data.record.passport;
					vm.record.email = response.data.record.email;
					vm.record.birthdate = response.data.record.birthdate;
					vm.record.payroll_gender_id = response.data.record.payroll_gender_id;
					vm.record.has_disability = response.data.record.has_disability;
					vm.record.disability = response.data.record.disability;*/
				});
			},
		},
		created() {
            this.getPayrollNationalities();
            this.getPayrollGenders();
			this.getCountries();
			this.getEstates();
            this.getMunicipalities();
			this.getPayrollLicenseDegrees();
			this.getPayrollBloodTypes();
			this.getPayrollDisabilities();
			this.record.has_disability = false;
			this.record.has_driver_license = false;
			this.record.phones = [];
		},
		mounted() {
			if(this.payroll_staff_id) {
				this.getStaff();
			}
			this.switchHandler('has_disability');
			this.switchHandler('has_driver_license');
		},
		watch: {
			record: {
				deep: true,
				handler: function() {
					const vm = this;
					if (vm.record.has_disability) {
						$('#has_disability').bootstrapSwitch('state', true, true);
					}
					if (vm.record.has_driver_license) {
						$('#has_driver_license').bootstrapSwitch('state', true, true);
					}
				}
			}
		}
	};
</script>
