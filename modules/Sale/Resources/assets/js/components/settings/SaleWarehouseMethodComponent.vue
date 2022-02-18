<template>
	<div class="text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary" href=""
		   title="Registros de Almacenes de Comercialización" data-toggle="tooltip"
		   @click="addRecord('add_sale_warehouse_method', 'sale/warehouse-method', $event)">
           <i class="icofont icofont-building-alt ico-3x"></i>
		   <span>Almacenes</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_sale_warehouse_method">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-building-alt ico-3x"></i>
							Gestión de Almacenes
						</h6>
					</div>

					<div class="modal-body">
						<div class="alert alert-danger" v-if="errors.length > 0">
							<ul>
								<li v-for="(error, index) in errors" :key="index">{{ error }}</li>
							</ul>
						</div>
                        <div class="row">
                        	<div class="col-md-6" >
								<div class="form-group is-required">
									<label>Institución que gestiona el Almacén:</label>
									<select2 :options="institutions"
											 id="institutions_id"
											 v-model="record.institution_id">
									</select2>
			                    </div>
							</div>
                            <div class="col-md-6">
        						<div class="form-group is-required">
        							<label for="name">Nombre de Almacén:</label>
        							<input type="text" id="name" placeholder="Nombre"
        								   class="form-control input-sm" v-model="record.name" data-toggle="tooltip"
        								   title="Indique el nombre (requerido)">
        							<input type="hidden" name="id" id="id" v-model="record.id">
        	                    </div>
                            </div>
							<div class="col-md-2">
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
							<div class="col-md-2">
								<div class="form-group">
									<label for="" class="control-label">Activo</label>
									<div class="col-12">
                                        <div class="bootstrap-switch-mini">
    										<input type="checkbox" class="form-control bootstrap-switch"
    											name="active" data-toggle="tolltip" title="Indique si es el almacén principal"
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
									<select2 :options="countries" @input="getEstates()"
											 v-model="record.country_id"></select2>
			                    </div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Estado:</label>
									<select2 :options="estates" @input="getMunicipalities()"
											 v-model="record.estate_id"></select2>
			                    </div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Municipio:</label>
									<select2 :options="municipalities" @input="getParishes()"
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
        							<label for="address">Dirección:</label>
        							<input type="text" id="address" placeholder="Descripción"
        								   class="form-control input-sm" v-model="record.address" data-toggle="tooltip"
        								   title="Indique una breve dirección del nuevo almacén (requerido)">
        	                    </div>
                            </div>
						</div>
					</div>
					<div class="modal-footer">
	                	<div class="form-group">
	                		<button type="button" class="btn btn-default btn-sm btn-round btn-modal-close" 
									@click="clearFilters" data-dismiss="modal">
								Cerrar
							</button>
							<button type="button" class="btn btn-warning btn-sm btn-round btn-modal btn-modal-clear" 
									@click="reset()">
								Cancelar
							</button>
							<button type="button" @click="createRecord('sale/warehouse-method')" 
									class="btn btn-primary btn-sm btn-round btn-modal-save">
								Guardar
							</button>
	                	</div>
	                </div>
	                <div class="modal-body modal-table">
	                	<v-client-table :columns="columns" :data="records" :options="table_options">
	                		<div slot="active" slot-scope="props">
	                			<span v-if="props.row.active == true">Activo</span>
	                			<span v-else>Inactivo</span>
	                		</div>
	                		<div slot="id" slot-scope="props" class="text-center">
	                			<button @click="initUpdate(props.row.id, $event)"
		                				class="btn btn-warning btn-xs btn-icon btn-action"
		                				title="Modificar registro" data-toggle="tooltip" type="button">
		                			<i class="fa fa-edit"></i>
		                		</button>
                                <button @click="deleteRecord(props.row.id, 'sale/warehouse-method')"
										class="btn btn-danger btn-xs btn-icon btn-action"
										title="Eliminar registro" data-toggle="tooltip"
										type="button">
									<i class="fa fa-trash-o"></i>
								</button>
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
					id: '',
					name: '',
					main: '',
					active: '',
					institution_id:'',
                    address: '',
					country_id:'',
					estate_id:'',
					municipality_id:'',
					parish_id: '',
				},
				multi_institution: null,
				errors: [],
				records: [],
				columns: ['name', 'address', 'active',  'id'],
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
			 * @author  Miguel Narvaez <mnarvaez@cenditel.gob.ve>
			 */
			reset() {
				this.record = {
					id: '',
					name: '',
					main: '',
					active: '',
					institution_id:'',
                    address: '',
					country_id:'',
					estate_id:'',
					municipality_id:'',
					parish_id: '',
				};
			},
		},
		created() {
			this.table_options.headings = {
				'id': 'Acción',
				'name': 'Nombre',
				'main': 'Principal',
				'active': 'Activo',
				'institution_id':'Institución',
                'address': 'Dirección',
				'country_id':'Pais',
				'estate_id':'Estado',
				'municipality_id':'Municipio',
				'parish_id': 'Parroquia',
			};
			this.table_options.sortable = ['name','address', 'active'];
			this.table_options.filterable = ['name','address', 'active'];
			this.table_options.columnsClasses = {
                'name': 'col-xs-3',
                'address': 'col-xs-3',
                'active': 'col-xs-3',
                'id': 'col-xs-3'
			};
			this.getCountries();
			this.getInstitutions();
		},
		//Estilo de botones principal y activar
		mounted() {
			//this.switchHandler('active');
			//this.switchHandler('main');
		}
	};
</script>
