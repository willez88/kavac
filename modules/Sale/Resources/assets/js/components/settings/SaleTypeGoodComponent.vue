<template>
	<div class="col-xs-2 text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary"
		   href="#" title="Registro de Tipo de bien" data-toggle="tooltip"
		   @click="addRecord('add_type_good', 'sale/type-good', $event)">
			<i class="icofont icofont-cubes ico-3x"></i>
			<span>Tipo de bien</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_type_good">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<!-- <button type="button" data-toggle="tooltip"
                                class="btn btn-primary btn-xs btn-icon btn-action"
                                style="margin-right: 3.5rem; margin-top: -.1rem;"
                                title="Presione para subir los registros mediante hoja de cálculo."
                                @click="setFile('importFile')">
                            <i class="fa fa-upload"></i>
                        </button>
                        <input  id="importFile" name="importFile"
                        		type="file" style="display:none;"
                        		@change="importData()">

                        <button type="button" data-toggle="tooltip"
                                class="btn btn-primary btn-xs btn-icon btn-action"
                                style="margin-right: 1.5rem; margin-top: -.1rem;"
                                title="Presione para descargar el documento con la información de los registros."
                                @click="exportData()">
                            <i class="fa fa-download"></i>
                        </button> -->
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-cubes ico-2x"></i>
							Registros de tipo de bien
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
									<li v-for="(error, index) in errors" :key="index">{{ error }}</li>
								</ul>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<b>Datos del Tipo de Bien</b>
							</div>

							<div class="col-md-6">
								<div class="form-group is-required">
									<label>Nombre:</label>
									<input type="text" placeholder="Nombre del tipo de bien" data-toggle="tooltip"
										   title="Indique el nombre del tipo de bien (requerido)"
										   class="form-control input-sm" v-model="record.name">
									<input type="hidden" v-model="record.id">
			                    </div>
							</div>

							<div class="col-md-6">
								<div class="form-group is-required">
									<label>Descripción:</label>
                                    <textarea id="description" 
                                              :class="'form-control'"
                                              @input="delete errors['description'];"
                                              type="text" name="description" aria-labelledby="description_label"   aria-describedby=""       value="" data-toggle="tooltip"
                                              title="Indique una breve descripción del tipo de bien (requerido)" tabindex="1" rows="3" required
                                              v-model="record.description">
                                    </textarea>
			                    </div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<a  data-toggle="tooltip"
				                        title="Establecer los atributos del tipo de bien para gestionar las variantes">
				                        <label for="" class="control-label">Atributos Personalizados</label>
				                        <div class="col-12">
                                            <div class="bootstrap-switch-mini">
        										<input type="checkbox" class="form-control bootstrap-switch"
        											name="define_attributes"
        											data-on-label="Si" data-off-label="No" value="true"
        											v-model="record.define_attributes">
                                            </div>
    									</div>
				                    </a>
								</div>
							</div>
						</div>
						<div v-show="this.record.define_attributes">
							<div class="row" style="margin: 10px 0">
								<h6 class="card-title cursor-pointer" @click="addAttribute()" >
									Gestionar nuevo atributo <i class="fa fa-plus-circle"></i>
								</h6>
							</div>
							<div class="row" style="margin: 20px 0">

								<div class="col-6" v-for="(attribute, index) in record.sale_type_good_attribute" :key="index">

									<div class="d-inline-flex">
										<div class="col-10">
											<div class="form-group">
												<input type="text" placeholder="Nombre del nuevo atributo" data-toggle="tooltip"
													   title="Indique el nombre del atributo del tipo de bien que desee hacer seguimiento (opcional)"
													   v-model="attribute.name" class="form-control input-sm">
											</div>
										</div>
										<div class="col-2">
											<div class="form-group">
												<button class="btn btn-sm btn-danger btn-action" type="button"
														@click="removeRow(index, record.sale_type_good_attribute)"
														title="Eliminar este dato" data-toggle="tooltip">
													<i class="fa fa-minus-circle"></i>
												</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
			        </div>
			        <div class="modal-footer">
                        <div class="form-group">
                            <button type="button" class="btn btn-default btn-sm btn-round btn-modal-close" 
									@click="clearFilters" data-dismiss="modal">
								Cerrar
							</button>
							<button type="button" class="btn btn-warning btn-sm btn-round btn-modal btn-modal-clear" 
									@click="reset()">
								Cancelar
							</button>
							<button type="button" @click="createRecord('sale/type-good')" 
									class="btn btn-primary btn-sm btn-round btn-modal-save">
								Guardar
							</button>
                        </div>
                    </div>
	                <div class="modal-body modal-table">
	                	<hr>
						<v-client-table :columns="columns" :data="records" :options="table_options">
							<div slot="attributes" slot-scope="props">
								<div v-if="props.row.define_attributes">
									<div v-for="(att, index) in props.row.sale_type_good_attribute" :key="index">
										<span>
											{{ att.name }}
										</span>
									</div>
								</div>
								<div v-else>
									<span>N/A</span>
								</div>
							</div>
	                		<div slot="id" slot-scope="props" class="text-center">
		                		<div class="d-inline-flex">
		                			<button @click="initUpdate(props.row.id, $event)"
			                				class="btn btn-warning btn-xs btn-icon btn-action"
			                				title="Modificar registro" data-toggle="tooltip" type="button">
			                			<i class="fa fa-edit"></i>
			                		</button>
			                		<button @click="deleteRecord(props.row.id, 'sale/type-good')"
											class="btn btn-danger btn-xs btn-icon btn-action"
											title="Eliminar registro" data-toggle="tooltip"
											type="button">
										<i class="fa fa-trash-o"></i>
									</button>
		                		</div>
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
					id:'',
					name: '',
					description: '',
					define_attributes: false,
					sale_type_good_attribute: [],
				},

				errors: [],
				records: [],
				columns: ['name', 'description', 'attributes', 'id'],
				// formImport: false,

			}
		},
		methods: {
			/**
			 * Método que borra todos los datos del formulario
			 *
			 * @author  Daniel Contreras <dcontreras@cenditel.gob.ve>
			 */
			reset()
			{
				this.record = {
					id: '',
					name: '',
					description: '',
					define_attributes: false,
					sale_type_good_attribute: []
				};
			},
			/**
			 * Método que agrega un nuevo campo de atributo al formulario
			 *
			 * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
			 */
			addAttribute()
			{
				var field = {id: '', name: '', sale_type_good_id: ''};
				this.record.sale_type_good_attribute.push(field);
			},
			// exportData() {
            //     //instrucciones para exportar registros
            //     location.href = '/sale/type-good/export/all';
            // },
            // importData() {
            //     //instrucciones para exportar registros
            //     const vm = this;
            //     var url = '/sale/type-good/import/all' ;
	        //     var formData = new FormData();
	        //     var importFile = document.querySelector('#importFile');
	        //     formData.append("file", importFile.files[0]);
	        //     vm.loading = true;
	        //     axios.post(url, formData, {
	        //         headers: {
	        //             'Content-Type': 'multipart/form-data'
	        //         }
	        //     }).then(response => {
	        //     	console.log('exit');
	        //     	vm.loading = false;
	        //     	vm.showMessage('store');
	        //     }).catch(error => {
	        //         console.log('failure');
	        //         vm.loading = false;

	        //     });
            // }
		},
		created() {
			const vm = this;
			vm.table_options.headings = {
				'name': 'Nombre',
				'description': 'Descripción',
				'attributes': 'Atributos',
				'id': 'Acción'
			};
			vm.table_options.sortable = ['name', 'description'];
			vm.table_options.filterable = ['name', 'description'];
			vm.table_options.columnsClasses = {
                'name': 'col-xs-2',
                'description': 'col-xs-4',
                'attributes': 'col-xs-4',
                'id': 'col-xs-2'
            };
		},
		mounted() {
			const vm = this;
			vm.switchHandler('define_attributes');
		}
	};
</script>
