<template>
	<div class="col-md-2 text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary" href="" 
		   title="Registros de estados civiles" data-toggle="tooltip" @click="addMaritalStatus">
			<i class="fa fa-female ico-3x inline-block"></i>
			<i class="fa fa-male ico-3x nopadding-left"></i>
			<span>Estados<br>Civiles</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_ms_model">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h4 class="modal-title">Agregar Estado Civil</h4>
					</div>
					<div class="modal-body">
						<div class="alert alert-danger" v-if="errors.length > 0">
							<ul>
								<li v-for="error in errors">{{ error }}</li>
							</ul>
						</div>
						<div class="form-group">
							<label for="name">Nombre:</label>
							<input type="text" name="name" id="name" placeholder="Estado Civil" 
								   class="form-control input-sm" v-model="marital_st.name">
							<input type="hidden" name="id" id="id" v-model="marital_st.id">
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
								<tr v-for="(ms, index) in marital_status">
									<td>{{ ms.name }}</td>
									<td class="text-center" width="10%">
										<button @click="initUpdate(index)" class="btn btn-warning btn-xs btn-icon btn-round" title="Modificar registro" data-toggle="tooltip" type="button">
											<i class="fa fa-edit"></i>
										</button>
										<button @click="deleteMaritalStatus(index)" 
												class="btn btn-danger btn-xs btn-icon btn-round" title="Eliminar registro" data-toggle="tooltip" type="button">
											<i class="fa fa-trash-o"></i>
										</button>
									</td>
								</tr>
							</tbody>
						</table>
	                </div>
	                <div class="modal-footer">
	                	<button type="button" class="btn btn-default" data-dismiss="modal">
	                		Cerrar
	                	</button>
	                	<button type="button" @click="createMaritalStatus" class="btn btn-primary">
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
				marital_st: {
					id: '',
					name: ''
				},
				errors: [],
				marital_status: [],
				update_marital_status: {}
			}
		},
		mounted()
		{
			this.readMaritalStatus();
		},
		methods: {
			addMaritalStatus(e) {
				e.preventDefault();
				this.errors = [];
				//$("#add_ms_model").modal('show');
				bootbox.alert('hola');
			},
			createMaritalStatus()
			{
				if (this.marital_st.id) {
					this.updateMaritalStatus();
				}
				else {
					axios.post('/marital-status', {
						name: this.marital_st.name
					})
					.then(response => {
						this.reset();
					 	this.readMaritalStatus();
					 	vue_messages(false, false, false, 'store');
					})
					.catch(error => {
						this.errors = [];
					 	if (error.response.data.errors.name) {
                            this.errors.push(error.response.data.errors.name[0]);
                        }
                    });
				}
				
			},
			reset()
			{
				this.marital_st.name = '';
			},
			readMaritalStatus()
			{
				axios.get('/marital-status').then(response => {
					this.marital_status = response.data.marital_status;
				});
			},
			initUpdate(index, event)
			{
				this.errors = [];
				this.marital_st = this.marital_status[index];
				event.preventDefault();
			},
			updateMaritalStatus()
            {
                axios.patch('/marital-status/' + this.marital_st.id, {
                    name: this.marital_st.name,
                })
                .then(response => {
                	this.readMaritalStatus();
                })
                .catch(error => {
                	this.errors = [];
                	if (error.response.data.errors.name) {
                		this.errors.push(error.response.data.errors.name[0]);
                	}
                });
            },
			deleteMaritalStatus(index)
			{
				let conf = confirm("Esta seguro de eliminar este registro?");

				if (conf === true) {
					axios.delete('/marital-status/' + this.marital_status[index].id).then(
						response => {
							this.marital_status.splice(index, 1);
						 	vue_messages(type='destroy');
						}
					)
					.catch(error => {});
				}
			}
		}
	}
</script>