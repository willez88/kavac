<template>
	<div>
		<a class="btn btn-success btn-xs btn-icon btn-action"
		   href="#" title="Aceptar solicitud" data-toggle="tooltip"
		   @click="initPending('view_pending_a', $event)"
		   v-if="request_type == 'accept'">
			<i class="fa fa-check"></i>
		</a>
		<a class="btn btn-danger btn-xs btn-icon btn-action"
		   href="#" title="Rechazar solicitud" data-toggle="tooltip"
		   @click="initPending('view_pending_r', $event)"
		   v-else>
			<i class="fa fa-ban"></i>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="view_pending_a">
			<div class="modal-dialog modal-xs" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							¿Seguro que desea aprobar esta solicitud?
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
									<li v-for="(error, index) in errors" :key="index">{{ error }}</li>
								</ul>
							</div>
						</div>
						  <div class="row">
								<div class="col-md-12">
									<p>
										Una vez aprobada la operación no se podrán realizar cambios en la misma.
									</p>
								</div>
								<div class="col-md-12">
										<div class="form-group">
											<label>Observación:</label>
		                                    <ckeditor :editor="ckeditor.editor" data-toggle="tooltip"
		                                              title="Indique alguna observación referente a la operación que esta realizando "
		                                              :config="ckeditor.editorConfig" class="form-control" tag-name="textarea"
		                                              rows="3" v-model="record.observation"
		                                              placeholder="Observaciones referentes a la operación"></ckeditor>
										  <input type="hidden" v-model="record.id" id="id">
					          </div>
								</div>
						  </div>
	          </div>

	                <div class="modal-footer">
	                	<button type="button" class="btn btn-default btn-sm btn-round btn-modal-close" data-dismiss="modal" title="Presione para cerrar la ventana" data-toggle="tooltip" v-has-tooltip>
	                		Cerrar
	                	</button>
	                	<button type="button" @click="updateRecord('/citizenservice/requests/request-approved/')"
	                			class="btn btn-primary btn-sm btn-round btn-modal-save"  title="Presione para guardar el registro" data-toggle="tooltip" v-has-tooltip>
	                		Guardar
		                </button>
		            </div>
		        </div>
		    </div>
		</div>

		<div class="modal fade text-left" tabindex="-1" role="dialog" id="view_pending_r">
			<div class="modal-dialog modal-xs" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							¿Seguro que desea rechazar esta solicitud?
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
									<li v-for="(error, index) in errors" :key="index">{{ error }}</li>
								</ul>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<p>
									Una vez aprobada la operación no se podrán realizar cambios en la misma.
								</p>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label>Observación:</label>
                                    <ckeditor :editor="ckeditor.editor" data-toggle="tooltip"
                                              title="Indique alguna observación referente a la operación que esta realizando "
                                              :config="ckeditor.editorConfig" class="form-control" tag-name="textarea"
                                              rows="3" v-model="record.observation"
                                              placeholder="Observaciones referentes a la operación"></ckeditor>
								   <input type="hidden" v-model="record.id" id="id">
			                    </div>
							</div>

						</div>
	                </div>

	                <div class="modal-footer">
	                	<button type="button" class="btn btn-default btn-sm btn-round btn-modal-close" data-dismiss="modal" title="Presione para cerrar la ventana" data-toggle="tooltip" v-has-tooltip>
	                		Cerrar
	                	</button>
	                	<button type="button" @click="updateRecord('/citizenservice/requests/request-rejected/')"
	                			class="btn btn-primary btn-sm btn-round btn-modal-save" title="Presione para guardar el registro" data-toggle="tooltip" v-has-tooltip>
	                		Guardar
		                </button>
		            </div>
		        </div>
		    </div>s
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				record: {
					id:'',
					observation: '',
				},
				errors: [],
			}
		},
		props: {
			requestid: Number,
			request_type: {
				type: String,
				required: true,
				default: 'accept'

			}
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
					observation:''
				};
			},
			initPending(modal_id,event) {

				$(".modal-body #id").val( this.requestid );
				if ($("#" + modal_id).length) {
					$('#'+modal_id).modal('show');
				}
				event.preventDefault();
			},
			updateRecord(url) {
				const vm = this;
				var id = $(".modal-body #id").val();
				if(typeof(url) != 'undefined'){
					url = vm.setUrl(url);
					axios.put(url + id, vm.record).then(response => {
	                    if (typeof(response.data.redirect) !== "undefined")
	                        location.href = response.data.redirect;
	                }).catch(error => {
	                    vm.errors = [];
	                    if (typeof(error.response) !="undefined") {
	                        for (var index in error.response.data.errors) {
	                            if (error.response.data.errors[index]) {
	                                vm.errors.push(error.response.data.errors[index][0]);
	                            }
	                        }
	                    }
	                });
              	}
			}
		},
	};
</script>
