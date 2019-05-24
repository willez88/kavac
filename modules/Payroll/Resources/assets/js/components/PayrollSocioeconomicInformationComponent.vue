<template>
	<div class="row">
		<div class="col-7">
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
											 v-model="record.payroll_staff_id"></select2>
									<input type="hidden" v-model="record.id">
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group is-required">
									<label>Estado Civil:</label>
									<select2 :options="marital_status"
											 v-model="record.marital_status_id" @input="showHide"></select2>
								</div>
							</div>
						</div>

						<div class="row d-none" id="block_twosome">
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
							Números Telefónicos <i class="fa fa-plus-circle cursor-pointer" @click="addChildren"></i>
						</h6>
						<div class="row" v-for="(children, index) in record.childrens">
							<div class="col-4">
								<div class="form-group is-required">
									<input type="text" placeholder="Nombres y Apellidos del hijo del trabajador" data-toggle="tooltip"
										   title="Indique los nombres y apellidos del hijo del trabajador" v-model="children.full_name_son"
										   class="form-control input-sm">
								</div>
							</div>
							<div class="col-4">
								<div class="form-group is-required">
									<input type="text" placeholder="Cédula de Identidad del hijo del trabajador" data-toggle="tooltip"
										   title="Indique la cédula de indentidad del hijo del trabajador"
										   v-model="children.id_number_son" class="form-control input-sm">
								</div>
							</div>
							<div class="col-4">
								<div class="form-group is-required">
									<input type="text" placeholder="Fecha de Nacimiento del hijo del trabajador" data-toggle="tooltip"
										   title="Indique la fecha de nacimiento del hijo del trabajador"
										   v-model="children.birthdate_son" class="form-control input-sm">
								</div>
							</div>
							<div class="col-1">
								<div class="form-group">
									<button class="btn btn-sm btn-danger btn-action" type="button"
											@click="removeRow(index, record.childrens)"
											title="Eliminar este dato" data-toggle="tooltip">
										<i class="fa fa-minus-circle"></i>
									</button>
								</div>
							</div>
						</div>

					</div>

					<div class="card-body modal-table">
	                	<hr>
	                	<v-client-table :columns="columns" :data="records" :options="table_options">
	                		<div slot="id" slot-scope="props" class="text-center">
	                			<button @click="initUpdate(props.index, $event)"
		                				class="btn btn-warning btn-xs btn-icon btn-round"
		                				title="Modificar registro" data-toggle="tooltip" type="button">
		                			<i class="fa fa-edit"></i>
		                		</button>
		                		<button @click="deleteRecord(props.index, 'socioeconomic-informations')"
										class="btn btn-danger btn-xs btn-icon btn-round"
										title="Eliminar registro" data-toggle="tooltip"
										type="button">
									<i class="fa fa-trash-o"></i>
								</button>
	                		</div>
	                		<div slot="childrens" slot-scope="props" class="text-center">
	                			<span v-for="children in props.row.childrens">
	                				<div>
	                					{{ children.full_name_son }}
	                				</div>
	                			</span>
	                		</div>
	                	</v-client-table>
	                </div>

				</div>
			</div>
		</div>
		<div class="col-5">
			<div class="card">
				<div class="card-body">
					<pre>
						{{ $data }}
					</pre>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				record: {
					id: '',
					full_name_twosome: '',
					id_number_twosome: '',
					birthdate_twosome: '',
					payroll_staff_id: '',
					marital_status_id: '',
					childrens: [],
				},
				errors: [],
				records: [],
				payroll_staffs: [],
				marital_status: [],
				columns: ['payroll_staffs.name', 'marital_status.name', 'childrens', 'id'],
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
					payroll_staff_id: '',
					marital_status_id: '',
					childrens: [],
				};
			},

			getPayrollStaffs() {
				axios.get('list-staffs').then(response => {
					this.payroll_staffs = response.data;
				});
			},

			getMaritalStatus() {
				axios.get('list-marital-status').then(response => {
					this.marital_status = response.data;
				});
			},

			showHide(value) {
				(this.record.marital_status_id == 2) ? $('#block_twosome').removeClass('d-none') : $('#block_twosome').addClass('d-none');
			},

			/**
			 * Agrega una nueva columna para el registro de hijos del trabajador
			 *
			 * @author William Páez <wpaez@cenditel.gob.ve>
			 */
			addChildren() {
				this.record.childrens.push({
					full_name_son: '',
					id_number_son: '',
					birthdate_son: ''
				});
			},
		},
		created() {
			this.table_options.headings = {
				'payroll_staffs.name': 'Trabajador',
				'marital_status.name': 'Estado Civil',
				'childrens': 'Hijos del Trabajador',
				'id': 'Acción'
			};
			this.table_options.sortable = ['payroll_staff.name', 'marital_status.name'];
			this.table_options.filterable = ['payroll_staff.name', 'marital_status.name'];
			this.getPayrollStaffs();
			this.getMaritalStatus();
		},
	};
</script>
