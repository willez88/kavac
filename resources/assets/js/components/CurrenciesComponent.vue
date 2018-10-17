<template>
	<div class="col-md-2 text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary" 
		   href="#" title="Registros de Monedas" data-toggle="tooltip" 
		   @click="addRecord('add_currency', 'currencies', $event)">
			<i class="icofont icofont-cur-dollar ico-3x"></i>
			<span>Monedas</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_currency">
			<div class="modal-dialog vue-crud" role="currency">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-cur-dollar inline-block"></i> 
							País
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
								<div class="form-group">
									<label>Pais:</label>
									<select2 :options="countries" v-model="record.country_id"></select2>
									<input type="hidden" v-model="record.id">
			                    </div>
							</div>
							<div class="col-md-2">
								<div class="form-group is-required">
									<label>Símbolo:</label>
									<input type="text" placeholder="Símbolo" data-toggle="tooltip" 
										   title="Indique el símbolo de la moneda (requerido)" 
										   class="form-control input-sm" v-model="record.symbol">
			                    </div>
							</div>
							<div class="col-md-4">
								<div class="form-group is-required">
									<label>Nombre:</label>
									<input type="text" placeholder="Nombre de la moneda" data-toggle="tooltip" 
										   title="Infique el nombre de la moneda (requerido)" 
										   class="form-control input-sm" v-model="record.name">
			                    </div>
							</div>
							<div class="col-md-2">
								<div class="form-group is-required">
									<label>Por defecto:</label>
									<div class="col-md-12">
										<input type="checkbox" class="form-control bootstrap-switch" 
											   data-toggle="tooltip" data-on-label="SI" data-off-label="NO" value="true" 
											   title="Indique si es la moneda por defecto en la aplicación" 
											   v-model="record.default">
									</div>
			                    </div>
							</div>
						</div>
					</div>
					<div class="modal-body modal-table">
						<hr>
	                	<v-client-table :columns="columns" :data="records" :options="table_options">
	                		<div slot="id" slot-scope="props" class="text-center">
	                			<button @click="initUpdate(props.index, $event)" 
		                				class="btn btn-warning btn-xs btn-icon btn-round" 
		                				title="Modificar registro" data-toggle="tooltip" type="button">
		                			<i class="fa fa-edit"></i>
		                		</button>
		                		<button @click="deleteRecord(props.index, 'currencies')" 
										class="btn btn-danger btn-xs btn-icon btn-round" 
										title="Eliminar registro" data-toggle="tooltip" 
										type="button">
									<i class="fa fa-trash-o"></i>
								</button>
	                		</div>
	                		<div slot="default" slot-scope="props">
								<span v-if="props.default">SI</span>
								<span v-else>NO</span>
							</div>
	                	</v-client-table>
					</div>
					<div class="modal-footer">
	                	<button type="button" class="btn btn-default btn-sm btn-round btn-modal-close" 
	                			data-dismiss="modal">
	                		Cerrar
	                	</button>
	                	<button type="button" @click="createRecord('currencies')" 
	                			class="btn btn-primary btn-sm btn-round btn-modal-save">
	                		Guardar
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
					country_id: '',
					symbol: '',
					default: false,
					name: ''
				},
				errors: [],
				records: [],
				countries: [],
				columns: ['country.name', 'symbol', 'name', 'default', 'id'],
			}
		},
		methods: {
			/**
			 * Método que borra todos los datos del formulario
			 * 
			 * @author  Ing. Roldan Vargas (rvargas at cenditel.gob.ve / roldandvg@gmail.com)
			 */
			reset() {
				this.record = {
					id: '',
					country_id: '',
					symbol: '',
					default: false,
					name: ''
				};
			},
		},
		created() {
			this.table_options.headings = {
				'country.name': 'Pais',
				'symbol': 'Símbolo',
				'name': 'Nombre',
				'default': 'Por defecto',
				'id': 'Acción'
			};
			this.table_options.sortable = ['name', 'symbol', 'country.name'];
			this.table_options.filterable = ['name', 'symbol', 'country.name'];
			this.getCountries();
		},
	};
</script>