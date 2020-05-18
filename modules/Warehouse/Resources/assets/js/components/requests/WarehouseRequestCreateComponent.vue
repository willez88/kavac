<template>
	<section id="WarehouseRequestForm">
		<div class="card-body">
			<div class="alert alert-danger" v-if="errors.length > 0">
				<div class="container">
					<div class="alert-icon">
						<i class="now-ui-icons objects_support-17"></i>
					</div>
					<strong>Cuidado!</strong> Debe verificar los siguientes errores antes de continuar:
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"
							@click.prevent="errors = []">
						<span aria-hidden="true">
							<i class="now-ui-icons ui-1_simple-remove"></i>
						</span>
					</button>
					<ul>
						<li v-for="error in errors">{{ error }}</li>
					</ul>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<b>Datos de la Solicitud</b>
				</div>

				<div class="col-md-4" id="helpWarehouseRequestDate">
					<div class="form-group is-required">
						<label>Fecha de la Solicitud</label>
						<input type="text" data-toggle="tooltip"
							   title="Fecha de la solicitud"
							   class="form-control input-sm"
							   readonly="readonly"
							   v-model="record.created_at">
						<input type="hidden" v-model="record.id">
                    </div>
				</div>

				<div class="col-md-4" id="helpWarehouseRequestDepartment">
					<div class=" form-group is-required">
						<label>Dependencia Solicitante</label>
						<select2 :options="departments"
							v-model="record.department_id"></select2>
					</div>
				</div>
				<div class="col-md-4" id="helpWarehouseRequestMotive">
					<div class="form-group is-required">
						<label>Motivo de la Solicitud</label>
                        <ckeditor :editor="ckeditor.editor" data-toggle="tooltip"
                                  title="Indique el motivo de la solicitud (requerido)"
                                  :config="ckeditor.editorConfig" class="form-control" tag-name="textarea" rows="3"
                                  v-model="record.motive"></ckeditor>
					   </textarea>
                    </div>
				</div>
				<div class="col-md-6" id="helpWarehouseRequestProject">
					<div class=" form-group is-required">
						<label class="mb-4">
                            <div class="bootstrap-switch-mini">
    							<input type="radio" name="project_centralized_action" value="project" id="sel_project"
    							   class="form-control bootstrap-switch bootstrap-switch-mini sel_pry_acc"
    							   data-on-label="SI" data-off-label="NO">
    							Proyecto
                            </div>
                        </label>
						<select2 :options="budget_projects" id="budget_project_id" @input="getBudgetSpecificActions('Project')" disabled
							v-model="record.budget_project_id"></select2>

					</div>
				</div>
				<div class="col-md-6" id="helpWarehouseRequestCentralizedAction">
					<div class=" form-group is-required">
						<label class="mb-4">
                            <div class="bootstrap-switch-mini">
    							<input type="radio" name="project_centralized_action" value="project"
    								   class="form-control bootstrap-switch bootstrap-switch-mini sel_pry_acc"
    								   id="sel_centralized_action" data-on-label="SI" data-off-label="NO">
    							Acción Centralizada
                            </div>
                        </label>
						<select2 :options="budget_centralized_actions" id="budget_centralized_action_id" @input="getBudgetSpecificActions('CentralizedAction')" disabled
							v-model="record.budget_centralized_action_id"></select2>
					</div>
				</div>
				<div class="col-md-12" id="helpWarehouseRequestSpecificAction">
					<div class=" form-group is-required">
						<label>Acción Específica</label>
						<select2 :options="budget_specific_actions" id="budget_specific_action_id"
							v-model="record.budget_specific_action_id" disabled></select2>
					</div>
				</div>

			</div>

			<hr>
			<v-client-table id="helpTable"
				@row-click="toggleActive" :columns="columns" :data="records" :options="table_options">
				<div slot="h__check" class="text-center">
					<label class="form-checkbox">
						<input type="checkbox" v-model="selectAll" @click="select()" class="cursor-pointer">
					</label>
				</div>

				<div slot="check" slot-scope="props" class="text-center">
					<label class="form-checkbox">
						<input type="checkbox" class="cursor-pointer" :value="props.row.id" :id="'checkbox_'+props.row.id" v-model="selected">
					</label>
				</div>
				<div slot="description" slot-scope="props">
					<span>
						<b> {{ (props.row.warehouse_product)?
							props.row.warehouse_product.name+': ':''
						}} </b>
						{{ (props.row.warehouse_product)?
								props.row.warehouse_product.description:''
						}}<br>
					</span>
					<span>
						<div v-for="att in props.row.warehouse_product_values">
							<b>{{att.warehouse_product_attribute.name +":"}}</b> {{ att.value}}<br>
						</div>
							<b>Valor:</b> {{props.row.unit_value}} {{(props.row.currency)?props.row.currency.name:''}}
					</span>
				</div>
				<div slot="inventory" slot-scope="props">
					<span>
						<b>Almacén:</b> {{
							props.row.warehouse_institution_warehouse.warehouse.name
							}} <br>
						<b>Existencia:</b> {{ props.row.exist }}<br>
						<b>Reservados:</b> {{ (props.row.reserved === null)? '0':props.row.reserved }}
					</span>
				</div>
				<div slot="requested" slot-scope="props" >
					<div>
						<input type="number" class="form-control table-form input-sm" data-toggle="tooltip" min=0 :max="props.row.exist" :id="'request_product_'+props.row.id" onfocus="this.select()" @input="selectElement(props.row.id)">
					</div>
				</div>
			</v-client-table>
		</div>
		<div class="card-footer text-right">
			<div class="row">
				<div class="col-md-3 offset-md-9" id="helpParamButtons">
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

		        	<button type="button"  @click="createRequest('warehouse/requests')"
		        			class="btn btn-success btn-icon btn-round btn-modal-save"
		        			title="Guardar registro">
		        		<i class="fa fa-save"></i>
		            </button>
		        </div>
		    </div>
        </div>
	</section>
