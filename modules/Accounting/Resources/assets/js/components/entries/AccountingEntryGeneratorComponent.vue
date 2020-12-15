<template>
<div>
	<accounting-show-errors ref="AccountingEntryGenerator" />

	<div class="card-body">
		<div class="row">
			<div class="col-12 col-md-6 form-group" id="helpEntriesCategory">
				<div class="form-group is-required">
					<label class="control-label">Categoría del asiento</label>
					<select2 :options="categories" v-model="data.category"></select2>
				</div>
			</div>
			<div class="col-12 col-md-6 form-group" id="helpEntriesDescription">
				<div class="form-group is-required">
					<label class="control-label">Concepto ó Descripción</label>
					<input type="text" class="form-control input-sm" v-model="data.concept">
				</div>
			</div>
		</div>
	</div>

	<table class="table table-formulation">
		<thead>
			<tr>
				<th class="text-uppercase" width="50%">CÓDIGO DE CUENTA - DENOMINACIÓN</th>
				<th class="text-uppercase" width="20%">DEBE</th>
				<th class="text-uppercase" width="20%">HABER</th>
				<th class="text-uppercase" width="10%">ACCIÓN</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="record in recordsAccounting">
				<td>
					<select2 :options="accounting_accounts" v-model="record.id"
								@input="changeSelectinTable(record)"></select2>
				</td>
				<td>
					<input :disabled="record.assets != 0" type="number"
							data-toggle="tooltip"
							class="form-control input-sm" :step="cualculateLimitDecimal()"
							v-model="record.debit" @change="CalculateTot()">
				</td>
				<td>
					<input :disabled="record.debit != 0 " type="number"
							data-toggle="tooltip"
							class="form-control input-sm" :step="cualculateLimitDecimal()"
							v-model="record.assets" @change="CalculateTot()">
				</td>
				<td>
					<div class="text-center">
						<button @click="clearValues(recordsAccounting.indexOf(record))"
							class="btn btn-default btn-xs btn-icon btn-action"
							title="Vaciar valores" data-toggle="tooltip">
							<i class="fa fa-eraser"></i>
						</button>
						<button @click="deleteAccount(recordsAccounting.indexOf(record), record.entryAccountId)"
							class="btn btn-danger btn-xs btn-icon btn-action"
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
				<td id="helpEntriesAccountSelect">
					<select2 :options="accounting_accounts" id="select2" @input="addAccountingAccount()"></select2>
				</td>
				<td id="helpEntriesTotDebit">
					<div class="form-group text-center">Total Debe:
						<h6>
							<span>{{ data.currency.symbol }}</span>
							<span v-if="data.totDebit.toFixed(data.currency.decimal_places) == data.totAssets.toFixed(data.currency.decimal_places) &&
										data.totDebit.toFixed(data.currency.decimal_places) >= 0"
								style="color:#18ce0f;">
								<strong>{{ addDecimals(data.totDebit) }}</strong>
							</span>
							<span v-else style="color:#FF3636;">
								<strong>{{ addDecimals(data.totDebit) }}</strong>
							</span>
						</h6>
					</div>
				</td>
				<td id="helpEntriesTotAssets">
					<div class="form-group text-center">Total Haber:
						<h6>
							<span>{{ data.currency.symbol }}</span>
							<span v-if="data.totDebit.toFixed(data.currency.decimal_places) == data.totAssets.toFixed(data.currency.decimal_places) &&
										data.totAssets.toFixed(data.currency.decimal_places) >= 0"
								style="color:#18ce0f;">
								<strong>{{ addDecimals(data.totAssets) }}</strong>
							</span>
							<span v-else style="color:#FF3636;">
								<strong>{{ addDecimals(data.totAssets) }}</strong>
							</span>
						</h6>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
	<div class="card-footer text-right">
		<buttonsDisplay route_list="/accounting/entries" display="false"/>
	</div>
