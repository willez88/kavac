<template>
	<div class="card">
		<div class="card-header">
			<h6 class="card-title text-uppercase">Nuevo Movimiento de Almacén</h6>
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
				<div class="col-md-6">
					<b>Origen de los productos</b>
					<div class="col-12 d-inline-flex">
						<div class="col-6" v-if="movementid == null">
							<div class="form-group is-required">
								<label>Nombre de la Institución:</label>
								<select2 :options="institutions" @input="getWarehouseStart(movement.institution_start_id)" v-model="movement.institution_start_id"></select2>
								<input type="hidden" v-model="movement.id">
		                    </div>
						</div>
						<div class="col-6" v-else>
							<div class="form-group is-required">
								<label>Nombre de la Institución:</label>
								<input type="text" data-toggle="tooltip" 
												class="form-control"
												id="institution_start" 
												readonly="">
								<input type="hidden" v-model="movement.id">
		                    </div>
						</div>

						<div class="col-6" v-if="movementid == null">
							<div class="form-group is-required">
								<label>Nombre del Almacén:</label>
								<select2 :options="warehouses_start" @input="getWarehouseProducts()"
								v-model="movement.warehouse_start_id"></select2>
		                    </div>
						</div>
						<div class="col-6" v-else>
							<div class="form-group is-required">
								<label>Nombre del Almacén:</label>
								<input type="text" data-toggle="tooltip" 
												class="form-control"
												id="warehouse_start" 
												readonly="">
		                    </div>
						</div>
					</div>
				</div>

				<div class="col-md-6">
					<b>Destino de los productos</b>
					<div class="col-12 d-inline-flex">
						<div class="col-6">
							<div class="form-group is-required">
								<label>Nombre de la Institución:</label>
								<select2 :options="institutions" @input="getWarehouseFinish(movement.institution_finish_id)" v-model="movement.institution_finish_id"></select2>
		                    </div>
						</div>

						<div class="col-6">
							<div class="form-group is-required">
								<label>Nombre del Almacén:</label>
								<select2 :options="warehouses_finish"
								v-model="movement.warehouse_finish_id"></select2>
		                    </div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<div class="form-group is-required">
						<label>Motivo:</label>
						<textarea  data-toggle="tooltip" 
								   title="Indique algún motivo o descripción referente al movimiento de almacén (requerido)" 
								   class="form-control" v-model="movement.description">
					   </textarea>
                    </div>
				</div>
			</div>

			<hr>

			<table class="table table-hover table-striped dt-responsive table-movement">
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
					<tr v-for="(field,index) in this.products"
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
								<input type="number" class="form-control input-sm" data-toggle="tooltip" min=0 :max="field.exist" :id="'movement_product_'+field.id" onfocus="this.select()" @input="selectElement(field.id)">
							</div>
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

        	<button type="button"  @click="createMovement('warehouse/movements')"
        			class="btn btn-success btn-icon btn-round btn-modal-save"
        			title="Guardar registro">
        		<i class="fa fa-save"></i>
            </button>
        </div>

	</div>
</template>

