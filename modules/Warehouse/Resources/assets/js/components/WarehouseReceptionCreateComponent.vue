<template>
	<div class="card">
		<div class="card-header">
			<h6 class="card-title text-uppercase">Nuevo Ingreso al Almacén</h6>
			<div class="card-btns">
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
						v-model="reception.warehouse_id"></select2>
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
						<label>Cantidad:</label>
						<input type="number" min="1" placeholder="Cantidad del Producto" data-toggle="tooltip" 								   
							   class="form-control input-sm"
							   v-model="record.quantity">
                    </div>
				</div>
				<div class="col-md-3">
					<div class="form-group is-required">
						<label>Minimo:</label>
						<input type="number" min="0" placeholder="Minimo permitido del Producto en almacén" data-toggle="tooltip" 							class="form-control input-sm"
							   	v-model="record.min">
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
				<div class="col-md-3">
					<div class="form-group is-required">
						<label>Unidad:</label>
						<select2 :options="units" v-model="record.unit_id"></select2>
                    </div>
				</div>
			</div>

			<div class="row" v-if="attributes.length > 0">
				<div class="col-md-12">
					<b>Detalles del Producto</b>
				</div>
				<div class="col-md-3" v-for="(attribute, index) in attributes">
					<div class="form-group">
						<label>{{attribute.name.charAt(0).toUpperCase() + attribute.name.slice(1) }}:</label>
						<input type="text" placeholder="Descripción del Producto" data-toggle="tooltip" 								   
						   class="form-control input-sm" :id="index">
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
						<th>Minimo</th>
						<th>Unidad</th>
						<th>Detallles</th>
						<th>Acciones</th>
					</tr>
				</thead>


				<tbody>
					<tr v-for="(product, index) in records">

						<td>{{ product.product_id }}</td>
						<td>{{ product.quantity }}</td>
						<td>{{ product.min }}</td>
						<td>{{ product.unit_id }}</td>
						<td>
							<div v-for="(att, i) in product.attributes">

							{{ att.name +" : "+ att.value}} </div>
						</td>

						<td class="text-center d-inline-flex">

							<button @click="editProduct(index,$event)" 
	                				class="btn btn-warning btn-xs btn-icon btn-round" 
	                				title="Modificar registro" data-toggle="tooltip" type="button">
	                			<i class="fa fa-edit"></i>
	                		</button>
		                	
	                		<button @click="removeProduct(index,$event)" 
									class="btn btn-danger btn-xs btn-icon btn-round" 
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
					min: '',
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
		methods: {
			reset() {
				this.record = {
					id: '',
					product_id: '',
					quantity: '',
					min: '',
					unit_id: '',
					unit_value:'',
				},
				this.editIndex = null;
				this.attributes.map(function (campo, key) {
					document.getElementById(campo.id - 1).value = '';
				});

			},
			getSetting(){
				this.errors = [];
				var url ="/warehouse/multi-institution"
				axios.get(url).then(response => {
					if (typeof(response.data.record) !== "undefined") {
						this.setting = response.data.record;
					}
				});
			},
			checkMultiInst(){
				if(this.setting == null)
					return false;
				else
					return this.setting.multi_institution;
			},
			
			getWarehouses(id){

				var institution_id = (typeof(id) !== 'undefined')? '/institution/'+id: '/institution';

				axios.get('/warehouse' + institution_id).then(response => {
					this.warehouses = response.data;
				});
			},

			getProducts(url){				
				axios.get(url).then(response => {
					this.products = response.data;
				});
			},
			getUnits(url){				
				axios.get(url).then(response => {
					this.units = response.data;
				});
			},
			getAttributes() {

				var id = this.record.product_id;
				var url = "/warehouse/attributes";
					if (id != '') {
						axios.get(url +'/product/'+ id).then(response => {
							if (typeof response.data.records !== "undefined") {
								this.attributes = response.data.records;
							}
						});
					}
			},		

			addProduct(event){
				var att = [];
				event.preventDefault();
				this.attributes.map(function(campo,key){
						var key = document.getElementById(campo.id-1);
						var field = { name: campo.name, value: key.value };
						att.push(field);
				});

				var record = {
					id: this.record.id,
					product_id: this.record.product_id,
					quantity: this.record.quantity,
					min: this.record.min,
					unit_id: this.record.unit_id,
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
				this.initUpdate(index+1,event);
				this.editIndex = index;
				var fields = this.record.attributes;
				console.log(fields);
			    this.attributes.map(function (campo, key) {
			        var id = campo.id - 1;
			        document.getElementById(id).value = fields[id].value;
			    });
			},
			removeProduct(index,event){
				this.records.splice(index, 1);
			},

			createReception(url){							
				this.reception.product = this.records;				

				axios.post('/' + url, this.reception).then(response => {
					console.log(response.data.records);
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
			},

		},
		created() {

			this.getSetting();
			this.getInstitutions();
			this.getWarehouses();
			this.getUnits('/warehouse/units-list');
			


		},
	};
</script>
