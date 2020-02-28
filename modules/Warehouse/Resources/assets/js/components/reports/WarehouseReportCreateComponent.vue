<template>
	<section id="WarehouseReportForm">
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
						<select2 :options="warehouse_products"
						v-model="record.warehouse_product_id"></select2>
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
				<div class="col-md-3 offset-md-9" id="helpParamButtons">
					<button type="button" @click="createReport()"
					class='btn btn-sm btn-primary btn-custom'>
						<i class="fa fa-plus-circle"></i>
						<span>	Generar Reporte	</span>
					</button>
				</div>
			</div>

			<hr>
			<v-client-table :columns="columns" :data="records" :options="table_options">
				<div slot="description" slot-scope="props">
					<span>
						<b> {{ (props.row.warehouse_product)?
								'Nombre: ':'' }} </b>
							{{ (props.row.warehouse_product)?
							props.row.warehouse_product.name + '.':''
						}} <br>
						{{ (props.row.warehouse_product)?
								props.row.warehouse_product.description:''
						}} <br>
					</span>
					<span>
						<div v-for="att in props.row.warehouse_product_values">
							<b>{{att.warehouse_product_attribute.name +": "}}</b> {{ att.value}} <br>
						</div>
						<b>Valor:</b> {{props.row.unit_value}} {{(props.row.currency)?props.row.currency.acronym:''}}
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
			</v-client-table>

		</div>
	</section>
</template>

<script>
	export default {
		data() {
			return {
				record: {
					id: '',
					warehouse_product_id: '',
					warehouse_id: '',
				},
				warehouses: [],
				warehouse_products: [],
				records: [],
				errors: [],
				columns: ['code', 'description', 'inventory'],
				
			}
		},
		methods: {
			reset() {
				this.record = {
					id: '',
					warehouse_product_id: '',
					warehouse_id: '',
				}
			},
			getWarehouseProducts() {
				const vm = this;
				axios.get('/warehouse/get-warehouse-products').then(response => {
					vm.warehouse_products = response.data;
				});
			},
			createReport() {
				var url = '/warehouse/pdf';
				const vm = this;
				if(typeof(url) != 'undefined'){
					if(vm.record.warehouse_product_id == '' && vm.record.warehouse_id == '')
						url = url +'/warehouse-products';
					else if(vm.record.warehouse_product_id != '' && vm.record.warehouse_id == '')
						url = url +'/product/'+ vm.record.warehouse_product_id;
					else if(vm.record.warehouse_product_id == '' && vm.record.warehouse_id != '')
						url = url +'/warehouse/'+ vm.record.warehouse_id;
					else
						url = url +'/warehouse/'+ vm.record.warehouse_product_id +'/product/'+ vm.record.warehouse_id;
					window.open(url, '_blank');
				}
			},
			loadInventaryProduct(url){
				const vm = this;
				if(vm.record.warehouse_product_id == '' && vm.record.warehouse_id == '')
					url = url +'/products/1';
				else if(vm.record.warehouse_product_id != '' && vm.record.warehouse_id == '')
					url = url +'/products/1/'+ vm.record.warehouse_product_id;
				else if(vm.record.warehouse_product_id == '' && vm.record.warehouse_id != '')
					url = url +'/products/2/'+ vm.record.warehouse_id;
				else
					url = url + '/' + vm.record.warehouse_id + '/' + vm.record.warehouse_product_id;
				axios.get(url).then(function (response) {
					if(typeof(response.data.records) !== "undefined")
						vm.records = response.data.records;
				});
	        },
		},
		created() {
			this.table_options.headings = {
				'code': 'Código',
				'description': 'Descripción',
				'inventory': 'Inventario',
			};
			this.table_options.sortable = ['code', 'description', 'inventory']
			this.table_options.filterable = ['code', 'description', 'inventory'];
		},
		mounted() {
			this.getWarehouseProducts();
			this.getWarehouses();
			this.loadInventaryProduct('/warehouse/report/vue-list');
		}
	};
</script>
