<template>
	<div class="card">
		<div class="card-header">
			<h6 class="card-title text-uppercase">Solicitud de Almacén</h6>
			<div class="card-btns">
				<a href="#" class="btn btn-sm btn-primary btn-custom" @click="redirect_back(route_list)" 
				   title="Ir atrás" data-toggle="tooltip">
					<i class="fa fa-reply"></i>
				</a>
				<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar" 
				   data-toggle="tooltip">
					<i class="now-ui-icons arrows-1_minimal-up"></i>
				</a>
			</div>
		</div>
		<div class="card-body">
			<div class="alert alert-danger" v-if="errors.length > 0">
				<ul>
					<li v-for="error in errors">{{ error }}</li>
				</ul>
			</div>


			<div class="row">

				<div class="col-md-12">
					<b>Datos de la Solicitud</b>
				</div>

				<div class="col-md-4">
					<div class="form-group is-required">
						<label>Fecha de la Solicitud</label>
						<input type="text" data-toggle="tooltip" 
							   title="Fecha de la solicitud" 
							   class="form-control input-sm" 
							   readonly="readonly"
							   id="init_date" v-model="record.init_date">
						<input type="hidden" v-model="record.id">
                    </div>
				</div>
			
				<div class="col-md-4">
					<div class=" form-group is-required">
						<label>Dependencia Solicitante</label>
						<select2 :options="departments"
							v-model="record.department_id"></select2>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group is-required">
						<label>Motivo de la Solicitud</label>
						<textarea  data-toggle="tooltip" 
											   title="Indique el motivo de la solicitud (requerido)" 
											   class="form-control" v-model="record.motive">
								   </textarea>
                    </div>
				</div>
				<div class="col-md-6">
					<div class=" form-group is-required">
						<label>
							<input type="radio" name="project_centralized_action" value="project" id="sel_project" 
							   class="form-control bootstrap-switch bootstrap-switch-mini sel_pry_acc" 
							   data-on-label="SI" data-off-label="NO">
							Proyecto</label>
						<select2 :options="projects" id="project_id" @input="getSpecificActions('Project')" disabled
							v-model="record.project_id"></select2>
							
					</div>
				</div>
				<div class="col-md-6">
					<div class=" form-group is-required">
						<label>
							<input type="radio" name="project_centralized_action" value="project" 
								   class="form-control bootstrap-switch bootstrap-switch-mini sel_pry_acc" 
								   id="sel_centralized_action" data-on-label="SI" data-off-label="NO">
							Acción Centralizada</label>
						<select2 :options="centralized_actions" id="centralized_action_id" @input="getSpecificActions('CentralizedAction')" disabled
							v-model="record.centralized_action_id"></select2>
					</div>
				</div>
				<div class="col-md-12">
					<div class=" form-group is-required">
						<label>Acción Específica</label>
						<select2 :options="specific_actions" id="specific_action_id"
							v-model="record.specific_action_id" disabled></select2>
					</div>
				</div>

			</div>

			<hr>
			<table class="table table-hover table-striped dt-responsive table-warehouse">
				<thead>
					<tr class="text-center">			
						<th>
							<label class="form-checkbox">
								<input type="checkbox" v-model="selectAll" @click="select()">
							</label>
						</th>
						<th>Nombre</th>
						<th>Descripción</th>
						<th>Almacén</th>
						<th>Inventario</th>
						<th>Detalles</th>
						<th>Solicitados</th>
					</tr>
				</thead>


				<tbody>
					<tr v-for="(field,index) in products"
					:class="(newSelected(field.id))?'selected-row':''">
						<td class="text-center">
							<label class="form-checkbox">
								<input type="checkbox" :value="field.id" :id="'checkbox_'+field.id" v-model="selected">
							</label>
						</td>
						<td> {{ field.product.name }} </td>
						<td> {{ field.product.description }} </td>
						<td> {{ field.warehouse_institution.warehouse.name }} </td>
						<td>
							<b>Existencia:</b> {{ field.exist }}<br>
							<b>Reservados:</b> {{ (field.reserved === null)? '0':field.reserved }}<br>
							<b>Minimo:</b> {{ (field.rule === null)? '0':field.rule.min }}<br>
						</td>
						<td>
							<div v-if="field.product.attribute" v-for="att in field.product.attributes">
								<b>{{ att.name+':'}}</b> {{ att.value.value}}
							</div>
							<b>Valor:</b> {{ field.unit_value }}<br>
						</td>
						<td class="td-with-border" width="10%">
							<div>
								<input type="number" class="form-control input-sm" data-toggle="tooltip" min=0 :max="field.exist" :id="'request_product_'+field.id" onfocus="this.select()" @input="selectElement(field.id)">
							</div>
						</td>
					</tr>
				</tbody>
			</table>

	        <div class="card-footer text-right">
            	<button type="button" @click="reset()"
						class="btn btn-default btn-icon btn-round"
						title ="Borrar datos del formulario">
						<i class="fa fa-eraser"></i>
				</button>

            	<button type="button"
            			class="btn btn-warning btn-icon btn-round btn-modal-close"
            			data-dismiss="modal"
            			title="Cancelar y regresar">
            			<i class="fa fa-ban"></i>
            	</button>

            	<button type="button"  @click="createRequest('warehouse/request')"
            			class="btn btn-success btn-icon btn-round btn-modal-save"
            			title="Guardar registro">
            		<i class="fa fa-save"></i>
                </button>
            </div>

		</div>
	</div>
