<template>
	<div>
		<form @submit.prevent="" class="form-horizontal">
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
					<div class="col-4">
						<div class="form-group is-required">
							<label class="control-label">Fecha
							</label>
							<input type="date" class="form-control" v-model="data.date">
						</div>
					</div>
					<div class="col-4">
						<div class="form-group">
							<label class="control-label">Concepto
							</label>
							<input type="text" class="form-control" v-model="data.concept">
						</div>
					</div>
					<div class="col-4">
						<div class="form-group">
							<label class="control-label">Observaciones
							</label>
							<input type="text" class="form-control" v-model="data.observations">
						</div>
					</div>
					<div class="col-4">
						<div class="form-group is-required">
							<label class="control-label">Referencia
							</label>
							<input type="text" class="form-control" v-model="data.reference">
						</div>
					</div>
				</div>

				<div class="col-12" v-show="data.date != '' && data.reference != ''">
					<!-- <div class="col-12"> -->
					<ul class="nav nav-tabs custom-tabs justify-content-center" role="tablist">
		                
		                <li class="nav-item">
		                    <a class="nav-link" data-toggle="tab" href="#Compromiso" role="tab"> Compromiso
		                    </a>
		                </li>
		                <li class="nav-item">
		                    <a class="nav-link active" data-toggle="tab" href="#Seating" role="tab"> Asiento Contable
		                    </a>
		                </li>
		            </ul>

					<div class="tab-content">
						<div class="tab-pane active" id="Seating" role="tabpanel">

							<br><br>
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
											<select2 :disabled="!(data.date != '' && data.reference != '')" :options="accounting_accounts" v-model="optionIdAcc" @input="addAccountingAccount()"></select2>
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
						</div>

						<div class="tab-pane" id="Compromiso" role="tabpanel">
							<br><br>
							<!-- <div class="row">
								<div class="col-6">
									<div class="form-group">
										<select2 :disabled="!(data.date != '' && data.reference != '')" :options="budget_accounts" v-model="optionIdBudget"></select2>
									</div>
								</div>
								<div class="col-2">
									<button class="btn btn-success btn-sm btn-icon btn-action btn-round"
									style="margin-top:-0.1rem !important;" 
									title="Agregar cuenta en el Asiento contable"
									:disabled="!(data.date != '' && data.reference != '')"
									v-on:click="addAccountingAccount"
									><i class="fa fa-plus"></i></button>
								</div>
								<div class="col-4"></div>

								<div class="col-12">

									<v-client-table :columns="columns" :data="recordsBudget" :options="table_options">
										<div slot="code" slot-scope="props" class="text-center">
											<div>
												<select2 :options="budget_accounts" v-model="recordsBudget[props.index-1].id"></select2>
											</div>
										</div>
										<div slot="debit" slot-scope="props" class="text-center">
											<input type="number" class="form-control" v-model="recordsBudget[props.index-1].debit">
										</div>
										<div slot="assets" slot-scope="props" class="text-center">
											<input type="number" class="form-control" v-model="recordsBudget[props.index-1].assets">
										</div>

										<div slot="id" slot-scope="props" class="text-center">
											<button @click="deleteAccount(props.index)" 
													class="btn btn-danger btn-xs btn-icon btn-action btn-round" 
													title="Eliminar registro" data-toggle="tooltip">
												<i class="fa fa-trash-o"></i>
											</button>
										</div>
									</v-client-table>
								</div>
							</div> -->
						</div>
					</div>
				</div>
			</div>
			<div class="card-footer text-right">
				<a :href="urlPrevious" class="btn btn-warning btn-icon btn-round"
					data-toggle="tooltip"
					title="Cancelar y regresar">
					<i class="fa fa-ban"></i>
			</a>
			<!-- se muestra en caso de crear -->
			<!-- <button v-if="showButton == 'create'" class="btn btn-success btn-icon btn-round" -->
			<button class="btn btn-success btn-icon btn-round"
					data-toggle="tooltip"
					title="Guardar registro"
					id="save"
					:disabled="!(data.date != '' && data.reference != '')" 
					v-on:click="AddSeating()">
					<i class="fa fa-save"></i>
			</button>
			<!-- se muestra en caso de actualizar -->
			<!-- <button v-else class="btn btn-success btn-icon btn-round"
					data-toggle="tooltip"
					title="Actualizar registro"
					id="save">
					<i class="fa fa-save"></i>
			</button> -->
			</div>
		</form>
	</div>
</template>
<script>
	export default{
		props:['accounting_accounts'],
		// props:['accounting_accounts','budget_accounts'],
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
		},
		methods:{
			changeSelectinTable:function(record) {
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
					this.errors = [];
					this.errors.push('Debe seleccionar una cuenta para poder agregarla al asiento.');
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
						}, 2000);
					});
				}else{
					this.errors = [];
					this.errors.push('Los totales no coinciden, Por favor verifique.');
				}
			},
			deleteAccount:function(index){
				this.recordsAccounting.splice(index-1,1);
				this.CalculateTot();
			},
		},
	}
</script>