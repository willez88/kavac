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
								<input type="text" class="form-control input-sm"
									v-model="record.first_name"/>
                                <input type="hidden" v-model="record.id">
							</div>
						</div>
                        <div class="col-md-4">
							<div class="form-group is-required">
								<label>Apellidos</label>
								<input type="text" class="form-control input-sm"
									v-model="record.last_name"/>
							</div>
						</div>
                        <div class="col-md-4">
							<div class="form-group is-required">
								<label>Nacionalidad</label>
								<select2 :options="payroll_nationalities"
                                    v-model="record.payroll_nationality_id">
                                </select2>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-4">
							<div class="form-group is-required">
								<label>Cédula de Identidad</label>
								<input type="text" class="form-control input-sm"
									v-model="record.id_number"/>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Pasaporte</label>
								<input type="text" class="form-control input-sm"
									v-model="record.passport"/>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Correo Electrónico</label>
								<input type="text" class="form-control input-sm"
									v-model="record.email"/>
							</div>
						</div>
					</div>

                    <div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Fecha de Nacimiento</label>
								<input type="date" class="form-control input-sm"
									v-model="record.birthdate"/>
							</div>
						</div>
                        <div class="col-md-4">
							<div class="form-group is-required">
								<label>Género</label>
								<select2 :options="payroll_genders"
                                    v-model="record.payroll_gender_id">
                                </select2>
							</div>
						</div>
					</div>

                    <div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Nombres y Apellidos de la Persona de Contacto</label>
								<input type="text" class="form-control input-sm"
									v-model="record.emergency_contact"/>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Teléfono de la Persona de Contacto</label>
								<input type="text" class="form-control input-sm"
									placeholder="00-000-0000000"
									v-model="record.emergency_phone"/>
							</div>
						</div>
					</div>

                    <div class="row">
                        <div class="col-md-4">
							<div class="form-group is-required">
								<label>País</label>
								<select2 :options="countries" @input="getEstates"
                                    v-model="record.country_id" id="country_id">
                                </select2>
							</div>
						</div>
                        <div class="col-md-4">
							<div class="form-group is-required">
								<label>Estado</label>
								<select2 :options="estates" @input="getMunicipalities" id="estate_id"
                                    v-model="record.estate_id">
                                </select2>
							</div>
						</div>
                        <div class="col-md-4">
							<div class="form-group is-required">
								<label>Municipio</label>
								<select2 :options="municipalities" @input="getParishes" id="municipality_id"
                                    v-model="record.municipality_id">
                                </select2>
							</div>
						</div>
					</div>

                    <div class="row">
                        <div class="col-md-4">
							<div class="form-group is-required">
								<label>Parroquia</label>
								<select2 :options="parishes" id="parish_id"
                                    v-model="record.parish_id">
                                </select2>
							</div>
						</div>
                        <div class="col-md-4">
							<div class="form-group is-required">
								<label>Dirección</label>
								<input type="text" class="form-control input-sm"
									v-model="record.address"/>
							</div>
						</div>
                    </div>

					<hr>
					<h6 class="card-title">
						Números Telefónicos <i class="fa fa-plus-circle cursor-pointer" @click="addPhone"></i>
					</h6>
                    <div class="row" v-for="(phone, index) in record.phones">
                        <div class="col-3">
                            <div class="form-group is-required">
                                <select data-toggle="tooltip" v-model="phone.type"
                                        class="select2"
                                        title="Seleccione el tipo de número telefónico">
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
                                       class="form-control input-sm">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group is-required">
                                <input type="text" placeholder="Número" data-toggle="tooltip"
                                       title="Indique el número telefónico"
                                       v-model="phone.number" class="form-control input-sm">
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group is-required">
                                <input type="text" placeholder="Extensión" data-toggle="tooltip"
                                       title="Indique la extención telefónica (opcional)"
                                       v-model="phone.extension" class="form-control input-sm">
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
                    emergency_contact: '',
                    emergency_phone: '',
					country_id: '',
					estate_id: '',
					municipality_id: '',
                    parish_id: '',
                    address: '',
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
					vm.record.country_id = response.data.record.parish.municipality.estate.country.id;
				});
			},
		},
		created() {
            this.getPayrollNationalities();
            this.getPayrollGenders();
			this.getCountries();
			this.getEstates();
            this.getMunicipalities();
			this.record.phones = [];
		},
		mounted() {
			if(this.payroll_staff_id) {
				this.getStaff();
			}
		}
	};
</script>
