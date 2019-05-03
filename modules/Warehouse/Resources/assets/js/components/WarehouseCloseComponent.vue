<template>
	<div class="col-md-2 text-center">
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
							<ul>
								<li v-for="error in errors">{{ error }}</li>
							</ul>
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
													   class="form-control input-sm" v-model="record.date_init">
			                    </div>
							</div>
							<div class="col-md-4">
								<div class="form-group is-required">
									<label>Fin del Cierre de Almacén:</label>
									<input type="date" placeholder="Fin del cierre del almacén" data-toggle="tooltip" 
													   title="Indique la fecha en que culmina el cierre del almacén (requerido)" 
													   class="form-control input-sm" v-model="record.date_end">
			                    </div>
							</div>

							<div class="col-md-4">
								<div class="form-group is-required">
									<label>Observaciones del Cierre de Almacén:</label>
									<textarea  data-toggle="tooltip" 
											   title="Indique alguna observación referente al cierre del almacén (requerido)" 
											   class="form-control" v-model="record.observation">
								   </textarea>
			                    </div>
							</div>
						</div>
						
	                </div>
	                <div class="modal-body modal-table">
	                	<hr>
	                	<v-client-table :columns="columns" :data="records" :options="table_options">
		            		<div slot="id" slot-scope="props" class="text-center d-inline-flex">
		            
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
            	</v-client-table>
	                	
	                </div>

	                <div class="modal-footer">
	                	<button type="button" class="btn btn-default btn-sm btn-round btn-modal-close" 
	                			data-dismiss="modal">
	                		Cerrar
	                	</button>
	                	<button type="button" @click="createRecord('warehouse/closes')" 
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
					warehouse_id: '',
					date_init: '',
					date_end: '',
					observation: '',
				},
				errors: [],
				records: [],
				columns: ['warehouse.name','start_user.name','date_init','end_user.name','date_end','observation','id'],
				warehouses: [],
			}
		},
		methods: {
			/**
			 * Método que borra todos los datos del formulario
			 * 
			 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
			 */
			reset() {
				this.record = {
					id: '',
					warehouse_id: '',
					date_init: '',
					date_end: '',
					observation: '',
				};
			},
			getWarehouses(url){
				const vm =this;
				axios.get(url).then(response => {
					if(typeof(response.data) != "undefined")
						vm.warehouses = response.data;
				});
			},
			checkClose(index) {
				var field = this.records[index-1];
				if (typeof(field) != "undefined")
			        if (field.date_end == null)			     
			           return true;
			        else
			          return false;
			},
			warehouseClose(index){
				var id = this.records[index-1].id;
				var url = '/warehouse/closes/finish';

				axios.put(url +'/'+ id).then(response => {
					this.records = response.data.records;
					this.reset();
				});

			},
			addRecordClose(event){
				this.addRecord('add_close', 'closes', event);
				this.getWarehouses('/warehouse/vue-list');
			},
		},
		created() {
			this.table_options.headings = {
				'warehouse.name': 'Almacén',
				'start_user.name': 'Cerrado por',
				'date_init': 'Inicio del Cierre',

				'end_user.name': 'Aperturado por',
				'date_end': 'Culminación del Cierre',
				'observation': 'Observaciones',
				'id': 'Acción',
			};
			this.table_options.sortable = ['date_init','date_end','warehouse.name'];
			this.table_options.filterable = ['date_init', 'date_end', 'start_user.name', 'end_user.name', 'warehouse.name'];
		},
	}
</script>
