<template>
	<section>
		<div class="row">
			<div class="col-12" v-if="items">
				<v-client-table :columns="columns" :data="items" :options="table_options">
					<div slot="quantity" slot-scope="props">
						{{ props.row.quantity }} <strong>{{props.row.measurement_unit}}</strong>
					</div>
				</v-client-table>
			</div>
			<div class="col-12">
				<div class="form-horizontal">
					<div class="card-body">
						<div class="row" v-if="has_budget">
							<div class="col-3">
								<div class="form-group is-required">
									<label class="control-label" for="specific_action_id"> Acción especifica </label><br>
									<select2 :options="specific_actions" id="specific_action_id" v-model="specific_action_id"></select2>
								</div>
							</div>
							<div class="col-3">
								<div class="form-group is-required">
									<label class="control-label" for="budget_item_id"> Partida presupuestaria </label><br>
									<select2 :options="budget_items" 
											:disabled="!specific_action_id"
											id="budget_item_id" 
											v-model="budget_item_id"></select2>
								</div>
							</div>
							<div class="col-2 text-center">
								<label class="control-label">Disponibilidad presupuestaria</label><br>
								<p>
									<i class="icofont icofont-ui-check" 
										style="color:#18ce0f"
										v-show="budget_available >= supplier_price_tot"></i>
									<i class="icofont icofont-ui-close" 
										style="color:#FF3636"
										v-show="budget_available < supplier_price_tot"></i>
								</p>
							</div>
							<div class="col-2 text-right">
								<label class="control-label">Saldo diponible</label><br>
								<p> {{ addDecimals(budget_available) }} <strong>{{currency.symbol}}</strong></p>
							</div>
							<div class="col-2 text-right">
								<label class="control-label">Total del proveedor</label><br>
								<p>{{ addDecimals(supplier_price_tot) }} <strong>{{currency.symbol}}</strong></p>
							</div>

							<div class="col-12">
								<hr>
							</div>				
							<div class="col-12">
								<h6 class="card-title">Lista de documentos requeridos</h6>
							</div>
							<div class="col-12">
								<ul class="feature-list list-group list-group-flush">
									<li class="list-group-item"
										v-for="(file, idx) in files">
										<div class="feature-list-indicator bg-info">
											<label style="margin-left: 2rem;" for="acta_inicio">
												{{ idx.replace(/_/g, ' ') }}
											</label>
										</div>
										<div class="feature-list-content p-0" style="margin-left: 6rem;">
											<div class="feature-list-content-wrapper">
												<div class="feature-list-content-left mr-2">
													<label class="custom-control">

														<button type="button" data-toggle="tooltip"
																class="btn btn-sm btn-danger btn-import"
																title="Presione para subir el archivo."
																@click="setFile(idx)">
															<i class="fa fa-upload"></i>
														</button>
														<input type="file" 
																:id="idx"
																@change="uploadFile(idx, $event)"
																style="display:none;">
													</label>
												</div>
												<div class="feature-list-content-left">
													<div class="feature-list-subheading">
														<div v-if="files[idx]">
															{{ files[idx].name }}
														</div>
														<div v-show="!files[idx]">
															Cargar documento.
														</div>
													</div>
													<div class="feature-list-subheading" :id="'status_'+idx"
															style="display:none;">
														<span class="badge badge-success">
															<strong>Documento Cargado.</strong>
														</span>
													</div>
												</div>
											</div>
										</div>
									</li>
								</ul>
							</div>
							<div class="col-12">
								<hr>
							</div>
						</div>
						<div class="row" v-if="!has_budget">
							<div class="col-10">
								<label></label>
							</div>
							<div class="col-2 text-right">
								<label class="control-label">Total del proveedor</label><br>
								<p>{{ addDecimals(supplier_price_tot) }} <strong>{{currency.symbol}}</strong></p>
							</div>
						</div>
						<div class="card-footer text-right" v-if="has_budget">
							<button class="btn btn-success btn-sm"
									title="Hay disponibilidad"
									data-toggle="tooltip"
									:disabled="!budget_item_id || !(budget_available >= supplier_price_tot)" 
									@click="">
								Hay disponibilidad
							</button>
							<button class="btn btn-danger btn-sm"
									title="No hay disponibilidad"
									data-toggle="tooltip"
									:disabled="!budget_item_id || !(budget_available < supplier_price_tot)" 
									@click="">
								No hay disponibilidad
							</button>
						</div>
						<div class="card-footer text-right" v-if="!has_budget">
							<button class="btn btn-success btn-sm"
									title="Hay disponibilidad"
									data-toggle="tooltip"
									@click="">
								Hay disponibilidad
							</button>
							<button class="btn btn-danger btn-sm"
									title="No hay disponibilidad"
									data-toggle="tooltip"
									@click="">
								No hay disponibilidad
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</template>
<script>
export default{
	props:{
		records:{
			type:Object,
			default: function() {
				return null;
			}
		},
		currency:{
			type:Object,
			default: function() {
				return null;
			}
		},
		supplier:{
			type:Object,
			default: function() {
				return null;
			}
		},
		budget_items:{
			type:Array,
			default: function(){
				return [{'id':'','text':'Seleccione...'}];
			}
		},
		specific_actions:{
			type:Array,
			default: function(){
				return [{'id':'','text':'Seleccione...'}];
			}
		},
		has_budget:{
			type:Boolean,
			default: function(){
				return false;
			}
		}
	},
	data(){
		return{
			columns: [  
					'code',
					'name',
					'description',
					'quantity',
					'base_budget_price',
					'supplier_price',
			],
			files:{
				'Acta_de_disponibilidad_presupuestaria': null,
			},
			specific_action_id: '',
			budget_item_id: '',
			budget_available: 0,
			supplier_price_tot: 0,
			items:[],
		}
	},
	created(){
		this.table_options.headings = {
			'code':              'Código de requerimiento',
			'name':              'Nombre',
			'description':     	 'Descripción',
			'quantity':          'Cantidad',
			'base_budget_price': 'Precio unitario base',
			'supplier_price': 	 'Precio unitario del proveedor',
		};

		this.table_options.columnsClasses = {
			'code':              'col-xs-1 text-center',
			'name':              'col-xs-2',
			'description':     	 'col-xs-2',
			'quantity':          'col-xs-1',
			'base_budget_price': 'col-xs-2 text-right',
			'supplier_price': 	 'col-xs-2 text-right',
		};

		this.table_options.filterable = [
			'code', 
			'name', 
			'description', 
			'quantity'
		];
	},
	watch:{
		budget_item_id(res){
			if (res) {
				this.getBudgetAvailable();
			}
		}
	},
	mounted(){
		const vm = this;

		if (vm.records) {
			function get_supplier_price(list, id) {
				var price = 0;
				$.each(list, function(index, data) {
					if (data.purchase_requirement_item_id == id) {
						price = data.unit_price;
						vm.supplier_price_tot += parseFloat(data.unit_price);
						return;
					}
				});
				return price;
			}

			$.each(vm.records.pivot_recordable, function(x, baseBudget) {
				var code = baseBudget.relatable.purchase_requirement.code;
				$.each(baseBudget.relatable.relatable, function(y, item) {
					vm.items.push({
						code: 				code,
						id: 				item.purchase_requirement_item.id,
						name: 				item.purchase_requirement_item.warehouse_product.name,
						description: 		item.purchase_requirement_item.warehouse_product.description,
						quantity: 			item.purchase_requirement_item.quantity,
						measurement_unit: 	item.purchase_requirement_item.warehouse_product.measurement_unit.acronym,
						base_budget_price: 	vm.addDecimals(item.unit_price),
						supplier_price: 	vm.addDecimals(get_supplier_price(vm.records.relatable, item.id)),
					});
				});
			});
		}
	},
	methods:{

		uploadFile(inputID, e){

			let vm = this;
			const files = e.target.files;

			Array.from(files).forEach(file => vm.addFile(file, inputID));
		},
		addFile(file, inputID) {
			if (!file.type.match('application/pdf')) {
				this.showMessage(
					'custom', 'Error', 'danger', 'screen-error', 'Solo se permiten archivos pdf.'
				);
				return;
			}else{
				this.files[inputID] = file;
				$('#status_'+inputID).show("slow");
			}
		},

		CalculateQtyPrice(qty_price){
			return (qty_price)?(qty_price).toFixed((this.currency)?this.currency.decimal_places:''):0;
		},

		addDecimals(value){
			return parseFloat(value).toFixed(this.currency.decimal_places);
		},

		/**
		* Establece la cantidad de decimales correspondientes a la moneda que se maneja
		*
		* @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
		*/
		cualculateLimitDecimal(){
			var res = "0.";
			if (this.currency) {
				for (var i = 0; i < this.currency.decimal_places-1; i++) {
					res += "0";
				}
			}
			res += "1";
			return res;
		},

		/**
		* [CalculateTot Calcula el total del debe y haber del asiento contable]
		* @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
		* @param  {[type]} r   [información del registro]
		* @param  {[type]} pos [posición del registro]
		*/
		CalculateTot(item, pos){
			const vm = this;

			vm.sub_total = 0;
			vm.tax_value = 0;
			for (var i = vm.record_items.length - 1; i >= 0; i--) {
				var r = vm.record_items[i];
				r['qty_price'] = r.quantity * r.unit_price;
				vm.sub_total += r['qty_price'];
			}
			vm.tax_value = vm.sub_total * (parseFloat(vm.tax.percentage)/100);
			vm.total = vm.sub_total + vm.tax_value;
		},

		/**
		 * [getBudgetAvailable Consulta el saldo de la partida presupuestaria]
		 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
		 * @return {[type]} [description]
		 */
		getBudgetAvailable(){
			const vm = this;
			// ---------------------------------------------------------
			// se consultara el saldo disponible de la cuenta
			// ---------------------------------------------------------
			axios.get(`/budget/getBudgetAvailable/${vm.specific_action_id}/${vm.budget_item_id}`).then(response=>{
				console.log(response.data.balance);
			    this.budget_available = response.data.balance;
			});
		}
	}
};
</script>
