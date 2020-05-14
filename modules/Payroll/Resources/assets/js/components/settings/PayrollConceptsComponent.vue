<template>
    <div class="text-center">
        <a class="btn-simplex btn-simplex-md btn-simplex-primary"
           href="#" title="Registros de conceptos" data-toggle="tooltip"
           @click="addRecord('add_payroll_concept', 'concepts', $event)">
            <i class=""></i>
            <span>Conceptos</span>
        </a>
        <div class="modal fade text-left" role="dialog" id="add_payroll_concept">
            <div class="modal-dialog vue-crud" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h6>
                            <i class=""></i>
                            Concepto
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
                                <!-- código -->
                                <div class="form-group is-required">
                                    <label>Código:</label>
                                    <input type="text" placeholder="Código" data-toggle="tooltip"
                                           title="Indique el código del concepto (requerido)"
                                           class="form-control input-sm" v-model="record.code">
                                    <input type="hidden" v-model="record.id">
                                </div>
                                <!-- ./código -->
                                <!-- nombre -->
                                <div class="form-group is-required">
                                    <label>Nombre:</label>
                                    <input type="text" placeholder="Nombre del concepto"
                                           data-toggle="tooltip"
                                           title="Indique el nombre del concepto (requerido)"
                                           class="form-control input-sm" v-model="record.name">
                                </div>
                                <!-- ./nombre -->
                            </div>
                            <!-- descripción -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Descripción:</label>
                                    <ckeditor :editor="ckeditor.editor" id="description"
                                              data-toggle="tooltip"
                                              title="Indique la descripción del concepto"
                                              :config="ckeditor.editorConfig" class="form-control"
                                              name="description" tag-name="textarea"
                                              v-model="record.description"></ckeditor>
                                </div>
                            </div>
                            <!-- ./descripción -->
                            <!-- tipo de concepto -->
                            <div class="col-md-4">
                                <div class=" form-group is-required">
                                    <label>Tipo de concepto</label>
                                    <select2 :options="payroll_concept_types"
                                             v-model="record.payroll_concept_type_id"></select2>
                                </div>
                            </div>
                            <!-- ./tipo de concepto -->
                            <!-- activa -->
                            <div class="col-md-2">
                                <div class=" form-group">
                                    <label>¿Activa?</label>
                                    <div class="col-12" data-toggle="tooltip"
                                         title="¿El concepto se encuentra activo actualmente?">
                                        <div class="col-12 bootstrap-switch-mini">
                                            <input type="checkbox" class="form-control bootstrap-switch"
                                                   data-toggle="tooltip" name="active"
                                                   title="Indique si el concepto esta activo"
                                                   data-on-label="SI" data-off-label="NO"
                                                   v-model="record.active" value="true">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ./activa -->
                        </div>
                        <div class="row">
                            <!-- ¿incide sobre? -->
                            <div class="col-md-4">
                                <div class=" form-group is-required">
                                    <label>¿Incide sobre?</label>
                                    <select2 :options="affects"
                                             v-model="record.affect"></select2>
                                </div>
                            </div>
                            <!-- ./¿incide sobre? -->
                            <!-- tipo de incidencia -->
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-12">
                                        <strong>Tipo de Incidencia</strong>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Valor</label>
                                            <div class="col-12">
                                                <div class="col-12 bootstrap-switch-mini">
                                                    <input type="radio" name="incidence_type" value="value"
                                                           id="sel_neto_value"
                                                           class="form-control bootstrap-switch bootstrap-switch-mini sel_incidence_value"
                                                            data-on-label="SI" data-off-label="NO">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Valor Absoluto</label>
                                            <div class="col-12">
                                                <div class="col-12 bootstrap-switch-mini">
                                                    <input type="radio" name="incidence_type" value="absolute_value"
                                                           id="sel_neto_value"
                                                           class="form-control bootstrap-switch bootstrap-switch-mini sel_incidence_value"
                                                            data-on-label="SI" data-off-label="NO">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Unidad Tributaria</label>
                                            <div class="col-12">
                                                <div class="col-12 bootstrap-switch-mini">
                                                    <input type="radio" name="incidence_type"
                                                           value="tax_unit" id="sel_tax_unit"
                                                           class="form-control bootstrap-switch bootstrap-switch-mini sel_incidence_value"
                                                           data-on-label="SI" data-off-label="NO">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Porcentaje</label>
                                            <div class="col-12">
                                                <div class="col-12 bootstrap-switch-mini">
                                                    <input type="radio" name="incidence_type" value="percent"
                                                           id="sel_percent"
                                                           class="form-control bootstrap-switch bootstrap-switch-mini sel_incidence_value"
                                                           data-on-label="SI" data-off-label="NO">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ./tipo de incidencia -->
                            <!-- forma de cálculo -->
                            <div class="col-md-4">
                                <div class=" form-group is-required">
                                    <label>Forma de cálculo:</label>
                                    <select2 :options="calculation_ways"
                                             v-model="record.calculation_way_id"></select2>
                                </div>
                            </div>
                            <!-- ./forma de cálculo -->
                        </div>
                        <div class="row"
                             v-show="record.calculation_way_id == 1">
                             <!-- fórmula -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Fórmula</label>
                                    <input type="text" class="form-control input-sm" data-toggle="tooltip"
                                           title="Fórmula a aplicar para el concepto. Utilice la siguiente calculadora para establecer los parámetros de la fórmula" v-model="record.formula" readonly>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="offset-sm-3 col-sm-6 text-center">
                                            <div class="btn btn-info btn-sm btn-formula" data-toggle="tooltip"
                                                 title="presione para agregar este dígito" data-value="1">1</div>
                                            <div class="btn btn-info btn-sm btn-formula" data-toggle="tooltip"
                                                 title="presione para agregar este dígito" data-value="2">2</div>
                                            <div class="btn btn-info btn-sm btn-formula" data-toggle="tooltip"
                                                 title="presione para agregar este dígito" data-value="3">3</div>
                                            <div class="btn btn-info btn-sm btn-formula" data-toggle="tooltip"
                                                 title="presione para agregar el signo de suma" data-value="+">+</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="offset-sm-3 col-sm-6 text-center">
                                            <div class="btn btn-info btn-sm btn-formula" data-toggle="tooltip"
                                                 title="presione para agregar este dígito" data-value="4">4</div>
                                            <div class="btn btn-info btn-sm btn-formula" data-toggle="tooltip"
                                                 title="presione para agregar este dígito" data-value="5">5</div>
                                            <div class="btn btn-info btn-sm btn-formula" data-toggle="tooltip"
                                                 title="presione para agregar este dígito" data-value="6">6</div>
                                            <div class="btn btn-info btn-sm btn-formula" data-toggle="tooltip"
                                                 title="presione para agregar el signo de resta" data-value="-">-</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="offset-sm-3 col-sm-6 text-center">
                                            <div class="btn btn-info btn-sm btn-formula" data-toggle="tooltip"
                                                 title="presione para agregar este dígito" data-value="7">7</div>
                                            <div class="btn btn-info btn-sm btn-formula" data-toggle="tooltip"
                                                 title="presione para agregar este dígito" data-value="8">8</div>
                                            <div class="btn btn-info btn-sm btn-formula" data-toggle="tooltip"
                                                 title="presione para agregar este dígito" data-value="9">9</div>
                                            <div class="btn btn-info btn-sm btn-formula" data-toggle="tooltip"
                                                 title="presione para agregar el signo de multiplicación"
                                                 data-value="*">*</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="offset-sm-3 col-sm-6 text-center">
                                            <div class="btn btn-info btn-sm btn-formula-clear" data-toggle="tooltip"
                                                 title="Reinicia el campo de la fórmula"
                                                 @click="record.formula = ''">C</div>
                                            <div class="btn btn-info btn-sm btn-formula" data-toggle="tooltip"
                                                 title="presione para agregar este dígito" data-value="0">0</div>
                                            <div class="btn btn-info btn-sm btn-formula" data-toggle="tooltip"
                                                 title="presione para agregar el separador de decimales"
                                                 data-value=".">.</div>
                                            <div class="btn btn-info btn-sm btn-formula" data-toggle="tooltip"
                                                 title="presione para agregar el signo de división"
                                                 data-value="/">/</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="offset-sm-3 col-sm-6 col-btn-block text-center">
                                            <div class="btn btn-info btn-sm btn-formula btn-block" data-toggle="tooltip"
                                                 title="Variable a usar para el monto deducible cuando se realice el cálculo" data-value="monto">
                                                DEDUCIBLE
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ./fórmula -->
                        </div>
                        <div class="row">
                            <!-- institución -->
                            <div class="col-md-4">
                                <div class=" form-group is-required">
                                    <label>Institución:</label>
                                    <select2 :options="institutions" v-model="record.institution_id"></select2>
                                </div>
                            </div>
                            <!-- ./institución -->
                            <!-- ¿asignar a? -->
                            <div class="col-md-4">
                                <div class=" form-group is-required">
                                    <label>¿Asignar a?</label>
                                    <select2 :options="payroll_assign_to"
                                             v-model="record.payroll_assign_to_id">
                                    </select2>
                                </div>
                            </div>
                            <!-- ./¿asignar a? -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group">
                            <modal-form-buttons :saveRoute="'payroll/concepts'"></modal-form-buttons>
                        </div>
                    </div>
                    <div class="modal-body modal-table">
                        <v-client-table :columns="columns" :data="records" :options="table_options">
                            <div slot="id" slot-scope="props" class="text-center">
                                <button @click="initUpdate(props.index, $event)"
                                        class="btn btn-warning btn-xs btn-icon  btn-action"
                                        title="Modificar registro" data-toggle="tooltip" type="button">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button @click="deleteRecord(props.index, 'concepts')"
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
                    id:                      '',
                    name:                    '',
                    description:             '',
                    active:                  '',
                    affect:                  '',
                    incidence:               '',
                    incidence_type:          '',
                    formula:                 '',
                    payroll_concept_type_id: '',
                    calculation_way_id:      '',
                    payroll_assign_to_id:    '',
                    institution_id:          ''

                },

                errors:                [],
                records:               [],
                columns:               ['code', 'name', 'description', 'incidence_type', 'id'],
                institutions:          [],
                payroll_concept_types: [],

                calculation_ways: [
                    {"id": "",          "text": "Seleccione..."},
                    {"id": "formula",   "text": "Fórmula"},
                    {"id": "tabulator", "text": "De acuerdo a tabulador"}
                ],
                affects: [
                    {"id": "",                    "text":  "Seleccione..."},
                    {"id": "base_salary",         "text":  "Salario Base"},
                    {"id": "normal_salary",        "text": "Salario Normal"},
                    {"id": "dialy_salary",         "text": "Salario Diario"},
                    {"id": "comprehensive_salary", "text": "Salario Integral"}
                ],
                payroll_assign_to: [
                    {"id": "",                              "text": "Seleccione..."},
                    {"id": "staff",                         "text": "Trabajadores"},
                    {"id": "all",                           "text": "Todos"},
                    {"id": "all_except_staffs_in_vacation", "text": "Todos excepto trabajadores que se " +
                                                                    "encuentren en período de disfrute vacaciones"},
                    {"id": "all_except_staffs_at_rest",     "text": "Todos excepto trabajadores que se " +
                                                                    "encuentren de reposo"},
                ],
            }
        },
        created() {
            const vm = this;
            vm.table_options.headings = {
                'code':           'Código',
                'name':           'Nombre',
                'description':    'Descripción',
                'incidence_type': 'Tipo de Incidencia',
                'id':              'Acción'
            };
            vm.table_options.sortable       = ['code', 'name', 'description', 'incidence_type'];
            vm.table_options.filterable     = ['code', 'name', 'description', 'incidence_type'];
            vm.table_options.columnsClasses = {
                'code':           'col-xs-2',
                'name':           'col-xs-2',
                'description':    'col-xs-4',
                'incidence_type': 'col-xs-2',
                'id':             'col-xs-2'
            }
        },
        mounted() {
            const vm = this;
            vm.switchHandler('active');
            vm.switchHandler('incidence');
            vm.switchHandler('incidence_type');

            $("#add_payroll_concept").on('show.bs.modal', function() {
                vm.reset();
                vm.getPayrollConceptTypes();
                vm.getInstitutions();
            });
            $('.btn-formula').on('click', function() {
                vm.record.formula += $(this).data('value');
            });
        },
        methods: {
            /**
             * Método que permite borrar todos los datos del formulario
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve>
             */
            reset() {
                const vm = this;
                vm.record = {
                    id:                      '',
                    name:                    '',
                    description:             '',
                    active:                  '',
                    affect:                  '',
                    incidence:               '',
                    incidence_type:          '',
                    formula:                 '',
                    payroll_concept_type_id: '',
                    calculation_way_id:      '',
                    payroll_assign_to_id:    '',
                    institution_id:          ''
                };
                vm.errors = [];
            },

            /**
             * Método que obtiene un arreglo con los tipos de conceptos registrados
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve>
             */
            getPayrollConceptTypes() {
                const vm = this;
                vm.payroll_concept_types = [];
                axios.get('/payroll/get-concept-types').then(response => {
                    vm.payroll_concept_types = response.data;
                });
            }
        }
    };
</script>

