<template>
    <section id="payrollConceptsFormComponent">
        <a class="btn-simplex btn-simplex-md btn-simplex-primary"
           href="#" title="Registros de conceptos" data-toggle="tooltip"
           @click="addRecord('add_payroll_concept', 'payroll/concepts', $event)">
            <i class="icofont icofont-calculator-alt-1 ico-3x"></i>
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
                            <i class="icofont icofont-calculator-alt-1 ico-3x"></i>
                            Concepto
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
                                    <li v-for="error in errors" :key="error">{{ error }}</li>
                                </ul>
                            </div>
                        </div>
                        <!-- ./mensajes de error -->
                        <div class="row">
                            <div class="col-md-6">
                                <!-- nombre -->
                                <div class="form-group is-required">
                                    <label>Nombre:</label>
                                    <input type="text" placeholder="Nombre del concepto"
                                           data-toggle="tooltip"
                                           title="Indique el nombre del concepto (requerido)"
                                           class="form-control input-sm" v-model="record.name">
                                    <input type="hidden" v-model="record.id">
                                </div>
                                <!-- ./nombre -->
                                <div class="row">
                                    <div class="col-md-8">
                                        <!-- código -->
                                        <div class="form-group is-required">
                                            <label>Código:</label>
                                            <input type="text" placeholder="Código" data-toggle="tooltip"
                                                   title="Indique el código del concepto (requerido)"
                                                   class="form-control input-sm" v-model="record.code">
                                        </div>
                                        <!-- ./código -->
                                    </div>
                                    <!-- activa -->
                                    <div class="col-md-4">
                                        <div class=" form-group">
                                            <label>¿Activo?</label>
                                            <div class="col-12">
                                                <p-check class="pretty p-switch p-fill p-bigger"
                                                         color="success" off-color="text-gray" toggle
                                                         data-toggle="tooltip"
                                                         title="¿El concepto se encuentra activo actualmente?"
                                                         v-model="record.active">
                                                    <label slot="off-label"></label>
                                                </p-check>
                                              </div>
                                        </div>
                                    </div>
                                    <!-- ./activa -->
                                </div>
                                <!-- tipo de concepto -->
                                <div class=" form-group is-required">
                                    <label>Tipo de concepto</label>
                                    <select2 :options="payroll_concept_types"
                                             v-model="record.payroll_concept_type_id"></select2>
                                </div>
                                <!-- ./tipo de concepto -->
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
                                <h6 class="text-center">Tipo de incidencia</h6>
                                <div class="row" style="align-items: flex-end;">
                                    <div class="col-xs-3">
                                        <div class="form-group">
                                            <label>Valor</label>
                                            <div class="col-12">
                                                <p-radio class="pretty p-switch p-fill p-bigger"
                                                         color="success" off-color="text-gray" toggle
                                                         v-model="record.incidence_type" value="value">
                                                    <label slot="off-label"></label>
                                                </p-radio>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-3">
                                        <div class="form-group">
                                            <label>Valor absoluto</label>
                                            <div class="col-12">
                                                <p-radio class="pretty p-switch p-fill p-bigger"
                                                         color="success" off-color="text-gray" toggle
                                                         v-model="record.incidence_type" value="absolute_value">
                                                    <label slot="off-label"></label>
                                                </p-radio>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-3">
                                        <div class="form-group">
                                            <label>Unidad tributaria</label>
                                            <div class="col-12">
                                                <p-radio class="pretty p-switch p-fill p-bigger"
                                                         color="success" off-color="text-gray" toggle
                                                         v-model="record.incidence_type" value="tax_unit">
                                                    <label slot="off-label"></label>
                                                </p-radio>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-3">
                                        <div class="form-group">
                                            <label>Porcentaje</label>
                                            <div class="col-12">
                                                <p-radio class="pretty p-switch p-fill p-bigger"
                                                         color="success" off-color="text-gray" toggle
                                                         v-model="record.incidence_type" value="percent">
                                                    <label slot="off-label"></label>
                                                </p-radio>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ./tipo de incidencia -->
                            <!-- cuenta contable -->
                            <div class="col-md-4">
                                <div class="form-group is-required">
                                    <label>Cuenta contable</label>
                                    <select2 :options="accounting_accounts"
                                             v-model="record.accounting_account_id"></select2>
                                </div>
                            </div>
                            <!-- ./cuenta contable -->
                            <!-- cuenta presupuestaria -->
                            <div class="col-md-4">
                                <div class="form-group is-required">
                                    <label>Cuenta presupuestario</label>
                                    <select2 :options="budget_accounts"
                                             v-model="record.budget_account_id"></select2>
                                </div>
                            </div>
                            <!-- ./cuenta presupuestaria -->
                            <!-- Organización -->
                            <div class="col-md-4">
                                <div class=" form-group is-required">
                                    <label>Organización:</label>
                                    <select2 :options="institutions" v-model="record.institution_id"></select2>
                                </div>
                            </div>
                            <!-- ./Organización -->
                            <!-- forma de cálculo -->
                            <div class="col-md-4">
                                <div class=" form-group is-required">
                                    <label>Forma de cálculo:</label>
                                    <select2 :options="calculation_ways"
                                             @input="record.payroll_salary_tabulator_id = ''"
                                             v-model="record.calculation_way"></select2>
                                </div>
                            </div>
                            <!-- ./forma de cálculo -->
                            <!-- tabla salarial -->
                            <div class="col-md-4"
                                 v-if="record.calculation_way == 'tabulator'">
                                <div class="form-group is-required">
                                    <label>Tabulador:</label>
                                    <select2 :options="payroll_salary_tabulators"
                                             v-model="record.payroll_salary_tabulator_id"></select2>

                                </div>
                            </div>
                            <!-- ./tabla salarial -->
                            <!-- ¿asignar a? -->
                            <div class="col-md-8">
                                <div class=" form-group is-required">
                                    <label>¿Asignar a?</label>
                                    <v-multiselect :options="assign_to" track_by="name"
                                                   :hide_selected="false" data-toggle="tooltip"
                                                   title="Indique los registros a los que se les va asignar el concepto"
                                                   @input="updateAssignOptions"
                                                   v-model="record.assign_to">
                                    </v-multiselect>
                                </div>
                            </div>
                            <!-- ./¿asignar a? -->
                        </div>
                        <div class="row" style="align-items: flex-end;"
                             v-if="record.assign_to">
                             <div class="col-md-4"
                                  v-for="field in record.assign_to" :key="field['id']">
                                <div v-if="field['type'] && assign_options[field['id']] && record.assign_options[field['id']]">
                                    <!-- registro de opciones a asignar -->
                                    <div class="form-group is-required"
                                        v-if="field['type'] == 'list'">
                                        <label>{{ field['name'] }}</label>
                                        <v-multiselect
                                                    :options="assign_options[field['id']]" track_by="text"
                                                    :hide_selected="false" data-toggle="tooltip"
                                                    title="Indique los registros a los que se les va asignar el concepto"
                                                    v-model="record.assign_options[field['id']]">
                                        </v-multiselect>
                                    </div>
                                    <!-- ./registro de opciones a asignar -->
                                    <!-- registro de rangos a asignar -->
                                    <div class="form-group"
                                        v-if="field['type'] == 'range'
                                            && assign_options[field['id']]">
                                        <label>{{ field['name'] }}</label>
                                        <div class="row" style="align-items: baseline;">
                                            <dir class="col-6">
                                                <div class="form-group is-required">
                                                    <label>Minimo:</label>
                                                    <input type="number" min="0" step=".01"
                                                        placeholder="Minimo" data-toggle="tooltip"
                                                        title="Indique el minimo requerido para asignar el concepto"
                                                        class="form-control input-sm"
                                                        v-model="record.assign_options[field['id']]['minimum']">
                                                </div>
                                            </dir>
                                            <div class="col-6">
                                                <div class="form-group is-required">
                                                    <label>Máximo:</label>
                                                    <input type="number" min="0" step=".01"
                                                        placeholder="Máximo" data-toggle="tooltip"
                                                        title="Indique el máximo requerido para asignar el concepto"
                                                        class="form-control input-sm"
                                                        v-model="record.assign_options[field['id']]['maximum']">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- ./registro de opciones a asignar -->
                                </div>
                            </div>
                        </div>
                        <div class="row" v-show="record.calculation_way == 'formula'">
                            <div class="col-md-6">
                                <!-- fórmula -->
                                <div class="form-group is-required">
                                    <label>Fórmula</label>
                                    <textarea type="text"
                                              :class="['form-control input-sm BlockDeletion', isInvalid('formula')]"
                                              data-toggle="tooltip"
                                              title="Fórmula a aplicar para el concepto. Utilice la siguiente calculadora para establecer los parámetros de la fórmula"
                                              rows="3" v-model="record.formula"
                                              autocomplete="off"
                                              onkeypress="return (event.charCode >= 24 && event.charCode <= 27)">
                                    </textarea>
                                </div>
                                <!-- ./fórmula -->
                                <div class="row" style="align-items: flex-end;">
                                    <div class="col-xs-3 col-md-3">
                                        <div class="form-group">
                                            <label for="worker_record">¿Expediente del trabajador?</label>
                                            <div class="col-12">
                                                <p-radio class="pretty p-switch p-fill p-bigger"
                                                         color="success" off-color="text-gray" toggle
                                                         data-toggle="tooltip"
                                                         title="Indique si desea utilizar una variable del expediente del Trabajador"
                                                         v-model="variable" value="worker_record">
                                                    <label slot="off-label"></label>
                                                </p-radio>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-3 col-md-3">
                                        <div class="form-group">
                                            <label for="parameter">¿Parámetro?</label>
                                            <div class="col-12">
                                                <p-radio class="pretty p-switch p-fill p-bigger"
                                                         color="success" off-color="text-gray" toggle
                                                         data-toggle="tooltip"
                                                         title="Indique si desea utilizar un parámetro previamente registrado"
                                                         v-model="variable" value="parameter">
                                                    <label slot="off-label"></label>
                                                </p-radio>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-3 col-md-3">
                                        <div class="form-group">
                                            <label for="vacation">¿Vacaciones?</label>
                                            <div class="col-12">
                                                <p-radio class="pretty p-switch p-fill p-bigger"
                                                         color="success" off-color="text-gray" toggle
                                                         data-toggle="tooltip"
                                                         title="Indique si desea utilizar una variable asociada a la configuración de vacaciones"
                                                         v-model="variable" value="vacation">
                                                    <label slot="off-label"></label>
                                                </p-radio>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-3 col-md-3">
                                        <div class="form-group">
                                            <label for="concept">¿Concepto?</label>
                                            <div class="col-12">
                                                <p-radio class="pretty p-switch p-fill p-bigger"
                                                         color="success" off-color="text-gray" toggle
                                                         data-toggle="tooltip"
                                                         title="Indique si desea utilizar un concepto previamente registrado"
                                                         v-model="variable" value="concept">
                                                    <label slot="off-label"></label>
                                                </p-radio>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12"
                                         v-if="variable">
                                        <!-- opciones -->
                                        <div class="form-group">
                                            <label for="register">Registro</label>
                                            <select2 :options="variable_options"
                                                     @input="getOptionType"
                                                     v-model="variable_option"></select2>
                                        </div>
                                        <!-- ./opciones -->
                                    </div>
                                    <div class="col-md-6"
                                         v-if="(variable_option &&
                                         ((variable == 'worker_record') || (variable == 'vacation')))">
                                        <div class="form-group">
                                            <label for="register">Operador</label>
                                            <select2 :options="operators"
                                                     v-model="operator"></select2>
                                        </div>
                                    </div>
                                    <div class="col-md-6"
                                         v-if="(variable_option &&
                                         ((variable == 'worker_record') || (variable == 'vacation')))">
                                        <div class="form-group">
                                            <label for="value">Valor</label>
                                            <select2 v-if="type == 'list'"
                                                     :options="subOptions"
                                                     v-model="value"></select2>
                                            <div class="col-12"
                                                 v-else-if="type == 'boolean'">
                                                <p-check class="pretty p-switch p-fill p-bigger"
                                                         color="success" off-color="text-gray" toggle
                                                         data-toggle="tooltip"
                                                         title="Indique el valor de comparación (requerido)"
                                                         v-model="value">
                                                    <label slot="off-label"></label>
                                                </p-check>
                                            </div>
                                            <input v-else
                                                   type="text"
                                                   data-toggle="tooltip"
                                                   title="Indique el valor de comparación (requerido)"
                                                   class="form-control input-sm" v-model="value"
                                                   v-input-mask data-inputmask="
                                                       'alias': 'numeric',
                                                       'allowMinus': 'false'">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- calculadora -->
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-12 text-center">
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
                                        <div class="col-sm-12 text-center">
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
                                        <div class="col-sm-12 text-center">
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
                                        <div class="col-sm-12 text-center">
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
                                    <div class="row"
                                         v-if="variable_option">
                                        <div class="col-sm-12 col-btn-block text-center">
                                            <div class="btn btn-info btn-sm" data-toggle="tooltip"
                                                 title="Variable a usar cuando se realice el cálculo"
                                                 :disabled="(((operator == '') ||
                                                 ((value == '') && (type != 'boolean'))) &&
                                                 ((variable == 'worker_record') || (variable == 'vacation')))"
                                                 @click="getCodeVariable()">
                                                {{ updateNameVariable }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- ./calculadora -->
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
							<button type="button" @click="createRecord('payroll/concepts')" 
									class="btn btn-primary btn-sm btn-round btn-modal-save">
								Guardar
							</button>
                        </div>
                    </div>
                    <div class="modal-body modal-table">
                        <v-client-table :columns="columns" :data="records" :options="table_options">
                            <div slot="description" slot-scope="props">
                                <span v-html="props.row.description"></span>
                            </div>
                            <div slot="incidence_type" slot-scope="props">
                                <span> {{ incidence_types[props.row.incidence_type] }} </span>
                            </div>
                            <div slot="id" slot-scope="props" class="text-center">
                                <button @click="initUpdate(props.row.id, $event)"
                                        class="btn btn-warning btn-xs btn-icon  btn-action"
                                        title="Modificar registro" data-toggle="tooltip" type="button">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button @click="deleteRecord(props.index, 'payroll/concepts')"
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
                    id:                          '',
                    name:                        '',
                    code:                        '',
                    description:                 '',
                    active:                      false,
                    affect:                      '',
                    incidence_type:              '',
                    formula:                     '',
                    payroll_concept_type_id:     '',
                    calculation_way:             '',
                    institution_id:              '',
                    assign_to:                   '',
                    payroll_salary_tabulator_id: '',
                    accounting_account_id:       '',
                    budget_account_id:           '',
                    assign_options:              {}

                },
                variable:                  '',
                variable_option:           '',
                assign_options:            {},
                type:                      '',
                value:                     '',
                operator:                  '',
                operators:                 [
                    {"id": "",   "text": "Seleccione..."},
                    {"id": "==", "text": "Igualdad (==)"},
                    {"id": "!=", "text": "Desigualdad (!=)"},
                    {"id": ">",  "text": "Mayor estricto (>)"},
                    {"id": "<",  "text": "Menor estricto (>)"},
                    {"id": ">=", "text": "Mayor o igual (>=)"},
                    {"id": "<=", "text": "Menor o igual (<=)"}
                ],
                subOptions:                [],

                errors:                    [],
                records:                   [],
                columns:                   ['code', 'name', 'description', 'incidence_type', 'id'],

                variable_options:          [],
                institutions:              [],
                payroll_concept_types:     [],
                assign_to:                 [],
                payroll_salary_tabulators: [],
                budget_accounts:           [],
                accounting_accounts:       [],

                calculation_ways:          [
                    {"id": "",          "text": "Seleccione..."},
                    {"id": "formula",   "text": "Fórmula"},
                    {"id": "tabulator", "text": "De acuerdo a tabulador"}
                ],
                affects:                   [
                    {"id": "",                     "text": "Seleccione..."},
                    {"id": "base_salary",          "text": "Salario base"},
                    {"id": "normal_salary",        "text": "Salario normal"},
                    {"id": "dialy_salary",         "text": "Salario diario"},
                    {"id": "comprehensive_salary", "text": "Salario integral"},
                    {"id": "none",                 "text": "Ninguno"}
                ],
                incidence_types: {
                    'value':          'Valor',
                    'absolute_value': 'Valor absoluto',
                    'tax_unit':       'Unidad tributaria',
                    'percent':        'Porcentaje'
                }
            }
        },
        created() {
            const vm = this;
            vm.table_options.headings = {
                'code':           'Código',
                'name':           'Nombre',
                'description':    'Descripción',
                'incidence_type': 'Tipo de incidencia',
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
            $("#add_payroll_concept").on('show.bs.modal', function() {
                vm.reset();
                vm.getPayrollConceptTypes();
                vm.getInstitutions();
                vm.getAccountingAccounts();
                vm.getBudgetAccounts();
                vm.getOptions('payroll/get-associated-records');
                vm.getPayrollConceptAssignTo();
                vm.getPayrollSalaryTabulators();

                $('.BlockDeletion').on('keydown', function (e) {
                    try {
                        if ((e.keyCode == 8) || (e.keyCode == 46))
                            return false;
                        else
                            return true;
                    } catch (Exception) {
                        return false;
                    }
                });
                $('.btn-formula').on('click', function() {
                    let keys = vm.record.formula.indexOf('}');
                    if (keys > 0) {
                        let firstFormula = vm.record.formula.substr(0, keys);
                        let lastFormula = vm.record.formula.substr(keys, vm.record.formula.length);
                        vm.record.formula = firstFormula + $(this).data('value').toString().substr(0, 1) + lastFormula;
                    } else {
                        vm.record.formula += $(this).data('value').toString().substr(0, 1);
                    }
                });
            });
        },
        watch: {
            /**
             * Método que supervisa los cambios en el objeto record y actualiza el tabulador seleccionado
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve> | <henryp2804@gmail.com>
             */
            record: {
                deep: true,
                handler: function() {
                    if (this.record.payroll_salary_tabulator && this.record.payroll_salary_tabulator_id == "") {
                        this.record.payroll_salary_tabulator_id = this.record.payroll_salary_tabulator.id;
                    }
                }
            },
            /**
             * Método que supervisa los cambios en el campo variable y actualiza el listado de opciones
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve> | <henryp2804@gmail.com>
             */
            variable: function(variable) {
                const vm = this;
                vm.operator = vm.value = '';
                if (vm.variable == 'parameter') {
                    vm.getOptions('payroll/get-parameters');

                } else if (vm.variable == 'worker_record') {
                    vm.getOptions('payroll/get-associated-records');
                } else if (vm.variable == 'vacation') {
                    vm.getOptions('payroll/get-vacation-associated-records');
                } else if (vm.variable == 'concept') {
                    vm.variable_options = [
                        {id: '', text: 'Seleccione...'}
                    ];
                    $.each(vm.records, function() {
                        vm.variable_options.push({
                            id: this.code,
                            text: this.name
                        });
                    });
                } else {
                    vm.variable_options = [];
                }
            },
            /**
             * Método que supervisa los cambios en el campo type y actualiza el listado de opciones
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve> | <henryp2804@gmail.com>
             */
            type: function(type) {
                const vm = this;
                if (vm.type == 'list') {
                    axios.get(`${window.app_url}/payroll/get-parameter-options/${vm.variable_option}`).then(response => {
                        vm.subOptions = response.data;
                    });
                } else if (vm.type == 'boolean') {
                    vm.value = false;
                }
            }
        },
        computed: {
            /**
             * Método que actualiza el nombre de la variable a emplear en el cálculo
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve> | <henryp2804@gmail.com>
             * @return    {string}
             */
            updateNameVariable: function() {
                const vm = this;
                var response = '';
                if (vm.variable_option != '') {
                    $.each(vm.variable_options, function(index, field) {
                        if (field['id'] == vm.variable_option) {
                            response = field['text'];
                        } else if (typeof field['children'] !== 'undefined') {
                            $.each(field['children'], function(index, field) {
                                if (field['id'] == vm.variable_option) {
                                    response = field['text'];
                                }
                            });
                        }
                    });
                }
                return response;
            },
            /**
             * Método que actualiza los inputs de opciones a asignar
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve> | <henryp2804@gmail.com>
             * @return    {void}
             */
            updateAssignOptions: function() {
                const vm = this;
                /** Recorrer las opciones "asignar a" para agregar los nuevos inputs */
                $.each(vm.record.assign_to, function(index, field) {
                    if (field['type'] == 'list') {
                        if (typeof(vm.record.assign_options[field['id']] ) == 'undefined') {
                            vm.record.assign_options[field['id']] = [];
                        }
                        if (typeof(vm.assign_options[field['id']] ) == 'undefined') {
                            vm.assign_options[field['id']] = [];
                            axios.get('get-concept-assign-options/' + field['id']).then(response => {
                                vm.assign_options[field['id']] = response.data;
                            });
                        }
                    }
                    if (field['type'] == 'range') {
                        if (typeof(vm.record.assign_options[field['id']] ) == 'undefined') {
                            vm.record.assign_options[field['id']] = {
                                minimum: '',
                                maximum: ''
                            };
                        }
                        if (typeof(vm.assign_options[field['id']] ) == 'undefined') {
                            vm.assign_options[field['id']] = {
                                minimum: '',
                                maximum: ''
                            };
                        }
                    }
                });
                /** Recorrer las opciones "asignar a" para eliminar los inputs desmarcados */
                $.each(vm.record.assign_options, function(index, field) {
                    let id = index;
                    let find = false;
                    $.each(vm.record.assign_to, function(index, field) {
                        if (id == field['id']) {
                            find = true;
                        }
                    });
                    if (!find) {
                        delete vm.record.assign_options[index];
                    }
                });
            }
        },
        methods: {
            /**
             * Método que permite borrar todos los datos del formulario
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve>
             */
            reset() {
                const vm = this;
                vm.variable = '';
                vm.errors = [];
                vm.record = {
                    id:                          '',
                    name:                        '',
                    code:                        '',
                    description:                 '',
                    active:                      false,
                    affect:                      '',
                    incidence_type:              '',
                    formula:                     '',
                    payroll_concept_type_id:     '',
                    calculation_way:             '',
                    institution_id:              '',
                    assign_to:                   '',
                    payroll_salary_tabulator_id: '',
                    accounting_account_id:       '',
                    budget_account_id:           '',
                    assign_options:              {}
                };
            },

            /**
             * Obtiene un listado de cuentas patrimoniales
             *
             * @author    Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             */
            getAccountingAccounts() {
                const vm = this;
                vm.accounting_accounts = [];
                axios.get(`${window.app_url}/accounting/accounts`).then(response => {
                    if (response.data.records.length > 0) {
                        vm.accounting_accounts.push({
                            id:   '',
                            text: 'Seleccione...'
                        });
                        $.each(response.data.records, function() {
                            vm.accounting_accounts.push({
                                id:   this.id,
                                text: `${this.code} - ${this.denomination}`
                            });
                        });
                    }
                }).catch(error => {
                    vm.logs('PayrollConceptsComponent', 258, error, 'getAccountingAccounts');
                });
            },

            /**
             * Obtiene un listado de cuentas presupuestarias
             *
             * @author    Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             */
            getBudgetAccounts() {
                const vm = this;
                vm.budget_accounts = [];
                axios.get(`${window.app_url}/budget/accounts/vue-list`).then(response => {
                    if (response.data.records.length > 0) {
                        vm.budget_accounts.push({
                            id:   '',
                            text: 'Seleccione...'
                        });
                        $.each(response.data.records, function() {
                            vm.budget_accounts.push({
                                id:   this.id,
                                text: `${this.code} - ${this.denomination}`
                            });
                        });
                    }
                }).catch(error => {
                    vm.logs('PayrollConceptsComponent', 258, error, 'getBudgetAccounts');
                });
            },

            /**
             * Método que obtiene un arreglo con las opciones a listar
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve>
             */
            getOptions(url) {
                const vm = this;
                vm.variable_options = [];
                url = (!url.includes('http://') || !url.includes('http://')) 
                      ? `${window.app_url}${(url.startsWith('/'))?'':'/'}${url}` : url;

                axios.get(url).then(response => {
                    vm.variable_options = response.data;
                });
            },
            /**
             * Método que obtiene un arreglo con las opciones de "asignar a" de un concepto
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve>
             */
            getPayrollConceptAssignTo() {
                const vm = this;
                vm.assign_to = [];
                axios.get(`${window.app_url}/payroll/get-concept-assign-to`).then(response => {
                    vm.assign_to = response.data;
                });
            },
            /**
             * Método que obtiene el acrónimo de la variable a emplear en el cálculo
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve> | <henryp2804@gmail.com>
             * @return    {string}
             */
            getCodeVariable() {
                const vm = this;
                var response = '';
                if (((vm.variable != 'worker_record') && (vm.variable != 'vacation')) ||
                    ((vm.operator != '') && (vm.value != '')) ||
                    ((vm.operator != '') && (vm.type == 'boolean'))) {
                    if (vm.variable_option != '') {
                        $.each(vm.variable_options, function(index, field) {
                            if (field['id'] == vm.variable_option) {
                                if (typeof field['code'] !== 'undefined') {
                                    response = field['code'];
                                } else if (typeof field['id'] !== 'undefined') {
                                    response = 'if(' + field['id'] + ' ' + vm.operator + ' ' + vm.value + '){}';
                                }
                            } else if (typeof field['children'] !== 'undefined') {
                                $.each(field['children'], function(index, field) {
                                    if (field['id'] == vm.variable_option) {
                                        if (typeof field['code'] !== 'undefined') {
                                            response = field['code'];
                                        } else if (typeof field['id'] !== 'undefined') {
                                            response = 'if(' + field['id'] + ' ' + vm.operator + ' ' + vm.value + '){}';
                                        }
                                    }
                                });
                            }
                        });
                    }
                    if (response != '') {
                        if (vm.record.formula != '') {
                            let keys = vm.record.formula.indexOf('}');
                            if (keys > 0) {
                                let firstFormula = vm.record.formula.substr(0, keys);
                                let lastFormula = vm.record.formula.substr(keys, vm.record.formula.length);
                                vm.record.formula = firstFormula + response + lastFormula;
                            } else {
                                vm.record.formula += response;
                            }
                        } else {
                            vm.record.formula += response;
                        }
                    }
                }
            },
            getOptionType() {
                const vm = this;
                vm.type = '';
                if (vm.variable_option != '') {
                    $.each(vm.variable_options, function(index, field) {
                        if (field['id'] == vm.variable_option) {
                            if (typeof field['type'] !== 'undefined') {
                                vm.type = field['type'];
                                return;
                            }
                        } else if (typeof field['children'] !== 'undefined') {
                            $.each(field['children'], function(index, field) {
                                if (field['id'] == vm.variable_option) {
                                    if (typeof field['type'] !== 'undefined') {
                                        vm.type = field['type'];
                                        return;
                                    }
                                }
                            });
                        }
                    });
                }
            },
            /**
             * Método que obtiene el estado de la propiedad is-invalid para elementos del formulario
             *
             * @method    isInvalid
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve> | <henryp2804@gmail.com>
             *
             * @param     {string}    elName    Nombre del elemento a buscar
             * @param     {string}    model     Nombre del modelo donde buscar
             */
            isInvalid(elName, model = 'record') {
                const vm = this;
                
                if (typeof vm[model][elName] != 'undefined') {
                    let keys = vm[model][elName].indexOf('/0');
                    return (keys > 0) ? 'is-invalid': '';
                } else {
                    return '';
                }
            },
        }
    };
</script>
