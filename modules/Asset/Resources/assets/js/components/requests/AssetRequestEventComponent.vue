<template>
	<div>
		<a class="btn btn-success btn-xs btn-icon btn-action"
		   href="#" title="Registros de Eventos" data-toggle="tooltip"
		   :disabled="((state == 'Aprobado')||(state == 'Pendiente por entrega'))?false:true"
		   @click="((state == 'Aprobado')||(state == 'Pendiente por entrega'))?addRecord('add_event', 'requests/request-event', $event):viewMessage()">
		   <i class="fa fa-list-alt"></i>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_event">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-tasks-alt ico-2x"></i>
							Nuevo Evento
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
									<label>Tipo de Evento:</label>
									<select2 :options="types"
											 data-toggle="tooltip"
											 title="Indique el tipo de evento ocurrido"
											 v-model="record.type">
									</select2>

									<input type="hidden" v-model="record.id">
			                    </div>
							</div>
							<div class="col-md-6">
								<div class="form-group is-required">
									<label>Descripción del Evento</label>
                                    <ckeditor :editor="ckeditor.editor" id="description_event" data-toggle="tooltip"
                                              title="Indique una descripción del evento" :config="ckeditor.editorConfig"
                                              class="form-control" name="description_event" tag-name="textarea" rows="3"
                                              v-model="record.description"></ckeditor>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6" v-show="record.type == 2">
								<input type="hidden" id="documents" name="documents" readonly>
								<div class="form-group is-required">
									<div class="feature-list-content p-0">
					                    <div class="feature-list-content-wrapper">
					                        <div class="feature-list-content-left">
					                            <div class="feature-list-heading">
					                            	<label>Informe de Especificación:</label>
					                                <div class="badge badge-danger ml-2"
					                                	 title="El documento aún no ha sido cargado"
					                                	 data-toggle="tooltip">
					                                	por cargar
					                                </div>
					                            </div>
					                            <div class="feature-list-subheading">
					                            	<i>Operaciones</i>
					                            </div>
					                        </div>
					                        <div class="feature-list-content-right feature-list-content-actions">
					                        	<button class="btn btn-simple btn-success btn-events"
					                        			title="Presione para cargar el documento"
					                        			data-toggle="tooltip" type="button"
					                        			onclick="$('#file').click()">
					                        		<i class="fa fa-cloud-upload fa-2x"></i>
					                        	</button>
					                        	<button class="btn btn-simple btn-primary btn-events"
					                        			title="Presione para descargar el documento"
					                        			data-toggle="tooltip" type="button">
					                        		<i class="fa fa-cloud-download fa-2x"></i>
					                        	</button>
				                                <button class="btn btn-sm btn-danger btn-action" type="button"
				                                        title="Eliminar documento" data-toggle="tooltip">
				                                    <i class="fa fa-minus-circle"></i>
				                                </button>
												<input type="file" id="file" name="file" style="display:none"
					                        		   accept=".doc, .pdf, .odt, .docx" @change="processFile()">
					                        </div>
					                    </div>
					                </div>
			                    </div>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-md-12">
								<b>Seleccione los equipos afectados</b>
							</div>
							<div class="col-md-12">
								<v-client-table @row-click="toggleActive"
		                						:columns="columns_equipments"
		                						:data="equipments"
		                						:options="table_options"
		                						ref="tableevent">
			                		<div slot="h__check" class="text-center">
										<label class="form-checkbox">
											<input  type="checkbox"
													v-model="selectAll"
													@click="select()"
													class="cursor-pointer">
										</label>
									</div>

									<div slot="check" slot-scope="props" class="text-center">
										<label class="form-checkbox">
											<input type="checkbox" class="cursor-pointer" :value="props.row.asset_id"
												:id="'checkbox_'+ props.row.asset_id" v-model="selected">
										</label>
									</div>
			                	</v-client-table>
							</div>
						</div>
	                </div>

	                <div class="modal-body modal-table">
	                	<hr>
	                	<v-client-table :columns="columns" :data="records" :options="table_options">
	                		<div slot="type" slot-scope="props" class="text-center">
								<div v-for="type in types">
									<span v-if="props.row.type == type.id">
										{{ type.text }}
									</span>
								</div>
							</div>
	                		<div slot="id" slot-scope="props" class="text-center">
	                			<button @click="initUpdate(props.index, $event)"
		                				class="btn btn-warning btn-xs btn-icon btn-action"
		                				title="Modificar registro" data-toggle="tooltip" type="button">
		                			<i class="fa fa-edit"></i>
		                		</button>
		                		<button @click="deleteRecord(props.index, 'requests/request-event')"
										class="btn btn-danger btn-xs btn-icon btn-action"
										title="Eliminar registro" data-toggle="tooltip"
										type="button">
									<i class="fa fa-trash-o"></i>
								</button>
	                		</div>
	                	</v-client-table>
	                </div>

	                <div class="modal-footer">

		                <button type="button" class="btn btn-default btn-sm btn-round btn-modal-close"
	                			data-dismiss="modal">
	                		Cerrar
	                	</button>
	                	<button type="button" @click="createRequest('asset/requests/request-event')"
	                			class="btn btn-primary btn-sm btn-round btn-modal-save">
	                		Guardar
		                </button>
		            </div>
		        </div>
		    </div>
		</div>
	</div>
</template>

