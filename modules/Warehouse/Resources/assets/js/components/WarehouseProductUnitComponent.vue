<template>
	<div class="col-md-2 text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary" 
		   href="#" title="Registros de Unidades Métricas de Productos" data-toggle="tooltip" 
		   @click="addRecord('add_unit', 'units', $event)">
			<i class="icofont icofont-ruler-pencil-alt-2 ico-3x"></i>
			<span>Unidades Métricas</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_unit">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-ruler-pencil-alt-2 ico-2x"></i> 
							Nueva Unidad Métrica
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
									<label>Nombre de la Unidad Métrica:</label>
									<input type="text" placeholder="Nombre de la Unidad Métrica" data-toggle="tooltip" 
										   title="Indique un nombre o descripción de la Unidad Métrica (requerido)" 
										   class="form-control input-sm" v-model="record.name">
									<input type="hidden" v-model="record.id">
			                    </div>
							</div>
							<div class="col-md-4">
								<div class="form-group is-required">
									<label>Abreviatura:</label>
									<input type="text" placeholder="Simbolo o Abreviatura" data-toggle="tooltip" 
										   title="Indique el simbolo o abreviatura de la Unidad Métrica (requerido)" 
										   class="form-control input-sm" v-model="record.abbreviation">
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
		                		<button @click="deleteRecord(props.index, 'units')" 
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
	                	<button type="button" @click="createRecord('warehouse/units')" 
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
					abbreviation:''
				},
				errors: [],
				records: [],
				columns: ['name','abbreviation','id'],
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
					abbreviation:''
				};
			},
		},
		created() {
			this.table_options.headings = {
				'name': 'Nombre',
				'abbreviation': 'Abreviatura',
				'id': 'Acción'
			};
			this.table_options.sortable = ['name','abbreviation'];
			this.table_options.filterable = ['name','abbreviation'];
		},
	}
</script>
