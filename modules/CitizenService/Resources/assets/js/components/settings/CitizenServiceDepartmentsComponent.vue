<template>
	<div class="col-xs-2 text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary" href=""
		   title="Registros de departamentos" data-toggle="tooltip"
		   @click="addRecord('add_citizenservice-department', 'citizenservice/departments', $event)">
           <i class="icofont icofont-briefcase-alt-1 ico-3x"></i>
		   <span>Departamentos</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_citizenservice-department">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-briefcase-alt-1 ico-3x"></i>
							Departamentos
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
										   v-input-mask data-inputmask-regex="[a-zA-ZÁ-ÿ0-9\s]*"
        								   class="form-control input-sm" v-model="record.name" data-toggle="tooltip"
        								   title="Indique el nombre del departamento">
        							<input type="hidden" name="id" id="id" v-model="record.id">
        	                    </div>
                            </div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="description">Descripción:</label>
									<input type="text" id="description" placeholder="Descripción"
										   v-input-mask data-inputmask-regex="[a-zA-ZÁ-ÿ0-9\s]*"
										   class="form-control input-sm" v-model="record.description" data-toggle="tooltip"
										   title="Indique la descripción del departamento">
								</div>
							</div>
                        </div>

	                </div>
					<div class="modal-footer">
	                	<div class="form-group">
	                		<modal-form-buttons :saveRoute="'citizenservice/departments'"></modal-form-buttons>
	                	</div>
	                </div>
	                <div class="modal-body modal-table">
	                	<v-client-table :columns="columns" :data="records" :options="table_options">
	                		<div slot="id" slot-scope="props" class="text-center">
	                			<button @click="initUpdate(props.row.id, $event)"
		                				class="btn btn-warning btn-xs btn-icon btn-action"
		                				title="Modificar registro" data-toggle="tooltip" type="button">
		                			<i class="fa fa-edit"></i>
		                		</button>
		                		<button @click="deleteRecord(props.index, 'citizenservice/departments')"
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
					description: ''
				},
				errors: [],
				records: [],
				columns: ['name', 'description', 'id'],
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
					description: ''
				};
			},
			deleteRecord(index, url) {
	            var url = (url)?url:this.route_delete;
	            var records = this.records;
	            var confirmated = false;
	            var index = index - 1;
	            const vm = this;

	            bootbox.confirm({
	                title: "¿Eliminar registro?",
	                message: "¿Está seguro de eliminar este registro?",
	                buttons: {
	                    cancel: {
	                        label: '<i class="fa fa-times"></i> Cancelar'
	                    },
	                    confirm: {
	                        label: '<i class="fa fa-check"></i> Confirmar'
	                    }
	                },
	                callback: function (result) {
	                    if (result) {
	                        confirmated = true;
	                        axios.delete(url + '/' + records[index].id).then(response => {
	                            if (typeof(response.data.error) !== "undefined") {
	                                /** Muestra un mensaje de error si sucede algún evento en la eliminación */
	                                vm.showMessage('custom', 'Alerta!', 'warning', 'screen-error', response.data.message);
	                                return false;
	                            }
	                            records.splice(index, 1);
	                            vm.showMessage('destroy');
	                        }).catch(error => {
	                            vm.logs('mixins.js', 498, error, 'deleteRecord');
	                        });
	                    }
	                }
	            });

	            if (confirmated) {
	                this.records = records;
	                this.showMessage('destroy');
	            }
	        },
		},
		created() {
			this.table_options.headings = {
				'name': 'Nombre',
				'description': 'Descripción',
				'id': 'Acción'
			};
			this.table_options.sortable = ['name'];
			this.table_options.filterable = ['name'];
			this.table_options.columnsClasses = {
				'name': 'col-md-5',
				'description': 'col-md-5',
				'id': 'col-md-2'
			};
		},
	};
</script>
