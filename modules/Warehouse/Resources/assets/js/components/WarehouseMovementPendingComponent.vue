<template>
	<div>
		<a class="btn btn-success btn-xs btn-icon btn-action" 
		   href="#" title="Confirmar Movimiento de Almacén" data-toggle="tooltip" 
		   @click="initMovement('view_movement_pending',$event)">
			<i class="fa fa-check"></i>
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
							<ul>
								<li v-for="error in errors">{{ error }}</li>
							</ul>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>Observación:</label>
									<textarea  placeholder="Observaciones referentes al movimiento de almacén"
											   data-toggle="tooltip" 
											   title="Indique alguna observación referente al movimiento de almacén" 
											   class="form-control input-sm" v-model="record.observation">
								   </textarea>
								   <input type="hidden" v-model="record.id" id="id">
			                    </div>
							</div>

						</div>
	                </div>

	                <div class="modal-footer">

	                	<button type="button" @click="reset()"
								class="btn btn-default btn-icon btn-round"
								title ="Borrar datos del formulario">
								<i class="fa fa-eraser"></i>
						</button>
	                	
	                	<button type="button" 
	                			class="btn btn-warning btn-icon btn-round btn-modal-close" 
	                			data-dismiss="modal"
	                			title="Cancelar y regresar">
	                			<i class="fa fa-ban"></i>
	                	</button>

	                	<button type="button" @click="updateRecord('/warehouse/movements-complete/')" 
	                			class="btn btn-success btn-icon btn-round btn-modal-save"
	                			title="Guardar registro">
	                		<i class="fa fa-save"></i>
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
			 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
			 */
			reset() {
				this.record = {
					id: '',
					observation:''
				};
			},
			initMovement(modal_id,event){
				
				$(".modal-body #id").val( this.movementid );
				if ($("#" + modal_id).length) {
					$('#'+modal_id).modal('show');
				}
				event.preventDefault();
			},
			updateRecord(url){
				const vm = this;
				var id = $(".modal-body #id").val();
				if(typeof(url) != 'undefined'){
					axios.put(url + id, vm.record).then(response => {
						if (response.data.result) {
	                        vm.showMessage('update');
	                        setTimeout(function() {
	                            window.location.href = '/warehouse/movements';
	                        }, 2000);
	                    }
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
	}
</script>
