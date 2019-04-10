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
					<div class="col-md-12">
						<b>Origen de los productos</b>
					</div>

					<div class="col-3">
						<div class="form-group is-required">
							<label>Nombre de la Institución:</label>
							<select2 :options="institutions" @click="getWarehouses(movement.institution_start_id, 'start')" v-model="movement.institution_start_id"></select2>
							<input type="hidden" v-model="movement.id">
	                    </div>
					</div>

					<div class="col-3">
						<div class="form-group is-required">
							<label>Nombre del Almacén:</label>
							<select2 :options="warehouses_start"
							v-model="movement.warehouse_start_id"></select2>
	                    </div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="col-md-12">
						<b>Destino de los productos</b>
					</div>

					<div class="col-3">
						<div class="form-group is-required">
							<label>Nombre de la Institución:</label>
							<select2 :options="institutions" @click="getWarehouses(movement.institution_finish_id, 'finish')" v-model="movement.institution_finish_id"></select2>
	                    </div>
					</div>

					<div class="col-3">
						<div class="form-group is-required">
							<label>Nombre del Almacén:</label>
							<select2 :options="warehouses_finish"
							v-model="movement.warehouse_finish_id"></select2>
	                    </div>
					</div>
				</div>
			</div>
			<hr>
			
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

<script>
	export default {
		data() {
			return {
				record: {
					id: '',
				},
				movement: {
					id: '',
					warehouse_start_id:'',
					institution_start_id:'',
					warehouse_finish_id:'',
					institution_finish_id:'',
				},
				
				records: [],
				errors: [],
				
				setting: [],
				institutions: [],

				warehouses_start: [],
				warehouses_finish: [],
			}
		},
		props: {
		movementid: Number, 
		},
		methods: {
			reset() {
				this.record = {
					id: '',
				}

			},
			getWarehouses(id,type){
				const vm = this;
				var url = (typeof(id) !== 'undefined')? '/warehouse/institution/'+id: '/warehouse/institution';
				axios.get(url).then(response => {
					if(typeof(response.data) != "undefined"){
						if(type == "start")
							vm.warehouses_start = response.data;
						else
							vm.warehouses_finish = response.data;
					}
				});
			},

			createMovement(url){
			},
			updateMovement(url){
			},
			loadMovement(id){
	        },
		},
		created() {

			this.getInstitutions();
			this.getWarehouses();

			if(this.movementid){
				this.loadMovement(this.movementid);
			}
		},
	};
</script>
