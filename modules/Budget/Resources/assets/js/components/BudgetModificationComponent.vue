<template>
	<div>
		<div class="card-body">
			<div class="alert alert-danger" v-if="errors.length > 0">
				<ul>
					<li v-for="error in errors">{{ error }}</li>
				</ul>
			</div>
			<div class="row">
				<div class="col-md-2">
					<div class="form-group is-required">
						<label class="control-label" for="approved_at">Fecha de creación</label>
						<input type="date" name="approved_at" id="approved_at" class="form-control input-sm" 
							   placeholder="dd/mm/YY" data-toggle="tooltip" v-model="record.approved_at" 
							   title="Fecha en la que se aprobó la modificación presupuestaria">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group is-required">
						<label class="control-label" for="institution_id">Institución</label>
						<select2 :options="institutions" v-model="record.institution_id"></select2>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group is-required">
						<label class="control-label" for="document">Documento</label>
						<input type="text" name="document" id="document" class="form-control input-sm" 
							   placeholder="Nro. Documento" data-toggle="tooltip" v-model="record.document" 
							   title="Número del documento, decreto o misiva que avala la modificación presupuestaria">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="form-group is-required">
						<label class="control-label" for="description">Descripción</label>
						<input type="text" name="description" id="description" class="form-control input-sm" 
							   placeholder="Descripción / Detalles" data-toggle="tooltip" 
							   title="Descripción o detalle de la modificación presupuestaria" 
							   v-model="record.description">
					</div>
				</div>
			</div>
			<div class="pad-top-40">
				<h6 class="text-center card-title">Cuentas presupuestarias</h6>
				<div class="row">
					<div class="col-12 pad-top-20" v-if="!transfer">
						<table class="table">
							<thead>
								<tr>
									<th>Acción Específica</th>
									<th>Cuenta</th>
									<th>Descripción</th>
									<th>Monto</th>
									<th>
										<a class="btn btn-sm btn-info btn-action btn-tooltip" href="#" 
										   data-original-title="Agregar nuevo registro" data-toggle="modal"  
										   data-target="#add_account" v-if="record.approved_at">
											<i class="fa fa-plus-circle"></i>
										</a>
									</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="(account, index) in budget_modification_accounts">
									<td>{{ account.spac_description }}</td>
									<td>{{ account.code }}</td>
									<td>{{ account.description }}</td>
									<td class="text-right">{{ account.from_amount }}</td>
									<td class="text-center">
										<input type="hidden" name="from_budget_account_id[]" readonly 
											   :value="account.from_budget_specific_action_id + '|' + account.from_budget_account_id">
										<input type="hidden" name="from_budget_account_amount[]" readonly 
											   :value="account.from_amount">
										<a class="btn btn-sm btn-danger btn-action" href="#" @click="deleteAccount(index)"
										   title="Eliminar este registro" data-toggle="tooltip">
											<i class="fa fa-minus-circle"></i>
										</a>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="modal fade" tabindex="-1" role="dialog" id="add_account">
					<div class="modal-dialog vue-crud" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">×</span>
								</button>
								<h6>
									<i class="ion-arrow-graph-up-right"></i> 
									Agregar Cuenta{{ (transfer) ? 's' : '' }}
								</h6>
							</div>
							<div class="modal-body">
								<div class="alert alert-danger" v-if="errors.length > 0">
									<ul>
										<li v-for="error in errors">{{ error }}</li>
									</ul>
								</div>
								<div class="row" v-if="transfer">
									<div class="col-12">
										<h6 class="text-center">
											Cuenta a Debitar
										</h6>
									</div>
								</div>
								<div class="row">
									<div class="col-6">
										<div class="form-group is-required">
											<label>Acción Específica:</label>
											<select2 :options="specific_actions" @input="getAccounts" 
													 v-model="from_budget_specific_action_id"/>
					                    </div>
									</div>
									<div class="col-6">
										<div class="form-group is-required">
											<label>Cuenta:</label>
											<select2 :options="accounts" 
													 v-model="from_budget_account_id"/>
					                    </div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-3">
										<div class="form-group is-required">
											<label>Monto:</label>
											<input type="number" class="form-control" data-toggle="tooltip" 
												   title="Indique el monto a asignar para la cuenta seleccionada" v-model="from_amount">
										</div>
									</div>
								</div>
								<div v-if="transfer">
									<div class="row">
										<div class="col-12">
											<hr>
											<h6 class="text-center">
												Cuenta a Acreditar
											</h6>
										</div>
									</div>
									<div class="row">
										<div class="col-6">
											<div class="form-group is-required">
												<label>Acción Específica:</label>
												<select2 :options="specific_actions" @input="getAccounts" 
														 v-model="to_budget_specific_action_id"/>
						                    </div>
										</div>
										<div class="col-6">
											<div class="form-group is-required">
												<label>Cuenta:</label>
												<select2 :options="accounts" 
														 v-model="to_budget_account_id"/>
						                    </div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-3">
											<div class="form-group is-required">
												<label>Monto:</label>
												<input type="number" class="form-control" data-toggle="tooltip" 
													   title="Indique el monto a asignar para la cuenta seleccionada" v-model="to_amount">
											</div>
										</div>
									</div>
								</div>
			                </div>
			                <div class="modal-footer">
			                	<button type="button" class="btn btn-default btn-sm btn-round btn-modal-close" 
			                			data-dismiss="modal">
			                		Cerrar
			                	</button>
			                	<button type="button" @click="addAccount" 
			                			class="btn btn-primary btn-sm btn-round btn-modal-save">
			                		Guardar
				                </button>
				            </div>
				        </div>
				    </div>
				</div>
			</div>
		</div>
		<div class="card-footer text-right">
			<button type="reset" class="btn btn-default btn-icon btn-round" data-toggle="tooltip" 
					title="Borrar datos del formulario" @click='reset'>
				<i class="fa fa-eraser"></i>
			</button>
			<button type="button" class="btn btn-warning btn-icon btn-round" data-toggle="tooltip" 
					title="Cancelar y regresar" @click="redirect_back(route_list)">
				<i class="fa fa-ban"></i>
			</button>
			<button type="button" class="btn btn-success btn-icon btn-round" data-toggle="tooltip" 
					title="Guardar registro" @click="createRecord">
				<i class="fa fa-save"></i>
			</button>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				record: {
					approved_at: '',
					institution_id: '',
					document: '',
					description: ''
				},
				institutions: [],
				specific_actions: [],
				accounts: [{
					id: '',
					text: 'Seleccione...'
				}],
				/*
				 * Variables para cuentas a agregar en créditos adicionales, traspasos y reducciones
				 */
				from_budget_specific_action_id: '',
				from_budget_account_id: '',
				from_amount: 0,
				/*
				 * Variables para cuentas a agregar en traspasos
				 */
				to_budget_specific_action_id: '',
				to_budget_account_id: '',
				to_amount: 0,
				errors: [],
				/** set localStorage budget_modification_accounts */
                set budget_modification_accounts(value) {
                    localStorage.budget_modification_accounts = value;
                },
                /** get localStorage budget_modification_accounts */
                get budget_modification_accounts() {
                    let storage = JSON.parse(localStorage.budget_modification_accounts || '[]');
                    return storage;
                }
			}
		},
		props: {
			aditional_credit: {
				type: Boolean,
				required: false,
				default: false
			},
			reduction: {
				type: Boolean,
				required: false,
				default: false
			},
			transfer: {
				type: Boolean,
				required: false,
				default: false
			}
		},
		mounted() {
			const vm = this;

			axios.get('/budget/get-group-specific-actions/' + vm.execution_year).then(response => {
				if (!$.isEmptyObject(response.data)) {
					vm.specific_actions = response.data;
				}
				else {
					console.log("no")
				}
			}).catch(error => {
				console.log(error);
			});

			vm.reset();

			$("#approved_at").on('change', function() {
				vm.record.approved_at = $(this).val();
			});
		},
		watch: {
			/** 
			 * Monitorea modificaciones a las cuentas agregadas para guardarlas 
			 * temporalmente en un localStorage
			 */
			budget_modification_accounts: {
				deep: true,
				handler: function() {
					if (this.budget_modification_accounts.length === 0) {
						localStorage.removeItem('budget_modification_accounts');
					}
					else {
						localStorage.budget_modification_accounts = JSON.stringify(this.budget_modification_accounts);
					}
				}
			}
		},
		methods: {
			/**
			 * Inicializa las variables de las cuentas a agregar
			 *
			 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
			 */
			reset: function() {
				this.from_budget_specific_action_id = '';
				this.from_budget_account_id = '';
				this.from_amount = 0;
			},
			/**
			 * Agrega una cuenta para el registro del crédito adicional
			 *
			 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
			 * @return {boolean} Devuelve falso si no se ha indicado alguna información requerida
			 */
			addAccount: function() {
				const vm = this;
				let to_add = {
					spac_description: '',
					code: '',
					description: '',
					amount: 0,
					from_budget_account_id: '',
					from_budget_specific_action_id: ''
				};

				if (!vm.from_budget_specific_action_id) {
					vm.showMessage(
						'custom', 'Alerta!', 'danger', 'screen-error', 
						'Debe seleccionar una acción específica'
					);
					return false;
				}
				if (!vm.from_budget_account_id) {
					vm.showMessage(
						'custom', 'Alerta!', 'danger', 'screen-error', 
						'Debe seleccionar una cuenta presupuestaria'
					);
					return false;
				}
				if (vm.from_amount <= 0) {
					vm.showMessage(
						'custom', 'Alerta!', 'danger', 'screen-error', 
						'Debe indicar un monto'
					);
					return false;
				}

				
				/** Obtiene datos de la acción específica seleccionada */
				axios.get('/budget/detail-specific-actions/' + vm.from_budget_specific_action_id).then(response => {
					if (response.data.result) {
						let record = response.data.record;
						to_add.spac_description = record.specificable.code + " - " + record.code + 
													 " | " + record.name;
					}
				}).catch(error => {
					console.log(error);
				});

				/** Obtiene datos de la cuenta presupuestaria */
				axios.get('/budget/detail-accounts/' + vm.from_budget_account_id).then(response => {
					console.log(response.data.result)
					if (response.data.result) {
						let record = response.data.record;
						to_add.code = record.group + "." + record.item + "." + record.generic + "." + 
										 record.specific + "." + record.subspecific;
						to_add.description = response.data.record.denomination;
					}
				}).catch(error => {
					console.log(error);
				});
				
				to_add.from_amount = vm.from_amount;
				to_add.from_budget_account_id = vm.from_budget_account_id;
				to_add.from_budget_specific_action_id = vm.from_budget_specific_action_id;
				
				vm.budget_modification_accounts.push(to_add);
				$('.close').click();
				vm.reset();
			},
			/**
			 * Elimina una cuenta del listado de cuentas agregadas
			 *
			 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
			 * @param  {integer} index Índice del elemento a eliminar
			 */
			deleteAccount(index) {
				let vm = this;
				bootbox.confirm({
					title: "Eliminar cuenta?",
					message: `Esta seguro de eliminar esta cuenta del registro de la modificación 
							  presupuestaria?`,
					buttons: {
						cancel: {
							label: '<i class="fa fa-times"></i> Cancelar'
						},
						confirm: {
							label: '<i class="fa fa-check"></i> Confirmar'
						}
					},
					callback: function (result) {
						if (result) {
							vm.budget_modification_accounts.splice(index, 1);
						}
					}
				});
			},
			/**
			 * Obtiene el listado de cuentas resupuestarias a mostrar para su selección
			 *
			 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
			 */
			getAccounts: function() {
				const vm = this;
				vm.accounts = [{
					id: '',
					text: 'Seleccione...'
				}];

				axios.get('/budget/accounts/egress-list/').then(response => {
					if (!$.isEmptyObject(response.data.records)) {
						$.each(response.data.records, function() {
							if (this.specific !== "00") {
								if (vm.from_budget_specific_action_id) {
									axios.get('/budget/get-availability-opened-accounts/' + vm.from_budget_specific_action_id + "/" + this.id)
										 .then(response => {
										 	if (response.data.result) {
										 		console.log(response.data.account)
										 	}
										 }).catch(error => {
										 	console.log(error);
										 });
								}
								vm.accounts.push({
									id: this.id,
									text: this.code + " - " + this.denomination,
									title: 'Disponible: '
								});
							}
						});
					}
				}).catch(error => {
					console.log(error);
				});
			}
		}
	};
</script>