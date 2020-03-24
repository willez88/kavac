	<template>
	<div class="col-xs-2 text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary"
		   href="#" title="Registros de Productos Almacenables" data-toggle="tooltip"
		   @click="addRecord('add_product', 'products', $event)">
			<i class="icofont icofont-cubes ico-3x"></i>
			<span>Productos</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_product">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-cubes ico-2x"></i>
							Registros de Productos Almacenables
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
							<div class="col-md-12">
								<b>Datos del Producto</b>
							</div>

							<div class="col-md-6">
								<div class="form-group is-required">
									<label>Nombre del Producto:</label>
									<input type="text" placeholder="Nombre del Producto" data-toggle="tooltip"
										   title="Indique el nombre del Nuevo producto (requerido)"
										   class="form-control input-sm" v-model="record.name">
									<input type="hidden" v-model="record.id">
			                    </div>
							</div>

							<div class="col-md-6">
								<div class="form-group is-required">
									<label>Descripción:</label>
									<textarea   data-toggle="tooltip"
												placeholder="Descripción del Producto"
											    title="Indique una breve descripción del nuevo producto (requerido)"
										   		class="form-control input-sm" v-model="record.description">
								   </textarea>
			                    </div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group is-required">
									<label>Unidad de Medida:</label>
									<select2 :options="measurement_units" v-model="record.measurement_unit_id"></select2>
			                    </div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<a  data-toggle="tooltip"
				                        title="Establecer los atributos del producto para gestionar las variantes">
				                        <label for="" class="control-label">Atributos Personalizados</label>
				                        <div class="col-12">
                                            <div class="bootstrap-switch-mini">
        										<input type="checkbox" class="form-control bootstrap-switch"
        											name="define_attributes"
        											data-on-label="Si" data-off-label="No" value="true"
        											v-model="record.define_attributes">
                                            </div>
    									</div>
				                    </a>
								</div>
							</div>
						</div>
						<div v-show="this.record.define_attributes">
							<div class="row" style="margin: 10px 0">
								<h6 class="card-title cursor-pointer" @click="addAttribute()" >
									Gestionar nuevo atributo <i class="fa fa-plus-circle"></i>
								</h6>
							</div>
							<div class="row" style="margin: 20px 0">

								<div class="col-6" v-for="(attribute, index) in record.warehouse_product_attributes">

									<div class="d-inline-flex">
										<div class="col-10">
											<div class="form-group">
												<input type="text" placeholder="Nombre del nuevo atributo" data-toggle="tooltip"
													   title="Indique el nombre del atributo del producto que desee hacer seguimiento (opcional)"
													   v-model="attribute.name" class="form-control input-sm">
											</div>
										</div>
										<div class="col-2">
											<div class="form-group">
												<button class="btn btn-sm btn-danger btn-action" type="button"
														@click="removeRow(index, record.warehouse_product_attributes)"
														title="Eliminar este dato" data-toggle="tooltip">
													<i class="fa fa-minus-circle"></i>
												</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
			        </div>
			        <div class="modal-footer">
                        <div class="form-group">
                            <modal-form-buttons :saveRoute="'warehouse/products'"></modal-form-buttons>
                        </div>
                    </div>
	                <div class="modal-body modal-table">
	                	<hr>
						<v-client-table :columns="columns" :data="records" :options="table_options">
							<div slot="attributes" slot-scope="props">
								<div v-if="props.row.define_attributes">
									<div v-for="att in props.row.warehouse_product_attributes">
										<span>
											{{ att.name }}
										</span>
									</div>
								</div>
								<div v-else>
									<span>N/A</span>
								</div>
							</div>
	                		<div slot="id" slot-scope="props" class="text-center">
		                		<div class="d-inline-flex">
		                			<button @click="initUpdate(props.index, $event)"
			                				class="btn btn-warning btn-xs btn-icon btn-action"
			                				title="Modificar registro" data-toggle="tooltip" type="button">
			                			<i class="fa fa-edit"></i>
			                		</button>
			                		<button @click="deleteRecord(props.index, 'products')"
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
					description: '',
					define_attributes: false,
					measurement_unit_id: '',
					warehouse_product_attributes: [],
				},

				errors: [],
				records: [],
				columns: ['name', 'description', 'attributes', 'id'],
				measurement_units: [],

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
					description: '',
					define_attributes: false,
					measurement_unit_id: '',
					warehouse_product_attributes: []
				};
			},
			/**
			 * Método que agrega un nuevo campo de atributo al formulario
			 *
			 * @author Henry Paredes <hparedes@cenditel.gob.ve>
			 */
			addAttribute()
			{
				var field = {id: '', name: '', warehouse_product_id: ''};
				this.record.warehouse_product_attributes.push(field);
			},
			/**
			 * Método que obtiene las unidades de medida del producto
			 *
			 * @author Henry Paredes <hparedes@cenditel.gob.ve>
			 */
			getMeasurementUnits() {
				const vm = this;
				vm.measurement_units = [];

				axios.get('/warehouse/get-measurement-units').then(response => {
					vm.measurement_units = response.data;
				});
			},

		},
		created() {
			const vm = this;
			vm.table_options.headings = {
				'name': 'Producto',
				'description': 'Descripción',
				'attributes': 'Atributos',
				'id': 'Acción'
			};
			vm.table_options.sortable = ['name', 'description'];
			vm.table_options.filterable = ['name', 'description'];
			vm.table_options.columnsClasses = {
                'name': 'col-xs-2',
                'description': 'col-xs-4',
                'attributes': 'col-xs-4',
                'id': 'col-xs-2'
            };
		},
		mounted() {
			const vm = this;
			vm.getMeasurementUnits();
			vm.switchHandler('define_attributes');
		}
	}
</script>
