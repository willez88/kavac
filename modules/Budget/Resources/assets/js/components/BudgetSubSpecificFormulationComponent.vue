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
						<select2 :options="institutions" v-model="record.institution_id"></select2>
						<input type="hidden" v-model="record.id">
					</div>
				</div>
				<div class="col-2">
					<div class="form-group">
						<label for="" class="control-label">Moneda</label>
					</div>
				</div>
				<div class="col-4">
					<div class="form-group is-required">
						<select2 :options="currencies" v-model="record.currency_id"></select2>
					</div>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-6">
					<label for="">
						<input type="radio" name="project_centralized_action" value="project" id="sel_project" 
							   class="form-control bootstrap-switch bootstrap-switch-mini sel_pry_acc" 
							   data-on-label="SI" data-off-label="NO">
						Proyecto
					</label>
					<select2 :options="projects" v-model="record.project_id" id="project_id" 
							 @input="getSpecificActions('Project')" disabled></select2>
				</div>
				<div class="col-6">
					<label for="">
						<input type="radio" name="project_centralized_action" value="project" 
							   class="form-control bootstrap-switch bootstrap-switch-mini sel_pry_acc" 
							   id="sel_centralized_action" data-on-label="SI" data-off-label="NO">
						Acción Centralizada
					</label>
					<select2 :options="centralized_actions" v-model="record.centralized_action_id" 
							 @input="getSpecificActions('CentralizedAction')" 
							 id="centralized_action_id" disabled></select2>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="form-group is-required">
						<label for="" class="control-label">Acción Específica</label>
						<select2 :options="specific_actions" v-model="record.specific_action_id" 
								 id="specific_action_id" disabled></select2>
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
						<th class="text-uppercase" v-for="month in months">
							<span v-if="month === 'jan'">Ene</span>
							<span v-else-if="month === 'apr'">Abr</span>
							<span v-else-if="month === 'aug'">Ago</span>
							<span v-else-if="month === 'dec'">Dic</span>
							<span v-else>{{ month }}</span>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="(account, index) in records" :class="(account.specific==='00')?'disable-row':''" 
						:id="account.id" data-formulated="false">
						<td>
							<i class="fa fa-ban text-white" v-if="account.locked" 
							   title="Elemento bloqueado, de solo lectura" data-toggle="tooltip"></i>
							<i class="fa fa-eye text-blue cursor-pointer" v-else 
							   title="Pulse para agregar esta cuenta presupuestaria a la formulación" 
							   data-toggle="tooltip" @click="showAccountInputs(index)" 
							   :id="'add_account_'+account.id"></i>
						</td>
						<td class="td-code">
							{{ account.code }}
						</td>
						<td>{{ account.denomination }}</td>
						<td class="td-with-border">
							<input type="text" class="form-control input-sm" v-model="account.total_real_amount" 
								   v-show="account.locked || account.formulated" data-toggle="tolltip" 
								   :readonly="account.locked"  @change="calculateAmounts(index, 'real')" 
								   onfocus="this.select()">
						</td>
						<td class="td-with-border">
							<input type="text" class="form-control input-sm" data-toggle="tolltip" 
								   v-model="account.total_estimated_amount" 
								   v-show="account.locked || account.formulated" :readonly="account.locked" 
								   @change="calculateAmounts(index, 'estimated')" onfocus="this.select()">
						</td>
						<td class="td-with-border">
							<input type="text" class="form-control input-sm" v-model="account.total_year_amount" 
								   v-show="account.locked || account.formulated" data-toggle="tolltip" 
								   :readonly="account.locked" @change="calculateAmounts(index, 'year')" 
								   onfocus="this.select()">
						</td>
						<td class="td-with-border">
							<input type="text" class="form-control input-sm" v-model="account.jan_amount" 
								   v-show="account.locked || account.formulated" data-toggle="tolltip" 
								   :readonly="account.locked" @change="calculateAmounts(index, 'month')" 
								   onfocus="this.select()">
						</td>
						<td class="td-with-border">
							<input type="text" class="form-control input-sm" v-model="account.feb_amount" 
								   v-show="account.locked || account.formulated" data-toggle="tolltip" 
								   :readonly="account.locked" @change="calculateAmounts(index, 'month')" 
								   onfocus="this.select()">
						</td>
						<td class="td-with-border">
							<input type="text" class="form-control input-sm" v-model="account.mar_amount" 
								   v-show="account.locked || account.formulated" data-toggle="tolltip" 
								   :readonly="account.locked" @change="calculateAmounts(index, 'month')" 
								   onfocus="this.select()">
						</td>
						<td class="td-with-border">
							<input type="text" class="form-control input-sm" v-model="account.apr_amount" 
								   v-show="account.locked || account.formulated" data-toggle="tolltip" 
								   :readonly="account.locked" @change="calculateAmounts(index, 'month')" 
								   onfocus="this.select()">
						</td>
						<td class="td-with-border">
							<input type="text" class="form-control input-sm" v-model="account.may_amount" 
								   v-show="account.locked || account.formulated" data-toggle="tolltip" 
								   :readonly="account.locked" @change="calculateAmounts(index, 'month')" 
								   onfocus="this.select()">
						</td>
						<td class="td-with-border">
							<input type="text" class="form-control input-sm" v-model="account.jun_amount" 
								   v-show="account.locked || account.formulated" data-toggle="tolltip" 
								   :readonly="account.locked" @change="calculateAmounts(index, 'month')" 
								   onfocus="this.select()">
						</td>
						<td class="td-with-border">
							<input type="text" class="form-control input-sm" v-model="account.jul_amount" 
								   v-show="account.locked || account.formulated" data-toggle="tolltip" 
								   :readonly="account.locked" @change="calculateAmounts(index, 'month')" 
								   onfocus="this.select()">
						</td>
						<td class="td-with-border">
							<input type="text" class="form-control input-sm" v-model="account.aug_amount" 
								   v-show="account.locked || account.formulated" data-toggle="tolltip" 
								   :readonly="account.locked" @change="calculateAmounts(index, 'month')" 
								   onfocus="this.select()">
						</td>
						<td class="td-with-border">
							<input type="text" class="form-control input-sm" v-model="account.sep_amount" 
								   v-show="account.locked || account.formulated" data-toggle="tolltip" 
								   :readonly="account.locked" @change="calculateAmounts(index, 'month')" 
								   onfocus="this.select()">
						</td>
						<td class="td-with-border">
							<input type="text" class="form-control input-sm" v-model="account.oct_amount" 
								   v-show="account.locked || account.formulated" data-toggle="tolltip" 
								   :readonly="account.locked" @change="calculateAmounts(index, 'month')" 
								   onfocus="this.select()">
						</td>
						<td class="td-with-border">
							<input type="text" class="form-control input-sm" v-model="account.nov_amount" 
								   v-show="account.locked || account.formulated" data-toggle="tolltip" 
								   :readonly="account.locked" @change="calculateAmounts(index, 'month')" 
								   onfocus="this.select()">
						</td>
						<td class="td-with-border">
							<input type="text" class="form-control input-sm" v-model="account.dec_amount" 
								   v-show="account.locked || account.formulated" data-toggle="tolltip" 
								   :readonly="account.locked" @change="calculateAmounts(index, 'month')" 
								   onfocus="this.select()">
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
					title="Guardar registro" @click="createFormulation">
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
					id: '',
					year: '',
					institution_id: '',
					currency_id: '',
					project_id: '',
					centralized_action_id: '',
					specific_action_id: '',
					formulated_accounts: []
				},
				errors: [],
				records: [],
				institutions: [],
				currencies: [],
				decimals: 2,
				projects: [],
				centralized_actions: [],
				specific_actions: [],
				months: ['jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec']
			}
		},
		methods: {
			/**
			 * Reinicia los valores de los elementos del formulario
			 *
			 * @author  In- Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
			 */
			reset: function() {
				this.record.year = '';
				this.record.institution_id = '';
				this.record.currency_id = '';
				this.record.project_id = '';
				this.record.centralized_action_id = '';
				this.record.specific_action_id = '';
				this.record.formulated_accounts = [];
				this.errors = [];
			},
			/**
			 * Calcula los montos de las cuentas presupuestarias formuladas
			 *
			 * @author Ing. Roldan Vargas (rvargas at cenditel.gob.ve / roldandvg@gmail.com)
			 * @param  {integer} index Indice del elemento
			 * @param  {string}  input Nombre del campo que activó el evento
			 */
			calculateAmounts(index, input) {
				let vm = this;
				
				if (input === 'year') {
					/** Asigna los montos mensuales equitativamente */
					let partial_ammount = parseFloat(
						parseFloat(vm.records[index].total_year_amount) / 12
					).toFixed(vm.decimals);
					$.each(vm.months, function() {
						vm.records[index][this + '_amount'] = partial_ammount;
					});
				}
				else if (input === 'month') {
					/** Asigna el monto total para la cuenta a formular */
					let total_year = 0;
					$.each(vm.months, function() {
						total_year += parseFloat(vm.records[index][this + '_amount']);
					});
					vm.records[index].total_year_amount = parseFloat(total_year).toFixed(2);
				}

				/** Filtra las cuentas bloqueadas para solo lectura (cuentas de nivel superior) */
				const lock_acc = vm.records.filter((account) => {
					return account.locked;
				});
				/** Filtra las cuentas agregadas para la formulación del presupuesto */
				const form_acc = vm.records.filter((account) => {
					return !account.locked && account.formulated;
				});
				/** Filtra las cuentas de grupo */
				const group_acc = vm.records.filter((acc) => {
					return (
						acc.item === "00" && acc.generic === "00" && acc.specific === "00" 
						&& acc.subspecific === "00"
					);
				});
				/** Filtra las cuentas de ítems */
				const item_acc = vm.records.filter((acc) => {
					return (
						acc.item !== "00" && acc.generic === "00" && acc.specific === "00" 
						&& acc.subspecific === "00"
					);
				});
				/** Filtra las cuentas genéricas */
				const generic_acc = vm.records.filter((acc) => {
					return (acc.generic !== "00" && acc.specific === "00" && acc.subspecific === "00");
				});
				
				/** Calcula los montos de la cuenta genérica */
				$.each(generic_acc, function() {
					let g = this, total_year = 0, total_estimated = 0, total_real = 0;
					let total_jan = 0, total_feb = 0, total_mar = 0, total_apr = 0, total_may = 0, 
						total_jun = 0, total_jul = 0, total_aug = 0, total_sep = 0, total_oct = 0,
						total_nov = 0, total_dec = 0;
					$.each(form_acc, function() {
						if (this.group === g.group && this.item === g.item && this.generic === g.generic) {
							total_year += parseFloat(this.total_year_amount);
							total_estimated += parseFloat(this.total_estimated_amount);
							total_real += parseFloat(this.total_real_amount);
							total_jan += parseFloat(this.jan_amount);
							total_feb += parseFloat(this.feb_amount);
							total_mar += parseFloat(this.mar_amount);
							total_apr += parseFloat(this.apr_amount);
							total_may += parseFloat(this.may_amount);
							total_jun += parseFloat(this.jun_amount);
							total_jul += parseFloat(this.jul_amount);
							total_aug += parseFloat(this.aug_amount);
							total_sep += parseFloat(this.sep_amount);
							total_oct += parseFloat(this.oct_amount);
							total_nov += parseFloat(this.nov_amount);
							total_dec += parseFloat(this.dec_amount);
						}
					});
					if (parseFloat(total_year) > 0) {
						g.total_year_amount = parseFloat(total_year).toFixed(vm.decimals);
						g.total_estimated_amount = parseFloat(total_estimated).toFixed(vm.decimals);
						g.total_real_amount = parseFloat(total_real).toFixed(vm.decimals);
						g.jan_amount = parseFloat(total_jan).toFixed(vm.decimals);
						g.feb_amount = parseFloat(total_feb).toFixed(vm.decimals);
						g.mar_amount = parseFloat(total_mar).toFixed(vm.decimals);
						g.apr_amount = parseFloat(total_apr).toFixed(vm.decimals);
						g.may_amount = parseFloat(total_may).toFixed(vm.decimals);
						g.jun_amount = parseFloat(total_jun).toFixed(vm.decimals);
						g.jul_amount = parseFloat(total_jul).toFixed(vm.decimals);
						g.aug_amount = parseFloat(total_aug).toFixed(vm.decimals);
						g.sep_amount = parseFloat(total_sep).toFixed(vm.decimals);
						g.oct_amount = parseFloat(total_oct).toFixed(vm.decimals);
						g.nov_amount = parseFloat(total_nov).toFixed(vm.decimals);
						g.dec_amount = parseFloat(total_dec).toFixed(vm.decimals);
					}
				});

				/** Calcula los montos de la cuenta ítems */
				$.each(item_acc, function() {
					let i = this, total_year = 0, total_estimated = 0, total_real = 0;
					let total_jan = 0, total_feb = 0, total_mar = 0, total_apr = 0, total_may = 0, 
						total_jun = 0, total_jul = 0, total_aug = 0, total_sep = 0, total_oct = 0,
						total_nov = 0, total_dec = 0;
					$.each(generic_acc, function() {
						if (this.group === i.group && this.item === i.item) {
							total_year += parseFloat(this.total_year_amount);
							total_estimated += parseFloat(this.total_estimated_amount);
							total_real += parseFloat(this.total_real_amount);
							total_jan += parseFloat(this.jan_amount);
							total_feb += parseFloat(this.feb_amount);
							total_mar += parseFloat(this.mar_amount);
							total_apr += parseFloat(this.apr_amount);
							total_may += parseFloat(this.may_amount);
							total_jun += parseFloat(this.jun_amount);
							total_jul += parseFloat(this.jul_amount);
							total_aug += parseFloat(this.aug_amount);
							total_sep += parseFloat(this.sep_amount);
							total_oct += parseFloat(this.oct_amount);
							total_nov += parseFloat(this.nov_amount);
							total_dec += parseFloat(this.dec_amount);
						}
					});
					if (parseFloat(total_year) > 0) {
						i.total_year_amount = parseFloat(total_year).toFixed(vm.decimals);
						i.total_estimated_amount = parseFloat(total_estimated).toFixed(vm.decimals);
						i.total_real_amount = parseFloat(total_real).toFixed(vm.decimals);
						i.jan_amount = parseFloat(total_jan).toFixed(vm.decimals);
						i.feb_amount = parseFloat(total_feb).toFixed(vm.decimals);
						i.mar_amount = parseFloat(total_mar).toFixed(vm.decimals);
						i.apr_amount = parseFloat(total_apr).toFixed(vm.decimals);
						i.may_amount = parseFloat(total_may).toFixed(vm.decimals);
						i.jun_amount = parseFloat(total_jun).toFixed(vm.decimals);
						i.jul_amount = parseFloat(total_jul).toFixed(vm.decimals);
						i.aug_amount = parseFloat(total_aug).toFixed(vm.decimals);
						i.sep_amount = parseFloat(total_sep).toFixed(vm.decimals);
						i.oct_amount = parseFloat(total_oct).toFixed(vm.decimals);
						i.nov_amount = parseFloat(total_nov).toFixed(vm.decimals);
						i.dec_amount = parseFloat(total_dec).toFixed(vm.decimals);
					}
				});

				/** Calcula los montos de la cuenta de grupo */
				$.each(group_acc, function() {
					let gr = this, total_year = 0, total_estimated = 0, total_real = 0;
					let total_jan = 0, total_feb = 0, total_mar = 0, total_apr = 0, total_may = 0, 
						total_jun = 0, total_jul = 0, total_aug = 0, total_sep = 0, total_oct = 0,
						total_nov = 0, total_dec = 0;
					$.each(item_acc, function() {
						if (this.group === gr.group) {
							total_year += parseFloat(this.total_year_amount);
							total_estimated += parseFloat(this.total_estimated_amount);
							total_real += parseFloat(this.total_real_amount);
							total_jan += parseFloat(this.jan_amount);
							total_feb += parseFloat(this.feb_amount);
							total_mar += parseFloat(this.mar_amount);
							total_apr += parseFloat(this.apr_amount);
							total_may += parseFloat(this.may_amount);
							total_jun += parseFloat(this.jun_amount);
							total_jul += parseFloat(this.jul_amount);
							total_aug += parseFloat(this.aug_amount);
							total_sep += parseFloat(this.sep_amount);
							total_oct += parseFloat(this.oct_amount);
							total_nov += parseFloat(this.nov_amount);
							total_dec += parseFloat(this.dec_amount);
						}
					});
					if (parseFloat(total_year) > 0) {
						gr.total_year_amount = parseFloat(total_year).toFixed(vm.decimals);
						gr.total_estimated_amount = parseFloat(total_estimated).toFixed(vm.decimals);
						gr.total_real_amount = parseFloat(total_real).toFixed(vm.decimals);
						gr.jan_amount = parseFloat(total_jan).toFixed(vm.decimals);
						gr.feb_amount = parseFloat(total_feb).toFixed(vm.decimals);
						gr.mar_amount = parseFloat(total_mar).toFixed(vm.decimals);
						gr.apr_amount = parseFloat(total_apr).toFixed(vm.decimals);
						gr.may_amount = parseFloat(total_may).toFixed(vm.decimals);
						gr.jun_amount = parseFloat(total_jun).toFixed(vm.decimals);
						gr.jul_amount = parseFloat(total_jul).toFixed(vm.decimals);
						gr.aug_amount = parseFloat(total_aug).toFixed(vm.decimals);
						gr.sep_amount = parseFloat(total_sep).toFixed(vm.decimals);
						gr.oct_amount = parseFloat(total_oct).toFixed(vm.decimals);
						gr.nov_amount = parseFloat(total_nov).toFixed(vm.decimals);
						gr.dec_amount = parseFloat(total_dec).toFixed(vm.decimals);
					}
				});
			},
			/**
			 * Muestra u oculta los campos de texto para ingresar información sobre los montos 
			 * a formular para una cuenta presupuestaria
			 *
			 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
			 * @param  {integer} index Indice del registro a mostrar u ocultar
			 */
			showAccountInputs: function(index) {
				if (!this.record.currency_id) {
					bootbox.alert("Debe seleccionar primero un tipo de moneda");
					return false;
				}

				this.records[index].formulated = !(this.records[index].formulated);
				let add_account = $("#add_account_" + this.records[index].id);
				
				if (add_account.hasClass('fa-eye')) {
					add_account.removeClass('fa-eye');
					add_account.addClass('fa-eye-slash');
					add_account.removeClass('text-blue');
					add_account.addClass('text-red');
				}
				else if (add_account.hasClass('fa-eye-slash')) {
					add_account.addClass('fa-eye');
					add_account.removeClass('fa-eye-slash');
					add_account.addClass('text-blue');
					add_account.removeClass('text-red');
				}
			},
			/**
			 * Obtiene un arreglo con los proyectos
			 *
			 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
			 * @param  {integer} id Identificador del proyecto a buscar, este parámetro es opcional
			 */
			getProjects(id) {
				var project_id = (typeof(id)!=="undefined")?'/'+id:'';
				axios.get('/budget/get-projects' + project_id).then(response => {
					this.projects = response.data;
				});
			},
			/**
			 * Obtiene un arreglo con las acciones centralizadas
			 *
			 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
			 * @param  {integer} id Identificador de la acción centralizada a buscar, este parámetro es opcional
			 */
			getCentralizedActions(id) {
				var centralized_action_id = (typeof(id)!=="undefined")?'/'+id:'';
				axios.get('/budget/get-centralized-actions' + centralized_action_id).then(response => {
					this.centralized_actions = response.data;
				});
			},
			/**
			 * Obtiene las Acciones Específicas
			 * 
			 * @author Ing. Roldan Vargas (rvargas at cenditel.gob.ve / roldandvg@gmail.com)
			 * @param {string} type Tipo de registro
			 */
			getSpecificActions(type) {
				let id = (type==='Project')?this.record.project_id:this.record.centralized_action_id;

				this.specific_actions = [];

				if (id) {
					axios.get('/budget/get-specific-actions/' + type + "/" + id).then(response => {
						this.specific_actions = response.data;
					});
				}

				var len = this.specific_actions.length;
				$("#specific_action_id").attr('disabled', (len == 0));
			},
			/**
			 * Crea o actualiza la formulación de presupuesto
			 *
			 * @author Ing. Roldan Vargas (rvargas at cenditel.gob.ve / roldandvg@gmail.com)
			 */
			createFormulation() {
				let vm = this;
				/** Filtra las cuentas bloqueadas para solo lectura (cuentas de nivel superior) */
				const lock_acc = vm.records.filter((account) => {
					return account.locked;
				});
				$.each(lock_acc, function() {
					this.formulated = (parseFloat(this.total_year_amount) > 0);
				});
				vm.record.formulated_accounts = vm.records.filter((account) => {
					return account.formulated;
				});

				if (this.record.id) {
					this.updateFormulation();
				}
				else {
					var fields = {};
					for (var index in this.record) {
						fields[index] = this.record[index];
					}
					axios.post('/budget/subspecific-formulations', fields).then(response => {
						this.showMessage('store');
					}).catch(error => {
						this.errors = [];
						if (typeof(error.response) !="undefined") {
							for (var index in error.response.data.errors) {
								if (error.response.data.errors[index]) {
									this.errors.push(error.response.data.errors[index][0]);
								}
							}
						}
					});
				}
			},
			updateFormulation() {
				var fields = {};
				for (var index in this.record) {
					fields[index] = this.record[index];
				}
				axios.patch('/budget/subspecific-formulations/' + this.record.id, fields).then(response => {
					this.showMessage('update');
				}).catch(error => {
					this.errors = [];
					if (typeof(error.response) !="undefined") {
						for (var index in error.response.data.errors) {
							if (error.response.data.errors[index]) {
								this.errors.push(error.response.data.errors[index][0]);
							}
						}
					}
				});
			}
		},
		watch: {
			/**
			 * Función que permite monitorear modificaciones en el campo specific_actions
			 *
			 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
			 */
			specific_actions: function() {
				$("#specific_action_id").attr('disabled', (this.specific_actions.length <= 1));
			},
			record: {
                deep: true,
                handler: function(newValue, oldValue) {
                	this.decimals = 2;
                	if (newValue.currency_id) {
                		axios.get('/currencies/info/' + newValue.currency_id).then(response => {
                			if (response.data.result) {
                				this.decimals = response.data.currency.decimal_places;
                			}
						});
                	}
                }
            },
		},
		mounted() {
			this.getInstitutions();
			this.getCurrencies();
			this.getProjects();
			this.getCentralizedActions();
			this.initRecords('/budget/accounts/egress-list/true', '');

			/** 
			 * Evento para determinar los datos a requerir según el tipo de formulación 
			 * (por proyecto o acción centralizada)
			 */
			$('.sel_pry_acc').on('switchChange.bootstrapSwitch', function(e) {
				$('#project_id').attr('disabled', (e.target.id!=="sel_project"));
				$('#centralized_action_id').attr('disabled', (e.target.id!=="sel_centralized_action"));
				
				if (e.target.id === "sel_project") {
					$("#centralized_action_id").closest('.form-group').removeClass('is-required');
					$("#project_id").closest('.form-group').addClass('is-required');
				}
				else if (e.target.id === "sel_centralized_action") {
					$("#centralized_action_id").closest('.form-group').addClass('is-required');
					$("#project_id").closest('.form-group').removeClass('is-required');
				}
			});

		},
	};
</script>