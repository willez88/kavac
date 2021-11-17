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

        <div class="row">
            <div class="col-md-12">
                <b>Datos del solicitante</b>
            </div>
            <div class="col-md-3">
                <div class="form-group is-required">
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
                            id="phone" v-model="phone.extension + '-' + phone.area_code + phone.number"></input>
                    </p>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group is-required">
                    <label for="applicant_organization">Organización:</label>
                    <input type="text" class="form-control input-sm" 
                        data-toggle="tooltip" title="Dirección" 
                        v-model="service.organization" :disabled="true" id="applicant_organization"></input>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group is-required">
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
                <div class="form-group is-required">
                    <label>Servicio:</label>
                    <p v-for="good_to_be_traded in sale_goods_to_be_traded">
                        <input type="text" class="form-control input-sm"
                            data-toggle="tooltip" title="Nombre o razón social" 
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
                            data-toggle="tooltip" title="Nombre o razón social" 
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
                            data-toggle="tooltip" title="Nombre o razón social" 
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
                            data-toggle="tooltip" title="Nombre o razón social" 
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
                            data-toggle="tooltip" title="Nombre o razón social" 
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
                            data-toggle="tooltip" title="Nombre o razón social" 
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
                            data-toggle="tooltip" title="Nombre o razón social" 
                            :disabled="true"
                            id="staff_email" v-model="good_to_be_traded.staff_email"></input>
                    </p>
                </div>
            </div>
            <br>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <b>Características del servicio</b>
            </div>
            <div class="col-md-3">
                <div class="form-group is-required">
                    <label>Subservicio:</label>
                    <select2 :options="sale_list_subservices"
                             v-model="record.sale_list_subservices"></select2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="duration">Duración:</label>
                        <input type="text" class="form-control input-sm"
                            data-toggle="tooltip" title="Duración"
                            id="duration" v-model="record.duration"></input>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group is-required">
                    <label>Duración:</label>
                    <select2 :options="frecuencies"
                             v-model="record.frecuency_id"></select2>
                </div>
            </div>
            <div class="col-md-12">
                <h6 class="card-title">Especificaciones técnicas <i class="fa fa-plus-circle cursor-pointer"
                    @click="addSpecification()"></i></h6>
                <div class="row" v-for="(specification, index) in record.specifications">
                    <div class="col-md-4">
                        <div class="form-group is-required">
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
            <div class="col-md-12">
                <h6 class="card-title">Requerimientos que serán suministrados por el cliente <i class="fa fa-plus-circle cursor-pointer"
                    @click="addRequirement()"></i></h6>
                <div class="row" v-for="(requirement, index) in record.requirements">
                    <div class="col-md-4">
                        <div class="form-group is-required">
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
            <div class="col-md-3">
                <div class="form-group is-required">
                    <label>Lista de trabajadores:</label>
                        <select2 :options="payroll_staffs_assigned"
                                    v-model="record.payroll_staff_id" @input="loadEquipment()"></select2>
                </div>
            </div>
        </div>
        <div v-if="record.payroll_staff_id" class="tab-pane" id="equipment" role="tabpanel">
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <b>Equipos a utilizar</b>
                </div>
                <br>
                <div class="col-md-12">
                    <v-client-table :columns="columns_asstets" :data="records" :options="table_options">
                    </v-client-table>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <b>Diagrama de Gantt</b>
            </div>
            <br>
            <br>
            <div class="col-md-12">
                <b>Etapas</b>
            </div>
            <div class="col-md-3">
                <div class="form-group is-required">
                    <label for="gantt_stage">Etapa:</label>
                    <input type="text" class="form-control input-sm" 
                        data-toggle="tooltip" title="Etapa" 
                        v-model="stage.stage" id="gantt_stage"></input>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group is-required">
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
            <div class="col-md-3">
                <div class="form-group is-required">
                    <label>Etapas:</label>
                        <select2 :options="stages"
                                    v-model="activity.stage"></select2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group is-required">
                    <label for="gantt_stage">Actividad:</label>
                    <input type="text" class="form-control input-sm" 
                        data-toggle="tooltip" title="Etapa" 
                        v-model="activity.name" id="gantt_stage"></input>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group is-required">
                    <label for="gantt_description">Descripción:</label>
                    <textarea type="text" class="form-control input-sm"
                        data-toggle="tooltip" title="Descripción" 
                        v-model="activity.description" id="gantt_description"></textarea>
                </div>
            </div>
            <div class="col-md-3">
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
            <div class="col-md-3">
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
            <div class="col-md-3">
                <div class="form-group is-required">
                    <label>Trabajador:</label>
                        <select2 :options="payroll_staffs" v-model="activity.payroll_staff_id"
                                    @input="activityStaff()"></select2>
                </div>
            </div>
            <div class="col-md-3" id="saleHelpProductValue">
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
            <div class="col-md-12">
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
    <div class="card-footer text-right">
        <div class="row">
            <div class="col-md-3 offset-md-9" id="saleHelpParamButtons">
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
                asset_asignations: [],
                sale_list_subservices: [],
                payroll_staffs: [],
                requirements: [],
                specifications: [],
                activities: [],
                stages: [],
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
            sale_list_subservices: [],
            frecuencies: [],
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
                stage: '',
                name: '',
                description: '',
                start_date: '',
                end_date: '',
                payroll_staff_id: '',
                percentage: '',
                payroll_staff: {},
            },
            columns_asstets: ['asset.inventory_serial','asset.serial','asset.marca','asset.model'],
            columns_activities: ['stage','name','description','start_date','end_date', 'payroll_staff', 'percentage', 'id'],
            table_option_assets: [],
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

        addStage(){
            const vm = this;
            vm.stages.push({
                text: vm.stage.stage,
                id: vm.stage.stage,
            });
            vm.stage.stage = '';
            vm.stage.description = '';
        },

        addActivity(){
            const vm = this;

            if (this.editIndex === null) {                  
                vm.record.activities.push({
                    stage: vm.activity.stage,
                    name: vm.activity.name,
                    description: vm.activity.description,
                    start_date: vm.activity.start_date,
                    end_date: vm.activity.end_date,
                    payroll_staff_id: vm.activity.payroll_staff_id,
                    percentage: vm.activity.percentage,
                    payroll_staff: vm.activity.payroll_staff,
                });
            }
            else if (this.editIndex >= 0 ) {
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
                });
                vm.editIndex = null;
            }
            vm.activity.stage = '';
            vm.activity.name = '';
            vm.activity.description = '';
            vm.activity.start_date = '';
            vm.activity.end_date = '';
            vm.activity.payroll_staff = '';
            vm.activity.payroll_staff_id = '';
            vm.activity.percentage = '';
        },

        activityStaff() {
            const vm = this;
            for (let staff of vm.payroll_staffs){
                let staff_id = staff.id;
                vm.activity.payroll_staff = staff;
            }
        },

        /**
         * Método que carga la información del formulario al editar
         *
         *
         */
        async loadForm(id){
            const vm = this;

            await axios.get('/sale/services/info/'+id).then(response => {
                if(typeof(response.data.record != "undefined")){
                    vm.service = response.data.record;

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
        },
        /**
         * Método que borra todos los datos del formulario
         *
         *
         */
        reset() {
            this.record = {
                sale_service_id: '',
                duration: '',
                frecuency_id: '',
                asset_asignations: [],
                sale_list_subservices: [],
                payroll_staffs: [],
                requirements: [],
                specifications: [],
                activities: [],
                stages: [],
            };
            this.editIndex = null;
        },

        getPayrollStaffsAssigned() {
            const vm = this;
            vm.payroll_staffs_assigned = [];

            axios.get('/sale/get-asignation-staffs/').then(response => {
                    vm.payroll_staffs_assigned = response.data.records;
            });
        },

        getPayrollStaffs() {
            const vm = this;
            vm.payroll_staffs = [];

            axios.get('/sale/get-payroll-staffs').then(response => {
                    vm.payroll_staffs = response.data;
            });
        },

        getSaleGoods() {
            const vm = this;
            vm.services = [];

            axios.get('/sale/get-sale-goods/').then(response => {
                vm.services = response.data.records;
            });
        },

        getSaleListSubservice() {
            const vm = this;
            vm.sale_list_subservices = [];

            axios.get('/sale/get-salelistsubservicesmethod/').then(response => {
                vm.sale_list_subservices = response.data;
            });
        },

        getFrencuency() {
            const vm = this;
            vm.frecuencies = [];

            axios.get('/sale/get-frecuencies/').then(response => {
                vm.frecuencies = response.data;
            });
        },

        getSaleClientsRif() {
            const vm = this;
            vm.sale_clients_rif = [];

            axios.get('/sale/get-sale-clients-rif/').then(response => {
                vm.sale_clients_rif = response.data.records;
            });
        },

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

        getSaleClientsAddress() {
            const vm = this;
            vm.sale_clients_address = [];

            axios.get('/sale/get-sale-clients-address/').then(response => {
                vm.sale_clients_address = response.data;
            });
        },

        getSaleClientsFiscalAddress() {
            const vm = this;
            vm.sale_clients_fiscal_address = [];

            axios.get('/sale/get-sale-clients-fiscal-address/').then(response => {
                vm.sale_clients_fiscal_address = response.data;
            });
        },

        loadEquipment(){
            if(this.record.payroll_staff_id) {
                let index = this.record.payroll_staff_id;
                axios.get('/asset/asignations/vue-info/' + index).then(response => {
                    this.records = response.data.records.asset_asignation_assets;
                });

            } else {
                this.records = [];
            }
        },

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

        removeActivity(index, event) {
            this.record.activities.splice(index-1, 1);
        },
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
        this.service.sale_goods_to_be_traded = [];
        this.record.specifications = [];
        this.record.requirements = [];
        this.stages = [{
            id: '',
            text: 'Seleccione...'
        }];
        this.table_options.headings = {
            'asset.inventory_serial': 'Código',
            'asset.serial': 'Serial',
            'asset.marca': 'Marca',
            'asset.model': 'Modelo',
        };
        this.table_options.sortable = ['asset.inventory_serial','asset.serial','asset.marca','asset.model'];
        this.table_options.filterable = ['asset.inventory_serial','asset.serial','asset.marca','asset.model'];
        this.table_options.orderBy = { 'column': 'asset.id'};
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
