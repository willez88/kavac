	<template>
	<div class="col-md-2 text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary" 
		   href="#" title="Registros de Productos de Almacén" data-toggle="tooltip" 
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
							Registros de Productos de Almacén
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
									<input type="text" placeholder="Descripción del Producto" data-toggle="tooltip" 
										   title="Indique una breve descripción del Nuevo producto (requerido)" 
										   class="form-control input-sm" v-model="record.description">
			                    </div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<a  data-toggle="tooltip"
				                        title="Establecer los atributos del producto para gestionar las variantes">
				                        <label for="" class="control-label">Atributos Personalizados</label>
				                        <div class="col-12">
										<input type="checkbox" class="form-control bootstrap-switch"
											name="attribute" 
											data-on-label="Si" data-off-label="No" value="true"
											v-model="record.attribute">
									</div>
				                    </a>
								</div>
							</div>
						</div>
						<hr>
						<div v-show="this.record.attribute">
							<div class="row" style="margin: 10px 0">
								<h6 class="card-title cursor-pointer" @click="addAttribute()" >
									Gestionar nuevo atributo <i class="fa fa-plus-circle"></i>
								</h6>
							</div>
							<div class="row" style="margin: 20px 0">

								<div class="col-6" v-for="(attribute, index) in record.attributes">

									<div class="d-inline-flex">
										<div class="col-10">
											<div class="form-group">
												<input type="text" placeholder="Descripción del nuevo atributo" data-toggle="tooltip" 
													   title="Indique el nombre o descripción del atributo del producto que desee hacer seguimiento (opcional)" 
													   v-model="attribute.name" class="form-control input-sm">
											</div>
										</div>
										<div class="col-2">
											<div class="form-group">
												<button class="btn btn-sm btn-danger btn-action" type="button" 
														@click="removeRow(index, record.attributes)" 
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
	                <div class="modal-body modal-table">
	                	<hr>
	                	<table class="table table-hover table-striped dt-responsive datatable">
							<thead>
								<tr class="text-center">			

									<th>Producto</th>									
									<th>Descripción</th>
									<th>Atributos</th>
									<th>Acciones</th>
								</tr>
							</thead>


							<tbody>
								<tr v-for="(product, index) in records">

									<td>
										{{ product.name }}
									</td>
									<td>
										{{ product.description }}
									</td>									

									<td>
										<div v-if="product.attribute" v-for="att in product.attributes">
											{{ att.name }}
										</div>
										<div v-else>
											<span>N/A</span>
										</div>
									</td>

									<td class="text-center">
										<div class="d-inline-flex">
											<button @click="initUpdate(index+1,$event)"
					                				class="btn btn-warning btn-xs btn-icon btn-action" 
					                				title="Modificar registro" data-toggle="tooltip" type="button">
					                			<i class="fa fa-edit"></i>
					                		</button>
					                		<button @click="" 
													class="btn btn-danger btn-xs btn-icon btn-action" 
													title="Eliminar registro" data-toggle="tooltip" 
													type="button">
												<i class="fa fa-trash-o"></i>
											</button>
										</div>
									</td>

								</tr>
							</tbody>
						</table>
	                </div>

	                <div class="modal-footer">

	                	<button type="button" class="btn btn-default btn-sm btn-round btn-modal-close" 
	                			data-dismiss="modal">
	                		Cerrar
	                	</button>
	                	<button type="button" @click="createRecordProduct('warehouse/products')"
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
					id:'',
					name: '',
					description: '',
					attribute: false,
					attributes: [],
				},
				editIndex: null,
				errors: [],
				records: [],
				attributes: [],
				
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
					description: '',
					attribute: false,
					attributes: []
				};
			},
			addAttribute(){
				var field = {id: '', name: '', product_id: ''};
				this.record.attributes.push(field);
			},
			createRecordProduct(url){
				this.record = {
					id: this.record.id,
					name: this.record.name,
					description: this.record.description,
					attribute: this.record.attribute,
					atts: this.record.attributes
				};
				this.createRecord(url);
			}

		},
		mounted() {
			this.switchHandler('attribute');
		}
	}
</script>
