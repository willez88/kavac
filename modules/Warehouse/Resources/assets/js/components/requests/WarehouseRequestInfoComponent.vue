<template>
	<div>
		<a class="btn btn-info btn-xs btn-icon btn-action" 
		   href="#" title="Ver información del registro" data-toggle="tooltip" 
		   @click="addRecord('view_warehouse_request', route_list , $event)">
			<i class="fa fa-info-circle"></i>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="view_warehouse_request">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-read-book ico-2x"></i> 
							Información de la Solicitud Registrada
						</h6>
					</div>
					
					<div class="modal-body">
						<ul class="nav nav-tabs custom-tabs justify-content-center" role="tablist">
	                        <li class="nav-item">
	                            <a class="nav-link active" data-toggle="tab" id="info_general" href="#general" role="tab">
	                                <i class="ion-android-person"></i> Información General
	                            </a>
	                        </li>
	                        
	                        <li class="nav-item">
	                            <a class="nav-link" data-toggle="tab" href="#equipment" role="tab" @click="loadProducts()">
	                                <i class="ion-arrow-swap"></i> Equipos Solicitados
	                            </a>
	                        </li>
	                    </ul>

	                    <div class="tab-content">
	                    	<div class="tab-pane active" id="general" role="tabpanel">
	                    		<div class="row">        
									
									<div class="col-md-6">
										<div class="form-group">
											<strong>Fecha de Registro</strong>
											<div class="row" style="margin: 1px 0">
												<span class="col-md-12" id="date_init">
												</span>
											</div>
											<input type="hidden" id="id">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<strong>Departamento Solicitante</strong>
											<div class="row" style="margin: 1px 0">
												<span class="col-md-12" id="department">
												</span>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<strong>Motivo</strong>
											<div class="row" style="margin: 1px 0">
												<span class="col-md-12" id="motive">
												</span>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<strong>Estado de la Solicitud</strong>
											<div class="row" style="margin: 1px 0">
												<span class="col-md-12" id="state">
												</span>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<strong>Observaciones</strong>
											<div class="row" style="margin: 1px 0">
												<span class="col-md-12" id="observations">
												</span>
											</div>
										</div>
									</div>
							    </div>
	                    	</div>
	                    	
	                    	<div class="tab-pane" id="equipment" role="tabpanel">            
	                    		<div class="modal-table">
									<v-client-table :columns="columns" :data="records" :options="table_options">
										<div slot="code" slot-scope="props" class="text-center">
											<span>
												{{ props.row.warehouse_inventory_product.code }} 
											</span>
										</div>
										<div slot="quantity" slot-scope="props">
											<span>
												{{ props.row.quantity }} 
												{{ props.row.warehouse_inventory_product.measurement_unit.acronym }}
											</span>
										</div>
										<div slot="unit_value" slot-scope="props">
											<span>
												{{ props.row.warehouse_inventory_product.unit_value }} 
												{{ props.row.warehouse_inventory_product.currency.symbol }}
											</span>
										</div>
									</v-client-table>
	                    		</div>
	                    	</div>
	                    </div>
					</div>

	                <div class="modal-footer">
	                	
	                	<button type="button" class="btn btn-default btn-sm btn-round btn-modal-close" 
	                			data-dismiss="modal">
	                		Cerrar
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
				records: [],
				errors: [],
				columns: ['code',
					'warehouse_inventory_product.warehouse_product.name',
					'warehouse_inventory_product.warehouse_product.description',
					'quantity',
					'unit_value'],
			}
		},
		props: {
			request: Object, 
		},
		created() {
			this.table_options.headings = {
				'code': 'Código',
				'warehouse_inventory_product.warehouse_product.name': 'Nombre',
				'warehouse_inventory_product.warehouse_product.description': 'Descripción',
				'quantity': 'Cantidad Agregada',
				'unit_value': 'Valor por Unidad'
			};
			this.table_options.sortable = [
				'code',
				'warehouse_inventory_product.warehouse_product.name',
				'warehouse_inventory_product.warehouse_product.description',
				'quantity',
				'unit_value'
			];
			this.table_options.filterable = [
				'code',
				'warehouse_inventory_product.warehouse_product.name',
				'warehouse_inventory_product.warehouse_product.description',
				'quantity',
				'unit_value'
			];

		},
		methods: {

			/**
             * Método que borra todos los datos del formulario
             * 
             * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
             */
            reset() {
            },
            /**
			 * Reescribe el método initRecords para cambiar su comportamiento por defecto
			 * Inicializa los registros base del formulario
			 *
			 * @author Henry Paredes <hparedes@cenditel.gob.ve>
			 * @param {string} url 		Ruta que obtiene los datos a ser mostrado en listados
		 	 * @param {string} modal_id Identificador del modal a mostrar con la información solicitada
			 */
            initRecords(url, modal_id) {
				this.errors = [];
				this.reset();

				const vm = this;
            	var fields = {};
            	
            	document.getElementById("info_general").click();
            	axios.get(url).then(response => {
					if (typeof(response.data.records) !== "undefined") {
						fields = response.data.records;

						$(".modal-body #id").val( fields.id );
		            	document.getElementById('date_init').innerText = (fields.created_at)?fields.created_at:'';
		            	document.getElementById('department').innerText = (fields.department)?fields.department.name:'';
		            	document.getElementById('motive').innerText = (fields.motive)?fields.motive:'';
		            	document.getElementById('observations').innerText = (fields.observations)?fields.observations:'No definido';
		            	document.getElementById('state').innerText = (fields.state)?fields.state:'';
		            	this.records = fields.warehouse_request_products;
					}
					if ($("#" + modal_id).length) {
						$("#" + modal_id).modal('show');
					}
				}).catch(error => {
					if (typeof(error.response) !== "undefined") {
						if (error.response.status == 403) {
							vm.showMessage(
								'custom', 'Acceso Denegado', 'danger', 'screen-error', error.response.data.message
							);
						}
						else {
							vm.logs('resources/js/all.js', 343, error, 'initRecords');
						}
					}
				});

			},

			/**
			 * Actualiza los productos asocados a la solicitud
			 *
			 * @author Henry Paredes <hparedes@cenditel.gob.ve>
			 */
			loadProducts() {
				const vm = this;
				var index = $(".modal-body #id").val();
				axios.get('/warehouse/requests/info/' + index).then(response => {
					this.records = response.data.records.warehouse_request_products;
				});
			}
		},
	}
</script>
