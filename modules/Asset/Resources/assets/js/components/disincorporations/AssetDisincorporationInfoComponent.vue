<template>
	<div>
		<a class="btn btn-info btn-xs btn-icon btn-action"
		   href="#" title="Ver información del registro" data-toggle="tooltip"
		   @click="addRecord('view_disincorporation',route_list ,$event)">
			<i class="fa fa-info-circle"></i>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="view_disincorporation">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-read-book ico-2x"></i>
							Información de la Desincorporación Registrada
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
	                            <a class="nav-link" data-toggle="tab" href="#equipment" role="tab" @click="loadEquipment()">
	                                <i class="ion-arrow-swap"></i> Equipos Desincorporados
	                            </a>
	                        </li>
	                    </ul>

	                    <div class="tab-content">
	                    	<div class="tab-pane active" id="general" role="tabpanel">
	                    		<div class="row">
							        <div class="col-md-6">
										<div class="form-group">
											<strong>Fecha de la Desincorporación</strong>
											<div class="row" style="margin: 1px 0">
												<span class="col-md-12" id="date">
												</span>
											</div>
											<input type="hidden" id="id">
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<strong>Motivo</strong>
											<div class="row" style="margin: 1px 0">
												<span class="col-md-12" id="motive">
												</span>
											</div>
							            </div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<strong>Observaciones</strong>
											<div class="row" style="margin: 1px 0">
												<span class="col-md-12" id="observation">
												</span>
											</div>
							            </div>
									</div>

							    </div>
	                    	</div>

	                    	<div class="tab-pane" id="equipment" role="tabpanel">
	                    		<div class="row">
	                    			<div class="col-md-12">
										<hr>
										<v-client-table :columns="columns" :data="records" :options="table_options">

										</v-client-table>
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
				records: [],
				errors: [],
				columns: ['asset.inventory_serial','asset.serial','asset.marca','asset.model'],
			}
		},
		created() {
			this.table_options.headings = {
				'asset.inventory_serial': 'Código',
				'asset.serial': 'Serial',
				'asset.marca': 'Marca',
				'asset.model': 'Modelo',
			};
			this.table_options.sortable = ['asset.inventory_serial','asset.serial','asset.marca','asset.model'];
			this.table_options.filterable = ['asset.inventory_serial','asset.serial','asset.marca','asset.model'];
			this.table_options.orderBy = { 'column': 'asset.id'};

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

            	axios.get(url).then(response => {
					if (typeof(response.data.records) !== "undefined") {
						fields = response.data.records;

						$(".modal-body #id").val( fields.id );
		            	document.getElementById('date').innerText = (fields.date)?fields.date:fields.created_at;
		            	document.getElementById('motive').innerText = (fields.asset_disincorporation_motive)?fields.asset_disincorporation_motive.name:'N/A';
		            	document.getElementById('observation').innerText = (fields.observation)?fields.observation:'N/A';
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
			loadEquipment(){
				var index = $(".modal-body #id").val();
				axios.get('/asset/disincorporations/vue-info/' + index).then(response => {
					this.records = response.data.records.asset_disincorporation_assets;
				});
			}
		},
	};
</script>
