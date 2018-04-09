<template>
	<div class="col-md-2 text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary" href="" 
		   title="Registros de estados civiles" data-toggle="tooltip" 
		   @click="addRecord('add_marital_status')">
			<i class="fa fa-female ico-3x inline-block"></i>
			<i class="fa fa-male ico-3x nopadding-left"></i>
			<span>Estados<br>Civiles</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_marital_status">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="fa fa-female inline-block"></i>
							<i class="fa fa-male inline-block"></i> 
							Estado Civil
						</h6>
					</div>
					<div class="modal-body">
						<div class="alert alert-danger" v-if="errors.length > 0">
							<ul>
								<li v-for="error in errors">{{ error }}</li>
							</ul>
						</div>
						<div class="form-group is-required">
							<label for="marital_status_name">Nombre:</label>
							<input type="text" name="marital_status_name" id="marital_status_name" placeholder="Estado Civil" 
								   class="form-control input-sm" v-model="record.marital_status_name">
							<input type="hidden" name="marital_status_id" id="marital_status_id" v-model="record.marital_status_id">
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
										<button @click="deleteRecord(index, 'marital-status')" 
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
					marital_status_id: '',
					marital_status_name: ''
				},
				errors: [],
				records: []
			}
		},
		mounted()
		{
			this.readRecords();
		},
		methods: {
			createRecord()
			{
				if (this.record.marital_status_id) {
					this.updateRecord();
				}
				else {
					axios.post('/marital-status', {
						name: this.record.marital_status_name
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
				axios.get('/marital-status').then(response => {
					this.records = response.data.records;
				});
			},
			initUpdate(index, event)
			{
				this.errors = [];
				this.record = this.records[index];
				event.preventDefault();
			},
			updateRecord()
            {
                axios.patch('/marital-status/' + this.record.marital_status_id, {
                    name: this.record.marital_status_name,
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