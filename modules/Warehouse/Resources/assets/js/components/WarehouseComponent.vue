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
						<div>
							<h6>
								<i class="icofont icofont-building-alt ico-2x"></i> 
								Gestión de Almacenes
							</h6>
						</div>
					</div>
					<div class="modal-body">
						<div class="alert alert-danger" v-if="errors.length > 0">
							<ul>
								<li v-for="error in errors">{{ error }}</li>
							</ul>
						</div>

						<div class="row">
							<div class="col-md-4" v-if="multi_warehouse">
								<div class="form-group is-required">
									<label>Institución que gestiona el Almacén:</label>
									<select2 :options="institutions"
											 id="institutions_id"
											 v-model="record.institution_id">
									</select2>
			                    </div>
							</div>							
							<div class="col-md-4">
								<div class="form-group is-required">
									<label>Nombre del Almacén:</label>
									<input type="text" placeholder="Nombre del Almacén" data-toggle="tooltip" 
										   title="Indique el nombre del Nuevo almacén (requerido)" 
										   class="form-control input-sm" v-model="record.name">
									<input type="hidden" v-model="record.id">
			                    </div>
							</div>
							
							<div class="col-md-4">
								<div class="form-group">
									<label for="" class="control-label">Principal</label>
									<div class="col-12">
										<input type="checkbox" class="form-control bootstrap-switch"
											name="main" data-toggle="tolltip" title="Indique si es el almacén principal"
											data-on-label="Si" data-off-label="No" value="true"
											v-model="record.main">
										</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="" class="control-label">Activo</label>
									<div class="col-12">
										<input type="checkbox" class="form-control bootstrap-switch"
											name="active" data-toggle="tolltip" title="Indique si el estatus del almacén"
											data-on-label="Si" data-off-label="No" value="true"
											v-model="record.active">
										</div>
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
									<select2 :options="estates" @input="getCities"
											 v-model="record.estate_id"></select2>
			                    </div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Ciudad:</label>
									<select2 :options="cities" v-model="record.city_id"></select2>
			                    </div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label>Dirección:</label>
									<textarea  data-toggle="tooltip"
												placeholder="Dirección del Almacén"
											    title="Indique una breve dirección del Nuevo almacén (requerido)" 
										   		class="form-control" v-model="record.address">
								   </textarea>
									
			                    </div>
							</div>
						</div>
						
		                <div class="modal-body modal-table">
		                	<hr>
		                	<v-client-table :columns="columns" :data="records" :options="table_options">
		                		<div slot="active" slot-scope="props">
		                			<span v-if="props.row.active">Activo</span>
		                			<span v-else>Inactivo</span>
		                		</div>
		                		<div slot="institution" slot-scope="props">
		                			<div v-for="field in props.row.pivot">
		                				<span v-if="(record.institution_id == '')|(record.institution_id == field.institution.id)">
		                				{{field.institution.acronym}}
		                				</span>
		                			</div>
		                		</div>

		                		<div slot="id" slot-scope="props" class="text-center d-inline-flex">
			                		<div v-if="multi_warehouse">
				                		<button @click="warehouseManage(props.index, $event)" 
												class="btn btn-danger btn-xs btn-icon btn-action" 
												title="Dejar de Gestionar Almacén" data-toggle="tooltip" 
												type="button"
												v-if="manage">
											<i class="fa fa-minus-circle"></i>
										</button>
										<button @click="warehouseManage(props.index,$event)" 
				                				class="btn btn-success btn-xs btn-icon btn-action" 
				                				title="Gestionar Almacén" data-toggle="tooltip" type="button"
				                				v-else>
				                			<i class="fa fa-plus-circle"></i>
				                		</button>
									</div>
		                			<button @click="initUpdate(props.index, $event)" 
			                				class="btn btn-warning btn-xs btn-icon btn-action" 
			                				title="Modificar registro" data-toggle="tooltip" type="button">
			                			<i class="fa fa-edit"></i>
			                		</button>
			                		<button @click="deleteRecord(props.index, 'warehouses')" 
											class="btn btn-danger btn-xs btn-icon btn-action" 
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
					active:'',
					address: '',
					institution_id:'',
					country_id:'',
					estate_id:'',
					city_id:'',

				},

				multi_warehouse: null,
				multi_institution: null,
				manage:'',
				errors: [],
				records: [],
				columns: ['name', 'country.name', 'estate.name', 'city.name', 'address', 'institution','active', 'id'],
				institutions: [],
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
					active:'',
					address: '',
					institution_id: '',
					country_id:'',
					estate_id:'',
					city_id:'',
				};
			},
			getSetting(url){
				const vm = this;
				axios.get(url).then(response => {
					if (typeof(response.data.record) !== "undefined") {
						vm.multi_institution = (response.data.record != null)?response.data.record.multi_institution:false;
						vm.multi_warehouse = (response.data.record != null)?response.data.record.multi_warehouse:false;
					}
				});
			},
			warehouseManage(index){
				const vm = this;
				var field = {};
				field = this.records[index-1];
				var url = '/warehouse/manage/'+field.id;								

				axios.get(url).then(response => {
					if (typeof(response.data.records) !== "undefined") {
						vm.records = response.data.records;
						vm.manage = response.data.manage;
					}
				});
			},
			addMinus(index){
				const vm = this;
				var field = {};
				field = this.records[index - 1];
	            $.each(field.pivot,function(index,campo){
	                if(campo.warehouse_id === field.id){
	                	console.log(campo.manage);
	                    return campo.manage;
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
				'institution': 'Gestionado por',
				'active': 'Estatus',
				'id': 'Acción'
			};
			
			this.table_options.sortable = ['name','country.name', 'estate.name', 'city.name', 'address', 'institution'];
			this.table_options.filterable = ['name','country.name', 'estate.name', 'city.name', 'address', 'institution'];

			this.getCountries();
			this.getInstitutions();
			this.getSetting('/warehouse/vue-setting');

		},
		mounted() {
			this.switchHandler('main');
			this.switchHandler('active');
		}
	}
</script>
