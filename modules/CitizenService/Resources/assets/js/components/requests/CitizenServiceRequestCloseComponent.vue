<template>
	<section>
		<a class="btn btn-info btn-xs btn-icon btn-action"
		   href="#" title="Cerrar" data-toggle="tooltip"
		   @click="addRecord('view_close', route_list, $event)">
		   <i class="icofont icofont-zipped"></i>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="view_close">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-read-book ico-2x"></i>
							Adjuntar Información
						</h6>
					</div>

				<div class="modal-body">
					<div class="alert alert-danger" v-if="errors.length > 0">
						<div class="container">
							<div class="alert-icon">
								<i class="now-ui-icons objects_support-17"></i>
							</div>
							<strong>Cuidado!</strong> Debe verificar los siguientes errores antes de continuar:
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"
									@click.prevent="errors = []">
								<span aria-hidden="true">
									<i class="now-ui-icons ui-1_simple-remove"></i>
								</span>
							</button>
							<ul>
								<li v-for="error in errors">{{ error }}</li>
							</ul>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group is-required">
								<strong>Fecha de verificación</strong>
			        			<input type="date" id="date"
    								class="form-control input-sm" data-toggle="tooltip"
    							    title="Indique la fecha de verificación">

					           </div>
						</div>
					</div>
					<div class="row">
						<div class="col-6">
                        	<div class="input-group">
	                                <input id="file" name="file" class="d-none" type="file"
	                                	   accept=".doc, .pdf, .odt, .docx, .jpg, .png, .jpeg, .mp4, .avi" @change="processFiles()">
	                                <label for="file">
	                                <a class="btn btn-sm btn-primary btn-info text-light"> Subir archivo </a>
	                                </label>

                        	</div>
                     	</div>

					</div>
					<hr>
					<v-client-table :columns="columns" :data="records" :options="table_options">

						<div slot="id" slot-scope="props" class="text-center">
								<div class="d-inline-flex">
									<button @click="initUpdate(props.row.id, $event)"
		                				class="btn btn-warning btn-xs btn-icon btn-action"
		                				title="Modificar registro" data-toggle="tooltip" type="button">
		                			    <i class="fa fa-edit"></i>
		                			</button>
									<button @click="deleteRecord(props.row.id, '')"
										class="btn btn-danger btn-xs btn-icon btn-action"
										title="Eliminar registro" data-toggle="tooltip" type="button"
										:disabled="props.row.state != 'Pendiente'">
										<i class="fa fa-trash-o"></i>
									</button>

								</div>
						</div>

					</v-client-table>
	            </div>
					<div class="modal-footer">
						<div class="form-group">
                            <modal-form-buttons saveRoute="citizenservice/request-close"></modal-form-buttons>
                        </div>
		            </div>
		        </div>
		    </div>
		</div>
	</section>
</template>

<script>
	var formData = new FormData();
	export default {
		data() {
			return {
				records: [],
				errors: [],
				columns: ['file', 'size', 'state', 'id']
			}
		},
		created() {
			this.readRecords(this.route_list);
			this.table_options.headings = {
				'file': 'Archivo',
				'size': 'Tamaño',
				'state': 'Estado',
				'id': 'Acción'
			};
			this.table_options.sortable = ['file', 'size', 'state'];
			this.table_options.filterable = ['file', 'size', 'state'];

		},
		props: {
			request_id: Number,
		},
		methods: {
			/**
             * Método que borra todos los datos del formulario
             *
             *
             */
            reset() {
            },

             initRecords(url,modal_id){
            	this.errors = [];
				this.reset();
        		if ($("#" + modal_id).length) {
					$("#" + modal_id).modal('show');
				}
            },
            processFiles() {
                const vm = this;
                var inputFile = document.querySelector('#file');
                formData.append("file", inputFile.files[0]);
                formData.append("request_id", vm.request_id)
                axios.post('/citizenservice/requests/validate-document', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(response => {

                    vm.showMessage(
	                    'custom', 'Éxito', 'success', 'screen-ok',
	                    'Documento cargado de manera existosa.'
	                );
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
		},

	};
</script>
