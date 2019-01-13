<template>
	<div class="card">
		<div class="card-header">
			<h6 class="card-title text-uppercase">Formulación de presupuesto de gastos por sub específica</h6>
			<div class="card-btns">
				<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar" 
				   data-toggle="tooltip">
					<i class="now-ui-icons arrows-1_minimal-up"></i>
				</a>
			</div>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-2">
					<div class="form-group">
						<label for="" class="control-label">Institución</label>
					</div>
				</div>
				<div class="col-4">
					<div class="form-group">
						<select name="" id="" class="select2">
							<option value="">Seleccione...</option>
						</select>
					</div>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-3">
					<label for="">
						<input type="radio" name="project_centralized_action" value="project" 
							   class="form-control bootstrap-switch bootstrap-switch-mini" 
							   data-on-label="SI" data-off-label="NO">
						Proyecto
					</label>
				</div>
				<div class="col-3">
					<label for="">
						<input type="radio" name="project_centralized_action" value="project" 
							   class="form-control bootstrap-switch bootstrap-switch-mini" 
							   data-on-label="SI" data-off-label="NO">
						Acción Centralizada
					</label>
				</div>
			</div>
			<div class="row">
				<div class="col-6">
					<div class="form-group">
						<label for="" class="control-label">Acción Específica</label>
					</div>
				</div>
				<div class="col-6">
					<div class="form-group">
						<label for="" class="control-label">Denominación</label>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-6">
					<div class="form-group">
						<select name="" id="" class="select2">
							<option value=""></option>
						</select>
					</div>
				</div>
				<div class="col-6">
					<div class="form-group">
						<label for=""></label>
					</div>
				</div>
			</div>
			<!-- Tabla para la formulación del presupuesto -->
			<table class="table table-formulation">
				<thead>
					<tr>
						<th class="text-uppercase">Código</th>
						<th class="text-uppercase">Denominación</th>
						<th class="text-uppercase">Real</th>
						<th class="text-uppercase">Estimado</th>
						<th class="text-uppercase">Total año</th>
						<th class="text-uppercase">Ene</th>
						<th class="text-uppercase">Feb</th>
						<th class="text-uppercase">Mar</th>
						<th class="text-uppercase">Abr</th>
						<th class="text-uppercase">May</th>
						<th class="text-uppercase">Jun</th>
						<th class="text-uppercase">Jul</th>
						<th class="text-uppercase">Ago</th>
						<th class="text-uppercase">Sep</th>
						<th class="text-uppercase">Oct</th>
						<th class="text-uppercase">Nov</th>
						<th class="text-uppercase">Dic</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="account in records" :class="(account.specific==='00')?'disable-row':''">
						<td class="td-code">
							<button type="button" class="btn btn-default btn-sm" 
									v-if="account.specific!=='00'">
								{{ account.code }}
							</button>
							<span v-else>{{ account.code }}</span>
						</td>
						<td>{{ account.denomination }}</td>
						<td>
							<input type="text" class="form-control input-sm" value="0.00" 
								   :readonly="(account.specific==='00')">
						</td>
						<td>
							<input type="text" class="form-control input-sm" value="0.00" 
								   :readonly="(account.specific==='00')">
						</td>
						<td>
							<input type="text" class="form-control input-sm" value="0.00"
								   :readonly="(account.specific==='00')">
						</td>
						<td>
							<input type="text" class="form-control input-sm" value="0.00"
								   :readonly="(account.specific==='00')">
						</td>
						<td>
							<input type="text" class="form-control input-sm" value="0.00"
								   :readonly="(account.specific==='00')">
						</td>
						<td>
							<input type="text" class="form-control input-sm" value="0.00"
								   :readonly="(account.specific==='00')">
						</td>
						<td>
							<input type="text" class="form-control input-sm" value="0.00"
								   :readonly="(account.specific==='00')">
						</td>
						<td>
							<input type="text" class="form-control input-sm" value="0.00"
								   :readonly="(account.specific==='00')">
						</td>
						<td>
							<input type="text" class="form-control input-sm" value="0.00"
								   :readonly="(account.specific==='00')">
						</td>
						<td>
							<input type="text" class="form-control input-sm" value="0.00"
								   :readonly="(account.specific==='00')">
						</td>
						<td>
							<input type="text" class="form-control input-sm" value="0.00"
								   :readonly="(account.specific==='00')">
						</td>
						<td>
							<input type="text" class="form-control input-sm" value="0.00"
								   :readonly="(account.specific==='00')">
						</td>
						<td>
							<input type="text" class="form-control input-sm" value="0.00"
								   :readonly="(account.specific==='00')">
						</td>
						<td>
							<input type="text" class="form-control input-sm" value="0.00"
								   :readonly="(account.specific==='00')">
						</td>
						<td>
							<input type="text" class="form-control input-sm" value="0.00"
								   :readonly="(account.specific==='00')">
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="card-footer text-right">
			<button type="reset" class="btn btn-default btn-icon btn-round" data-toggle="tooltip" 
					title="Borrar datos del formulario">
				<i class="fa fa-eraser"></i>
			</button>
			<button type="button" class="btn btn-warning btn-icon btn-round" data-toggle="tooltip" 
					title="Cancelar y regresar">
				<i class="fa fa-ban"></i>
			</button>
			<button type="button" class="btn btn-success btn-icon btn-round" data-toggle="tooltip" 
					title="Guardar registro" @click="createRecord('budget/subspecific-formulations')">
				<i class="fa fa-save"></i>
			</button>
		</div>
	</div>
</template>

<style>
	.table-formulation, .td-code .btn {
		font-size: .58rem;
	}
	.table-formulation .form-control {
		border-radius:.25rem !important;
		padding: .375rem .1rem;
	    font-size: .6rem;
	    text-align: right;
	}
	.table-formulation tbody tr.disable-row {
		background-color: #d1d1d1;
	}
	.td-code .btn {
		background-color: #FFFFFF;
		color: #636E7B;
	}
	.td-code .btn, .td-code span {
		padding: 5px !important;
	}
</style>

<script>
	export default {
		data() {
			return {
				record: {
					year: '',
					specific_action_id: '',
				},
				errors: [],
				records: [],
			}
		},
		methods: {
			reset: function() {

			},
		},
		mounted() {
			this.initRecords('/budget/accounts/egress-list', '');
		},
	};
</script>