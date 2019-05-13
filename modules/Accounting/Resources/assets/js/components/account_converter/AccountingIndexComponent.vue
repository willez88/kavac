<template>
	<div class="form-horizontal">
		<div class="card-body">
			<div class="alert alert-danger" role="alert" v-if="errors.length > 0">
				<div class="container">
					<div class="alert-icon">
						<i class="now-ui-icons objects_support-17"></i>
					</div>
					<strong>Cuidado!</strong> Debe verificar los siguientes errores antes de continuar:
					<ul>
						<li v-for="error in errors">{{ error }}</li>
					</ul>
				</div>
			</div>
			<div class="row">
				<div class="col-3"></div>
				<div class="col-3">
					<label for="" class="control-label">Por Presupuestos
						<input type="radio" 
								name="sel_account_type"
								id="sel_budget_acc"
								data-on-label="SI" data-off-label="NO" 
								class="form-control bootstrap-switch sel_pry_acc">
					</label>
				</div>
				<div class="col-3">
					<label for="" class="control-label">Por Patrimonial
						<input type="radio"
								name="sel_account_type" 
								id="sel_accounting_acc"
								data-on-label="SI" data-off-label="NO" 
								class="form-control bootstrap-switch sel_pry_acc">
					</label>
				</div>
				<div class="col-3"></div>
				<br>
					<div class="col-4"></div>

					<div class="col-4">
						<label v-if="searchActive && searchBudgetAccount"
								class="control-label text-center">
							<h4>Cuentas Presupuestales</h4>
						</label>
						<label v-else-if="searchActive && !searchBudgetAccount"
								class="control-label text-center">
							<h4>Cuentas Patrimoniales</h4>
						</label>
						<label v-else
								class="control-label text-center">
						</label>
					</div>
					<div class="col-4"></div>

					<div class="col-5">
						<span>desde</span>
						<select2 :disabled="!searchActive" :options="accountOptions[0]" v-model="accountSelect.init_id"></select2>
					</div>
					<div class="col-5">
						<span>hasta</span>
						<select2 :disabled="!searchActive" :options="accountOptions[1]" v-model="accountSelect.end_id"></select2>
					</div>
					<div class="col-2 text-center">
						<button class="btn btn-success btn-round"
								:disabled="!searchActive"
								style="margin-top:0.8rem !important;" 
								title="Consultar registros"
								data-toggle="tooltip"
								v-on:click="getRecords()">Consultar</button>
					</div>
				<div class="col-12">
					<v-client-table :columns="columns" :data="records" :options="table_options">
						
						<div slot="codeBudget" slot-scope="props" class="text-center">
							{{ props.row.budget_account.group+'.'+
								props.row.budget_account.item+'.'+
								props.row.budget_account.generic+'.'+
								props.row.budget_account.specific+'.'+
								props.row.budget_account.subspecific }}
						</div>
						<div slot="BudgetAccounts" slot-scope="props" class="text-center">
							{{ props.row.budget_account.denomination }}
						</div>
						<div slot="codeAccounting" slot-scope="props" class="text-center">
							{{ props.row.accounting_account.group+'.'+
								props.row.accounting_account.subgroup+'.'+
								props.row.accounting_account.item+'.'+
								props.row.accounting_account.generic+'.'+
								props.row.accounting_account.specific+'.'+
								props.row.accounting_account.subspecific }}
						</div>
						<div slot="AccountingAccounts" slot-scope="props" class="text-center">
							{{ props.row.accounting_account.denomination }}
						</div>

						<!-- <div slot="status" slot-scope="props" class="text-center">
							<div v-if="props.row.active">
								<span class="badge badge-success"><strong>Activa</strong></span>
							</div>
							<div v-else>
								<span class="badge badge-warning"><strong>Inactiva</strong></span>
							</div>
						</div> -->
						<div slot="id" slot-scope="props" class="text-center">
							<button class="btn btn-warning btn-xs btn-icon btn-action btn-round"
									title="Modificar registro"
									data-toggle="tooltip"
									v-on:click="editForm(props.row.id)">
								<i class="fa fa-edit"></i>
							</button>
							<button class="btn btn-danger btn-xs btn-icon btn-action btn-round" 
									title="Eliminar registro de la lista de cuentas a convertir"
									data-toggle="tooltip"
									v-on:click="deleteRecord(props.index,'/accounting/converter')">
								<i class="fa fa-trash-o"></i>
							</button>
						</div>
					</v-client-table>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
	export default{
		props:['budget_accounts','accounting_accounts'],
		data(){
			return{
				errors:[],
				records:[],
				budgetAccounts:[],
				accountingAccounts:[],
				// columns: ['codeBudget', 'BudgetAccounts','codeAccounting', 'AccountingAccounts', 'status','id'],
				columns: ['codeBudget', 'BudgetAccounts','codeAccounting', 'AccountingAccounts','id'],
				accountOptions:[[],[]],
				accountSelect:{
								init_id:'',
								end_id:'',
								type:'budget',
							 },
				searchActive:false,
				searchBudgetAccount:true, //true: para cuentas presupuestales, false para cuentas patrimoniales
				convertionId:null,
			}
		},
		created() {
			this.table_options.headings = {
				'codeBudget': 'CÓDIGO PRESUPUESTAL',
				'BudgetAccounts': 'DENOMINACIÓN',
				'codeAccounting': 'CÓDIGO PATRIMONIAL',
				'AccountingAccounts': 'DENOMINACIÓN',
				'id': 'ACCIÓN'
			};
			this.table_options.sortable = ['codeBudget', 'BudgetAccounts',
											'codeAccounting', 'AccountingAccounts'];
			this.table_options.filterable = ['BudgetAccounts', 'AccountingAccounts'];
		},
		mounted(){
			this.budgetAccounts = this.budget_accounts;
			this.accountingAccounts = this.accounting_accounts;
			/** 
			 * Evento para determinar los datos a requerir segun la busqueda seleccionada
			 */
			const vm = this;
			$('.sel_pry_acc').on('switchChange.bootstrapSwitch', function(e) {
				if (e.target.id === "sel_budget_acc") {
					// se carga la información de las cuentas presupuestales en los selects
					vm.accountOptions = [[],[]];
					vm.accountOptions[0] = vm.budget_accounts;
					vm.accountOptions[1] = vm.budget_accounts;
					vm.searchBudgetAccount = true;
					vm.accountSelect.type = 'budget';
					vm.searchActive = true;
				}
				else if (e.target.id === "sel_accounting_acc") {
					// se carga la información de las cuentas patrimoniales en los selects
					vm.accountOptions = [[],[]];
					vm.accountOptions[0] = vm.accounting_accounts;
					vm.accountOptions[1] = vm.accounting_accounts;
					vm.searchBudgetAccount = false;
					vm.accountSelect.type = 'accounting';
					vm.searchActive = true;
				}
			});
		},
		methods:{
			getRecords:function(){
				if (this.accountSelect.init_id != '' && this.accountSelect.end_id != '') {
					var aux1 = this.accountSelect.init_id, aux2 = this.accountSelect.end_id;

					this.accountSelect.init_id = (aux1 > aux2) ? aux2 : aux1;
					this.accountSelect.end_id = (aux1 > aux2) ? aux1 : aux2;

					axios.post('/accounting/converter/get-Records',this.accountSelect)
					.then(response=>{
						this.records = [];
						this.records = response.data.records;

						if (this.records.length == 0) {
							this.errors = [];
							this.errors.push('No se encontraron registros de conversiones en el rango dado');		
						}
						this.accountSelect.init_id = '';
						this.accountSelect.end_id = '';
					});
				}else{
					this.errors = [];
					this.errors.push('Los campos de selección de cuenta son obligatorios');
				}
			},
		}
	}
</script>
