<template>
	<div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 mt-2 mb-2 text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary"
		   href="javascript:void(0)" title="Registros de Parroquias de un Municipio"
		   data-toggle="tooltip" @click="addRecord('add_parish', 'parishes', $event)">
			<i class="icofont icofont-map-pins ico-3x"></i>
			<span>Parroquias</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_parish">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-map-pins inline-block"></i>
							Parroquias
						</h6>
					</div>
					<div class="modal-body">
						<div class="alert alert-danger" v-if="errors.length > 0">
							<ul>
								<li v-for="error in errors">{{ error }}</li>
							</ul>
						</div>
						<div class="row">
							<div class="col-12 col-md-4">
								<div class="form-group">
									<label>Pais:</label>
									<select2 :options="countries" @input="getEstates"
											 v-model="record.country_id"></select2>
									<input type="hidden" v-model="record.id">
			                    </div>
							</div>
							<div class="col-12 col-md-4">
								<div class="form-group">
									<label>Estados:</label>
									<select2 :options="estates" @input="getMunicipalities"
											 v-model="record.estate_id"></select2>
			                    </div>
							</div>
							<div class="col-12 col-md-4">
								<div class="form-group">
									<label>Municipios:</label>
									<select2 :options="municipalities" v-model="record.municipality_id">
									</select2>
			                    </div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group is-required">
									<label>Código:</label>
									<input type="text" placeholder="Código de Parroquia" data-toggle="tooltip"
										   title="Indique el código de la Parroquia (requerido)"
										   class="form-control input-sm" v-model="record.code" v-is-digits>
			                    </div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group is-required">
									<label>Nombre:</label>
									<input type="text" placeholder="Nombre de Parroquia" data-toggle="tooltip"
										   title="Indique el nombre de la Parroquia (requerido)"
										   class="form-control input-sm" v-model="record.name" v-is-text>
			                    </div>
							</div>
						</div>
	                </div>
	                <div class="modal-footer">
	                	<div class="form-group">
	                		<modal-form-buttons :saveRoute="'parishes'"></modal-form-buttons>
	                	</div>
	                </div>
	                <div class="modal-body modal-table">
	                	<!--<v-client-table :columns="columns" :data="records" :options="table_options">
	                		<div slot="id" slot-scope="props" class="text-center">
	                			<button @click="initUpdate(props.row.id, $event)"
		                				class="btn btn-warning btn-xs btn-icon btn-action"
		                				title="Modificar registro" data-toggle="tooltip" type="button">
		                			<i class="fa fa-edit"></i>
		                		</button>
		                		<button @click="deleteRecord(props.row.id, 'parishes')"
										class="btn btn-danger btn-xs btn-icon btn-action"
										title="Eliminar registro" data-toggle="tooltip"
										type="button">
									<i class="fa fa-trash-o"></i>
								</button>
	                		</div>
	                	</v-client-table>-->
                        <v-server-table :url="'parishes'" :columns="columns" :options="table_options"
                                        ref="tableResults">
                            <div slot="id" slot-scope="props" class="text-center">
                                <button @click="initUpdate(props.row.id, $event)"
                                        class="btn btn-warning btn-xs btn-icon btn-action"
                                        title="Modificar registro" data-toggle="tooltip" type="button">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button @click="deleteRecord(props.row.id, 'parishes')"
                                        class="btn btn-danger btn-xs btn-icon btn-action"
                                        title="Eliminar registro" data-toggle="tooltip"
                                        type="button">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                            </div>
                        </v-server-table>
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
					country_id: '',
					estate_id: '',
					municipality_id,
					name: '',
					code: ''
				},
                recordEdit: {},
                selectedEstateId: '',
                selectedMunicipalityId: '',
				errors: [],
				records: [],
				countries: [],
				estates: ['0'],
				municipalities: ['0'],
				columns: ['municipality.estate.name', 'municipality.name', 'name', 'code', 'id'],
			}
		},
        watch: {
            estates() {
                const vm = this;
                if (vm.record.id && !vm.record.estate_id) {
                    vm.record.estate_id = vm.recordEdit.municipality.estate.id;
                }
            },
            municipalities() {
                const vm = this;
                if (vm.record.id && !vm.record.municipality_id) {
                    vm.record.municipality_id = vm.recordEdit.municipality.id;
                }
            }
        },
		methods: {
			/**
			 * Método que borra todos los datos del formulario
			 *
			 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
			 */
			reset() {
                const vm = this;
				vm.record = {
					id: '',
					country_id: '',
					estate_id: '',
					municipality_id: '',
					name: '',
					code: ''
				};
                vm.selectedEstateId = '';
                vm.selectedMunicipalityId = '';
			},
            /**
             * Método que carga el formulario con los datos a modificar
             *
             * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             *
             * @param  {integer} index Identificador del registro a ser modificado
             * @param {object} event   Objeto que gestiona los eventos
             */
            async initUpdate(id, event) {
                let vm = this;
                vm.errors = [];

                let recordEdit = JSON.parse(JSON.stringify(vm.$refs.tableResults.data.filter((rec) => {
                    return rec.id === id;
                })[0])) || vm.reset();

                vm.recordEdit = recordEdit;
                vm.record = recordEdit;
                vm.record.country_id = recordEdit.municipality.estate.country.id;
                /*vm.record.estate_id = recordEdit.municipality.estate.id;
                vm.record.municipality_id = recordEdit.municipality.id;*/
                /*vm.selectedEstateId = recordEdit.municipality.estate.id;
                vm.selectedMunicipalityId = recordEdit.municipality.id;*/
                event.preventDefault();
            }
		},
		created() {
			this.table_options.headings = {
                'municipality.estate.name': 'Estado',
				'municipality.name': 'Municipio',
				'name': 'Parroquia',
				'code': 'Código',
				'id': 'Acción'
			};
			this.table_options.sortable = ['municipality.estate.name', 'municipality.name', 'name', 'code'];
			this.table_options.filterable = ['municipality.estate.name', 'municipality.name', 'name', 'code'];
			this.table_options.columnsClasses = {
                'municipality.estate.name': 'col-md-3',
				'municipality.name': 'col-md-3',
				'name': 'col-md-3',
				'code': 'col-md-1',
				'id': 'col-md-2'
			};
		},
		async mounted() {
			let vm = this;
            await vm.$nextTick();
            $("#add_parish").on('show.bs.modal', function() {
                vm.getCountries();
			});
		}
	};
</script>
