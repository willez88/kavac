<template>
	<div class="col-md-2 text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary" 
		   href="#" title="Registros de Almacenes" data-toggle="tooltip" 
		   @click="addRecord('add_warehouse', 'warehouses', $event)">
			<i class="icofont icofont-building-alt ico-3x"></i>
			<span>Almacenes</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_warehouse">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-building ico-2x"></i> 
							Nuevo Almacén
						</h6>
					</div>
					<div class="modal-body">
						<div class="alert alert-danger" v-if="errors.length > 0">
							<ul>
								<li v-for="error in errors">{{ error }}</li>
							</ul>
						</div>

						<div class="row">
							<div class="col-md-4">
								<div class="form-group is-required">
									<label>Nombre del Almacén:</label>
									<input type="text" placeholder="Nombre del Almacén" data-toggle="tooltip" 
										   title="Indique el nombre del Nuevo almacén (requerido)" 
										   class="form-control input-sm" v-model="record.name">
									<input type="hidden" v-model="record.id">
			                    </div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>	Principal </label>
									<input type="checkbox" v-model="record.main"
										class="form-control bootstrap-switch bootstrap-switch-mini"
										data-on-label="Si" data-off-label="No">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<b>Ubicación del Almacén</b>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Pais:</label>
									<select2 :options="countries" @input="getEstates" 
											 v-model="record.country_id"></select2>
			                    </div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Estado:</label>
									<select2 :options="estates" v-model="record.estate_id"></select2>
			                    </div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Ciudad:</label>
									<select2 :options="cities" v-model="record.city_id"></select2>
			                    </div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label>Dirección:</label>
									<input type="text" placeholder="Dirección del Almacén" data-toggle="tooltip" 
										   title="Indique una breve dirección del Nuevo almacén (requerido)" 
										   class="form-control input-sm" v-model="record.address">
			                    </div>
							</div>

						</div>

						<div class="row" v-if="checkMultiInst()">
							<div class="col-md-4">
								<div class="form-group is-required">
									<label>Institución que gestiona el Almacén:</label>
									<select2 :options="institutions"
											 v-model="record.institution_id"></select2>
			                    </div>
							</div>							
						</div>
		                <div class="modal-body modal-table">
		                	<hr>
		                	<v-client-table :columns="columns" :data="records" :options="table_options">
		                		<div slot="id" slot-scope="props" class="text-center d-inline-flex">	                			
			                		<div v-if="checkInstitution()">
			                			<button @click="warehouseAdd(props.index,$event)" 
				                				class="btn btn-success btn-xs btn-icon btn-round" 
				                				title="Gestionar Almacén" data-toggle="tooltip" type="button"
				                				v-if="checkAdd(props.row.id)">
				                			<i class="fa fa-plus-circle"></i>
				                		</button>
				                		<button @click="warehouseMinus(props.index, $event)" 
												class="btn btn-danger btn-xs btn-icon btn-round" 
												title="Dejar de Gestionar Almacén" data-toggle="tooltip" 
												type="button"
												v-if="checkMinus(props.row.id)">
											<i class="fa fa-times-circle"></i>
										</button>
									</div>
		                			<button @click="initUpdate(props.index, $event)" 
			                				class="btn btn-warning btn-xs btn-icon btn-round" 
			                				title="Modificar registro" data-toggle="tooltip" type="button">
			                			<i class="fa fa-edit"></i>
			                		</button>
			                		<button @click="deleteRecord(props.index, 'warehouses')" 
											class="btn btn-danger btn-xs btn-icon btn-round" 
											title="Eliminar registro" data-toggle="tooltip" 
											type="button">
										<i class="fa fa-trash-o"></i>
									</button>
		                		</div>
		                	</v-client-table>
		                </div>
					</div>

	                <div class="modal-footer">

	                	<button type="button" @click="reset()"
								class="btn btn-default btn-icon btn-round"
								title ="Borrar datos del formulario">
								<i class="fa fa-eraser"></i>
						</button>
	                	
	                	<button type="button" 
	                			class="btn btn-warning btn-icon btn-round btn-modal-close" 
	                			data-dismiss="modal"
	                			title="Cancelar y regresar">
	                			<i class="fa fa-ban"></i>
	                	</button>

	                	<button type="button" @click="createRecord('warehouse/warehouses')" 
	                			class="btn btn-success btn-icon btn-round btn-modal-save"
	                			title="Guardar registro">
	                		<i class="fa fa-save"></i>
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
					id:'',
					name: '',
					main: '',
					address: '',
					institution_id:'',
					country_id:'',
					estate_id:'',
					city_id:'',

				},
				errors: [],
				records: [],
				columns: ['name', 'country.name', 'estate.name', 'city.name', 'address', 'id'],
				institutions: [],
				setting: [],
				countries: [],
				estates: [],
				cities: [],
				warehouses: [],
			}
		},
		methods: {
			/**
			 * Método que borra todos los datos del formulario
			 * 
			 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
			 */
			reset() {
				this.record = {
					id: '',
					name: '',
					main: '',
					address: '',
					institution_id: '',
					country_id:'',
					estate_id:'',
					city_id:'',
				};
			},
			getSetting(){
				this.errors = [];
				var url ="/warehouse/multi-institution"
				axios.get(url).then(response => {
					if (typeof(response.data.record) !== "undefined") {
						this.setting = response.data.record;
					}
				});
			},
			checkMultiInst(){
				if(this.setting == null)
					return false;
				else
					return this.setting.multi_institution;
			},
			warehouseAdd(index,event){
				this.errors = [];
				this.record = this.records[index-1];
								
				event.preventDefault();
			},
			warehouseMinus(index,event){
				this.errors = [];
				this.record = this.records[index-1];
								
				event.preventDefault();
			},
			checkAdd(id){
				console.log(id,this.warehouses[1]);
				return true;
			},
			checkMinus(id){
				return true;
			},
			checkInstitution(){
				if(this.record.institution_id >= 1)
					return true;
				else
					return false;
			},
			getWarehouses(url){
				this.errors = [];
				this.reset();
				axios.get(url).then(response => {
					if (typeof(response.data.records) !== "undefined") {
						this.warehouses = response.data.records;
					}
				});
			},

		},
		created() {
			this.table_options.headings = {
				'name': 'Nombre',
				'country.name': 'Pais',
				'estate.name': 'Estado',
				'city.name': 'Ciudad',
				'address': 'Dirección',
				'id': 'Acción'
			};
			
			this.table_options.sortable = ['name','country.name', 'estate.name', 'city.name', 'address'];
			this.table_options.filterable = ['name','country.name', 'estate.name', 'city.name', 'address'];

			this.getSetting();
			this.getCountries();
			this.getInstitutions();
			this.getWarehouses('/warehouse/manage');
		},
	}
</script>
