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
					<div class="col-12 pad-top-20" v-if="!(type_modification==='TR')">
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
										   data-target="#add_account" 
										   v-if="record.approved_at && record.institution_id && 
										   record.document && record.description">
											<i class="fa fa-plus-circle"></i>
										</a>
									</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="(account, index) in modification_accounts">
									<td>{{ account.from_spac_description }}</td>
									<td>{{ account.from_code }}</td>
									<td>{{ account.from_description }}</td>
									<td class="text-right">{{ account.from_amount }}</td>
									<td class="text-center">
										<input type="hidden" name="from_account_id[]" readonly 
											   :value="account.from_specific_action_id + '|' + account.from_account_id">
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
					<div class="col-12 pad-top-20" v-else>
						<table class="table">
							<thead>
								<tr>
									<th colspan="4" class="border-right">
										Datos de Origen
									</th>
									<th colspan="4">
										Datos de Destino
									</th>
									<th>
										<a class="btn btn-sm btn-info btn-action btn-tooltip" href="#" 
										   data-original-title="Agregar nuevo registro" data-toggle="modal"  
										   data-target="#add_account" 
										   v-if="record.approved_at && record.institution_id && 
										   record.document && record.description">
											<i class="fa fa-plus-circle"></i>
										</a>
									</th>
								</tr>
								<tr>
									<th>Acción Específica</th>
									<th>Cuenta</th>
									<th>Descripción</th>
									<th class="border-right">Monto</th>
									<th>Acción Específica</th>
									<th>Cuenta</th>
									<th>Descripción</th>
									<th>Monto</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="(account, index) in modification_accounts">
									<td>{{ account.from_spac_description }}</td>
									<td>{{ account.from_code }}</td>
									<td>{{ account.from_description }}</td>
									<td class="text-right border-right">
										{{ account.from_amount }}
									</td>
									<td>{{ account.to_spac_description }}</td>
									<td>{{ account.to_code }}</td>
									<td>{{ account.to_description }}</td>
									<td class="text-right">{{ account.to_amount }}</td>
									<td class="text-center">
										<input type="hidden" name="from_account_id[]" readonly 
											   :value="account.from_specific_action_id + '|' + account.from_account_id">
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
									Agregar Cuenta{{ (type_modification==='TR') ? 's' : '' }}
								</h6>
							</div>
							<div class="modal-body">
								<div class="alert alert-danger" v-if="errors.length > 0">
									<ul>
										<li v-for="error in errors">{{ error }}</li>
									</ul>
								</div>
								<div class="row" v-if="(type_modification==='TR')">
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
											<select2 :options="specific_actions" 
													 v-model="from_specific_action_id"/>
					                    </div>
									</div>
									<div class="col-6">
										<div class="form-group is-required">
											<label>Cuenta:</label>
											<select2 :options="accounts" 
													 v-model="from_account_id"/>
					                    </div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-3">
										<div class="form-group is-required">
											<label>Monto:</label>
											<input type="number" onfocus="$(this).select()" 
												   class="form-control numeric" 
												   data-toggle="tooltip" 
												   title="Indique el monto a asignar para la cuenta seleccionada" v-model="from_amount">
										</div>
									</div>
								</div>
								<div v-if="(type_modification==='TR')">
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
												<select2 :options="specific_actions" 
														 v-model="to_specific_action_id"/>
						                    </div>
										</div>
										<div class="col-6">
											<div class="form-group is-required">
												<label>Cuenta:</label>
												<select2 :options="accounts" 
														 v-model="to_account_id"/>
						                    </div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-3">
											<div class="form-group is-required">
												<label>Monto:</label>
												<input type="number" class="form-control" 
													   data-toggle="tooltip" readonly 
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
			                		Agregar
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
					title="Guardar registro" @click="createRecord('budget/modifications')">
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
					type: '',
					approved_at: '',
					institution_id: '',
					document: '',
					description: '',
					budget_account_id: []
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
				from_specific_action_id: '',
				from_account_id: '',
				from_amount: 0,
				/*
				 * Variables para cuentas a agregar en traspasos
				 */
				to_specific_action_id: '',
				to_account_id: '',
				to_amount: 0,
				errors: [],
				modification_accounts: []
			}
		},
		props: {
			type_modification: {
				type: String,
				required: true,
			},
			edit_object: {
				type: String,
				required: false
			}
		},
		mounted() {
			const vm = this;

			axios.get(
				`${window.app_url}/budget/get-group-specific-actions/${window.execution_year}/true`
			).then(response => {
				if (!$.isEmptyObject(response.data)) {
					vm.specific_actions = response.data;
				}
			}).catch(error => {
				vm.logs('BudgetModificationComponent.vue', 263, error, 'mounted');
			});

			vm.reset();
			vm.getInstitutions();
			vm.getAccounts();
			vm.record.type = vm.type_modification;

			if (vm.edit_object) {
				vm.loadEditData();
			}
			/*if (typeof(localStorage.modification_accounts) !== "undefined") {
				vm.modification_accounts = JSON.parse(localStorage.modification_accounts);
			}*/
		},
		watch: {
			/** 
			 * Monitorea modificaciones a las cuentas agregadas para guardarlas 
			 * temporalmente en un localStorage
			 *
			 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
			 */
			modification_accounts: {
				deep: true,
				handler: function() {
					if (this.modification_accounts.length === 0) {
						localStorage.removeItem('modification_accounts');
					}
					else {
						this.record.budget_account_id = this.modification_accounts;
						localStorage.modification_accounts = JSON.stringify(
							this.modification_accounts
						);
					}
				}
			},
			/**
			 * Asigna el monto desde la cuenta de origen a la cuenta de destino en traspasos
			 *
			 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com> 
			 */
			from_amount: function() {
				if (this.type_modification === "TR") {
					this.to_amount = this.from_amount;
				}
			}
		},
		methods: {
			/**
			 * Inicializa las variables de las cuentas a agregar
			 *
			 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
			 */
			reset: function() {
				this.from_specific_action_id = '';
				this.from_account_id = '';
				this.from_amount = 0;
				this.to_specific_action_id = '';
				this.to_account_id = '';
				this.to_amount = 0;
			},
			/**
			 * Carga los datos para ser editados
			 *
			 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
			 */
			loadEditData: function() {
				let vm = this;
				let editData = JSON.parse(vm.edit_object);
				vm.record.approved_at = vm.format_date(editData.approved_at);
				vm.record.institution_id = editData.institution_id;
				vm.record.document = editData.document;
				vm.record.description = editData.description;

				let array_accounts = [];

				var from_add = {
					spac_description: '',
					code: '',
					description: '',
					amount: 0,
					account_id: '',
					specific_action_id: '',
				};

				var to_add = {
					spac_description: '',
					code: '',
					description: '',
					amount: 0,
					account_id: '',
					specific_action_id: '',
				};

				var i = 0;
				$.each(editData.budget_modification_accounts, function(index, account) {
					var sp = account.budget_sub_specific_formulation.specific_action;
					var spac_desc = `${sp.specificable.code} - ${sp.code} | ${sp.name}`;
					var acc = account.budget_account;
					var code = `${acc.group}.${acc.item}.${acc.generic}.${acc.specific}.${acc.subspecific}`;
					if (account.operation === "D") {
						from_add.spac_description = spac_desc;
						from_add.code = code;
						from_add.description = account.budget_account.denomination;
						from_add.amount = account.amount;
						from_add.account_id = acc.id;
						from_add.specific_action_id = sp.id;
					}
					else {
						to_add.spac_description = spac_desc;
						to_add.code = code;
						to_add.description = account.budget_account.denomination;
						to_add.amount = account.amount;
						to_add.account_id = acc.id;
						to_add.specific_action_id = sp.id;
					}
					
					if ((index % 2) === 1 || vm.type_modification !== "TR") {
						array_accounts[i] = {
							from_spac_description: from_add.spac_description,
							from_code: from_add.code,
							from_description: from_add.description,
							from_amount: from_add.amount,
							from_account_id: from_add.account_id,
							from_specific_action_id: from_add.specific_action_id,
							to_spac_description: to_add.spac_description,
							to_code: to_add.code,
							to_description: to_add.description,
							to_amount: to_add.amount,
							to_account_id: to_add.account_id,
							to_specific_action_id: to_add.specific_action_id,
						};
						i++;
					}

				});

				vm.modification_accounts = array_accounts;
			},
			/**
			 * Agrega una cuenta para el registro del crédito adicional
			 *
			 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
			 * @return {boolean} Devuelve falso si no se ha indicado alguna información requerida
			 */
			addAccount: function() {
				const vm = this;
				let to_add = {
					from_spac_description: '',
					from_code: '',
					from_description: '',
					from_amount: 0,
					from_account_id: '',
					from_specific_action_id: '',
					to_spac_description: '',
					to_code: '',
					to_description: '',
					to_amount: 0,
					to_account_id: '',
					to_specific_action_id: '',
				};

				if (!vm.from_specific_action_id) {
					vm.showMessage(
						'custom', 'Alerta!', 'danger', 'screen-error', 
						'Debe seleccionar una acción específica'
					);
					return false;
				}
				if (!vm.from_account_id) {
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
				axios.get(
					`${window.app_url}/budget/detail-specific-actions/${vm.from_specific_action_id}`
				).then(response => {
					if (response.data.result) {
						let spec = response.data.record;
						
						/** Obtiene datos de la cuenta presupuestaria */
						axios.get(
							`${window.app_url}/budget/detail-accounts/${vm.from_account_id}`
						).then(response => {
							if (response.data.result) {
								let acc = response.data.record;
								to_add.from_code = `${acc.group}.${acc.item}.${acc.generic}.${acc.specific}.${acc.subspecific}`;
								to_add.from_description = acc.denomination;
								to_add.from_spac_description = `${spec.specificable.code} - ${spec.code} | ${spec.name}`;
								to_add.from_amount = vm.from_amount;
								to_add.from_account_id = vm.from_account_id;
								to_add.from_specific_action_id = vm.from_specific_action_id;
								
								if (this.type_modification === "TR") {
									axios.get(
										`${window.app_url}/budget/detail-specific-actions/${vm.to_specific_action_id}`
									).then(response => {
										if (response.data.result) {
											let to_spec = response.data.record;

											/** Obtiene datos de la cuenta presupuestaria */
											axios.get(
												`${window.app_url}/budget/detail-accounts/${vm.to_account_id}`
											).then(response => {
												if (response.data.result) {
													let to_acc = response.data.record;
													to_add.to_code = `${to_acc.group}.${to_acc.item}.${to_acc.generic}.${to_acc.specific}.${to_acc.subspecific}`;
													to_add.to_description = to_acc.denomination;
													to_add.to_spac_description = `${to_spec.specificable.code} - ${to_spec.code} | ${to_spec.name}`;
													to_add.to_amount = vm.to_amount;
													to_add.to_account_id = vm.to_account_id;
													to_add.to_specific_action_id = vm.to_specific_action_id;
													vm.modification_accounts.push(to_add);

													$('.close').click();
													vm.reset();
												}
											}).catch(error => {
												console.log(error);
											});
										}
									}).catch(error => {
										console.log(error);
									});
								}
								else {
									vm.modification_accounts.push(to_add);
									$('.close').click();
									vm.reset();
								}

							}
						}).catch(error => {
							console.log(error);
						});
					}
				}).catch(error => {
					console.log(error);
				});
			},
			/**
			 * Elimina una cuenta del listado de cuentas agregadas
			 *
			 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
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
			 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
			 */
			getAccounts: function() {
				const vm = this;
				vm.accounts = [{
					id: '',
					text: 'Seleccione...',
					title: ''
				}];

				axios.get(`${window.app_url}/budget/accounts/egress-list/`).then(response => {
					if (!$.isEmptyObject(response.data.records)) {
						$.each(response.data.records, function() {
							if (this.specific !== "00") {
								vm.accounts.push({
									id: this.id,
									text: `${this.code} - ${this.denomination}`,
									title: 'Disponible: '
								});
							}
						});
					}
				}).catch(error => {
					vm.logs('BudgetModificationComponent.vue', 415, error, 'getAccounts');
				});
			},
		}
	};
</script>