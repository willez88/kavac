<template>
	<div>
		<a class="btn btn-info btn-xs btn-icon btn-action" 
		   href="#" title="Ver información de la Solicitud de Almacén" data-toggle="tooltip" 
		   @click="initRequest('view_warehouse_request',$event)">
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
	                            <a class="nav-link" data-toggle="tab" href="#equipment" role="tab" @click="loadRequest()">
	                                <i class="ion-arrow-swap"></i> Equipos Solicitados
	                            </a>
	                        </li>
	                    </ul>

	                    <div class="tab-content">
	                    	<div class="tab-pane active" id="general" role="tabpanel">
	                    		<div class="row">        
									<div class="col-md-12">
										<b>Datos de la Solicitud</b>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label>Solicitante</label>
							        		<input type="text"
												data-toggle="tooltip" 
												class="form-control input-sm" 
												id="department"
												readonly>
											<input type="hidden" id="id">
										</div>
									</div>
							        <div class="col-md-6">
										<div class="form-group">
											<label>Fecha de Registro</label>
							        		<input type="text"
												data-toggle="tooltip" 
												class="form-control input-sm" 
												id="date_init"
												readonly>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label>Motivo</label>
											<input type="text"
												data-toggle="tooltip" 
												class="form-control"
												id="motive"
												readonly>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label>Estado de la Solicitud</label>
											<input type="text"
												data-toggle="tooltip" 
												class="form-control"
												id="state"
												disabled="true">
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label>Observaciones</label>
											<input type="textarea"
												data-toggle="tooltip" 
												class="form-control"
												id="observation"
												disabled="true">
										</div>
									</div>

							    </div>
	                    	</div>
	                    	
	                    	<div class="tab-pane" id="equipment" role="tabpanel">            
	                    		<div class="row">
	                    			<div class="col-md-12">
										<hr>
										<v-client-table :columns="columns" :data="records" :options="table_options">
										</v-client-table>
									</div>
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
				columns: ['inventary_product.product.name','inventary_product.product.description','inventary_product.unit.name','quantity'],
			}
		},
		props: {
		request: Object, 
		},
		created() {
			this.table_options.headings = {
				'inventary_product.product.name': 'Nombre',
				'inventary_product.product.description': 'Descripción',
				'inventary_product.unit.name': 'Unidad',
				'quantity': 'Solicitados'

			};
			this.table_options.sortable = ['inventary_product.product.name','inventary_product.product.description','inventary_product.unit.name'];
			this.table_options.filterable = ['inventary_product.product.name','inventary_product.product.description','inventary_product.unit.name'];

		},
		methods: {

			fillRequest(){
				$(".modal-body #id").val( this.request.id );
            	$(".modal-body #department").val( this.request.department.name );
            	$(".modal-body #date_init").val( this.request.created_at );
            	$(".modal-body #observation").val( this.request.observation );
            	$(".modal-body #motive").val( this.request.motive );
            	$(".modal-body #state").val( ( this.request.delivered)? "Completado":"Pendiente por Ejecutar" );
			},

			initRequest(modal_id,event) {
				
				this.fillRequest();
				document.getElementById("info_general").click();
				event.preventDefault();
				if ($("#" + modal_id).length) {
					$('#'+modal_id).modal('show');
				}

			},

			loadRequest(){
				const vm = this;
	         	var index = $(".modal-body #id").val();
				axios.get('/' + this.route_list + index).then(response => {
					if(typeof(response.data.records) !== "undefined"){
						vm.records = response.data.records.request_product;
		            }
				});
			}
		},
	}
</script>