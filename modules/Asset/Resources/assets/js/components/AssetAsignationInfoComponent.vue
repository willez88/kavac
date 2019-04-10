<template>
	<div>
		<a class="btn btn-info btn-xs btn-icon btn-action" 
		   href="#" title="Ver información de la Asignación" data-toggle="tooltip" 
		   @click="initRequest('view_asignation',$event)">
			<i class="fa fa-info-circle"></i>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="view_asignation">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-read-book ico-2x"></i> 
							Información de la Asignación Registrada
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
	                            <a class="nav-link active" data-toggle="tab" href="#general" id="info_general" role="tab">
	                                <i class="ion-android-person"></i> Información General
	                            </a>
	                        </li>
	                        
	                        <li class="nav-item">
	                            <a class="nav-link" data-toggle="tab" href="#equipment" role="tab" @click="loadRequest()">
	                                <i class="ion-arrow-swap"></i> Equipos Asignados
	                            </a>
	                        </li>
	                    </ul>

	                    <div class="tab-content">
	                    	<div class="tab-pane active" id="general" role="tabpanel">
	                    		<div class="row">        
									<div class="col-md-12">
										<b>Datos de la Asignación</b>
									</div>

							        <div class="col-md-6">
										<div class="form-group">
											<label>Fecha de Registro</label>
							        		<input type="text"
												data-toggle="tooltip" 
												class="form-control input-sm" 
												id="date_init"
												readonly="readonly">
											<input type="hidden" id="id">
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label>Trabajador Responsable de los Bienes Asignados</label>
											<input type="text"
												data-toggle="tooltip" 
												class="form-control"
												id="staff"
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
		asignation: Object, 
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
            	$(".modal-body #id").val( this.asignation.id );
            	$(".modal-body #date_init").val( this.asignation.created_at );
            	$(".modal-body #staff").val( this.asignation.staff_id );
            },

			initRequest(modal_id,event) {

				event.preventDefault();
				document.getElementById("info_general").click();
				this.fillRequest();


				if ($("#" + modal_id).length) {
					$('#'+modal_id).modal('show');
				}

			},
			loadRequest(){
				var index = $(".modal-body #id").val();
				axios.get('/' + this.route_list +index).then(response => {
					this.records = response.data.records;
				});
			}
		},
	}
</script>