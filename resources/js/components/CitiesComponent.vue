<template>
	<div class="col-md-2 text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary" 
		   href="" title="Registros de Ciudades de un Estado" 
		   data-toggle="tooltip" @click="addRecord('add_city', 'cities', $event)">
			<i class="icofont icofont-5-star-hotel ico-3x"></i>
			<span>Ciudades</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_city">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-5-star-hotel inline-block"></i> 
							Ciudades
						</h6>
					</div>
					<div class="modal-body">
						<div class="alert alert-danger" v-if="errors.length > 0">
							<ul>
								<li v-for="error in errors">{{ error }}</li>
							</ul>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Pais:</label>
									<select2 :options="countries" @input="getEstates" 
											 v-model="record.country_id"></select2>
									<input type="hidden" v-model="record.id">
			                    </div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Estados:</label>
									<select2 :options="estates" v-model="record.estate_id"></select2>
			                    </div>
							</div>
							<div class="col-md-12">
								<div class="form-group is-required">
									<label>Nombre:</label>
									<input type="text" placeholder="Nombre de la Ciudad" data-toggle="tooltip" 
										   title="Indique el nombre de la ciudad (requerido)" 
										   class="form-control input-sm" v-model="record.name">
			                    </div>
							</div>
						</div>
	                </div>
	                <div class="modal-footer">
	                	<div class="form-group">
	                		<modal-form-buttons :saveRoute="'cities'"></modal-form-buttons>
	                	</div>
	                </div>
	                <div class="modal-body modal-table">
	                	<v-client-table :columns="columns" :data="records" :options="table_options">
	                		<div slot="id" slot-scope="props" class="text-center">
	                			<button @click="initUpdate(props.index, $event)" 
		                				class="btn btn-warning btn-xs btn-icon btn-action" 
		                				title="Modificar registro" data-toggle="tooltip" type="button">
		                			<i class="fa fa-edit"></i>
		                		</button>
		                		<button @click="deleteRecord(props.index, 'cities')" 
										class="btn btn-danger btn-xs btn-icon btn-action" 
										title="Eliminar registro" data-toggle="tooltip" 
										type="button">
									<i class="fa fa-trash-o"></i>
								</button>
	                		</div>
	                	</v-client-table>
	                </div>
		        </div>
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
					country_id: '0',
					estate_id: '',
					name: '',
				},
				errors: [],
				records: [],
				countries: [],
				estates: ['0'],
				columns: ['estate.name', 'name', 'id'],
			}
		},
		methods: {
			/**
			 * Método que borra todos los datos del formulario
			 * 
			 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
			 */
			reset() {
				this.record = {
					id: '',
					country_id: '0',
					estate_id: '',
					name: '',
				};
			},
		},
		created() {
			this.table_options.headings = {
				'estate.name': 'Estado',
				'name': 'Ciudad',
				'id': 'Acción'
			};
			this.table_options.sortable = ['estate.name', 'name'];
			this.table_options.filterable = ['estate.name', 'name'];
			this.table_options.columnsClasses = {
				'estate.name': 'col-md-3',
				'name': 'col-md-7',
				'id': 'col-md-2'
			};
		},
		mounted() {
			let vm = this;
			$("#add_city").on('show.bs.modal', function() {
				vm.getCountries();
			});
		}
	};
</script>
