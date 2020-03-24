<template>
	<div class="col-xs-2 text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary"
		   href="#" title="Registros de Cierres de Almacén" data-toggle="tooltip"
		   @click="addRecordClose($event)">
			<i class="icofont icofont-ui-unlock ico-3x"></i>
			<span>Cierres de Almacén</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_close">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-ui-unlock ico-2x"></i>
							Nuevo Cierre de Almacén
						</h6>
					</div>
					<div class="modal-body">
						<div class="alert alert-danger" v-if="errors.length > 0">
							<div class="container">
								<div class="alert-icon">
									<i class="now-ui-icons objects_support-17"></i>
								</div>
								<strong>Cuidado!</strong> Debe verificar los siguientes errores antes de continuar:
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"
										@click.prevent="errors = []">
									<span aria-hidden="true">
										<i class="now-ui-icons ui-1_simple-remove"></i>
									</span>
								</button>
								<ul>
									<li v-for="error in errors">{{ error }}</li>
								</ul>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group is-required">
									<label>Nombre del Almacén:</label>
									<select2 :options="warehouses"
														 v-model="record.warehouse_id"></select2>
									<input type="hidden" v-model="record.id">
			                    </div>
							</div>

							<div class="col-md-4">
								<div class="form-group is-required">
									<label>Inicio del Cierre de Almacén:</label>
									<input type="date" placeholder="Inicio del cierre del almacén" data-toggle="tooltip"
													   title="Indique la fecha de inicio del cierre del almacén (requerido)"
													   class="form-control input-sm" v-model="record.initial_date">
			                    </div>
							</div>
							<div class="col-md-4">
								<div class="form-group is-required">
									<label>Fin del Cierre de Almacén:</label>
									<input type="date" placeholder="Fin del cierre del almacén" data-toggle="tooltip"
													   title="Indique la fecha en que culmina el cierre del almacén (requerido)"
													   class="form-control input-sm" v-model="record.end_date">
			                    </div>
							</div>

							<div class="col-md-12">
								<div class="form-group is-required">
									<label>Observaciones del Cierre de Almacén:</label>
									<textarea  data-toggle="tooltip"
											   title="Indique alguna observación referente al cierre del almacén (requerido)"
											   class="form-control" v-model="record.observations">
								   </textarea>
			                    </div>
							</div>
						</div>
	                </div>
	                <div class="modal-footer">
                        <div class="form-group">
                            <modal-form-buttons :saveRoute="'warehouse/closes'"></modal-form-buttons>
                        </div>
                    </div>
	                <div class="modal-body modal-table">
	                	<hr>
	                	<v-client-table :columns="columns" :data="records" :options="table_options">
		            		<div slot="id" slot-scope="props" class="text-center">
		            			<div class="d-inline-flex">
				            		<div v-if="checkClose(props.index)">
				            			<button @click="warehouseClose(props.index)"
				                				class="btn btn-success btn-xs btn-icon btn-action"
				                				title="Abrir Almacén" data-toggle="tooltip" type="button">
				                			<i class="fa fa-check"></i>
				                		</button>
				                	</div>

			            			<button @click="initUpdate(props.index, $event)"
			                				class="btn btn-warning btn-xs btn-icon btn-action"
			                				title="Editar Registro" data-toggle="tooltip" type="button">
			                			<i class="fa fa-edit"></i>
			                		</button>

			                		<button @click="deleteRecord(props.index, 'closes')"
											class="btn btn-danger btn-xs btn-icon btn-action"
											title="Eliminar registro" data-toggle="tooltip"
											type="button">
										<i class="fa fa-trash-o"></i>
									</button>
		            			</div>
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
					warehouse_id: '',
					initial_date: '',
					end_date: '',
					observations: '',
				},
				errors: [],
				records: [],
				columns: ['warehouse.name', 'initial_user.name', 'initial_date', 'end_user.name', 'end_date', 'id'],
				warehouses: [],
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
					warehouse_id: '',
					initial_date: '',
					end_date: '',
					observations: '',
				};
				this.errors = [];
			},
			/**
	         * Método que obtiene si el almacén ha sido cerrado
	         *
	         * @author Henry Paredes <hparedes@cenditel.gob.ve>
	         */
			checkClose(index)
			{
				var field = this.records[index-1];
				if (typeof(field) != "undefined")
			        if (field.end_date == null)
			           return true;
			        else
			          return false;
			},
			/**
	         * Método que apertura un almacén cerrado
	         *
	         * @author Henry Paredes <hparedes@cenditel.gob.ve>
	         */
			warehouseClose(index)
			{
				var id = this.records[index-1].id;
				var url = '/warehouse/closes/finish';

				axios.put(url +'/'+ id).then(response => {
					if (typeof(response.data.records) !== "undefined") {
						this.records = response.data.records;
						this.reset();
						this.showMessage('update');
					}
				});
			},
			/**
		     * Método que permite mostrar una ventana con el formulario e inicializa los registros
		     *
		     * @author Henry Paredes <hparedes@cenditel.gob.ve>
		     */
			addRecordClose(event)
			{
				this.addRecord('add_close', 'closes', event);
				this.getWarehouses();
			},
		},

		created() {
			this.table_options.headings = {
				'warehouse.name': 'Almacén',
				'initial_user.name': 'Cerrado por',
				'initial_date': 'Inicio del Cierre',
				'end_user.name': 'Aperturado por',
				'end_date': 'Fin del Cierre',
				'id': 'Acción',
			};
			this.table_options.sortable = [
				'warehouse.name', 'initial_user.name', 'initial_date', 'end_user.name', 'end_date'
			];
			this.table_options.filterable = [
				'warehouse.name', 'initial_user.name', 'initial_date', 'end_user.name', 'end_date'
			];
			this.table_options.columnsClasses = {
                'warehouse.name': 'col-xs-2',
                'initial_user.name': 'col-xs-2',
                'initial_date': 'col-xs-2',
                'end_user.name': 'col-xs-2',
                'end_date': 'col-xs-2',
                'id': 'col-xs-2'
            };
		},
	}
</script>
