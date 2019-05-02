<template>
	<div class="card">
		<div class="card-header">
			<h6 class="card-title text-uppercase">Nuevo Ingreso al Almacén</h6>
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
					<b>Seleccione el destino de los productos</b>
				</div>

				<div class="col-md-4">
					<div class="form-group is-required">
						<label>Nombre de la Institución:</label>
						<select2 :options="institutions" @input="getWarehouses(reception.institution_id)"
						v-model="reception.institution_id"></select2>
						<input type="hidden" v-model="reception.id">
                    </div>
				</div>

				<div class="col-md-4">
					<div class="form-group is-required">
						<label>Nombre del Almacén:</label>
						<select2 :options="warehouses" @input="getProducts('/warehouse/products-list')"
						v-model="reception.warehouse_id"
						id="select_product"></select2>
                    </div>
				</div>
			</div>
			<hr>
			
			<div class="row">
				<div class="col-md-12">
					<b>Ingrese los Productos a la solicitud</b>
				</div>
				<div class="col-md-3">
					<div class="form-group is-required">
						<label>Nombre del Producto:</label>
						<select2 :options="products" @input="getAttributes" v-model="record.product_id"></select2>
                    </div>
				</div>
				<div class="col-md-3">
					<div class="form-group is-required">
						<label>Unidad del Producto:</label>
						<select2 :options="units" v-model="record.unit_id"></select2>
                    </div>
				</div>
				<div class="col-md-3">
					<div class="form-group is-required">
						<label>Cantidad:</label>
						<input type="number" min="1" placeholder="Cantidad del Producto" data-toggle="tooltip" 								   
							   class="form-control input-sm"
							   v-model="record.quantity">
                    </div>
				</div>
				<div class="col-md-3">
					<div class="form-group is-required">
						<label>Valor:</label>
						<input type="number" min="0" placeholder="Valor por unidad del Producto en almacén" data-toggle="tooltip"			   
							   class="form-control input-sm"
							   v-model="record.unit_value">
                    </div>
				</div>
			</div>
			<hr>

			<div class="row" v-show="record.attributes.length > 0">
				<div class="col-md-12">
					<b>Características del Producto</b>
				</div>
				<div class="col-md-3" v-for="attribute in record.attributes">
					<div class="form-group">
						<label>{{attribute.name.charAt(0).toUpperCase() + attribute.name.slice(1) }}:</label>
						<input type="text" placeholder="Descripción del Producto" data-toggle="tooltip" 								   
						   class="form-control input-sm" :id="attribute.name" v-model="attribute.value">
	                </div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<button type="button" @click="addProduct($event)"class="btn btn-sm btn-primary btn-custom float-right" 
							title="Agregar registro a la lista"
							data-toggle="tooltip">
						<i class="fa fa-plus-circle"></i>
						Agregar
					</button>
				</div>
			</div>
			<hr>
			<table class="table table-hover table-striped dt-responsive datatable">
				<thead>
					<tr class="text-center">			

						<th>Producto</th>
						<th>Cantidad Agregada</th>
						<th>Unidad</th>
						<th>Detallles</th>
						<th>Acciones</th>
					</tr>
				</thead>


				<tbody>
					<tr v-for="(field, index) in records">

						<td>{{ 
							(field.product.name)?field.product.name:field.product_id }}</td>
						<td>{{ field.quantity }}</td>
						<td>{{
							(field.unit.name)?field.unit.name:field.unit_id }}</td>
						<td>
							<div v-for="(att, i) in field.attributes">

							<b>{{att.name +":"}}</b> {{ att.value}} </div>
							<b>Valor por Unidad:</b> {{field.unit_value}}
						</td>

						<td class="text-center d-inline-flex">

							<button @click="editProduct(index,$event)" 
	                				class="btn btn-warning btn-xs btn-icon btn-action" 
	                				title="Modificar registro" data-toggle="tooltip" type="button">
	                			<i class="fa fa-edit"></i>
	                		</button>
		                	
	                		<button @click="removeProduct(index,$event)" 
									class="btn btn-danger btn-xs btn-icon btn-action" 
									title="Eliminar registro" data-toggle="tooltip" 
									type="button">
								<i class="fa fa-trash-o"></i>
							</button>
						</td>

					</tr>
				</tbody>
			</table>

		</div>
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

        	<button type="button"  @click="createReception('warehouse/receptions')"
        			class="btn btn-success btn-icon btn-round btn-modal-save"
        			title="Guardar registro">
        		<i class="fa fa-save"></i>
            </button>
        </div>

	</div>
</template>

