<template>
	<div class="col-md-2 text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary" 
		   href="" title="Registros de Impuestos" data-toggle="tooltip" 
		   @click="addRecord('add_tax', 'taxes', $event)">
			<i class="icofont icofont-deal ico-3x"></i>
			<span>Impuestos</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_tax">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-deal inline-block"></i> 
							Impuestos
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
								<div class="form-group is-required">
									<label>Nombre:</label>
									<input type="text" placeholder="Impuesto" data-toggle="tooltip" 
										   title="Indique el nombre del impuesto (requerido)" 
										   class="form-control input-sm" v-model="record.name">
									<input type="hidden" v-model="record.id">
			                    </div>
							</div>
							<div class="col-md-6">
								<div class="form-group is-required">
									<label>Descripción:</label>
									<input type="text" placeholder="Descripción" data-toggle="tooltip" 
										   title="Indique una descripción breve del impuesto (requerido)" 
										   class="form-control input-sm" v-model="record.description">
			                    </div>
							</div>
							<div class="col-md-6">
								<div class="form-group is-required">
									<label>Fecha entrada en vigencia:</label>
									<input type="date" placeholder="dd/mm/yyyy" data-toggle="tooltip" 
										   title="Seleccione una fecha del calendario (requerido)" 
										   class="form-control input-sm" v-model="record.operation_date">
			                    </div>
							</div>
							<div class="col-md-6">
								<div class="form-group is-required">
									<label>Porcentaje:</label>
									<input type="number" placeholder="0" step="0.01" data-toggle="tooltip" 
										   title="Indique el porcentaje del impuesto (requerido)"
										   class="form-control input-sm" v-model="record.percentage">
			                    </div>
							</div>
							<div class="col-md-6">
								<div class="form-group is-required">
									<label>Afecta cuenta de IVA:</label>
									<input type="checkbox" class="form-control bootstrap-switch" 
										   data-toggle="tooltip" name="affect_tax" 
										   title="Indique si afecta la cuenta presupuestaria de IVA" 
										   data-on-label="SI" data-off-label="NO" 
										   v-model="record.affect_tax" value="true">
			                    </div>
							</div>
							<div class="col-md-6">
								<div class="form-group is-required">
									<label>Activo:</label>
									<input type="checkbox" class="form-control bootstrap-switch" 
										   data-toggle="tooltip" name="active" 
										   title="Indique si el impuesta esta o no activo" 
										   data-on-label="SI" data-off-label="NO" 
										   v-model="record.active" value="true">
			                    </div>
							</div>
						</div>
	                </div>
	                <div class="modal-body modal-table">
	                	<hr>
	                	<v-client-table :columns="columns" :data="records" :options="table_options">
	                		<div slot="id" slot-scope="props" class="text-center">
	                			<button @click="initUpdate(props.index, $event)" 
		                				class="btn btn-warning btn-xs btn-icon btn-round" 
		                				title="Modificar registro" data-toggle="tooltip" type="button">
		                			<i class="fa fa-edit"></i>
		                		</button>
		                		<button @click="deleteRecord(props.index, 'taxes')" 
										class="btn btn-danger btn-xs btn-icon btn-round" 
										title="Eliminar registro" data-toggle="tooltip" 
										type="button">
									<i class="fa fa-trash-o"></i>
								</button>
	                		</div>
	                	</v-client-table>
	                    <!--<table class="table table-hover table-striped dt-responsive nowrap datatable">
							<thead>
								<tr class="text-center">
									<th>Nombre</th>
									<th>Descripción</th>
									<th>Fecha Vigencia</th>
									<th>Porcentaje</th>
									<th>Activo</th>
									<th>Acción</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="(rec, index) in records">
									<td>{{ rec.name }}</td>
									<td>{{ rec.description }}</td>
									<td>{{ rec.histories.operation_date }}</td>
									<td>{{ rec.histories.percentage }}</td>
									<td v-if="rec.active">Activo</td>
									<td v-else>Inactivo</td>
									<td class="text-center" width="10%">
										<button @click="initUpdate(index, $event)" 
												class="btn btn-warning btn-xs btn-icon btn-round" 
												title="Modificar registro" data-toggle="tooltip" type="button">
											<i class="fa fa-edit"></i>
										</button>
										<button @click="deleteRecord(index, 'taxes')" 
												class="btn btn-danger btn-xs btn-icon btn-round" title="Eliminar registro" data-toggle="tooltip" type="button">
											<i class="fa fa-trash-o"></i>
										</button>
									</td>
								</tr>
							</tbody>
						</table>-->
	                </div>
	                <div class="modal-footer">
	                	<button type="button" class="btn btn-default btn-sm btn-round btn-modal-close" 
	                			data-dismiss="modal">
	                		Cerrar
	                	</button>
	                	<button type="button" @click="createRecord('taxes')" 
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
					name: '',
					description: '',
					affect_tax: false,
					active: false,
					operation_date: '',
					percentage: ''
				},
				errors: [],
				records: [],
				columns: [
					'name', 'description', 'histories.operation_date', 'histories.percentage', 
					'active', 'id'
				],
			}
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
					name: '',
					description: '',
					affect_tax: false,
					active: false,
					operation_date: '',
					percentage: ''
				};
			},
		},
		created() {
			this.table_options.headings = {
				'name': 'Nombre',
				'description': 'Descripción',
				'histories.operation_date': 'Fecha de Vigencia',
				'histories.percentage': 'Porcentage',
				'active': 'Activo',
				'id': 'Acción'
			};
			this.table_options.sortable = [
				'name', 'description', 'histories.operation_date', 'histories.percentage'
			];
			this.table_options.filterable = [
				'name', 'description', 'histories.operation_date', 'histories.percentage'
			];
		},
		mounted() {
			this.switchHandler('affect_tax', 'affect_tax');
			this.switchHandler('active', 'active');
		}
	};
</script>