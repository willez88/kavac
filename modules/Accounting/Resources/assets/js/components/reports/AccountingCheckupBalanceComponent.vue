<template>
	<div class="form-horizontal">
		<div class="card-body">

			<accounting-show-errors ref="errorsCheckUpBalance" />

			<div class="row">
				<div class="col-3" id="helpCheckupBalanceInitDate">
					<label><strong>Desde:</strong></label>
					<br>
					<label class="control-label">Mes</label>
					<select2 :options="months" v-model="month_init"></select2>
					<br>
					<label class="control-label">Año</label>
					<select2 :options="years" v-model="year_init"></select2>
				</div>
				<div class="col-3" id="helpCheckupBalanceEndDate">
					<label><strong>Hasta:</strong></label>
					<br>
					<label class="control-label">Mes</label>
					<select2 :options="months" v-model="month_end"></select2>
					<br>
					<label class="control-label">Año</label>
					<select2 :options="years" v-model="year_end"></select2>
				</div>
				<div class="col-3" id="helpCheckupBalanceCurrency">
					<label class="control-label">Expresar en</label>
					<br><br>
					<select2 :options="currencies" v-model="currency"></select2>
				</div>
				<div class="col-3" id="helpCheckupBalanceAllAccount">
					<label class="text-center"><strong>Mostrar valores en cero</strong>
					</label>
					<br><br>
					<input id="zero"
						 data-on-label="SI" data-off-label="NO" 
						 name="zero" 
						 type="checkbox"
						 class="form-control text-center bootstrap-switch">
				</div>
			</div>
		</div>
		<div class="card-footer text-right">
			<button class="btn btn-primary btn-sm"
					data-toggle="tooltip"
					title="Generar Reporte"
					v-on:click="OpenPdf(getUrlReport(), '_black')"
					id="helpCheckupBalanceGenerateReport">
					<span>Generar reporte</span>
					<i class="fa fa-print"></i>
			</button>
		</div>
	</div>
</template>
<script>
	export default{
		props:{
            year_old:{
                type:String,
                default: ''
            },
            currencies:{
                type:Array,
                default: function() {
                	return [];
                }
            },
        },
		data(){
			return{
				url:'/accounting/report/balanceCheckUp/pdf/',
				currency:'',
			}
		},
		created(){
			this.CalculateOptionsYears(this.year_old);
		},
		methods:{
			/**
			* Formatea la url para el reporte
			*
			* @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
			* @return {string} url para el reporte
			*/
			getUrlReport:function(){

				var errors = [];
				if (!this.currency) {
					errors.push("El tipo de moneda es obligatorio.");
				}

				if (errors.length > 0) {
					this.$refs.errorsCheckUpBalance.showAlertMessages(errors);
					return;
				}
				this.$refs.errorsCheckUpBalance.reset();

				var zero = ($('#zero').prop('checked'))?'true':'';

				var initDate = (this.year_init > this.year_end)?(this.year_end+'-'+this.month_end):(this.year_init+'-'+this.month_init);
				var endDate  = (this.year_init > this.year_end)?(this.year_init+'-'+this.month_init):(this.year_end+'-'+this.month_end);

				var url = this.url+initDate+'/'+endDate+'/'+this.currency+'/'+zero;
				return url;
			}
		},
	};
</script>
