<template>
	<div class="col-xs-2 text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary"
		   href="#" title="Reglas de Abastecimiento del Almacén" data-toggle="tooltip"
		   @click="addRecord('add_rule', 'warehouse/rules', $event)">
			<i class="icofont icofont-law-document ico-3x"></i>
			<span>Reglas de Abastecimiento</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_rule">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-law-document ico-2x"></i>
							Reglas de Abastecimiento del Almacén
						</h6>
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
							<div class="col-md-6">
								<div class="form-group">
									<label>Institución que gestiona el Almacén:</label>
									<select2 :options="institutions"
											 v-model="institution_id"
											 @input="getWarehouses()">
									</select2>
			                    </div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Almacén:</label>
									<select2 :options="warehouses"
											 v-model="warehouse_id"
											 @input="getWarehouseProducts()">
									</select2>
			                    </div>
							</div>
						</div>
						<hr>
						<div class="row" v-show="this.record.warehouse_inventory_product_id != ''">
							<div class="col-md-3">
								<div class="form-group">
									<label>Minimo:</label>
									<input  type="number" class="form-control input-sm"
											data-toggle="tooltip" min=0
											v-model="record.minimum">
			                    </div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Maximo:</label>
									<input  type="number" class="form-control input-sm"
											data-toggle="tooltip" min=0
											v-model="record.maximum">
			                    </div>
							</div>
						</div>
	                </div>
	                <div class="modal-footer">
                        <div class="form-group">
                            <modal-form-buttons :saveRoute="'warehouse/rules'"></modal-form-buttons>
                        </div>
                    </div>
	                <div class="modal-body modal-table">
	                	<hr>
	                	<v-client-table :columns="columns" :data="records"
	                	:options="table_options">
							<div slot="description" slot-scope="props">
								<span>
									{{ (props.row.warehouse_product)?
											props.row.warehouse_product.name+': '+props.row.warehouse_product.description:'N/A'
									}}
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
							<div slot="rules" slot-scope="props">
								<span>
									<b>Minimo:</b> {{
										(props.row.warehouse_inventory_rule)?props.row.warehouse_inventory_rule.minimum:'N/A'
										}} <br>
									<b>Maximo:</b> {{
										(props.row.warehouse_inventory_rule)?props.row.warehouse_inventory_rule.maximum:'N/A'
										}}
								</span>
							</div>
							<div slot="details" slot-scope="props">
								<span>
									<div v-for="att in props.row.warehouse_product_values">
										<b>{{att.warehouse_product_attribute.name +":"}}</b> {{ att.value}}
									</div>
										<b>Valor:</b> {{props.row.unit_value}} {{(props.row.currency)?props.row.currency.name:''}}
								</span>
							</div>
							<div slot="id" slot-scope="props" class="text-center">
								<div class="d-inline-flex">
									<button @click="editRule(props.index, $event)"
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
					minimum: '',
					maximum: '',
					warehouse_inventory_product_id: '',
				},

				editIndex: null,
				institution_id: '',
				warehouse_id: '',
				warehouses: [],
				institutions: [],
				errors: [],
				records: [],
				columns: ['code', 'description', 'details', 'inventory', 'rules', 'id'],
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
					minimum: '',
					maximum: '',
					warehouse_inventory_product_id: '',
				};
				this.editIndex = null;
				this.institution_id = '';
				this.warehouse_id = '';
			},
			/**
	         * Método que obtiene los datos de los productos inventariados
	         *
	         * @author Henry Paredes <hparedes@cenditel.gob.ve>
	         */
			getWarehouseProducts()
			{
				const vm = this;
				if ((vm.warehouse_id != '') && (vm.institution_id != '')) {
					var url = "/warehouse/rules/vue-list-products/";
					axios.get(url + vm.warehouse_id + '/' + vm.institution_id).then(response => {
						if(typeof(response.data.records) != "undefined"){
							vm.records = response.data.records;
						}
						else
							vm.records = [];
					});
				} else {
					axios.get('/warehouse/rules/vue-list-products').then(function (response) {
						if (typeof(response.data.records) !== "undefined")
							vm.records = response.data.records;
						else
							vm.records = [];
					});
				}
			},
			/**
	         * Método que carga el formulario con los datos a modificar
	         *
	         * @author Henry Paredes <hparedes@cenditel.gob.ve>
	         */
			editRule(index, event)
			{
				const vm = this;
				this.editIndex = index-1;

				if (vm.records[index-1].warehouse_inventory_rule == null)
					this.record = {
						id: '',
						minimum: '',
						maximum: '',
						warehouse_inventory_product_id: vm.records[index-1].id,
					};
				else
					vm.record = vm.records[index-1].warehouse_inventory_rule;
				event.preventDefault();
			},
			/**
			 * Reescribe el método deleteRecord para cambiar su comportamiento por defecto
	         * Método que elimina los registros
	         *
	         * @author Henry Paredes <hparedes@cenditel.gob.ve>
	         */
			deleteRecord(index, url)
			{
	    		var url = (url)?url:this.route_delete;
	    		var records = this.records;
	    		var confirmated = false;
	    		var index = index - 1;
	    		const vm = this;

	    		bootbox.confirm({
	    			title: "Eliminar registro?",
	    			message: "Esta seguro de eliminar este registro?",
	    			buttons: {
	    				cancel: {
	    					label: '<i class="fa fa-times"></i> Cancelar'
	    				},
	    				confirm: {
	    					label: '<i class="fa fa-check"></i> Confirmar'
	    				}
	    			},
	    			callback: function (result) {
						if (result) {
	    					confirmated = true;
							axios.delete(url + '/' + records[index].id).then(response => {
								if (typeof(response.data.error) !== "undefined") {
									/** Muestra un mensaje de error si sucede algún evento en la eliminación */
	    							vm.showMessage('custom', 'Alerta!', 'warning', 'screen-error', response.data.message);
	    							return false;
								}
								vm.readRecords('warehouse/rules');
								vm.showMessage('destroy');
							}).catch(error => {});
	    				}
	    			}
	    		});
			},
		},
		created() {
			this.getInstitutions();
			this.table_options.headings = {
				'code': 'Código',
				'description': 'Descripción',
				'details': 'Detalles',
				'inventory': 'Inventario',
				'rules': 'Reglas',
				'id': 'Acción'
			};
			this.table_options.sortable = ['code', 'description', 'details', 'inventory', 'rules'];
			this.table_options.filterable = ['code', 'description', 'details', 'inventory', 'rules'];
			this.table_options.columnsClasses = {
                'code': 'col-xs-2',
                'description': 'col-xs-2',
                'details': 'col-xs-2',
                'inventory': 'col-xs-2',
                'rules': 'col-xs-2',
                'id': 'col-xs-2'
            };
		},
		mounted() {
			this.getWarehouseProducts();
		},
	}
</script>
