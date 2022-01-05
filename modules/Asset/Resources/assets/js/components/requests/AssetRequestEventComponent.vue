<template>
	<div>
		<a class="btn btn-success btn-xs btn-icon btn-action"
		   href="#" title="Registros de Eventos" data-toggle="tooltip"
		   :disabled="((state == 'Aprobado')||(state == 'Pendiente por entrega'))?false:true"
		   @click="((state == 'Aprobado')||(state == 'Pendiente por entrega'))?addRecord('add_event', 'asset/requests/request-event', $event):viewMessage()">
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
									<li v-for="error in errors" :key="error">{{ error }}</li>
								</ul>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group is-required">
									<label>Tipo de evento:</label>
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
									<label>Descripción del evento</label>
                                    <ckeditor :editor="ckeditor.editor" id="description_event" data-toggle="tooltip"
                                              title="Indique una descripción del evento" :config="ckeditor.editorConfig"
                                              class="form-control" name="description_event" tag-name="textarea" rows="3"
                                              v-model="record.description"></ckeditor>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6" v-show="record.type == 2">
								<div class="form-group">
									<label> Informe de especificaciones </label>
									<input id="files" name="files" type="file"
										   accept=".docx, .doc, .odt, .pdf" multiple>
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
								<div v-for="type in types" :key="type.id">
									<span v-if="props.row.type == type.id">
										{{ type.text }}
									</span>
								</div>
							</div>
	                		<div slot="id" slot-scope="props" class="text-center">
	                			<button @click="initUpdate(props.row.id, $event)"
		                				class="btn btn-warning btn-xs btn-icon btn-action"
		                				title="Modificar registro" data-toggle="tooltip" type="button">
		                			<i class="fa fa-edit"></i>
		                		</button>
		                		<button @click="deleteRecord(props.row.id, 'requests/request-event')"
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
	                	<button type="button" @click="createRecord('asset/requests/request-event')"
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
					id:'',
					type: '',
					asset_request_id: '',
					description: '',
					equipments: []

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
					else {
						checkbox.click();
                    }
				}
				else if ((checkbox)&&(checkbox.checked == true)) {
					var index = vm.selected.indexOf(row.asset_id);
					if (index >= 0) {
						checkbox.click();
                    }
					else {
						vm.selected.push(row.asset_id);
                    }
				}
		    },
		    select()
			{
				const vm = this;
				vm.selected = [];
				$.each(vm.equipments, function(index,campo){
					var checkbox = document.getElementById('checkbox_' + campo.asset_id);

					if(!vm.selectAll) {
						vm.selected.push(campo.asset_id);
                    }
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
					equipments: []
				};
			},
			/**
             * Reescribe el método createRecord para cambiar su comportamiento por defecto
             * Método que permite crear o actualizar un registro
             *
             * @author    Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             *
             * @param     {string}    url      Ruta de la acción a ejecutar para la creación o actualización de datos
             * @param     {string}    list     Condición para establecer si se cargan datos en un listado de tabla.
             *                                 El valor por defecto es verdadero.
             * @param     {string}    reset    Condición que evalúa si se inicializan datos del formulario.
             *                                 El valor por defecto es verdadero.
             */
            createRecord(url, list = true, reset = true) {
				const vm = this;
				if(!vm.selected.length > 0){
                	bootbox.alert("Debe agregar almenos un elemento a la solicitud");
					return false;
				};
				var inputFiles = document.querySelector('#files');
				var formData   = new FormData();

				vm.errors = [];
				vm.record.asset_request_id = vm.id;
				vm.record.equipments = vm.selected;

	            if (vm.record.id) {
	                vm.updateRecord(url);
	            } else {
	                vm.loading = true;

	                for (var index in vm.record) {
	                	if (index == 'equipments') {
	                		formData.append(index, JSON.stringify(vm.record[index]));
	                	}else {
	                		formData.append(index, vm.record[index]);
	                	}
	                }
	                for( var i = 0; i < inputFiles.files.length; i++ ){
					  let file = inputFiles.files[i];

					  formData.append('files[' + i + ']', file);
					}
					url = vm.setUrl(url);
	                axios.post(url, formData, {
                    	headers: {
                        	'Content-Type': 'multipart/form-data'
                    	}
                	}).then(response => {
	                    if (typeof(response.data.redirect) !== "undefined") {
	                        location.href = response.data.redirect;
	                    }
	                    else {
	                    	vm.errors = [];
                            if (reset) {
                                vm.reset();
                            }
                            if (list) {
                                vm.readRecords(url);
                            }
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
				const vm = this;
				axios.get(`${window.app_url}/asset/get-request-types`).then(response => {
					vm.types = response.data;
				});
			},
			getEquipments() {
				const vm = this;
				axios.get(`${window.app_url}/asset/requests/get-equipments/${vm.id}`).then(response => {
					vm.equipments = response.data;
				});
			},
			viewMessage() {
            	const vm = this;
            	vm.showMessage(
                    'custom', 'Alerta', 'danger', 'screen-error',
                    'La solicitud está en un tramite que no le permite acceder a esta funcionalidad'
                );
            	return false;
            },
		},
		mounted() {
            const vm = this;
            $("#add_event").on('show.bs.modal', function() {
                vm.reset();
                vm.getTypes();
				vm.getEquipments();
            });
        },
		created() {
			//
		},
	};
</script>
