<template>
	<div>
		<button @click="addRecord('show_purchase_plan_'+id, route_show, $event)"
				class="btn btn-info btn-xs btn-icon btn-action" 
				title="Visualizar registro" 
				data-toggle="tooltip" >
			<i class="fa fa-eye"></i>
		</button>

		<div class="modal fade text-left" tabindex="-1" role="dialog" :id="'show_purchase_plan_'+id">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="reset" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="fa fa-list inline-block"></i>
							Plan de compra
						</h6>
					</div>
					<!-- Fromulario -->
					<div class="modal-body">
						<hr>
						<h6>INFORMACIÓN DEL PLAN DE COMPRA</h6>
						<br>
						<div class="row">
							<div class="col-3"><strong>Fecha de inicio:</strong> {{ format_date(records.init_date) }}</div>
							<div class="col-3"><strong>Fecha de culminación:</strong> {{ format_date(records.end_date) }}</div>
							<div class="col-3"><strong>Tipo de compra:</strong> {{ purchase_type }}</div>
							<div class="col-3"><strong>Proceso de compra:</strong> {{ purchase_process }}</div>
							<div class="col-3"><strong>Responsable:</strong> Empleado de nomina </div>
						</div>
						<hr>
						<h6 class="text-center text-info">DOCUMENTO DE PLAN DE COMPRAS</h6>

						<div class="row">
							<div class="col-md-12" v-if="records.document">
								<div id="documents">
									<div class="card-body">
										<ul class="feature-list list-group list-group-flush">
											<li class="list-group-item">
												<div class="feature-list-indicator bg-info"></div>
												<div class="feature-list-content p-0">
													<div class="feature-list-content-wrapper">
														<a :href="'/purchase/purchase_plans/download/'+records.document.code">
															{{ records.document.file }}
														</a>
														<div class="feature-list-content-left">
															<div class="feature-list-subheading">
															</div>
														</div>
													</div>
												</div>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</template>

<script>
export default{
	props:['id'],
	data(){
		return{
			records:[],
			files:{},
		}
	},
	created(){
		// 
	},
	mounted(){
		if (this.records.purchase_process) {
			this.record = this.records.purchase_process;
		}
	},
	methods:{

		/**
		 * Método que borra todos los datos del formulario
		 *
		 * @author  Juan Rosas <jrosas@cenditel.gob.ve> | <juan.rosasr01@gmail.com>
		 */
		reset() {
			// 
		},

		uploadFile(input_id){
			let vm = this;
			if (document.querySelector(`#${input_id}`)) {
				vm.loading = false;
				vm.files[input_id] = document.querySelector(`#${input_id}`).files[0];

				/** Se obtiene y da formato para enviar el archivo a la ruta */
				var formData = new FormData();
				var inputFile = document.querySelector('#'+input_id);
				formData.append("file", inputFile.files[0]);
				formData.append("purchase_plan_id", vm.id);

				axios.post('/purchase/purchase_plan_upload_file', formData, {
					headers: {
						'Content-Type': 'multipart/form-data'
					}
				}).then(response => {
					vm.showMessage('update');
					vm.loading = false;
					$('#status_'+input_id).show("slow");

				}).catch(error => {
					if (typeof(error.response) !== "undefined") {
						if (error.response.status == 422 || error.response.status == 500) {
							for (const i in error.response.data.errors){
								vm.showMessage(
									'custom', 'Error', 'danger', 'screen-error', error.response.data.errors[i][0]
								);
							}
						}
					}
					vm.loading = false;
				});
			}
		},
	},
	computed:{
		purchase_type: function(){
			if (this.records.purchase_type) {
				return this.records.purchase_type.name;
			}
		},
		purchase_process: function(){
			if (this.records.purchase_process) {
				return this.records.purchase_process.name;
			}
		},
	}
};
</script>
