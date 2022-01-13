<template>
	<div class="pad-top-40">
		<h6 class="text-center card-title">Cuentas presupuestarias</h6>
		<div class="row">
			<div class="col-12 pad-top-20">
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
								   data-target="#add_account" v-if="approved_at">
									<i class="fa fa-plus-circle"></i>
								</a>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(account, index) in aditional_credit_accounts" :key="index">
							<td>{{ account.spac_description }}</td>
							<td>{{ account.code }}</td>
							<td>{{ account.description }}</td>
							<td class="text-right">{{ account.amount }}</td>
							<td class="text-center">
								<input type="hidden" name="budget_account_id[]" readonly
									   :value="account.budget_specific_action_id + '|' + account.budget_account_id">
								<input type="hidden" name="budget_account_amount[]" readonly
									   :value="account.amount">
								<a class="btn btn-sm btn-danger btn-action" href="javascript:void(0)" 
								   @click="deleteAccount(index)" title="Eliminar este registro" data-toggle="tooltip">
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
							Agregar Cuenta
						</h6>
					</div>
					<div class="modal-body">
						<div class="alert alert-danger" v-if="errors.length > 0">
							<ul>
								<li v-for="(error, index) in errors" :key="index">{{ error }}</li>
							</ul>
						</div>
						<div class="row">
							<div class="col-6">
								<div class="form-group is-required">
									<label>Acción Específica:</label>
									<select2 :options="specific_actions" @input="getAccounts"
											 v-model="budget_specific_action_id"/>
			                    </div>
							</div>
							<div class="col-6">
								<div class="form-group is-required">
									<label>Cuenta:</label>
									<select2 :options="accounts"
											 v-model="budget_account_id"/>
			                    </div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<div class="form-group is-required">
									<label>Monto:</label>
									<input type="number" class="form-control input-sm" data-toggle="tooltip"
										   title="Indique el monto a asignar para la cuenta seleccionada"
										   v-model="amount">
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
</template>

<script>
	export default {
		data() {
			return {
				approved_at: document.querySelector('#approved_at').value,
				specific_actions: [],
				accounts: [{
					id: '',
					text: 'Seleccione...'
				}],
				budget_specific_action_id: '',
				budget_account_id: '',
				amount: 0,
				/*aditional_credit_accounts: (localStorage.aditional_credit_accounts)
										   ? JSON.parse(localStorage.aditional_credit_accounts) : [],*/
				errors: [],
				/** set localStorage aditional_credit_accounts */
                set aditional_credit_accounts(value) {
                    localStorage.aditional_credit_accounts = value;
                },
                /** get localStorage aditional_credit_accounts */
                get aditional_credit_accounts() {
                    let storage = JSON.parse(localStorage.aditional_credit_accounts || '[]');
                    return storage;
                }
			}
		},
		mounted() {
			const vm = this;

			axios.get(`${window.app_url}/budget/get-group-specific-actions/${vm.execution_year}`).then(response => {
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
				vm.approved_at = $(this).val();
			});
		},
		watch: {
			/** Monitorea modificaciones a las cuentas agregadas para guardarlas temporalmente en un localStorage */
			aditional_credit_accounts: {
				deep: true,
				handler: function() {
					if (this.aditional_credit_accounts.length === 0) {
						localStorage.removeItem('aditional_credit_accounts');
					}
					else {
						localStorage.aditional_credit_accounts = JSON.stringify(this.aditional_credit_accounts);
					}
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
				this.budget_specific_action_id = '';
				this.budget_account_id = '';
				this.amount = 0;
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
					spac_description: '',
					code: '',
					description: '',
					amount: 0,
					budget_account_id: '',
					budget_specific_action_id: ''
				};

				if (!vm.budget_specific_action_id) {
					vm.showMessage(
						'custom', 'Alerta!', 'danger', 'screen-error',
						'Debe seleccionar una acción específica'
					);
					return false;
				}
				if (!vm.budget_account_id) {
					vm.showMessage(
						'custom', 'Alerta!', 'danger', 'screen-error',
						'Debe seleccionar una cuenta presupuestaria'
					);
					return false;
				}
				if (vm.amount <= 0) {
					vm.showMessage(
						'custom', 'Alerta!', 'danger', 'screen-error',
						'Debe indicar un monto'
					);
					return false;
				}


				/** Obtiene datos de la acción específica seleccionada */
				axios.get(
					`${window.app_url}/budget/detail-specific-actions/${vm.budget_specific_action_id}`
				).then(response => {
					if (response.data.result) {
						let record = response.data.record;
						to_add.spac_description = record.specificable.code + " - " + record.code + " | " + record.name;
					}
				}).catch(error => {
					console.log(error);
				});

				/** Obtiene datos de la cuenta presupuestaria */
				axios.get(`${window.app_url}/budget/detail-accounts/${vm.budget_account_id}`).then(response => {
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

				to_add.amount = vm.amount;
				to_add.budget_account_id = vm.budget_account_id;
				to_add.budget_specific_action_id = vm.budget_specific_action_id;

				vm.aditional_credit_accounts.push(to_add);
				$('.close').click();
				vm.reset();
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
					message: "Esta seguro de eliminar esta cuenta para el registro del crédito adicional?",
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
							vm.aditional_credit_accounts.splice(index, 1);
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
					text: 'Seleccione...'
				}];

				axios.get(`${window.app_url}/budget/accounts/egress-list/`).then(response => {
					if (!$.isEmptyObject(response.data.records)) {
						$.each(response.data.records, function() {
							if (this.specific !== "00") {
								var spActionId = vm.budget_specific_action_id;
								if (vm.budget_specific_action_id) {
									axios.get(
										`${window.app_url}/budget/get-availability-opened-accounts/${spActionId}/${this.id}`
									).then(response => {
										if (response.data.result) {
											console.log(response.data.account);
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
