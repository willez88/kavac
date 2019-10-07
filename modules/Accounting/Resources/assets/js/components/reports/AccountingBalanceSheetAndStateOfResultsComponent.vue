<template>
	<div class="form-horizontal">
		<div class="card-body">

			<accounting-show-errors :ref="type_report" />

			<div class="row">
				<div class="col-3">
					<label class="control-label">Al mes</label>
					<br><br>
					<select2 :options="months" v-model="month_init"></select2>
					<br><br>
					<label class="control-label">Año</label>
					<br><br>
					<select2 :options="years" v-model="year_init"></select2>
				</div>
				<div class="col-3">
					<label class="control-label">Nivel de consulta</label>
					<br><br>
					<select2 :options="levels" v-model="level"></select2>
				</div>
				<div class="col-3">
						<div>
							<label class="control-label">Expresar en</label>
							<br><br>
							<select2 :options="currencies" v-model="currency"></select2>
						</div>
					</div>
				<div class="col-3">
					<label class="text-center"><strong>Mostrar valores en cero</strong>
					</label>
					<br><br>
					<input :id="'zero'+type_report"
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
	</div>
</template>

<script>
	export default{
		props:{
            type_report:{
                type:String,
                default: ''
            },
            currencies:{
                type:Array,
                default: function() {
                	return [];
                }
            },
            year_old:{
                type:String,
                default: ''
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
				currency:'',
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

				var errors = [];
				if (!this.currency) {
					errors.push("El tipo de moneda es obligatorio.");
				}

				if (errors.length > 0) {
					this.$refs[this.type_report].showAlertMessages(errors);
					return;
				}
				this.$refs[this.type_report].reset();

				var zero = ($('#zero'+this.type_report).prop('checked'))?'true':'';
				return ( this.url+(this.year_init+'-'+this.month_init) )+'/'+this.level+'/'+this.currency+'/'+zero;
			}
		}
	};
</script>
