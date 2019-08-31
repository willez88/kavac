<template>
	<div class="form-horizontal">
		<div class="card-body" style="min-height: 0px;">
			<div class="row">
				<div class="col-2"></div>
				<div class="col-4">
					<label class="control-label">Periodo Inicial</label>
					<input type="date" class="form-control is-required"
						v-model="dateIni">
				</div>
				<div class="col-4">
					<label class="control-label">Periodo Final</label>
					<input type="date" class="form-control is-required"
						v-model="dateEnd">
				</div>
				<div class="col-2"></div>
			</div>
		</div>
		<div class="card-footer text-right">
			<button class="btn btn-primary btn-sm"
					data-toggle="tooltip"
					title="Generar Reporte"
					:disabled="(dateIni == '' || dateEnd == '')"
					v-on:click="OpenPdf(getUrlReport(), '_blank')">
					<span>Generar reporte</span>
					<i class="fa fa-print"></i>
			</button>
		</div>
	</div>
</template>

<script>
	export default{
		data(){
			return{
				url:'/accounting/report/diaryBook/pdf/',
				dateIni:'',
				dateEnd:'',
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
				var dateIni = this.dateIni.split('-')[2]+'-'+this.dateIni.split('-')[1]+'-'+this.dateIni.split('-')[0];
				var dateEnd = this.dateEnd.split('-')[2]+'-'+this.dateEnd.split('-')[1]+'-'+this.dateEnd.split('-')[0];
				var info = (this.dateIni <= this.dateEnd) ? (dateIni+'/'+dateEnd) : (dateEnd+'/'+dateIni) ;
				var url = this.url+info;
				return url;
			},
		}
	};
</script>
