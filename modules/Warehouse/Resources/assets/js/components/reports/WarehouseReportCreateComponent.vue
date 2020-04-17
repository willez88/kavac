<template>
	<section id="WarehouseReportForm">
		<div class="card-body">
			<div class="alert alert-danger" v-if="errors.length > 0">
				<ul>
					<li v-for="error in errors">{{ error }}</li>
				</ul>
			</div>

			<div class="row">
				<div class="col-md-12">
					<strong>Filtros</strong>
				</div>
				<div class="col-md-6" id="helpWarehouseRequestProject">
					<div class=" form-group is-required">
						<label class="mb-4">
                            <div class="bootstrap-switch-mini">
    							<input type="radio" name="project_centralized_action" value="project" id="sel_project"
    							   class="form-control bootstrap-switch bootstrap-switch-mini sel_pry_acc"
    							   data-on-label="SI" data-off-label="NO">
    							Proyecto
                            </div>
                        </label>
						<select2 :options="budget_projects" id="budget_project_id" @input="getBudgetSpecificActions('Project')" disabled
							v-model="record.budget_project_id"></select2>

					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<strong>Filtros</strong>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Operación:</label>
						<select2 :options="warehouse_operations"
								 v-model="record.warehouse_operation_id"></select2>
						<input type="hidden" v-model="record.id">
	                </div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Producto:</label>
						<select2 :options="warehouse_products"
								 v-model="record.warehouse_product_id"></select2>
	                </div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Almacén:</label>
						<select2 :options="warehouses"
								 v-model="record.warehouse_id"></select2>
	                </div>
				</div>
				<div class="col-md-6" id="helpWarehouseRequestProject">
					<div class=" form-group is-required">
						<label class="mb-4">
                            <div class="bootstrap-switch-mini">
    							<input type="radio" name="project_centralized_action" value="project" id="sel_project"
    							   class="form-control bootstrap-switch bootstrap-switch-mini sel_pry_acc"
    							   data-on-label="SI" data-off-label="NO">
    							Proyecto
                            </div>
                        </label>
						<select2 :options="budget_projects" id="budget_project_id" @input="getBudgetSpecificActions('Project')" disabled
							v-model="record.budget_project_id"></select2>

					</div>
				</div>
				<div class="col-md-6" id="helpWarehouseRequestCentralizedAction">
					<div class=" form-group is-required">
						<label class="mb-4">
                            <div class="bootstrap-switch-mini">
    							<input type="radio" name="project_centralized_action" value="project"
    								   class="form-control bootstrap-switch bootstrap-switch-mini sel_pry_acc"
    								   id="sel_centralized_action" data-on-label="SI" data-off-label="NO">
    							Acción Centralizada
                            </div>
                        </label>
						<select2 :options="budget_centralized_actions" id="budget_centralized_action_id" @input="getBudgetSpecificActions('CentralizedAction')" disabled
							v-model="record.budget_centralized_action_id"></select2>
					</div>
				</div>
				<div class="col-md-12" id="helpWarehouseRequestSpecificAction">
					<div class=" form-group is-required">
						<label>Acción Específica</label>
						<select2 :options="budget_specific_actions" id="budget_specific_action_id"
							v-model="record.budget_specific_action_id" disabled></select2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Institución:</label>
						<select2 :options="institutions"
								 @input="getDepartments()"
								 v-model="record.institution_id"></select2>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Departamento/Dependencia:</label>
						<select2 :options="departments"
								v-model="record.department_id"></select2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Busqueda por Periodo</label>
						<div class="col-12">
                            <div class="col-12 bootstrap-switch-mini">
								<input type="radio" name="type_search" value="date" id="sel_search_date"
									   class="form-control bootstrap-switch bootstrap-switch-mini sel_type_search"
									   data-on-label="SI" data-off-label="NO">
                            </div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class=" form-group">
						<label>Busqueda por Mes</label>
						<div class="col-12">
                            <div class="col-12 bootstrap-switch-mini">
								<input type="radio" name="type_search" value="mes" id="sel_search_mes"
									   class="form-control bootstrap-switch bootstrap-switch-mini sel_type_search"
									   data-on-label="SI" data-off-label="NO">
                            </div>
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
			<div class="row">
				<div class="col-md-12">
					<button type="button" @click="loadInventaryProduct('/warehouse/report/vue-list')"
                            class='btn btn-sm btn-info float-right' title="Buscar registro" data-toggle="tooltip">
						<i class="fa fa-search"></i>
					</button>
				</div>
			</div>
			<hr>
			<v-client-table :columns="columns" :data="records" :options="table_options">
				<div slot="description" slot-scope="props">
					<span>
						<b> {{ (props.row.warehouse_product)?
								'Nombre: ':'' }} </b>
							{{ (props.row.warehouse_product)?
							props.row.warehouse_product.name + '.':''
						}} <br>
						{{ (props.row.warehouse_product)?
								props.row.warehouse_product.description:''
						}} <br>
					</span>
					<span>
						<div v-for="att in props.row.warehouse_product_values">
							<b>{{att.warehouse_product_attribute.name +": "}}</b> {{ att.value}} <br>
						</div>
						<b>Valor:</b> {{props.row.unit_value}} {{(props.row.currency)?props.row.currency.acronym:''}}
					</span>
				</div>
				<div slot="inventory" slot-scope="props">
					<span>
						<b>Almacén:</b> {{
							props.row.warehouse_institution_warehouse.warehouse.name
							}} <br>
						<b>Existencia:</b> {{ props.row.exist }}<br>
						<b>Reservados:</b> {{ (props.row.reserved === null)? '0':props.row.reserved }}
					</span>
				</div>
			</v-client-table>
		</div>
		<div class="card-footer text-right">
			<div class="row">
				<div class="col-md-3 offset-md-9" id="helpParamButtons">
		        	<button type="button" class='btn btn-sm btn-primary btn-custom'
							@click="createRecord()">
						<i class="fa fa-file-pdf-o"></i>
						<span>Generar Reporte</span>
					</button>
				</div>
		    </div>
        </div>
	</section>
