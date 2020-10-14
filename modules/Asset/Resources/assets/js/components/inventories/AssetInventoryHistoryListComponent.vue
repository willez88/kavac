<template>
	<div>
		<div class="card">
			<div class="card-header">
				<h6 class="card-title text-uppercase">Historial de Inventario de Bienes Institucionales</h6>
				<div class="card-btns">
					<a href="#" class="btn btn-sm btn-primary btn-custom" @click="redirect_back(route_list)"
					   title="Ir atrás" data-toggle="tooltip">
						<i class="fa fa-reply"></i>
					</a>
					<a href="#" class="btn btn-sm btn-primary btn-custom" @click="createRecord('asset/inventory-history')"
					   title="Guardar estado actual de inventario" data-toggle="tooltip">
						<i class="fa fa-plus-circle"></i>
					</a>
					<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar"
					   data-toggle="tooltip">
						<i class="now-ui-icons arrows-1_minimal-up"></i>
					</a>
				</div>
			</div>
			<div class="card-body">
				<v-client-table :columns="columns" :data="records" :options="table_options">
					<div slot="id" slot-scope="props" class="text-center">
						<div class="d-inline-flex">

							<button @click="showReport(props.row.code, 'create_report')"
									class="btn btn-primary btn-xs btn-icon btn-action"
									title="Generar reporte de bienes" data-toggle="tooltip"
									type="button">
								<i class="fa fa-file-pdf-o"></i>
							</button>

				    		<button @click="deleteRecord(props.index, 'asset/inventory-history/delete')"
									class="btn btn-danger btn-xs btn-icon btn-action"
									title="Eliminar registro" data-toggle="tooltip"
									type="button">
								<i class="fa fa-trash-o"></i>
							</button>
						</div>
					</div>
				</v-client-table>
			</div>
		</div>

		<div class="modal fade text-left" tabindex="-1" role="dialog" id="create_report">
			<div class="modal-dialog modal-xs">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-file-pdf ico-2x"></i>
							Generar Reporte de Bienes?
						</h6>
					</div>

					<div class="modal-body">
						<div class="row">
							<div class="col-md-12">
								<strong>Tipo de Reporte</strong>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>General</label>
									<div class="col-12">
										<input type="radio" name="type_report" value="general" checked=""
                                               id="sel_general_report"
                                               class="form-control bootstrap-switch bootstrap-switch-mini sel_type_report"
                                               data-on-label="SI" data-off-label="NO">
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Por Clasificación</label>
									<div class="col-12">
										<input type="radio" name="type_report" value="clasification" id="sel_clasification_report" class="form-control bootstrap-switch bootstrap-switch-mini sel_type_report" data-on-label="SI" data-off-label="NO">
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Por Dependencia</label>
									<div class="col-12">
										<input type="radio" name="type_report" value="dependence" id="sel_dependence_report" class="form-control bootstrap-switch bootstrap-switch-mini sel_type_report" data-on-label="SI" data-off-label="NO">
									</div>
								</div>
							</div>
						</div>
					</div>

	                <div class="modal-footer">

	                	<button data-bb-handler="cancel" type="button" class="btn btn-default btn-modal-close" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>

	                	<button data-bb-handler="confirm" type="button" class="btn btn-primary" @click="createReport('create_report')"><i class="fa fa-check"></i> Confirmar</button>

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
					code: '',
					type_report: '',
				},
				records: [],
				columns: ['code', 'created_at', 'registered', 'assigned', 'disincorporated', 'id'],
			}
		},
		created() {
			this.table_options.headings = {
				'code': 'Código',
				'created_at': 'Fecha de Creación',
				'registered': 'Bienes Registrados',
				'assigned': 'Bienes Asignados',
				'disincorporated': 'Bienes Desincorporados',
				'id': 'Acción'
			};
			this.table_options.sortable = ['code', 'created_at', 'registered', 'assigned', 'disincorporated'];
			this.table_options.filterable = ['code', 'created_at', 'registered', 'assigned', 'disincorporated'];
			this.table_options.orderBy = { 'column': 'id'};
		},
		mounted () {
			this.initRecords('/asset/inventory-history/vue-list', '');
			this.switchHandler('type_report');
		},
		methods: {
			/**
			 * Inicializa los datos del formulario
			 *
			 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
			 */
			reset() {
				this.record = {
					id: '',
					code: '',
					type_report: 'general',
				}
			},
			showReport(code, modal_id) {
				const vm = this;
				vm.reset();
				vm.record.code = code;
				if ($("#" + modal_id).length) {
					$("#" + modal_id).modal('show');
				}
			},
			createReport(modal_id) {
				const vm = this;
				if (vm.record.type_report == 'dependence') {
					return false;
				}
				var url = '/asset/reports/' + vm.record.type_report + '/show/' + vm.record.code;
				window.open(url, '_blank');
				if ($("#" + modal_id).length) {
					$("#" + modal_id).modal('hide');
				}
			}
		}
	};
</script>
