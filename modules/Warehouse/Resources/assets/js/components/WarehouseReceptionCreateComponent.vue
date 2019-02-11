<template>
	<div class="card">
		<div class="card-header">
			<h6 class="card-title text-uppercase">Recepción de Almacén</h6>
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
			</div>

			<div class="row">
				<div class="col-md-4">
					<div class="form-group is-required">
						<label>Nombre del Almacén:</label>
						<select2 :options="warehouses" @input="getProducts('/warehouse/products-list')"></select2>
						<input type="hidden" v-model="record.id">
                    </div>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-md-12">
					<b>Ingrese los Productos a la solicitud</b>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<div class="form-group is-required">
						<label>Nombre del Producto:</label>
						<select2 :options="products" @input="getAttributes" v-model="product.id"></select2>
                    </div>
				</div>
				<div class="col-md-3">
					<div class="form-group is-required">
						<label>Cantidad:</label>
						<input type="number" placeholder="Cantidad del Producto" data-toggle="tooltip" 								   
							   class="form-control input-sm"
							   v-model="product.description">
                    </div>
				</div>
				<div class="col-md-3">
					<div class="form-group is-required">
						<label>Minimo:</label>
						el <input type="number" placeholder="Minimo permitido del Producto en almacén" data-toggle="tooltip" 								   
							   class="form-control input-sm"
							   v-model="product.min">
                    </div>
				</div>
				<div class="col-md-3">
					<div class="form-group is-required">
						<label>Unidad:</label>
						<select2 :options="units" v-model="product.unit_id"></select2>
                    </div>
				</div>
			</div>
			<div class="row" v-if="attributes.length > 0">
				<div class="col-md-12">
					<b>Detalles del Producto</b>
				</div>
				<div class="col-md-4" v-for="(attribute, index) in attributes">
					<div class="form-group">
						<label>{{attribute.name.charAt(0).toUpperCase() + attribute.name.slice(1) }}:</label>
						<input type="text" placeholder="Descripción del Producto" data-toggle="tooltip" 								   
						   class="form-control input-sm" :id="index">
	                </div>
				</div>
			</div>

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

        	<button type="button"  @click="createProduct('/warehouse/products')"
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
					name: '',
					description: '',
				},
				product: {
					id: '',
					name: '',
					description: '',
					min: '',
					unit_id: '',
				},
				keep: {
					id:'',
					key:'',
					value:''
				},
				keeps: [],
				records: [],
				errors: [],
				warehouses: [],
				products: [],
				attributes: [],
				units: [],
			}
		},
		methods: {
			reset() {
				this.record = {
					id: '',
					name: '',
					description:'',					
				}

			},			
			getWarehouses(url){				
				axios.get(url).then(response => {
					this.warehouses = response.data;
				});
			},
			getAttributes() {
				this.keeps = [];
				var tam = 0;
				var id = this.product.id;
				var url = "/warehouse/attributes";
				if (id !== '')
					axios.get(url +'/product/'+ id).then(response => {
						if (typeof response.data.records !== "undefined") {
							this.attributes = response.data.records;
							tam = this.attributes.length;
							this.pushKeeps(tam);
						}
					});
			},
			pushKeeps(tam){
				if (tam > 0){
					for(var i=0; i < tam;i++){
						var field = {
										id:i+1,
										key:this.attributes[i].name,
										value:$('#' + this.attributes[i].name).value 
									};
						if(this.keeps.indexof(field) === -1)
							this.keeps.push(field);
					}
				}
				console.log(this.keeps);
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
			addProducts(url){
				console.log(this.product, this.keeps);
			},

			createProduct(url) {
				const vm = this;
				var fields = {};
				for (var index in this.product) {
					fields[index] = this.product[index];
				}
				axios.post('/' + url, fields).then(response => {
					vm.showMessage('store');
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
		},
		created() {
			this.getWarehouses('/warehouse/vue-list');
			this.getUnits('/warehouse/units-list');


		},
	};
</script>