</div>
</template>
<script>
	export default{
		props:{
			recordToConverter:{
				type:Array,
				default: null
			},
			date:{
				type:String,
				default: null
			},
		},
		data(){
			return{
				recordsAccounting: [],
				accounting_accounts:[],
				rowsToDelete:[],
				columns: ['code', 'debit', 'assets', 'id'],
				data:{
					date:'',
					reference:'',
					concept:'',
					observations:'',
					category:'',
					totDebit:0,
					totAssets:0,
					institution:{ 
						id:'',
						rif:'',
						acronym:'',
						name:0,
					},
					currency:{ 
						id:'',
						symbol:'',
						name:'',
						decimal_places:0,
					},
				},
				categories:[],
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
		},
		mounted(){
			if (this.recordToConverter) {
				axios.post('/accounting/entries/converterToEntry', { 
						objectsList: this.recordToConverter
					}
				).then(response => {
					this.accounting_accounts = response.data.accountingAccounts;
					this.recordsAccounting = response.data.recordsAccounting;
					this.categories = response.data.categories;

					// En caso de no haber seleccionado un tipo de moneda le asignara el 
					// que tenga por defecto en el sistema
					if (!this.data.currency.id && response.data.currency) {
						this.data.currency 		  = response.data.currency;
					}
					this.CalculateTot();
				})
			}
			if (this.date) {
				this.data.date = this.date;
			}
		},
		// beforeDestroy(){
		// 	EventBus.$off('enableInput:entries-account');
		// },
		methods:{

			reset(){
				// EventBus.$emit('reset:accounting-entry-edit-create');
			},

			addDecimals(value){
				return parseFloat(value).toFixed(this.data.currency.decimal_places);
			},

			/**
			 * [validateTotals valida que los totales sean positivos]
			 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
			 * @return {boolean}
			 */
			validateTotals:function(){
				return !(this.data.totDebit.toFixed(this.data.currency.decimal_places) >= 0 &&
						this.data.totAssets.toFixed(this.data.currency.decimal_places) >= 0);
			},

			/**
			* Validación de errores
			*
			* @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
			*/
			validateErrors:function() {
				/**
				* se cargan los errores
				*/
				var errors = [];
				var res = false;

				if (!this.data.date) {
					errors.push('El campo fecha es obligatorio.');
					res = true;
				}
				if (!this.data.concept) {
					errors.push('El campo concepto ó descripción es obligatorio.');
					res = true;
				}
				if (!this.data.category) {
					errors.push('El campo categoria es obligatorio.');
					res = true;
				}
				// if (!this.data.institution.id) {
				// 	errors.push('El campo institución es obligatorio.');
				// 	res = true;
				// }
				if (!this.data.currency.id) {
					errors.push('El tipo de moneda es obligatorio.');
					res = true;
				}
				if (this.recordsAccounting.length < 1) {
					errors.push('No está permitido registrar asientos contables vacíos');
					res = true;
				}
				if (this.data.totDebit != this.data.totAssets) {
					errors.push('El asiento no esta balanceado, Por favor verifique.');
					res = true;
				}
				if (this.data.totDebit < 0 || this.data.totAssets < 0) {
					errors.push('Los valores en la columna del DEBE y el HABER deben ser positivos.');
					res = true;
				}
				this.$refs.AccountingEntryGenerator.showAlertMessages(errors);
				return res;
			},

			/**
			* Vacia la información del debe y haber de la columna sin cuenta seleccionada
			*
			* @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
			*/
			changeSelectinTable:function(record) {
				// si asigna un select en vacio, vacia los valores del debe y haber de esa fila
				if (record.id == '') {
					record.debit = 0;
					record.assets = 0;
					this.CalculateTot();
				}
			},

			/**
			* Establece la cantidad de decimales correspondientes a la moneda que se maneja
			*
			* @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
			*/
			cualculateLimitDecimal(){
				var res = "0.";
				for (var i = 0; i < this.data.currency.decimal_places-1; i++) {
					res += "0";
				}
				res += "1";
				return res;
			},

			/**
			* Calcula el total del debe y haber del asiento contable
			*
			* @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
			*/
			CalculateTot:function(){

				this.data.totDebit = 0;
				this.data.totAssets = 0;

				/** Se recorren todo el arreglo que tiene todas las filas de las cuentas y saldos para el asiento y se calcula el total */
				for (var i = this.recordsAccounting.length - 1; i >= 0; i--) {
					if (this.recordsAccounting[i].id != '') {
						var debit = (this.recordsAccounting[i].debit != '') ? this.recordsAccounting[i].debit : 0;
						var assets = (this.recordsAccounting[i].assets != '') ? this.recordsAccounting[i].assets : 0;

						this.recordsAccounting[i].debit = parseFloat(debit).toFixed(this.data.currency.decimal_places);
						this.recordsAccounting[i].assets = parseFloat(assets).toFixed(this.data.currency.decimal_places)

						if (this.recordsAccounting[i].debit < 0 || this.recordsAccounting[i].assets < 0) {
							this.$refs.AccountingEntryGenerator.showAlertMessages('Los valores en la columna del DEBE y el HABER deben ser positivos.');
						}

						this.data.totDebit += (this.recordsAccounting[i].debit!='')?parseFloat(this.recordsAccounting[i].debit):0;
						this.data.totAssets += (this.recordsAccounting[i].assets!='')?parseFloat(this.recordsAccounting[i].assets):0;
					}
				}
			},

			/**
			* Establece la información base para cada fila de cuentas
			*
			* @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
			*/
			addAccountingAccount:function() {
				if ($('#select2').val() != '') {
					for (var i = this.accounting_accounts.length - 1; i >= 0; i--) {
						if (this.accounting_accounts[i].id == $('#select2').val()){
							this.recordsAccounting.push({
								id:$('#select2').val(),
								entryAccountId:null,
								debit:0,
								assets:0,
							});
							$('#select2').val('');
							break;
						}
					}
				}
			},

		   /**
			* Guarda la información del asiento contable
			* 
			* @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
			* @return {[type]} [description]
			*/
			createRecord:function(){
				const vm = this;
				if (vm.validateErrors()) {
					return ;
				}

				vm.data['institution_id'] 	  = vm.data.institution.id;
				vm.data['currency_id'] 	  	  = vm.data.currency.id;
				vm.data['tot'] 				  = vm.data.totDebit;
				vm.data['tot_confirmation']   = vm.data.totAssets;
				vm.data['accountingAccounts'] = vm.recordsAccounting;
				vm.loading = true;

				axios.post('/accounting/entries', vm.data).then(response => {
					vm.loading = false;
					vm.showMessage('store');
				}).catch(error=>{
					var errors = [];
					if (typeof(error.response) != "undefined") {
						for (var index in error.response.data.errors) {
							if (error.response.data.errors[index]) {
								errors.push(error.response.data.errors[index][0]);
							}
						}
					}
					/**
					* se cargan los errores
					*/
					vm.$refs.AccountingEntryGenerator.showAlertMessages(errors);
					vm.loading = false;
				});
			},

			/**
			* cambia el tipo de moneda en el que se expresa el asiento contable
			*
			* @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
			*/
			changeCurrency(currency_id){
				if (currency_id) {
					axios.get('/currencies/info/'+currency_id).then(response => {
						this.data.currency 	= response.data.currency;
						this.data.currency_id 	= response.data.currency.id;
					});
				}else{
					this.data.currency = { 
						id:'',
						symbol:'',
						name:'',
						decimal_places:0,
					};
					this.data.currency_id 	= '';
				}
				this.CalculateTot();
			},

			/**
			* Elimina la fila de la cuenta y vuelve a calcular el total del asiento
			*
			* @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
			*/
			deleteAccount:function(index, id){
				this.rowsToDelete.push(id);
				this.recordsAccounting.splice(index,1);
				this.CalculateTot();
			},

			/**
			* vacia los valores del debe y del haber de la fila de la cuenta y vuelve a calcular el total del asiento
			*
			* @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
			*/
			clearValues:function(index){
				this.recordsAccounting[index].assets = 0.00;
				this.recordsAccounting[index].debit  = 0.00;
				this.CalculateTot();
			}
		},
	};
</script>
