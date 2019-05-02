<template>
	<div class="card">
		<div class="card-header">
			<h6 class="card-title text-uppercase">Inventario de Productos Almacén</h6>
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
				<div class="col-md-4">
					<div class="form-group">
						<label>Productos Registrados:</label>
						<select2 :options="products"
						v-model="record.product_id"></select2>
						<input type="hidden" v-model="record.id">
	                </div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Almacén:</label>
						<select2 :options="warehouses"
						v-model="record.warehouse_id"></select2>
	                </div>
				</div>

				<div class="col-md-4">
					<button type="button" @click="loadInventaryProduct('/warehouse/report/vue-list')"
					class='btn btn-sm btn-info float-right'>
						<i class="fa fa-search"></i>
						<span>	Buscar	</span>
					</button>
				</div>
			</div>
			<div class="row">
				<div class="col-12" align="left">
					<button type="button" @click="createReport('/warehouse/pdf')"
					class='btn btn-sm btn-primary btn-custom'>
						<i class="fa fa-plus-circle"></i>
						<span>	Generar Reporte	</span>
					</button>
				</div>
			</div>

			<hr>
			<table class="table table-hover table-striped dt-responsive datatable table-warehouse">
					<thead>
						<tr class="text-center">			
							<th>Nombre</th>
							<th>Descripción</th>
							<th>Almacén</th>
							<th>Inventario</th>
							<th>Detalles</th>
						</tr>
					</thead>


					<tbody>
						<tr v-for="(field,index) in records">

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
						</tr>
					</tbody>
				</table>

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
					warehouse_id: '',
				},
				warehouses: [],
				products: [],
				records: [],
				errors: [],
				
			}
		},
		methods: {
			reset() {
				this.record = {
					id: '',
					product_id: '',
					warehouse_id: '',
				}
			},
			getProducts(url){
				const vm = this;
				if(typeof(url) != 'undefined'){
					axios.get(url).then(response => {
						vm.products = response.data;
					});
				}
			},
			createReport(url){
				const vm = this;
				if(typeof(url) != 'undefined'){
					if(vm.record.product_id == '' && vm.record.warehouse_id == '')
						url = url +'/products/1';
					else if(vm.record.product_id != '' && vm.record.warehouse_id == '')
						url = url +'/products/1/'+ vm.record.product_id;
					else if(vm.record.product_id == '' && vm.record.warehouse_id != '')
						url = url +'/products/2/'+ vm.record.warehouse_id;
					else
						url = url +'/'+ vm.record.product_id +'/'+ vm.record.warehouse_id;
					window.open(url);
					//window.open(url, "Inventario de Productos de Almacén","width=700,height=800,top=200,left=200");
				}
			},
			loadInventaryProduct(url){
				const vm = this;
				if(vm.record.product_id == '' && vm.record.warehouse_id == '')
					url = url +'/products/1';
				else if(vm.record.product_id != '' && vm.record.warehouse_id == '')
					url = url +'/products/1/'+ vm.record.product_id;
				else if(vm.record.product_id == '' && vm.record.warehouse_id != '')
					url = url +'/products/2/'+ vm.record.warehouse_id;
				else
					url = url +'/'+ vm.record.product_id +'/'+ vm.record.warehouse_id;
				axios.get(url).then(function (response) {
					if(typeof(response.data.records) !== "undefined")
						vm.records = response.data.records;
				});
	        },
	        getWarehouses(url){
				const vm = this;
				axios.get(url).then(response => {
					if(typeof(response.data) != "undefined")
						vm.warehouses = response.data;
				});
			},
		},
		created() {

			this.getProducts('/warehouse/products-list');
			this.getWarehouses('/warehouse/vue-list');
			this.loadInventaryProduct('/warehouse/report/vue-list');

		},
	};
</script>
