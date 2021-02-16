<template>
	<section id="assetSubcategoriesComponent">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary"
		   href="#" title="Registros de Subcategorías de Bienes" data-toggle="tooltip"
		   @click="addRecord('add_subcategory', 'asset/subcategories', $event)">
			<i class="icofont icofont-read-book ico-3x"></i>
			<span>Subcategorías</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_subcategory">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-read-book ico-2x"></i>
							Nueva Subcategoría de Bienes
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
							<div class="col-md-4">
								<div class="form-group">
									<label>Tipo de bien:</label>
									<select2 :options="asset_types" @input="getAssetCategories"
											 v-model="record.asset_type_id"></select2>
									<input type="hidden" v-model="record.id">
			                    </div>
							</div>


							<div class="col-md-4">
								<div class="form-group">
									<label>Categoría general:</label>
									<select2 :options="asset_categories"
											 v-model="record.asset_category_id"></select2>
			                    </div>
							</div>

							<div class="col-md-6">
								<div class="form-group is-required">
									<label>Código de la subcategoría:</label>
									<input type="text" placeholder="Código de Subcategoría" data-toggle="tooltip"
										   title="Indique el código de la nueva Subcategoría (requerido)"
										   class="form-control input-sm" v-model="record.code">
			                    </div>
							</div>
							<div class="col-md-6">
								<div class="form-group is-required">
									<label>Subcategoría:</label>
									<input type="text" placeholder="Nueva SubCategoría" data-toggle="tooltip"
										   v-input-mask data-inputmask-regex="[a-zA-ZÁ-ÿ\s]*$"
										   title="Indique la nueva Subcategoría(requerido)"
										   class="form-control input-sm" v-model="record.name">
			                    </div>
							</div>
						</div>
	                </div>
	                <div class="modal-footer">
                        <div class="form-group">
                            <modal-form-buttons :saveRoute="'asset/subcategories'"></modal-form-buttons>
                        </div>
                    </div>
	                <div class="modal-body modal-table">
	                	<hr>
	                	<v-client-table :columns="columns" :data="records" :options="table_options">
	                		<div slot="id" slot-scope="props" class="text-center">
	                			<button @click="initUpdate(props.row.id, $event)"
		                				class="btn btn-warning btn-xs btn-icon btn-action" v-has-tooltip
		                				title="Modificar registro" data-toggle="tooltip" type="button">
		                			<i class="fa fa-edit"></i>
		                		</button>
		                		<button @click="deleteRecord(props.row.id, 'asset/subcategories')"
										class="btn btn-danger btn-xs btn-icon btn-action" v-has-tooltip
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
	</section>
</template>

<script>
	export default {
		data() {
			return {
				record: {
					id: '',
					asset_type_id: '',
					asset_category_id: '',
					code: '',
					name: ''
				},
				errors: [],
				records: [],
				asset_types: [],
				asset_categories: [],
				columns: ['asset_category.name', 'name', 'code', 'id'],
			}
		},
		created() {
			this.table_options.headings = {
				'asset_category.name': 'Categoria General',
				'name': 'Subcategoria',
				'code': 'Código',
				'id': 'Acción'
			};
			this.table_options.sortable = ['asset_category.name','name', 'code'];
			this.table_options.filterable = ['asset_category.name','name', 'code'];
			this.table_options.columnsClasses = {
                'asset_category.name': 'col-xs-4',
                'name': 'col-xs-4',
                'code': 'col-xs-2',
                'id': 'col-xs-2'
            };

		},
		mounted() {
			this.getAssetTypes();
		},
		methods: {
			/**
             * Método que borra todos los datos del formulario
             *
             * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             */
            reset() {
                this.record = {
                    id: '',
					asset_type_id: '',
					asset_category_id: '',
					code: '',
					name: ''
                };
            },
		},
	};
</script>
