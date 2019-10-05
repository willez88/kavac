<template>
	<div class="form-horizontal">
		<div class="card-body" style="min-height: 0px;">
			<accounting-show-errors />

			<div class="row">
				<div class="col-1"></div>
				<div class="col-3">
					<label class="control-label">Periodo inicial</label>
					<input type="date" class="form-control is-required"
						v-model="dateIni">
				</div>
				<div class="col-3">
					<label class="control-label">Periodo final</label>
					<input type="date" class="form-control is-required"
						v-model="dateEnd">
				</div>
				<div class="col-3">
					<label class="control-label">Expresar en</label>
					<select2 :options="currencies" v-model="currency"></select2>
				</div>
				<div class="col-2"></div>
			</div>
		</div>
		<div class="card-footer text-right">
			<button class="btn btn-primary btn-sm"
					data-toggle="tooltip"
					title="Generar Reporte"
					:disabled="(!dateIni || !dateEnd || !currency)"
					v-on:click="OpenPdf(getUrlReport(), '_blank')">
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
			getUrlReport:function(argument) {
				var dateIni = this.dateIni;
				var dateEnd = this.dateEnd;
				var info = (this.dateIni <= this.dateEnd) ? (dateIni+'/'+dateEnd) : (dateEnd+'/'+dateIni) ;
				var url = this.url+info+'/'+this.currency;
				return url;
			},
		}
	};
</script>
