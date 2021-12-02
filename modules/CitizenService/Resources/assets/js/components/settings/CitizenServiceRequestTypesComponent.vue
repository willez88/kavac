<template>
	<section id="citizenserviceRequestTypesComponent">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary" href="#"
		   title="Registros de tipo de solicitudes" data-toggle="tooltip"
		   @click="addRecord('add_citizenservice-request-type', 'citizenservice/request-types', $event)">
           <i class="icofont icofont-files ico-3x"></i>
		   <span>Tipo de Solicitud</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_citizenservice-request-type">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-files ico-3x"></i>
							Tipo de solicitud
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
                            <div class="col-md-5">
        						<div class="form-group is-required">
        							<label for="name">Nombre:</label>
        							<input type="text" id="name" placeholder="Nombre"
										   v-input-mask data-inputmask-regex="[a-zA-ZÁ-ÿ\s]*"
        								   class="form-control input-sm" v-model="record.name" data-toggle="tooltip"
        								   title="Indique el nombre de la solicitud requerida">
        							<input type="hidden" name="id" id="id" v-model="record.id">
        	                    </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group is-required">
        							<label for="description">Descripción:</label>
        							<input type="text" id="description" placeholder="Descripción"
										   v-input-mask data-inputmask-regex="[a-zA-ZÁ-ÿ\s]*"
        								   class="form-control input-sm" v-model="record.description" data-toggle="tooltip"
        								   title="Indique la descripción de la solicitud requerida">
        	                    </div>
                            </div>
                        </div>
						<div class="row">
							<div class="col-md-5">
								<div class="form-group is-required">
									<label for="requirement">Requerimientos de solicitud:</label>
									<input type="text" id="requirement" placeholder="Requerimientos de solicitud"
										   v-input-mask data-inputmask-regex="[a-zA-ZÁ-ÿ\s]*"
										   class="form-control input-sm" v-model="record.requirement" data-toggle="tooltip"
										   title="Indique el requerimiento de solicitud">
								</div>
							</div>
						</div>
	                </div>
					<div class="modal-footer">
	                	<div class="form-group">
	                		<modal-form-buttons :saveRoute="'citizenservice/request-types'"></modal-form-buttons>
	                	</div>
	                </div>
	                <div class="modal-body modal-table">
	                	<v-client-table :columns="columns" :data="records" :options="table_options">
							
	                		<div slot="id" slot-scope="props" class="text-center">
	                			<button @click="initUpdate(props.row.id, $event)"
		                				class="btn btn-warning btn-xs btn-icon btn-action"
		                				title="Modificar registro" data-toggle="tooltip" v-has-tooltip type="button">
		                			<i class="fa fa-edit"></i>
		                		</button>
		                		<button @click="deleteRecord(props.row.id, 'citizenservice/request-types')"
										class="btn btn-danger btn-xs btn-icon btn-action"
										title="Eliminar registro" data-toggle="tooltip" v-has-tooltip
										type="button">
									<i class="fa fa-trash-o"></i>
								</button>

	                		</div>
	                	</v-client-table>
	                </div>
		        </div>
		    </div>
		</div>
	</section>
</template>

<script>
	export default {
		data() {
			return {
				record: {
					id: '',
					name: '',
                    description: '',
					requirement: ''
				},
				errors: [],
				records: [],
				columns: ['name', 'description', 'requirement', 'id'],
			}
		},
		methods: {
			/**
			 * Método que borra todos los datos del formulario
			 *
			 *
			 */
			reset() {
				this.record = {
					id: '',
					name: '',
                    description: '',
					requirement: ''
				};
			},
			
		},
		created() {
			this.table_options.headings = {
				'name': 'Nombre',
                'description': 'Descripción',
				'requirement': 'Requerimientos de solicitud',
				'id': 'Acción'
			};
			this.table_options.sortable = ['name'];
			this.table_options.filterable = ['name'];
			this.table_options.columnsClasses = {
				'name': 'col-md-3',
                'description': 'col-md-3',
				'requirement': 'col-md-3',
				'id': 'col-md-2'
			};
		},
	};
</script>
