<template>
	<div class="col-md-2 text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary" 
		   href="#" title="Registros de las Reglas de Almacén" data-toggle="tooltip" 
		   @click="addRecord('add_rule', 'rules', $event)">
			<i class="icofont icofont-papper ico-3x"></i>
			<span>Reglas de Almacén</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_rule">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-papper ico-2x"></i> 
							Reglas de Almacén
						</h6>
					</div>
					<div class="modal-body">
						<div class="alert alert-danger" v-if="errors.length > 0">
							<ul>
								<li v-for="error in errors">{{ error }}</li>
							</ul>
						</div>
						<div class="row">
							<div class="col-md-12">
								<b>Seleccione el almacén donde se aloja el producto</b>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Institución que gestiona el Almacén:</label>
									<select2 :options="institutions" 
											 v-model="record.institution_id"></select2>
			                    </div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Almacén:</label>
									<select2 :options="warehouses" 
											 v-model="record.warehouse_id"></select2>
			                    </div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<b>Seleccione un Producto</b>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Producto:</label>
									<select2 :options="products" 
											 v-model="record.product_id"></select2>
			                    </div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Unidad Métrica:</label>
									<select2 :options="units" 
											 v-model="record.unit_id"></select2>
			                    </div>
							</div>
							<div class="col-md-4">
								<div class="form-group is-required">
									<label>Cantidad Minima del Producto:</label>
									<input type="number" placeholder="Cantidad Minima del Producto" data-toggle="tooltip" 
										   title="Indique la cantidad minima almacenable del producto (requerido)" 
										   class="form-control input-sm" v-model="record.min">
									<input type="hidden" v-model="record.id">
			                    </div>
							</div>
						</div>
	                </div>

	                <div class="modal-body modal-table">
	                	<hr>
	                	<v-client-table :columns="columns" :data="records" :options="table_options">
	                		<div slot="id" slot-scope="props" class="text-center">
	                			<button @click="ruleUpdate(props.index, $event)" 
		                				class="btn btn-warning btn-xs btn-icon btn-action" 
		                				title="Modificar registro" data-toggle="tooltip" type="button">
		                			<i class="fa fa-edit"></i>
		                		</button>
		                		<button @click="deleteRecord(props.index, 'rules')" 
										class="btn btn-danger btn-xs btn-icon btn-action" 
										title="Eliminar registro" data-toggle="tooltip" 
										type="button">
									<i class="fa fa-trash-o"></i>
								</button>
	                		</div>
	                	</v-client-table>
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

	                	<button type="button" @click="createRecord('warehouse/rules')" 
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
					min: '',
					product_id: '',
					warewhouse_id: '',
					unit_id: '',
				},

				products: [],
				warehouses: [],
				institutions: [],
				units: [],
				errors: [],
				records: [],
				columns: ['inventary.product.name','min','id'],
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
					min: '',
					inventary: '',
					product_id: '',
					warehouse_id: '',
					unit_id: '',
				};
			},
			getProducts(url) {
				const vm = this;
				axios.get('/' + url).then(response => {
					if (typeof(response.data) !== "undefined") {
						vm.products = response.data;
					}
				});
			},
			getWarehouses(url) {
				const vm = this;
				axios.get(url).then(response => {
					if(typeof(response.data) !== "undefined"){
						vm.warehouses = response.data;
					}
				});
			},
			getUnits(url) {
				const vm = this;
				axios.get(url).then(response => {
					if(typeof(response.data) !== "undefined"){
						vm.units = response.data;
					}
				});
			},
			ruleUpdate(index, event){
				this.initUpdate(index,event);
				this.record.product_id = this.record.inventary.product_id;
				this.record.warehouse_id = this.record.inventary.warehouse_id;
				this.record.unit_id = this.record.inventary.unit_id;
			},
		},
		created() {
			this.table_options.headings = {
				'inventary.product.name': 'Producto',
				'min': 'Minimo',
				'id': 'Acción'
			};
			this.table_options.sortable = ['inventary.product.name','min'];
			this.table_options.filterable = ['inventary.product.name','min'];
			this.getInstitutions();			
		},
		mounted() {
			this.getWarehouses('/warehouse/vue-list');
			this.getProducts('warehouse/products-list');
			this.getUnits('/warehouse/units-list');
		},
	}
</script>
