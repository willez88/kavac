<template>
	<div class="form-horizontal">
		<div v-for="currency in currencies">
			<div v-if="currency.default">
				<div class="row">
					<!-- <div class="col-12 form-group">
						<span><strong>Moneda por defecto {{ currency.name }}</strong></span>
					</div> -->
					{{ selectCurrencyDefault(currency) }}
				</div>
			</div>
		</div>

		<table class="table table-striped">
			<thead>
				<tr>
					<td><strong>MONEDA BASE</strong></td>
					<td><strong>EQUIVALENTE</strong></td>
					<td><strong>ACCIÓN</strong></td>
				</tr>
			</thead>
			<tbody>
				<tr v-for="currency in currencies" v-if="!currency.default">
					<td>
						<span><strong>1 {{ baseCurrency.symbol }}</strong> </span>
					</td>
					<td class="row">
						<span style="padding: 0.3rem;" class="col-3 text-right"><strong>{{ currency.symbol }}</strong></span>	
						<input type="number" class="form-control col-6"
							:step="cualculateLimitDecimal(currency.decimal_places)"
							:disabled="editCurrency.id != currency.id"
							v-show="editCurrency.id == currency.id"
							v-model="editCurrency.value">

						<input type="number" class="form-control col-6"
							v-show="editCurrency.id != currency.id"
							:step="cualculateLimitDecimal(currency.decimal_places)"
							:disabled="editCurrency.id != currency.id"
							value="0">
					</td>
					<td>
						<button class="btn btn-success btn-icon btn-xs btn-round" 
								title="Guardar registro"
								@click="storeCurrency()"
								v-if="edit_id == currency.id">
								<i class="fa fa-save"></i>
						</button>
						<button class="btn btn-warning btn-icon btn-xs btn-round"
								title="Actualizar registro"
								@click="updateCurrency(currency.id)"
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
		props:['currencies'],
		data(){
			return {
				baseCurrency:{},
				editCurrency:{
					id:'',
					value:0.00,
				},
				edit_id:{},
				disabledList:[],
			}
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
				this.baseCurrency = currency;
			},
			updateCurrency(id){
				this.editCurrency.id = id;
				this.editCurrency.value = 0;
			},
			storeCurrency(id){
				
			}

		}
	};
</script>