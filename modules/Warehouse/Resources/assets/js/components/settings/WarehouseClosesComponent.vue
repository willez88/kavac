<template>
	<section id="warehouseClosesFormComponent">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary"
		   href="#" title="Registros de cierres de almacén" data-toggle="tooltip" v-has-tooltip
		   @click="addRecordClose($event)">
			<i class="icofont icofont-ui-unlock ico-3x"></i>
			<span>Cierres de almacén</span>
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
							Nuevo cierre de almacén
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
									<li v-for="(error, index) in errors" :key="index">{{ error }}</li>
								</ul>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group is-required">
									<label>Nombre del almacén:</label>
									<select2 :options="warehouses"
														 v-model="record.warehouse_id"></select2>
									<input type="hidden" v-model="record.id">
			                    </div>
							</div>

							<div class="col-md-4">
								<div class="form-group is-required">
									<label>Inicio del cierre de almacén:</label>
									<input type="date" placeholder="Inicio del cierre del almacén" data-toggle="tooltip"
													   title="Indique la fecha de inicio del cierre del almacén (requerido)"
													   class="form-control no-restrict" :min="new Date(new Date().getTime() - (new Date().getTimezoneOffset() * 60000)).toISOString().split('T')[0]" v-model="record.initial_date">
			                    </div>
							</div>
							<div class="col-md-4">
								<div class="form-group is-required">
									<label>Fin del cierre de almacén:</label>
									<input type="date" placeholder="Fin del cierre del almacén" data-toggle="tooltip" :min="record.initial_date"
													   title="Indique la fecha en que culmina el cierre del almacén (requerido)"
													   class="form-control input-sm" v-model="record.end_date">
			                    </div>
							</div>

							<div class="col-md-12">
								<div class="form-group is-required">
									<label>Observaciones del cierre de almacén:</label>
                                    <ckeditor :editor="ckeditor.editor" data-toggle="tooltip"
                                              title="Indique alguna observación referente al cierre de almacén (requerido)"
                                              :config="ckeditor.editorConfig" class="form-control" tag-name="textarea"
                                              rows="3" v-model="record.observations"></ckeditor>
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
							<button type="button" @click="createRecord('warehouse/closes')" 
									class="btn btn-primary btn-sm btn-round btn-modal-save">
								Guardar
							</button>
                        </div>
                    </div>
	                <div class="modal-body modal-table">
	                	<hr>
	                	<v-client-table :columns="columns" :data="records" :options="table_options">
		            		<div slot="id" slot-scope="props" class="text-center">
		            			<div class="d-inline-flex">
				            		<div v-if="checkClose(props.index)">
				            			<button @click="warehouseClose(props.row.id)"
				                				class="btn btn-success btn-xs btn-icon btn-action"
				                				title="Abrir Almacén" data-toggle="tooltip" type="button">
				                			<i class="fa fa-check"></i>
				                		</button>
				                	</div>

			            			<button @click="initUpdate(props.row.id, $event)"
			                				class="btn btn-warning btn-xs btn-icon btn-action"
			                				title="Editar Registro" data-toggle="tooltip" type="button">
			                			<i class="fa fa-edit"></i>
			                		</button>

			                		<button @click="deleteRecord(props.row.id, 'warehouse/closes')"
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
	</section>
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
			warehouseClose(id)
			{
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
				this.addRecord('add_close', 'warehouse/closes', event);
				this.getWarehouses();
			},
		},

		created() {
			this.table_options.headings = {
				'warehouse.name': 'Almacén',
				'initial_user.name': 'Cerrado por',
				'initial_date': 'Inicio del cierre',
				'end_user.name': 'Aperturado por',
				'end_date': 'Fin del cierre',
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
