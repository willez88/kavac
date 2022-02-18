<template>
	<div class="text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary" href=""
		   title="Registros de Gestión de Pedidos" data-toggle="tooltip"
		   @click="addRecord('add_sale_ordermanagement_method', 'sale/saleordermanagement-method', $event)">
           <i class="icofont icofont-cur-dollar ico-3x"></i>
		   <span>Pedidos</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_sale_ordermanagement_method">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-cur-dollar ico-3x"></i>
							Gestión de Pedidos
						</h6>
					</div>

					<div class="modal-body">
						<div class="alert alert-danger" v-if="errors.length > 0">
							<ul>
								<li v-for="(error, index) in errors" :key="index">{{ error }}</li>
							</ul>
						</div>
                        <div class="row">
                            <div class="col-md-6">
        						<div class="form-group is-required">
        							<label for="name">Nombre:</label>
        							<input type="text" id="name" placeholder="Nombre"
        								   class="form-control input-sm" v-model="record.name" data-toggle="tooltip"
        								   title="Indique el nombre (requerido)">
        							<input type="hidden" name="id" id="id" v-model="record.id">
        	                    </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group is-required">
        							<label for="cedule">Cédula:</label>
        							<input type="text" id="cedule" placeholder="Cédula"
        								   class="form-control input-sm" v-model="record.cedule" data-toggle="tooltip"
        								   title="Indique la descripción (requerido)">
        	                    </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group is-required">
        							<label for="type">Tipo:</label>
        							<input type="text" id="type" placeholder="Dirección"
        								   class="form-control input-sm" v-model="record.type" data-toggle="tooltip"
        								   title="Indique la descripción (requerido)">
        	                    </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group is-required">
        							<label for="code">Codigo:</label>
        							<input type="text" id="code" placeholder="Numero de Contácto"
        								   class="form-control input-sm" v-model="record.code" data-toggle="tooltip"
        								   title="Indique la descripción (requerido)">
        	                    </div>
                            </div>
 							<div class="col-md-6">
                                <div class="form-group is-required">
        							<label for="category">Categoria:</label>
        							<input type="text" id="category" placeholder="Categoria"
        								   class="form-control input-sm" v-model="record.category" data-toggle="tooltip"
        								   title="Indique la descripción (requerido)">
        	                    </div>
                            </div>                   
 							<div class="col-md-6">
                                <div class="form-group is-required">
        							<label for="quantity">Cantidad:</label>
        							<input type="text" id="quantity" placeholder="Cantidad"
        								   class="form-control input-sm" v-model="record.quantity" data-toggle="tooltip"
        								   title="Indique la descripción (requerido)">
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
							<button type="button" @click="createRecord('sale/saleordermanagement-method')" 
									class="btn btn-primary btn-sm btn-round btn-modal-save">
								Guardar
							</button>
	                	</div>
	                </div>
	                <div class="modal-body modal-table">
	                	<v-client-table :columns="columns" :data="records" :options="table_options">
	                		<div slot="id" slot-scope="props" class="text-center">
	                			<button @click="initUpdate(props.row.id, $event)"
		                				class="btn btn-warning btn-xs btn-icon btn-action"
		                				title="Modificar registro" data-toggle="tooltip" type="button">
		                			<i class="fa fa-edit"></i>
		                		</button>
		                		<button @click="deleteRecord(props.row.id, 'saleordermanagement-method')"
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
					cedule: '',
					type: '',
                    code: '',
                    category: '',
                    quantity: ''
				},
				errors: [],
				records: [],
				columns: ['name', 'cedule', 'type', 'code', 'category', 'quantity', 'id'],
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
					cedule: '',
					type: '',
					code: '',
					category: '',
                    quantity: ''
				};
			},
		},
		created() {
			this.table_options.headings = {
				'name': 'Nombre',
                'cedule': 'Cédula',
                'type': 'Dirección',
                'code': 'Código',
                'category': 'Categoria',
                'quantity': 'Cantidad',
                'status': 'Estatus',
				'id': 'Acción'
			};
			this.table_options.sortable = ['name'];
			this.table_options.filterable = ['name'];
			this.table_options.columnsClasses = {
				'name': 'col-md-2',
                'cedule': 'col-md-2',
                'type': 'col-md-1',
                'code': 'col-md-2',
                'category': 'col-md-2',
                'quantity': 'col-md-1',
                'status': 'col-md-1',
				'id': 'col-md-1'
			};
		},
	};
</script>