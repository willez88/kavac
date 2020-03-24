<template>
	<div>
		<div class="card-body">

			<accounting-show-errors ref="errorsAnalyticalMajor" />

			<div class="row">
				<div class="col-3" id="helpAnaliticalMajorInitDate">
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
				<div class="col-3" id="helpAnaliticalMajorEndDate">
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
				<div class="col-3" id="helpAnaliticalMajorRangeAccount">
					<br>
					<div class="is-required">
						<label><strong>Cuenta Inicial</strong></label>
						<select2 :options="OptionsAcc" v-model="InitAcc" :disabled="disabledSelect"></select2>
					</div>

					<br>
					<label><strong>Cuenta Final</strong></label>
					<select2 :options="OptionsAcc" v-model="EndAcc" :disabled="disabledSelect"></select2>
				</div>
				<div class="col-3">
					<br>
					<div id="helpAnaliticalMajorCurrency">
						<label class="control-label">Expresar en</label>
						<select2 :options="currencies" v-model="currency"></select2>
					</div>
					<div id="helpAnaliticalMajorAllAccount">
						<label for="" class="control-label mt-4">Seleccionar todas</label>
						<div class="col-12 bootstrap-switch-mini">
    						<input type="checkbox" name="sel_account_type" id="sel_all_acc" data-on-label="SI"
                                   data-off-label="NO"
                                   class="form-control bootstrap-switch sel_pry_acc sel_all_acc_class">
                        </div>
					</div>
				</div>
			</div>
		</div>
		<div class="card-footer text-right">
			<button class="btn btn-primary btn-sm" title="Generar Reporte" data-toggle="tooltip"
                    v-on:click="OpenPdf(getUrlReport(), '_blank')" id="helpAnaliticalMajorGenerateReport">
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
            currencies:{
				type:Array,
				default:function(){
					return [];
				}
			}
        },
		data(){
			return {
				url:'/accounting/report/analyticalMajor',
				InitAcc:0,
				EndAcc:0,
				dates:null,
				OptionsAcc:[{id:0,text:'Seleccione...'}],
				disabledSelect:false,
				currency:'',
			}
		},
		created(){
			this.CalculateOptionsYears(this.year_old);
		},
		mounted(){
			const vm = this;
			vm.getAccountingAccounts();
			/**
			 * Evento para determinar los datos a requerir segun la busqueda seleccionada
			 */
			$('.sel_pry_acc').on('switchChange.bootstrapSwitch', function(e) {
				if(e.target.id === "sel_all_acc"){
					if ($('#sel_all_acc').prop('checked')) {
						if (vm.OptionsAcc.length > 1) {
							vm.disabledSelect = true;
							vm.InitAcc = vm.OptionsAcc[1].id;
							vm.EndAcc = vm.OptionsAcc[vm.OptionsAcc.length-1].id;
						}
					}else{
						vm.disabledSelect = false;
						vm.InitAcc = 0;
						vm.EndAcc = 0;
					}
				}
			});
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

				var errors = [];
				if (this.InitAcc <= 0) {
					errors.push("Debe seleccionar una cuenta de inicio.");
				}
				if (this.EndAcc <= 0) {
					errors.push("Debe seleccionar una cuenta de final.");
				}
				if (!this.currency) {
					errors.push("El tipo de moneda es obligatorio.");
				}

				if (errors.length > 0) {
					this.$refs.errorsAnalyticalMajor.showAlertMessages(errors);
					return;
				}
				this.$refs.errorsAnalyticalMajor.reset();

				var url = this.url+'/pdf';
				var InitAcc = (this.InitAcc > this.EndAcc)? this.EndAcc  : this.InitAcc;
				var EndAcc  = (this.InitAcc > this.EndAcc)? this.InitAcc : this.EndAcc;

				var dates = '/'+this.dates.initYear+'-'+this.dates.initMonth+
								  '/'+this.dates.endYear+'-'+this.dates.endMonth;

				url += dates;

				if (InitAcc != 0) { url += '/'+InitAcc; }

				if (EndAcc != 0) { url += '/'+EndAcc; }

				url += '/'+this.currency;
				return url;
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
