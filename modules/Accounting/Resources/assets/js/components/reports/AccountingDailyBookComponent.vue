<template>
	<div class="form-horizontal">
		<div class="card-body">

			<accounting-show-errors ref="errorsDialyBook" />

			<div class="row">
				<div class="col-3" id="helpDailyBookInitDate">
					<label class="control-label">Fecha inicial</label>
					<input type="date" class="form-control input-sm"
						v-model="dateIni">
				</div>
				<div class="col-3" id="helpDailyBookEndDate">
					<label class="control-label">Fecha final</label>
					<input type="date" class="form-control input-sm"
						v-model="dateEnd">
				</div>
				<div class="col-3" id="helpDailyBookCurrency">
					<label class="control-label">Expresar en</label>
					<select2 :options="currencies" v-model="currency"></select2>
				</div>
				<div class="col-2"></div>
			</div>
		</div>
		<div class="card-footer text-right" >
			<button class="btn btn-primary btn-sm" data-toggle="tooltip" title="Generar Reporte"
                    v-on:click="OpenPdf(getUrlReport(), '_blank')" id="helpDailyBookGenerateReport">
                <span>Generar reporte</span>
                <i class="fa fa-print"></i>
			</button>
		</div>
	</div>
</template>

<script>
	export default{
		props:{
			currencies:{
				type:Array,
				default:function(){
					return [];
				}
			}
		},
		data(){
			return{
				url:'/accounting/report/dailyBook/pdf/',
				dateIni:'',
				dateEnd:'',
				currency:'',
			}
		},
		methods:{
			/**
			* Formatea la url para el reporte
			*
			* @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
			* @return {string} url para el reporte
			*/
			getUrlReport:function() {

				var errors = [];
				if (!this.dateIni) {
					errors.push("La fecha inicial es obligatorio.");
				}
				if (!this.dateEnd) {
					errors.push("La fecha final es obligatorio.");
				}
				if (!this.currency) {
					errors.push("El tipo de moneda es obligatorio.");
				}

				if (errors.length > 0) {
					this.$refs.errorsDialyBook.showAlertMessages(errors);
					return;
				}
				this.$refs.errorsDialyBook.reset();

				var dateIni = this.dateIni;
				var dateEnd = this.dateEnd;
				var info = (this.dateIni <= this.dateEnd) ? (dateIni+'/'+dateEnd) : (dateEnd+'/'+dateIni) ;
				var url = this.url+info+'/'+this.currency;
				return url;
			},
		}
	};
</script>