<style>
	.table-movement {
		font-size: .58rem;
	}
	.table-movement .form-control {
		border-radius:.25rem !important;
		padding: .375rem .1rem;
	    font-size: .6rem;
	    text-align: right;
	}
	.table-movement tbody tr.selected-row {
		background-color: #d1d1d1;
	}
	.table-movement tbody tr td.td-with-border {
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
				},
				movement: {
					id: '',
					description:'',
					warehouse_start_id:'',
					institution_start_id:'',
					warehouse_finish_id:'',
					institution_finish_id:'',
					products: [],
				},
				
				records: [],
				errors: [],
				
				institutions: [],
				products: [],
				warehouses_start: [],
				warehouses_finish: [],

				selected: [],
				selectAll: false,
			}
		},
		props: {
		movementid: Number, 
		},
		methods: {
			reset() {
				this.record = {
					id: '',
				};
				this.movement = {
					id: '',
					description:'',
					warehouse_start_id:'',
					institution_start_id:'',
					warehouse_finish_id:'',
					institution_finish_id:'',
					products: [],
				};
				this.warehouses_start = [];
				this.warehouses_finish = [];

				this.selected = [];
				this.selectAll = false;

			},
			select() {
				const vm = this;
				vm.selected = [];
				$.each(vm.products, function(index,campo){
					var checkbox = document.getElementById('checkbox_' + campo.id);
					var input = document.getElementById('movement_product_' + campo.id);
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
				var input = document.getElementById('movement_product_' + id);
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
			getWarehouseProducts(){
				const vm = this;
				var warehouse = vm.movement.warehouse_start_id;
				var institution = vm.movement.institution_start_id;

				var url = "/warehouse/movements/vue-list-products/";
				vm.products = [];
				if(( warehouse != '') && (institution != '')){
					axios.get(url + warehouse + '/' + institution).then(response => {
						if(typeof(response.data.records) != "undefined"){
							vm.products = response.data.records;
						}
					});
				}
			},
			getWarehouseStart(id){
				const vm = this;
				var url = '/warehouse/institution/';
				vm.warehouse_start = [];
				vm.selected = [];
				if (id != ''){
					axios.get(url + id).then(response => {
						if(typeof(response.data) != "undefined")
							vm.warehouses_start = response.data;
					});
				}
				if(vm.movementid){
					$.each(vm.movement.products, function (index, campo) {
						var element = document.getElementById("movement_product_" + campo.inventary_product_id);
                        console.log(element);
						if (element) {
							element.value = campo.quantity;
							vm.selected.push(campo.inventary_product_id);
						}
					});
				}
			},
			getWarehouseFinish(id){
				const vm = this;
				var url = '/warehouse/institution/';
				vm.warehouse_finish = [];
				if (id != ''){
					axios.get(url).then(response => {
						if(typeof(response.data) != "undefined")
							vm.warehouses_finish = response.data;
					});
				}
			},

			createMovement(url){
				const vm = this;
                vm.movement.products = [];
                if(!vm.selected.length > 0){
                	bootbox.alert("Debe agregar almenos un elemento a la solicitud");
					return false;
				};
                $.each(vm.selected,function(index,campo){
                    var value = document.getElementById("movement_product_"+campo).value;
                    if (value == "") {
						bootbox.alert("Debe ingresar la cantidad solicitada para cada producto seleccionado");
						return false;
					}
                    vm.movement.products.push(
                        {id:campo, movemented:value});

                });
                if (vm.movement.id) {
					this.updateMovement(url);
				}
				else{
					axios.post('/' + url, this.movement).then(response => {
						this.errors = [];
						if (response.data.result) {
	                        vm.showMessage('store');
	                        setTimeout(function() {
	                            window.location.href = '/warehouse/movements';
	                        }, 2000);
	                    }
	                    else if(response.data.result){
	                    	let msg = response.data.message;
							this.showMessage(msg.type, msg.title, msg.class, msg.icon, msg.text);
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
			updateMovement(url){
				const vm = this;
					axios.patch('/' + url + '/' + this.movement.id, this.movement).then(response => {
						if (response.data.result) {
		                        vm.showMessage('update');
		                        setTimeout(function() {
		                            window.location.href = '/warehouse/movements';
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
			loadMovement(id){
				const vm = this;
	            var fields = {};
	            
	            axios.get('/warehouse/movements/vue-info/'+id).then(response => {
	                if(typeof(response.data.records != "undefined")){
	                    fields = response.data.records;
	                    vm.movement = {
	                        id: fields.id,
	                        description: fields.description,
	                        institution_start_id: fields.start.institution_id,
	                        institution_finish_id: fields.finish.institution_id,
	                        warehouse_start_id: fields.start.warehouse_id,
	                        warehouse_finish_id: fields.finish.warehouse_id,
	                        products: [],
	                    };
	                    $(".card-body #institution_start").val(fields.start.institution.acronym );
	                    $(".card-body #warehouse_start").val(fields.start.warehouse.name );

	                    vm.getWarehouseProducts();
	                    $.each(fields.product_movements, function(index,campo){
	                        var element = document.getElementById("movement_product_"+campo.inventary_product_id);
	                        if(element){
	                            element.value = campo.quantity;
	                        }
	                        vm.selected.push(campo.inventary_product_id);
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
