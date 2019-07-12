<template>
	<div class="form-horizontal">
		<div class="card-body">
			<div class="row">
				<div class="col-4">
					<label><strong>Desde:</strong></label>
					<br>
					<div class="is-required">
						<label>Mes</label>
						<select2 :options="months" v-model="month_init"></select2>
					</div>
					<br>
					<div class="is-required">
						<label>Año</label>
						<select2 :options="years" v-model="year_init"></select2>
					</div>
				</div>
				<div class="col-8">
					<label class="control-label"><strong>Cuentas Patrimoniales</strong></label>
					<br><br>
					<select2 :options="records" v-model="account_id"></select2>
				</div>
			</div>
		</div>
		<div class="card-footer text-right">
			<button class="btn btn-primary btn-custom"
					data-toggle="tooltip"
					:disabled="account_id == 0"
					title="Generar Reporte"
					@click="OpenPdf(getUrlReport(),'_blank')">
					<span>Generar reporte</span>
					<i class="fa fa-print"></i>
			</button>
		</div>
	</div>
</template>

<script>
	export default{
		props:['records','year_old'],
		data(){
			return {
				account_id:0,
				url:'http://'+window.location.host+'/accounting/report/auxiliaryBook/pdf/',
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
			getUrlReport:function() {
				return ( this.url+this.account_id+'/'+(this.year_init+'-'+this.month_init) );
			}
		}
	};
</script>