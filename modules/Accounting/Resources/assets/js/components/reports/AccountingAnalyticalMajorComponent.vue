<template>
	<div>
		<div class="card-body">
			
			<accounting-show-errors :options="errors" />

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
					<div class="is-required">
						<label><strong>Cuenta Inicial</strong></label>
						<select2 :options="OptionsAcc" @input="activatedButtonFunc" v-model="InitAcc"></select2>
					</div>

					<br>
					<label><strong>Cuenta Final</strong></label>
					<select2 :options="OptionsAcc" @input="activatedButtonFunc" v-model="EndAcc"></select2>
				</div>
			</div>
		</div>
		<div class="card-footer text-right">
			<button class="btn btn-primary btn-sm"
					title="Generar Reporte"
					:disabled="disabledButton"
					data-toggle="tooltip"
					v-on:click="OpenPdf(getUrlReport(),'_black')">
					<span>Generar reporte</span>
					<i class="fa fa-print"></i>
			</button>
		</div>
	</div>
</template>
<script>
	export default{
		props:{
            year_old:{
                type:String,
                default: ''
            },
        },
		data(){
			return {
				url:'/accounting/report/analyticalMajor',
				disabledButton:true,
				InitAcc:0,
				EndAcc:0,
				dates:null,
				OptionsAcc:[{id:0,text:'Seleccione...'}],
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

			/**
			* Obtiene las cuentas encontradas en el rango de fecha dado
			*
			* @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
			*/
			getAccountingAccounts:function(){
				const vm = this;
				vm.dates = {
					initMonth:vm.month_init,
					initYear:(vm.year_init > vm.year_end)?vm.year_end:vm.year_init,
					endMonth:vm.month_end,
					endYear:(vm.year_init > vm.year_end)?vm.year_init:vm.year_end,
				};
				axios.post(vm.url+"/AccAccount",vm.dates).then(response=>{
					vm.OptionsAcc = response.data.records;
					vm.InitAcc = '';
					vm.EndAcc = '';
				});
			},

			/**
			* genera la url para el reporte
			*
			* @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
			* @return {string} url para el reporte
			*/
			getUrlReport:function(){
				var url = this.url+'/pdf';
				var InitAcc = (this.InitAcc > this.EndAcc)? this.EndAcc  : this.InitAcc;
				var EndAcc  = (this.InitAcc > this.EndAcc)? this.InitAcc : this.EndAcc;

				var dates = '/'+this.dates.initYear+'-'+this.dates.initMonth+
								  '/'+this.dates.endYear+'-'+this.dates.endMonth;

				url += dates;

				if (InitAcc != 0) { url += '/'+InitAcc; }

				if (EndAcc != 0) { url += '/'+EndAcc; }

				return url;
			},

			/**
			* valida si se cumplen los requerimientos de información de las cuentas, y cambia el valor de la variable para habilitar el boton
			*
			* @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
			*/
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
