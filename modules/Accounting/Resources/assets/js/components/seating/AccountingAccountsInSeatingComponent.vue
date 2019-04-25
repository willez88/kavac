<template>
<div>
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
						<button @click="deleteAccount(recordsAccounting.indexOf(record))" 
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
					<select2 :disabled="!enableInput" :options="accounting_accounts" id="select2" @input="addAccountingAccount()"></select2>
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
				v-if="seating == null"
				v-on:click="AddSeating()">
				<i class="fa fa-save"></i>
		</button>
		<button class="btn btn-success btn-icon btn-round"
				data-toggle="tooltip"
				title="Actualizar registro"
				id="update"
				:disabled="!enableInput"
				v-else
				v-on:click="EditSeating()">
				<i class="fa fa-save"></i>
		</button>
	</div>
</div>
</template>
<script>
	export default{
		props:['accounting_accounts','seating'],
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
					generated_by_id:'',
					totDebit:0,
					totAssets:0,
				},
				enableInput:false,
				accountingOptions:[],
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

			$('#select2').val('');

			EventBus.$on('enableInput:seating-account',(data)=>{
				this.enableInput = data.value;
				this.data.date = data.date;
				this.data.reference = data.reference;
				this.data.concept = data.concept;
				this.data.observations = data.observations;
				this.data.generated_by_id = data.generated_by_id;
			});
			// recibe un json con el id de cuenta presupuestal para agregar el registro con la
			// respectiva cuenta patrimonial
			//emisión:  EventBus.$emit('seating:budgetToAccount',{'id':id_budget,'debit':compromise_value});

			// data = id_budget
			EventBus.$on('seating:budgetToAccount', (data)=>{
				const vm = this;
				axios.get('/accounting/converter/budgetToAccount/'+data).then(response=>{
					$('#select2').val(response.data.record.id);
					vm.addAccountingAccount();
					// var pos = vm.recordsAccounting.length-1;
					// vm.recordsAccounting[pos].debit = data.debit;
					// vm.CalculateTot();
				});
			});
		},
		mounted(){
			if (this.seating != null) {
				for (var i = 0; i < this.seating.accounting_accounts.length; i++) {
					this.recordsAccounting.push({
						id:this.seating.accounting_accounts[i].accounting_account_id,
						id_seatAcc:this.seating.accounting_accounts[i].id,
						debit:this.seating.accounting_accounts[i].debit,
						assets:this.seating.accounting_accounts[i].assets,
					});
				}
				this.data.totDebit = parseFloat(this.seating.tot_debit);
				this.data.totAssets = parseFloat(this.seating.tot_assets);
			}
		},
		beforeDestroy(){
            this.$EventBus.$off('enableInput:seating-account');
            this.$EventBus.$off('request:budgetToAccount');
        },
		methods:{
			validateErrors:function() {
				if (this.recordsAccounting.length < 1) { return true; }
			},
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
				if ($('#select2').val() != '') {
					for (var i = this.accounting_accounts.length - 1; i >= 0; i--) {
						if (this.accounting_accounts[i].id == $('#select2').val()){
							this.recordsAccounting.push({
								id:$('#select2').val(),
								id_seatAcc:null,
								debit:0,
								assets:0,
							});
							$('#select2').val('');
							break;
						}
					}
				}
			},
			AddSeating:function(){
				if (this.data.totDebit == this.data.totAssets) {

					if (this.validateErrors()) { return ; }

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
						if (typeof(error.response) != "undefined") {
							for (var index in error.response.data.errors) {
								if (error.response.data.errors[index]) {
									errors.push(error.response.data.errors[index][0]);
								}
							}
						}
						this.errors = [];
						this.errors = errors;
					});
				}else{
					this.errors = [];
					this.errors.push('Los totales no coinciden, Por favor verifique.');
				}
			},
			EditSeating:function() {
				if (this.data.totDebit == this.data.totAssets){
					if (this.validateErrors()) { return ; }
					axios.put('/accounting/seating/'+this.seating.id, {'data':this.data,
														'accountingAccounts':this.recordsAccounting})
					.then(response=>{
						this.showMessage('update');
						const vm = this;
						setTimeout(function() {
							location.href = vm.route_list;
						}, 1500);
					});
				}
			},
			deleteAccount:function(index){
				this.recordsAccounting.splice(index,1);
				this.CalculateTot();
			},
		},
	}
</script>