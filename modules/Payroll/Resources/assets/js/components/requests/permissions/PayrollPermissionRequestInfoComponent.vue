<template>
	<section>
		<a class="btn btn-info btn-xs btn-icon btn-action"
		   href="#" title="Ver información" data-toggle="tooltip" v-has-tooltip
		   @click="addRecord('view_permission', route_list, $event)">
			<i class="fa fa-eye"></i>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="view_permission">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-read-book ico-2x"></i>
							Información de solicitud de permisos
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
												<strong>Fecha de Solicitud</strong>
												<div class="row" style="margin: 1px 0">
													<span class="col-md-12" id="date">
													</span>
												</div>
												<input type="hidden" id="id">
											</div>
										</div>

										<div class="col-md-4">
											<div class="form-group">
												<strong>Trabajador</strong>
												<div class="row" style="margin: 1px 0">
													<span class="col-md-12" id="payroll_staff_id">
													</span>
												</div>
								            </div>
										</div>

										<div class="col-md-4">
											<div class="form-group">
												<strong>Tipo de Permiso</strong>
												<div class="row" style="margin: 1px 0">
													<span class="col-md-12" id="payroll_permission_policy_id">
													</span>
												</div>
								            </div>
										</div>
								</div>
                                <label><h6>Periodo del Permiso</h6></label>
								<div class="row">
									<div class="col-md-4">
											<div class="form-group">
												<strong>Desde:</strong>
												<div class="row" style="margin: 1px 0">
													<span class="col-md-12" id="start_date">
													</span>
												</div>
								            </div>
									</div>
									<div class="col-md-4">
											<div class="form-group">
												<strong>Hasta:</strong>
												<div class="row" style="margin: 1px 0">
													<span class="col-md-12" id="end_date" >
													</span>
												</div>
								            </div>
									</div>
									<div class="col-md-4">
											<div class="form-group">
												<strong>Dias de permiso</strong>
												<div class="row" style="margin: 1px 0">
													<span class="col-md-12" id="day_permission">
													</span>
												</div>
								            </div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4">
											<div class="form-group">
												<strong>Motivo del permiso</strong>
												<div class="row" style="margin: 1px 0">
													<span class="col-md-12" id="motive_permission">
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
             *
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

            	axios.get('/' + url).then(response => {
					if (typeof(response.data.record) !== "undefined") {
						fields = response.data.record;

						$(".modal-body #id").val( fields.id );

		            	document.getElementById('date').innerText = (fields.date)?fields.date:'N/A';
						document.getElementById('payroll_staff_id').innerText =
							(fields.payroll_staff_id)
							? fields.payroll_staff.id
								? fields.payroll_staff.first_name + ' ' + fields.payroll_staff.last_name
								: 'No definido'
							: 'No definido';
		            	document.getElementById('payroll_permission_policy_id').innerText = (fields.payroll_permission_policy_id)?fields.payroll_permission_policy.name:'N/A';
		            	document.getElementById('start_date').innerText = (fields.start_date)?fields.start_date:'N/A';
		            	document.getElementById('end_date').innerText = (fields.end_date)?fields.end_date:'N/A';
		            	document.getElementById('day_permission').innerText = (fields.day_permission)?fields.day_permission:'N/A';
		            	document.getElementById('motive_permission').innerText = (fields.motive_permission)?fields.motive_permission:'N/A';
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
