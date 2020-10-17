<template>
	<div>
		<a class="btn btn-info btn-xs btn-icon btn-action"
		   href="#" title="Ver información del registro" data-toggle="tooltip"
		   @click="addRecord('sale_view_reception', route_list , $event)">
			<i class="fa fa-info-circle"></i>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="sale_view_reception">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-read-book ico-2x"></i>
							Información de la Recepción Registrada
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
	                            <a class="nav-link" data-toggle="tab" href="#products" role="tab" @click="loadProducts()">
	                                <i class="ion-arrow-swap"></i> Equipos Ingresados
	                            </a>
	                        </li>
	                    </ul>

						<div class="tab-content">
                            <div class="tab-pane active" id="general" role="tabpanel">
                                <div class="row">

							        <div class="col-md-6">
										<div class="form-group">
											<strong>Fecha de Registro</strong>
											<div class="row" style="margin: 1px 0">
												<span class="col-md-12" id="date_init">
												</span>
											</div>
											<input type="hidden" id="id">
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<strong>Descripción</strong>
											<div class="row" style="margin: 1px 0">
												<span class="col-md-12" id="description">
												</span>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<strong>Almacén</strong>
											<div class="row" style="margin: 1px 0">
												<span class="col-md-12" id="sale_warehouse">
												</span>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<strong>Estado de la Solicitud</strong>
											<div class="row" style="margin: 1px 0">
												<span class="col-md-12" id="state">
												</span>
											</div>
										</div>
									</div>
							    </div>
							</div>

							<div class="tab-pane" id="products" role="tabpanel">
								<div class="modal-table">
									<v-client-table :columns="columns" :data="records" :options="table_options">
										<div slot="code" slot-scope="props" class="text-center">
											<span>
												{{ props.row.sale_warehouse_inventory_product.code }}
											</span>
										</div>
										<div slot="quantity" slot-scope="props">
											<span>
												{{ props.row.quantity }}
												{{ (props.row.sale_warehouse_inventory_product.measurement_unit)
														? props.row.sale_warehouse_inventory_product.measurement_unit.acronym
														: '' }}
											</span>
										</div>
										<div slot="unit_value" slot-scope="props">
											<span>
												{{ props.row.sale_warehouse_inventory_product.unit_value }}
												{{ (props.row.sale_warehouse_inventory_product.currency)
													? props.row.sale_warehouse_inventory_product.currency.symbol
													: ''
												}}
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
				columns: ['code',
					'sale_warehouse_inventory_product.sale_setting_product.name',
					'sale_warehouse_inventory_product.sale_setting_product.description',
					'quantity',
					'unit_value'],
			}
		},
		created() {
			this.table_options.headings = {
				'code': 'Código',
				'sale_warehouse_inventory_product.sale_setting_product.name': 'Nombre',
				'sale_warehouse_inventory_product.sale_setting_product.description': 'Descripción',
				'quantity': 'Cantidad Agregada',
				'unit_value': 'Valor por Unidad'

			};
			this.table_options.sortable = [
				'code',
				'sale_warehouse_inventory_product.name',
				'sale_warehouse_inventory_product.description',
				'quantity',
				'unit_value'
			];
			this.table_options.filterable = [
				'code',
				'sale_warehouse_inventory_product.name',
				'sale_warehouse_inventory_product.description',
				'quantity',
				'unit_value'
			];

		},
		methods: {

			/**
             * Método que borra todos los datos del formulario
             *
             * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
             */
            reset() {
            },

            /**
			 * Reescribe el método de initRecords para cambiar su comportamiento por defecto.
			 * Inicializa los registros base del formulario
			 *
			 * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
			 */
			initRecords(url, modal_id) {
				this.errors = [];
				this.reset();

				const vm = this;
                var fields = {};

                document.getElementById("info_general").click();
                axios.get(url).then(response => {
					if (typeof(response.data.records) !== "undefined") {
						fields = response.data.records;

                        $(".modal-body #id").val( fields.id );
                        document.getElementById('date_init').innerText = (fields.created_at)?fields.created_at:'';
                        document.getElementById('description').innerText = (fields.description)?fields.description:'';
                        document.getElementById('sale_warehouse').innerText = (fields.sale_warehouse_institution_warehouse_end)?fields.sale_warehouse_institution_warehouse_end.sale_warehouse.name:'';
                        document.getElementById('state').innerText = (fields.state)?fields.state:'No definido';
                        this.records = fields.sale_warehouse_inventory_product_movements;
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

			/**
			 * Actualiza los productos asocados a la solicitud
			 *
			 * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
			 */
			loadProducts() {
				const vm = this;
				var index = $(".modal-body #id").val();

				axios.get('/sale/receptions/info/' + index).then(response => {
					this.records = response.data.records.sale_warehouse_inventory_product_movements;
				});
			}
		},
	}
</script>
