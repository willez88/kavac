<template>
	<div>
		<a class="btn btn-default btn-xs btn-icon btn-action"
		   href="#" title="Solicitud de Prorroga" data-toggle="tooltip"
		   :disabled="((state == 'Aprobado')||(state == 'Pendiente por entrega'))?false:true"
		   @click="((state == 'Aprobado')||(state == 'Pendiente por entrega'))?addRecord('add_prorroga','asset/request/request-extensions', $event):viewMessage()">
			<i class="fa fa-calendar-plus-o"></i>
		</a>

		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_prorroga">
			<div class="modal-dialog modal-xs">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-meeting-add ico-2x"></i>
							Solicitud de Prorroga
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
									<li v-for="error in errors">{{ error }}</li>
								</ul>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Fecha de Entrega Actual</label>
					        		<input type="date"
										data-toggle="tooltip"
										class="form-control input-sm" v-model="record.date"
										id="delivery_date">
									<input type="hidden" v-model="record.id">
								</div>
							</div>
						</div>
					</div>

	                <div class="modal-footer">

	                	<button type="button" class="btn btn-default btn-sm btn-round btn-modal-close"
	                			data-dismiss="modal">
	                		Cerrar
	                	</button>
	                	<button type="button" @click="createRecord('asset/requests/request-extensions')"
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
					date: '',
					asset_request_id: ''
				},
				records: [],
				errors: [],
			}
		},
		props: {
			requestid: Number,
			state: String,
		},
		methods: {
			/**
             * Método que borra todos los datos del formulario
             *
             * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             */
            reset() {
                this.record = {
                    id: '',
					date: '',
					asset_request_id: ''
                };
            },
            /**
			 * Inicializa los registros base del formulario
			 *
			 * @author Henry Paredes <hparedes@cenditel.gob.ve>
			 */
            initRecords(url,modal_id){
				const vm = this;
				vm.errors = [];
            	var fields = {};
            	var url = 'requests/vue-info/' + this.requestid;
            	axios.get(url).then(response => {
					if (typeof(response.data.records) !== "undefined") {
						fields = response.data.records;

						vm.record = {
							id: '',
							date: fields.delivery_date,
							asset_request_id: vm.requestid
						};
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
            viewMessage() {
            	const vm = this;
            	vm.showMessage(
                    'custom', 'Alerta', 'danger', 'screen-error',
                    'La solicitud está en un tramite que no le permite acceder a esta funcionalidad'
                );
            	return false;
            },
		},
	};
</script>
