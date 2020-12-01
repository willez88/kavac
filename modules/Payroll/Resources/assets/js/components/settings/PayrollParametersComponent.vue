<template>
    <section id="payrollParametersFormComponent">
        <a class="btn-simplex btn-simplex-md btn-simplex-primary" href=""
           title="Registros de parámetros" data-toggle="tooltip"
           @click="addRecord('add_payroll_parameter', 'payroll/parameters', $event)">
           <i class="icofont icofont-globe ico-3x"></i>
           <span>Parámetros<br>Globales</span>
        </a>
        <div class="modal fade text-left" tabindex="-1" role="dialog" id="add_payroll_parameter">
            <div class="modal-dialog vue-crud" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h6>
                            <i class="icofont icofont-globe ico-3x"></i>
                            Parámetro Global de Nómina
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <!-- tipo de parámetro -->
                                        <div class="form-group is-required">
                                            <label for="parameter_type">Tipo de parámetro:</label>
                                            <select2 :options="parameter_types"
                                                     @input="changeParameterType()"
                                                     v-model="record.parameter_type"></select2>
                                        </div>
                                        <!-- ./tipo de parámetro -->
                                    </div>
                                    <div class="col-md-12">
                                        <!-- nombre -->
                                        <div class="form-group is-required">
                                            <label for="name">Nombre:</label>
                                            <input type="text" id="name" placeholder="Nombre"
                                                   class="form-control input-sm" v-model="record.name" data-toggle="tooltip"
                                                   title="Indique el nombre del parámetro (requerido)">
                                            <input type="hidden" name="id" id="id" v-model="record.id">
                                        </div>
                                        <!-- ./nombre -->
                                    </div>
                                    <div class="col-md-6">
                                        <!-- código -->
                                        <div class="form-group is-required">
                                            <label for="code">Código:</label>
                                            <input type="text" id="code" placeholder="Código"
                                                   class="form-control input-sm" v-model="record.code" data-toggle="tooltip"
                                                   title="Indique el código del parámetro (requerido)">
                                        </div>
                                        <!-- ./código -->
                                    </div>
                                    <div class="col-md-6">
                                        <!-- acrónimo -->
                                        <div class="form-group is-required">
                                            <label for="acronym">Acrónimo:</label>
                                            <input type="text" id="acronym" placeholder="Acrónimo"
                                                   class="form-control input-sm" v-model="record.acronym" data-toggle="tooltip"
                                                   title="Indique el acrónimo del parámetro (requerido)">
                                        </div>
                                        <!-- ./acrónimo -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <!-- descripción -->
                                        <div class="form-group">
                                            <label for="description">Descripción:</label>
                                            <ckeditor :editor="ckeditor.editor" id="description"
                                                      data-toggle="tooltip"
                                                      title="Indique la descripción del parámetro"
                                                      :config="ckeditor.editorConfig" class="form-control"
                                                      name="description" tag-name="textarea"
                                                      v-model="record.description"></ckeditor>
                                        </div>
                                        <!-- ./descripción -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6"
                                 v-if="record.parameter_type == 'global_value'">
                                <!-- valor -->
                                <div class="form-group is-required">
                                    <label for="value">Valor:</label>
                                    <input type="number" id="value" placeholder="Valor"
                                           min="0" step=".01" onfocus="this.select()"
                                           class="form-control input-sm" data-toggle="tooltip"
                                           title="Indique el valor del parámetro (requerido)"
                                           v-model="record.value">
                                </div>
                                <!-- ./valor -->
                            </div>
                            <div class="col-md-6"
                                 v-if="record.parameter_type == 'global_value'">
                                <!-- porcentaje -->
                                <div class="form-group">
                                    <label for="percentage">¿Porcentaje?</label>
                                    <div class="col-12">
                                        <p-check class="pretty p-switch p-fill p-bigger"
                                                 color="success" off-color="text-gray" toggle
                                                 data-toggle="tooltip"
                                                 title="Indique si el valor indicado está expresado en porcentaje (requerido)"
                                                 v-model="record.percentage">
                                            <label slot="off-label"></label>
                                        </p-check>
                                    </div>
                                </div>
                                <!-- ./porcentaje -->
                            </div>
                            <div class="col-md-6"
                                 v-show="record.parameter_type == 'processed_variable'">
                                <!-- fórmula -->
                                <div class="form-group is-required">
                                    <label for="formula">Fórmula:</label>
                                    <textarea type="text"
                                              class="form-control input-sm BlockDeletion" data-toggle="tooltip"
                                              title="Fórmula a aplicar para la variable. Utilice la siguiente calculadora para establecer los parámetros de la fórmula"
                                              rows="3" v-model="record.formula"
                                              autocomplete="off"
                                              onkeypress="return (event.charCode >= 24 && event.charCode <= 27)">
                                    </textarea>
                                </div>
                                <!-- ./fórmula -->
                                <div class="row">
                                    <div class="col-6 col-md-6">
                                        <div class="form-group">
                                            <label for="worker_record">¿Expediente del Trabajador?</label>
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
                                    <div class="col-6 col-md-6">
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
                                    <div class="col-md-12"
                                         v-if="variable">
                                        <!-- opciones -->
                                        <div class="form-group">
                                            <label for="register">Registro</label>
                                            <select2 :options="options"
                                                     @input="getOptionType"
                                                     v-model="variable_option"></select2>
                                        </div>
                                        <!-- ./opciones -->
                                    </div>
                                    <div class="col-md-6"
                                         v-if="(variable_option && variable == 'worker_record')">
                                        <div class="form-group">
                                            <label for="register">Operador</label>
                                            <select2 :options="operators"
                                                     v-model="operator"></select2>
                                        </div>
                                    </div>
                                    <div class="col-md-6"
                                         v-if="(variable_option && variable == 'worker_record')">
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
                            <div class="col-md-6"
                                 v-show="record.parameter_type == 'processed_variable'">
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
                                                 (variable == 'worker_record'))"
                                                 @click="getAcronymVariable()">
                                                {{ updateNameVariable }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ./calculadora -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group">
                            <modal-form-buttons :saveRoute="'payroll/parameters'"></modal-form-buttons>
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
                                <button @click="deleteRecord(props.index, 'parameters')"
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
                    name:           '',
                    code:           '',
                    acronym:        '',
                    description:    '',
                    parameter_type: '',
                    percentage:     false,
                    value:          '',
                    formula:        ''
                },
                variable:        '',
                variable_option: '',

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


                errors:          [],
                records:         [],
                columns:         ['name', 'code', 'acronym', 'description', 'id'],
                options:         [],
                parameter_types: []
            }
        },
        created() {
            const vm = this;
            vm.table_options.headings = {
                'name':        'Nombre',
                'code':        'Código',
                'acronym':     'Acrónimo',
                'description': 'Descripción',
                'id':          'Acción'
            };
            vm.table_options.sortable       = ['name', 'code', 'acronym', 'description'];
            vm.table_options.filterable     = ['name', 'code', 'acronym', 'description'];
            vm.table_options.columnsClasses = {
                'name':        'col-xs-2',
                'code':        'col-xs-2',
                'acronym':     'col-xs-2',
                'description': 'col-xs-4',
                'id':          'col-xs-2'
            };
        },
        mounted() {
            const vm = this;
            $("#add_payroll_parameter").on('show.bs.modal', function() {
                vm.reset();
                vm.getPayrollParameterTypes();
                vm.getOptions('payroll/get-associated-records');

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
                        vm.record.formula = firstFormula + $(this).data('value') + lastFormula;
                    } else {
                        vm.record.formula += $(this).data('value');
                    }
                });
            });
        },
        watch: {
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
                    axios.get('/payroll/get-parameter-options/' + vm.variable_option).then(response => {
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
                    vm.options.forEach(function(value, index) {
                        if (value.id == vm.variable_option) {
                            response = value.text;
                        } else if (typeof value.children !== 'undefined') {
                            value.children.forEach(function(value, index) {
                                if (value.id == vm.variable_option) {
                                    response = value.text;
                                }
                            });
                        }
                    });
                }
                return response;
            }
        },
        methods: {
            /**
             * Método que borra todos los datos del formulario
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve>
             */
            reset() {
                const vm    = this;
                vm.errors   = [];
                vm.record   = {
                    id:             '',
                    name:           '',
                    code:           '',
                    acronym:        '',
                    description:    '',
                    parameter_type: '',
                    percentage:     false,
                    value:          '',
                    formula:        ''
                };
                vm.variable = '';
            },
            /**
             * Método que borra los campos comunes del formulario
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve>
             */
            changeParameterType() {
                const vm = this;

                if (vm.record.parameter_type == 'processed_variable') {
                    vm.variable = '';
                } else if (vm.record.parameter_type == 'global_value') {
                    vm.variable       = '';
                    vm.record.formula = '';

                } else if (vm.record.parameter_type == 'resettable_variable') {
                    vm.variable          = '';
                    vm.record.formula    = '';
                    vm.record.percentage = false;
                }
            },
            /**
             * Método que obtiene un arreglo con los tipos de parámetros
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve>
             */
            getPayrollParameterTypes() {
                const vm = this;
                vm.parameter_types = [];
                axios.get('/payroll/get-parameter-types').then(response => {
                    vm.parameter_types = response.data;
                });
            },
            /**
             * Método que obtiene un arreglo con las opciones a listar
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve>
             */
            getOptions(url) {
                const vm = this;
                vm.options = [];
                axios.get('/' + url).then(response => {
                    vm.options = response.data;
                });
            },
            /**
             * Método que obtiene el acrónimo de la variable a emplear en el cálculo
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve> | <henryp2804@gmail.com>
             * @return    {string}
             */
            getAcronymVariable() {
                const vm = this;
                let response = '';
                if ((vm.variable != 'worker_record') ||
                    ((vm.operator != '') && (vm.value != '')) ||
                    ((vm.operator != '') && (vm.type == 'boolean'))) {
                    if (vm.variable_option != '') {
                        $.each(vm.options, function(index, field) {
                            if (field['id'] == vm.variable_option) {
                                if (typeof field['acronym'] !== 'undefined') {
                                    response = field['acronym'];
                                } else if (typeof field['id'] !== 'undefined') {
                                    response = 'if(' + field['id'] + ' ' + vm.operator + ' ' + vm.value + '){}';
                                }
                            } else if (typeof field['children'] !== 'undefined') {
                                $.each(field['children'], function(index, field) {
                                    if (field['id'] == vm.variable_option) {
                                        if (typeof field['acronym'] !== 'undefined') {
                                            response = field['acronym'];
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
                            let firstFormula = vm.record.formula.substr(0, keys);
                            let lastFormula = vm.record.formula.substr(keys, vm.record.formula.length);
                            vm.record.formula = firstFormula + response + lastFormula;
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
                    $.each(vm.options, function(index, field) {
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
            }
        }
    };
</script>
