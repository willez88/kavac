<template>
	<div class="text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary" href=""
		   title="Registros de Formas de Pago" data-toggle="tooltip"
		   @click="addRecord('add_sale_setting_deposit', 'sale/setting-deposit', $event)">
           <i class="icofont icofont-briefcase-alt-1 ico-3x"></i>
		   <span>Pagos</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_sale_setting_deposit">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-briefcase-alt-1 ico-3x"></i>
							Forma de pago
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
        							<label for="description">Descripción:</label>
        							<input type="text" id="description" placeholder="Descripción"
        								   class="form-control input-sm" v-model="record.description" data-toggle="tooltip"
        								   title="Indique la descripción (requerido)">
        	                    </div>
                            </div>
                            <div class="col-md-6">
        						<div class="form-group is-required">
        							<label for="deposit_attributes">Atributos:</label>
        							<input type="text" id="deposit_attributes" placeholder="Atributos"
        								   class="form-control input-sm" v-model="record.deposit_attributes" data-toggle="tooltip"
        								   title="Indique los atributos (requerido)">
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
							<button type="button" @click="createRecord('sale/setting-deposit')" 
									class="btn btn-primary btn-sm btn-round btn-modal-save">
								Guardar
							</button>
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
		                		<button @click="deleteRecord(props.index, 'setting-deposit')"
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
					description: '',
					deposit_attributes: '',
				},
				errors: [],
				records: [],
				columns: ['name', 'description', 'deposit_attributes', 'id'],
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
					name: '',
					description: '',
					deposit_attributes: ''
				};
			},
		},
		created() {
			this.table_options.headings = {
				'name': 'Nombre',
				'description': 'Descripción',
				'deposit_attributes': 'Atributos',
				'id': 'Acción'
			};
			this.table_options.sortable = ['name'];
			this.table_options.filterable = ['name'];
			this.table_options.columnsClasses = {
				'name': 'col-xs-3',
				'description': 'col-xs-3',
				'deposit_attributes': 'col-xs-3',
				'id': 'col-xs-3'
			};
		},
	};
</script>
