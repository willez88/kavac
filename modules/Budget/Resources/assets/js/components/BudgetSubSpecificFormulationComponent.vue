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
					<div class="form-group is-required">
						<select name="" id="" class="select2">
							<option value="">Seleccione...</option>
						</select>
					</div>
				</div>
				<div class="col-2">
					<div class="form-group">
						<label for="" class="control-label">Moneda</label>
					</div>
				</div>
				<div class="col-4">
					<div class="form-group is-required">
						<select name="" id="" class="select2">
							<option value="">Seleccione...</option>
						</select>
					</div>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-6">
					<label for="">
						<input type="radio" name="project_centralized_action" value="project" 
							   class="form-control bootstrap-switch bootstrap-switch-mini" 
							   data-on-label="SI" data-off-label="NO">
						Proyecto
					</label>
					<select name="" id="" class="select2">
						<option value=""></option>
					</select>
				</div>
				<div class="col-6">
					<label for="">
						<input type="radio" name="project_centralized_action" value="project" 
							   class="form-control bootstrap-switch bootstrap-switch-mini" 
							   data-on-label="SI" data-off-label="NO">
						Acción Centralizada
					</label>
					<select name="" id="" class="select2">
						<option value=""></option>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="form-group is-required">
						<label for="" class="control-label">Acción Específica</label>
						<select name="" id="" class="select2">
							<option value=""></option>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-4 offset-md-8">
					<button type="button" class="btn btn-sm btn-success btn-import text-uppercase float-right" 
							title="Presione para importar la información a partir de un archivo .csv" 
							data-toggle="tooltip">
						<i class="fa fa-file-excel-o"></i>
						Importar CSV
					</button>
				</div>
			</div>
			<!-- Tabla para la formulación del presupuesto -->
			<table class="table table-formulation">
				<thead>
					<tr>
						<th></th>
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
						<td>
							<i class="fa fa-ban text-white" v-if="(account.specific==='00')" 
							   title="Elemento bloqueado, de solo lectura" data-toggle="tooltip"></i>
							<i class="fa fa-eye text-blue cursor-pointer" v-else 
							   title="Pulse para agregar esta cuenta presupuestaria a la formulación" 
							   data-toggle="tooltip" @click="showAccountInputs(account.id)" 
							   :id="'add_account_'+account.id"></i>
						</td>
						<td class="td-code">
							{{ account.code }}
						</td>
						<td>{{ account.denomination }}</td>
						<td class="td-with-border">
							<input type="text" class="form-control input-sm" :class="'input_'+account.id" 
							       value="0.00" :readonly="(account.specific==='00')" 
							       v-show="(account.specific==='00')">
						</td>
						<td class="td-with-border">
							<input type="text" class="form-control input-sm" :class="'input_'+account.id" 
							       value="0.00" :readonly="(account.specific==='00')" 
							       v-show="(account.specific==='00')">
						</td>
						<td class="td-with-border">
							<input type="text" class="form-control input-sm" :class="'input_'+account.id" 
							       value="0.00":readonly="(account.specific==='00')" 
							       v-show="(account.specific==='00')">
						</td>
						<td class="td-with-border">
							<input type="text" class="form-control input-sm" :class="'input_'+account.id" 
							       value="0.00":readonly="(account.specific==='00')" 
							       v-show="(account.specific==='00')">
						</td>
						<td class="td-with-border">
							<input type="text" class="form-control input-sm" :class="'input_'+account.id" 
							       value="0.00":readonly="(account.specific==='00')" 
							       v-show="(account.specific==='00')">
						</td>
						<td class="td-with-border">
							<input type="text" class="form-control input-sm" :class="'input_'+account.id" 
							       value="0.00":readonly="(account.specific==='00')" 
							       v-show="(account.specific==='00')">
						</td>
						<td class="td-with-border">
							<input type="text" class="form-control input-sm" :class="'input_'+account.id" 
							       value="0.00":readonly="(account.specific==='00')" 
							       v-show="(account.specific==='00')">
						</td>
						<td class="td-with-border">
							<input type="text" class="form-control input-sm" :class="'input_'+account.id" 
							       value="0.00":readonly="(account.specific==='00')" 
							       v-show="(account.specific==='00')">
						</td>
						<td class="td-with-border">
							<input type="text" class="form-control input-sm" :class="'input_'+account.id" 
							       value="0.00":readonly="(account.specific==='00')" 
							       v-show="(account.specific==='00')">
						</td>
						<td class="td-with-border">
							<input type="text" class="form-control input-sm" :class="'input_'+account.id" 
							       value="0.00":readonly="(account.specific==='00')" 
							       v-show="(account.specific==='00')">
						</td>
						<td class="td-with-border">
							<input type="text" class="form-control input-sm" :class="'input_'+account.id" 
							       value="0.00":readonly="(account.specific==='00')" 
							       v-show="(account.specific==='00')">
						</td>
						<td class="td-with-border">
							<input type="text" class="form-control input-sm" :class="'input_'+account.id" 
							       value="0.00":readonly="(account.specific==='00')" 
							       v-show="(account.specific==='00')">
						</td>
						<td class="td-with-border">
							<input type="text" class="form-control input-sm" :class="'input_'+account.id" 
							       value="0.00":readonly="(account.specific==='00')" 
							       v-show="(account.specific==='00')">
						</td>
						<td class="td-with-border">
							<input type="text" class="form-control input-sm" :class="'input_'+account.id" 
							       value="0.00":readonly="(account.specific==='00')" 
							       v-show="(account.specific==='00')">
						</td>
						<td class="td-with-border">
							<input type="text" class="form-control input-sm" :class="'input_'+account.id" 
							       value="0.00":readonly="(account.specific==='00')" 
							       v-show="(account.specific==='00')">
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
	.table-formulation {
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
	.table-formulation tbody tr td.td-with-border {
		border-right: 1px solid #d1d1d1;
		border-left: 1px solid #d1d1d1;
	}
	.btn-import {
		font-size: .639rem;
		font-weight: bold;
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
			showAccountInputs: function(account_id) {
				let add_account = $("#add_account_" + account_id);
				let input_row = $(".input_" + account_id);
				
				if (add_account.hasClass('fa-eye')) {
					add_account.removeClass('fa-eye');
					add_account.addClass('fa-eye-slash');
					add_account.removeClass('text-blue');
					add_account.addClass('text-red')
					input_row.show();
				}
				else if (add_account.hasClass('fa-eye-slash')) {
					add_account.addClass('fa-eye');
					add_account.removeClass('fa-eye-slash');
					add_account.addClass('text-blue')
					add_account.removeClass('text-red');
					input_row.hide();
				}
			}
		},
		mounted() {
			this.initRecords('/budget/accounts/egress-list', '');
		},
	};
</script>