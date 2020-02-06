<template>
	<div class="text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary" href=""
		   title="Registros de tipos de cargo" data-toggle="tooltip"
		   @click="addRecord('add_payroll_position_type', 'position-types', $event)">
           <i class="icofont icofont-contact-add ico-3x"></i>
			<span>Tipos de Cargo</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_payroll_position_type">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-contact-add ico-3x"></i>
							Tipo de Cargo
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
        							<label for="name">Nombre:</label>
        							<input type="text" id="name" placeholder="Nombre"
        								   class="form-control input-sm" v-model="record.name" data-toggle="tooltip"
        								   title="Indique el nombre del tipo de cargo (requerido)">
        							<input type="hidden" name="id" id="id" v-model="record.id">
        	                    </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group is-required">
        							<label for="description">Descripción:</label>
        							<input type="text" id="description" placeholder="Descripción"
        								   class="form-control input-sm" v-model="record.description" data-toggle="tooltip"
        								   title="Indique la descripción del tipo de cargo (requerido)">
        	                    </div>
                            </div>
                        </div>
	                </div>
					<div class="modal-footer">
	                	<div class="form-group">
	                		<modal-form-buttons :saveRoute="'payroll/position-types'"></modal-form-buttons>
	                	</div>
	                </div>
	                <div class="modal-body modal-table">
	                	<v-client-table :columns="columns" :data="records" :options="table_options">
	                		<div slot="id" slot-scope="props" class="text-center">
	                			<button @click="initUpdate(props.index, $event)"
		                				class="btn btn-warning btn-xs btn-icon btn-action"
		                				title="Modificar registro" data-toggle="tooltip" type="button">
		                			<i class="fa fa-edit"></i>
		                		</button>
		                		<button @click="deleteRecord(props.index, 'position-types')"
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
			 * @author  William Páez <wpaez@cenditel.gob.ve>
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
			this.table_options.sortable = ['name'];
			this.table_options.filterable = ['name'];
			this.table_options.columnsClasses = {
				'name': 'col-md-5',
                'description': 'col-md-5',
				'id': 'col-md-2'
			};
		},
	};
</script>
