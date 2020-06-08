<template>
	<section id="PayrollSalaryScalesFormComponent">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary"
		   href="#" title="Registros de los escalafones salariales" data-toggle="tooltip"
		   @click="addRecord('add_payroll_salary_scale', 'salary-scales', $event)">
		   <i class="icofont icofont-growth ico-3x"></i>
			<span>Escalafones Salariales</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_payroll_salary_scale">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-growth ico-2x"></i>
							 Escalafón Salarial
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
								<div class="row">
									<div class="col-md-12">
										<!-- nombre -->
										<div class="form-group is-required">
											<label for="name">Nombre:</label>
											<input type="text" id="name" placeholder="Nombre del escalafón salarial"
												   class="form-control input-sm" data-toggle="tooltip"
												   title="Indique el nombre del nuevo escalafón salarial (requerido)"
												   v-model="record.name">
											<input type="hidden" v-model="record.id">
					                    </div>
					                    <!-- ./nombre -->
									</div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<!-- activa -->
			                            <div class="form-group">
			                                <label for="active">¿Activa?</label>
			                                <div class="col-12">
                                                <p-check class="pretty p-switch p-fill p-bigger"
                                                         color="success" off-color="text-gray" toggle
                                                         data-toggle="tooltip"
                                                         title="Indique si el escalafón está activo"
                                                         v-model="record.active">
                                                    <label slot="off-label"></label>
                                                </p-check>
			                                </div>
			                            </div>
			                            <!-- ./activa -->
									</div>
									<div class="col-md-8">
										<!-- institución -->
										<div class="form-group is-required">
											<label for="institution">Institución:</label>
											<select2 :options="institutions"
													 v-model="record.institution_id"></select2>
					                    </div>
					                    <!-- ./institución -->
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-12">
                                        <!-- descripción -->
										<div class="form-group">
											<label>Descripción:</label>
                                            <ckeditor :editor="ckeditor.editor" id="description"
                                                      data-toggle="tooltip"
                                                      title="Indique alguna descripción asociada al escalafón"
                                                      :config="ckeditor.editorConfig" class="form-control"
                                                      name="description" tag-name="textarea"
                                                      v-model="record.description"></ckeditor>
					                    </div>
                                        <!-- ./descripción -->
									</div>
								</div>
							</div>
						</div>
                        <div class="container">
                            <h6 class="text-center">Agrupar por</h6>
                            <div class="row" style="align-items: flex-end;">
                                <div class="col-3 col-md-3"
                                     v-for="field in payroll_salary_tabulators_groups">
                                    <div class="form-group">
                                        <label>{{ field.name }}</label>
                                        <div class="col-12">
                                            <div class="pretty p-switch p-fill p-bigger p-toggle">
                                                <input type="radio"
                                                       @input="getOptions(field)"
                                                       v-model="record.group_by" :value="field.code">
                                                <div class="state p-off">
                                                    <label></label>
                                                </div>
                                                <div class="state p-on p-success">
                                                    <label></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="alert alert-danger" v-if="payroll_salary_tabulators_groups.length == 0">
                                    <div class="container">
                                        <strong>No se ha registrado ninguna agrupación</strong> Debe dirigirse a Configuración de parámetros de nómina y registrar al menos un grupo de tablas salariales antes de continuar.
                                    </div>
                                </div>
                                <div class="col-7 pad-top-10 with-border with-radius table-responsive"
                                     v-if="payroll_salary_tabulators_groups.length > 0">
                                    <h6 class="text-center">Escalas o Niveles del Escalafón</h6>
                                    <div class="row" v-if="record.payroll_scales.length == 0">
                                        <div class="alert alert-danger">
                                            <div class="container">
                                                <strong>No existen registros</strong> Debe seleccionar una agrupación y agregar una nueva escala antes de continuar.
                                            </div>
                                        </div>
                                    </div>
                                    <div v-show="record.payroll_scales.length > 0">
                                        <table class="table table-hover table-striped table-responsive  table-scale">
                                            <thead>
                                                <th :colspan="1 + record.payroll_scales.length">
                                                    <strong>{{ record.name }}</strong>
                                                </th>
                                            </thead>
                                            <tbody>
                                                <tr class="selected-row text-center">
                                                    <th>{{ getGroupBy }}</th>
                                                    <th v-for="(field,index) in record.payroll_scales">
                                                        <span v-if="type == 'list'
                                                                 && options.length > 0">
                                                            {{ getValueScale(field.value) }}
                                                        </span>
                                                        <span v-else-if="type == 'range'">
                                                            {{ field.value['from'] + ' - ' + field.value['to'] }}
                                                        </span>
                                                        <span v-else>
                                                            {{ field.value }}
                                                        </span>
                                                    </th>
                                                </tr>
                                                <tr class="selected-row text-center">
                                                    <th>Nombre</th>
                                                    <td v-for="(field,index) in record.payroll_scales">
                                                        {{ field.name}}
                                                    </td>
                                                </tr>
                                                <tr class="config-row text-center">
                                                    <th>Acción:</th>
                                                    <td v-for="(field,index) in record.payroll_scales">
                                                        <div class="d-inline-flex">
                                                            <button @click="editScale(index,$event)"
                                                                    class="btn btn-warning btn-xs btn-icon btn-action"
                                                                    title="Modificar registro" data-toggle="tooltip" type="button">
                                                                <i class="fa fa-edit"></i>
                                                            </button>
                                                            <button @click="removeScale(index,$event)"
                                                                    class="btn btn-danger btn-xs btn-icon btn-action"
                                                                    title="Eliminar registro" data-toggle="tooltip"
                                                                    type="button">
                                                                <i class="fa fa-trash-o"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-4 offset-1 pad-top-10 with-border with-radius table-responsive"
                                     v-if="payroll_salary_tabulators_groups.length > 0">
                                    <h6 class="text-center">Nueva Escala</h6>
                                    <div class="row"
                                        v-if="record.group_by">
                                        <div class="col-md-12">
                                            <div class="form-group is-required">
                                                <label>Nombre</label>
                                                <input type="text" placeholder="Nombre" data-toggle="tooltip"
                                                       title="Indique un nombre para identificar la agrupación"
                                                       class="form-control input-sm" v-model="scale.name">
                                                <input type="hidden" v-model="scale.id">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="align-items: flex-end;"
                                         v-if="record.group_by">
                                        <div class="col-md-12"
                                             v-if="type == 'list'">
                                            <div class="form-group">
                                                <label>Valor:</label>
                                                <select2 :options="options"
                                                         v-model="scale.value"></select2>
                                            </div>
                                        </div>
                                        <b class="col-md-12 text-center"
                                           v-if="type != 'list'">
                                            Expresado en
                                        </b>
                                        <div class="col-4 col-md-4"
                                             v-if="type != 'list'">
                                            <div class="form-group">
                                                <label>Valor Puntual</label>
                                                <div class="col-12">
                                                    <div class="pretty p-switch p-fill p-bigger p-toggle">
                                                        <input type="radio" data-toggle="tooltip"
                                                               title="Indique si el valor está expresado puntualmente"
                                                               @input="resetType()"
                                                               v-model="type" value="value">
                                                        <div class="state p-off">
                                                            <label></label>
                                                        </div>
                                                        <div class="state p-on p-success">
                                                            <label></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4 col-md-4"
                                             v-if="type != 'list'">
                                            <div class="form-group">
                                                <label>Rango</label>
                                                <div class="col-12">
                                                    <div class="pretty p-switch p-fill p-bigger p-toggle">
                                                        <input type="radio" data-toggle="tooltip"
                                                               title="Indique si el valor está expresado en rangos"
                                                               @input="resetType('range')"
                                                               v-model="type" value="range">
                                                        <div class="state p-off">
                                                            <label></label>
                                                        </div>
                                                        <div class="state p-on p-success">
                                                            <label></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4 col-md-4"
                                             v-if="type != 'list'">
                                            <div class="form-group">
                                                <label>Booleano</label>
                                                <div class="col-12">
                                                    <div class="pretty p-switch p-fill p-bigger p-toggle">
                                                        <input type="radio" data-toggle="tooltip"
                                                               title="Indique si el valor está expresado en bool"
                                                               @input="resetType()"
                                                               v-model="type" value="boolean">
                                                        <div class="state p-off">
                                                            <label></label>
                                                        </div>
                                                        <div class="state p-on p-success">
                                                            <label></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12"
                                             v-if="type == 'value'">
                                            <div class="form-group is-required">
                                                <label>Valor</label>
                                                <input type="number" placeholder="Valor"
                                                       class="form-control input-sm" data-toggle="tooltip"
                                                       title="Indique la cantidad (requerido)"
                                                       v-model="scale.value">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12"
                                             v-if="type == 'range'">
                                            <div class="form-group is-required">
                                                <label>Desde</label>
                                                <input type="number" placeholder="Valor"
                                                       class="form-control input-sm" data-toggle="tooltip"
                                                       title="Indique la cantidad (requerido)"
                                                       v-model="scale.value['from']">
                                            </div>
                                            <div class="form-group is-required">
                                                <label>Hasta</label>
                                                <input type="number" placeholder="Valor"
                                                       class="form-control input-sm" data-toggle="tooltip"
                                                       title="Indique la cantidad (requerido)"
                                                       v-model="scale.value['to']">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12"
                                             v-if="type == 'boolean'">
                                            <div class="form-group">
                                                <label>Valor</label>
                                                <div class="col-12">
                                                    <div class="pretty p-switch p-fill p-bigger p-toggle">
                                                        <input type="checkbox" data-toggle="tooltip"
                                                               title="Indique si el campo está activo"
                                                               v-model="scale.value">
                                                            <div class="state p-off">
                                                                <label></label>
                                                            </div>
                                                            <div class="state p-on p-success">
                                                                <label></label>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row"
                                         v-if="record.group_by">
                                        <div class="col-md-12">
                                            <button type="button" @click="addScale($event)"
                                                    class="btn btn-sm btn-primary btn-custom float-right"
                                                    title="Agregar escala"
                                                    data-toggle="tooltip">
                                                <i class="fa fa-plus-circle"></i>
                                                Agregar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
					</div>
					<div class="modal-footer">
                        <div class="form-group">
                            <modal-form-buttons :saveRoute="'payroll/salary-scales'"></modal-form-buttons>
                        </div>
                    </div>
					<div class="modal-body modal-table">
	                	<v-client-table :columns="columns" :data="records" :options="table_options">
	                		<div slot="description" slot-scope="props">
                                <span v-html="props.row.description"></span>
                            </div>
	                		<div slot="active" slot-scope="props" class="text-center">
	                			<span>{{ (props.row.active) ? 'Activo' : 'Inactivo' }}</span>
	                		</div>
	                		<div slot="id" slot-scope="props" class="text-center">
	                			<button @click="initUpdate(props.index, $event)"
		                				class="btn btn-warning btn-xs btn-icon btn-action"
		                				title="Modificar registro" data-toggle="tooltip" type="button">
		                			<i class="fa fa-edit"></i>
		                		</button>
		                		<button @click="deleteRecord(props.index, 'salary-scales')"
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
	</section>
