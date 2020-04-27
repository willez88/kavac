<template>
	<div>
		<a class="btn btn-default btn-xs btn-icon btn-action"
		   href="#" title="Confirmar movimiento" data-toggle="tooltip"
		   @click="initMovement('view_movement_pending', $event)">
			<i class="fa fa-calendar-check-o"></i>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="view_movement_pending">
			<div class="modal-dialog modal-xs" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							Confirmar Movimiento de Almacén
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
							<div class="col-md-12">
								<div class="form-group">
									<label>Observación:</label>
                                    <ckeditor :editor="ckeditor.editor" data-toggle="tooltip"
                                              title="Indique alguna observación referente al movimiento de almacén"
                                              :config="ckeditor.editorConfig" class="form-control" tag-name="textarea"
                                              rows="3" v-model="record.observation"
                                              placeholder="Observaciones referentes al movimiento de almacén"></ckeditor>
								   <input type="hidden" v-model="record.id" id="id">
			                    </div>
							</div>

						</div>
	                </div>

	                <div class="modal-footer">
	                	<button type="button" class="btn btn-default btn-sm btn-round btn-modal-close"
	                			data-dismiss="modal">
	                		Cerrar
	                	</button>
	                	<button type="button" @click="updateRecord()"
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
					id:'',
					observation: '',
				},
				errors: [],
			}
		},
		props: {
			movementid: Number,
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
			initMovement(modal_id,event) {

				$(".modal-body #id").val( this.movementid );
				if ($("#" + modal_id).length) {
					$('#'+modal_id).modal('show');
				}
				event.preventDefault();
			},
			updateRecord() {
				const vm = this;
				var id = $(".modal-body #id").val();

				axios.put('/'+vm.route_update+'/'+id, vm.record).then(response => {
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
		},
	}
</script>