</template>

<script>
	export default {
		data() {
			return {
				record: {
					id: '',
					warehouse_product_id: '',
					warehouse_id: '',
					warehouse_operation_id: '',
					budget_project_id: '',
					budget_centralized_action_id: '',
					budget_specific_action_id: '',

					type_search: '',
					department_id: '',
					institution_id: '',

					mes_id: '',
					year: '',
					start_date: '',
					end_date: ''
				},
				warehouses: [],
				warehouse_products: [],
				records: [],
				errors: [],
				columns: ['code', 'description', 'inventory'],
				warehouse_operations: [
					{"id":"","text":"Todos"},
					{"id":1,"text":"Recepciones"},
					{"id":2,"text":"Movimientos"},
					{"id":3,"text":"Solicitudes"}
				],
				budget_projects: [],
				budget_centralized_actions: [],
				budget_specific_actions: [],
				mes: [
					{"id":"","text":"Todos"},
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
					{"id":12,"text":"Diciembre"}
				],
				institutions: [],
				departments: [],

			}
		},
		methods: {
			reset() {
				this.record = {
					id: '',
					warehouse_product_id: '',
					warehouse_id: '',
					budget_project_id: '',
					budget_centralized_action_id: '',
					budget_specific_action_id: '',

					type_search: '',
					department_id: '',
					institution_id: '',

					mes_id: '',
					year: '',
					start_date: '',
					end_date: ''
				}
			},
			getWarehouseProducts() {
				const vm = this;
				axios.get('/warehouse/get-warehouse-products').then(response => {
					vm.warehouse_products = response.data;
				});
			},
			createReport() {
				var url = '/warehouse/pdf';
				const vm = this;
				if(typeof(url) != 'undefined'){
					if(vm.record.warehouse_product_id == '' && vm.record.warehouse_id == '')
						url = url +'/warehouse-products';
					else if(vm.record.warehouse_product_id != '' && vm.record.warehouse_id == '')
						url = url +'/product/'+ vm.record.warehouse_product_id;
					else if(vm.record.warehouse_product_id == '' && vm.record.warehouse_id != '')
						url = url +'/warehouse/'+ vm.record.warehouse_id;
					else
						url = url +'/warehouse/'+ vm.record.warehouse_product_id +'/product/'+ vm.record.warehouse_id;
					window.open(url, '_blank');
				}
			},
			loadInventaryProduct(url){
				const vm = this;
				if(vm.record.warehouse_product_id == '' && vm.record.warehouse_id == '')
					url = url +'/products/1';
				else if(vm.record.warehouse_product_id != '' && vm.record.warehouse_id == '')
					url = url +'/products/1/'+ vm.record.warehouse_product_id;
				else if(vm.record.warehouse_product_id == '' && vm.record.warehouse_id != '')
					url = url +'/products/2/'+ vm.record.warehouse_id;
				else
					url = url + '/' + vm.record.warehouse_id + '/' + vm.record.warehouse_product_id;
				axios.get(url).then(function (response) {
					if(typeof(response.data.records) !== "undefined")
						vm.records = response.data.records;
				});
	        },
		},
		created() {
			this.table_options.headings = {
				'code': 'Código',
				'description': 'Descripción',
				'inventory': 'Inventario',
			};
			this.table_options.sortable = ['code', 'description', 'inventory']
			this.table_options.filterable = ['code', 'description', 'inventory'];
		},
		watch: {

			/**
			 * Función que permite monitorear modificaciones en el campo budget_specific_actions
			 *
			 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
			 */
			budget_specific_actions: function() {
				$("#budget_specific_action_id").attr('disabled', (this.budget_specific_actions.length <= 1));
			},

		},
		mounted() {
			this.switchHandler('type_search');
			this.getInstitutions();
			this.getBudgetProjects();
			this.getBudgetCentralizedActions();
			this.getWarehouseProducts();
			this.getWarehouses();
			this.loadInventaryProduct('/warehouse/report/vue-list');
			/**
			 * Evento para determinar los datos a requerir según el tipo de formulación
			 * (por proyecto o acción centralizada)
			 */
			$('.sel_pry_acc').on('switchChange.bootstrapSwitch', function(e) {
				$('#budget_project_id').attr('disabled', (e.target.id!=="sel_project"));
				$('#budget_centralized_action_id').attr('disabled', (e.target.id!=="sel_centralized_action"));

				if (e.target.id === "sel_project") {
					$("#budget_centralized_action_id").closest('.form-group').removeClass('is-required');
					$("#budget_project_id").closest('.form-group').addClass('is-required');
				}
				else if (e.target.id === "sel_centralized_action") {
					$("#budget_centralized_action_id").closest('.form-group').addClass('is-required');
					$("#budget_project_id").closest('.form-group').removeClass('is-required');
				}
			});
		}
	};
</script>
