<template>
	<div class="card">
		<div class="card-header">
			<h6 class="card-title text-uppercase">Bienes Institucionales</h6>
			<div class="card-btns">
				<a href="#" class="btn btn-sm btn-primary btn-custom" @click="redirect_back(route_list)" 
				   title="Ir atrás" data-toggle="tooltip">
					<i class="fa fa-reply"></i>
				</a>
				<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar" 
				   data-toggle="tooltip">
					<i class="now-ui-icons arrows-1_minimal-up"></i>
				</a>
			</div>
		</div>
		<div class="card-body">
			<div class="alert alert-danger" v-if="errors.length > 0">
				<ul>
					<li v-for="error in errors">{{ error }}</li>
				</ul>
			</div>
			<div class="row">
				<div class="col-md-12">
					<strong>Tipo de Reporte</strong>
				</div>
				<div class="col-md-2">
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>General</label>
						<div class="col-12">
							<input type="radio" name="type_report" value="general" id="sel_general_report" 
								   class="form-control bootstrap-switch bootstrap-switch-mini sel_type_report" 
								   data-on-label="SI" data-off-label="NO">
							<input type="hidden" v-model="record.id">
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>Por Clasificación</label>
						<div class="col-12">
							<input type="radio" name="type_report" value="clasification" id="sel_clasification_report" 
								   class="form-control bootstrap-switch bootstrap-switch-mini sel_type_report" 
								   data-on-label="SI" data-off-label="NO">
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>Por Dependencia</label>
						<div class="col-12">
							<input type="radio" name="type_report" value="dependence" id="sel_dependence_report" 
								   class="form-control bootstrap-switch bootstrap-switch-mini sel_type_report" 
								   data-on-label="SI" data-off-label="NO">
						</div>
					</div>
				</div>
			</div>
			<div v-show="this.record.type_report == 'general'">
				<div class="row">
					<div class="col-md-2">
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Busqueda por Periodo</label>
							<div class="col-12">
								<input type="radio" name="type_search" value="date" id="sel_search_date" 
									   class="form-control bootstrap-switch bootstrap-switch-mini sel_type_search" 
									   data-on-label="SI" data-off-label="NO">
							</div>
						</div>
					</div>

					<div class="col-md-4">
						<div class=" form-group">
							<label>Busqueda por Mes</label>
							<div class="col-12">
								<input type="radio" name="type_search" value="mes" id="sel_search_mes" 
									   class="form-control bootstrap-switch bootstrap-switch-mini sel_type_search" 
									   data-on-label="SI" data-off-label="NO">
							</div>
						</div>
					</div>
				</div>

				<div v-show="this.record.type_search == 'mes'">
					<div class="row">
						<div class="col-md-2">
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Mes:</label>
								<select2 :options="mes" 
										 v-model="record.mes_id"></select2>
		                    </div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Año:</label>
								<input type="number" data-toggle="tooltip" min="0"
										   title="Indique el año de busqueda" 
										   class="form-control input-sm" v-model="record.year">
		                    </div>
						</div>
					</div>
				</div>
				<div v-show="this.record.type_search == 'date'">
					<div class="row">
						<div class="col-md-2">
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Desde:</label>
								<div class="input-group input-sm">
				                    <span class="input-group-addon">
				                        <i class="now-ui-icons ui-1_calendar-60"></i>
				                    </span>
				                    <input type="date" data-toggle="tooltip" 
										   title="Indique la fecha minima de busqueda" 
										   class="form-control input-sm" v-model="record.start_date">
				                </div>
		                    </div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Hasta:</label>
								<div class="input-group input-sm">
				                    <span class="input-group-addon">
				                        <i class="now-ui-icons ui-1_calendar-60"></i>
				                    </span>
				                    <input type="date" data-toggle="tooltip" 
										   title="Indique la fecha maxima de busqueda" 
										   class="form-control input-sm" v-model="record.end_date">
				                </div>
		                    </div>
						</div>
					</div>
				</div>
			</div>
			<div v-show="this.record.type_report == 'clasification'">
				<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<label>Tipo de Bien:</label>
							<select2 :options="asset_types"
									 @input="getAssetCategories()"
									 v-model="record.asset_type_id"></select2>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>Categoria General:</label>
							<select2 :options="asset_categories"
									 @input="getAssetSubcategories()"
									 v-model="record.asset_category_id"></select2>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>Subcategoria:</label>
							<select2 :options="asset_subcategories"
									 @input="getAssetSpecificCategories()"
									 v-model="record.asset_subcategory_id"></select2>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>Categoria Específica:</label>
							<select2 :options="asset_specific_categories"
									v-model="record.asset_specific_category_id"></select2>
						</div>
					</div>
				</div>
			</div>
			<div v-show="this.record.type_report == 'dependence'">
				<div class="row">
					<div class="col-md-2"></div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Institución:</label>
							<select2 :options="institutions"
									 @input="getDepartments()"
									 v-model="record.institution_id"></select2>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Departamento/Dependencia:</label>
							<select2 :options="departments"
									v-model="record.department_id"></select2>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-12">
					<button type="button" class='btn btn-sm btn-info btn-custom float-right'
							@click="filterRecords()" v-show="this.record.type_report != ''">
						<i class="fa fa-search"></i>
						<span>Buscar</span>
					</button>
				</div>
			</div>
			<hr>
			<v-client-table :columns="columns" :data="records" :options="table_options">
				
				<div slot="institution" slot-scope="props" class="text-center">
					<span>{{ (props.row.institution)? props.row.institution.name:((props.row.institution_id)?props.row.institution_id:'N/A') }}</span>
					
				</div>
				<div slot="condition" slot-scope="props" class="text-center">
					<span>{{ (props.row.asset_condition)? props.row.asset_condition.name:props.row.asset_condition_id }}</span>
				</div>
				<div slot="status" slot-scope="props" class="text-center">
					<span>{{ (props.row.asset_status)? props.row.asset_status.name:props.row.asset_status_id }}</span>
				</div>
				
			</v-client-table>
		</div>

        <div class="card-footer text-right">
        	<button type="button" class='btn btn-sm btn-primary btn-custom'
					@click="createRecord()">
				<i class="fa fa-file-pdf-o"></i>
				<span>Generar Reporte</span>
			</button>
        </div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				record: {
					id: '',
					type_search: '',
					type_report: '',

					asset_type_id: '',
					asset_category_id: '',
					asset_subcategory_id:'',
					asset_specific_category_id: '',

					department_id: '',
					institution_id: '',

					mes_id: '',
					year: '',
					start_date: '',
					end_date: '',
				},

				records: [],
				errors: [],
				columns: ['inventory_serial', 'condition', 'status', 'serial', 'marca', 'model'],
				mes: [{"id":"","text":"Todos"},
						{"id":1,"text":"Enero"},
						{"id":2,"text":"Febrero"},
						{"id":3,"text":"Marzo"},
						{"id":4,"text":"Abril"},
						{"id":5,"text":"Mayo"},
						{"id":6,"text":"Junio"},
						{"id":7,"text":"Julio"},
						{"id":8,"text":"Agosto"},
						{"id":9,"text":"Septiempre"},
						{"id":10,"text":"Octubre"},
						{"id":11,"text":"Noviembre"},
						{"id":12,"text":"Diciembre"}],
				asset_types: [],
				asset_categories: [],
				asset_subcategories: [],
				asset_specific_categories: [],
				institutions: [],
				departments: [],

				table_options: {
					headings: {
						'inventory_serial': 'Código',
						'condition': 'Condición Física',
						'status': 'Estatus de Uso',
						'serial': 'Serial',
						'marca': 'Marca',
						'model': 'Modelo',
					},
					sortable: ['inventory_serial', 'condition', 'status', 'serial', 'marca', 'model'],
					filterable: ['inventory_serial', 'condition', 'status', 'serial', 'marca', 'model'],
					orderBy: { 'column': 'id'}
				}
			}
		},

		created() {
			this.loadAssets();
			this.getInstitutions();
			this.getAssetTypes();
		},
		mounted() {
			this.switchHandler('type_report');
			this.switchHandler('type_search');
		},
		methods: {

			reset() {
				this.record = {
					id: '',
					type_search: '',
					type_report: '',

					asset_type_id: '',
					asset_category_id: '',
					asset_subcategory_id:'',
					asset_specific_category_id: '',

					department_id: '',
					institution_id: '',

					mes_id: '',
					year: '',
					start_date: '',
					end_date: '',
				};
				
			},

			loadAssets() {
				const vm = this;
				axios.get('/asset/registers/vue-list').then(response => {
					vm.records = response.data.records;
				});
			},
			createRecord() {
				const vm = this;
				var fields = {};
				var url = 'asset/reports';

				if (vm.record.type_report == '') {
					bootbox.alert("Debe seleccionar el tipo de reporte a generar");
					return false;
				}
				if (vm.record.type_report == 'dependence') {
					return false;
				}

				for (var index in this.record) {
					fields[index] = this.record[index];
				}
				axios.post('/' + url, fields).then(response => {
					if (response.data.result == false)
						location.href = response.data.redirect;
					else if (typeof(response.data.redirect) !== "undefined") {
						window.open(response.data.redirect, '_blank');
					}
					else {
						vm.reset();
					}
				}).catch(error => {
					vm.errors = [];

					if (typeof(error.response) !="undefined") {
						for (var index in error.response.data.errors) {
							if (error.response.data.errors[index]) {
								vm.errors.push(error.response.data.errors[index][0]);
							}
						}
					}
				});

			},
			filterRecords() {
				const vm = this;
				var url =  '/asset/registers/search';
				var fields = {};

				if(vm.record.type_report == 'general'){
					url += '/general';
					if(vm.record.type_search == 'date'){
						fields = {
							start_date: vm.record.start_date,
							end_date: vm.record.end_date,
						};
					}
					else if(vm.record.type_search == 'mes'){
						fields = {
							mes_id: vm.record.mes_id,
							year: vm.record.year,
						};
					}
				}
				else if(vm.record.type_report == 'clasification') {
					url += '/clasification';
					fields = {
						asset_type: vm.record.asset_type_id,
						asset_category: vm.record.asset_category_id,
						asset_subcategory: vm.record.asset_subcategory_id,
						asset_specific_category: vm.record.asset_specific_category_id
					}
				}
				else if(vm.record.type_report == 'dependence') {
					url += '/dependence';
					fields = {
						department: vm.record.department_id,
						institution: vm.record.instituion_id
					}	
				}
				if((vm.record.type_report != '')||((vm.record.type_report == 'general')&&(vm.record.type_search != ''))){
					axios.post(url, fields).then(response => {
						vm.records = response.data.records;
					});
				}
			},
		}
	};
</script>
