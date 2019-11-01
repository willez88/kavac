<template>
	<div>
		<form @submit.prevent="" class="form-horizontal">
			<div class="card-body">
				
				<accounting-show-errors ref="accountingEntriesSearch" />

				<div class="row">
					<div class="col-2" id="helpSearchEntriesReference">
						<div class="form-group">
							<label class="control-label">Por Referencia</label><br>
							<input type="radio" 
									name="sel_Search"
									id="sel_ref"
									data-on-label="SI" data-off-label="NO" 
									class="form-control bootstrap-switch sel_search">
						</div>
					</div>
					<div class="col-2" id="helpSearchEntriesCategory">
						<div class="form-group">
							<label class="control-label">Por Categoría</label><br>
							<input type="radio"
									name="sel_Search" 
									id="sel_origin"
									checked="true" 
									data-on-label="SI" data-off-label="NO" 
									class="form-control bootstrap-switch sel_search">
						</div>
					</div>
					<div class="col-8 row">
						<div class="col-7" id="helpSearchEntriesInstitution">
							<div class="form-group">
								<label class="control-label">Por Institución</label><br>
								<select2 :options="institutions" v-model="data.institution"></select2>
							</div>
						</div>
						<div class="col-5" id="helpSearchEntriesInputReference">
							<div :class="(typeSearch != 'reference')? 'form-group': 'form-group is-required'">
								<label class="control-label">Referencia</label>
								<input :disabled="typeSearch != 'reference'" type="text" class="form-control"
									v-model="data.reference" placeholder="Referencia">
							</div>	
						</div>
					</div>

					<!-- filtrado por fechas -->
					<div class="col-2" id="helpSearchEntriesDateSpecific">
						<label for="" class="control-label">Por Período</label><br>
						<input type="radio" 
								name="sel_filter_date"
								id="sel_fil_date_specific"
								data-on-label="SI" data-off-label="NO"
								class="form-control bootstrap-switch sel_filterDate">
					</div>
					<div class="col-2" id="helpSearchEntriesDateGeneric">
						<label for="" class="control-label">Por Mes</label><br>
						<input type="radio"
								name="sel_filter_date" 
								id="sel_fil_date_generic"
								checked="true" 
								data-on-label="SI" data-off-label="NO" 
								class="form-control bootstrap-switch sel_filterDate">
					</div>

					<div class="col-8 row">
						<!-- fecha detallada -->
						<div class="col-7 row" style="padding-right: 0rem;" v-if="filterDate == 'specific'"
							id="helpSearchEntriesDateRange">
							<div class="col-6">
								<div class="form-group is-required">
									<label class="control-label">Desde</label>
									<input type="date" class="form-control" v-model="data.init">
								</div>
							</div>
							<div class="col-6" style="padding-right: 0rem;">
								<div class="form-group is-required">
									<label class="control-label">Hasta</label>
									<input type="date" class="form-control" v-model="data.end">
								</div>
							</div>				
						</div>
						<div class="col-7 row" style="padding-right: 0rem;" 
							id="helpSearchEntriesDateRange" v-else>
							<div class="col-6">
								<div class="form-group is-required">
									<label class="control-label">Mes</label>
									<select2 :disabled="!filterDate" :options="months" v-model="data.month"></select2>
								</div>
							</div>
							<div class="col-6" style="padding-right: 0rem;">
								<div class="form-group is-required">
									<label class="control-label">Año</label>
									<select2 :disabled="!filterDate" :options="years" v-model="data.year"></select2>
								</div>
							</div>
						</div>
						<div class="col-5" style="margin-left: 1.8rem;" id="helpSearchEntriesInputCategory">
							<div :class="(typeSearch != 'origin')? 'form-group': 'form-group is-required'">
								<label class="control-label">Por Categoría</label><br>
								<select2 :disabled="typeSearch != 'origin'" :options="categories" v-model="data.category"></select2>
							</div>
						</div>
						
					</div>
				</div>
			</div>
			<div class="card-footer text-right">
				<button class="btn btn-info btn-sm"
					data-toggle="tooltip"
					title="Buscar asientos contables aprobados"
					v-on:click="searchRecords()">
					Buscar 
					<i class="fa fa-search"></i>
			</button>
			</div>
		</form>

		<div v-if="records.length > 0">
			<!-- <accounting-entry-listing :seating="records" :currency="currency" :show="'approved'" /> -->
		</div>
	</div>
</template>

<script>
	export default{
		props:{
            categories:{
                type:Array,
                default: []
            },
            year_old:{
                type:[String,Number],
                default: 0
            },
            institutions:{
                type:Array,
                default: []
            },
            currency:{
                type:Object,
                default: null
            },
        },
		data(){
			return {
				records: [],
				typeSearch:'origin', //states: 'reference', 'origin'
				filterDate:'generic', //states: 'generic','specific'
				data:{
					reference:'',
					category:0,
					init:'',
					end:'',
					year:0,
					month:0,
					institution:'',
				},
			}
		},
		created(){
			this.CalculateOptionsYears(this.year_old, true);
			this.months.unshift({id:0, text:'Todos'});
		},
		mounted(){

			/** 
			 * Evento para determinar los datos a requerir segun la busqueda seleccionada
			 */
			const vm = this;
			$('.sel_search').on('switchChange.bootstrapSwitch', function(e) {
				if (e.target.id === "sel_ref") {
					vm.typeSearch = 'reference';
				}
				else if (e.target.id === "sel_origin") {
					vm.typeSearch = 'origin';
				}
			});

			$('.sel_filterDate').on('switchChange.bootstrapSwitch', function(e) {
				if (e.target.id === "sel_fil_date_specific") {
					vm.filterDate = 'specific';
				}
				else if (e.target.id === "sel_fil_date_generic") {
					vm.filterDate = 'generic';
				}
			});
		},
		methods:{
			/**
			* Funcion para la verificación y manejo de errores
			*
			* @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
			* @return {boolean} Devuelve true si la información no cumple algun campo
			*/
			ErrorsInForm:function(){
				var errors = [];
				if (this.typeSearch == 'reference' && this.data.reference == '') {
					errors.push('El campo referencia es obligatorio');
				}

				if (this.typeSearch == 'origin') {
					if (this.filterDate == '') {
						errors.push('Debe seleccionar un rango de busqueda (por perdiodo o por mes.)');
					}

					if (this.filterDate == 'specific' && (this.data.init == '' || this.data.end == '')) {
						errors.push('Debe especificar el rango de las fechas');
					}
				}

				if (errors.length > 0) {
					this.$refs.accountingEntriesSearch.showAlertMessages(errors);
					return true;
				}
				this.$refs.accountingEntriesSearch.reset();
				return false;
			},

			/**
			* Obtiene la información de los asientos contables
			*
			* @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
			*/
			searchRecords:function(){

				// manejo de errores
				if (this.ErrorsInForm()) {
					return ;
				}
				const vm = this;
				axios.post('/accounting/entries/Filter-Records',{
					'typeSearch':this.typeSearch,
					'filterDate':this.filterDate,
					'data':this.data,
				}).then(response=>{
					if (response.data.records.length == 0) {
						this.$refs.accountingEntriesSearch.showAlertMessages('No se encontraron asientos contables aprobados con los parámetros de busqueda dados.', 'primary');
					}
					this.records = response.data.records;
					EventBus.$emit('list:entries',{
						records:response.data.records,
						currency:this.currency,
					});
				});
			},
		},
	};
</script>
