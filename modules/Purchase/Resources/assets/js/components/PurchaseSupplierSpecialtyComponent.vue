<template>
	<div class="col-xs-2 text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary"
		   href="#" title="Registros de especialidades de proveedores"
		   data-toggle="tooltip"
		   @click="addRecord('add_specialty', '/purchase/supplier-specialties', $event)">
			<i class="icofont icofont-cube ico-3x"></i>
			<span>Espec. de<br>Proveedor</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_specialty">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-cube inline-block"></i>
							Especialidad de Proveedor
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
								<div class="form-group is-required">
									<label>Nombre:</label>
									<input type="hidden" v-model="record.id">
									<input type="text" placeholder="Nombre de la especialidad del proveedor"
										   data-toggle="tooltip" v-model="record.name"
										   title="Indique el nombre de la especialidad del proveedor (requerido)"
										   class="form-control input-sm">
			                    </div>
							</div>
							<div class="col-md-12">
								<div class="form-group is-required">
									<label>Descripción:</label>
                                    <ckeditor :editor="ckeditor.editor" data-toggle="tooltip"
                                              title="Indique la descripción para la especialidad del proveedor"
                                              :config="ckeditor.editorConfig" class="form-control" tag-name="textarea"
                                              rows="3" v-model="record.description"
                                              placeholder="Descripción de la especialidad del proveedor"></ckeditor>
			                    </div>
							</div>
						</div>
	                </div>
	                <div class="modal-footer">
	                	<div class="form-group">
	                		<modal-form-buttons :saveRoute="'purchase/supplier-specialties'"></modal-form-buttons>
	                	</div>
	                </div>
	                <div class="modal-body modal-table">
	                	<v-client-table :columns="columns" :data="records" :options="table_options">
	                		<div slot="id" slot-scope="props" class="text-center">
	                			<button @click="initUpdate(props.row.id, $event)"
		                				class="btn btn-warning btn-xs btn-icon btn-round"
		                				title="Modificar registro" data-toggle="tooltip" type="button">
		                			<i class="fa fa-edit"></i>
		                		</button>
		                		<button @click="deleteRecord(props.row.id, '/purchase/supplier-specialties')"
										class="btn btn-danger btn-xs btn-icon btn-round"
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
					description: ''
				},
				errors: [],
				records: [],
				columns: ['name', 'description', 'id'],
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
					name: '',
					description: ''
				};
			},
		},
		created() {
			this.table_options.headings = {
				'name': 'Nombre',
				'description': 'Descripción',
				'id': 'Acción'
			};
			this.table_options.sortable = ['name', 'description'];
			this.table_options.filterable = ['name', 'description'];
			this.table_options.columnsClasses = {
				'name': 'col-md-4',
				'description': 'col-md-6',
				'id': 'col-md-2'
			};
		},
	};
</script>
