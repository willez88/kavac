<template>
    <section id="warehouseFormComponent">
        <a class="btn-simplex btn-simplex-md btn-simplex-primary"
           href="#" title="Registros de Almacenes" data-toggle="tooltip" v-has-tooltip
           @click="addRecord('add_warehouse', 'warehouse/warehouses', $event)">
            <i class="icofont icofont-building-alt ico-3x"></i>
            <span>Almacenes</span>
        </a>
        <div class="modal fade text-left" tabindex="-1" role="dialog" id="add_warehouse">
            <div class="modal-dialog vue-crud" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h6>
                            <i class="icofont icofont-building-alt ico-2x"></i>
                            Gestión de almacenes
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
                                    <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
                                </ul>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4" v-if="multi_institution">
                                <div class="form-group is-required">
                                    <label>Organización que gestiona el almacén:</label>
                                    <select2 id="institutions_id" :options="institutions"
                                             @input="readRecords('warehouse/institution/' + record.institution_id)"
                                             v-model="record.institution_id">
                                    </select2>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group is-required">
                                    <label>Nombre del almacén:</label>
                                    <input type="text" placeholder="Nombre del almacén" data-toggle="tooltip"
                                           title="Indique el nombre del nuevo almacén (requerido)" v-has-tooltip
                                           class="form-control input-sm" v-model="record.name">
                                    <input type="hidden" v-model="record.id">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="" class="control-label">Principal</label>
                                    <div class="col-12">
                                        <div class="bootstrap-switch-mini">
                                            <input type="checkbox" class="form-control bootstrap-switch"
                                                   name="main" data-toggle="tolltip"
                                                   v-has-tooltip title="Indique si es el almacén principal"
                                                   data-on-label="Si" data-off-label="No" value="true"
                                                   v-model="record.main">
                                            </div>
                                        </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="" class="control-label">Activo</label>
                                    <div class="col-12">
                                        <div class="bootstrap-switch-mini">
                                            <input type="checkbox" class="form-control bootstrap-switch"
                                                   name="active" data-toggle="tolltip"
                                                   v-has-tooltip title="Indique si el estatus del almacén"
                                                   data-on-label="Si" data-off-label="No" value="true"
                                                   v-model="record.active">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <b>Ubicación del almacén</b>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Pais:</label>
                                    <select2 id="input_country" :options="countries" @input="getEstates"
                                             v-model="record.country_id"></select2>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Estado:</label>
                                    <select2 id="input_estate" :options="estates" @input="getMunicipalities"
                                             v-model="record.estate_id"></select2>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Municipio:</label>
                                    <select2 :options="municipalities" @input="getParishes"
                                             v-model="record.municipality_id"></select2>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group is-required">
                                    <label>Parroquia:</label>
                                    <select2 :options="parishes"
                                             v-model="record.parish_id"></select2>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group is-required">
                                    <label>Dirección:</label>
                                    <ckeditor :editor="ckeditor.editor" data-toggle="tooltip"
                                              title="Indique una breve dirección del nuevo almacén (requerido)"
                                              :config="ckeditor.editorConfig" class="form-control" tag-name="textarea"
                                              rows="3" v-model="record.address"></ckeditor>
                                </div>
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
							<button type="button" @click="createRecord('warehouse/warehouses')" 
									class="btn btn-primary btn-sm btn-round btn-modal-save">
								Guardar
							</button>
                        </div>
                    </div>
                    <div class="modal-body modal-table">
                        <hr>
                        <v-client-table :columns="columns" :data="records" :options="table_options">
                            <div slot="name" slot-scope="props">
                                <span>
                                    {{ (props.row.warehouse)?props.row.warehouse.name:'' }}
                                </span>
                            </div>
                            <div slot="country" slot-scope="props">
                                <span>
                                    {{ (props.row.warehouse.parish)?
                                        props.row.warehouse.parish.municipality.estate.country.name:'' }}
                                </span>
                            </div>
                            <div slot="estate" slot-scope="props">
                                <span>
                                    {{ (props.row.warehouse.parish)?
                                        props.row.warehouse.parish.municipality.estate.name:'' }}
                                </span>
                            </div>
                            <div slot="address" slot-scope="props">
                                <span v-html="props.row.warehouse.address"></span>
                            </div>
                            <div slot="institution" slot-scope="props">
                                <span>
                                    {{ (props.row.institution)?
                                        props.row.institution.acronym:'' }}
                                </span>
                            </div>
                            <div slot="active" slot-scope="props">
                                <span v-if="props.row.warehouse.active">Activo</span>
                                <span v-else>Inactivo</span>
                            </div>
                            <div slot="id" slot-scope="props" class="text-center">
                                <div class="d-inline-flex">
                                    <div v-if="multi_warehouse">
                                        <button @click="warehouseManage(props.index, $event)"
                                                class="btn btn-danger btn-xs btn-icon btn-action"
                                                title="Dejar de Gestionar Almacén" data-toggle="tooltip"
                                                type="button"
                                                v-if="props.row.manage">
                                            <i class="fa fa-minus-circle"></i>
                                        </button>
                                        <button @click="warehouseManage(props.index, $event)"
                                                class="btn btn-success btn-xs btn-icon btn-action"
                                                title="Gestionar Almacén" data-toggle="tooltip" type="button"
                                                v-else>
                                            <i class="fa fa-plus-circle"></i>
                                        </button>
                                    </div>
                                    <button @click="editRecord(props.index, $event)"
                                            class="btn btn-warning btn-xs btn-icon btn-action"
                                            title="Modificar registro" data-toggle="tooltip" type="button">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button @click="deleteRecord(props.index, 'warehouse/warehouses')"
                                            class="btn btn-danger btn-xs btn-icon btn-action"
                                            title="Eliminar registro" data-toggle="tooltip"
                                            type="button">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                </div>
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
                    id:              '',
                    name:            '',
                    main:            '',
                    address:         '',
                    institution_id:  '',
                    country_id:      '',
                    estate_id:       '',
                    municipality_id: '',
                    parish_id:       '',

                },

                multi_warehouse:   null,
                multi_institution: null,
                errors:            [],
                records:           [],
                columns:           ['name', 'country', 'estate', 'address', 'institution','active', 'id'],
                institutions:      [],
                countries:         [],
                estates:           [],
                municipalities:    [],
                parishes:          [],
            }
        },
        methods: {
            /**
             * Método que borra todos los datos del formulario
             *
             * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             */
            reset()
            {
                const vm = this;
                vm.record = {
                    id:              '',
                    name:            '',
                    main:            '',
                    address:         '',
                    institution_id:  '',
                    country_id:      '',
                    estate_id:       '',
                    municipality_id: '',
                    parish_id:       '',
                };

                vm.errors = [];
            },
            /**
             * Método que obtiene la configuración del sistema
             *
             * @author Henry Paredes <hparedes@cenditel.gob.ve>
             */
            getSetting(url)
            {
                const vm = this;
                axios.get(url).then(response => {
                    if (typeof(response.data.record) !== "undefined") {
                        vm.multi_institution = (response.data.record != null)
                            ? response.data.record.multi_institution
                            : false;
                        vm.multi_warehouse = (response.data.record != null)
                            ? response.data.record.multi_warehouse
                            : false;
                    }
                });
            },
            /**
             * Método que obtiene actualiza la institución que gestiona un almacén
             *
             * @author Henry Paredes <hparedes@cenditel.gob.ve>
             */
            warehouseManage(index)
            {
                const vm = this;
                var field = {};
                field = this.records[index-1];
                var url = '/warehouse/manage/' + field.id;

                axios.get(url).then(response => {
                    if (typeof(response.data.records) !== "undefined") {
                        vm.records = response.data.records;
                    }
                });
            },
            /**
             * Método que carga los datos de un registro en el formulario para su edición
             *
             * @author Henry Paredes <hparedes@cenditel.gob.ve>
             */
            editRecord(index, event)
            {
                const vm  = this;
                vm.errors = [];
                var field = vm.records[index - 1];
                vm.record = field.warehouse;
                vm.record.institution_id = field.institution_id;
                vm.record.country_id = field.warehouse.parish.municipality.estate.country_id;
                var elements = {
                    active: vm.record.active,
                    main: field.main,
                };

                $.each(elements, function (el, value) {
                    if ($("input[name=" + el + "]").hasClass('bootstrap-switch')) {
                        /**
                         * verifica los elementos bootstrap-switch para seleccionar el que
                         * corresponda según los registros del sistema
                         */
                        $("input[name=" + el + "]").each(function () {
                            if ($(this).val() === value) {
                                $(this).bootstrapSwitch('state', value, true);
                            }
                        });
                    }
                    if (value === true || value === false) {
                        $("input[name=" + el + "].bootstrap-switch").bootstrapSwitch('state', value, true);
                    }
                });
                event.preventDefault();
            },
        },
        created() {
            const vm = this;
            vm.table_options.headings = {
                'name':        'Nombre',
                'country':     'Pais',
                'estate':      'Estado',
                'address':     'Dirección',
                'institution': 'Gestionado por',
                'active':      'Estatus',
                'id':          'Acción'
            };

            vm.table_options.sortable       = [
                'warehouse.name', 'warehouse.parish.municipality.estate.country.name',
                'warehouse.parish.municipality.estate.name', 'warehouse.address', 'institution.acronym', 'active'
            ];
            vm.table_options.filterable     = [
                'warehouse.name', 'warehouse.parish.municipality.estate.country.name',
                'warehouse.parish.municipality.estate.name', 'warehouse.address', 'institution.acronym', 'active'
            ];
            vm.table_options.columnsClasses = {
                'name':        'col-xs-1',
                'country':     'col-xs-2',
                'estate':      'col-xs-2',
                'address':     'col-xs-2',
                'institution': 'col-xs-2',
                'active':      'col-xs-2',
                'id':          'col-xs-1'
            };

            vm.getCountries();
            vm.getInstitutions();
            vm.getSetting('/warehouse/vue-setting');

        },
        mounted() {
            const vm = this;
            vm.switchHandler('main');
            vm.switchHandler('active');
        }
    }
</script>
