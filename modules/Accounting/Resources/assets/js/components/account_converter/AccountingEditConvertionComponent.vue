<template>
	<div class="form-horizontal">
		<div class="card-body">
			<div class="alert alert-danger" role="alert" v-if="existErrors">
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
				<div class="col-1"></div>
				<div class="col-5">
					<h4>Cuentas Presupuestales</h4>
					<select2 :options="accountOptions[0]" v-model="accountSelect.budget_account_id" 
					data-toggle="tooltip" title="Cuentas Presupuestales"></select2>
				</div>
				<div class="col-5">
					<h4>Cuentas Patrimoniales</h4>
					<select2 :options="accountOptions[1]" v-model="accountSelect.accounting_account_id"
					data-toggle="tooltip" title="Cuentas Patrimoniales"></select2>
				</div>
			</div>
		</div>
		<div class="card-footer text-right">
			<a :href="urlPrevious" class="btn btn-warning btn-icon"
					data-toggle="tooltip"
					title="Cancelar y regresar">
					<i class="fa fa-ban"></i>
			</a>
			<button class="btn btn-success btn-icon" 
					title="actualizar conversión"
					:disabled="accountSelect.budget_account_id == '' || accountSelect.accounting_account_id == ''"
					data-toggle="tooltip"
					v-on:click="update()"><i class="fa fa-save"></i></button>
		</div>
	</div>
</template>
<script>
	export default{
		props:['account_to_edit', 'accounting_accounts', 'budget_accounts'],
		data(){
			return{
				accountOptions:[[],[]],
				accountSelect:{
								budget_account_id:'',
								accounting_account_id:''
							 },
				urlPrevious:'http://'+window.location.host+'/accounting/converter',
			}
		},
		created(){
			this.accountOptions[0] = this.budget_accounts;
			this.accountOptions[1] = this.accounting_accounts;
			this.accountSelect.budget_account_id = this.account_to_edit.budget_account_id;
			this.accountSelect.accounting_account_id = this.account_to_edit.accounting_account_id;
		},
		methods:{
			/**
			 * Enviar la información de la conversión para ser actualizada
			 *
			 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
			*/
			update:function(){
				const vm = this;
				axios.put('/accounting/converter/'+this.account_to_edit.id,this.accountSelect)
				.then(response=>{
					vm.showMessage('update');
					window.location.href = this.urlPrevious;
					setTimeout(function() {
							location.href = vm.urlPrevious;
						}, 2000);
				});
			}
		},

	}
</script>