<template>
	<div class="col-xs-2 text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary"
		   href="javascript:void(0)" title="Registros de Países" data-toggle="tooltip"
		   @click="addRecord('add_country', 'countries', $event)">
			<i class="icofont icofont-map ico-3x"></i>
			<span>Países</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_country">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-map inline-block"></i>
							País
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
								<div class="form-group">
									<label>Prefijo:</label>
									<input type="text" placeholder="Prefijo" data-toggle="tooltip"
										   title="Indique el prefijo del Pais (requerido)"
										   class="form-control input-sm" v-model="record.prefix" v-is-digits>
									<input type="hidden" v-model="record.id">
			                    </div>
							</div>
							<div class="col-md-6">
								<div class="form-group is-required">
									<label>Nombre:</label>
									<input type="text" placeholder="Nombre de Pais" data-toggle="tooltip"
										   title="Indique el nombre del Pais (requerido)"
										   class="form-control input-sm" v-model="record.name" v-is-text>
			                    </div>
							</div>
						</div>
	                </div>
	                <div class="modal-footer">
	                	<div class="form-group">
	                		<modal-form-buttons :saveRoute="'countries'"></modal-form-buttons>
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
		                		<button @click="deleteRecord(props.row.id, 'countries')"
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
					prefix: '',
					name: ''
				},
				errors: [],
				records: [],
				columns: ['prefix', 'name', 'id'],
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
					prefix: '',
					name: ''
				};
			},
		},
		created() {
			this.table_options.headings = {
				'prefix': 'Prefijo',
				'name': 'Nombre',
				'id': 'Acción'
			};
			this.table_options.sortable = ['name', 'prefix'];
			this.table_options.filterable = ['name', 'prefix'];
			this.table_options.columnsClasses = {
				'prefix': 'col-md-1',
				'name': 'col-md-9',
				'id': 'col-md-2'
			};
		},
	};
</script>
