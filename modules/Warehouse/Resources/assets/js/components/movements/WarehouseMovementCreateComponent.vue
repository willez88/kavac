<template>
	<section id="WarehouseMovementForm">
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
				<div class="col-md-6">
					<b>Origen de los insumos</b>
					<div class="col-12 d-inline-flex">
						<div class="col-6" id="helpInstitutionInitial"
							v-if="movementid == null">
							<div class="form-group is-required">
								<label>Nombre de la organización:</label>
								<select2 :options="institutions" @input="getWarehouseStart(record.initial_institution_id)" v-model="record.initial_institution_id"></select2>
								<input type="hidden" v-model="record.id">
		                    </div>
						</div>
						<div class="col-6" id="helpInstitutionInitial"
							v-else>
							<div class="form-group is-required">
								<label>Nombre de la organización:</label>
								<input type="text" data-toggle="tooltip"
												class="form-control"
												id="institution_start"
												readonly="">
		                    </div>
						</div>

						<div class="col-6" id="helpWarehouseInitial"
							v-if="movementid == null">
							<div class="form-group is-required">
								<label>Nombre del almacén:</label>
								<select2 :options="initial_warehouses" @input="getWarehouseProducts()"
								v-model="record.initial_warehouse_id"></select2>
		                    </div>
						</div>
						<div class="col-6" id="helpWarehouseInitial"
							v-else>
							<div class="form-group is-required">
								<label>Nombre del almacén:</label>
								<input type="text" data-toggle="tooltip"
												class="form-control"
												id="warehouse_start"
												readonly="">
		                    </div>
						</div>
					</div>
				</div>

				<div class="col-md-6">
					<b>Destino de los insumos</b>
					<div class="col-12 d-inline-flex">
						<div class="col-6" id="helpInstitutionEnd">
							<div class="form-group is-required">
								<label>Nombre de la organización:</label>
								<select2 :options="institutions" @input="getWarehouseFinish(record.end_institution_id)" v-model="record.end_institution_id"></select2>
		                    </div>
						</div>

						<div class="col-6"  id="helpWarehouseEnd">
							<div class="form-group is-required">
								<label>Nombre del almacén:</label>
								<select2 :options="end_warehouses"
								v-model="record.end_warehouse_id"></select2>
		                    </div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6" id="helpWarehouseMovementDescription">
					<div class="form-group is-required">
						<label>Descripción:</label>
                        <ckeditor :editor="ckeditor.editor" data-toggle="tooltip"
                                  title="Indique alguna descripción referente al movimiento de almacén (requerido)"
                                  :config="ckeditor.editorConfig" class="form-control" tag-name="textarea" rows="3"
                                  v-model="record.description"></ckeditor>
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
						}}
					</span>
					<span>
						<div v-for="att in props.row.warehouse_product_values">
							<b>{{att.warehouse_product_attribute.name +":"}}</b> {{ att.value}}
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
				<div slot="id" slot-scope="props">
					<div>
						<input type="number" class="form-control table-form input-sm" data-toggle="tooltip" min=0 :max="props.row.exist" :id="'movement_product_'+props.row.id" onfocus="this.select()" @input="selectElement(props.row.id)">
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

		        	<button type="button"  @click="createMovement('warehouse/movements')"
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
					description:'',
					initial_warehouse_id:'',
					initial_institution_id:'',
					end_warehouse_id:'',
					end_institution_id:'',
					warehouse_inventory_products: [],
				},

				columns: ['check', 'code', 'description', 'inventory', 'id'],
				records: [],
				errors: [],

				institutions: [],
				initial_warehouses: [],
				end_warehouses: [],

				selected: [],
				selectAll: false,

				table_options: {
					rowClassCallback(row) {
						var checkbox = document.getElementById('checkbox_' + row.id);
						return ((checkbox)&&(checkbox.checked))? 'selected-row cursor-pointer' : 'cursor-pointer';
					},

					headings: {
						'code': 'Código',
						'description': 'Descripción',
						'inventory': 'Inventario',
						'id': 'Solicitados',
					},
					sortable: ['code', 'description', 'inventory', 'id'],
					filterable: ['code', 'description', 'inventory', 'id'],
				}
			}
		},
		props: {
			movementid: Number,
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
					description:'',
					initial_warehouse_id:'',
					initial_institution_id:'',
					end_warehouse_id:'',
					end_institution_id:'',
					warehouse_inventory_products: [],
				};

				this.initial_warehouses = [];
				this.end_warehouses = [];

				this.selected = [];
				this.selectAll = false;

			},
			select() {
				const vm = this;
				vm.selected = [];
				$.each(vm.records, function(index,campo){
					var checkbox = document.getElementById('checkbox_' + campo.id);
					var input = document.getElementById('movement_product_' + campo.id);
					if(!vm.selectAll)
						vm.selected.push(campo.id);
					else if(checkbox && checkbox.checked){
						checkbox.click();
						if (input)
							input.value = "";
					}
				});
			},
			selectElement(id) {
				var input = document.getElementById('movement_product_' + id);
	            var checkbox = document.getElementById('checkbox_' + id);
	            if ((input.value == '') || (input.value == 0)) {
	                if (checkbox.checked)
	                    checkbox.click();
	            } else if (!checkbox.checked)
	                checkbox.click();
			},
			getWarehouseProducts() {
				const vm = this;
				var warehouse = vm.record.initial_warehouse_id;
				var institution = vm.record.initial_institution_id;

				var url = "/warehouse/movements/vue-list-products/";
				vm.records = [];
				if(( warehouse != '') && (institution != '')){
					axios.get(url + warehouse + '/' + institution).then(response => {
						if(typeof(response.data.records) != "undefined"){
							vm.records = response.data.records;
						}
					});
				}
			},
			getWarehouseStart(id) {
				const vm = this;
				var url = '/warehouse/get-warehouses/';
				vm.warehouse_start = [];
				vm.selected = [];
				if (id != '') {
					axios.get(url + id).then(response => {
						if(typeof(response.data) != "undefined")
							vm.initial_warehouses = response.data;
					});
				}
				if (vm.movementid) {
					$.each(vm.record.warehouse_inventory_products, function (index, campo) {
						var element = document.getElementById("movement_product_" + campo.warehouse_inventory_product_id);
						if (element) {
							element.value = campo.quantity;
							vm.selected.push(campo.warehouse_inventory_product_id);
						}
					});
				}
			},
			getWarehouseFinish(id) {
				const vm = this;
				var url = '/warehouse/get-warehouses/';
				vm.warehouse_finish = [];
				if (id != '') {
					axios.get(url + id).then(response => {
						if(typeof(response.data) != "undefined")
							vm.end_warehouses = response.data;
					});
				}
			},

			createMovement(url){
				const vm = this;
                vm.record.warehouse_inventory_products = [];
                if(!vm.selected.length > 0){
                	bootbox.alert("Debe agregar almenos un elemento a la solicitud");
					return false;
				};
                $.each(vm.selected,function(index,campo){
                	var element = document.getElementById("movement_product_"+campo);
                	if (element) {
                		var value = element.value;
	                    if (value == "") {
							bootbox.alert("Debe ingresar la cantidad solicitada para cada insumo seleccionado");
							return false;
						}
	                    vm.record.warehouse_inventory_products.push({ id:campo, movemented:value});
                	}
                });
                vm.createRecord(url);
			},

			loadMovement(id){
				const vm = this;
	            var fields = {};

	            axios.get('/warehouse/movements/info/'+id).then(response => {
	                if(typeof(response.data.records != "undefined")){
	                    fields = response.data.records;
	                    vm.record = {
	                        id: fields.id,
	                        description: fields.description,
	                        initial_institution_id: (fields.warehouse_institution_warehouse_initial)?
	                        	fields.warehouse_institution_warehouse_initial.institution_id:'',
	                        end_institution_id: (fields.warehouse_institution_warehouse_end)?
	                        	fields.warehouse_institution_warehouse_end.institution_id:'',
	                        initial_warehouse_id: (fields.warehouse_institution_warehouse_initial)?
	                        	fields.warehouse_institution_warehouse_initial.warehouse_id:'',
	                        end_warehouse_id: (fields.warehouse_institution_warehouse_end)?
	                        	fields.warehouse_institution_warehouse_end.warehouse_id:'',
	                        warehouse_inventory_products: [],
	                    };
	                    $(".card-body #institution_start").val((fields.warehouse_institution_warehouse_initial)?
	                        	fields.warehouse_institution_warehouse_initial.institution.acronym:'' );
	                    $(".card-body #warehouse_start").val((fields.warehouse_institution_warehouse_initial)?
	                        	fields.warehouse_institution_warehouse_initial.warehouse.name:'' );

	                    vm.getWarehouseProducts();
	                    $.each(fields.warehouse_inventory_product_movements, function(index,campo){
	                        var element = document.getElementById("movement_product_"+campo.warehouse_inventory_product_id);
	                        if(element){
	                            element.value = campo.quantity;
	                        }
	                        vm.selected.push(campo.warehouse_inventory_product_id);
	                    });
	                }
	            });
	        },
		},
		created() {
			this.getInstitutions();
			if(this.movementid){
				this.loadMovement(this.movementid);
			}
		},
	};
</script>
