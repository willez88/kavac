<template>
	<div class="form-horizontal" v-show="record_curr != null">
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
		{{ selectCurrencyDefault(record_curr) }}
		<table class="table table-striped">
			<thead>
				<tr>
					<td><strong>MONEDA BASE</strong></td>
					<td><strong>EQUIVALENTE</strong></td>
					<td><strong>ACCIÓN</strong></td>
				</tr>
			</thead>
			<tbody>
				<tr v-for="iter_currency in record_curr.exchange_rate_currency_base">
					<td>
						<span><strong>1 {{ baseCurrency.symbol }}</strong> </span>
					</td>
					<td class="row">
						<span class="col-3 text-right" style="padding: 0.3rem;"
							v-if="editCurrency.currency_id != iter_currency.currency.id"> 
							<strong>{{ iter_currency.value }}</strong>
						</span>
						<input type="number" class="form-control col-6"
							:step="cualculateLimitDecimal(iter_currency.decimal_places)"
							:disabled="editCurrency.currency_id != iter_currency.currency.id"
							v-else
							v-model="editCurrency.value">

						<span style="padding: 0.3rem;" class="col-3 text-left"><strong>{{ iter_currency.currency.symbol }}</strong></span>	
					</td>
					<td>
						<button class="btn btn-success btn-icon btn-xs btn-round" 
								title="Guardar registro"
								@click="storeCurrency()"
								v-if="editCurrency.currency_id == iter_currency.currency.id">
								<i class="fa fa-save"></i>
						</button>
						<button class="btn btn-warning btn-icon btn-xs btn-round"
								title="Actualizar registro"
								@click="updateCurrency(iter_currency)"
								v-else
								><i class="fa fa-edit"></i>
						</button>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</template>

<script>
	export default{
		props:['currency_default'],
		data(){
			return {
				errors:[],
				baseCurrency:{},
				editCurrency:{
					currency_base_id:'',
					currency_id:'',
					value:0.00,
				},
				record_curr:null,
			}
		},
		created(){
			this.record_curr = this.currency_default;
		},
		methods:{
			cualculateLimitDecimal(decimal_places){
				var res = "0.";
				for (var i = 0; i < decimal_places-1; i++) {
					res += "0";
				}
				res += "1";
				return res;
			},
			selectCurrencyDefault:function(currency) {
				this.editCurrency.currency_base_id = currency.id;
				this.baseCurrency = currency;
			},
			updateCurrency(currency_default){
				this.editCurrency.currency_id = currency_default.currency_id;
				this.editCurrency.value = currency_default.value;
			},
			storeCurrency(id){
				if (this.editCurrency.value != 0) {
					var vm = this;
					axios.post('/accounting/settings/currencies',this.editCurrency).then(response=>{
						this.editCurrency.currency_id = '';
						this.editCurrency.value = 1;
						this.record_curr = null;
						this.record_curr = response.data.records;
						vm.showMessage('update');
					});
				}else{
					this.errors = [];
					this.errors.push('No es permitido un equivalente de valor 0')
				}
			}

		}
	};
</script>