<template>
	<div>
		<a class="btn btn-info btn-xs btn-icon btn-round" 
		   href="#" title="Ver información de la Solicitud" data-toggle="tooltip" 
		   @click="initRequest('view_request',$event)">
			<i class="fa fa-info-circle"></i>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="view_request">
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

						<div class="alert alert-danger" v-if="errors.length > 0">
							<ul>
								<li v-for="error in errors">{{ error }}</li>
							</ul>
						</div>
						<ul class="nav nav-tabs custom-tabs justify-content-center" role="tablist">
	                        <li class="nav-item">
	                            <a class="nav-link active" data-toggle="tab" href="#request" role="tab">
	                                <i class="ion-android-person"></i> Datos de la Solicitud
	                            </a>
	                        </li>
	                        <li class="nav-item">
	                            <a class="nav-link" data-toggle="tab" href="#contact" role="tab">
	                                <i class="ion-android-person"></i> Información de Contacto
	                            </a>
	                        </li>
	                        <li class="nav-item">
	                            <a class="nav-link" data-toggle="tab" href="#equipment" role="tab">
	                                <i class="ion-arrow-swap"></i> Equipos Solicitados
	                            </a>
	                        </li>
	                    </ul>

	                    <div class="tab-content">
	                    	<div class="tab-pane active" id="request" role="tabpanel">
	                    		<div class="row">        
									<div class="col-md-12">
										<b>Datos de la Solicitud</b>
									</div>

							        <div class="col-md-6">
										<div class="form-group">
											<label>Fecha de la Solicitud</label>
							        		<input type="text"
												data-toggle="tooltip" 
												class="form-control input-sm" 
												id="date_init"
												readonly="readonly">
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label>Motivo de la Solicitud</label>
							        		<input type="text"
												data-toggle="tooltip" 
												class="form-control input-sm" 
												id="motive"
												readonly="readonly">
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label>Tipo de Solicitud</label>
							        		<input type="text"
												data-toggle="tooltip" 
												class="form-control input-sm" 
												id="type"
												readonly="readonly">
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label>Fecha de Entrega de los Bienes</label>
							        		<input type="text"
												data-toggle="tooltip" 
												class="form-control input-sm" 
												id="delivery_date"
												readonly="readonly">
										</div>
										
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label>Ubicación de los Bienes</label>
							        		<input type="text"
												data-toggle="tooltip" 
												class="form-control input-sm" 
												id="ubication"
												readonly="readonly">
										</div>
									</div>
							    </div>
	                    	</div>
	                    	<div class="tab-pane" id="contact" role="tabpanel">
	                    		<div class="row">
	                    			<div class="col-md-12">
										<b>Información de Contacto del Agente Externo Responsable del Bien</b>    
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label>Nombre</label>
							        		<input type="text"
												data-toggle="tooltip" 
												class="form-control input-sm" 
												id="agent_name"
												readonly="readonly">
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label>Teléfono</label>
							        		<input type="text"
												data-toggle="tooltip" 
												class="form-control input-sm" 
												id="agent_telf"
												readonly="readonly">
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label>Correo</label>
							        		<input type="text"
												data-toggle="tooltip" 
												class="form-control input-sm" 
												id="agent_email"
												readonly="readonly">
										</div>
									</div>
	                    		</div>
	                    	</div>
	                    	<div class="tab-pane" id="equipment" role="tabpanel">
	                    		<div class="row">
	                    			<div class="col-md-12">
										<hr>
										<v-client-table :columns="columns" :data="records" :options="table_options">
											<div slot="asset.id" slot-scope="props" class="text-center">
											</div>

										</v-client-table>
									</div>
	                    		</div>
	                    	</div>
	                    </div>
					</div>

	                <div class="modal-footer">
	                	
	                	<button type="button" 
	                			class="btn btn-warning btn-icon btn-round btn-modal-close" 
	                			data-dismiss="modal"
	                			title="Cancelar y regresar">
	                			<i class="fa fa-ban"></i>
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
				columns: ['asset.serial_inventario','asset.serial','asset.marca','asset.model','asset.id'],
			}
		},
		props: {
		request: Object,
		},
		created() {
			this.table_options.headings = {
				'asset.serial_inventario': 'Código',
				'asset.serial': 'Serial',
				'asset.marca': 'Marca',
				'asset.model': 'Modelo',
				'asset.id': 'Acción'
			};
			this.table_options.sortable = ['asset.serial_inventario','asset.serial','asset.marca','asset.model'];
			this.table_options.filterable = ['asset.serial_inventario','asset.serial','asset.marca','asset.model'];

		},
		methods: {

            fillRequest(){

            	$(".modal-body #date_init").val( this.request.created_at );
				$(".modal-body #motive").val( this.request.motive );
				$(".modal-body #type").val( this.request.type );
				$(".modal-body #delivery_date").val( this.request.delivery_date );
				$(".modal-body #ubication").val( this.request.ubication );
				$(".modal-body #agent_name").val( this.request.agent_name );
				$(".modal-body #agent_telf").val( this.request.agent_telf );
				$(".modal-body #agent_email").val( this.request.agent_email );
            },

			initRequest(modal_id,event) {

				event.preventDefault();
				this.fillRequest();
				this.readRecords(this.route_list);				

				if ($("#" + modal_id).length) {
					$('#'+modal_id).modal('show');
				}
			}
		},
	}
</script>