<style>
	.selected-row {
		background-color: #d1d1d1 !important;
	}
</style>

<script>
	var formData = new FormData();
	export default {
		data() {
			return {
				record: {
					id:'',
					type: '',
					asset_request_id: '',
					description: '',
					equipments: [],
					document_id: ''

				},
				types: [],
				equipments: [],
				records: [],
				errors: [],
				columns: ['type', 'description', 'id'],
				columns_equipments: ['check', 'asset.inventory_serial','asset.serial','asset.marca','asset.model'],

				selected: [],
				selectAll: false,

				table_options: {
					rowClassCallback(row) {
						var checkbox = document.getElementById('checkbox_' + row.asset_id);
						return ((checkbox)&&(checkbox.checked))? 'selected-row cursor-pointer' : 'cursor-pointer';
					},
					headings: {
						'type': 'Tipo',
						'description': 'Descripción',
						'id': 'Acción',
						'asset.inventory_serial': 'Código',
						'asset.serial': 'Serial',
						'asset.marca': 'Marca',
						'asset.model': 'Modelo',
					},
					sortable: ['type','asset.inventory_serial', 'asset.serial', 'asset.marca', 'asset.model'],
					filterable: ['type','asset.inventory_serial', 'asset.serial', 'asset.marca', 'asset.model']
				}
			}
		},
		props: {
			id: Number,
			state: String,
		},
		methods: {
			toggleActive({ row })
			{
				const vm = this;
				var checkbox = document.getElementById('checkbox_' + row.asset_id);

				if((checkbox)&&(checkbox.checked == false)){
					var index = vm.selected.indexOf(row.asset_id);
					if (index >= 0){
						vm.selected.splice(index,1);
					}
					else
						checkbox.click();
				}
				else if ((checkbox)&&(checkbox.checked == true)) {
					var index = vm.selected.indexOf(row.asset_id);
					if (index >= 0)
						checkbox.click();
					else
						vm.selected.push(row.asset_id);
				}
		    },
		    select()
			{
				const vm = this;
				vm.selected = [];
				$.each(vm.equipments, function(index,campo){
					var checkbox = document.getElementById('checkbox_' + campo.asset_id);

					if(!vm.selectAll)
						vm.selected.push(campo.asset_id);
					else if(checkbox && checkbox.checked){
						checkbox.click();
					}
				});
			},
			/**
			 * Método que borra todos los datos del formulario
			 *
			 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
			 */
			reset() {
				this.record = {
					id:'',
					type: '',
					asset_request_id: '',
					description: '',
					equipments: [],
					document_id: ''
				};
			},
			createRequest(url) {
				const vm = this;
				vm.record.asset_request_id = vm.id;
				vm.record.equipments = vm.selected;
	            if (vm.record.id) {
	                vm.updateRecord(url);
	            } else {
	                vm.loading = true;

	                for (var index in this.record) {
	                	if (index == 'equipments') {
	                		formData.append(index, JSON.stringify(vm.record[index]));
	                	}else {
	                		formData.append(index, vm.record[index]);
	                	}
	                }
	                axios.post('/' + url, formData, {
                    	headers: {
                        	'Content-Type': 'multipart/form-data'
                    	}
                	}).then(response => {
	                    if (typeof(response.data.redirect) !== "undefined") {
	                        location.href = response.data.redirect;
	                    }
	                    else {
	                        vm.errors = [];
	                        vm.reset();
	                        vm.readRecords(url);
	                        vm.loading = false;
	                        vm.showMessage('store');
	                    }

	                }).catch(error => {
	                    vm.errors = [];

	                    if (typeof(error.response) !="undefined") {
	                        for (var index in error.response.data.errors) {
	                            if (error.response.data.errors[index]) {
	                                vm.errors.push(error.response.data.errors[index][0]);
	                            }
	                        }
	                    }
	                    vm.loading = false;
	                });
	            }
			},

			getTypes() {
				axios.get('/asset/get-request-types').then(response => {
					this.types = response.data;
				});
			},
			getEquipments() {
				axios.get('/asset/requests/get-equipments/' + this.id).then(response => {
					this.equipments = response.data;
				});
			},
			viewMessage() {
            	const vm = this;
            	vm.showMessage('custom', 'Alerta', 'danger', 'screen-error', 'La solicitud está en un tramite que no le permite acceder a esta funcionalidad');
            	return false;
            },
            processFile() {
                const vm = this;
                var inputFile = document.querySelector('#file');
                formData.append("file", inputFile.files[0]);
                vm.showMessage(
                    'custom', 'Éxito', 'success', 'screen-ok',
                    'Documento cargado de manera existosa.'
                );
                return;
                axios.post('/asset/requests/validate-document', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(response => {

                    if ( ! response.data.result) {
                        vm.showMessage(
                            'custom', 'Error', 'danger', 'screen-error',
                            response.data.message
                        );
                    } else {

                    }
                }).catch(error => {
                    if (typeof(error.response) !== "undefined") {
                        if (error.response.status == 422 || error.response.status == 500) {
                            vm.showMessage(
                                'custom',
                                'Error',
                                'danger',
                                'screen-error',
                                "El documento debe ser un archivo en formato: .doc, .pdf, .odt, .docx"
                            );
                        }
                    }
                });
			},
		},
		created() {
			this.getTypes();
			this.getEquipments();
			this.record.equipments = [];
		},
	}
</script>
