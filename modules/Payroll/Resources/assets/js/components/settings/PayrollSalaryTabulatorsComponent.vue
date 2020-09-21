<template>
	<section id="payrollSalaryTabulatorsFormComponent">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary"
		   href="#" title="Registros Tabuladores de Nómina" data-toggle="tooltip"
		   @click="addRecord('add_payroll_salary_tabulator', 'salary-tabulators', $event)">
			<i class="icofont icofont-table ico-3x"></i>
			<span>Tabuladores de Nónima</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_payroll_salary_tabulator">
			<div class="modal-dialog modal-lg vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-table ico-2x"></i>
							 Tabulador de Nómina
						</h6>
					</div>

					<div class="modal-body">
                        <!-- mensajes de error -->
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
                        <!-- ./mensajes de error -->
                        <div class="wizard-tabs with-border">
                            <ul class="nav wizard-steps"
                                v-if="panel == 'Form'">
                                <li class="nav-item active">
                                    <a href="#w-tabulatorForm" data-toggle="tab"
                                       class="nav-link text-center" id="tabuladorForm"
                                       @click="changePanel('Form')">
                                        <span class="badge">1</span>
                                        Definir Tabulador
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a :href="isDisableNext()?'#':'#w-tabulatorShow'" data-toggle="tab"
                                       class="nav-link text-center" id="tabuladorShow"
                                       @click="changePanel('Show')">
                                        <span class="badge">2</span>
                                        Cargar Tabulador
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav wizard-steps"
                                v-else>
                                <li class="nav-item">
                                    <a href="#w-tabulatorForm" data-toggle="tab"
                                       class="nav-link text-center" id="tabuladorForm"
                                       @click="changePanel('Form')">
                                        <span class="badge">1</span>
                                        Definir Tabulador
                                    </a>
                                </li>
                                <li class="nav-item active">
                                    <a href="#w-tabulatorShow" data-toggle="tab"
                                       class="nav-link text-center" id="tabuladorShow"
                                       @click="changePanel('Show')">
                                        <span class="badge">2</span>
                                        Cargar Tabulador
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <form class="form-horizontal">
                            <div class="tab-content">
                                <div id="w-tabulatorForm" class="tab-pane p-3 active">
            						<div class="row">
            							<div class="col-md-6">
                                            <!-- nombre -->
                                            <div class="form-group is-required">
                                                <label>Nombre</label>
                                                <input type="text" class="form-control input-sm"
                                                       placeholder="Nombre del tabulador" data-toggle="tooltip"
                                                       title="Indique el nombre del tabulador (requerido)"
                                                       v-model="record.name">
                                                <input type="hidden" v-model="record.id">
                                            </div>
                                            <!-- ./nombre -->
            								<div class="row">
            									<div class="col-md-4">
                                                    <!-- activa -->
            										<div class="form-group">
            											<label>¿Activa?</label>
                                                        <div class="col-12">
                                                            <p-check class="pretty p-switch p-fill p-bigger"
                                                                     color="success" off-color="text-gray" toggle
                                                                     data-toggle="tooltip"
                                                                     title="Indique si el tabulador esá activo"
                                                                     v-model="record.active">
                                                                <label slot="off-label"></label>
                                                            </p-check>
                                                        </div>
            										</div>
                                                    <!-- ./activa -->
            									</div>
                                                <div class="col-md-8">
                                                    <!-- moneda -->
                                                    <div class="form-group is-required">
                                                        <label>Moneda:</label>
                                                        <select2 :options="currencies"
                                                                 v-model="record.currency_id"></select2>
                                                    </div>
                                                    <!-- ./moneda -->
                                                </div>
                                            </div>
                                            <!-- tipo de personal -->
                                            <div class="form-group is-required">
                                                <label>Tipo de Personal</label>
                                                <v-multiselect :options="payroll_staff_types" track_by="text"
                                                               :hide_selected="false"
                                                               v-model="record.payroll_staff_types">
                                                </v-multiselect>
                                            </div>
                                            <!-- ./tipo de personal -->
            							</div>
            							<div class="col-md-6">
                                            <!-- descripción -->
                                            <div class="form-group">
                                                <label>Descripción:</label>
                                                <ckeditor :editor="ckeditor.editor" id="description_tabulator"
                                                          data-toggle="tooltip"
                                                          title="Indique alguna descripción asociada al tabulador"
                                                          :config="ckeditor.editorConfig" class="form-control"
                                                          name="description_tabulator" tag-name="textarea" rows="2"
                                                          v-model="record.description"></ckeditor>
                                            </div>
                                            <!-- ./descripción -->
            							</div>
                                        <div class="col-md-6">
                                            <!-- institución -->
                                            <div class="form-group is-required">
                                                <label>Institución:</label>
                                                <select2 :options="institutions"
                                                         v-model="record.institution_id"></select2>
                                            </div>
                                            <!-- ./institución -->
                                        </div>
                                        <div class="col-md-6">
                                            <!-- tipo de tabulador -->
                                            <div class="form-group is-required">
                                                <label>Tipo de tabulador:</label>
                                                <select2 :options="payroll_salary_tabulator_types"
                                                         @input="getPayrollSalaryScales()"
                                                         v-model="record.payroll_salary_tabulator_type"></select2>
                                            </div>
                                            <!-- ./tipo de tabulador -->
                                        </div>
                                        <!-- Visible si el tipo de tabulador es horizontal o vertical -->
                                        <div class="col-md-6"
                                             v-if="record.payroll_salary_tabulator_type &&
                                                   record.payroll_salary_tabulator_type != 'mixed'">
                                            <!-- escalafón -->
                                            <div class="form-group is-required">
                                                <label>Escalafón:</label>
                                                <select2 id="payroll_horizontal_salary_scale"
                                                         :options="payroll_horizontal_salary_scales"
                                                         v-if="record.payroll_salary_tabulator_type =='horizontal'"
                                                         @input="loadSalaryScales('horizontal')"
                                                         v-model="record.payroll_horizontal_salary_scale_id"></select2>
                                                <select2 id="payroll_vertical_salary_scale"
                                                         :options="payroll_vertical_salary_scales"
                                                         @input="loadSalaryScales('vertical')"
                                                         v-else
                                                         v-model="record.payroll_vertical_salary_scale_id"></select2>
                                            </div>
                                            <!-- ./escalafón -->
                                        </div>
            						</div>
                                    <!-- visible si el tipo de tabulador es mixto -->
                                    <div class="row"
                                         v-if="record.payroll_salary_tabulator_type == 'mixed'">
                                        <div class="col-md-6">
                                            <!-- escalafón horizontal -->
                                            <div class="form-group is-required">
                                                <label>Escalafón horizontal:</label>
                                                <select id="payroll_horizontal_salary_scale"
                                                        class="form-control select2"
                                                        @change="isDisable('horizontal');loadSalaryScales('horizontal')"
                                                        v-model="record.payroll_horizontal_salary_scale_id">
                                                    <option v-for="option in payroll_horizontal_salary_scales"
                                                            :id="option.id + '_h'" :value="option.id">
                                                        {{ option.text }}
                                                    </option>
                                                </select>
                                            </div>
                                            <!-- ./escalafón horizontal -->
                                        </div>
                                        <div class="col-md-6">
                                            <!-- escalafón vertical -->
                                            <div class="form-group is-required">
                                                <label>Escalafón vertical:</label>
                                                <select id="payroll_vertical_salary_scale"
                                                        class="form-control select2"
                                                        @change="isDisable('vertical');loadSalaryScales('vertical')"
                                                        v-model="record.payroll_vertical_salary_scale_id">
                                                    <option v-for="option in payroll_vertical_salary_scales"
                                                            :id="option.id + '_v'" :value="option.id">
                                                        {{ option.text }}
                                                    </option>
                                                </select>
                                            </div>
                                            <!-- ./escalafón vertical -->
                                        </div>
                                    </div>
                                </div>

                                <div id="w-tabulatorShow" class="tab-pane p-3">
                                    <!-- Visible para ambos escalafones -->
                                    <div class="modal-table"
                                         v-if="((record.payroll_horizontal_salary_scale_id > 0)
                                            && (payroll_salary_scale_h.payroll_scales)
                                            && (payroll_salary_scale_h.payroll_scales.length > 0))
                                            || ((record.payroll_vertical_salary_scale_id > 0)
                                            && (payroll_salary_scale_v.payroll_scales)
                                            && (payroll_salary_scale_v.payroll_scales.length > 0))">
                                        <table class="table table-hover table-striped table-responsive table-assignment"
                                               v-if="record.payroll_horizontal_salary_scale_id > 0
                                                  && record.payroll_salary_tabulator_type != 'vertical'">
                                            <thead>
                                                <th :colspan="1 + payroll_salary_scale_h.payroll_scales.length"
                                                     v-if="payroll_salary_scale_h.payroll_scales">
                                                    <strong>{{ record.name }}</strong>
                                                </th>
                                            </thead>
                                            <tbody>
                                                <tr class="text-center">
                                                    <th>Nombre:</th>
                                                    <th
                                                        v-for="(field_h, index) in payroll_salary_scale_h.payroll_scales">
                                                        {{field_h.name}}
                                                    </th>
                                                </tr>
                                                <tr class="text-center"
                                                    v-if="record.payroll_salary_tabulator_type == 'horizontal'">
                                                    <th>Incidencia:</th>
                                                    <td class="td-with-border"
                                                        v-for="(field_h, index) in payroll_salary_scale_h.payroll_scales">
                                                        <div>
                                                            <input type="text" :id="'salary_scale_h_' + field_h.id"
                                                                   class="form-control input-sm" data-toggle="tooltip"
                                                                   onfocus="this.select()" v-input-mask
                                                                   data-inputmask="
                                                                       'alias': 'numeric',
                                                                       'allowMinus': 'false',
                                                                       'digits': '2'">
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr class="text-center"
                                                    v-if="record.payroll_vertical_salary_scale_id > 0
                                                       && record.payroll_salary_tabulator_type == 'mixed'"
                                                    v-for="(field_v, index_v) in payroll_salary_scale_v.payroll_scales">
                                                    <th>
                                                        {{field_v.name}}
                                                    </th>
                                                    <td class="td-with-border"
                                                        v-for="(field_h, index_h) in payroll_salary_scale_h.payroll_scales">
                                                        <div>
                                                            <input type="text"
                                                                   :id="'salary_scale_' + field_v.id + '_' + field_h.id"
                                                                   class="form-control input-sm" data-toggle="tooltip"
                                                                   onfocus="this.select()" v-input-mask
                                                                   data-inputmask="
                                                                       'alias': 'numeric',
                                                                       'allowMinus': 'false',
                                                                       'digits': '2'">
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table class="table table-hover table-striped table-responsive table-assignment"
                                               v-else-if="record.payroll_salary_tabulator_type == 'vertical'
                                                       && record.payroll_vertical_salary_scale_id > 0">
                                            <thead>
                                                <th colspan="2">
                                                    <strong>{{ record.name }}</strong>
                                                </th>
                                            </thead>
                                            <tbody>
                                                <tr class="text-center">
                                                    <th>Nombre</th>
                                                    <th>Incidencia</th>
                                                </tr>
                                                <tr class="text-center"
                                                    v-for="(field, index) in payroll_salary_scale_v.payroll_scales">
                                                    <th>
                                                        {{field.name}}
                                                    </th>
                                                    <td>
                                                        <div>
                                                            <input type="text" :id="'salary_scale_v_' + field.id"
                                                                   class="form-control input-sm" data-toggle="tooltip"
                                                                   onfocus="this.select()" v-input-mask
                                                                   data-inputmask="
                                                                       'alias': 'numeric',
                                                                       'allowMinus': 'false',
                                                                       'digits': '2'">
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="wizard-footer">
                                <div class="pull-right"
                                     v-if="panel == 'Form'">
                                    <button type="button" @click="loadSalaryScales()"
                                            class="btn btn-primary btn-wd btn-sm"
                                            :disabled="isDisableNext()"
                                            data-toggle="tooltip" title="">
                                        Siguiente
                                    </button>
                                </div>
                                <div class="pull-left"
                                     v-else>
                                    <button type="button" @click="changePanel('Form')"
                                            class="btn btn-default btn-wd btn-sm"
                                            data-toggle="tooltip" title="">
                                        Regresar
                                    </button>
                                </div>
                            </div>
                        </form>
			        </div>
			        <div class="modal-footer">
                        <div class="form-group">
                            <modal-form-buttons :saveRoute="'payroll/salary-tabulators'"></modal-form-buttons>
                        </div>
                    </div>
                    <div class="modal-body modal-table">
	                	<hr>
	                	<v-client-table :columns="columns" :data="records" :options="table_options">
                            <div slot="description" slot-scope="props">
                                <span v-html="props.row.description"></span>
                            </div>
	                		<div slot="id" slot-scope="props" class="text-center">
	                			<button @click="exportRecord(props.row.id, $event)"
                                        class="btn btn-primary btn-xs btn-icon btn-action"
                                        title="Descargar/Exportar tabulador" data-toggle="tooltip" type="button">
	                                <i class="fa fa-download"></i>
	                            </button>
	                			<button @click="changePanel('Form'); initUpdate(props.row.id, $event)"
		                				class="btn btn-warning btn-xs btn-icon btn-action"
		                				title="Modificar registro" data-toggle="tooltip" type="button">
		                			<i class="fa fa-edit"></i>
		                		</button>
		                		<button @click="deleteRecord(props.index, 'salary-tabulators')"
										class="btn btn-danger btn-xs btn-icon btn-action" title="Eliminar registro"
                                        data-toggle="tooltip" type="button">
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
					id:                                 '',
                    name:                               '',
                    active:                             false,
                    description:                        '',
                    institution_id:                     '',
                    currency_id:                        '',
                    payroll_salary_tabulator_type:      '',
                    payroll_staff_types:                [],

                    payroll_horizontal_salary_scale_id: '',
                    payroll_vertical_salary_scale_id:   '',
                    payroll_salary_tabulator_scales:    []
				},
                errors:                           [],
                records:                          [],
                columns:                          ['name', 'description', 'id'],
                payroll_salary_tabulator_types:   [
                    {"id": "",           "text": "Seleccione..."},
                    {"id": "horizontal", "text": "Horizontal"},
                    {"id": "vertical",   "text": "Vertical"},
                    {"id": "mixed",      "text": "Mixto"}
                ],
                institutions:                     [],
                currencies:                       [],
                payroll_staff_types:              [],
                payroll_horizontal_salary_scales: [],
                payroll_vertical_salary_scales:   [],
                payroll_salary_scale_h:           [],
                payroll_salary_scale_v:           [],
                panel:                            'Form',
                edit:                             false

			}
		},
		created() {
            const vm = this;
			vm.table_options.headings = {
				'name':        'Nombre',
				'description': 'Descripción',
				'id':          'Acción'
			};
			vm.table_options.sortable       = ['name', 'description'];
			vm.table_options.filterable     = ['name', 'description'];
			vm.table_options.columnsClasses = {
				'name':        'col-xs-4',
				'description': 'col-xs-6',
				'id':          'col-xs-2'
			};
		},
        mounted() {
            const vm = this;
            $("#add_payroll_salary_tabulator").on('show.bs.modal', function() {
                vm.reset();
                vm.getPayrollStaffTypes();
                vm.getInstitutions();
                vm.getCurrencies();
            });
        },
        watch: {
            /**
             * Método que permite actualizar los escalafones horizontal y vertical cuando detecta cambios
             * en la variable "record"
             *
             * @method    record
             * @author    Henry Paredes <hparedes@cenditel.gob.ve>
             */
            record: {
                deep: true,
                handler: function() {
                    const vm = this;
                    if (vm.record.id) {
                        if ((vm.payroll_horizontal_salary_scales.length > 0)
                            && (vm.record.payroll_horizontal_salary_scale)
                            && (vm.record.payroll_horizontal_salary_scale_id == '')) {
                            vm.record.payroll_horizontal_salary_scale_id = vm.record.payroll_horizontal_salary_scale['id'];
                        }
                        if ((vm.payroll_vertical_salary_scales.length > 0)
                            && (vm.record.payroll_vertical_salary_scale)
                            && (vm.record.payroll_vertical_salary_scale_id == '')) {
                            vm.record.payroll_vertical_salary_scale_id = vm.record.payroll_vertical_salary_scale['id'];
                        }
                    }
                }
            }
        },
		methods: {
            /**
             * Método que borra todos los datos del formulario
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve>
             */
			reset() {
				const vm  = this;
                vm.errors = [];
				vm.record = {
					id:                                 '',
                    name:                               '',
                    active:                             false,
                    description:                        '',
                    institution_id:                     '',
                    currency_id:                        '',
                    payroll_salary_tabulator_type:      '',
                    payroll_staff_types:                [],
                    payroll_horizontal_salary_scale_id: '',
                    payroll_vertical_salary_scale_id:   '',
                    payroll_salary_tabulator_scales:    []
				};
                vm.payroll_salary_scale_h = [];
                vm.payroll_salary_scale_v = [];
                vm.panel                  = 'Form';
                vm.edit                   = false;
                vm.changePanel(vm.panel);

			},
            /**
             * Método que habilita o deshabilita el botón siguiente
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve>
             */
            isDisableNext() {
                const vm = this;
                if ((vm.record.name != '') && (vm.record.institution_id != '') &&
                    (vm.record.currency_id != '') && (vm.record.payroll_staff_types != []) &&
                    (vm.record.payroll_salary_tabulator_type != '')) {
                    if (((vm.record.payroll_salary_tabulator_type == 'vertical') &&
                        (vm.record.payroll_vertical_salary_scale_id != '')) ||
                        ((vm.record.payroll_salary_tabulator_type == 'horizontal') &&
                        (vm.record.payroll_horizontal_salary_scale_id != '')) ||
                        ((vm.record.payroll_salary_tabulator_type == 'mixed') &&
                        (vm.record.payroll_horizontal_salary_scale_id != '') &&
                        (vm.record.payroll_vertical_salary_scale_id != ''))) {
                        return false;
                    } else {
                        return true;
                    }
                } else {
                    return true;
                }
            },
            /**
             * Método que cambia el panel de visualización
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve>
             *
             * @param     {string}     panel    Panel seleccionado
             */
            changePanel(panel) {
                const vm    = this;
                let complete;
                if (panel == 'Show') {
                    complete = !vm.isDisableNext();
                } else {
                    complete = true;
                }
                if (complete == true) {
                    vm.panel    = panel;
                    let element = document.getElementById('tabulador' + panel);
                    if (element) {
                        element.click();
                    }
                }
            },
            /**
             * Método que permite habilitar/deshabilitar las opciones de los escalafones salariales
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve>
             *
             * @param     {string}     ladder    Escalafón que invoco el método
             */
            isDisable(ladder) {
                const vm = this;
                if (ladder == 'horizontal') {
                    $.each(vm.payroll_vertical_salary_scales, function(index, field) {
                        if ((field.id == vm.record.payroll_horizontal_salary_scale_id)
                            && (vm.record.payroll_horizontal_salary_scale_id != '')) {
                            $('#' + field.id + '_v').prop("disabled", true);
                        } else
                            $('#' + field.id + '_v').prop("disabled", false);
                    })
                } else {
                    $.each(vm.payroll_horizontal_salary_scales, function(index, field) {
                        if ((field.id == vm.record.payroll_vertical_salary_scale_id)
                            && (vm.record.payroll_vertical_salary_scale_id != '')) {
                            $('#' + field.id + '_h').prop("disabled", true);
                        } else
                            $('#' + field.id + '_h').prop("disabled", false);
                    })
                }
            },
            /**
             * Método que exporta el tabulador seleccionado en formato ".xls"
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve>
             *
             * @param     {integer}    index    Identificador del registro a ser exportado
             * @param     {object}     event    Objeto que gestiona los eventos
             */
			exportRecord(id, event) {
				window.open('/payroll/salary-tabulators/export/' + id);
				event.preventDefault();
			},
            /**
             * Método que obtiene los escalafones salariales, para posteriormente,
             * cargarlos en el formulario según sea el tipo de tabulador
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve>
             *
             * @param     {integer}    index    Identificador del registro a ser modificado
             * @param     {object}     event    Objeto que gestiona los eventos
             */
            getPayrollSalaryScales() {
                const vm  = this;
                let field = {
                    institution_id: vm.record.institution_id,
                    except_id:      ''
                };
                if (vm.edit == false) {
                    delete vm.record.payroll_salary_tabulator_scales;
                    delete vm.record.payroll_horizontal_salary_scale;
                    delete vm.record.payroll_vertical_salary_scale;
                }
                vm.edit = false;

                if (vm.record.payroll_salary_tabulator_type != '') {
                    axios.post('/payroll/get-salary-scales', field).then(response => {
                        if (typeof(response.data) !== "undefined") {

                            if (vm.record.payroll_salary_tabulator_type == 'vertical') {
                                vm.payroll_horizontal_salary_scales = [];
                                vm.record.payroll_horizontal_salary_scale_id = '';
                            } else {
                                vm.payroll_horizontal_salary_scales = response.data;
                                vm.record.payroll_vertical_salary_scale_id = '';
                            }
                            if (vm.record.payroll_salary_tabulator_type == 'horizontal') {
                                vm.payroll_vertical_salary_scales = [];
                                vm.record.payroll_vertical_salary_scale_id = '';
                            } else {
                                vm.payroll_vertical_salary_scales = response.data;
                                vm.record.payroll_horizontal_salary_scale_id = '';
                            }
                        }
                    }).catch(error => {
                        if (typeof(error.response) !== "undefined") {
                            if (error.response.status == 403) {
                                vm.showMessage(
                                    'custom', 'Acceso Denegado', 'danger', 'screen-error', error.response.data.message
                                );
                            }
                            else {
                                vm.logs(
                                    'modules/Payroll/Resources/assets/js/_all.js',
                                    343,
                                    error,
                                    'getPayrollSalaryScales'
                                );
                            }
                        }
                    });
                };
            },
            /**
             * Método que obtiene la información de los escalafones salariales seleccionados
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve>
             *
             */
            loadSalaryScales(ladder = '') {
                const vm = this;
                let id   = '';
                if (ladder !== '') {
                    if (ladder == 'horizontal') {
                        if (vm.record.payroll_horizontal_salary_scale_id > 0) {
                            id = vm.record.payroll_horizontal_salary_scale_id;
                            axios.get('/payroll/salary-scales/info/' + id).then(response => {
                                vm.payroll_salary_scale_h = response.data.record;
                            });
                        };
                    } else {
                        if (vm.record.payroll_vertical_salary_scale_id > 0) {
                            id = vm.record.payroll_vertical_salary_scale_id;
                            axios.get('/payroll/salary-scales/info/' + id).then(response => {
                                vm.payroll_salary_scale_v = response.data.record;
                            });
                        }
                    }
                } else {
                    if (vm.record.id) {
                        if (vm.record.payroll_salary_tabulator_type == 'horizontal') {
                            if ((typeof(vm.record.payroll_horizontal_salary_scale) != 'undefined')
                                && (vm.record.payroll_horizontal_salary_scale != null)
                                && (vm.record.payroll_horizontal_salary_scale_id == vm.record.payroll_horizontal_salary_scale['id'])) {
                                $.each(vm.record.payroll_salary_tabulator_scales, function (index, field) {
                                    let element = document.getElementById("salary_scale_h_" + field['payroll_horizontal_scale_id']);
                                    if (element) {
                                        element.value = field['value'];
                                    }
                                });
                                vm.changePanel('Show');
                            };
                        } else if (vm.record.payroll_salary_tabulator_type == 'vertical') {
                            if ((typeof(vm.record.payroll_vertical_salary_scale) != 'undefined')
                                && (vm.record.payroll_vertical_salary_scale != null)
                                && (vm.record.payroll_vertical_salary_scale_id == vm.record.payroll_vertical_salary_scale['id'])) {
                                $.each(vm.record.payroll_salary_tabulator_scales, function (index, field) {
                                    var element = document.getElementById("salary_scale_v_" + field['payroll_vertical_scale_id']);
                                    if (element) {
                                        element.value = field['value'];
                                    }
                                });
                                vm.changePanel('Show');
                            }
                        } else {
                            if ((typeof(vm.record.payroll_vertical_salary_scale) != 'undefined')
                                && (vm.record.payroll_vertical_salary_scale != null)
                                && (vm.record.payroll_vertical_salary_scale_id == vm.record.payroll_vertical_salary_scale['id'])
                                && (typeof(vm.record.payroll_horizontal_salary_scale) != 'undefined')
                                && (vm.record.payroll_horizontal_salary_scale != null)
                                && (vm.record.payroll_horizontal_salary_scale_id == vm.record.payroll_horizontal_salary_scale['id'])) {
                                $.each(vm.record.payroll_salary_tabulator_scales, function (index, field) {
                                    var element = document.getElementById(
                                                    "salary_scale_" + field['payroll_vertical_scale_id'] + '_' + 
                                                    field['payroll_horizontal_scale_id']
                                                );
                                    if (element) {
                                        element.value = field['value'];
                                    }
                                });
                                vm.changePanel('Show');
                            }
                        }
                    }
                    vm.changePanel('Show');
                }
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
                var payroll_scales = [];

                if ((vm.record.payroll_horizontal_salary_scale_id > 0
                    && vm.payroll_salary_scale_h.payroll_scales.length > 0)
                    || (vm.record.payroll_vertical_salary_scale_id > 0
                    && vm.payroll_salary_scale_v.payroll_scales.length > 0)) {

                    if ((!vm.record.payroll_vertical_salary_scale_id > 0)
                        && (vm.record.payroll_horizontal_salary_scale_id > 0)) {
                        $.each(vm.payroll_salary_scale_h.payroll_scales, function (index, campo) {
                            var element = document.getElementById("salary_scale_h_" + campo.id);
                            if (element) {
                                var field = {
                                    payroll_horizontal_scale_id:   campo.id,
                                    payroll_horizontal_scale_code: campo.code,
                                    value:                         element.value
                                };
                                payroll_scales.push(field);
                            }
                        });
                    } else if ((vm.record.payroll_vertical_salary_scale_id > 0)
                        && (!vm.record.payroll_horizontal_salary_scale_id > 0)) {
                        $.each(vm.payroll_salary_scale_v.payroll_scales, function (index, campo) {
                            var element = document.getElementById("salary_scale_v_" + campo.id);
                            if (element) {
                                var field = {
                                    payroll_vertical_scale_id:   campo.id,
                                    payroll_vertical_scale_code: campo.code,
                                    value:                       element.value
                                };
                                payroll_scales.push(field);
                            }
                        });
                    } else {
                        $.each(vm.payroll_salary_scale_v.payroll_scales, function (index_v, campo_v) {
                            $.each(vm.payroll_salary_scale_h.payroll_scales, function (index_h, campo_h) {
                                var element = document.getElementById(
                                    "salary_scale_" + campo_v.id + '_' + campo_h.id
                                );
                                if (element) {
                                    var field = {
                                        payroll_vertical_scale_id:     campo_v.id,
                                        payroll_vertical_scale_code:   campo_v.code,
                                        payroll_horizontal_scale_id:   campo_h.id,
                                        payroll_horizontal_scale_code: campo_h.code,
                                        value:                         element.value,
                                    };
                                    payroll_scales.push(field);
                                }
                            });
                        });
                    }
                    vm.record.payroll_salary_tabulator_scales = payroll_scales;
                }

                if (vm.record.id) {
                    vm.updateRecord(url);
                }
                else {
                    vm.loading = true;
                    var fields = {};
                    for (var index in this.record) {
                        fields[index] = this.record[index];
                    }
                    axios.post('/' + url, fields).then(response => {
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
            /**
             * Reescribe el método initUpdate para cambiar su comportamiento por defecto
             * Método que carga el formulario con los datos a modificar
             *
             * @author    Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             *
             * @param     {integer}    id       Identificador del registro a ser modificado
             * @param     {object}     event    Objeto que gestiona los eventos
             */
            initUpdate(id, event) {
                const vm = this;
                vm.errors = [];
                let recordEdit = JSON.parse(JSON.stringify(vm.records.filter((rec) => {
                    return rec.id === id;
                })[0])) || vm.reset();

                vm.record = recordEdit;
                vm.edit   = true;
                vm.payroll_salary_scale_v = (vm.record.payroll_vertical_salary_scale)
                                                ? vm.record.payroll_vertical_salary_scale
                                                : [];
                vm.payroll_salary_scale_h = (vm.record.payroll_horizontal_salary_scale)
                                                ? vm.record.payroll_horizontal_salary_scale
                                                : [];
                event.preventDefault();
            }
		}
	};
</script>
