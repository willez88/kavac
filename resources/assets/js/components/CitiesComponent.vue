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
	                <div class="modal-body modal-table">
	                    <table class="table table-hover table-striped dt-responsive nowrap datatable">
							<thead>
								<tr class="text-center">
									<!--<th>Pais</th>-->
									<th>Estado</th>
									<th>Ciudad</th>
									<th>Acción</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="(rec, index) in records">
									<!--<td>{{ rec.estate.country.name }}</td>-->
									<td>{{ rec.estate.name }}</td>
									<td>{{ rec.name }}</td>
									<td class="text-center" width="10%">
										<button @click="initUpdate(index, $event)" 
												class="btn btn-warning btn-xs btn-icon btn-round" 
												title="Modificar registro" data-toggle="tooltip" type="button">
											<i class="fa fa-edit"></i>
										</button>
										<button @click="deleteRecord(index, 'cities')" 
												class="btn btn-danger btn-xs btn-icon btn-round" title="Eliminar registro" data-toggle="tooltip" type="button">
											<i class="fa fa-trash-o"></i>
										</button>
									</td>
								</tr>
							</tbody>
						</table>
	                </div>
	                <div class="modal-footer">
	                	<button type="button" class="btn btn-default btn-sm btn-round btn-modal-close" 
	                			data-dismiss="modal">
	                		Cerrar
	                	</button>
	                	<button type="button" @click="createRecord('cities')" 
	                			class="btn btn-primary btn-sm btn-round btn-modal-save">
	                		Guardar
		                </button>
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
				estates: []
			}
		},
		mounted() {
			
		},
		methods: {
			/**
			 * Inicializa los registros base del formulario
			 *
			 * @author Ing. Roldan Vargas (rvargas at cenditel.gob.ve)
			 */
			initRecords() {
				axios.get('/get-countries').then(response => {
					this.countries = response.data;
				});
			},
			/**
			 * Obtiene los Estados del Pais seleccionado
			 * 
			 * @author Ing. Roldan Vargas (rvargas at cenditel.gob.ve)
			 */
			getEstates() {
				if (this.record.country_id) {
					axios.get('/get-estates/' + this.record.country_id).then(response => {
						this.estates = response.data;
					});
				}
			}
		}
	}
</script>