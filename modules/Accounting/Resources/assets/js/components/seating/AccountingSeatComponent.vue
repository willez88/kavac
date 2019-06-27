<template>
	<div>
		<form @submit.prevent="" class="form-horizontal">
			<div class="card-body">
				<div class="alert alert-danger" role="alert" v-if="errors.length > 0">
					<div class="container">
						<div class="alert-icon">
							<i class="now-ui-icons objects_support-17"></i>
						</div>
						<strong>Cuidado!</strong> Debe verificar los siguientes errores antes de continuar:
						<ul>
							<li v-for="error in errors">{{ error }}</li>
						</ul>
					</div>
				</div>
				<div class="alert alert-warning" role="alert" v-if="warnings.length > 0">
					<div class="container">
						<div class="alert-icon">
							<i class="now-ui-icons objects_support-17"></i>
						</div>
						<strong>Atención!</strong>
						<ul>
							<li v-for="warning in warnings">{{ warning }}</li>
						</ul>
					</div>
				</div>
				<div class="row">
					<div class="col-3"></div>
					<div class="col-3">
						<div class="form-group">
							<label class="control-label">Por Referencia
								<br>
								<input type="radio" 
										name="sel_Search"
										id="sel_ref"
										data-on-label="SI" data-off-label="NO" 
										class="form-control bootstrap-switch sel_search">
							</label>
						</div>
					</div>
					<div class="col-1"></div>
					<div class="col-3">
						<div class="form-group">
							<label class="control-label">Por Origen <br>
								<input type="radio"
										name="sel_Search" 
										id="sel_origin"
										data-on-label="SI" data-off-label="NO" 
										class="form-control bootstrap-switch sel_search">
							</label>
						</div>
					</div>
					<div class="col-2"></div>
					<br><br>
					<div class="col-12 row">
							<div class="col-2"></div>
							<div class="col-1">
								<div class="form-group">
									<label class="control-label">Por Institución</label>
								</div>
							</div>
							<div class="col-7">
								<div class="form-group">
									<select2 :options="institutions" v-model="data.institution"></select2>
								</div>
							</div>
							<div class="col-2"></div>
						</div>
					<div class="col-12 row">
						<div class="col-2"></div>
						<div class="col-1">
							<div class="form-group">
								<label class="control-label">Referencia</label>
							</div>
						</div>
						<div class="col-7">
							<div class="form-group is-required">
								<input :disabled="typeSearch != 'reference'" type="text" class="form-control"
										v-model="data.reference">
							</div>
						</div>
						<div class="col-2"></div>
					</div>
					<div class="col-12 row">
						<div class="col-2"></div>
						<div class="col-1">
							<div class="form-group">
								<label class="control-label">Generado por</label>
							</div>
						</div>
						<div class="col-7">
							<div class="form-group is-required">
								<select2 :disabled="typeSearch != 'origin'" :options="categories" v-model="data.category"></select2>
							</div>
						</div>
						<!-- filtrado por fechas -->
						<div class="col-3"></div>
						<div class="col-3">
							<label for="" class="control-label">Por Período <br>
								<input type="radio" 
										name="sel_filter_date"
										id="sel_fil_date_specific"
										data-on-label="SI" data-off-label="NO"
										class="form-control bootstrap-switch sel_filterDate">
							</label>
						</div>
						<div class="col-3">
							<label for="" class="control-label">Por Mes <br>
								<input type="radio"
										name="sel_filter_date" 
										id="sel_fil_date_generic"
										data-on-label="SI" data-off-label="NO" 
										class="form-control bootstrap-switch sel_filterDate">
							</label>
						</div>
						<div class="col-2"></div>
						
						<!-- fecha detallada -->
						<div class="col-12 row" v-if="filterDate == 'specific'">
							<div class="col-2"></div>
							<div class="col-1">
								<div class="form-group">
									<label class="control-label">Por fecha</label>
								</div>
							</div>
							<div class="col-3">
								<div class="form-group is-required">
									<label class="control-label">desde</label>
									<input type="date" class="form-control" v-model="data.init">
								</div>
							</div>
							<div class="col-3">
								<div class="form-group is-required">
									<label class="control-label">hasta</label>
									<input type="date" class="form-control" v-model="data.end">
								</div>
							</div>
							<div class="col-2"></div>					
						</div>
						<div class="col-12 row" v-else>
							<div class="col-3"></div>
							<div class="col-3">
								<div class="form-group is-required">
									<select2 :disabled="!filterDate" :options="months" v-model="data.month"></select2>
								</div>
							</div>
							<div class="col-3">
								<div class="form-group is-required">
									<select2 :disabled="!filterDate" :options="years" v-model="data.year"></select2>
								</div>
							</div>
							<div class="col-3"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="card-footer text-right">
				<button class="btn btn-info btn-xs"
					data-toggle="tooltip"
					title="Consultar Registros"
					:disabled="typeSearch=='' || filterDate ==''"
					v-on:click="searchRecords()">
					Buscar
					<i class="fa fa-search"></i>
			</button>
			</div>
		</form>

		<div v-if="records.length > 0">
			<accounting-seat-listing :seating="records" :currency="currency" :show="'approved'" />
		</div>
	</div>
</template>

<script>
	export default{
		props:['categories','year_old','institutions','currency'],
		data(){
			return {
				errors:[],
				warnings:[],
				records: [],
				typeSearch:'', //states: 'reference', 'origin'
				filterDate:'', //states: 'generic','specific'
				data:{
					reference:'',
					category:0,
					init:'',
					end:'',
					year:0,
					month:0,
					institution:'',
				},
				months:[
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
			}
		},
		created(){
			this.CalculateOptionsYears(this.year_old, true);
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

				if (this.typeSearch == 'reference' && this.data.reference == '') {
					this.errors = [];
					this.errors.push('El campo referencia es obligatorio');
					return true;
				}

				if (this.typeSearch == 'origin') {
					if (this.filterDate == '') {
						this.errors = [];
						this.errors.push('Debe seleccionar un rango de busqueda (por perdiodo o por mes.)');
						return true;
					}

					if (this.filterDate == 'specific' && (this.data.init == '' || this.data.end == '')) {
						this.errors = [];
						this.errors.push('Debe especificar el rango de las fechas');
						return true;
					}
				}
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
				axios.post('/accounting/seating/Filter-Records',{
					'typeSearch':this.typeSearch,
					'filterDate':this.filterDate,
					'data':this.data,
				}).then(response=>{
					if (response.data.records.length == 0) {
						this.warnings = [];
						this.warnings.push('No se encontraron registros.')
					}
					this.records = response.data.records;
					EventBus.$emit('reload:listing',response.data.records);
				});
			},
		},
	}
</script>