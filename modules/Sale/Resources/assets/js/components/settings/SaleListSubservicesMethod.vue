<template>
	<div class="text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary" href=""
		   title="Registros de Lista de Subservicios" data-toggle="tooltip"
		   @click="addRecord('add_sale_list_subservices_method', 'sale/list-subservices-method', $event)">
           <i class="icofont icofont-law-document ico-3x"></i>
		   <span>Lista de Subservicios</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_sale_list_subservices_method">
			<div class="modal-dialog vue-crud" role="document"> 
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-law-document ico-3x"></i>
							Lista de Subservicios
						</h6>
					</div>

					<div class="modal-body">
						<div class="alert alert-danger" v-if="errors.length > 0">
							<ul>
								<li v-for="error in errors">{{ error }}</li>
							</ul>
						</div>
                        <div class="row">
                            <div class="col-md-6">
        						<div class="form-group is-required">
        							<label for="name">Nombre:</label>
        							<input type="text" id="name" placeholder="Nombre"
        								   class="form-control input-sm" v-model="record.name" data-toggle="tooltip"
        								   title="Indique el nombre (requerido)">
        							<input type="hidden" name="id" id="id" v-model="record.id">
        	                    </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group is-required">
        							<label for="description">Descripción:</label>
        							<input type="text" id="description" placeholder="Descripción"
        								   class="form-control input-sm" v-model="record.description" data-toggle="tooltip"
        								   title="Indique la descripción (requerido)">
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
								<h6 class="card-title cursor-pointer" @click="addAttribute2()" >
									Gestionar nuevo atributo <i class="fa fa-plus-circle"></i>
								</h6>
							</div>
							<div class="row" style="margin: 20px 0">

								<div class="col-6" v-for="(attribute, index) in record.sale_lists_subservices_attribute">

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
														@click="removeRow(index, record.sale_lists_subservices_attribute)"
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
	                		<modal-form-buttons :saveRoute="'sale/list-subservices-method'"></modal-form-buttons>
	                	</div>
	                </div>
	                <div class="modal-body modal-table">
	                	<v-client-table :columns="columns" :data="records" :options="table_options">
							<div slot="attributes" slot-scope="props">
								<div v-if="props.row.define_attributes">
									<div v-for="att in props.row.sale_type_good_attribute">
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
	                			<button @click="initUpdate(props.row.id, $event)"
		                				class="btn btn-warning btn-xs btn-icon btn-action"
		                				title="Modificar registro" data-toggle="tooltip" type="button">
		                			<i class="fa fa-edit"></i>
		                		</button>
		                		<button @click="deleteRecord(props.row.id, 'sale/list-subservices-method')"
										class="btn btn-danger btn-xs btn-icon btn-action"
										title="Eliminar registro" data-toggle="tooltip"
										type="button">
									<i class="fa fa-trash-o"></i>
								</button>
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
					id: '',
					name: '',
                    description: '',
                    define_attributes: false,
                    sale_lists_subservices_attribute: [],                
				},
				errors: [],
				records: [],
				columns: ['name', 'description', 'attributes', 'id'],
			}
		},
		methods: {
			/**
			 * Método que borra todos los datos del formulario
			 *
			 * @author  Miguel Narvaez <mnarvaez@cenditel.gob.ve>
			 */
			reset() {
				this.record = {
					id: '',
					name: '',
                    description: '',
                    define_attributes: false,
                    sale_lists_subservices_attribute: [],
				};
			},
		addAttribute2()
			{
				var field = {id: '', name: '', sale_list_subservices_id: ''};
				this.record.sale_lists_subservices_attribute.push(field);
			},
		},
		created() {
			this.table_options.headings = {
				'name': 'Nombre',
                'description': 'Descripción',
                'attributes': 'Atributos',
				'id': 'Acción'
			};
			this.table_options.sortable = ['name', 'description'];
			this.table_options.filterable = ['name', 'description'];
			this.table_options.columnsClasses = {
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