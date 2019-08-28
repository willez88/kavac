<template>
	<div class="col-md-2 text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary" 
		   href="#" title="Registros de Características de Productos" data-toggle="tooltip" 
		   @click="addRecord('add_attribute', 'attributes', $event)">
			<i class="icofont icofont-cubes ico-3x"></i>
			<span>Características de Productos</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_attribute">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-cubes ico-2x"></i> 
							Nueva Característica
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
								<b>Seleccione un Producto</b>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Producto:</label>
									<select2 :options="products" @input="getAttributes" 
											 v-model="record.product_id"></select2>
			                    </div>
							</div>
						</div>
						<hr>						
						<div class="row" v-if="record.product_id >=1">
							<div class="col-md-4">
								<div class="form-group">
									<label>Característica:</label>
									<input type="text" placeholder="Característica del producto" data-toggle="tooltip" 
										   title="Indique una nueva característica particular del producto (requerido)" 
										   class="form-control input-sm" v-model="record.name">	
										   <input type="hidden" v-model="record.id">
			                    </div>
							</div>
						</div>
	                </div>
	                <div class="modal-body modal-table">
	                	<hr>
	                	<v-client-table :columns="columns" :data="records" :options="table_options">
	                		<div slot="id" slot-scope="props" class="text-center">
	                			<button @click="initUpdate(props.index, $event)" 
		                				class="btn btn-warning btn-xs btn-icon btn-action" 
		                				title="Modificar registro" data-toggle="tooltip" type="button">
		                			<i class="fa fa-edit"></i>
		                		</button>
		                		<button @click="deleteRecord(props.index, 'attributes')" 
										class="btn btn-danger btn-xs btn-icon btn-action" 
										title="Eliminar registro" data-toggle="tooltip" 
										type="button">
									<i class="fa fa-trash-o"></i>
								</button>
	                		</div>
	                	</v-client-table>
	                </div>

	                <div class="modal-footer">

	                	<button type="button" class="btn btn-default btn-sm btn-round btn-modal-close" 
	                			data-dismiss="modal">
	                		Cerrar
	                	</button>
	                	<button type="button" @click="createAttribute('warehouse/attributes')" 
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
					product_id:'',
				},
				errors: [],
				records: [],
				products:[],
				columns: ['name','id'],
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
					product_id: '',
				};
			},
			getAttributes()
			{
				var id = this.record.product_id;
				var url = "attributes";
				if (id !== '')
					axios.get(url +'/product/'+ id).then(response => {
						if (typeof response.data.records !== "undefined") {
							this.records = response.data.records;
						}
					});
			},
			getProducts(url)
			{
				axios.get('/' + url).then(response => {
					if (typeof response.data !== "undefined") {
						this.products = response.data;
					}
				});
			},
			createAttribute(url)
			{
				if (this.record.id) {
					this.updateAttribute(url);
				}
				else {
					var fields = {};
					for (var index in this.record) {
						fields[index] = this.record[index];
					}

					axios.post('/' + url, fields).then(response => {
						if (typeof response.data.records !== "undefined") {
							this.records = response.data.records;
							this.record.name='';
							this.record.id='';
							this.showMessage('store');
						}
					});
				}
			},
			updateAttribute(url)
			{
				var fields = {};
				for (var index in this.record) {
					fields[index] = this.record[index];
				}
				
				axios.patch('/' + url + '/' + this.record.id, fields).then(response => {
					if (typeof response.data.records !== "undefined") {
						this.records = response.data.records;
						this.record.name='';
						this.record.id='';
						this.showMessage('update');
					}
				});
		    },
		},
		created() {
			this.table_options.headings = {
				'name': 'Nombre',
				'id': 'Acción'
			};
			this.table_options.sortable = ['name'];
			this.table_options.filterable = ['name'];

			this.getProducts('warehouse/products-list');
		},
	}
</script>
