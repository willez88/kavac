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
				<div class="col-md-4">
						<div class="form-group is-required">
							<label for="citizenserviceRequestTypes">Tipo de Solicitud</label>
							<select2 :options="citizen_service_request_types"
									 v-model="record.citizen_service_request_type_id"></select2>

						
							
						</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Estado de la Solicitud:</label>
						<select2 :options="citizen_service_states"
						v-model="record.citizenservice_id"></select2>
	                </div>
				</div>

			
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Busqueda por Periodo</label>
						<div class="col-12">
							<input type="radio" name="type_search" value="period" id="sel_search_period" 
								   class="form-control bootstrap-switch bootstrap-switch-mini sel_type_search" 
								   data-on-label="SI" data-off-label="NO">
							<input type="hidden" v-model="record.type_search">
							
						</div>
					</div>
				</div>
				<div class="col-md-4">
						<div class=" form-group">
							<label>Busqueda por Fecha </label>
							<div class="col-12">
								<input type="radio" name="type_search" value="date" id="sel_search_date" 
									   class="form-control bootstrap-switch bootstrap-switch-mini sel_type_search" 
									   data-on-label="SI" data-off-label="NO">
							</div>
						</div>
				</div>
			</div>
				
				<div v-show="this.record.type_search == 'period'">
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
				<div v-show="this.record.type_search == 'date'">
					<div class="col-md-4">
						<div class="form-group">
							<label >Fecha</label>
        					<input type="date"
        								   class="form-control input-sm" data-toggle="tooltip"
        								   title="Indique la fecha de solicitud"
        								   v-model="record.date">
        				</div>
					</div>
				</div>
				
			<div class="row">
				<div class="col-12">
					<button type="button" class='btn btn-sm btn-info btn-custom float-right'
							@click="filterRecords()" v-show="this.record.type_search != ''">
						<i class="fa fa-search"></i>
						<span>Buscar</span>
					</button>
				</div>
			</div>
		
			

			<hr>
			<v-client-table :columns="columns" :data="records" :options="table_options">
				<div slot="code" slot-scope="props" class="text-center">
					<span>
						{{ props.row.code }}
					</span>
				</div>
				<div slot="id" slot-scope="props" class="text-center">
					<div class="d-inline-flex">
						
					

					</div>
				</div>
				<div slot="requested_by" slot-scope="props" class="text-center">
	                <span>
	                    {{ 
	                        props.row.first_name + ' ' + props.row.last_name
	                    }}
	                </span>
	        	</div>
			</v-client-table>
			<div class="row">
				<div class="col-12" align="right">
					<button type="button" @click="createReport()"
						class='btn btn-sm btn-primary btn-custom'>
						<i class="fa fa-plus-circle"></i>
						<span>	Generar Reporte	</span>
					</button>
				</div>
			</div>

			</div>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				record: {
					id: '',
					citizen_service_request_types_id: '',
					type_search: '',
					date: '',
					start_date: '',
					end_date: '',
				},
			
				records: [],
				errors: [],
				columns: ['requested_by', 'citizen_service_request_type_id', 'state', 'date'],
				citizen_service_request_types: [],
				citizen_service_states: [
					{
						id: '',
						text:'Seleccione..'
					},
					{
						id: 1,
						text:'Iniciado'
					},
					{
						id: 2,
						text:'Culminado'
					},
				]
				
			}
		},
		created() {
			this.table_options.headings = {
				'requested_by': 'Solicitado por',
				'citizen_service_request_type_id': 'Tipos de solicitud',
				'state': 'Estado de la Solicitud',
				'date': 'Fecha de la Solicitud'
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
					citizen_service_request_types_id: '',
					type_search: '',
					date: '',
					start_date: '',
					end_date: '',
					
				};
			
		
	   
			},
			filterRecords() {
				const vm = this;
				var fields = {};

				if(vm.record.type_search == 'period'){
						fields = {
							start_date: vm.record.start_date,
							end_date: vm.record.end_date,
						};
					}
				else if(vm.record.type_search == 'date'){
						fields = {
							date: vm.record.date,
						};
					}
			}
		},
		
	
};
</script>