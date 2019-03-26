<template>

	<div>
		<h2>Converción de cuentas</h2>
	<table>
		<tbody>
			<tr></tr>
			<tr v-for="item in listAvailable">
				<td>
					<div class="row">
						<div class="form-group col-5">
							<div v-show="!item.complete">
								<select2 :options="budgetAccountsList"
										v-model="budget_select"></select2>
							</div>
							<div v-show="item.complete">
								<label>{{item.budget_text}}</label>
							</div>
						</div>
						<div class="form-group col-5">
							<div v-show="!item.complete">
								<select2 :options="accountingAccountsList"
										v-model="accounting_select"></select2>
							</div>
							<div v-show="item.complete">
								<label>{{item.accounting_text}}</label>
							</div>
						</div>
						<div class="col-1">
							<div v-show="item.complete">
								<button class="btn btn-danger btn-sm btn-custom"
									title="Elimina fila a registrar" 
									v-on:click="deleteRow()">
									<i class="fa fa-trash"></i></button>
							</div>
							<div v-show="!item.complete">
								<button class="btn btn-success btn-sm btn-custom"
										title="Agregar campo para una nueva converción" 
										v-on:click="addRow()">
										<i class="fa fa-plus"></i></button>
							</div>
						</div>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
	</div>

</template>
<script>
export default{
	props:['budget_accounts','accounting_accounts'],
	data(){
		return{
			accountingAccountsList:[{id: 0, text: 'Seleccione una opción'}],
			budgetAccountsList:[{id: 0, text: 'Seleccione una opción'}],
			listToAdded:[],
			listAvailable:[{ 'budget_id':null,
					'budget_text':'',
					'accounting_id':null,
					'accounting_text':'',
					'complete':false}],
			budget_select:null,
			accounting_select:null,
		}
	},
	mounted(){
		this.budgetAccountsList = this.budget_accounts;
		this.accountingAccountsList = this.accounting_accounts;
	},
	methods:{
		addRow:function() {
			if (this.accounting_select && this.budget_select) {
				this.listAvailable[this.listAvailable.length-1].complete = true;
				this.listToAdded.push({ 'budget_id':null,
								 'budget_text':'',
								 'accounting_id':null,
								 'accounting_text':'',
								 'complete':false});
				this.budget_id = null;
				this.accounting_id = null;
			}
		},
		deleteRow:function() {
			// 
		}
	},
	watch:{
		budget_select:function(res){
			if (res) {
				this.listAvailable[this.listAvailable.length-1].budget_id = res.split('?')[0];
				this.listAvailable[this.listAvailable.length-1].budget_text = res.split('?')[1];
			}
		},
		accounting_select:function(res) {
			if (res) {
				this.listAvailable[this.listAvailable.length-1].accounting_id = res.split('?')[0];
				this.listAvailable[this.listAvailable.length-1].accounting_text = res.split('?')[1];
			}
		},
	}
}

</script>