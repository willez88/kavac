<template>
	<div>
		<a class="btn btn-info btn-xs btn-icon btn-action" 
		   href="#" title="Ver información del Bien" data-toggle="tooltip" 
		   @click="initRecord('add_asset',$event)">
			<i class="fa fa-info-circle"></i>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_asset">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-read-book ico-2x"></i> 
							Información del Bien Registrado
						</h6>
					</div>
					
					<div class="modal-body">
						
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Tipo</label>
									<input type="text"
										data-toggle="tooltip" 
										class="form-control"
										id="asset_type"
										disabled="true">
								</div>			        	
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label>Categoria</label>
					        		<input type="text"
										data-toggle="tooltip" 
										class="form-control"
										id="asset_category"
										disabled="true">
					            </div>
					        </div>

					        <div class="col-md-6">
								<div class="form-group">
									<label>Subcategoria</label>
					        		<input type="text"
										data-toggle="tooltip" 
										class="form-control"
										id="asset_subcategory"
										disabled="true">
								</div>
							</div>
					                

					        <div class="col-md-6">
								<div class="form-group">
									<label>Categoria Especifica</label>
					        		<input type="text"
										data-toggle="tooltip" 
										class="form-control"
										id="asset_specific"
										disabled="true">
								</div>
							</div>
					                
							<div class="col-md-6">
								<div class="form-group">
									<label>Código</label>
									<div>
										<span>{{this.record.code}}</span>
									</div>
									<input type="text"
										data-toggle="tooltip" 
										class="form-control"
										id="asset_codigo"
										disabled="true">
								</div>
							</div>
					                
							<div class="col-md-6">
								<div class="form-group">
									<label>Forma de Adquisición</label>
					        		<input type="text"
										data-toggle="tooltip" 
										class="form-control"
										id="asset_purchase"
										disabled="true">
								</div>
							</div>
					                

					        <div class="col-md-6">
								<div class="form-group">
									<label>Año de Adquisición</label>
					        		<input type="text"
										data-toggle="tooltip" 
										class="form-control"
										id="asset_purchase_year"
										disabled="true">
								</div>
							</div>
					                

					        <div class="col-md-6">
								<div class="form-group">
									<label>Ubicación</label>
					        		<input type="text"
										data-toggle="tooltip" 
										class="form-control"
										id="asset_ubication"
										disabled="true">
								</div>
							</div>
					                
					        <div class="col-md-6">
								<div class="form-group">
									<label>Proveedor</label>
					        		<input type="text"
										data-toggle="tooltip" 
										class="form-control"
										id="asset_proveedor"
										disabled="true">
								</div>
							</div>
					                

					        <div class="col-md-6">
								<div class="form-group">
									<label>Condición Física</label>
					        		<input type="text"
										data-toggle="tooltip" 
										class="form-control"
										id="asset_condition"
										disabled="true">
								</div>
							</div>
					                

					        <div class="col-md-6">
								<div class="form-group">
									<label>Estatus de Uso</label>
					        		<input type="text"
										data-toggle="tooltip" 
										class="form-control"
										id="asset_status"
										disabled="true">
								</div>
							</div>
					                
					        <div class="col-md-6">
								<div class="form-group">
									<label>Función de Uso</label>
					        		<input type="text"
										data-toggle="tooltip" 
										class="form-control"
										id="asset_use"
										disabled="true">
								</div>
							</div>
					                

					        <div class="col-md-6">
								<div class="form-group">
									<label>Serial de Fábrica</label>
					        		<input type="text"
										data-toggle="tooltip" 
										class="form-control"
										id="asset_serial"
										disabled="true">
								</div>
							</div>
					                

					        <div class="col-md-6">
								<div class="form-group">
									<label>Marca</label>
					        		<input type="text"
										data-toggle="tooltip" 
										class="form-control"
										id="asset_marca"
										disabled="true">
								</div>
							</div>
					                

					        <div class="col-md-6">
								<div class="form-group">
									<label>Modelo</label>
					        		<input type="text"
										data-toggle="tooltip" 
										class="form-control"
										id="asset_model"
										disabled="true">
								</div>
							</div>
					                

					        <div class="col-md-6">
								<div class="form-group">
									<label>Valor</label>
					        		<input type="text"
										data-toggle="tooltip" 
										class="form-control"
										id="asset_value"
										disabled="true">
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
				record: {
					id: '',
                    type: '',
                    category: '',
                    subcategory: '',
                    specific: '',
                    code: '',
                    purchase: '',
                    year: '',
                    ubication: '',
                    proveedor: '',
                    condition:'',
                    status:'',
                    use: '',
                    serial: '',
                    marca: '',
                    model: '',
                    value: '',
				},
				errors: [],
				records: []
			}
		},
		props: ['id'],
		methods: {
			/**
             * Método que borra todos los datos del formulario
             * 
             * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             */
            reset() {
                this.record = {
                    id: '',
                    type: '',
                    category: '',
                    subcategory: '',
                    specific: '',
                    code: '',
                    purchase: '',
                    year: '',
                    ubication: '',
                    proveedor: '',
                    condition:'',
                    status:'',
                    use: '',
                    serial: '',
                    marca: '',
                    model: '',
                    value: '',
                };
            },
            initRecord(modal_id,event){
            	if(this.id > 0 ){
            		this.getAsset();
            		event.preventDefault();
					if ($("#" + modal_id).length) {
						$('#'+modal_id).modal('show');
					}
            	}
            },
			/**
			 * Inicializa los registros base del formulario
			 *
			 * @author Henry Paredes (henryp2804@gmail.com)
			 */
			getAsset() {

				axios.get(this.route_list+"/"+this.id).then(response => {
					this.record = response.data.record;
/*					this.record.type = this.records.type;
					$(".modal-body #asset_type").val( this.records.type );
					$(".modal-body #asset_category").val( this.records.category );
					$(".modal-body #asset_subcategory").val( this.records.subcategory );
					$(".modal-body #asset_specific").val( this.records.specific );
					$(".modal-body #asset_codigo").val( this.records.code );

					$(".modal-body #asset_purchase").val( this.records.purchase );
					$(".modal-body #asset_purchase_year").val( this.records.year );
					$(".modal-body #asset_ubication").val( this.records.ubication );
					$(".modal-body #asset_proveedor").val( this.records.proveedor );
					$(".modal-body #asset_condition").val( this.records.condition );
					$(".modal-body #asset_status").val( this.records.status );

					$(".modal-body #asset_use").val( this.records.use );
					$(".modal-body #asset_serial").val( this.records.serial );
					$(".modal-body #asset_marca").val( this.records.marca );
					$(".modal-body #asset_model").val( this.records.model );
					$(".modal-body #asset_value").val( this.records.value );
*/					
				});

			}
		},
	}
</script>