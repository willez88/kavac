<template>
	<div class="col-md-2 text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary" 
		   href="#" title="Registros de objetos de proveedores" 
		   data-toggle="tooltip" 
		   @click="addRecord('add_object', '/purchase/supplier-objects', $event)">
			<i class="icofont icofont-truck-loaded ico-3x"></i>
			<span>Objetos de<br>Proveedor</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_object">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-truck-loaded inline-block"></i> 
							Objeto de Proveedor
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
									<label>Tipo:</label>
									<select2 :options="objects" v-model="record.type"></select2>
									<input type="hidden" v-model="record.id">
			                    </div>
							</div>
							<div class="col-md-6">
								<div class="form-group is-required">
									<label>Nombre:</label>
									<input type="text" 
										   placeholder="Nombre del objeto del proveedor" 
										   data-toggle="tooltip" v-model="record.name" 
										   title="Indique el nombre del objeto del proveedor (requerido)" 
										   class="form-control input-sm">
			                    </div>
							</div>
							<div class="col-md-12">
								<div class="form-group is-required">
									<label>Descripción:</label>
									<textarea class="form-control input-sm" rows="3" 
											  title="Indique la descripción para el objeto del proveedor" 
											  placeholder="Descripción del objeto del proveedor" 
											  v-model="record.description" data-toggle="tooltip"></textarea>
			                    </div>
							</div>
						</div>
	                </div>
	                <div class="modal-body modal-table">
	                	<hr>
	                	<v-client-table :columns="columns" :data="records" :options="table_options">
	                		<div slot="type" slot-scope="props" class="text-center">
	                			<span v-if="props.row.type==='B'">Bienes</span>
	                			<span v-if="props.row.type==='O'">Obras</span>
	                			<span v-if="props.row.type==='S'">Servicios</span>
	                		</div>
	                		<div slot="id" slot-scope="props" class="text-center">
	                			<button @click="initUpdate(props.index, $event)" 
		                				class="btn btn-warning btn-xs btn-icon btn-round" 
		                				title="Modificar registro" data-toggle="tooltip" type="button">
		                			<i class="fa fa-edit"></i>
		                		</button>
		                		<button @click="deleteRecord(props.index, '/purchase/supplier-objects')" 
										class="btn btn-danger btn-xs btn-icon btn-round" 
										title="Eliminar registro" data-toggle="tooltip" 
										type="button">
									<i class="fa fa-trash-o"></i>
								</button>
	                		</div>
	                	</v-client-table>
	                </div>
	                <div class="modal-footer">
	                	<button type="button" data-dismiss="modal" 
	                			class="btn btn-default btn-sm btn-round btn-modal-close">
	                		Cerrar
	                	</button>
	                	<button type="button" @click="createRecord('purchase/supplier-objects')" 
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
					type: '',
					name: '',
					description: ''
				},
				errors: [],
				records: [],
				objects: [
					{id: '',  text: 'Seleccione...'},
					{id: 'B', text: 'Bienes'},
					{id: 'O', text: 'Obras'},
					{id: 'S', text: 'Servicios'},
				],
				columns: ['type', 'name', 'description', 'id'],
			}
		},
		methods: {
			/**
			 * Método que borra todos los datos del formulario
			 * 
			 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
			 */
			reset() {
				this.record = {
					id: '',
					type: '',
					name: '',
					description: ''
				};
			},
		},
		created() {
			this.table_options.headings = {
				'type': 'Tipo',
				'name': 'Nombre',
				'description': 'Descripción',
				'id': 'Acción'
			};
			this.table_options.sortable = ['type', 'name', 'description'];
			this.table_options.filterable = ['type', 'name', 'description'];
			this.table_options.columnsClasses = {
				'type': 'col-md-2',
				'name': 'col-md-3',
				'description': 'col-md-5',
				'id': 'col-md-2'
			};
		},
	};
</script>