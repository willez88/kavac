<template>
	<section>
		<a class="btn btn-info btn-xs btn-icon btn-action"
		   href="#" title="Ver información" data-toggle="tooltip"
		   @click="addRecord('view_register', route_list, $event)">
			<i class="fa fa-eye"></i>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="view_register">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-read-book ico-2x"></i>
							Información de Cronograma Registrado
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
	                    </ul>
	                    <div class="tab-content">
	                    	<div class="tab-pane active" id="general" role="tabpanel">
		                    	<div class="row">
								        <div class="col-md-4">
								        	<div class="form-group">
												<strong>Fecha del Registro</strong>
												<div class="row" style="margin: 1px 0">
													<span class="col-md-12" id="date_register">
													</span>
												</div>
												<input type="hidden" id="id">
											</div>
										</div>

										<div class="col-md-4">
											<div class="form-group">
												<strong>Nombre del Director</strong>
												<div class="row" style="margin: 1px 0">
													<span class="col-md-12" id="first_name">
													</span>
												</div>
								            </div>
										</div>

										<div class="col-md-4">
											<div class="form-group">
												<strong>Nombre del Proyecto</strong>
												<div class="row" style="margin: 1px 0">
													<span class="col-md-12" id="project_name">
													</span>
												</div>
								            </div>
										</div>
								</div>
								<div class="row">
									<div class="col-md-4">
											<div class="form-group">
												<strong>Actividades</strong>
												<div class="row" style="margin: 1px 0">
													<span class="col-md-12" id="activities">
													</span>
												</div>
								            </div>
									</div>
									<div class="col-md-4">
											<div class="form-group">
												<strong>Fecha de Inicio</strong>
												<div class="row" style="margin: 1px 0">
													<span class="col-md-12" id="start_date">
													</span>
												</div>
								            </div>
									</div>
									<div class="col-md-4">
											<div class="form-group">
												<strong>Fecha de Culminación</strong>
												<div class="row" style="margin: 1px 0">
													<span class="col-md-12" id="end_date">
													</span>
												</div>
								            </div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4">
											<div class="form-group">
												<strong>Correo Electrónico</strong>
												<div class="row" style="margin: 1px 0">
													<span class="col-md-12" id="email">
													</span>
												</div>
								            </div>
									</div>
									<div class="col-md-4">
											<div class="form-group">
												<strong>Porcentaje de cumplimiento</strong>
												<div class="row" style="margin: 1px 0">
													<span class="col-md-12" id="percent">
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
             * @author Yennifer Ramirez <yramirez@cenditel.gob.ve>
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

		            	document.getElementById('date_register').innerText = (fields.date_register)?fields.date_register:'N/A';
		            	document.getElementById('first_name').innerText = (fields.first_name)?fields.first_name:'N/A';
		            	document.getElementById('project_name').innerText = (fields.project_name)?fields.project_name:'N/A';
		            	document.getElementById('activities').innerText = (fields.activities)?fields.activities:'N/A';
		            	document.getElementById('start_date').innerText = (fields.start_date)?fields.start_date:'N/A';
		            	document.getElementById('end_date').innerText = (fields.end_date)?fields.end_date:'N/A';
		            	document.getElementById('email').innerText = (fields.email)?fields.email:'N/A';
		            	document.getElementById('percent').innerText = (fields.percent)?fields.percent:'N/A';
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
		},
	};
</script>
