<template>
	<div class="col-md-2 text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary" 
		   href="#" title="Reglas de Abastecimiento del Almacén" data-toggle="tooltip" 
		   @click="addRecord('add_rule', 'rules', $event)">
			<i class="icofont icofont-papper ico-3x"></i>
			<span>Reglas de Almacén</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_rule">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-papper ico-2x"></i> 
							Reglas de Abastecimiento del Almacén
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
								<div class="form-group">
									<label>Institución que gestiona el Almacén:</label>
									<select2 :options="institutions" 
											 v-model="record.institution_id"
											 @input="getWarehouses(record.institution_id)">
									</select2>
			                    </div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Almacén:</label>
									<select2 :options="warehouses" 
											 v-model="record.warehouse_id"
											 @input="getWarehouseProducts()">
									</select2>
			                    </div>
							</div>
						</div>

	                </div>

	                <div class="modal-body modal-table">
	                	<hr>
	                	<table class="table table-hover table-striped dt-responsive table-movement">
							<thead>
								<tr class="text-center">
									<th>Nombre</th>
									<th>Descripción</th>
									<th>Inventario</th>
									<th>Detalles</th>
									<th>Reglas</th>
									<th>Acciones</th>
								</tr>
							</thead>


							<tbody>
								<tr v-for="(field,index) in this.products">
									<td> {{ field.product.name }} </td>
									<td> {{ field.product.description }} </td>
									<td>
										<b>Almacén:</b> {{ field.warehouse_institution.warehouse.name }}<br>
										<b>Existencia:</b> {{ field.exist }}<br>
										<b>Reservados:</b> {{ (field.reserved === null)? '0':field.reserved }}
									</td>
									<td>
										<div v-if="field.product.attribute" v-for="att in field.product.attributes">
											<b>{{ att.name+':'}}</b> {{ att.value.value}}
										</div>
										<b>Valor:</b> {{ field.unit_value }}<br>
									</td>
									<td class="td-with-border" width="10%">
										<div v-if="editIndex == index">
											<input type="number" class="form-control input-sm" data-toggle="tooltip" :id="'rule_product_'+field.id" onfocus="this.select()">
										</div>
										<div v-else>
											<b>Minimo:</b> {{ (field.rule == null)? 'N/A':field.rule.min }}
										</div>
									</td>
									<td class="text-center d-inline-flex">
										<div v-if="editIndex != index">
											<button @click="editRule(index, $event)" 
					                				class="btn btn-warning btn-xs btn-icon btn-action" 
					                				title="Modificar registro" data-toggle="tooltip" type="button">
					                			<i class="fa fa-edit"></i>
					                		</button>
					                	</div>
				                		<div v-else>
				                			<button @click="saveRule(index,$event)" 
					                				class="btn btn-success btn-xs btn-icon btn-action" 
					                				title="Guardar Regla" data-toggle="tooltip" type="save">
					                			<i class="fa fa-save"></i>
					                		</button>
					                		<button @click="cancelEdit(index, $event)" 
					                				class="btn btn-danger btn-xs btn-icon btn-action" 
					                				title="Modificar registro" data-toggle="tooltip" type="button">
					                			<i class="fa fa-ban"></i>
					                		</button>
				                		</div>
									</td>
								</tr>
							</tbody>
						</table>


	                </div>

	                <div class="modal-footer">
	                	<button type="button" 
	                			class="btn btn-warning btn-icon btn-round btn-modal-close" 
	                			data-dismiss="modal"
	                			title="Cancelar y regresar">
	                			<i class="fa fa-ban"></i>
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
					id:'',
					institution_id: '',
					warewhouse_id: '',
				},

				editIndex: null,
				warehouses: [],
				institutions: [],
				products: [],
				errors: [],
				records: [],
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
					institution_id: '',
					warehouse_id: '',
				};
			},
			getWarehouses(id){
				const vm = this;
				var url = '/warehouse/institution/';
				vm.warehouses = [];
				if (id != ''){
					axios.get(url + id).then(response => {
						if(typeof(response.data) != "undefined")
							vm.warehouses = response.data;
					});
				}
			},
			getWarehouseProducts(){
				const vm = this;
				var warehouse = vm.record.warehouse_id;
				var institution = vm.record.institution_id;

				vm.products = [];
				if(( warehouse != '') && (institution != '')){
					var url = "/warehouse/rules/vue-list-products/";
					axios.get(url + warehouse + '/' + institution).then(response => {
						if(typeof(response.data.records) != "undefined"){
							vm.products = response.data.records;
						}
					});
				}else{
				var url = '/warehouse/rules/vue-list-products';
					axios.get(url).then(function (response) {
						if(typeof(response.data.records) !== "undefined")
							vm.products = response.data.records;
					});
				}
			},
			editRule(index, event){
				const vm = this;
				vm.editIndex = index;
				event.preventDefault();
			},
			cancelEdit(index, event){
				const vm = this;
				vm.editIndex = null;
				event.preventDefault();
			},
			saveRule(index, event){
				const vm = this;
				var fields = vm.products[index];
				var element = document.getElementById('rule_product_'+fields.id);
				if(element){
					var field = {
						id: fields.id,
						min: element.value
					};
					if(fields.rule == null){
	                    axios.post('/warehouse/rules', field).then(function (response) {
	                        if (response.data.result) {
	                            vm.showMessage('store');
	                            vm.editIndex = null;
	                            vm.getWarehouseProducts();
	                        }
	                    }).catch(function (error) {
	                        _this.errors = [];

	                        if (typeof error.response != "undefined") {
	                            for (var index in error.response.data.errors) {
	                                if (error.response.data.errors[index]) {
	                                    _this.errors.push(error.response.data.errors[index][0]);
	                                }
	                            }
	                        }
	                    });
	                }
	                else{
	                    this.updateRule(index);
	                }
				}
			},
			updateRule(index){
				const vm = this;
				var fields = vm.products[index];
				var element = document.getElementById('rule_product_'+fields.id);
				if(element){
					var field = {
						id: fields.id,
						min: element.value
					};
					var rule = fields.rule;
					axios.patch('/warehouse/rules/'+rule.id, field).then(function (response) {
	                        if (response.data.result) {
	                            vm.showMessage('update');
	                            vm.editIndex = null;
	                            vm.getWarehouseProducts();
	                        }
	                    }).catch(function (error) {
	                        _this.errors = [];

	                        if (typeof error.response != "undefined") {
	                            for (var index in error.response.data.errors) {
	                                if (error.response.data.errors[index]) {
	                                    _this.errors.push(error.response.data.errors[index][0]);
	                                }
	                            }
	                        }
	                    });
				}

			}
			
		},
		created() {
			this.getInstitutions();			
		},
		mounted() {
			this.getWarehouseProducts();
		},
	}
</script>
