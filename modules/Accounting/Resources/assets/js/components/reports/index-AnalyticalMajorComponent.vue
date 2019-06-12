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
						<select2 :options="months" v-model="month_init"></select2>
					</div>
					<br>
					<div class="is-required">
						<label>Año</label>
						<select2 :options="years" v-model="year_init"></select2>
					</div>
				</div>
				<div class="col-3">
					<label class="control-label"><strong>Fecha Final</strong></label>
					<br>
					<div class="is-required">
						<label>Mes</label>
						<select2 :options="months" v-model="month_end"></select2>
					</div>
					<br>
					<div class="is-required">
						<label>Año</label>
						<select2 :options="years" v-model="year_end"></select2>
					</div>
				</div>
				<div class="col-6">
					<br>
					<label><strong>Cuenta Inicial</strong></label>
					<select2 :options="OptionsAcc" @input="activatedButtonFunc" v-model="InitAcc"></select2>

					<br><br>
					<label><strong>Cuenta Final</strong></label>
					<select2 :options="OptionsAcc" @input="activatedButtonFunc" v-model="EndAcc"></select2>
				</div>
			</div>
		</div>
		<div class="card-footer text-right">
			<button class="btn btn-primary btn-custom"
					title="Generar Reporte"
					:disabled="disabledButton"
					v-on:click="OpenPdf(getUrlReport(),'_black')">
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
				url:'http://'+window.location.host+'/accounting/report/AnalyticalMajor/pdf',
				disabledButton:true,
				InitAcc:'',
				EndAcc:'',
				OptionsAcc:[{id:'',text:'Seleccione...'}],
				disabledSelect:true,
			}
		},
		created(){
			this.CalculateOptionsYears(this.year_old);
		},
		mounted(){
			this.getAccountingAccounts();
		},
		methods:{
			getAccountingAccounts:function(){
				const vm = this;
				var dates = {
					initMonth:vm.month_init,
					initYear:(vm.year_init > vm.year_end)?vm.year_end:vm.year_init,
					endMonth:vm.month_end,
					endYear:(vm.year_init > vm.year_end)?vm.year_init:vm.year_end,
				};
				console.log(dates);
				axios.post("/accounting/report/AnalyticalMajor/AccAccount",dates).then(response=>{
					console.log(response.data.records);
					this.OptionsAcc = response.data.records;
					this.InitAcc = '';
					this.EndAcc = '';
				});
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
		},
		watch:{
			month_init:function(res) {
				this.getAccountingAccounts();
			},
			year_init:function(res) {
				this.getAccountingAccounts();
			},
			month_end:function(res) {
				this.getAccountingAccounts();
			},
			year_end:function(res) {
				this.getAccountingAccounts();
			},
		}
	};
</script>
