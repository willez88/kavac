<template>
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Registrar los Datos Socioeconómicos</h6>
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
						<div class="container">
							<div class="alert-icon">
								<i class="now-ui-icons objects_support-17"></i>
							</div>
							<strong>Cuidado!</strong> Debe verificar los siguientes errores antes de continuar:
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"
									@click.prevent="errors = []">
								<span aria-hidden="true">
									<i class="now-ui-icons ui-1_simple-remove"></i>
								</span>
							</button>
							<ul>
								<li v-for="error in errors">{{ error }}</li>
							</ul>
						</div>
					</div>

					<div class="row">
						<div class="col-md-4">
							<div class="form-group is-required">
								<label>Trabajador:</label>
								<select2 :options="payroll_staffs"
										 v-model="record.payroll_staff_id"></select2>
								<input type="hidden" v-model="record.id">
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group is-required">
								<label>Estado Civil:</label>
								<select2 :options="marital_status"
									v-model="record.marital_status_id"></select2>
							</div>
						</div>
					</div>

					<div class="row" v-if="record.marital_status_id == 2">
						<div class="col-md-4">
							<div class="form-group">
								<label>Nombres y apellidos de la pareja del trabajador:</label>
								<input type="text" class="form-control input-sm"
									v-model="record.full_name_twosome"/>
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<label>Cédula de Identidad de la pareja del trabajador:</label>
								<input type="text" class="form-control input-sm"
									v-model="record.id_number_twosome"/>
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<label>fecha de nacimiento de la pareja del trabajador:</label>
								<input type="date" class="form-control input-sm"
									v-model="record.birthdate_twosome"/>
							</div>
						</div>
					</div>

					<hr>
					<h6 class="card-title">
						Hijos del Trabajador <i class="fa fa-plus-circle cursor-pointer" @click="addPayrollChildren"></i>
					</h6>
					<div class="row" v-for="(payroll_children, index) in record.payroll_childrens">
						<div class="col-3">
							<div class="form-group is-required">
								<input type="text" placeholder="Nombres del hijo del trabajador" data-toggle="tooltip"
									title="Indique los nombres del hijo del trabajador" v-model="payroll_children.first_name"
									class="form-control input-sm">
							</div>
						</div>
						<div class="col-3">
							<div class="form-group is-required">
								<input type="text" placeholder="Apellidos del hijo del trabajador" data-toggle="tooltip"
									title="Indique los apellidos del hijo del trabajador" v-model="payroll_children.last_name"
									class="form-control input-sm">
							</div>
						</div>
						<div class="col-2">
							<div class="form-group">
								<input type="text" placeholder="Cédula de Identidad del hijo del trabajador" data-toggle="tooltip"
									title="Indique la cédula de indentidad del hijo del trabajador"
									v-model="payroll_children.id_number" class="form-control input-sm">
							</div>
						</div>
						<div class="col-2">
							<div class="form-group is-required">
								<input type="date" placeholder="Fecha de Nacimiento del hijo del trabajador" data-toggle="tooltip"
									title="Indique la fecha de nacimiento del hijo del trabajador"
									v-model="payroll_children.birthdate" class="form-control input-sm">
							</div>
						</div>
						<div class="col-1">
							<div class="form-group">
								<button class="btn btn-sm btn-danger btn-action" type="button"
									@click="removeRow(index, record.payroll_childrens)"
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
					<button type="button" @click="createRecord('payroll/socioeconomics')"
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
			payroll_socioeconomic_id: Number,
		},
		data() {
			return {
				record: {
					id: '',
					full_name_twosome: '',
					id_number_twosome: '',
					birthdate_twosome: '',
					payroll_staff_id: '',
					marital_status_id: '',
					payroll_childrens: [],
				},
				errors: [],
				payroll_staffs: [],
				marital_status: [],
			}
		},
		methods: {
			/**
			 * Método que borra todos los datos del formulario
			 *
			 * @author  William Páez <wpaez@cenditel.gob.ve>
			 */
			reset() {
				this.record = {
					id: '',
					full_name_twosome: '',
					id_number_twosome: '',
					birthdate_twosome: '',
					payroll_staff_id: '',
					marital_status_id: '',
					payroll_childrens: [],
				};
			},

			getSocioeconomic() {
				axios.get('/payroll/socioeconomics/' + this.payroll_socioeconomic_id).then(response => {
					this.record = response.data.record;
				});
			},

			/**
			 * Agrega una nueva columna para el registro de hijos del trabajador
			 *
			 * @author William Páez <wpaez@cenditel.gob.ve>
			 */
			addPayrollChildren() {
				this.record.payroll_childrens.push({
					first_name: '',
					last_name: '',
					id_number: '',
					birthdate: ''
				});
			},
		},
		created() {
			this.getPayrollStaffs();
			this.getMaritalStatus();
			this.record.payroll_childrens = [];
		},
		mounted() {
			if(this.payroll_socioeconomic_id) {
				this.getSocioeconomic();
			}
		}
	};
</script>
