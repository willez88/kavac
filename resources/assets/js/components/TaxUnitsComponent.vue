<template>
	<div class="col-md-2 text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary" 
		   href="" title="Registros de Unidades Tributarias" data-toggle="tooltip" 
		   @click="addRecord('add_tax_unit', 'taxes', $event)">
			<i class="icofont icofont-chart-line-alt ico-3x"></i>
			<span>Unidades Tributarias</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_tax_unit">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-chart-line-alt inline-block"></i> 
							Unidades Tributarias
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
									<label>Valor:</label>
									<input type="number" placeholder="0.00" 
										   class="form-control input-sm" v-model="record.value">
									<input type="hidden" v-model="record.id">
			                    </div>
							</div>
							<div class="col-md-6">
								<div class="form-group is-required">
									<label>Fecha Inicio:</label>
									<input type="date" placeholder="dd/mm/yyyy" 
										   class="form-control input-sm" v-model="record.start_date">
			                    </div>
							</div>
							<div class="col-md-6">
								<div class="form-group is-required">
									<label>Fecha fin:</label>
									<input type="date" placeholder="dd/mm/yyyy" 
										   class="form-control input-sm" 
										   v-model="record.end_date">
			                    </div>
							</div>
							<div class="col-md-6">
								<div class="form-group is-required">
									<label>Activo:</label>
									<input type="checkbox" class="form-control bootstrap-switch" 
										   data-on-label="SI" data-off-label="NO" 
										   v-model="record.active">
			                    </div>
							</div>
						</div>
	                </div>
	                <div class="modal-body modal-table">
	                    <table class="table table-hover table-striped dt-responsive nowrap datatable">
							<thead>
								<tr class="text-center">
									<th>Vigencia</th>
									<th>Valor</th>
									<th>Activo</th>
									<th>Acción</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="(rec, index) in records">
									<td>
										{{ rec.start_date }} - 
										{{ (rec.end_date)?rec.end_date:'Actual' }}
									</td>
									<td>{{ rec.value }}</td>
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
						</table>
	                </div>
	                <div class="modal-footer">
	                	<button type="button" class="btn btn-default btn-sm btn-round" 
	                			data-dismiss="modal">
	                		Cerrar
	                	</button>
	                	<button type="button" @click="createRecord('tax-units')" 
	                			class="btn btn-primary btn-sm btn-round">
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
					value: '',
					start_date: '',
					end_date: '',
					active: true
				},
				errors: [],
				records: [],
			}
		},
		mounted() {

		},
	}
</script>