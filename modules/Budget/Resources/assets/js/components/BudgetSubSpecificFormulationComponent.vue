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
						<th class="text-uppercase" v-for="month in months">{{ month }}</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="account in records" :class="(account.specific==='00')?'disable-row':''" 
						:id="account.id" data-formulated="false">
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
							<input type="text" class="form-control input-sm input-to-calc" 
								   :class="'input_'+account.id" value="0.00" 
								   :readonly="(account.specific==='00')" v-show="(account.specific==='00')" 
							       :data-group="account.group" :data-item="account.item" 
							       :data-generic="account.generic" :data-specific="account.specific" 
							       :data-subspecific="account.subspecific" data-type='real' 
							       data-toggle="tooltip">
						</td>
						<td class="td-with-border">
							<input type="text" class="form-control input-sm input-to-calc" 
								   :class="'input_'+account.id" value="0.00" 
								   :readonly="(account.specific==='00')" v-show="(account.specific==='00')" 
								   :data-group="account.group" :data-item="account.item" 
								   :data-generic="account.generic" :data-specific="account.specific" 
								   :data-subspecific="account.subspecific" data-type="estimated" 
								   data-toggle="tooltip">
						</td>
						<td class="td-with-border">
							<input type="text" class="form-control input-sm input-to-calc" 
								   :class="'input_'+account.id" value="0.00" 
								   :readonly="(account.specific==='00')" v-show="(account.specific==='00')" 
								   :data-group="account.group" :data-item="account.item" 
								   :data-generic="account.generic" :data-specific="account.specific" 
								   :data-subspecific="account.subspecific" data-type="total" 
								   data-toggle="tooltip">
						</td>
						<td class="td-with-border" v-for="month in months">
							<input type="text" class="form-control input-sm input-to-calc" 
								   :class="'input_'+account.id" value="0.00" 
								   :readonly="(account.specific==='00')" v-show="(account.specific==='00')" 
								   :data-group="account.group" :data-item="account.item" 
								   :data-generic="account.generic" :data-specific="account.specific" 
								   :data-subspecific="account.subspecific" data-type="month" :data-month="month"
								   data-toggle="tooltip">
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
				months: ['ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic']
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
			 * @param  {string} input   Nombre de la clase
			 * @param  {string} type    Tipo de campo
			 */
			calculateAmounts(input, type) {
				if (type === "total") {
					/*var month_values = parseFloat($("." + input).data('total').val()) / 12;
					$.each($("." + input), function() {
						if ($(this).data('type') === "month") {
							$(this).val(month_values);
						}
					});*/
				}

			},
			/**
			 * Muestra u oculta los campos de texto para ingresar información sobre los montos 
			 * a formular para una cuenta presupuestaria
			 *
			 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
			 * @param  {integer} account_id Identificador de la cuenta presupuestaria
			 */
			showAccountInputs: function(account_id) {
				let vm = this;
				let add_account = $("#add_account_" + account_id);
				let input_row = $(".input_" + account_id);
				
				if (add_account.hasClass('fa-eye')) {
					if (!this.record.currency_id) {
						bootbox.alert("Debe seleccionar primero un tipo de moneda");
						return false;
					}
					add_account.removeClass('fa-eye');
					add_account.addClass('fa-eye-slash');
					add_account.removeClass('text-blue');
					add_account.addClass('text-red');
					$("tr#"+account_id).attr('data-formulated', 'true');
					input_row.show();
				}
				else if (add_account.hasClass('fa-eye-slash')) {
					add_account.addClass('fa-eye');
					add_account.removeClass('fa-eye-slash');
					add_account.addClass('text-blue');
					add_account.removeClass('text-red');
					$("tr#"+account_id).attr('data-formulated', 'false');
					input_row.hide();
				}

				input_row.on('change', function() {
					let group = $(this).data('group'), item = $(this).data('item'), 
						generic = $(this).data('generic'), specific = $(this).data('specific'), 
						subspecific = $(this).data('subspecific');

					if ($(this).data('type') === "total") {
						let total = $(this).val();
						let porcion = parseFloat(total / 12).toFixed(vm.decimals);

						$.each(input_row.filter("[data-type='month']"), function() {
							$(this).val(porcion);
							$(this).attr('title', 'formulado: ' + $(this).val());
						});
					}
					else if ($(this).data('type') === "month") {
						let total_by_months = 0;
						$.each(input_row.filter("[data-type='month']"), function() {
							total_by_months += parseFloat($(this).val());
						});
						input_row.filter("[data-type='total']").val(parseFloat(total_by_months).toFixed(vm.decimals));
					}

					/** Calculo en cuentas de nivel superior */
					let el_generic = $("[data-specific='00']").filter("[data-generic='" + generic + "']");
					let el_item = $("[data-generic='00']").filter("[data-item='" + item + "']");
					let el_group = $("[data-item='00']").filter("[data-group='" + group + "']");
					
					$.each([el_generic, el_item, el_group], function() {
						var element = $(this);
						element.closest('tr').attr("data-formulated", "true");
						$.each(element, function() {
							var el_to_calc = $(this);
							var el_total = parseFloat($(this).filter("[data-type='total']").val());
							var months = [
								'ene', 'feb', 'mar', 'abr', 'may', 'jun',
								'jul', 'ago', 'sep', 'oct', 'nov', 'dic'
							];

							$(this).filter("[data-type='total']").val(
								parseFloat(
									el_total + parseFloat(input_row.filter("[data-type='total']").val())
								).toFixed(vm.decimals)
							);
							

							$.each(months, function() {
								var month_element = el_to_calc.filter("[data-month='" + this + "']");
								month_element.val(
									parseFloat(
										parseFloat(month_element.val()) + 
										parseFloat(input_row.filter("[data-month='" + this + "']").val())
									).toFixed(vm.decimals)
								);
								month_element.attr('title', 'formulado: ' + month_element.val());
							});
						});
					});

					/** Asigna los valores decimales al elemento actual */
					$(this).val(parseFloat($(this).val()).toFixed(vm.decimals));
				});
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
				vm.record.formulated_accounts = [];

				/** 
				 * Crea el listado de cuentas formuladas antes de proceder a registrar la formulación 
				 * del presupuesto
				 */
				$.each($("[data-formulated='true']"), function() {
					vm.record.formulated_accounts.push({
						budget_account_id: $(this).attr("id"),
						total_real_amount: $(this).find("[data-type='real']").val(),
						total_estimated_amount: $(this).find("[data-type='estimated']").val(),
						total_year_amount: $(this).find("[data-type='total']").val(),
						jan_amount: $(this).find("[data-month='ene']").val(),
						feb_amount: $(this).find("[data-month='feb']").val(),
						mar_amount: $(this).find("[data-month='mar']").val(),
						apr_amount: $(this).find("[data-month='abr']").val(),
						may_amount: $(this).find("[data-month='may']").val(),
						jun_amount: $(this).find("[data-month='jun']").val(),
						jul_amount: $(this).find("[data-month='jul']").val(),
						aug_amount: $(this).find("[data-month='ago']").val(),
						sep_amount: $(this).find("[data-month='sep']").val(),
						oct_amount: $(this).find("[data-month='oct']").val(),
						nov_amount: $(this).find("[data-month='nov']").val(),
						dec_amount: $(this).find("[data-month='dic']").val(),
					});
				});
				//this.createRecord('budget/subspecific-formulations');
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
            }
		},
		mounted() {
			this.getInstitutions();
			this.getCurrencies();
			this.getProjects();
			this.getCentralizedActions();
			this.initRecords('/budget/accounts/egress-list', '');

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