</template>

<style>
	.table-warehouse {
		font-size: .58rem;
	}
	.table-warehouse .form-control {
		border-radius:.25rem !important;
		padding: .375rem .1rem;
	    font-size: .6rem;
	    text-align: right;
	}
	.table-warehouse tbody tr.selected-row {
		background-color: #d1d1d1;
	}
	.table-warehouse tbody tr td.td-with-border {
		border-right: 1px solid #d1d1d1;
		border-left: 1px solid #d1d1d1;
	}
</style>

<script>
	export default {
		data() {
			return {
				record: {
					id: '',
					motive: '',
					institution_id: '1',
					department_id: '',
					project_id: '',
					centralized_action_id: '',
					specific_action_id: '',
					init_date: '',
					products: [],
				},

				editIndex: null,
				records: [],
				errors: [],
				selected: [],
				selectAll: false,

				products: [],
				departments: [],
				projects: [],
				centralized_actions: [],
				specific_actions: [],
			}
		},
		created() {
			this.getProjects();
			this.getCentralizedActions();
			this.initForm('/warehouse/request/vue-list-products');
			if(this.requestid){
				this.loadRequest(this.requestid);
			}

		},
		props: {
			requestid: Number,
		},
		methods: {
			reset() {
				this.record = {
					id: '',
					motive: '',
					institution_id: '1',
					department_id: '',
					project_id: '',
					centralized_action_id: '',
					specific_action_id: '',
				}

			},
			select() {
				const vm = this;
				vm.selected = [];
				$.each(vm.products, function(index,campo){
					var checkbox = document.getElementById('checkbox_' + campo.id);
					var input = document.getElementById('request_product_' + campo.id);
					if(!vm.selectAll)
						vm.selected.push(campo.id);
					else if(checkbox && checkbox.checked){
						checkbox.click();
						if( input )
							input.value = "";
					}
				});
			},
			selectElement(id){
				var input = document.getElementById('request_product_' + id);
	            var checkbox = document.getElementById('checkbox_' + id);
	            if ((input.value == '')||(input.value == 0)){
	                if(checkbox.checked){
	                    checkbox.click();
	                }
	            }
	            else if(!checkbox.checked){
	                checkbox.click();
	            }
			},
			newSelected(id){
				var checkbox = document.getElementById('checkbox_' + id);
				if(checkbox)
					return checkbox.checked;
				else return false;
			},
			initForm(url){
				
				const vm = this;
				if(vm.requestid){
					axios.get('/warehouse/request/vue-info/'+vm.requestid).then(function (response) {
						if(typeof(response.data.records) !== "undefined"){
						var field = response.data.records;
						vm.record.institution_id = field.department.institution_id;
						vm.getDepartments();
						vm.record.motive = field.motive;
						vm.record.department_id = field.dependence_id;
						}
					});
				}
				/*
					ajustar si esta activa unica institucion seleccionar la institucion x defecto
				*/
				vm.record.institution_id = '1';
				vm.getDepartments();
				vm.record.init_date = vm.format_timestamp(new Date);
				axios.get(url).then(function (response) {
					if(typeof(response.data.records) !== "undefined")
						vm.products = response.data.records;
				});
			},
			loadRequest(id){
				const vm = this;
	            var fields = {};
	            
	            axios.get('/warehouse/request/vue-info/'+id).then(response => {
	                if(typeof(response.data.records != "undefined")){
	                	fields = response.data.records;
	                	vm.record = {
							id: fields.id,
							motive: fields.motive,
							institution_id: '1',
							department_id: fields.dependence_id,
							project_id: '',
							centralized_action_id: '',
							specific_action_id: fields.specific_action_id,
							init_date: vm.format_timestamp(fields.created_at),
							products: [],
						};
						$.each(fields.request_product, function(index,campo){
							var element = document.getElementById("request_product_"+campo.warehouse_inventary_product_id);
							if(element){
								element.value = campo.quantity;
								vm.selected.push(campo.warehouse_inventary_product_id);
							}
						});
	                }
	            });

			},
			createRequest(url){
				const vm = this;
                vm.record.products = [];
                if(!vm.selected.length > 0){
                	bootbox.alert("Debe agregar almenos un elemento a la solicitud");
					return false;
				};
                $.each(vm.selected,function(index,campo){
                    var value = document.getElementById("request_product_"+campo).value;
                    if (value == "") {
						bootbox.alert("Debe ingresar la cantidad solicitada para cada producto seleccionado");
						return false;
					}
                    vm.record.products.push(
                        {id:campo, requested:value});

                });
                if (vm.record.id) {
					this.updateRequest(url);
				}
				else{
					axios.post('/' + url, this.record).then(response => {
						if (response.data.result) {
	                        vm.showMessage('store');
	                        setTimeout(function() {
	                            window.location.href = '/warehouse/request';
	                        }, 2000);
	                    }
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
			updateRequest(url){
				const vm = this;
				axios.patch('/' + url + '/' + this.record.id, this.record).then(response => {
					if (response.data.result) {
	                        vm.showMessage('update');
	                        setTimeout(function() {
	                            window.location.href = '/warehouse/request';
	                        }, 2000);
	                    }
				}).catch(error => {
					vm.errors = [];

					if (typeof(error.response) !="undefined") {
						for (var index in error.response.data.errors) {
							if (error.response.data.errors[index]) {
								vm.errors.push(error.response.data.errors[index][0]);
							}
						}
					}
				});
			},

		/***
		   * Obtiene un arreglo con los proyectos
		   *
		   * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
		   * @param  {integer} id Identificador del proyecto a buscar, este parámetro es opcional
		   */

			getProjects(id){
				const vm = this;

				var project_id = typeof id !== "undefined" ? '/' + id : '';
				axios.get('/budget/get-projects' + project_id).then(function (response) {
					vm.projects = response.data;
				});
			},

		/***
		   * Obtiene un arreglo con las acciones centralizadas
		   *
		   * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
		   * @param  {integer} id Identificador de la acción centralizada a buscar, este parámetro es opcional
		   */
			
			getCentralizedActions(id) {
				const vm = this;

				var centralized_action_id = typeof id !== "undefined" ? '/' + id : '';
				axios.get('/budget/get-centralized-actions' + centralized_action_id).then(function (response) {
					vm.centralized_actions = response.data;
				});
			},

		/***
		   * Obtiene las Acciones Específicas
		   * 
		   * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
		   * @param {string} type Tipo de registro
		   */
			
			getSpecificActions(type) {
				const vm = this;

				var id = type === 'Project' ? this.record.project_id : this.record.centralized_action_id;

				vm.specific_actions = [];

				if (id) {
					axios.get('/budget/get-specific-actions/' + type + "/" + id + "/formulation").then(function (response) {
						vm.specific_actions = response.data;
					});
				}
			},

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

		},
		mounted() {
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

		}
	};
</script>