</template>

<script>
	export default {
		data() {
			return {
				record: {
					id: '',
					motive: '',
					institution_id: '1',
					department_id: '',
					budget_project_id: '',
					budget_centralized_action_id: '',
					budget_specific_action_id: '',
					created_at: '',
					warehouse_products: [],
				},

				editIndex: null,
				records: [],
				columns: ['check', 'code', 'description', 'inventory', 'requested'],
				errors: [],
				selected: [],
				selectAll: false,

				departments: [],
				budget_projects: [],
				budget_centralized_actions: [],
				budget_specific_actions: [],

				table_options: {
					rowClassCallback(row) {
						var checkbox = document.getElementById('checkbox_' + row.id);
						return ((checkbox)&&(checkbox.checked))? 'selected-row cursor-pointer' : 'cursor-pointer';
					},
					headings: {
						'code': 'Código',
						'description': 'Descripción',
						'inventory': 'Inventario',
						'requested': 'Solicitados',
					},
					sortable: ['code', 'description', 'inventory', 'requested'],
					filterable: ['code', 'description', 'inventory', 'requested']
				}
			}
		},
		created() {
			this.getBudgetProjects();
			this.getBudgetCentralizedActions();
			this.initForm('/warehouse/requests/vue-list-products');
			if(this.requestid){
				this.loadRequest(this.requestid);
			}

		},
		props: {
			requestid: Number,
		},
		methods: {
			toggleActive({ row }) {
				const vm = this;
				var checkbox = document.getElementById('checkbox_' + row.id);

				if((checkbox)&&(checkbox.checked == false)){
					var index = vm.selected.indexOf(row.id);
					if (index >= 0){
						vm.selected.splice(index,1);
					}
					else
						checkbox.click();
				}
				else if ((checkbox)&&(checkbox.checked == true)) {
					var index = vm.selected.indexOf(row.id);
					if (index >= 0)
						checkbox.click();
					else
						vm.selected.push(row.id);
				}
		    },
			reset() {
				this.record = {
					id: '',
					motive: '',
					institution_id: '1',
					department_id: '',
					budget_project_id: '',
					budget_centralized_action_id: '',
					budget_specific_action_id: '',
					created_at: '',
					warehouse_products: [],
				}

			},
			select() {
				const vm = this;
				vm.selected = [];
				$.each(vm.records, function(index,campo){
					var checkbox = document.getElementById('checkbox_' + campo.id);

					if(!vm.selectAll)
						vm.selected.push(campo.id);
					else if(checkbox && checkbox.checked){
						checkbox.click();
					}
				});
			},
			selectElement(id) {
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
			initForm(url) {
				const vm = this;
				if (vm.requestid) {
					axios.get('/warehouse/requests/info/'+vm.requestid).then(function (response) {
						if (typeof(response.data.records) !== "undefined") {
							var field = response.data.records;
							vm.record.institution_id = field.department.institution_id;
							vm.getDepartments();
							vm.record.motive = field.motive;
							vm.record.department_id = field.department_id;
						}
					});
				}
				/**
				 *	Ajustar si esta activa unica institucion seleccionar la institucion x defecto
				 */
				vm.record.institution_id = '1';
				vm.getDepartments();
				vm.record.created_at = vm.format_date(new Date);
				axios.get(url).then(function (response) {
					if (typeof(response.data.records) !== "undefined")
						vm.records = response.data.records;
				});
			},
			loadRequest(id) {
				const vm = this;
	            var fields = {};

	            axios.get('/warehouse/requests/info/' + id).then(response => {
	                if(typeof(response.data.records != "undefined")){
	                	fields = response.data.records;
	                	vm.record = {
							id: fields.id,
							motive: fields.motive,
							institution_id: '1',
							department_id: fields.department_id,
							budget_project_id: '',
							budget_centralized_action_id: '',
							budget_specific_action_id: fields.budget_specific_action_id,
							created_at: vm.format_date(fields.created_at),
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
				vm.record.warehouse_products = [];
				var complete = true;
                if(!vm.selected.length > 0){
                	bootbox.alert("Debe agregar almenos un elemento a la solicitud");
					return false;
				};
                $.each(vm.selected,function(index,campo){
                    var value = document.getElementById("request_product_"+campo).value;
                    if (value == "") {
						bootbox.alert("Debe ingresar la cantidad solicitada para cada producto seleccionado");
						complete = false;
						return;
					}
                    vm.record.warehouse_products.push(
                        {id:campo, requested:value});

                });
                if (complete == true)
                	vm.createRecord(url)
			}
		},
		watch: {

			/**
			 * Función que permite monitorear modificaciones en el campo budget_specific_actions
			 *
			 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
			 */
			budget_specific_actions: function() {
				$("#budget_specific_action_id").attr('disabled', (this.budget_specific_actions.length <= 1));
			},

		},
		mounted() {

			/**
			 * Evento para determinar los datos a requerir según el tipo de formulación
			 * (por proyecto o acción centralizada)
			 */
			$('.sel_pry_acc').on('switchChange.bootstrapSwitch', function(e) {
				$('#budget_project_id').attr('disabled', (e.target.id!=="sel_project"));
				$('#budget_centralized_action_id').attr('disabled', (e.target.id!=="sel_centralized_action"));

				if (e.target.id === "sel_project") {
					$("#budget_centralized_action_id").closest('.form-group').removeClass('is-required');
					$("#budget_project_id").closest('.form-group').addClass('is-required');
				}
				else if (e.target.id === "sel_centralized_action") {
					$("#budget_centralized_action_id").closest('.form-group').addClass('is-required');
					$("#budget_project_id").closest('.form-group').removeClass('is-required');
				}
			});
		}
	};
</script>
