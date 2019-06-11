<template>
	<div class="form-horizontal">
		<div class="card-body">
			<div class="row">
				<div class="col-1"></div>
				<div class="col-3">
					<label><strong>Desde:</strong></label>
					<br>
					<label class="control-label">Mes</label>
					<select2 :options="optionMonths" v-model="monthIni"></select2>
					<br>
					<label class="control-label">Año</label>
					<select2 :options="optionsYears" v-model="yearIni"></select2>
				</div>
				<div class="col-3">
					<label><strong>Hasta:</strong></label>
					<br>
					<label class="control-label">Mes</label>
					<select2 :options="optionMonths" v-model="monthEnd"></select2>
					<br>
					<label class="control-label">Año</label>
					<select2 :options="optionsYears" v-model="yearEnd"></select2>
				</div>
				<!-- <div class="col-3 form-horizontal">
					<label class="control-label"><strong>Tipo de balance</strong></label>
					<br><br>
					<label class="text-center">Balance de Sumas y Saldos
					</label>
					<input id="Balance"
						 data-on-label="SI" data-off-label="NO" 
						 checked="checked"
						 name="typeBalance" 
						 type="radio"
						 value="Complet" 
						 class="form-control text-center bootstrap-switch">
					<br><br>
					<label class="text-center">Balance de Sumas
					</label>
					<input id="Sum"
						 data-on-label="SI" data-off-label="NO" 
						 name="typeBalance" 
						 type="radio"
						 value="Sum" 
						 class="form-control text-center bootstrap-switch">

					<br><br>
					<label class="text-center">Balance de Saldos
					</label>
					<input id="Balance"
						 data-on-label="SI" data-off-label="NO" 
						 name="typeBalance" 
						 type="radio"
						 value="Balance" 
						 class="form-control text-center bootstrap-switch">
				</div> -->
				<div class="col-2">
					<label class="text-center"><strong>Mostrar valores en cero</strong>
					</label>
					<br><br>
					<input id="zero"
						 data-on-label="SI" data-off-label="NO" 
						 checked="checked"
						 name="zero" 
						 type="checkbox"
						 class="form-control text-center bootstrap-switch">
				</div>
			</div>
		</div>
		<div class="card-footer text-right">
			<button class="btn btn-primary btn-custom"
					data-toggle="tooltip"
					:disabled="(monthIni == 0 || yearIni == 0 || monthEnd == 0 || yearEnd == 0)"
					title="Generar Reporte"
					v-on:click="OpenReport()">
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
				url:'http://'+window.location.host+'/accounting/report/checkingBalance/pdf/',
				optionMonths:[
					{id:0, text:'Seleccione...'},
					{id:1, text:'Enero'},
					{id:2, text:'Febrero'},
					{id:3, text:'Marzo'},
					{id:4, text:'Abril'},
					{id:5, text:'Mayo'},
					{id:6, text:'Junio'},
					{id:7, text:'Julio'},
					{id:8, text:'Agosto'},
					{id:9, text:'Septiembre'},
					{id:10, text:'Octubre'},
					{id:11, text:'Noviembre'},
					{id:12, text:'Diciembre'}
				],
				optionsYears:[],
				monthIni:0,
				monthEnd:0,
				yearIni:0,
				yearEnd:0,
				zero:true,
			}
		},
		created(){
			this.CalculateOptionsYears();
		},
		methods:{
			CalculateOptionsYears:function(){
				var date = new Date();
				this.optionsYears.push({
					id:0,
					text:'Seleccione...'
				});
				for (var year = date.getFullYear(); year >= this.year_old; year--) {
					this.optionsYears.push({
						id:year,
						text:year
					});
				}
			},
			OpenReport:function(){
				var zero = ($('#zero').prop('checked'))?'':'zero';
				var type = $('input:radio[name=typeBalance]:checked').val();

				var initDate = (this.yearIni > this.yearEnd)?(this.yearEnd+'-'+this.monthEnd):(this.yearIni+'-'+this.monthIni);
				var endDate  = (this.yearIni > this.yearEnd)?(this.yearIni+'-'+this.monthIni):(this.yearEnd+'-'+this.monthEnd);

				var url = this.url+initDate+'/'+endDate+'/'+zero;
				window.open(url, '_blank');
			}
		},
	}
</script>