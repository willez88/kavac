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
							<i class="icofont icofont-cube ico-2x"></i> 
							Nuevo Producto
						</h6>
					</div>
					<div class="modal-body">
						<div class="alert alert-danger" v-if="errors.length > 0">
							<ul>
								<li v-for="error in errors">{{ error }}</li>
							</ul>
						</div>

						<ul class="nav nav-tabs custom-tabs justify-content-center" role="tablist">
	                        <li class="nav-item">
	                            <a class="nav-link active" data-toggle="tab" href="#general" role="tab">
	                                <i class="ion-information-circled"></i> Información General
	                            </a>
	                        </li>
	                        
	                        <li class="nav-item" v-if="checkProduct()">
	                            <a class="nav-link" data-toggle="tab" href="#specific" role="tab">
	                                <i class="ion-ios-search-strong"> Información Detallada</i> 
	                            </a>
	                        </li>
	                    </ul>

						<div class="tab-content">
	                    	<div class="tab-pane active" id="general" role="tabpanel">
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
			                </div>
	                    	<div class="tab-pane" id="specific" role="tabpanel">
	                    		<div class="row">        
									<div class="col-md-12">
										<b>Carateristícas del Producto</b>
									</div>

									<div class="col-md-12">
										<table class="table table-hover table-striped dt-responsive datatable">
											<thead>
												<tr class="text-center">

													<th>Característica</th>
													<th width="20%">Acciones</th>
												</tr>
											</thead>
											<tbody>
											<tr v-for="(item, index) in attributes">
												<td>
													{{item.name ,index}}
												</td>									
												<td width="20%" class="text-center">
													<div class="d-inline-flex">
														<button @click="itemSave(index)" 
							                					class="btn btn-success btn-xs btn-icon btn-round" 
							                					title="Guardar registro" data-toggle="tooltip" type="button">
								                			<i class="fa fa-save"></i>
								                		</button>
														<button @click="" 
							                					class="btn btn-warning btn-xs btn-icon btn-round" 
							                					title="Modificar registro" data-toggle="tooltip" type="button">
								                			<i class="fa fa-edit"></i>
								                		</button>
								                		<button @click="" 
																class="btn btn-danger btn-xs btn-icon btn-round" 
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
								</div>
								<div class="row">
									<div class="col-12">
										<a class='btn btn-sm btn-primary btn-custom float-right'
															 title="Agregar Nueva Característica"
															 data-toggle="tooltip"
															 @click="itemAdd()">
											<i class="fa fa-plus-circle"></i>
											<span>Nueva</span>
										</a>	
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
		                		<button @click="deleteRecord(props.index, 'products')" 
										class="btn btn-danger btn-xs btn-icon btn-round" 
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

	                	<button type="button" @click="createRecord('warehouse/products')" 
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
					description: ''
				},
				attribute: {
					id: '',
					name: '',
					product_id: '',
				},
				errors: [],
				records: [],
				attributes: [],
				columns: ['name', 'description','id'],
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
					description: ''
				};
			},

			checkProduct(){
				if (this.record.id >= 1)
					return true;
				else
					return false;
			},
			itemAdd(){
				this.attribute.name = 'Nuevo Campo';
				this.attribute.product_id = this.record.id;
				this.attributes.push(this.attribute);
			},
			itemSave(index){
				var url = "products/attribute";
				var field= {};
			    for (var index in this.attribute) {
			    	field[index] = this.attribute[index];
			    }
				axios.post(url,field).then(response => {
					if (typeof(response.data.records) !== "undefined") {
						this.attributes = response.data.records;
					}
				});
			},
		},
		created() {
			this.table_options.headings = {
				'name': 'Nombre',
				'description': 'Descripción',
				'id': 'Acción'
			};
			this.table_options.sortable = ['name'];
			this.table_options.filterable = ['name'];
		},
	}
</script>
