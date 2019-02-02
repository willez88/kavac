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
								   data-target="#add_account">
									<i class="fa fa-plus-circle"></i>
								</a>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(account, index) in aditional_credit_accounts">
							<td>{{ account.spac_description }}</td>
							<td>{{ account.code }}</td>
							<td>{{ account.description }}</td>
							<td class="text-right">{{ account.amount }}</td>
							<td class="text-center">
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
							Agregar Cuenta
						</h6>
					</div>
					<div class="modal-body">
						<div class="alert alert-danger" v-if="errors.length > 0">
							<ul>
								<li v-for="error in errors">{{ error }}</li>
							</ul>
						</div>
						<div class="row">
							<div class="col-12">
								<div class="form-group is-required">
									<label>Acción Específica:</label>
									<select2 :options="specific_actions" @input="getAccounts" 
											 v-model="budget_specific_action_id"/>
			                    </div>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
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
										   title="Indique el monto a asignar para la cuenta seleccionada" v-model="amount">
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
				specific_actions: [],
				accounts: [{
					id: '',
					text: 'Seleccione...'
				}],
				budget_specific_action_id: '',
				budget_account_id: '',
				amount: 0,
				aditional_credit_accounts: [],
				errors: [],
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
		},
		watch: {
		},
		methods: {
			reset: function() {

			},
			addAccount: function() {
				const vm = this;
				axios.get('/budget/detail-specific-actions/' + vm.budget_specific_action_id).then(response => {
					if (response.data.result) {
						var record = response.data.record;
						vm.aditional_credit_accounts.push({
							spac_description: record.specificable.code + " - " + record.code + " | " + record.name,
							code: '',
							description: '',
							amount: vm.amount
						});
					}
				}).catch(error => {});
			},
			deleteAccount(index) {

			},
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
								vm.accounts.push({
									id: this.id,
									text: this.code + " - " + this.denomination
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