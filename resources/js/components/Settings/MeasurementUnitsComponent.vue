<template>
	<div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 mt-2 mb-2 text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary" href="javascript:void"
		   title="Registro de unidades de medida" data-toggle="tooltip"
		   @click="addRecord('add_measurement_unit', 'measurement-units', $event)">
		   	<i class="icofont icofont-ruler-pencil-alt-1 ico-3x"></i>
			<span>Unidades de<br>Medida</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_measurement_unit">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-ruler-pencil-alt-1 inline-block"></i>
							Unidades de Medida
						</h6>
					</div>
					<div class="modal-body">
						<form-errors :listErrors="errors"></form-errors>
						<div class="row">
							<div class="col-12 col-md-2">
								<div class="form-group is-required">
									<label>Acrónimo:</label>
									<input type="text" placeholder="Acrónimo" data-toggle="tooltip"
										   title="Indique el acrónimo o abreviación para la unidad de medida (requerido)"
										   class="form-control input-sm" v-model="record.acronym" v-is-text>
			                    </div>
							</div>
							<div class="col-12 col-md-4">
								<div class="form-group is-required">
									<label>Nombre:</label>
									<input type="text" placeholder="Nombre" data-toggle="tooltip"
										   title="Indique el nombre de la unidad de medida (requerido)"
										   class="form-control input-sm" v-model="record.name" v-is-text>
									<input type="hidden" v-model="record.id">
			                    </div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group is-required">
									<label>Descripción:</label>
									<input type="text" placeholder="Descripción" data-toggle="tooltip"
										   title="Indique una descripción breve sobre la unidad de medida (requerido)"
										   class="form-control input-sm" v-model="record.description" v-is-text>
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
							<button type="button" @click="createRecord('measurement-units')" 
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
		                		<button @click="deleteRecord(props.row.id, 'measurement-units')"
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
				/** @type {json} Inicialización de atributos */
				record: {
					id: '',
					description: '',
					name: '',
					acronym: ''
				},
				/** @type {Array} Inicialización de errores a mostrar */
				errors: [],
				/** @type {Array} Inicialización de atributo que cargara información registrada */
				records: [],
				columns: ['acronym', 'name', 'description', 'id'],
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
					description: '',
					name: '',
					acronym: '',
				};
			}
		},
		created() {
			this.table_options.headings = {
				acronym: 'Acrónimo',
				name: 'Nombre',
				description: 'Descripción',
				id: 'Acción'
			};
			this.table_options.sortable = ['acronym', 'name', 'description'];
			this.table_options.filterable = ['acronym', 'name', 'description'];
			this.table_options.columnsClasses = {
				'acronym': 'col-md-2',
				'name': 'col-md-3',
				'description': 'col-md-5',
				'id': 'col-md-2'
			};
		}
	};
</script>
