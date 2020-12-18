<template>
	<div class="col-xs-2 text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary"
		   href="#" title="Registros de Almacenes" data-toggle="tooltip"
		   @click="addRecord('add_warehouse', 'warehouse/warehouses', $event)">
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
							<div class="container">
								<div class="alert-icon">
									<i class="now-ui-icons objects_support-17"></i>
								</div>
								<strong>Cuidado!</strong> Debe verificar los siguientes errores antes de continuar:
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"
										@click.prevent="errors = []">
									<span aria-hidden="true">
										<i class="now-ui-icons ui-1_simple-remove"></i>
									</span>
								</button>
								<ul>
									<li v-for="error in errors">{{ error }}</li>
								</ul>
							</div>
						</div>

						<div class="row">
							<div class="col-md-4" v-if="multi_institution">
								<div class="form-group is-required">
									<label>Institución que gestiona el Almacén:</label>
									<select2 :options="institutions" @input="readRecords('warehouse/institution/' + record.institution_id)"
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
                                        <div class="bootstrap-switch-mini">
    										<input type="checkbox" class="form-control bootstrap-switch"
    											name="main" data-toggle="tolltip" title="Indique si es el almacén principal"
    											data-on-label="Si" data-off-label="No" value="true"
    											v-model="record.main">
    										</div>
                                        </div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="" class="control-label">Activo</label>
									<div class="col-12">
                                        <div class="bootstrap-switch-mini">
    										<input type="checkbox" class="form-control bootstrap-switch"
    											name="active" data-toggle="tolltip" title="Indique si el estatus del almacén"
    											data-on-label="Si" data-off-label="No" value="true"
    											v-model="record.active">
                                        </div>
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
									<select2 :options="estates" @input="getMunicipalities"
											 v-model="record.estate_id"></select2>
			                    </div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Municipio:</label>
									<select2 :options="municipalities" @input="getParishes"
									v-model="record.municipality_id"></select2>
			                    </div>
							</div>
							<div class="col-md-4">
								<div class="form-group is-required">
									<label>Parroquia:</label>
									<select2 :options="parishes" v-model="record.parish_id"></select2>
			                    </div>
							</div>

							<div class="col-md-8">
								<div class="form-group is-required">
									<label>Dirección:</label>
                                    <ckeditor :editor="ckeditor.editor" data-toggle="tooltip"
                                              title="Indique una breve dirección del nuevo almacén (requerido)"
                                              :config="ckeditor.editorConfig" class="form-control" tag-name="textarea"
                                              rows="3" v-model="record.address"></ckeditor>
			                    </div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
                        <div class="form-group">
                            <modal-form-buttons :saveRoute="'warehouse/warehouses'"></modal-form-buttons>
                        </div>
                    </div>
					<div class="modal-body modal-table">
	                	<hr>
	                	<v-client-table :columns="columns" :data="records" :options="table_options">
	                		<div slot="name" slot-scope="props">
	                			<span>
	                				{{ (props.row.warehouse)?props.row.warehouse.name:'' }}
	                			</span>
	                		</div>
	                		<div slot="country" slot-scope="props">
	                			<span>
	                				{{ (props.row.warehouse.parish)?
	                					props.row.warehouse.parish.municipality.estate.country.name:'' }}
	                			</span>
	                		</div>
	                		<div slot="estate" slot-scope="props">
	                			<span>
	                				{{ (props.row.warehouse.parish)?
	                					props.row.warehouse.parish.municipality.estate.name:'' }}
	                			</span>
	                		</div>
	                		<div slot="address" slot-scope="props">
	                			<span>
	                				{{ (props.row.warehouse.address)?
	                					props.row.warehouse.address:'' }}
	                			</span>
	                		</div>
	                		<div slot="institution" slot-scope="props">
	                			<span>
	                				{{ (props.row.institution)?
	                					props.row.institution.acronym:'' }}
	                			</span>
	                		</div>
	                		<div slot="active" slot-scope="props">
	                			<span v-if="props.row.warehouse.active">Activo</span>
	                			<span v-else>Inactivo</span>
	                		</div>
	                		<div slot="id" slot-scope="props" class="text-center">
		                		<div class="d-inline-flex">
			                		<div v-if="multi_warehouse">
				                		<button @click="warehouseManage(props.index, $event)"
												class="btn btn-danger btn-xs btn-icon btn-action"
												title="Dejar de Gestionar Almacén" data-toggle="tooltip"
												type="button"
												v-if="props.row.manage">
											<i class="fa fa-minus-circle"></i>
										</button>
										<button @click="warehouseManage(props.index, $event)"
				                				class="btn btn-success btn-xs btn-icon btn-action"
				                				title="Gestionar Almacén" data-toggle="tooltip" type="button"
				                				v-else>
				                			<i class="fa fa-plus-circle"></i>
				                		</button>
									</div>
		                			<button @click="editRecord(props.index, $event)"
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
		                	</div>
	                	</v-client-table>
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
					municipality_id:'',
					parish_id: '',

				},

				multi_warehouse: null,
				multi_institution: null,
				errors: [],
				records: [],
				columns: ['name', 'country', 'estate', 'address', 'institution','active', 'id'],
				institutions: [],
				countries: [],
				estates: [],
				municipalities: [],
				parishes: [],
			}
		},
		methods: {
			/**
			 * Método que borra todos los datos del formulario
			 *
			 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
			 */
			reset()
			{
				this.record = {
					id: '',
					name: '',
					main: '',
					address: '',
					institution_id: '',
					country_id:'',
					estate_id:'',
					municipality_id:'',
					parish_id: '',
				};

				this.errors = [];
			},
			/**
			 * Método que obtiene la configuración del sistema
			 *
			 * @author Henry Paredes <hparedes@cenditel.gob.ve>
			 */
			getSetting(url)
			{
				const vm = this;
				axios.get(url).then(response => {
					if (typeof(response.data.record) !== "undefined") {
						vm.multi_institution = (response.data.record != null)?
							response.data.record.multi_institution:false;
						vm.multi_warehouse = (response.data.record != null)?
							response.data.record.multi_warehouse:false;
					}
				});
			},
			/**
			 * Método que obtiene actualiza la institución que gestiona un almacén
			 *
			 * @author Henry Paredes <hparedes@cenditel.gob.ve>
			 */
			warehouseManage(index)
			{
				const vm = this;
				var field = {};
				field = this.records[index-1];
				var url = '/warehouse/manage/' + field.id;

				axios.get(url).then(response => {
					if (typeof(response.data.records) !== "undefined") {
						vm.records = response.data.records;
					}
				});
			},
			/**
			 * Método que carga los datos de un registro en el formulario para su edición
			 *
			 * @author Henry Paredes <hparedes@cenditel.gob.ve>
			 */
			editRecord(index, event)
			{
				const vm = this;
				vm.errors = [];
				var field = vm.records[index - 1];
				vm.record = field.warehouse;
				vm.record.institution_id = field.institution_id;
				var elements = {
					active: vm.record.active,
					main: field.main,
				};

				$.each(elements, function (el, value) {
					if ($("input[name=" + el + "]").hasClass('bootstrap-switch')) {
						/**
						 * verifica los elementos bootstrap-switch para seleccionar el que
						 * corresponda según los registros del sistema
						 */
						$("input[name=" + el + "]").each(function () {
							if ($(this).val() === value) {
								$(this).bootstrapSwitch('state', value, true);
							}
						});
					}
					if (value === true || value === false) {
						$("input[name=" + el + "].bootstrap-switch").bootstrapSwitch('state', value, true);
					}
				});
				event.preventDefault();
			},
		},
		created() {
			this.table_options.headings = {
				'name': 'Nombre',
				'country': 'Pais',
				'estate': 'Estado',
				'address': 'Dirección',
				'institution': 'Gestionado por',
				'active': 'Estatus',
				'id': 'Acción'
			};

			this.table_options.sortable = ['name', 'country', 'estate', 'address', 'institution', 'active'];
			this.table_options.filterable = ['name', 'country', 'estate', 'address', 'institution', 'active'];
			this.table_options.columnsClasses = {
                'name': 'col-xs-1',
                'country': 'col-xs-2',
                'estate': 'col-xs-2',
                'address': 'col-xs-2',
                'institution': 'col-xs-2',
                'active': 'col-xs-2',
                'id': 'col-xs-1'
            };

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
