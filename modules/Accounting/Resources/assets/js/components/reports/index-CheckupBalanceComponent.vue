<template>
	<div class="form-horizontal">
		<div class="card-body">
			<div class="row">
				<div class="col-2"></div>
				<div class="col-3">
					<label><strong>Desde:</strong></label>
					<br>
					<label class="control-label">Mes</label>
					<select2 :options="months" v-model="month_init"></select2>
					<br>
					<label class="control-label">Año</label>
					<select2 :options="years" v-model="year_init"></select2>
				</div>
				<div class="col-1"></div>
				<div class="col-3">
					<label><strong>Hasta:</strong></label>
					<br>
					<label class="control-label">Mes</label>
					<select2 :options="months" v-model="month_end"></select2>
					<br>
					<label class="control-label">Año</label>
					<select2 :options="years" v-model="year_end"></select2>
				</div>
			</div>
		</div>
		<div class="card-footer text-right">
			<button class="btn btn-primary btn-sm"
					data-toggle="tooltip"
					title="Generar Reporte"
					v-on:click="OpenPdf(getUrlReport(), '_black')">
					<span>Generar reporte</span>
					<i class="fa fa-print"></i>
			</button>
		</div>
	</div>
</template>
<script>
	export default{
		props:['year_old'],
		data(){
			return{
				url:'http://'+window.location.host+'/accounting/report/BalanceCheckUp/pdf/',
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
				var type = $('input:radio[name=typeBalance]:checked').val();

				var initDate = (this.year_init > this.year_end)?(this.year_end+'-'+this.month_end):(this.year_init+'-'+this.month_init);
				var endDate  = (this.year_init > this.year_end)?(this.year_init+'-'+this.month_init):(this.year_end+'-'+this.month_end);

				var url = this.url+initDate+'/'+endDate;
				return url;
			}
		},
	};
</script>