<script>
	export default {
		data() {
			return {
				record: {
					id: '',
					product_id: '',
					quantity: '',
					unit_id: '',
					unit_value:'',
					attributes: [],
				},
				reception: {
					id: '',
					warehouse_id:'',
					institution_id:'',
					product: [],
				},
				
				records: [],
				errors: [],
				
				setting: [],
				institutions: [],
				warehouses: [],
				products: [],
				attributes: [],
				units: [],
				editIndex: null,
			}
		},
		props: {
		receptionid: Number, 
		},
		methods: {
			reset() {
				this.record = {
					id: '',
					product_id: '',
					quantity: '',
					unit_id: '',
					unit_value:'',
					attributes: [],
				},
				this.editIndex = null;
				this.attributes.map(function (campo, key) {
					var element = document.getElementById(campo.name);
		            if(element)
		                element.value = '';
				});

			},
			getWarehouses(id){

				var institution_id = (typeof(id) !== 'undefined')? '/institution/'+id: '/institution';

				axios.get('/warehouse' + institution_id).then(response => {
					this.warehouses = response.data;
				});
			},

			getProducts(url){
				const vm = this;
				axios.get(url).then(response => {
					vm.products = response.data;
				});
			},
			getUnits(url){
				const vm = this;
				axios.get(url).then(response => {
					vm.units = response.data;
				});
			},
			getAttributes() {
				const vm = this;
				var id = this.record.product_id;
				var url = "/warehouse/attributes";
					if (id != '') {
						axios.get(url +'/product/'+ id).then(response => {
							if (typeof response.data.records !== "undefined") {
								this.attributes = response.data.records;
								if((vm.editIndex == null)&&(vm.record.id == '')){
									vm.record.attributes = [];
			                        $.each(vm.attributes, function(index, campo){
			                            vm.record.attributes.push({name:campo.name, value:""});
			                        });
			                    }
							}
						});
					}
			},		

			addProduct(event){
				const vm = this;
				var att = [];
				var product_name = '';
				var unit_name = '';
				event.preventDefault();
				this.attributes.map(function(campo,key){
					var key = document.getElementById(campo.name);
					var field = { name: campo.name, value: key.value };
					att.push(field);
				});
				if(vm.record.product_id != ''){
					$.each(vm.products,function(index,campo){
			            if(campo.id == vm.record.product_id)
			                product_name = campo.text;
			        });
				}
				if(vm.record.unit_id != ''){
			        $.each(vm.units,function(index,campo){
			            if(campo.id == vm.record.unit_id)
			                unit_name = campo.text;
			        });
			    }
		        
				var record = {
					id: this.record.id,
					product_id: this.record.product_id,
					product: {
						name: product_name,
					},
					quantity: this.record.quantity,
					unit_id: this.record.unit_id,
					unit: {
						name: unit_name,
					},
					unit_value: this.record.unit_value,
					attributes: att,
				};

				if(this.editIndex === null){					
					this.records.push(record);
					this.reset();
				}
				else if(this.editIndex >= 0 ){				
					this.records.splice(this.editIndex, 1);
					this.records.push(record);
					this.reset();
				}
			},

			editProduct(index,event){
				this.reset();
				this.editIndex = index;
				this.initUpdate(index+1,event);
				$.each(this.record.attributes, function(index,campo){
					var element = document.getElementById(campo.name);
					if(element)
						element.value = campo.value;
				});
			},
			removeProduct(index,event){
				this.records.splice(index, 1);
			},

			createReception(url){
				const vm = this;
				this.reception.product = this.records;				
				if (vm.reception.id) {
					this.updateReception(url);
				}
				else{
					axios.post('/' + url, this.reception).then(response => {
						if (response.data.result) {
	                        vm.showMessage('store');
	                        setTimeout(function() {
	                            window.location.href = '/warehouse/receptions';
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
			updateReception(url){
				const vm = this;
				axios.patch('/' + url + '/' + this.reception.id, this.reception).then(response => {
					if (response.data.result) {
                        vm.showMessage('update');
                        setTimeout(function() {
                            window.location.href = '/warehouse/receptions';
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
			loadReception(id){
				const vm = this;
	            var fields = {};
	            var field = [];
	            
	            axios.get('/warehouse/receptions/vue-info/'+id).then(response => {
	                fields = response.data.records.product_movements;
	                vm.reception.id = response.data.records.id;
	                vm.reception.institution_id = response.data.records.finish.institution_id;
	                vm.reception.warehouse_id = response.data.records.finish.warehouse_id;
	                fields.forEach(function(campo){
	                    var record = campo.inventary;
	                    field = [];
	                    campo.inventary.product.attributes.forEach(function(att){
	                        field.push({name: att.name, value: att.value.value});
	                    });
	                    record.quantity = campo.quantity;
	                    record.attributes = field;
	                    vm.records.push(record);
	                    
	                });
	            });
	        },
		},
		created() {

			this.getInstitutions();
			this.getWarehouses();
			this.getUnits('/warehouse/units-list');

			if(this.receptionid){
				this.loadReception(this.receptionid);
			}

			


		},
	};
</script>
