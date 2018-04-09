<template>
	<div class="col-md-2 text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary" 
		   href="#" title="Registros de Estado de un Pais" 
		   data-toggle="tooltip" @click="addRecord('add_estate')">
			<i class="icofont icofont-map-search ico-3x"></i>
			<span>Estados</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_estate">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-map-search inline-block"></i> 
							Estado
						</h6>
					</div>
					<div class="modal-body">
						<div class="alert alert-danger" v-if="errors.length > 0">
							<ul>
								<li v-for="error in errors">{{ error }}</li>
							</ul>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="country_id">Pais:</label>
									<select2 :options="countries" v-model="record.country_id"></select2>
									<!--<input type="text" name="country_id" id="country_id" 
										   placeholder="Pais" 
										   class="form-control input-sm" v-model="record.country_id">-->
									<input type="hidden" name="id" id="id" v-model="record.id">
			                    </div>
							</div>
							<div class="col-md-4">
								<div class="form-group is-required">
									<label for="code">Código:</label>
									<input type="text" name="code" id="code" placeholder="Código de Estado" 
										   class="form-control input-sm" v-model="record.code">
			                    </div>
							</div>
							<div class="col-md-4">
								<div class="form-group is-required">
									<label for="name">Nombre:</label>
									<input type="text" name="name" id="name" placeholder="Nombre de Estado" 
										   class="form-control input-sm" v-model="record.name">
			                    </div>
							</div>
						</div>
	                </div>
	                <div class="modal-body modal-table">
	                    <table class="table table-hover table-striped dt-responsive nowrap datatable">
							<thead>
								<tr class="text-center">
									<th>Pais</th>
									<th>Estado</th>
									<th>Código</th>
									<th>Acción</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="(rec, index) in records">
									<td>{{ rec.country.name }}</td>
									<td>{{ rec.name }}</td>
									<td class="text-center">{{ rec.code }}</td>
									<td class="text-center" width="10%">
										<button @click="initUpdate(index)" class="btn btn-warning btn-xs btn-icon btn-round" title="Modificar registro" data-toggle="tooltip" type="button">
											<i class="fa fa-edit"></i>
										</button>
										<button @click="deleteRecord(index, 'estates')" 
												class="btn btn-danger btn-xs btn-icon btn-round" title="Eliminar registro" data-toggle="tooltip" type="button">
											<i class="fa fa-trash-o"></i>
										</button>
									</td>
								</tr>
							</tbody>
						</table>
	                </div>
	                <div class="modal-footer">
	                	<button type="button" class="btn btn-default btn-sm btn-round" data-dismiss="modal">
	                		Cerrar
	                	</button>
	                	<button type="button" @click="createRecord" class="btn btn-primary btn-sm btn-round">
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
					country_id: '',
					name: '',
					code: ''
				},
				errors: [],
				records: [],
				countries: []
			}
		},
		mounted() {
			axios.get('/get-countries').then(response => {
				this.countries = response.data;
			});
			this.readRecords();
		},
		methods: {
			createRecord()
			{
				if (this.record.id) {
					this.updateRecord();
				}
				else {
					axios.post('/estates', {
						country_id: this.record.country_id,
						name: this.record.name,
						code: this.record.code
					})
					.then(response => {
						this.reset();
					 	this.readRecords();
					 	gritter_messages(false, false, false, 'store');
					})
					.catch(error => {
						this.errors = [];
						
						if (typeof(error.response) !="undefined") {
						 	if (error.response.data.errors.name) {
	                            this.errors.push(error.response.data.errors.name[0]);
	                        }
	                        if (error.response.data.errors.country_id) {
	                            this.errors.push(error.response.data.errors.country_id[0]);
	                        }
	                        if (error.response.data.errors.code) {
	                            this.errors.push(error.response.data.errors.code[0]);
	                        }
	                    }
                    });
				}
				
			},
			reset()
			{
				this.record = [];
			},
			readRecords()
			{
				axios.get('/estates').then(response => {
					this.records = response.data.records;
				});
			},
			initUpdate(index)
			{
				this.errors = [];
				this.record = this.records[index];
				event.preventDefault();
			},
			updateRecord()
            {
                axios.patch('/estates/' + this.record.id, {
                    name: this.record.name,
                    country_id: this.record.country_id,
                    code: this.record.code
                })
                .then(response => {
                	this.readRecords();
                	this.reset();
                })
                .catch(error => {
                	this.errors = [];

                	if (typeof(error.response) !="undefined") {
	                	if (error.response.data.errors.name) {
	                		this.errors.push(error.response.data.errors.name[0]);
	                	}
	                	if (error.response.data.errors.country_id) {
	                		this.errors.push(error.response.data.errors.country_id[0]);
	                	}
	                	if (error.response.data.errors.code) {
	                		this.errors.push(error.response.data.errors.code[0]);
	                	}
	                }
                });
            },
		}
	}
</script>