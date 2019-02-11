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

						<ul class="nav nav-tabs custom-tabs justify-content-center" role="tablist">
	                        <li class="nav-item">
	                            <a class="nav-link active" data-toggle="tab" href="#products" role="tab" @click="change()">
	                                <i class="icofont icofont-cubes"></i> Productos
	                            </a>

	                        </li>
	                        
	                        <li class="nav-item">
	                            <a class="nav-link" data-toggle="tab" href="#details" role="tab" @click="setTable(true)" v-if="record.id > 0">
	                                <i class="ion-arrow-swap"></i> Detalles del Producto
	                            </a>
	                        </li>
	                    </ul>

	                    <div class="tab-content">
	                    	<div class="tab-pane active" id="products" role="tabpanel">
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

							<div class="tab-pane" id="details" role="tabpanel">
								<div class="row">        
									<div class="col-md-12">
										<b>Características del Producto</b>
									</div>

									<div class="col-md-6">
										<div class="form-group is-required">
											<label>Característica:</label>
											<input type="text" placeholder="Característica del Producto" data-toggle="tooltip" 
												   title="Indique el una nueva característica particular del producto (requerido)" 
												   class="form-control input-sm" v-model="attribute.name">
											<input type="hidden" v-model="attribute.id">
					                    </div>
									</div>
									
								</div>
							</div>

						</div>

			        </div>
	                <div class="modal-body modal-table">
	                	<hr>
	                	<table class="table table-hover table-striped dt-responsive datatable"  v-if="tableAtt">
							<thead>
								<tr class="text-center">			
									<th>Caractrística</th>
									<th>Acciones</th>
								</tr>
							</thead>


							<tbody>
								<tr v-for="(attribute, index) in attributes">

									<td>
										{{ attribute.name }}
									</td>
									<td>
										<button @click="attributeUpdate(index,$event)" 
				                				class="btn btn-warning btn-xs btn-icon btn-round" 
				                				title="Modificar registro" data-toggle="tooltip" type="button">
				                			<i class="fa fa-edit"></i>
				                		</button>
				                		<button @click="deleteAttribute(index, 'attributes')" 
												class="btn btn-danger btn-xs btn-icon btn-round" 
												title="Eliminar registro" data-toggle="tooltip" 
												type="button">
											<i class="fa fa-trash-o"></i>
										</button>
									</td>

								</tr>
							</tbody>
						</table>

	                	<table class="table table-hover table-striped dt-responsive datatable" v-else>
							<thead>
								<tr class="text-center">			

									<th>Producto</th>									
									<th>Descripción</th>
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
										<button @click="productUpdate(index,$event)" 
				                				class="btn btn-warning btn-xs btn-icon btn-round" 
				                				title="Modificar registro" data-toggle="tooltip" type="button">
				                			<i class="fa fa-edit"></i>
				                		</button>
				                		<button @click="deleteRecord(index+1, 'products')" 
												class="btn btn-danger btn-xs btn-icon btn-round" 
												title="Eliminar registro" data-toggle="tooltip" 
												type="button">
											<i class="fa fa-trash-o"></i>
										</button>
									</td>

								</tr>
							</tbody>
						</table>
	                </div>

	                <div class="modal-footer" v-if="tableAtt">

	                	<button type="button" @click="resetAtt()"
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

	                	<button type="button" @click="createAttribute('warehouse/attributes')" 
	                			class="btn btn-success btn-icon btn-round btn-modal-save"
	                			title="Guardar registro">
	                		<i class="fa fa-save"></i>
		                </button>
		            </div>

	                <div class="modal-footer" v-else>

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
					id:'',
					name: '',
					product_id: '',
				},
				errors: [],
				records: [],
				attributes: [],
				tableAtt: false,
				
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
			resetAtt() {
				this.attribute = {
					id: '',
					name: '',
				};
			},
			getAttributes() {
				this.attribute.product_id = this.record.id;
				var id = this.record.id;
				var url = "attributes";
				if (id !== '')
					axios.get(url +'/product/'+ id).then(response => {
						if (typeof response.data.records !== "undefined") {
							this.attributes = response.data.records;
						}
					});
			},
			createAttribute(url) {

				if (this.attribute.id) {
					this.updateAttribute(url);
				}
				else {
					var fields = {};
					for (var index in this.attribute) {
						fields[index] = this.attribute[index];
					}

					axios.post('/' + url, fields).then(response => {
						if (typeof response.data.records !== "undefined") {
							this.attributes = response.data.records;
							this.resetAtt();
							this.showMessage('store');
						}
					});
				}
				
			},
			updateAttribute(url) {
				
				var fields = {};
				for (var index in this.attribute) {
					fields[index] = this.attribute[index];
				}
				
				axios.patch('/' + url + '/' + this.attribute.id, fields).then(response => {
					if (typeof response.data.records !== "undefined") {
						this.attributes = response.data.records;
						this.resetAtt();
						this.showMessage('update');
					}
				});
		    },
		    attributeUpdate(index,event){
		    	this.errors = [];
				this.attribute = this.attributes[index];

				event.preventDefault();
		    },
		    deleteAttribute(index,url){

	    		var attributes = this.attributes;
	    		var confirmated = false;

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
							axios.delete(url + '/' + attributes[index].id).then(response => {
								attributes.splice(index, 1);
								this.showMessage('destroy');
							}).catch(error => {});
	    				}
	    			}
	    		});

	    		if (confirmated) {
	    			this.attributes = attributes;
	    			this.showMessage('destroy');
	    		}
			},
			productUpdate(index,event){
				this.initUpdate(index+1,event);
				this.getAttributes();
			},
			setTable(value){
				this.tableAtt = value;
				this.resetAtt();
			},
			change(){
				this.reset();
				this.attribute.prduct_id ='';
				this.setTable(false);
			}
		},
	}
</script>
