<template>
<section id="SaleTechnicalProposalForm">
    <div class="card-body">
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
        <div id="HelpServiceSection">
            <div class="row">
                <div class="col-md-12">
                    <b>Datos del solicitante</b>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Cliente:</label>
                        <select2 :options="sale_clients_rif"
                                 v-model="service.sale_client_id" @input="getSaleClient" :disabled="true"></select2>
                    </div>
                </div>
                <div class="col-md-3">
                    <div v-show="service.sale_client_id != 0" class="form-group">
                        <label for="sale_clients_email">Correo:</label>
                        <p v-for="email in sale_client.sale_clients_email">
                            <input type="text" class="form-control input-sm" :disabled="true"
                                data-toggle="tooltip" title="Dirección"
                                id="email" v-model="email.email"></input>
                        </p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div v-show="service.sale_client_id != 0" class="form-group">
                        <label for="phones">Número telefónico:</label>
                        <p v-for="phone in sale_client.phones">
                            <input type="text" class="form-control input-sm" :disabled="true"
                                data-toggle="tooltip" title="Dirección fiscal"
                                id="phone" v-model="((phone.extension == null )? '00' : phone.extension) + '-' + phone.area_code + phone.number"></input>
                        </p>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="applicant_organization">Organización:</label>
                        <input type="text" class="form-control input-sm"
                            data-toggle="tooltip" title="Dirección" 
                            v-model="service.organization" :disabled="true" id="applicant_organization"></input>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="economic_activity">Descripción de la actividad económica:</label>
                        <textarea type="text" class="form-control input-sm"
                            data-toggle="tooltip" title="Dirección fiscal" 
                            v-model="service.description" :disabled="true" id="economic_activity"></textarea>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <b>Datos de la solicitud de servicios</b>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Servicio:</label>
                        <p v-for="good_to_be_traded in sale_goods_to_be_traded">
                            <input type="text" class="form-control input-sm"
                                data-toggle="tooltip" title="Servicio"
                                :disabled="true"
                                id="service_description" v-model="good_to_be_traded.name"></input>
                        </p>
                    </div>
                </div>
                <div v-if="service.sale_goods_to_be_traded && service.sale_goods_to_be_traded.length > 0" class="col-md-3">
                    <div class="form-group">
                        <label for="applicant_name">Descripción:</label>
                        <p v-for="good_to_be_traded in sale_goods_to_be_traded">
                            <input type="text" class="form-control input-sm"
                                data-toggle="tooltip" title="Descripción"
                                :disabled="true"
                                id="service_description" v-model="good_to_be_traded.description"></input>
                        </p>
                    </div>
                </div>
                <div class="col-md-3" v-if="service.sale_goods_to_be_traded && service.sale_goods_to_be_traded.length > 0">
                    <div class="form-group">
                        <label for="applicant_name">Unidad o departamento:</label>
                        <p v-for="good_to_be_traded in sale_goods_to_be_traded">
                            <input type="text" class="form-control input-sm"
                                data-toggle="tooltip" title="Unidad o departamento"
                                :disabled="true"
                                id="service_department" v-model="good_to_be_traded.department"></input>
                        </p>
                        <br>
                    </div>
                </div>
                <div class="col-md-3" v-if="service.sale_goods_to_be_traded && service.sale_goods_to_be_traded.length > 0">
                    <div id="saleServiceName" class="form-group">
                        <label for="applicant_name">Nombre:</label>
                        <p v-for="good_to_be_traded in sale_goods_to_be_traded">
                            <input type="text" class="form-control input-sm"
                                data-toggle="tooltip" title="Nombre"
                                :disabled="true"
                                id="staff_name" v-model="good_to_be_traded.staff_name"></input>
                        </p>
                    </div>
                </div>
                <div class="col-md-3" v-if="service.sale_goods_to_be_traded && service.sale_goods_to_be_traded.length > 0">
                    <div id="saleServiceLastname" class="form-group">
                        <label for="applicant_name">Apellido:</label>
                        <p v-for="good_to_be_traded in sale_goods_to_be_traded">
                            <input type="text" class="form-control input-sm"
                                data-toggle="tooltip" title="Apellido"
                                :disabled="true"
                                id="staff_last_name" v-model="good_to_be_traded.staff_last_name"></input>
                        </p>
                    </div>
                </div>
                <div class="col-md-3" v-if="service.sale_goods_to_be_traded && service.sale_goods_to_be_traded.length > 0">
                    <div id="saleServicePhone" class="form-group">
                        <label for="applicant_name">Teléfono:</label>
                        <p v-for="good_to_be_traded in sale_goods_to_be_traded">
                            <input type="text" class="form-control input-sm"
                                data-toggle="tooltip" title="Teléfono"
                                :disabled="true"
                                id="staff_phone" v-model="good_to_be_traded.staff_phone"></input>
                        </p>
                    </div>
                </div>
                <div class="col-md-3" v-if="service.sale_goods_to_be_traded && service.sale_goods_to_be_traded.length > 0">
                    <div id="saleServiceEmail" class="form-group">
                        <label for="applicant_name">Correo electrónico:</label>
                        <p v-for="good_to_be_traded in sale_goods_to_be_traded">
                            <input type="text" class="form-control input-sm"
                                data-toggle="tooltip" title="Correo electrónico"
                                :disabled="true"
                                id="staff_email" v-model="good_to_be_traded.staff_email"></input>
                        </p>
                    </div>
                </div>
                <br>
            </div>
        </div>
        <hr>
        <div class="row" id="HelpServiceFeatures">
            <div class="col-md-12">
                <b>Características del servicio</b>
            </div>
            <div class="col-md-3" id="HelpSubservices">
                <div class="form-group is-required">
                    <label>Subservicio:</label>
                    <v-multiselect :options="list_subservices" track_by="text"
                                   :hide_selected="false" data-toggle="tooltip"
                                   title="Indique los subservicios a seleccionar"
                                   v-model="sale_list_subservices">
                    </v-multiselect>
                </div>
            </div>
            <div class="col-md-3" id="HelpDuration">
                <div class="form-group is-required">
                    <label for="duration">Duración:</label>
                        <input type="text" class="form-control input-sm"
                            data-toggle="tooltip" title="Duración"
                            id="duration" v-model="record.duration"
                            v-input-mask data-inputmask="
                                       'alias': 'numeric',
                                       'allowMinus': 'false'"></input>
                </div>
            </div>
            <div class="col-md-3" id="HelpFrecuency">
                <div class="form-group is-required">
                    <label>Duración:</label>
                    <select2 :options="frecuencies"
                             v-model="record.frecuency_id"></select2>
                </div>
            </div>
            <div class="col-md-12" id="HelpTechnicalSpecifications">
                <h6 class="card-title">Especificaciones técnicas <i class="fa fa-plus-circle cursor-pointer"
                    @click="addSpecification()"></i></h6>
                <div class="row" v-for="(specification, index) in record.specifications">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="specification">Especificaciones técnicas:</label>
                            <input type="text" id="specification" class="form-control input-sm" data-toggle="tooltip"
                                title="Requerimiento del solicitante" v-model="specification.name">
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="form-group">
                            <button class="mt-4 btn btn-sm btn-danger btn-action" type="button" @click="removeRow(index, record.specifications)"
                                title="Eliminar este dato" data-toggle="tooltip">
                                    <i class="fa fa-minus-circle"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12" id="HelpClientRequirements">
                <h6 class="card-title">Requerimientos que serán suministrados por el cliente <i class="fa fa-plus-circle cursor-pointer"
                    @click="addRequirement()"></i></h6>
                <div class="row" v-for="(requirement, index) in record.requirements">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="requirement">Requerimiento:</label>
                            <input type="text" id="requirement" class="form-control input-sm" data-toggle="tooltip"
                                title="Requerimiento del solicitante" v-model="requirement.name">
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="form-group">
                            <button class="mt-4 btn btn-sm btn-danger btn-action" type="button" @click="removeRow(index, record.requirements)"
                                title="Eliminar este dato" data-toggle="tooltip">
                                    <i class="fa fa-minus-circle"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <b>Personal técnico a utilizar</b>
            </div>
            <div class="col-md-3" id="HelpStaff">
                <div class="form-group">
                    <label>Lista de trabajadores:</label>
                    <v-multiselect :options="payroll_staffs_assignations" track_by="text"
                                   :hide_selected="false" data-toggle="tooltip"
                                   title="Indique los trabajadores a seleccionar"
                                   v-model="payroll_staffs_assigned">
                    </v-multiselect>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="equipment" role="tabpanel">
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <b>Equipos a utilizar</b>
                </div>
                <br>
                <div class="col-md-12" id="HelpStaffEquipments">
                    <v-client-table :columns="columns_assets" :data="records" :options="table_options" ref="tableResults">
                        <div slot="inventory_serial" slot-scope="props" class="text-center">
                            <p v-for="assets in props.row.asset_asignation_assets">
                                {{ props.row.asset_asignation_assets ? assets.asset.inventory_serial : '' }}
                            </p>
                        </div>
                        <div slot="payroll_staff" slot-scope="props" class="text-center">
                            {{ props.row.payroll_staff ? props.row.payroll_staff.first_name + ' ' + props.row.payroll_staff.last_name + ' - ' + props.row.payroll_staff.id_number : '' }}
                        </div>
                        <div slot="serial" slot-scope="props" class="text-center">
                            <p v-for="assets in props.row.asset_asignation_assets">
                                {{ props.row.asset_asignation_assets ? assets.asset.serial : '' }}
                            </p>
                        </div>
                        <div slot="marca" slot-scope="props" class="text-center">
                            <p v-for="assets in props.row.asset_asignation_assets">
                                {{ props.row.asset_asignation_assets ? assets.asset.marca : '' }}
                            </p>
                        </div>
                        <div slot="model" slot-scope="props" class="text-center">
                            <p v-for="assets in props.row.asset_asignation_assets">
                                {{ props.row.asset_asignation_assets ? assets.asset.model : '' }}
                            </p>
                        </div>
                    </v-client-table>
                </div>
            </div>
        </div>
        <hr>
        <div id="HelpGanttDiagramSection">
            <div class="row">
                <div class="col-md-12">
                    <b>Diagrama de Gantt</b>
                </div>
                <br>
                <br>
                <div class="col-md-12">
                    <b>Etapas</b>
                </div>
                <div class="col-md-3" id="HelpStageName">
                    <div class="form-group is-required">
                        <label for="gantt_stage">Etapa:</label>
                        <input type="text" class="form-control input-sm"
                            data-toggle="tooltip" title="Etapa"
                            v-model="stage.stage" id="gantt_stage"></input>
                    </div>
                </div>
                <div class="col-md-3" id="HelpStageDescription">
                    <div class="form-group">
                        <label for="gantt_description">Descripción:</label>
                        <textarea type="text" class="form-control input-sm"
                            data-toggle="tooltip" title="Descripción"
                            v-model="stage.description" id="gantt_description"></textarea>
                    </div>
                </div>
                <div class="col-md-12"></div>
                <div class="col-md-6">
                    <button type="button" @click="addStage($event)" class="btn btn-sm btn-primary btn-custom float-right"
                            title="Agregar registro a la lista"
                            data-toggle="tooltip">
                        <i class="fa fa-plus-circle"></i>
                        Agregar
                    </button>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <b>Actividades</b>
                </div>
                <div class="col-md-3" id="HelpActivityStage">
                    <div class="form-group is-required">
                        <label>Etapas:</label>
                            <select2 :options="stages"
                                        v-model="activity.stage_id" @input="activityStages()"></select2>
                    </div>
                </div>
                <div class="col-md-3" id="HelpActivityName">
                    <div class="form-group is-required">
                        <label for="gantt_stage">Actividad:</label>
                        <input type="text" class="form-control input-sm"
                            data-toggle="tooltip" title="Actividad"
                            v-model="activity.name" id="gantt_stage"></input>
                    </div>
                </div>
                <div class="col-md-3" id="HelpActivityDescription">
                    <div class="form-group">
                        <label for="gantt_description">Descripción:</label>
                        <textarea type="text" class="form-control input-sm"
                            data-toggle="tooltip" title="Descripción"
                            v-model="activity.description" id="gantt_description"></textarea>
                    </div>
                </div>
                <div class="col-md-3" id="HelpActivityStartDate">
                    <div class="form-group is-required">
                        <label>Fecha de inicio:</label>
                        <div class="input-group input-sm">
                            <span class="input-group-addon">
                                <i class="now-ui-icons ui-1_calendar-60"></i>
                            </span>
                            <input type="date" data-toggle="tooltip" title="Indique la fecha de inicio"
                                   class="form-control input-sm no-restrict" v-model="activity.start_date">
                        </div>
                    </div>
                </div>
                <div class="col-md-3" id="HelpActivityEndDate">
                    <div class="form-group is-required">
                        <label>Fecha de fin:</label>
                        <div class="input-group input-sm">
                            <span class="input-group-addon">
                                <i class="now-ui-icons ui-1_calendar-60"></i>
                            </span>
                            <input type="date" data-toggle="tooltip" title="Indique la fecha de fin"
                                   class="form-control input-sm no-restrict" v-model="activity.end_date">
                        </div>
                    </div>
                </div>
                <div class="col-md-3" id="HelpActivityStaff">
                    <div class="form-group is-required">
                        <label>Trabajador:</label>
                            <select2 :options="payroll_staffs" v-model="activity.payroll_staff_id"
                                        @input="activityStaff()"></select2>
                    </div>
                </div>
                <div class="col-md-3" id="HelpActivityPercentage">
                    <div class="form-group is-required">
                        <label>Porcentaje:</label>
                            <input class="form-control input-sm" type="text"
                                       v-model="activity.percentage" required
                                       v-input-mask data-inputmask="
                                       'alias': 'numeric',
                                       'allowMinus': 'false'"/>
                    </div>
                </div>
                <div class="col-md-12">
                    <button type="button" @click="addActivity($event)" class="btn btn-sm btn-primary btn-custom float-right"
                            title="Agregar registro a la lista"
                            data-toggle="tooltip">
                        <i class="fa fa-plus-circle"></i>
                        Agregar
                    </button>
                </div>
            </div>
            <br>
            <br>
            <br>
            <div class="row">
                <div class="col-md-12" id="HelpActivitiesTable">
                    <v-client-table :columns="columns_activities" :data="record.activities" :options="table_option_activities">
                        <div slot="id" slot-scope="props" class="text-center">
                            <div class="d-inline-flex">
                                <button @click="editActivity(props.index, $event)"
                                        class="btn btn-warning btn-xs btn-icon btn-action"
                                        title="Modificar registro" data-toggle="tooltip" type="button">
                                    <i class="fa fa-edit"></i>
                                </button>

                                <button @click="removeActivity(props.index, $event)"
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
    <div class="card-footer text-right">
        <div class="row">
            <div class="col-md-3 offset-md-9" id="HelpButtons">
                <button type="button" @click="reset()"
                        class="btn btn-default btn-icon btn-round"
                        title ="Borrar datos del formulario">
                        <i class="fa fa-eraser"></i>
                </button>

                <button type="button"
                        class="btn btn-warning btn-icon btn-round btn-modal-close"
                        data-dismiss="modal"
                        title="Cancelar y regresar">
                        <i class="fa fa-ban"></i>
                </button>

                <button type="button"  @click="createRecord('sale/technical-proposals')"
                        class="btn btn-success btn-icon btn-round btn-modal-save"
                        title="Guardar registro">
                    <i class="fa fa-save"></i>
                </button>
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
                sale_service_id: '',
                duration: '',
                frecuency_id: '',
                sale_list_subservices: [],
                payroll_staffs: [],
                requirements: [],
                specifications: [],
                activities: [],
            },
            service: {
                id: '',
                organization: '',
                description: '',
                resume: '',
                sale_goods_to_be_traded: [],
                requirements: [],
                sale_client_id: '',
            },
            sale_goods_to_be_traded: [],
            sale_list_subservices: [],
            services: [],
            records: [],
            errors: [],
            sale_client: {
                name : '',
                phones : '',
                sale_clients_email : '',
            },
            sale_clients_rif: [],
            sale_clients_name: [],
            sale_clients_address: [],
            sale_clients_fiscal_address: [],
            list_subservices: [],
            frecuencies: [],
            payroll_staffs_assignations: [],
            payroll_staffs_assigned: [],
            payroll_staffs: [],
            stage: {
                stage: '',
                description: '',
            },
            stages: [{
                id: '',
                text: 'Seleccione...'
            }],
            activity: {
                stage: {},
                stage_id: '',
                name: '',
                description: '',
                start_date: '',
                end_date: '',
                payroll_staff_id: '',
                percentage: '',
                payroll_staff: {},
            },
            columns_assets: ['inventory_serial','payroll_staff','serial','marca','model'],
            columns_activities: ['stage','name','description','start_date','end_date', 'payroll_staff', 'percentage', 'id'],
            table_option_activities: [],
            editIndex: null,
        }
    },
    watch: {
        /**
         * Método que supervisa los cambios en el objeto sale_goods_to_be_traded para asignar sus valores
         * en el record
         *
         * @author    Daniel Contreras <dcontreras@cenditel.gob.ve> | <exodiadaniel@gmail.com>
         *
         * @param     {object}    value    Objeto que contiene el valor de a búsqueda
         */
        sale_goods_to_be_traded() {
            const vm = this;
            vm.record.sale_goods_to_be_traded = [];

            for (let good_to_be_traded of vm.sale_goods_to_be_traded){
                let good_to_be_traded_id = good_to_be_traded.id;
                vm.record.sale_goods_to_be_traded.push(good_to_be_traded_id);
            }
        },

        /**
         * Método que supervisa los cambios en el objeto sale_list_subservices para asignar sus valores
         * en el record
         *
         * @author    Daniel Contreras <dcontreras@cenditel.gob.ve> | <exodiadaniel@gmail.com>
         *
         * @param     {object}    value    Objeto que contiene el valor de a búsqueda
         */
        sale_list_subservices() {
            const vm = this;
            vm.record.sale_list_subservices = [];

            for (let subservice of vm.sale_list_subservices){
                let subservice_id = subservice.id;
                vm.record.sale_list_subservices.push(subservice_id);
            }
        },

        /**
         * Método que supervisa los cambios en el objeto payroll_staffs_assigned para asignar sus valores
         * en el record
         *
         * @author    Daniel Contreras <dcontreras@cenditel.gob.ve> | <exodiadaniel@gmail.com>
         *
         * @param     {object}    value    Objeto que contiene el valor de a búsqueda
         */
        payroll_staffs_assigned() {
            const vm = this;
            vm.record.payroll_staffs = [];

            for (let staff of vm.payroll_staffs_assigned){
                let staff_id = staff.id;
                vm.record.payroll_staffs.push(staff_id);
            }
            vm.loadEquipment();
        },
    },
    methods: {
        /**
         * Agrega una nueva columna para las especificaciones
         *
         * @author Daniel Contreras <dcontreras@cenditel.gob.ve> | <exodiadaniel@gmail.com>
         */ 
        addSpecification() {
            const vm = this;
            vm.record.specifications.push({
                name: '',
                sale_technical_proposal_id: '',
            });
        },
        /**
         * Agrega una nueva columna para los requerimientos
         *
         * @author Daniel Contreras <dcontreras@cenditel.gob.ve> | <exodiadaniel@gmail.com>
         */ 
        addRequirement() {
            const vm = this;
            vm.record.requirements.push({
                name: '',
                sale_technical_proposal_id: '',
            });
        },

        /**
         * Método que carga agrega una nueva etapa para el diagrama de gantt
         *
         * @author  Daniel Contreras <dcontreras@cenditel.gob.ve>
         */
        addStage(){
            const vm = this;
            vm.errors = [];
            if (!vm.stage.stage) {
                $('html,body').animate({
                    scrollTop: $("#SaleTechnicalProposalForm").offset()
                }, 1000);
                vm.errors.push('El campo etapa es obligatorio.');
            } else {
                vm.stages.push({
                    description: vm.stage.description,
                    stage: vm.stage.stage,
                    text: vm.stage.stage,
                    id: vm.stage.stage,
                });
            }

            vm.stage.stage = '';
            vm.stage.description = '';
        },

        /**
         * Método que agrega un nuevo registro a la tabla para el diagrama de gantt
         *
         * @author  Daniel Contreras <dcontreras@cenditel.gob.ve>
         */
        addActivity(){
            const vm = this;
            vm.errors = [];

            if (this.editIndex === null) {                  
                if (!vm.activity.stage_id) {
                    vm.errors.push('El campo etapas es obligatorio.');
                }
                if (!vm.activity.name) {
                    vm.errors.push('El campo actividad es obligatorio.');
                }
                if (!vm.activity.start_date) {
                    vm.errors.push('El campo fecha de inicio es obligatorio.');
                }
                if (!vm.activity.end_date) {
                    vm.errors.push('El campo fecha de fin es obligatorio.');
                }
                if (vm.activity.start_date > vm.activity.end_date) {
                    vm.errors.push('El campo fecha de inicio no debe ser mayor al campo fecha de fin.');
                }
                if (!vm.activity.payroll_staff_id) {
                    vm.errors.push('El campo trabajador es obligatorio.');
                }
                if (!vm.activity.percentage) {
                    vm.errors.push('El campo porcentaje es obligatorio.');
                }
                if(vm.errors.length > 0){
                    $('html,body').animate({
                        scrollTop: $("#SaleTechnicalProposalForm").offset()
                    }, 1000);
                } else {
                    vm.record.activities.push({
                        stage: vm.activity.stage,
                        stage_id: vm.activity.stage_id,
                        name: vm.activity.name,
                        description: vm.activity.description,
                        start_date: vm.activity.start_date,
                        end_date: vm.activity.end_date,
                        payroll_staff_id: vm.activity.payroll_staff_id,
                        percentage: vm.activity.percentage,
                        payroll_staff: vm.activity.payroll_staff,
                    });
                }
            }
            else if (this.editIndex >= 0 ) {
                if (!vm.activity.stage_id) {
                    vm.errors.push('El campo etapas es obligatorio.');
                }
                if (!vm.activity.name) {
                    vm.errors.push('El campo actividad es obligatorio.');
                }
                if (!vm.activity.start_date) {
                    vm.errors.push('El campo fecha de inicio es obligatorio.');
                }
                if (!vm.activity.end_date) {
                    vm.errors.push('El campo fecha de fin es obligatorio.');
                }
                if (!vm.activity.payroll_staff_id) {
                    vm.errors.push('El campo trabajador es obligatorio.');
                }
                if (!vm.activity.percentage) {
                    vm.errors.push('El campo porcentaje es obligatorio.');
                }
                if (vm.errors.length > 0){
                    $('html,body').animate({
                        scrollTop: $("#SaleTechnicalProposalForm").offset()
                    }, 1000);
                } else {
                    vm.record.activities.splice(this.editIndex, 1);
                    vm.record.activities.push({
                        stage: vm.activity.stage,
                        name: vm.activity.name,
                        description: vm.activity.description,
                        start_date: vm.activity.start_date,
                        end_date: vm.activity.end_date,
                        payroll_staff_id: vm.activity.payroll_staff_id,
                        percentage: vm.activity.percentage,
                        payroll_staff: vm.activity.payroll_staff,
                        stage_id: vm.activity.stage_id,
                    });
                    vm.editIndex = null;
                }
            }
            vm.activity.stage = '';
            vm.activity.stage_id = '';
            vm.activity.name = '';
            vm.activity.description = '';
            vm.activity.start_date = '';
            vm.activity.end_date = '';
            vm.activity.payroll_staff = '';
            vm.activity.payroll_staff_id = '';
            vm.activity.percentage = '';
        },

        /**
         * Método que agrega un trabajador a una actividad para el diagrama de gantt
         *
         * @author  Daniel Contreras <dcontreras@cenditel.gob.ve>
         */
        activityStaff() {
            const vm = this;
            for (let staff of vm.payroll_staffs){
                if (vm.activity.payroll_staff_id == staff.id) {
                    vm.activity.payroll_staff = staff;
                };
            };
        },

        /**
         * Método que agrega una etapa a una actividad para el diagrama de gantt
         *
         * @author  Daniel Contreras <dcontreras@cenditel.gob.ve>
         */
        activityStages() {
            const vm = this;
            for (let stage of vm.stages){
                if(vm.activity.stage_id == stage.id) {
                    vm.activity.stage = stage;
                }
            }
        },

        /**
         * Método que carga la información del formulario al editar
         *
         * @author  Daniel Contreras <dcontreras@cenditel.gob.ve>
         */
        async loadForm(id){
            const vm = this;

            await axios.get('/sale/services/info/'+id).then(response => {
                if(typeof(response.data.record != "undefined")){
                    vm.service = response.data.record;
                    vm.record.sale_service_id = vm.service.id;

                    vm.sale_goods_to_be_traded = [];
                    vm.service.requirements = [];

                    for (let data of vm.services) {
                        for (let good_id of response.data.record.sale_goods_to_be_traded) {
                            if (good_id == data.id) {
                                vm.sale_goods_to_be_traded.push(data);
                            }
                        }
                    }

                    for (let requirement of response.data.record.sale_service_requirement) {
                        vm.service.requirements.push(requirement);
                    }
                }
            });

            await axios.get('/sale/technical-proposals/info/'+id).then(response => {
                if(typeof(response.data.record != "undefined")){
                    if (response.data.record.status == 'En proceso') {
                        vm.record = {
                            sale_service_id: vm.service.id,
                            duration: '',
                            frecuency_id: '',
                            sale_list_subservices: [],
                            payroll_staffs: [],
                            requirements: [],
                            specifications: [],
                            activities: [],
                        };
                    } else {
                        let data = response.data.record;
                        vm.record = {
                            sale_service_id: data.sale_service_id,
                            duration: data.duration,
                            frecuency_id: data.frecuency_id,
                            sale_list_subservices: data.sale_list_subservices,
                            payroll_staffs: data.payroll_staffs,
                            requirements: data.sale_proposal_requirement,
                            specifications: data.sale_proposal_specification,
                            activities: [],
                        };

                        for (let subservice_id of data.sale_list_subservices) {
                            for (let subservice of vm.list_subservices) {
                                if (subservice_id == subservice.id){
                                    vm.sale_list_subservices.push(subservice);
                                };
                            };
                        };

                        for (let staff_id of data.payroll_staffs) {
                            for (let staff of vm.payroll_staffs_assignations) {
                                if (staff_id == staff.id){
                                    vm.payroll_staffs_assigned.push(staff);
                                };
                            };
                        };
                        
                        for (let gantt of response.data.record.sale_gantt_diagram){
                            let stage = '';
                            let staff = '';
                            let gantt_stage = {};

                            for (stage of gantt.sale_gantt_diagram_stage){
                                stage = stage;

                                gantt_stage = {
                                    id: stage.stage,
                                    stage: stage.stage,
                                    description: stage.description,
                                    text: stage.stage,
                                };

                                vm.stages.push(gantt_stage);
                            };
                            
                            for (staff of vm.payroll_staffs){
                                if (gantt.payroll_staff_id == staff.id) {
                                    staff = staff;
                                }
                            }
                            
                            let activity = {
                                description: gantt.description,
                                end_date: gantt.end_date,
                                name: gantt.activity,
                                payroll_staff: staff,
                                payroll_staff_id: gantt.payroll_staff_id,
                                percentage: gantt.percentage,
                                stage: gantt_stage,
                                stage_id: stage.stage,
                                start_date: gantt.start_date,
                            };
                            
                            vm.record.activities.push(activity);
                        };
                    }
                }
            });
        },
        /**
         * Método que borra todos los datos del formulario
         *
         * @author  Daniel Contreras <dcontreras@cenditel.gob.ve>
         */
        reset() {
            this.record = {
                sale_service_id: '',
                duration: '',
                frecuency_id: '',
                sale_list_subservices: [],
                payroll_staffs: [],
                requirements: [],
                specifications: [],
                activities: [],
            };
            this.editIndex = null;
        },

        /**
         * Método que carga los trabajadores con bienes asignados para los select
         *
         * @author  Daniel Contreras <dcontreras@cenditel.gob.ve>
         */
        getPayrollStaffsAssigned() {
            const vm = this;
            vm.payroll_staffs_assignations = [];

            axios.get('/sale/get-asignation-staffs/').then(response => {
                    vm.payroll_staffs_assignations = response.data.records;
            });
        },

        /**
         * Método que carga los trabajadores registrados para los select
         *
         * @author  Daniel Contreras <dcontreras@cenditel.gob.ve>
         */
        getPayrollStaffs() {
            const vm = this;
            vm.payroll_staffs = [];

            axios.get('/sale/get-payroll-staffs').then(response => {
                    vm.payroll_staffs = response.data;
            });
        },

        /**
         * Método que carga los bienes para los select
         *
         * @author  Daniel Contreras <dcontreras@cenditel.gob.ve>
         */
        getSaleGoods() {
            const vm = this;
            vm.services = [];

            axios.get('/sale/get-sale-goods/').then(response => {
                vm.services = response.data.records;
            });
        },

        /**
         * Método que carga los subservicios registrados para los select
         *
         * @author  Daniel Contreras <dcontreras@cenditel.gob.ve>
         */
        getSaleListSubservice() {
            const vm = this;
            vm.list_subservices = [];

            axios.get('/sale/get-salelistsubservicesmethod/').then(response => {
                vm.list_subservices = response.data;
            });
        },

        /**
         * Método que carga los periodos de tiempo registrados para los select
         *
         * @author  Daniel Contreras <dcontreras@cenditel.gob.ve>
         */
        getFrencuency() {
            const vm = this;
            vm.frecuencies = [];

            axios.get('/sale/get-frecuencies/').then(response => {
                vm.frecuencies = response.data;
            });
        },

        /**
         * Método que carga los clientes registrados para los select
         *
         * @author  Daniel Contreras <dcontreras@cenditel.gob.ve>
         */
        getSaleClientsRif() {
            const vm = this;
            vm.sale_clients_rif = [];

            axios.get('/sale/get-sale-clients-rif/').then(response => {
                vm.sale_clients_rif = response.data.records;
            });
        },

        /**
         * Método que carga la información de los clientes registrados para los select
         *
         * @author  Daniel Contreras <dcontreras@cenditel.gob.ve>
         */
        getSaleClient() {
            const vm = this;
            if (vm.service.sale_client_id > 0) {
                axios.get('/sale/get-sale-client/' + vm.service.sale_client_id).then(response => {
                    vm.sale_client.name = response.data.sale_client.name;
                    vm.sale_client.phones = response.data.sale_client.phones;
                    vm.sale_client.sale_clients_email = response.data.sale_client.sale_clients_email;
                });
            }
        },

        /**
         * Método que carga la información de los clientes registrados para los select
         *
         * @author  Daniel Contreras <dcontreras@cenditel.gob.ve>
         */
        getSaleClientsAddress() {
            const vm = this;
            vm.sale_clients_address = [];

            axios.get('/sale/get-sale-clients-address/').then(response => {
                vm.sale_clients_address = response.data;
            });
        },

        /**
         * Método que carga la información de los clientes registrados para los select
         *
         * @author  Daniel Contreras <dcontreras@cenditel.gob.ve>
         */
        getSaleClientsFiscalAddress() {
            const vm = this;
            vm.sale_clients_fiscal_address = [];

            axios.get('/sale/get-sale-clients-fiscal-address/').then(response => {
                vm.sale_clients_fiscal_address = response.data;
            });
        },

        /**
         * Método que carga la información para la tabla de bienes asignados
         *
         * @author  Daniel Contreras <dcontreras@cenditel.gob.ve>
         */
        loadEquipment(){
            if(this.record.payroll_staffs.length > 0) {
                this.records = [];
                axios.get('/asset/asignations/vue-info/' + this.record.payroll_staffs).then(response => {
                    let assets = [];
                    if (this.record.payroll_staffs.length > 1) {
                        for (let data of response.data.records) {
                            assets.push(data);
                        }
                        this.records = assets;
                    } else {
                        this.records.push(response.data.records);
                    }
                });
            } else {
                this.records = [];
            }
        },

        /**
         * Método que permite la edición de una actividad para el diagrama de gantt
         *
         * @author  Daniel Contreras <dcontreras@cenditel.gob.ve>
         */
        editActivity(index, event) {
            this.activity = {
                stage: '',
                name: '',
                description: '',
                start_date: '',
                end_date: '',
                payroll_staff_id: '',
                percentage: '',
                payroll_staff: {},
            };
            this.editIndex = index-1;
            this.activity = this.record.activities[index - 1];
            event.preventDefault();
        },

        /**
         * Método que permite eliminar una actividad para el diagrama de gantt
         *
         * @author  Daniel Contreras <dcontreras@cenditel.gob.ve>
         */
        removeActivity(index, event) {
            this.record.activities.splice(index-1, 1);
        },

        /**
         * Método que reemplaza el createRecord para no usar sus valores por defecto
         *
         * @author  Daniel Contreras <dcontreras@cenditel.gob.ve>
         */
        createRecord(url){
            const vm = this;
            let percentage = 0;

            if (vm.record.activities.length > 1) {
                for (let activity of vm.record.activities) {
                    percentage += parseFloat(activity.percentage);
                }
            } else {
                for (let activity of vm.record.activities) {
                    percentage = activity.percentage;
                }
            }

            if (percentage > 100){
                vm.errors = [];
                $('html,body').animate({
                    scrollTop: $("#SaleTechnicalProposalForm").offset()
                }, 1000);
                vm.errors.push('El porcentaje de actividades no debe ser mayor a 100.');
            } else {
                vm.loading = true;
                var fields = {};
                url = (!url.includes('http://') || !url.includes('http://'))
                      ? `${window.app_url}${(url.startsWith('/'))?'':'/'}${url}` : url;

                for (var index in vm.record) {
                    fields[index] = vm.record[index];
                }
                axios.patch(`${url}${(url.endsWith('/'))?'':'/'}${vm.record.sale_service_id}`, fields).then(response => {
                    if (typeof(response.data.redirect) !== "undefined") {
                        location.href = response.data.redirect;
                    }
                    else {
                        vm.readRecords(url);
                        vm.reset();
                        vm.loading = false;
                        vm.showMessage('update');
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
        }
    },
    mounted() {
        const vm = this;

        if(this.serviceid){
            this.loadForm(this.serviceid);
        }
        else {
            vm.service.date = moment(String(new Date())).format('YYYY-MM-DD');
        }
    },
    props: {
        serviceid: {
            type: Number
        },
    },
    created() {
        this.table_option_activities = {
            columnsDropdown: false,
            dateFormat:"DD/MM/YYYY",
            filterable: [],
            headings: {},
            orderBy: {},
            pagination: {},
            perPage: 10,
            perPageValues: ['10','20','50'],
            sortIcon: {
                base:"fa",
                down:"fa-sort-down cursor-pointer",
                is:"fa-sort cursor-pointer",
                up:"fa-sort-up cursor-pointer",
            },
            sortable: {},
            texts: {
                count:" ",
                filter:"Buscar:",
                filterBy:"Buscar por {column}",
                filterPlaceholder:"Buscar...",
                first:"PRIMERO",
                last:"ÚLTIMO",
                limit:"Registros",
                loading:"Cargando...",
                loadingError:"Oops! No se pudo cargar la información",
                noResults:"No existen registros",
            },
        };
        this.getSaleClientsRif();
        this.getSaleClient();
        this.getSaleGoods();
        this.getFrencuency();
        this.getPayrollStaffsAssigned();
        this.getPayrollStaffs();
        this.getSaleListSubservice();
        this.activityStaff();
        this.activityStages();
        this.service.sale_goods_to_be_traded = [];
        this.record.specifications = [];
        this.record.requirements = [];
        this.record.sale_list_subservices = [];
        this.record.payroll_staffs = [];
        this.stages = [{
            id: '',
            text: 'Seleccione...'
        }];
        this.table_options.headings = {
            'inventory_serial': 'Código',
            'payroll_staff': 'Trabajador',
            'serial': 'Serial',
            'marca': 'Marca',
            'model': 'Modelo',
        };
        this.table_options.sortable = ['inventory_serial','payroll_staff','serial','marca','model'];
        this.table_options.filterable = ['inventory_serial','payroll_staff','serial','marca','model'];
        this.table_options.orderBy = { 'column': 'id'};
        this.table_option_activities.headings = {
            'stage': 'Etapa',
            'name': 'Actividad',
            'description': 'Descripción',
            'start_date': 'Fecha de inicio',
            'end_date': 'Fecha de fin',
            'payroll_staff': 'Trabajador',
            'percentage': 'Porcentaje',
            'id': 'Acción'
        };
        this.table_option_activities.sortable = ['stage','name','description','start_date','end_date', 'payroll_staff', 'percentage'];
        this.table_option_activities.filterable = ['stage','name','description','start_date','end_date', 'payroll_staff', 'percentage'];
        this.table_option_activities.orderBy = { 'column': 'id'};
        this.record.activities = [];
    },
};
</script>
