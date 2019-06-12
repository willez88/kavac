<template>
	<div>
		<a class="btn btn-default btn-xs btn-icon btn-action" 
		   href="#" title="Solicitud de Prorroga" data-toggle="tooltip" 
		   :disabled="(request.type == 1)?true:false"
		   @click="initRequest('add_prorroga',$event)">
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
							<ul>
								<li v-for="error in errors">{{ error }}</li>
							</ul>
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
	                	<button type="button" @click="createRecord('asset/requests/request-prorroga')"
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
					request_id: ''
				},
				records: [],
				errors: [],
			}
		},
		props: {
			request: Object
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
					request_id: ''
                };
            },
            fillRequest(){
            	this.record.date = this.request.delivery_date;
            	this.record.request_id = this.request.id;
            	$(".modal-body #delivery_date").val( this.record.date );
            },
			/**
			 * Inicializa los registros base del formulario
			 */
			initRequest(modal_id,event) {
				event.preventDefault();
				this.reset();

				this.fillRequest();
				if ($("#" + modal_id).length) {
					$('#'+modal_id).modal('show');
				}

			},
			createRequest(url) {
				
				var fields = {};
				for (var index in this.record) {
					fields[index] = this.record[index];
				}
				
				axios.post(url, fields).then(response => {
					this.reset();
					this.readRecords(url);
					this.showMessage('store');
					setTimeout(function() {
                        window.location.href = '/asset/requests';
                    }, 2000);
				}).catch(error => {
					this.errors = [];

						if (typeof(error.response) !="undefined") {
						for (var index in error.response.data.errors) {
							if (error.response.data.errors[index]) {
								this.errors.push(error.response.data.errors[index][0]);
							}
						}
					}
				});
			}
		},
	}
</script>