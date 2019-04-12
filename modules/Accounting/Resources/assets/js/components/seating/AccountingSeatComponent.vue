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
				<div class="row">
					<div class="col-3"></div>
					<div class="col-3">
						<div class="form-group">
							<label class="control-label">Por Referencia
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
							<label class="control-label">Por Origen
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
					<div v-show="typeSearch == 'reference'" class="col-12 row">
						<div class="col-2"></div>
						<div class="col-1">
							<div class="form-group">
								<label class="control-label">Referencia</label>
							</div>
						</div>
						<div class="col-7">
							<div class="form-group is-required">
								<input type="text" class="form-control"
										v-model="data.reference">
							</div>
						</div>
						<div class="col-2"></div>
					</div>
					<div v-show="typeSearch == 'origin'" class="col-12 row">
						<div class="col-2"></div>
						<div class="col-1">
							<div class="form-group">
								<label class="control-label">Generado por</label>
							</div>
						</div>
						<div class="col-7">
							<div class="form-group">
								<select2 :options="categories" v-model="data.category"></select2>
							</div>
						</div>
						<div class="col-2"></div>
						<!-- filtrado por fechas -->
						<div class="col-4"></div>
						<div class="col-3">
							<label for="" class="control-label">Por Período
								<input type="radio" 
										name="sel_filter_date"
										id="sel_fil_date_specific"
										data-on-label="SI" data-off-label="NO" 
										class="form-control bootstrap-switch sel_filterDate">
							</label>
						</div>
						<div class="col-3">
							<label for="" class="control-label">Por Mes
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
							<div class="col-2">
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
						<div class="col-12 row" v-if="filterDate == 'generic'">
							<div class="col-2"></div>
							<div class="col-2">
								<div class="form-group">
									<label class="control-label">Fecha general</label>
								</div>
							</div>
							<div class="col-3">
								<div class="form-group">
									<select2 :options="OptionMonths" v-model="data.month"></select2>
								</div>
							</div>
							<div class="col-3">
								<div class="form-group">
									<select2 :options="OptionsYears" v-model="data.year"></select2>
								</div>
							</div>
							<div class="col-2"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="card-footer text-right">
				<button class="btn btn-success btn-icon btn-round"
					data-toggle="tooltip"
					title="Realizar busqueda"
					:disabled="typeSearch==''"
					v-on:click="searchRecords()">
					<i class="fa fa-search"></i>
			</button>
			</div>
		</form>

		<v-client-table :columns="columns" :data="records" :options="table_options">
			<div slot="reference" slot-scope="props" class="text-center">
				{{ props.row.reference }}
			</div>
			<div slot="id" slot-scope="props" class="text-center">
				<button @click="changeView(props.row.id, 'edit')"
						class="btn btn-warning btn-xs btn-icon btn-action" 
						title="Modificar registro" data-toggle="tooltip">
					<i class="fa fa-edit"></i>
				</button>
				<button @click="deleteAccount(props.index,props.row.id)" 
						class="btn btn-danger btn-xs btn-icon btn-action" 
						title="Eliminar registro" data-toggle="tooltip">
					<i class="fa fa-trash-o"></i>
				</button>
			</div>
		</v-client-table>
	</div>
</template>

<script>
	export default{
		props:['categories'],
		data(){
			return {
				errors:[],
				records: [],
				columns: ['reference', 'seating_content', 'id'],
				typeSearch:'', //states: 'reference', 'origin'
				filterDate:'', //states: 'generic','specific'
				data:{
					reference:'',
					category:0,
					init:'',
					end:'',
					year:0,
					month:0,
				},
				OptionMonths:[
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
				OptionsYears:[],
			}
		},
		created(){
			this.CalculateOptionsYears();
			this.table_options.headings = {
				'reference': 'REFERENCIA',
				'seating_content': 'ASIENTO CONTABLE',
				'id': 'ACCIÓN'
			};
			this.table_options.sortable = ['reference'];
			this.table_options.filterable = ['reference'];
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
			CalculateOptionsYears:function(){
				var date = new Date();
				this.OptionsYears.push({
					id:0,
					text:'Todos'
				});
				for (var year = date.getFullYear(); year >= 2007; year--) {
					this.OptionsYears.push({
						id:year,
						text:year
					});
				}
			},
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
			searchRecords:function(){

				// manejo de errores
				if (this.ErrorsInForm()) {
					return ;
				}

				axios.post('/accounting/seating/Filter-Records',{
					'typeSearch':this.typeSearch,
					'filterDate':this.filterDate,
					'data':this.data,
				}).then(response=>{
					console.log(response.data.records);
					this.errors = [];
				});
			},
		},
	}
</script>