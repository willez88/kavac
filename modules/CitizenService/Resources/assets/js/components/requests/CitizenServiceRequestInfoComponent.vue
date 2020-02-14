<template>
	<section>
		<a class="btn btn-info btn-xs btn-icon btn-action" 
		   href="#" title="Ver información" data-toggle="tooltip" 
		   @click="addRecord('view_request', route_list, $event)">
			<i class="fa fa-eye"></i>
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
	                            <a class="nav-link active" data-toggle="tab" href="#general" id="info_general" role="tab">
	                                <i class="ion-android-person"></i> Información General
	                            </a>
	                        </li>
	                        <li class="nav-item">
	                            <a class="nav-link" data-toggle="tab" href="#contact" role="tab">
	                                <i class="ion-android-person"></i> Información de Contacto
	                            </a>
	                        </li>
	                        <li class="nav-item">
	                            <a class="nav-link" data-toggle="tab" href="#institution" role="tab">
	                                <i class="ion-arrow-person"></i> Información de la Institución
	                            </a>
	                        </li>
	                    </ul>
	                    <div class="tab-content">
	                    	<div class="tab-pane active" id="general" role="tabpanel">
		                    	<div class="row">        
								        <div class="col-md-4">
								        	<div class="form-group">
												<strong>Fecha de la Solicitud</strong>
												<div class="row" style="margin: 1px 0">
													<span class="col-md-12" id="date">
													</span>
												</div>
												<input type="hidden" id="id">
											</div>
										</div>

										<div class="col-md-4">
											<div class="form-group">
												<strong>Motivo de la Solicitud</strong>
												<div class="row" style="margin: 1px 0">
													<span class="col-md-12" id="motive_request">
													</span>
												</div>
								            </div>
										</div>

										<div class="col-md-4">
											<div class="form-group">
												<strong>Tipo de Solicitud</strong>
												<div class="row" style="margin: 1px 0">
													<span class="col-md-12" id="citizen_service_request_type_id">
													</span>
												</div>
								            </div>
										</div>
								</div>
							</div>
								<div class="tab-pane" id="contact" role="tabpanel">
		                    		<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<strong>Nombre</strong>
												<div class="row" style="margin: 1px 0">
													<span class="col-md-12" id="applicant_name">
													</span>
												</div>
								            </div>
										</div>

										<div class="col-md-4">
											<div class="form-group">
												<strong>Teléfono</strong>
												<div class="row" style="margin: 1px 0">
													<span class="col-md-12" id="applicant_phone">
													</span>
												</div>
								            </div>
										</div>

										<div class="col-md-4">
											<div class="form-group">
												<strong>Correo</strong>
												<div class="row" style="margin: 1px 0">
													<span class="col-md-12" id="email">
													</span>
												</div>
								            </div>
										</div>
		                    		</div>
		                    	</div>
		                    	<div class="tab-pane" id="institution" role="tabpanel">
		                    		<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<strong>Nombre de la institución</strong>
												<div class="row" style="margin: 1px 0">
													<span class="col-md-12" id="institution_name">
													</span>
												</div>
								            </div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<strong>Rif</strong>
												<div class="row" style="margin: 1px 0">
													<span class="col-md-12" id="rif">
													</span>
												</div>
								            </div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<strong>Dirección de la institución</strong>
												<div class="row" style="margin: 1px 0">
													<span class="col-md-12" id="institution_address">
													</span>
												</div>
								            </div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<strong>Dirección web</strong>
												<div class="row" style="margin: 1px 0">
													<span class="col-md-12" id="web">
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
	
	</section>
</template>
<script>
	export default {
		data() {
			return {
				records: [],
				errors: [],

			}
		},
		created() {


		},
		methods: {
			/**
             * Método que borra todos los datos del formulario
             * 
             * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
             */
            reset() {
            },

             initRecords(url,modal_id){
            	this.errors = [];
				this.reset();

				const vm = this;
            	var fields = {};
            	
            	document.getElementById("info_general").click();

            	axios.get(url).then(response => {
					if (typeof(response.data.record) !== "undefined") {
						fields = response.data.record;

						$(".modal-body #id").val( fields.id );

		            	document.getElementById('date').innerText = (fields.date)?fields.date:'N/A';
		            	document.getElementById('motive_request').innerText = (fields.motive_request)?fields.motive_request:'N/A';
		            	document.getElementById('citizen_service_request_type_id').innerText = (fields.citizen_service_request_type_id)?fields.citizen_service_request_type_id:'N/A';
		            	document.getElementById('applicant_name').innerText = (fields.first_name)?((fields.last_name)?(fields.first_name+fields.last_name):(fields.first_name)):'N/A';
		            	let phoneText = `
		            		<div class = "col-md-6">

		            	`;
		            	fields.phones.forEach(function(phone) {
							phoneText += `<p>${phone.area_code} ${phone.number}</p>`;
						});

		            	phoneText += '</div>';
		            	document.getElementById('applicant_phone').innerHTML = phoneText;
		            	document.getElementById('email').innerText = (fields.email)?fields.email:'N/A';
		            	document.getElementById('institution_name').innerText = (fields.institution_name)?fields.institution_name:'N/A';
		            	document.getElementById('rif').innerText = (fields.rif)?fields.rif:'N/A';
		            	document.getElementById('institution_address').innerText = (fields.institution_address)?fields.institution_address:'N/A';
		            	document.getElementById('web').innerText = (fields.web)?fields.web:'N/A';
					}
					console.log('filterable');
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
		},
	}
</script>