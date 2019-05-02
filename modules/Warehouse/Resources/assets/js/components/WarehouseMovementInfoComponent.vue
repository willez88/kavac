<template>
	<div>
		<a class="btn btn-info btn-xs btn-icon btn-action" 
		   href="#" title="Ver información del Movimiento de Almacén" data-toggle="tooltip" 
		   @click="initRequest('view_movement',$event)">
			<i class="fa fa-info-circle"></i>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="view_movement">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-read-book ico-2x"></i> 
							Información del Movimiento Registrado
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
	                            <a class="nav-link" data-toggle="tab" href="#equipment" role="tab" @click="loadRequest()">
	                                <i class="ion-arrow-swap"></i> Equipos
	                            </a>
	                        </li>
	                    </ul>

	                    <div class="tab-content">
	                    	<div class="tab-pane active" id="general" role="tabpanel">
	                    		<div class="row">        
									<div class="col-md-12">
										<b>Datos del Movimiento</b>
									</div>

							        <div class="col-md-6">
										<div class="form-group">
											<label>Fecha de Registro</label>
							        		<input type="text"
												data-toggle="tooltip" 
												class="form-control input-sm" 
												id="date_init"
												readonly="readonly">
											<input type="hidden" id="id">
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label>Description</label>
											<input type="text"
												data-toggle="tooltip" 
												class="form-control"
												id="description"
												disabled="true">
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label>Observation</label>
											<input type="text"
												data-toggle="tooltip" 
												class="form-control"
												id="observation"
												disabled="true">
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label>Almacén de Origen</label>
											<input type="text"
												data-toggle="tooltip" 
												class="form-control"
												id="warehouse_init"
												disabled="true">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Almacén Destino</label>
											<input type="text"
												data-toggle="tooltip" 
												class="form-control"
												id="warehouse_finish"
												disabled="true">
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label>Estado del Movimiento</label>
											<input type="text"
												data-toggle="tooltip" 
												class="form-control"
												id="state"
												disabled="true">
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
	                	
	                	<button type="button" 
	                			class="btn btn-warning btn-icon btn-round btn-modal-close" 
	                			data-dismiss="modal"
	                			title="Cancelar y regresar">
	                			<i class="fa fa-ban"></i>
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
				columns: ['product.name', 'product.description','unit.name','quantity','unit_value'],
			}
		},
		props: {
		movement: Object, 
		},
		created() {
			this.table_options.headings = {
				'product.name': 'Nombre',
				'product.description': 'Descripción',
				'unit.name': 'Unidad',
				'quantity': 'Cantidad',
				'unit_value': 'Valor por Unidad'

			};
			this.table_options.sortable = ['product.name','product.description','unit.name','unit_value'];
			this.table_options.filterable = ['product.name', 'product.description','unit.name','unit_value'];

		},
		methods: {

            fillRequest(){         
            	$(".modal-body #id").val( this.movement.id );
            	$(".modal-body #date_init").val( this.movement.created_at );
				$(".modal-body #observation").val( (this.movement.observation != null)? this.movement.observation:'N/A');
            	$(".modal-body #description").val( this.movement.description );
            	$(".modal-body #warehouse_init").val( this.movement.start.warehouse.name );
            	$(".modal-body #warehouse_finish").val( this.movement.finish.warehouse.name );
            	$(".modal-body #state").val( (this.movement.complete)? "Completado":"Pendiente por Ejecutar" );
            },

			initRequest(modal_id,event) {

				this.fillRequest();
				document.getElementById("info_general").click();
				event.preventDefault();
				if ($("#" + modal_id).length) {
					$('#'+modal_id).modal('show');
				}

			},
			loadRequest(){
				const vm = this;
	            var fields = {};
	            var field = [];
	            
				var index = $(".modal-body #id").val();

				axios.get('/' + this.route_list +index).then(response => {
					fields = response.data.records.product_movements;
	                vm.movement.institution_id = response.data.records.finish.institution_id;
	                vm.movement.warehouse_id = response.data.records.finish.warehouse_id;
	                vm.records = [];

	                $.each(fields,function(index,campo){
	                	var record = campo.inventary;
	                    field = [];
	                    $.each(campo.inventary.product.attributes,function(index,att){
	                    	field.push({name: att.name, value: att.value.value});
	                    });
	                    record.quantity = campo.quantity;
	                    record.attributes = field;
	                    vm.records.push(record);
	                });
				});
			}
		},
	}
</script>