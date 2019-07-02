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
			<table class="table">
				<tbody>
					<tr class="row">
						<div class="col-5">
							<h4><label class="control-label">Presupuestales</label></h4>
							<select2 :options="budgetOptions" v-model="budgetSelect"
										data-toggle="tooltip"
										title="Seleccione una cuenta presupuestal"></select2>
						</div>
						<div class="col-5">
							<h4><label class="control-label">Patrimoniales</label></h4>
							<select2 :options="accountingOptions" v-model="accountingSelect"
										data-toggle="tooltip"
										title="Seleccione una cuenta patrimonial"></select2>
						</div>
						<div class="col-2">
							<button class="btn btn-success btn-sm btn-icon btn-action"
									style="margin-top:4.5rem !important;" 
									data-toggle="tooltip"
									v-on:click="addToConvertions()"
									title="Agregar cuentas al listado de cuentas a convertir"
									><i class="fa fa-plus"></i></button>
						</div>
					</tr>
				</tbody>
			</table>
			<br>
			<div>
				<v-client-table :columns="columns" :data="AccountToConverters" :options="table_options">
					
					<div slot="BudgetAccounts" slot-scope="props" class="text-center">
						{{ props.row.budget.text }}
					</div>
					<div slot="AccountingAccounts" slot-scope="props" class="text-center">
						{{ props.row.accounting.text }}
					</div>
					<div slot="id" slot-scope="props" class="text-center">
						<button @click="removeToConvertions(props.index)" 
								class="btn btn-danger btn-xs btn-icon btn-action" 
								title="Eliminar registro de la lista de cuentas a convertir"
								data-toggle="tooltip">
							<i class="fa fa-trash-o"></i>
						</button>
					</div>
				</v-client-table>
				<div align="right">
					<button class="btn btn-success btn-icon"
							data-toggle="tooltip" 
							title="Guardar registros"
							v-on:click="saveConvertions()"
							v-if="AccountToConverters.length > 0">
						<i class="fa fa-save"></i>
					</button>
					<button class="btn btn-success btn-icon"
							data-toggle="tooltip" 
							title="Guardar registros"
							disabled="" 
							v-else>
						<i class="fa fa-save"></i>
					</button>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default{
		props:['accounting_list','budget_list'],
		data(){
			return{
				errors:[],
				columns: ['BudgetAccounts', 'AccountingAccounts', 'id'],
				AccountToConverters:[],
				budgetOptions:[],
				accountingOptions:[],
				budgetSelect:'',
				accountingSelect:'',
			}
		},
		created() {
			this.table_options.headings = {
				'BudgetAccounts': 'CUENTAS PRESUPUESTALES',
				'AccountingAccounts': 'CUENTAS PATRIMONIALES',
				'id': 'ACCIÓN'
			};
		},
		mounted(){
			this.budgetOptions = this.budget_list;
			this.accountingOptions = this.accounting_list;
		},
		methods:{
			/**
			* Agrega la información de la cuenta patrimonial y presupuestal seleccionada y las carga al listado de cuentas por convertir
			*
			* @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
			*/
			addToConvertions:function() {
				if (this.budgetSelect != '' && this.accountingSelect != '') {
					var tempBudget = null;
					var tempAccounting = null;

					for (var i = 0; i < this.budgetOptions.length; i++) {
						if(this.budgetOptions[i].id == this.budgetSelect){
							tempBudget = this.budgetOptions.splice(i,1)[0];
							break;
						}
					}
					for (var i = 0; i < this.accountingOptions.length; i++) {
						if(this.accountingOptions[i].id == this.accountingSelect){
							tempAccounting = this.accountingOptions.splice(i,1)[0];
							break;
						}
					}
					this.AccountToConverters.push({
						budget:tempBudget,
						accounting:tempAccounting
					});
					this.budgetSelect = '';
					this.accountingSelect = '';
				}else{
					this.errors = [];
					this.errors.push('Los campos de selección de cuenta son obligatorios');
				}
			},
			/**
			 * Remueve el registro de la lista de cuentas a convertir
			 *
			 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
			 * @param {int} $indexToConvertion [posición en el array de cuentas a convertir]
			*/
			removeToConvertions:function(indexToConvertion){
				// elimina registro del listado de cuentas a convertir
				var temp = this.AccountToConverters.splice(indexToConvertion-1, 1);
				// agrega las cuentas a las opciones de cuentas disponibles en los selects
				this.budgetOptions.splice(1, 0, temp[0].budget);
				this.accountingOptions.splice(1, 0, temp[0].accounting);
			},

			/**
			 * enviar la información de las cuentas a convertir para ser almacenada
			 *
			 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
			 * @param {int} $indexToConvertion [posición en el array de cuentas a convertir]
			*/
			saveConvertions:function(){
				const vm = this;
				axios.post('/accounting/converter',{'records':this.AccountToConverters})
					.then(response=>{
						this.AccountToConverters = [];
						vm.showMessage('store');
						setTimeout(function() {
								window.location.href = 'http://'+window.location.host+'/accounting/converter';
							}, 2000);
					});
			},
		}
	}
</script>
