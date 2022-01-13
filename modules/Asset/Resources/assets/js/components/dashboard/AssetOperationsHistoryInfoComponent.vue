<template>
	<div>
		<a class="btn btn-info btn-xs btn-icon btn-action"
		   href="#" title="Ver información de la operación" data-toggle="tooltip"
		   @click="addRecord('view_operation', route_list, $event)">
			<i class="fa fa-info-circle"></i>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="view_operation">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-read-book ico-2x"></i>
							Información de la Operación Registrada
						</h6>
					</div>

					<div class="modal-body">

						<div class="alert alert-danger" v-if="errors.length > 0">
							<ul>
								<li v-for="error in errors" :key="error">{{ error }}</li>
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
	                                <i class="ion-arrow-swap"></i> Equipos
	                            </a>
	                        </li>
	                    </ul>

	                    <div class="tab-content">
	                    	<div class="tab-pane active" id="general" role="tabpanel">
	                    		<div class="row">
		                            <div class="col-md-6">
		                                <div class="form-group">
		                                    <strong>Fecha de la Operación</strong>
		                                    <div class="row" style="margin: 1px 0">
		                                        <span class="col-md-12" id="created_at"></span>
		                                    </div>
		                                    <input type="hidden" id="url_search">
		                                </div>
		                            </div>
		                            <div class="col-md-6">
		                                <div class="form-group">
		                                    <strong>Tipo de Operación</strong>
		                                    <div class="row" style="margin: 1px 0">
		                                        <span class="col-md-12" id="type_operation"></span>
		                                    </div>
		                                </div>
		                            </div>
		                            <div class="col-md-12">
		                                <div class="form-group">
		                                    <strong>Descripción</strong>
		                                    <div class="row" style="margin: 1px 0">
		                                        <span class="col-md-12" id="description"></span>
		                                    </div>
		                                </div>
		                            </div>
		                        </div>
	                    	</div>

	                    	<div class="tab-pane" id="equipment" role="tabpanel">
	                    		<div class="row">
		                            <div class="col-md-12">
		                                <span class="text-muted">
		                                    A continuación se muestran los equipos asociados a la operación.
		                                </span>
		                            </div>
		                        </div>
	                    		<div class="modal-table">
									<v-client-table :columns="columns" :data="records" :options="table_options">
										<div slot="inventory_serial" slot-scope="props" class="text-center">
		                                    <span>
		                                        {{ (props.row.asset)?props.row.asset.inventory_serial:props.row.inventory_serial }}
		                                    </span>
		                                </div>
		                                <div slot="serial" slot-scope="props" class="text-center">
		                                    <span>
		                                        {{ (props.row.asset)?props.row.asset.serial:props.row.serial }}
		                                    </span>
		                                </div>
		                                <div slot="marca" slot-scope="props" class="text-center">
		                                    <span>
		                                        {{ (props.row.asset)?props.row.asset.marca:props.row.marca }}
		                                    </span>
		                                </div>
		                                <div slot="model" slot-scope="props" class="text-center">
		                                    <span>
		                                        {{ (props.row.asset)?props.row.asset.model:props.row.model }}
		                                    </span>
		                                </div>
									</v-client-table>
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
				columns: ['inventory_serial','serial','marca','model'],
			}
		},
		props: {
			operation: Object,
		},
		created() {
			this.table_options.headings = {
                'inventory_serial': 'Código',
                'serial': 'Serial',
                'marca': 'Marca',
                'model': 'Modelo',
            };
            this.table_options.sortable = ['inventory_serial','serial','marca','model'];
            this.table_options.filterable = false;
            this.table_options.orderBy = { 'column': 'inventory_serial'};

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
             * Reescribe el método initRecords para cambiar el comportamiento por defecto
			 * Inicializa los registros base del formulario
			 *
			 * @author Henry Paredes <hparedes@cenditel.gob.ve>
			 */
            initRecords(url, modal_id) {
            	const vm = this;
            	vm.errors = [];
				vm.reset();

            	document.getElementById("info_general").click();

            	$(".modal-body #url_search").val( vm.operation.type_operation + '/' + vm.operation.code );
            	document.getElementById('created_at').innerText = (vm.operation.created_at)?vm.operation.created_at:'N/A';
            	document.getElementById('type_operation').innerText =
        		(vm.operation.type_operation == 'registers')?'Registro de bienes':(
        			(vm.operation.type_operation == 'asignations')?'Asignación de bienes':(
        				(vm.operation.type_operation == 'requests')?'Solicitud de bienes':(
        					(vm.operation.type_operation == 'disincorporations')?'Desincorporación de bienes':'N/A'
        				)
        			)
        		);
            	document.getElementById('description').innerText = (vm.operation.description)?vm.operation.description:'N/A';

            	if ($("#" + modal_id).length) {
					$("#" + modal_id).modal('show');
				}
            },
			loadEquipment() {
				var url_search = $(".modal-body #url_search").val();
				axios.get(this.route_list + '/' + url_search).then(response => {
					this.records = response.data.records;
				});
			}
		},
	};
</script>
