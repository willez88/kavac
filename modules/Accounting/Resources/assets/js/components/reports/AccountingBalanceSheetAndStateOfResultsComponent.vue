<template>
	<div class="form-horizontal">
		<div class="card-body row">
			<div class="col-1"></div>
			<div class="col-4">
				<label class="control-label">Al mes</label>
				<select2 :options="months" v-model="month_init"></select2>
				<br>
				<label class="control-label">Año</label>
				<select2 :options="years" v-model="year_init"></select2>
			</div>
			<div class="col-4">
				<label class="control-label">Nivel de consulta</label>
				<select2 :options="levels" v-model="level"></select2>
			</div>
			<div class="col-2">
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
		<div class="card-footer text-right">
			<button class="btn btn-primary btn-sm"
				@click="OpenPdf(getUrlReport(), '_blank')">
				Generar Reporte <i class="fa fa-print"></i>
			</button>
		</div>
	</div>
</template>

<script>
	export default{
		props:{
            type_report:{
                type:String,
                default: ''
            },
            year_old:{
                type:Number,
                default: 0
            },
        },
		data(){
			return{
				level:1,
				levels:[
					{ id:1, text:'Nivel 1' },
					{ id:2, text:'Nivel 2' },
					{ id:3, text:'Nivel 3' },
					{ id:4, text:'Nivel 4' },
					{ id:5, text:'Nivel 5' },
					{ id:6, text:'Nivel 6' },
				],
				url:'/accounting/report/',
			}
		},
		created(){
			this.CalculateOptionsYears(this.year_old);
			this.url += this.type_report+'/pdf/';
		},
		methods:{

			/**
			* Formatea la url para el reporte
			*
			* @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
			* @return {string} url para el reporte
			*/
			getUrlReport:function() {
				var zero = ($('#zero').prop('checked'))?'true':'';
				return ( this.url+(this.year_init+'-'+this.month_init) )+'/'+this.level+'/'+zero;
			}
		}
	};
</script>
