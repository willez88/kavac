<template>
	<div>
		<a class="btn btn-info btn-xs btn-icon btn-action"
		   href="#" title="Ver información del Bien" data-toggle="tooltip" v-has-tooltip
		   @click="addRecord('add_asset', route_list ,$event)">
			<i class="fa fa-info-circle"></i>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_asset">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-read-book ico-2x"></i>
							Información del Bien Registrado
						</h6>
					</div>

					<div class="modal-body">

						<ul class="nav nav-tabs custom-tabs justify-content-center" role="tablist">
	                        <li class="nav-item">
	                            <a class="nav-link active" data-toggle="tab" href="#general" id="info_general" role="tab">
	                                <i class="ion-android-person"></i> Información General
	                            </a>
	                        </li>

	                        <li class="nav-item">
	                            <a class="nav-link" data-toggle="tab" href="#purchase" role="tab">
	                                <i class="ion-social-dropbox-outline"></i>
	                                Procedencia
	                            </a>
	                        </li>
	                    </ul>

	                    <div class="tab-content">
	                    	<div class="tab-pane active" id="general" role="tabpanel">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<strong>Tipo</strong>
											<div class="row" style="margin: 1px 0">
												<span class="col-md-12" id="asset_type">
												</span>
											</div>
											<input type="hidden" id="id">
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<strong>Categoria</strong>
											<div class="row" style="margin: 1px 0">
												<span class="col-md-12" id="asset_category">
												</span>
											</div>
							            </div>
							        </div>

							        <div class="col-md-6">
										<div class="form-group">
											<strong>Subcategoria</strong>
											<div class="row" style="margin: 1px 0">
												<span class="col-md-12" id="asset_subcategory">
												</span>
											</div>
										</div>
									</div>


							        <div class="col-md-6">
										<div class="form-group">
											<strong>Categoria especifica</strong>
											<div class="row" style="margin: 1px 0">
								        		<span class="col-md-12" id="asset_specific">
												</span>
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<strong>Código</strong>
											<div class="row" style="margin: 1px 0">
												<span class="col-md-12" id="asset_codigo"></span>
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<strong>Marca</strong>
											<div class="row" style="margin: 1px 0">
												<span class="col-md-12" id="asset_marca">
												</span>
											</div>
										</div>
									</div>


							        <div class="col-md-6">
										<div class="form-group">
											<strong>Modelo</strong>
											<div class="row" style="margin: 1px 0">
												<span class="col-md-12" id="asset_model">
												</span>
											</div>
										</div>
									</div>

							        <div class="col-md-6">
										<div class="form-group">
											<strong>Valor</strong>
											<div class="row" style="margin: 1px 0">
								        		<span class="col-md-12" id="asset_value">
												</span>
											</div>
										</div>
									</div>
							    </div>
							</div>

	                    	<div class="tab-pane" id="purchase" role="tabpanel">
	                    		<div class="row">
	                    			<div class="col-md-6">
										<div class="form-group">
											<strong>Forma de adquisición</strong>
											<div class="row" style="margin: 1px 0">
								        		<span class="col-md-12" id="asset_acquisition_type">
												</span>
											</div>
										</div>
									</div>


							        <div class="col-md-6">
										<div class="form-group">
											<strong>Fecha de adquisición</strong>
											<div class="row" style="margin: 1px 0">
								        		<span class="col-md-12" id="asset_acquisition_date">
												</span>
											</div>
										</div>
									</div>


							        <div class="col-md-6">
										<div class="form-group">
											<strong>Ubicación</strong>
											<div class="row" style="margin: 1px 0">
								        		<span class="col-md-12" id="asset_ubication">
												</span>
											</div>
										</div>
									</div>

							        <div class="col-md-6">
										<div class="form-group">
											<strong>Proveedor</strong>
											<div class="row" style="margin: 1px 0">
								        		<span class="col-md-12" id="asset_proveedor">
												</span>
											</div>
										</div>
									</div>


							        <div class="col-md-6">
										<div class="form-group">
											<strong>Condición física</strong>
											<div class="row" style="margin: 1px 0">
								        		<span class="col-md-12" id="asset_condition">
												</span>
											</div>
										</div>
									</div>


							        <div class="col-md-6">
										<div class="form-group">
											<strong>Estatus de uso</strong>
											<div class="row" style="margin: 1px 0">
								        		<span class="col-md-12" id="asset_status">
												</span>
											</div>
										</div>
									</div>

							        <div class="col-md-6">
										<div class="form-group">
											<strong>Función de uso</strong>
											<div class="row" style="margin: 1px 0">
								        		<span class="col-md-12" id="asset_use_function">
												</span>
											</div>
										</div>
									</div>


							        <div class="col-md-6">
										<div class="form-group">
											<strong>Serial de fábrica</strong>
											<div class="row" style="margin: 1px 0">
								        		<span class="col-md-12" id="asset_serial">
												</span>
											</div>
										</div>
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
				errors: [],
				records: []
			}
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
			 * Reescribe el método de initRecords para cambiar su comportamiento por defecto.
			 * Inicializa los registros base del formulario
			 *
			 * @author Henry Paredes <hparedes@cenditel.gob.ve>
			 */
            initRecords(url,modal_id){
            	this.errors = [];
				this.reset();

				const vm = this;
            	var fields = {};

            	document.getElementById("info_general").click();

            	axios.get('/' + url).then(response => {
					if (typeof(response.data.records) !== "undefined") {
						fields = response.data.records;

						document.getElementById('asset_type').innerText = (fields.asset_type)?fields.asset_type.name:'';
						document.getElementById('asset_category').innerText = (fields.asset_category)?fields.asset_category.name:'';
						document.getElementById('asset_subcategory').innerText = (fields.asset_subcategory)?fields.asset_subcategory.name:'';
						document.getElementById('asset_specific').innerText = (fields.asset_specific_category)?fields.asset_specific_category.name:'';
						document.getElementById('asset_codigo').innerText = fields.inventory_serial;

						document.getElementById('asset_acquisition_type').innerText = (fields.asset_acquisition_type)?fields.asset_acquisition_type.name:'';
						document.getElementById('asset_acquisition_date').innerText = (fields.acquisition_date)?fields.acquisition_date:'';
						document.getElementById('asset_ubication').innerText = (fields.ubication)?fields.ubication:'N/A';
						document.getElementById('asset_proveedor').innerText = (fields.proveedor)?fields.proveedor:'N/A';
						document.getElementById('asset_condition').innerText = (fields.asset_condition)?fields.asset_condition.name:'';
						document.getElementById('asset_status').innerText = (fields.asset_status)?fields.asset_status.name:'';

						document.getElementById('asset_use_function').innerText = (fields.asset_use_function)?fields.asset_use_function.name:'N/A';
						document.getElementById('asset_serial').innerText = (fields.serial)?fields.serial:'';
						document.getElementById('asset_marca').innerText = (fields.marca)?fields.marca:'';
						document.getElementById('asset_model').innerText = (fields.model)?fields.model:'';
						document.getElementById('asset_value').innerText = (fields.value)?fields.value:'';
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
            }

		},
	};
</script>
