<template>
	<div>
		<div class="card-body">
			<div class="alert alert-danger" role="alert" v-if="errors.length > 0">
				<div class="container">
					<div class="alert-icon">
						<i class="now-ui-icons objects_support-17"></i>
					</div>
					<strong>Atención!</strong>
					<ul>
						<li v-for="error in errors">{{ error }}</li>
					</ul>
				</div>
			</div>
			<div class="row">
				<div class="col-3">
					<label class="control-label"><strong>Fecha Inicial</strong></label>
					<br>
					<div class="is-required">
						<label>Mes</label>
						<select2 :options="OptionMonths" v-model="InitDateMonth"></select2>
					</div>
					<br>
					<div class="is-required">
						<label>Año</label>
						<select2 :options="OptionsYears" v-model="InitDateYear"></select2>
					</div>
				</div>
				<div class="col-3">
					<label class="control-label"><strong>Fecha Final</strong></label>
					<br>
					<div class="is-required">
						<label>Mes</label>
						<select2 :options="OptionMonths" v-model="EndDateMonth"></select2>
					</div>
					<br>
					<div class="is-required">
						<label>Año</label>
						<select2 :options="OptionsYears" v-model="EndDateYear"></select2>
					</div>
				</div>
				<div class="col-6">
					<br>
					<label><strong>Cuenta Inicial</strong></label>
					<select2 :disabled="disabledSelect" :options="OptionsAcc" @input="activatedButtonFunc" v-model="InitAcc"></select2>

					<br><br>
					<label><strong>Cuenta Final</strong></label>
					<select2 :disabled="disabledSelect" :options="OptionsAcc" @input="activatedButtonFunc" v-model="EndAcc"></select2>
				</div>
			</div>
		</div>
		<div class="card-footer text-right">
			<button class="btn btn-primary btn-custom"
					title="Generar Reporte"
					:disabled="disabledButton"
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
			return {
				errors:[],
				url:"/accounting/report/AnalyticalMajor/pdf",
				disabledButton:true,
				InitDateMonth:0,
				InitDateYear:0,
				EndDateMonth:0,
				EndDateYear:0,
				InitAcc:'',
				EndAcc:'',
				OptionMonths:[
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
				OptionsYears:[],
				OptionsAcc:[{id:'',text:'Seleccione...'}],
				disabledSelect:true,
			}
		},
		created(){
			this.CalculateOptionsYears();
		},
		methods:{
			CalculateOptionsYears:function(){
				var date = new Date();
				this.OptionsYears.push({
					id:0,
					text:'Seleccione...'
				});
				for (var year = date.getFullYear(); year >= this.year_old; year--) {
					this.OptionsYears.push({
						id:year,
						text:year
					});
				}
			},
			getAccountingAccounts:function(){
				if (this.InitDateMonth != 0 && this.InitDateYear != 0 && 
					this.EndDateMonth != 0 && this.EndDateYear != 0) {
					
					var dates = {
						initMonth:this.InitDateMonth,
						initYear:(this.InitDateYear > this.EndDateYear)?this.EndDateYear:this.InitDateYear,
						endMonth:this.EndDateMonth,
						endYear:(this.InitDateYear > this.EndDateYear)?this.InitDateYear:this.EndDateYear,
					};
					axios.post("/accounting/report/AnalyticalMajor/AccAccount",dates).then(response=>{
						this.OptionsAcc = response.data.records;
						this.InitAcc = '';
						this.EndAcc = '';
					});

					this.disabledSelect = false;
				}else{
					this.disabledSelect = true;
				}
			},
			getUrlReport:function(){
				var url = this.url;
				var InitAcc = (this.InitAcc > this.EndAcc)? this.EndAcc  : this.InitAcc;
				var EndAcc = ( this.InitAcc > this.EndAcc)? this.InitAcc : this.EndAcc;

				if (InitAcc != 0) { url += '/'+InitAcc; }
				if (EndAcc != 0 && InitAcc != EndAcc) { url += '/'+EndAcc; }
				return url;
			},
			activatedButtonFunc:function(){
				if (this.InitAcc == 0 && this.EndAcc == 0) {
					this.disabledButton = true;
				}else{
					this.disabledButton = false;
				}
			},
			OpenReport:function(){
				window.open(this.getUrlReport(), '_blank');
			}
		},
		watch:{
			InitDateMonth:function(res) {
				if (res != 0) this.getAccountingAccounts();
			},
			InitDateYear:function(res) {
				if (res != 0) this.getAccountingAccounts();
			},
			EndDateMonth:function(res) {
				if (res != 0) this.getAccountingAccounts();
			},
			EndDateYear:function(res) {
				if (res != 0) this.getAccountingAccounts();
			},
		}
	};
</script>
