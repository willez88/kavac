<template>
	<div class="text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary" href=""
		   title="Registro de Productos" data-toggle="tooltip"
		   @click="addRecord('add_sale_setting_product', 'setting-product', $event)">
           <i class="icofont icofont-social-dropbox ico-3x"></i>
		   <span>Productos</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_sale_setting_product">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-social-dropbox ico-3x"></i>
							Productos
						</h6>
					</div>

					<div class="modal-body">
						<div class="alert alert-danger" v-if="errors.length > 0">
							<ul>
								<li v-for="error in errors">{{ error }}</li>
							</ul>
						</div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group is-required">
                                    <label>Típo de producto</label>
                                    <select2 :options="sale_setting_product_type"
                                        v-model="record.sale_setting_product_type_id" id="sale_setting_product_type_id">
                                    </select2>
                                </div>
                            </div>
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
        							<label for="code">Código:</label>
        							<input type="text" id="code" placeholder="Código"
        								   class="form-control input-sm" v-model="record.code" data-toggle="tooltip"
        								   title="Indique el código (requerido)">
        	                    </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group is-required">
        							<label for="description">Descripción:</label>
        							<input type="text" id="description" placeholder="Descripción"
        								   class="form-control input-sm" v-model="record.description" data-toggle="tooltip"
        								   title="Indique la descripción (requerido)">
        	                    </div>
                            </div>
                            <div class="col-md-6">
        						<div class="form-group is-required">
        							<label for="price">Precio unitario:</label>
        							<input type="text" id="price" placeholder="Precio unitario"
        								   class="form-control input-sm" v-model="record.price" data-toggle="tooltip"
        								   title="Indique el precio unitario (requerido)">
        	                    </div>
                            </div>
                            <div class="col-md-6" v-show="record.sale_setting_product_type_id == 1">
        						<div class="form-group is-required">
        							<label for="iva">IVA:</label>
        							<input type="text" id="iva" placeholder="IVA"
        								   class="form-control input-sm" v-model="record.iva" data-toggle="tooltip"
        								   title="Indique el IVA (requerido)">
        	                    </div>
							</div>
                        </div>
	                </div>
					<div class="modal-footer">
	                	<div class="form-group">
	                		<modal-form-buttons :saveRoute="'sale/setting-product'"></modal-form-buttons>
	                	</div>
	                	<div class="form-group">
		                	<button class="btn btn-default btn-sm btn-round" data-toggle="tooltip" type="button"
							title="Borrar datos del formulario" @click="reset">Borrar
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
		                		<button @click="deleteRecord(props.row.id, 'setting-product')"
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
					sale_setting_product_type_id: '',
					name: '',
					code: '',
                    description: '',
                    price: '',
                    iva: '',
				},
				errors: [],
                sale_setting_product_type_id: [],
				records: [],
				columns: ['sale_setting_product_type.name', 'name', 'code', 'description', 'price', 'iva', 'id'],
			}
		},
		methods: {
			/**
			 * Método que borra todos los datos del formulario
			 *
			 * @author  Daniel Contreras <dcontreras@cenditel.gob.ve>
			 */
			reset() {
				this.record = {
					id: '',
					sale_setting_product_type_id: '',
					name: '',
					code: '',
                    description: '',
                    price: '',
                    iva: ''
				};
			},
		},
		created() {
			this.table_options.headings = {
				'sale_setting_product_type.name': 'Tipo de producto',
				'name': 'Nombre',
				'code': 'Código',
                'description': 'Descripción',
                'price': 'Precio unitario',
                'iva': 'IVA',
				'id': 'Acción'
			};
			this.table_options.sortable = ['sale_setting_product_type.name' , 'name'];
			this.table_options.filterable = ['sale_setting_product_type.name', 'name'];
			this.table_options.columnsClasses = {
				'sale_setting_product_type_id': 'Tipo de producto',
                'name': 'Nombre',
				'code': 'Código',
                'description': 'col-md-5',
                'price': 'Precio unitario',
                'iva': 'IVA',
				'id': 'col-md-2'
			};
			this.getSaleSettingProductType();
		},
	};
</script>
