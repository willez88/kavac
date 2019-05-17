<template>
	<div class="form-horizontal">
		<div class="card-body">
			<div class="row">
				<div class="col-1"></div>
				<div class="col-1">
					<label>Desde:</label>
				</div>
				<div class="col-4">
					<label class="control-label">Mes</label>
					<select2 :options="optionMonths" v-model="monthIni"></select2>
				</div>
				<div class="col-4">
					<label class="control-label">Año</label>
					<select2 :options="optionsYears" v-model="yearIni"></select2>
				</div>
				<div class="col-1"></div>
				<div class="col-1">
					<label class="text-center">Mostrar valores en cero
					</label>
					<input id="zero"
						 data-on-label="SI" data-off-label="NO" 
						 checked="checked"
						 name="zero" 
						 type="checkbox"
						 class="form-control text-center bootstrap-switch">
				</div>


				<div class="col-1"></div>
				<div class="col-1">
					<label>Desde:</label>
				</div>
				<div class="col-4">
					<label class="control-label">Mes</label>
					<select2 :options="optionMonths" v-model="monthEnd"></select2>
				</div>
				<div class="col-4">
					<label class="control-label">Año</label>
					<select2 :options="optionsYears" v-model="yearEnd"></select2>
				</div>
				<div class="col-2"></div>
			</div>
		</div>
		<div class="card-footer text-right">
			<button class="btn btn-success btn-icon btn-round"
				data-toggle="tooltip"
				title="Realizar busqueda"
				v-on:click="searchRecords()">
				<i class="fa fa-search"></i>
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
					{id:0, text:'Todos'},
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
					text:'Todos'
				});
				for (var year = date.getFullYear(); year >= this.year_old; year--) {
					this.optionsYears.push({
						id:year,
						text:year
					});
				}
			},
			searchRecords:function(){
				var zero = ($('#zero').prop('checked'))?'InitZero':'';
				location.href = this.url+zero;
			}
		},
	}
</script>