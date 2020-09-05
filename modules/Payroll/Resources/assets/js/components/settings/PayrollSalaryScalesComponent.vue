<template>
    <section id="payrollSalaryScalesFormComponent">
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
                                <div class="row">
                                    <div class="col-md-12">
                                        <!-- agrupar por -->
                                        <div class="form-group is-required">
                                            <label for="group_by">Agrupar por:</label>
                                            <select2 :options="payroll_salary_tabulators_groups"
                                                     @input="getOptions()"
                                                     v-model="record.group_by"></select2>
                                        </div>
                                        <!-- ./agrupar por -->
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
                            <div class="row">
                                <div class="col-7 pad-top-10 with-border with-radius table-responsive"
                                     style="place-self: baseline;" 
                                     v-if="record.group_by">
                                    <h6 class="text-center">Escalas o Niveles del Escalafón</h6>
                                    <div class="row" v-if="record.payroll_scales.length == 0">
                                        <div class="col-md-12">
                                            <div class="alert alert-info" role="alert">
                                                <div class="container">
                                                    <div class="alert-icon">
                                                        <i class="now-ui-icons travel_info"></i>
                                                    </div>
                                                    <strong>No se encontraron registros</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-else>
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
                                                        <span v-else-if="type == 'boolean'">
                                                            {{ field.value?'SI':'NO' }}
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
                                     v-if="record.group_by">
                                    <h6 class="text-center">Nueva Escala</h6>
                                    <div class="row" style="align-items: flex-end;"
                                         v-if="type != 'boolean'
                                            && type != 'list'">
                                        <strong class="col-md-12">
                                            Expresado en
                                        </strong>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Valor Puntual</label>
                                                <div class="col-12">
                                                    <p-radio class="pretty p-switch p-fill p-bigger"
                                                             color="success" off-color="text-gray" toggle
                                                             data-toggle="tooltip"
                                                             title="Indique si el valor está expresado puntualmente"
                                                             @change="resetScales()"
                                                             v-model="type" value="value">
                                                        <label slot="off-label"></label>
                                                    </p-radio>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4 col-md-4">
                                            <div class="form-group">
                                                <label>Rango</label>
                                                <div class="col-12">
                                                    <p-radio class="pretty p-switch p-fill p-bigger"
                                                             color="success" off-color="text-gray" toggle
                                                             data-toggle="tooltip"
                                                             title="Indique si el valor está expresado en rangos"
                                                             @change="resetScales()"
                                                             v-model="type" value="range">
                                                        <label slot="off-label"></label>
                                                    </p-radio>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
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
                                    <div class="row">
                                        <div class="col-md-12"
                                             v-if="type == 'list'">
                                            <div class="form-group">
                                                <label>Valor:</label>
                                                <select2 :options="options"
                                                         v-model="scale.value"></select2>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12"
                                             v-if="type == 'value'">
                                            <div class="form-group is-required">
                                                <label>Valor</label>
                                                <input type="number" placeholder="Valor"
                                                       class="form-control input-sm" data-toggle="tooltip"
                                                       title="Indique la cantidad (requerido)"
                                                       v-model="scale.value" min="0" onfocus="this.select()">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12"
                                             v-if="type == 'range'">
                                            <div class="form-group is-required">
                                                <label>Desde</label>
                                                <input id="scale-value-from"
                                                       type="number" placeholder="Valor"
                                                       class="form-control input-sm" data-toggle="tooltip"
                                                       title="Indique la cantidad (requerido)"
                                                       min="0" step=".01" onfocus="this.select()">
                                            </div>
                                            <div class="form-group is-required">
                                                <label>Hasta</label>
                                                <input id="scale-value-to"
                                                       type="number" placeholder="Valor"
                                                       class="form-control input-sm" data-toggle="tooltip"
                                                       title="Indique la cantidad (requerido)"
                                                       min="0" step=".01" onfocus="this.select()">
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
                                    <div class="row">
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
                                <button @click="editSalaryScale(props.row.id, $event)"
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
                    payroll_scales: []
                },
                scale: {
                    id:    '',
                    name:  '',
                    value: ''
                },

                type:                             '',
                errors:                           [],
                records:                          [],
                columns:                          ['name', 'description', 'active', 'id'],
                options:                          [],
                institutions:                     [],
                payroll_salary_tabulators_groups: [],
                resetScale:                       true,
                editIndex:                        null
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
             * @author    Henry Paredes <hparedes@cenditel.gob.ve>
             * @return    {string}
             */
            getGroupBy: function() {
                const vm = this;
                let response = '';
                $.each(vm.payroll_salary_tabulators_groups, function(index, field) {
                    if (typeof(field['children']) != 'undefined') {
                        $.each(field['children'], function(index, field) {
                            if (vm.record.group_by == field['id']) {
                                response = field['text'];
                                if (field['type'] == 'list') {
                                    vm.options = [];
                                    axios.get('get-parameter-options/' + field['id']).then(response => {
                                        vm.options = response.data;
                                    });
                                }
                            }
                        });
                    }
                });
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
                vm.resetScales();
            },
            /**
             * Método que borra los campos del formulario de la escala
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve>
             *
             */
            resetScales() {
                const vm = this;
                vm.scale = {
                    id:    '',
                    name:  '',
                    value: ''
                };
                vm.editIndex = null;
                $("#scale-value-from").val('');
                $("#scale-value-to").val('');
                if (vm.resetScale) {
                    vm.record.payroll_scales = [];
                } else {
                    vm.resetScale = true;
                }
            },
            /**
             * Método que carga el formulario con los datos a modificar
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve>
             *
             * @param     {integer}    id       Identificador del registro a ser modificado
             * @param     {object}     event    Objeto que gestiona los eventos
             */
            editSalaryScale(id, event) {
                let vm = this;
                vm.resetScale = false;
                vm.initUpdate(id, event);
            },
            /**
             * Método que obtiene el valor de la escala según el identificador único
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve>
             *
             * @param     {string}    value    Objeto json que contiene el id de la escala
             * @return    {string}
             */
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
            /**
             * Método que obtiene los parámetros de opciones
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve>
             */
            getOptions() {
                const vm = this;
                $.each(vm.payroll_salary_tabulators_groups, function(index, field) {
                    if (typeof(field['children']) != 'undefined') {
                        $.each(field['children'], function(index, field) {
                            if (vm.record.group_by == field['id']) {
                                vm.type = field['type'];
                                if (field['type'] == 'list') {
                                    vm.options = [];
                                    axios.get('get-parameter-options/' + field['id']).then(response => {
                                        vm.options = response.data;
                                    });
                                }
                            }
                        });
                    }
                });
                vm.resetScales();
            },
            /**
             * Método que obtiene los grupos de tabuladores salariales registrados
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve>
             */
            getPayrollSalaryTabulatorsGroups() {
                const vm = this;
                vm.payroll_salary_tabulators_groups = [];
                axios.get('get-salary-tabulators-groups').then(response => {
                    vm.payroll_salary_tabulators_groups = response.data;
                });
            },
            /**
             * Método que agrega una nueva escala
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve>
             *
             * @param     {object}    event    Objeto que gestiona los eventos
             */
            addScale(event) {
                const vm = this;
                var field = {};
                if ((vm.scale.name == '')   ||
                    ((vm.scale.value == '') && (vm.type != 'boolean') && (vm.type != 'range'))) {
                    return false;
                }

                for (var index in vm.scale) {
                    if (index == 'value') {
                        if (vm.type == 'range') {
                            var fromValue = $("#scale-value-from").val();
                            var toValue   = $("#scale-value-to").val();
                            if ((fromValue == '') ||
                                (toValue == '')) {
                                return false;
                            }
                            field[index] = {
                                from: fromValue,
                                to:   toValue
                            };
                        } else {
                            field[index] = vm.scale[index];
                        }

                    } else {
                        field[index] = vm.scale[index];
                    }
                }
                if(vm.editIndex == null)
                    vm.record.payroll_scales.push(field);
                else {
                    vm.record.payroll_scales[vm.editIndex] = field;
                }
                vm.resetScale = false;
                vm.resetScales();
                event.preventDefault();
            },
            /**
             * Método que carga el formulario de la escala con los datos a modificar
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve>
             *
             * @param     {integer}    index    Identificador del registro a ser modificado
             * @param     {object}     event    Objeto que gestiona los eventos
             */
            editScale(index, event){
                const vm = this;
                vm.editIndex = index;
                if (vm.type == 'range') {
                    vm.scale = {
                        id:    vm.record.payroll_scales[index].id,
                        name:  vm.record.payroll_scales[index].name,
                        value: ''
                    };
                    $("#scale-value-from").val(vm.record.payroll_scales[index].value.from);
                    $("#scale-value-to").val(vm.record.payroll_scales[index].value.to);
                } else {
                    vm.scale = {
                        id:    vm.record.payroll_scales[index].id,
                        name:  vm.record.payroll_scales[index].name,
                        value: JSON.parse(vm.record.payroll_scales[index].value)
                    };
                }
                event.preventDefault();
            },
            /**
             * Método que elimina el elemento seleccionado
             *
             * @author    Henry Paredes <hparedes@cenditel.gob.ve>
             *
             * @param     {integer}    index    Identificador del registro a eliminar
             * @param     {object}     event    Objeto que gestiona los eventos
             */
            removeScale(index, event) {
                const vm = this;
                vm.record.payroll_scales.splice(index, 1);
                vm.editIndex = null;
                event.preventDefault();
            },
        }
    };
</script>
