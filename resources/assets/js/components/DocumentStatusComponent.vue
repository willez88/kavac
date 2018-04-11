<template>
	<div class="col-md-2 text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary" href="" 
		   title="Registros de estados de los documentos" data-toggle="tooltip" 
		   @click="addRecord('add_doc_status', 'document-status')">
		   	<i class="icofont icofont-ui-copy ico-3x"></i>
			<span>Estatus<br>Documentos</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_doc_status">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-ui-copy inline-block"></i> 
							Estatus de Documento
						</h6>
					</div>
					<div class="modal-body">
						<div class="alert alert-danger" v-if="errors.length > 0">
							<ul>
								<li v-for="error in errors">{{ error }}</li>
							</ul>
						</div>
						<div class="row">
							<div class="col-md-2">
								<div class="form-group is-required">
									<label>Color:</label>
									<input type="text" placeholder="Color" 
										   class="form-control input-sm" v-model="record.color">
			                    </div>
							</div>
							<div class="col-md-4">
								<div class="form-group is-required">
									<label>Nombre:</label>
									<input type="text" placeholder="Nombre" 
										   class="form-control input-sm" v-model="record.name">
									<input type="hidden" v-model="record.id">
			                    </div>
							</div>
							<div class="col-md-6">
								<div class="form-group is-required">
									<label>Descripción:</label>
									<input type="text" placeholder="Descripción" 
										   class="form-control input-sm" v-model="record.description">
			                    </div>
							</div>
						</div>
	                </div>
	                <div class="modal-body modal-table">
	                    <table class="table table-hover table-striped dt-responsive nowrap datatable">
							<thead>
								<tr class="text-center">
									<th>Nombre</th>
									<th>Descripción</th>
									<th>Acción</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="(rec, index) in records">
									<td>
										<span class="badge" 
											  v-bind:style="{ background: rec.color, border: rec.color, color: '#fff' }">
											{{ rec.name }}
										</span>
									</td>
									<td>{{ rec.description }}</td>
									<td class="text-center" width="10%">
										<button @click="initUpdate(index)" 
												class="btn btn-warning btn-xs btn-icon btn-round" 
												title="Modificar registro" data-toggle="tooltip" 
												type="button">
											<i class="fa fa-edit"></i>
										</button>
										<button @click="deleteRecord(index, 'document-status')" 
												class="btn btn-danger btn-xs btn-icon btn-round" 
												title="Eliminar registro" data-toggle="tooltip" 
												type="button">
											<i class="fa fa-trash-o"></i>
										</button>
									</td>
								</tr>
							</tbody>
						</table>
	                </div>
	                <div class="modal-footer">
	                	<button type="button" class="btn btn-default btn-sm btn-round" 
	                			data-dismiss="modal">
	                		Cerrar
	                	</button>
	                	<button type="button" @click="createRecord('document-status')" 
	                			class="btn btn-primary btn-sm btn-round">
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
				/** @type {json} Inicialización de atributos */
				record: {
					id: '',
					description: '',
					name: '',
					color: ''
				},
				/** @type {Array} Inicialización de errores a mostrar */
				errors: [],
				/** @type {Array} Inicialización de atributo que cargara información registrada */
				records: []
			}
		},
		mounted() {
			//this.readRecords('document-status');
		}
	}
</script>