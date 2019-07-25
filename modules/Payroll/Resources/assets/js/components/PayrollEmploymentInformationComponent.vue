<template>
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Registrar los Datos Laborales</h6>
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
								<label>Fecha de ingreso a la administración pública:</label>
								<input type="date" class="form-control input-sm"
									v-model="record.start_date_apn"/>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group is-required">
								<label>Fecha de ingreso a la institución:</label>
								<input type="date" class="form-control input-sm"
									v-model="record.start_date"/>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Fecha de egreso de la institución:</label>
								<input type="date" class="form-control input-sm"
									v-model="record.end_date"/>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>¿Está Activo?</label>
								<div class="col-md-12">
									<input id="active" type="checkbox" class="form-control bootstrap-switch"
										data-toggle="tooltip" data-on-label="SI" data-off-label="NO"
										title="Indique si el trabajador está activo o no"
										v-model="record.active"/>
								</div>
							</div>
						</div>
						<div class="col-md-4" v-if="!record.active">
							<div class="form-group is-required">
								<label>Tipo de Inactividad:</label>
								<select2 :options="payroll_inactivity_types"
									v-model="record.payroll_inactivity_type_id">
								</select2>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Correo Institucional:</label>
								<input type="email" class="form-control input-sm"
									v-model="record.institution_email"/>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Descripción de Funciones:</label>
								<input type="textarea" class="form-control input-sm"
									v-model="record.function_description"/>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group is-required">
								<label>Tipo de Cargo:</label>
								<select2 :options="payroll_position_types"
									v-model="record.payroll_position_type_id">
								</select2>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group is-required">
								<label>Cargo:</label>
								<select2 :options="payroll_positions"
									v-model="record.payroll_position_id">
								</select2>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group is-required">
								<label>Tipo de Personal:</label>
								<select2 :options="payroll_staff_types"
									v-model="record.payroll_staff_type_id">
								</select2>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group is-required">
								<label>Departamento:</label>
								<select2 :options="departments"
									v-model="record.department_id">
								</select2>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group is-required">
								<label>Tipo de Contrato:</label>
								<select2 :options="payroll_contract_types"
									v-model="record.payroll_contract_type_id">
								</select2>
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
	                <button type="button" @click="createRecord('payroll/employment-informations')"
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
			payroll_employment_information_id: Number,
		},
		data() {
			return {
				record: {
					id: '',
					payroll_staff_id: '',
					institution_id: '',
					start_date_apn: '',
					start_date: '',
					active: '',
					payroll_inactivity_type_id: '',
					institution_email: '',
					function_description: '',
					payroll_position_type_id: '',
					payroll_position_id: '',
					payroll_staff_type_id: '',
					department_id: '',
					payroll_contract_type_id: ''
				},
				errors: [],
				payroll_staffs: [],
				payroll_inactivity_types: [],
				payroll_position_types: [],
				payroll_positions: [],
				payroll_staff_types: [],
				departments: [],
				payroll_contract_types: [],
			}
		},
		methods: {

			getEmploymentInformation() {
				axios.get('/payroll/employment-informations/' + this.payroll_employment_information_id).then(response => {
					this.record = response.data.record;
				});
			},

			reset() {
				this.record = {
					id: '',
					institution_id: '1',
					payroll_staff_id: '',
					start_date_apn: '',
					start_date: '',
					active: false,
					payroll_inactivity_type_id: '',
					institution_email: '',
					function_description: '',
					payroll_position_type_id: '',
					payroll_position_id: '',
					payroll_staff_type_id: '',
					department_id: '',
					payroll_contract_type_id: ''
				};
			},
		},
		created() {
			this.record.active = true;
			this.record.institution_id = '1';
			this.getPayrollStaffs();
			this.getPayrollInactivityTypes();
			this.getPayrollPositionTypes();
			this.getPayrollPositions();
			this.getPayrollStaffTypes();
			this.getDepartments();
			this.getPayrollContractTypes();
		},
		mounted() {
			if(this.payroll_employment_information_id) {
				this.getEmploymentInformation();
			}

			this.switchHandler('active');
			const vm = this;

			/**
			 * En la funcionalidad de actualizar, el botón booleano sigue sin actualizarse según
			 *  el valor que se carga de la bd
			 */
			$('#active').on('switchChange.bootstrapSwitch', function(e) {
				e.target.id;
				if (vm.record.active) {
					vm.record.active = false;
					$('#active').bootstrapSwitch('state', false)
				}
				else {
					vm.record.active = true;
					$('#active').bootstrapSwitch('state', true)
				}
			});
		}
	};
</script>
