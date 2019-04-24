<template>
<div>
	<table class="table table-formulation">
		<thead>
			<tr>
				<th class="text-uppercase">CÓDIGO DE CUENTA - DENOMINACIÓN</th>
				<th class="text-uppercase">DEBE</th>
				<th class="text-uppercase">HABER</th>
				<th class="text-uppercase">ACCIÓN</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="record in recordsAccounting">
				<td>
					<select2 :options="accounting_accounts" v-model="record.id" @input="changeSelectinTable(record)"></select2>
				</td>
				<td>
					<input type="text" data-toggle="tooltip" class="form-control input-sm" step=0.01 v-model="record.debit" @change="CalculateTot()">
				</td>
				<td>
					<input type="text" data-toggle="tooltip" class="form-control input-sm" step=0.01 v-model="record.assets" @change="CalculateTot()">
				</td>
				<td>
					<div class="text-center">
						<button @click="deleteAccount(recordsAccounting.indexOf(record)-1)" 
							class="btn btn-danger btn-xs btn-icon btn-action btn-round" 
							title="Eliminar registro" data-toggle="tooltip">
							<i class="fa fa-trash-o"></i>
						</button>
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>
					<select2 :disabled="!enableInput" :options="accounting_accounts" v-model="optionIdAcc" @input="addAccountingAccount()"></select2>
				</td>
				<td>
					<div class="form-group text-center">Total Debe:
						<h6>
							<span v-if="data.totDebit.toFixed(2) == data.totAssets.toFixed(2)" style="color:#18ce0f;">
								<strong>{{ data.totDebit.toFixed(2) }}</strong>
							</span>
							<span v-else style="color:#FF3636;">
								<strong>{{ data.totDebit.toFixed(2) }}</strong>
							</span>
						</h6>
					</div>
				</td>
				<td>
					<div class="form-group text-center">Total Haber:
						<h6>
							<span v-if="data.totDebit.toFixed(2) == data.totAssets.toFixed(2)"
								style="color:#18ce0f;">
								<strong>{{ data.totAssets.toFixed(2) }}</strong>
							</span>
							<span v-else style="color:#FF3636;">
								<strong>{{ data.totAssets.toFixed(2) }}</strong>
							</span>
						</h6>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
	<div class="card-footer text-right">
		<a :href="urlPrevious" class="btn btn-warning btn-icon btn-round"
			data-toggle="tooltip"
			title="Cancelar y regresar">
			<i class="fa fa-ban"></i>
		</a>
		<button class="btn btn-success btn-icon btn-round"
				data-toggle="tooltip"
				title="Guardar registro"
				id="save"
				:disabled="!enableInput" 
				v-on:click="AddSeating()">
				<i class="fa fa-save"></i>
		</button>
	</div>
</div>
</template>
<script>
	export default{
		props:['accounting_accounts'],
		data(){
			return{
				errors:[],
				recordsAccounting: [],
				recordsBudget:[],
				columns: ['code', 'debit', 'assets', 'id'],
				urlPrevious:'http://'+window.location.host+'/accounting/seating',
				data:{
					date:'',
					reference:'',
					concept:'',
					observations:'',
					totDebit:0,
					totAssets:0,
				},
				enableInput:false,
				accountingOptions:[],
				optionIdAcc:'',
				optionIdBudget:'',
			}
		},
		created(){
			this.table_options.headings = {
				'code': 'CÓDIGO PATRIMONIAL - DENOMINACIÓN',
				'debit': 'BEDE',
				'assets': 'HABER',
				'id': 'ACCIÓN'
			};
			this.optionIdAcc = '';
			EventBus.$on('enableInput:seating-account',(data)=>{
				this.enableInput = data.value;
				this.data.date = data.date;
				this.data.reference = data.reference;
				this.data.concept = data.concept;
				this.data.observations = data.observations;
			});
			EventBus.$on('request:budgetToAccount', (data)=>{
				// 
			});
		},
		beforeDestroy(){
            this.$EventBus.$off('enableInput:seating-account');
            this.$EventBus.$off('request:budgetToAccount');
        },
		methods:{
			changeSelectinTable:function(record) {
				// si asigna un select en vacio, vacia los valores del debe y haber de esa fila
				if (record.id == '') {
					record.debit = 0;
					record.assets = 0;
					this.CalculateTot();
				}
			},
			CalculateTot:function(){
				this.data.totDebit = 0;
				this.data.totAssets = 0;
				for (var i = this.recordsAccounting.length - 1; i >= 0; i--) {
					if (this.recordsAccounting[i].id != '') {
						this.data.totDebit += (this.recordsAccounting[i].debit!='')?parseFloat(this.recordsAccounting[i].debit):0;
						this.data.totAssets += (this.recordsAccounting[i].assets!='')?parseFloat(this.recordsAccounting[i].assets):0;
					}
				}
			},
			addAccountingAccount:function() {
				if (this.optionIdAcc != '') {
					for (var i = this.accounting_accounts.length - 1; i >= 0; i--) {
						if (this.accounting_accounts[i].id == this.optionIdAcc){
							this.recordsAccounting.push({
								id:this.optionIdAcc,
								debit:0,
								assets:0,
							});
							break;
						}
					}
				}else{
					EventBus.$emit('show:errors',['Debe seleccionar una cuenta para poder agregarla al asiento.']);
				}
				this.optionIdAcc = '';
			},
			AddSeating:function(){
				// console.log(this.data.totDebit,this.data.totAssets)
				if (this.data.totDebit == this.data.totAssets) {
					const vm = this;
					axios.post('/accounting/seating',{'data':this.data,
													  'accountingAccounts':this.recordsAccounting
					}).then(response=>{
						vm.showMessage('store');
						setTimeout(function() {
							location.href = vm.urlPrevious;
						}, 1500);
					}).catch(error=>{
						var errors = [];
						if (typeof(error.response) !="undefined") {
							for (var index in error.response.data.errors) {
								if (error.response.data.errors[index]) {
									errors.push(error.response.data.errors[index][0]);
								}
							}
						}
						EventBus.$emit('show:errors',errors);
					});
				}else{
					EventBus.$emit('show:errors',['Los totales no coinciden, Por favor verifique.']);
				}
			},
			deleteAccount:function(index){
				this.recordsAccounting.splice(index-1,1);
				this.CalculateTot();
			},
		},
	}
</script>