<template>
	<div class="col-md-2 text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary" 
		   href="" title="Registros para sectores de instituciones" 
		   data-toggle="tooltip" @click="addRecord('add_institution_sector')">
			<i class="icofont icofont-focus ico-3x"></i>
			<span>Sector<br>Instituciones</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_institution_sector">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-focus inline-block"></i> 
							Sector de Institución
						</h6>
					</div>
					<div class="modal-body">
						<div class="alert alert-danger" v-if="errors.length > 0">
							<ul>
								<li v-for="error in errors">{{ error }}</li>
							</ul>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group is-required">
									<label for="name">Nombre:</label>
									<input type="text" name="name" id="name" placeholder="Profesión" 
										   class="form-control input-sm" v-model="record.name">
									<input type="hidden" name="id" id="id" v-model="record.id">
			                    </div>
							</div>
						</div>
	                </div>
	                <div class="modal-body modal-table">
	                    <table class="table table-hover table-striped dt-responsive nowrap datatable">
							<thead>
								<tr class="text-center">
									<th>Nombre</th>
									<th>Acción</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="(rec, index) in records">
									<td>{{ rec.name }}</td>
									<td class="text-center" width="10%">
										<button @click="initUpdate(index)" class="btn btn-warning btn-xs btn-icon btn-round" title="Modificar registro" data-toggle="tooltip" type="button">
											<i class="fa fa-edit"></i>
										</button>
										<button @click="deleteRecord(index, 'institution-sectors')" 
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
					name: ''
				},
				errors: [],
				records: []
			}
		},
		mounted() {
			this.readRecords();
		},
		methods: {
			createRecord()
			{
				if (this.record.id) {
					this.updateRecord();
				}
				else {
					axios.post('/institution-sectors', {
						name: this.record.name
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
				axios.get('/institution-sectors').then(response => {
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
                axios.patch('/institution-sectors/' + this.record.id, {
                    name: this.record.name,
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
	                }
                });
            },
		}
	}
</script>