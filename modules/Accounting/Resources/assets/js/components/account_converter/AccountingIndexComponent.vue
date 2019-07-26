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
			<div class="card-body">
				<div class="row">
					<div class="col-2"></div>
					<div class="col-3">
						<label for="sel_budget_acc" class="control-label">Por Presupuestos</label>
						<br>
							<input type="radio" 
									name="sel_account_type"
									id="sel_budget_acc"
									data-on-label="SI" data-off-label="NO" 
									class="form-control bootstrap-switch sel_pry_acc">
					</div>
					<div class="col-3">
						<label for="sel_account_type" class="control-label">Por Patrimonial</label>
						<br>
							<input type="radio"
									name="sel_account_type" 
									id="sel_accounting_acc"
									checked="true" 
									data-on-label="SI" data-off-label="NO" 
									class="form-control bootstrap-switch sel_pry_acc">
					</div>
					<div class="col-3">
						<label for="" class="control-label">Seleccionar todos</label>
						<br>
						<input type="checkbox"
									name="sel_account_type" 
									id="sel_all_acc"
									data-on-label="SI" data-off-label="NO" 
									class="form-control bootstrap-switch sel_pry_acc sel_all_acc_class">
					</div>
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
							<select2 id="sel_acc_init" :options="accountOptions[0]" v-model="accountSelect.init_id"></select2>
						</div>
						<div class="col-5">
							<span>hasta</span>
							<select2 id="sel_acc_end" :options="accountOptions[1]" v-model="accountSelect.end_id"></select2>
						</div>
				</div>
				<br>
				<div class="card-footer text-right">
					<button class="btn btn-info btn-xs"
							:disabled="!searchActive"
							title="Consultar Registros"
							data-toggle="tooltip"
							v-on:click="getRecords()">
							Buscar
						<i class="fa fa-search"></i>
					</button>
				</div>
				<div class="row">
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
							<div slot="id" slot-scope="props" class="text-center">
								<button class="btn btn-warning btn-xs btn-icon btn-action"
										title="Modificar registro"
										data-toggle="tooltip"
										v-on:click="editForm(props.row.id)">
									<i class="fa fa-edit"></i>
								</button>
								<button class="btn btn-danger btn-xs btn-icon btn-action" 
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
	</div>
</template>
<script>
	export default{
		data(){
			return{
				errors:[],
				records:[],
				budgetAccounts:null,
				accountingAccounts:null,
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

			/** Se realiza la primera busqueda en base a cuentas patrimoniales para los selects */
			this.getAllRecords_selects_vuejs('getAllRecordsAccounting_vuejs', 'accounting', false);
		},
		mounted(){
			/** 
			 * Evento para determinar los datos a requerir segun la busqueda seleccionada
			 */
			const vm = this;
			$('.sel_pry_acc').on('switchChange.bootstrapSwitch', function(e) {
				console.log(e.target.id)
				if (e.target.id === "sel_budget_acc") {
					vm.getAllRecords_selects_vuejs('getAllRecordsBudget_vuejs', 'budget', true);
				}
				else if (e.target.id === "sel_accounting_acc") {
					vm.getAllRecords_selects_vuejs('getAllRecordsAccounting_vuejs', 'accounting', false);
				}else if(e.target.id === "sel_all_acc"){
					if (vm.accountSelect.type == 'budget') {
						vm.getAllRecords_selects_vuejs('getAllRecordsBudget_vuejs', 'budget', true);		
					}else{
						vm.getAllRecords_selects_vuejs('getAllRecordsAccounting_vuejs', 'accounting', false);
					}

					if (!$('#sel_all_acc').prop('checked')) {
						vm.accountSelect.init_id = '';
						vm.accountSelect.end_id = '';
					}
				}
			});
		},
		methods:{

			/**
			* Asigna los valores a las variables de los selects
			*
			* @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
			*/
			setValues:function(records, type_select, type_search){

				this.accountOptions = [[],[]];
				this.accountOptions[0] = records;
				this.accountOptions[1] = records;

				this.searchBudgetAccount = type_search;
				this.accountSelect.type = type_select;
				this.searchActive = true;

				if (type_select == 'accounting') {
					this.accountingAccounts = records;
				}
				if (type_select == 'budget') {
					this.budgetAccounts = records;
				}
				this.accountSelect.init_id = records[1].id;
				this.accountSelect.end_id = records[records.length-1].id;

			},

			/**
			* varifica y realiza la consulta de las cuentas de ser necesario
			*
			* @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
			*/
			getAllRecords_selects_vuejs:function(name_func, type_select, type_search){

				/** Array que almacenara los registros de las cuentas para los selects */
				var records = null;

				/** Boolean que determina si es necesario realizar la consulta de los registros */
				var query = true;

				if (type_select == 'accounting' && this.accountingAccounts != null) {
					records = this.accountingAccounts;
					query = false;
				}
				else if (type_select == 'budget' && this.budgetAccounts != null) {
					records = this.budgetAccounts;
					query = false;
				}

				if (query) {
					axios.post('/accounting/converter/'+name_func).then(response=>{
						this.setValues(response.data.records, type_select, type_search);
					});
				}else{
					this.setValues(records, type_select, type_search);
				}
			},

			/**
			* Obtiene los registros de las cuentas que tienen conversión activa 
			*
			* @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
			*/
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

						this.errors = [];
					});
				}else{
					this.errors = [];
					this.errors.push('Los campos de selección de cuenta son obligatorios');
				}
			},
		}
	}
</script>