</template>

<script>
	export default {
		data() {
			return {
				record: {
					id:             '',
                    code:           '',
                    name:           '',
                    description:    '',
                    active:         false,
                    institution_id: '',
                    group_by:       '',
                    payroll_scales: [],
				},
                scale: {
                    id:    '',
                    name:  '',
                    value: ''
                },

                type:  '',
				errors:                           [],
				records:                          [],
				columns:                          ['name', 'description', 'active', 'id'],
                options:                          [],
				institutions:                     [],
                payroll_salary_tabulators_groups: [],
                editIndex: null
			}
		},
        created() {
            const vm = this;
            vm.table_options.headings = {
                'name'        : 'Nombre',
                'description' : 'Descripción',
                'active'      : 'Estatus',
                'id'          : 'Acción'
            };
            vm.table_options.sortable       = ['name', 'description'];
            vm.table_options.filterable     = ['name', 'description'];
            vm.table_options.columnsClasses = {
                'name'        : 'col-xs-4',
                'description' : 'col-xs-4',
                'active'      : 'col-xs-2',
                'id'          : 'col-xs-2'
            };
        },
        mounted() {
            const vm = this;
            $("#add_payroll_salary_scale").on('show.bs.modal', function() {
                vm.reset();
                vm.getInstitutions();
                vm.getPayrollSalaryTabulatorsGroups();
            });
        },
        computed: {
            /**
             * Método que obtiene el nombre de la agrupación de los tabuladores
             *
             * @author Henry Paredes <hparedes@cenditel.gob.ve> | <henryp2804@gmail.com>
             * @return {string}
             */
            getGroupBy: function() {
                const vm = this;
                let response = '';
                $.each(vm.payroll_salary_tabulators_groups, function(index, field) {
                    if (field.code == vm.record.group_by) {
                        response = field.name;
                        
                        if (field.type == 'list') {
                            vm.type = field.type;
                            vm.options = [];
                            axios.get('get-parameter-options/' + field.code).then(response => {
                                vm.options = response.data;
                            });
                        }
                    }
                });
                return response;
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
					id:             '',
					code:           '',
					name:           '',
					description:    '',
					active:         false,
					institution_id: '',
                    group_by:       '',
                    payroll_scales: [],
				};
			},
            resetType(type = '') {
                const vm = this;
                if (type == 'range') {
                    vm.scale.value = {
                        'from': '',
                        'to': ''
                    };
                } else
                 vm.scale.value = '';
                if (vm.record.payroll_scales.length > 0)
                    vm.resetScale(true);
            },
            getValueScale(value) {
                const vm = this;
                let id = JSON.parse(value);
                let response = '';
                $.each(vm.options, function(index, field) {
                    if (id == field['id']) {
                        response = field['text'];
                    }
                });
                return response;
            },
            getOptions(object, reset = true) {
                const vm = this;
                vm.type = object.type;
                if (object.type == 'list') {
                    vm.options = [];
                    axios.get('get-parameter-options/' + object.code).then(response => {
                        vm.options = response.data;
                    });
                }

                vm.resetScale(reset);
            },
            getPayrollSalaryTabulatorsGroups() {
                const vm = this;
                vm.payroll_salary_tabulators_groups = [];
                axios.get('get-salary-tabulators-groups').then(response => {
                    vm.payroll_salary_tabulators_groups = response.data;
                });
            },
            addScale(event) {
                const vm = this;
                var field = {};
                for (var index in vm.scale) {
                    field[index] = vm.scale[index];
                }
                if(vm.editIndex == null)
                    vm.record.payroll_scales.push(field);
                else {
                    vm.record.payroll_scales[vm.editIndex] = field;
                }
                vm.resetScale(false);
                event.preventDefault();
            },
            editScale(index,event){
                const vm = this;
                vm.editIndex = index;
                vm.scale = {
                    id:    vm.record.payroll_scales[index].id,
                    name:  vm.record.payroll_scales[index].name,
                    value: JSON.parse(vm.record.payroll_scales[index].value)
                },
                event.preventDefault();
            },
            removeScale(index,event) {
                const vm = this;
                vm.record.payroll_scales.splice(index, 1);
                vm.editIndex = null;
                event.preventDefault();
            },
            resetScale(reset_all = true) {
                const vm = this;
                if (vm.type == 'range') {
                    vm.scale = {
                        id:    '',
                        name:  '',
                        value: {
                            'from': '',
                            'to': ''
                        }
                    };
                } else
                    vm.scale = {
                        id:    '',
                        name:  '',
                        value: ''
                    };
                vm.editIndex = null;
                vm.record.payroll_scales = (reset_all)
                    ? []
                    : vm.record.payroll_scales;
            },
		}
	};
</script>
