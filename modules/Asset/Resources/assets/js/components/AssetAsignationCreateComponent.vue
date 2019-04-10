<template>
	<div class="card">
		<div class="card-header">
			<h6 class="card-title text-uppercase">Asignación de Bienes Institucionales</h6>
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
					<b>Información del Trabajador Responsable del bien</b>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label>Puesto de Trabajo:</label>
						<select2 :options="puestos" @input="" 
								 v-model="record.puesto_id"></select2>
						<input type="hidden" v-model="record.id">
                    </div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Cargo:</label>
						<select2 :options="cargos" @input="" 
								 v-model="record.cargo_id"></select2>
                    </div>
				</div>
				<div class="col-md-6">
					<div class="form-group is-required">
						<label>Trabajador:</label>
						<select2 :options="staffs" @input="" 
								 v-model="record.staff_id"></select2>
                    </div>
				</div>

				<div class="col-md-6">
					<div class="form-group is-required">
						<label>Ubicación:</label>
						<select2 :options="ubications" @input="" 
								 v-model="record.ubication_id"></select2>
                    </div>

				</div>
			</div>

			<div class="modal-body modal-table">	                

            	<hr>
            	<v-client-table :columns="columns" :data="records" :options="table_options"> 
            	</v-client-table>

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

            	<button type="button"  @click=""
            			class="btn btn-success btn-icon btn-round btn-modal-save"
            			title="Guardar registro">
            		<i class="fa fa-save"></i>
                </button>
            </div>

		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				record: {
					id: '',
					puesto_id: '',
					cargo_id: '',
					staff_id: '',
					ubication_id: '',
				},
				records: [],
				errors: [],
				columns: ['serial_inventario','condition.name','status.name', 'serial', 'marca', 'model'],
				puestos:[],
				cargos:[],
				staffs:[],
				ubications:[],
			}
		},
		created() {
			this.table_options.headings = {
				'serial_inventario': 'Código',
				'condition.name': 'Condición Física',
				'status.name': 'Estatus de Uso',
				'serial': 'Serial',
				'marca': 'Marca',
				'model': 'Modelo',
			};
			this.table_options.sortable = ['serial_inventario','condition.name','status.name', 'serial', 'marca', 'model']
			this.table_options.filterable = ['serial_inventario','condition.name','status.name', 'serial', 'marca', 'model']
		},
		mounted() {
			axios.get('/asset/vue-list').then(response => {
					this.records = response.data.records;
				});
		},
		methods: {
			reset() {
				this.record = {
					id: '',
					puesto_id: '',
					cargo_id: '',
					staff_id: '',
					ubication_id: ''
				}
				
			},
		}
	};
</script>