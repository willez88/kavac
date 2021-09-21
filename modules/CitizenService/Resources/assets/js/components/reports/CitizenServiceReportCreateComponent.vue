<template>
	<div class="card">
		<div class="card-header">
			<h6 class="card-title text-uppercase">Reportes</h6>
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
				<div class="col-md-6">
					<div class="form-group is-required">
						<label for="citizenserviceRequestTypes">Tipo de solicitud</label>
					    <v-multiselect :options="citizen_service_request_types" track_by="text"
								v-model="record.citizen_service_request_types"
							    :hide_selected="false">
					    </v-multiselect>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group is-required">
						<label>Estado de la solicitud:</label>
						<v-multiselect :options="citizen_service_states" track_by="text"
								v-model="record.citizen_service_states"
							    :hide_selected="false">
					    </v-multiselect>
	                </div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group" style="text-align: right;">
						<label>Busqueda por periodo</label>
						<div class="col-12">
                            <div class="col-12 bootstrap-switch-mini">
    							<input type="radio" name="type_search" value="period" id="sel_search_period"
    								   class="form-control bootstrap-switch bootstrap-switch-mini sel_type_search"
    								   data-on-label="SI" data-off-label="NO">
                            </div>
							<input type="hidden" v-model="record.type_search">
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class=" form-group">
						<label>Busqueda por fecha </label>
						<div class="col-12">
                            <div class="col-12 bootstrap-switch-mini">
								<input type="radio" name="type_search" value="date" id="sel_search_date"
									   class="form-control bootstrap-switch bootstrap-switch-mini sel_type_search"
									   data-on-label="SI" data-off-label="NO">
                            </div>
						</div>
					</div>
				</div>
			</div>
			<div v-show="this.record.type_search == 'period'">
				<div class="row">
					<div class="col-md-4 offset-2">
						<div class="form-group">
							<label>Desde:</label>
							<div class="input-group input-sm">
			                    <span class="input-group-addon">
			                        <i class="now-ui-icons ui-1_calendar-60"></i>
			                    </span>
			                    <input type="date" data-toggle="tooltip" title="Indique la fecha minima de busqueda"
									   class="form-control input-sm no-restrict" v-model="record.start_date">
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
			                    <input type="date" data-toggle="tooltip" title="Indique la fecha maxima de busqueda"
									   class="form-control input-sm no-restrict" v-model="record.end_date">
			                </div>
	                    </div>
					</div>
				</div>
			</div>
			<div v-show="this.record.type_search == 'date'">
				<div class="col-md-4 offset-2">
					<div class="form-group">
						<label >Fecha</label>
    					<input type="date" class="form-control input-sm" data-toggle="tooltip"
                               title="Indique la fecha de solicitud" v-model="record.date">
    				</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<button type="button" class='btn btn-sm btn-info btn-custom float-right' data-toggle="tooltip"
							@click="filterRecords()" v-show="this.record.type_search != ''"
							title="Buscar registros">
						<i class="fa fa-search"></i>
					</button>
				</div>
			</div>
			<hr>
			<v-client-table :columns="columns" :data="records" :options="table_options">
				<div slot="code" slot-scope="props" class="text-center">
					<span>{{ props.row.code }}</span>
				</div>
				<div slot="id" slot-scope="props" class="text-center">
					<div class="d-inline-flex"></div>
				</div>
				<div slot="id" slot-scope="props" class="text-center">
					<div class="d-inline-flex">
						<button @click="createReport()" class="btn btn-primary btn-xs btn-icon btn-action"
                                title="Generar reporte" data-toggle="tooltip" v-has-tooltip type="button">
							<i class="fa fa-file-pdf-o"></i>
						</button>
					</div>
				</div>
				<div slot="requested_by" slot-scope="props" class="text-center">
	                <span>{{ props.row.first_name + ' ' + props.row.last_name }}</span>
	        	</div>
	        	<div slot="citizen_service_request_type_id" slot-scope="props" class="text-center">
	                <span>{{ props.row.citizen_service_request_type ? props.row.citizen_service_request_type.name :''}}</span>
	        	</div>
			</v-client-table>
		</div>
	</div>

</template>

<script>
	export default {
		data() {
			return {
				record: {
					id: '',
					citizen_service_request_types: [],
					citizen_service_states: [],
					type_search: '',
					date: '',
					start_date: '',
					end_date: '',
				},

				records: [],
				errors: [],
				columns: ['requested_by', 'citizen_service_request_type_id', 'state', 'date', 'id'],
				citizen_service_request_types: [],
				citizen_service_states: [
					{
						id: '',
						text:'Seleccione..'
					},
					{
						id: 'Iniciado',
						text:'Iniciado'
					},
					{
						id: 'Culminado',
						text:'Culminado'
					},
				]

			}
		},
		created() {
			this.table_options.headings = {
				'requested_by': 'Solicitado por',
				'citizen_service_request_type_id': 'Tipos de solicitud',
				'state': 'Estado de la solicitud',
				'date': 'Fecha de la solicitud',
				'id': 'Acción'
			};

			this.table_options.sortable = ['requested_by', 'citizen_service_request_type_id', 'state', 'date'];
			this.table_options.filterable = ['requested_by', 'citizen_service_request_type_id', 'state', 'date'];

			this.getCitizenServiceRequestTypes();
		},
		mounted() {
			this.switchHandler('type_search');
		},

		methods: {
			reset() {
				this.record = {
					id: '',
					citizen_service_request_types: [],
					citizen_service_states: [],
					type_search: '',
					date: '',
					start_date: '',
					end_date: '',
				};
			},

			createReport() {

				const vm = this;
				vm.loading = true;
				var fields = {};
				for (var index in this.records) {
					fields[index] = this.records[index];
				}
				
				axios.post('/citizenservice/reports/request/create' , fields).then(response => {
					if (response.data.result == false)
						location.href = response.data.redirect;
					else if (typeof(response.data.redirect) !== "undefined") {
						window.open(response.data.redirect, '_blank');
					}
					else {
						vm.reset();
					}
					vm.loading = false;
				}).catch(error => {
					vm.errors = [];

					if (typeof(error.response) !="undefined") {
						for (var index in error.response.data.errors) {
							if (error.response.data.errors[index]) {
								vm.errors.push(error.response.data.errors[index][0]);
							}
						}
					}
					vm.loading = false;
				});

			},
			filterRecords() {

				const vm = this;
				var url =  '/citizenservice/reports/search';

				var fields = {};
				if(vm.record.type_search == 'period'){
					url += '/period';
						fields = {
							start_date: vm.record.start_date,
							end_date: vm.record.end_date,
							citizen_service_request_types: vm.record.citizen_service_request_types,
							citizen_service_states: vm.record.citizen_service_states
						};
					}
				else if(vm.record.type_search == 'date'){
					url += '/date';


						fields = {
							date: vm.record.date,
							citizen_service_request_types: vm.record.citizen_service_request_types,
							citizen_service_states: vm.record.citizen_service_states
						};
					}

				if(vm.record.type_search != ''){
					axios.post(url, fields).then(response => {
						vm.records = response.data.records;

					});
				}
			}
		},
    };
</script>
