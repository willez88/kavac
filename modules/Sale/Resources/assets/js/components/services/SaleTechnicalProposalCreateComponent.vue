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
                        <select2 :options="payroll_staffs"
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
                    <v-client-table :columns="columns" :data="records" :options="table_options">
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
                        v-model="record.stage" id="gantt_stage"></input>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group is-required">
                    <label for="gantt_description">Descripción:</label>
                    <textarea type="text" class="form-control input-sm"
                        data-toggle="tooltip" title="Descripción" 
                        v-model="record.description" id="gantt_description"></textarea>
                </div>
            </div>
            <div class="col-md-12">
                <b>Actividades</b>
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
            payroll_staffs: [],
            columns: ['asset.inventory_serial','asset.serial','asset.marca','asset.model'],
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
        }
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
            this.record = {};
        },

        getPayrollStaffs() {
                const vm = this;
                vm.payroll_staffs = [];

                axios.get('/sale/get-asignation-staffs/').then(response => {
                        vm.payroll_staffs = response.data.records;
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
        this.getSaleClientsRif();
        this.getSaleClient();
        this.getSaleGoods();
        this.getFrencuency();
        this.getPayrollStaffs();
        this.getSaleListSubservice();
        this.service.sale_goods_to_be_traded = [];
        this.record.specifications = [];
        this.record.requirements = [];
        this.table_options.headings = {
            'asset.inventory_serial': 'Código',
            'asset.serial': 'Serial',
            'asset.marca': 'Marca',
            'asset.model': 'Modelo',
        };
        this.table_options.sortable = ['asset.inventory_serial','asset.serial','asset.marca','asset.model'];
        this.table_options.filterable = ['asset.inventory_serial','asset.serial','asset.marca','asset.model'];
        this.table_options.orderBy = { 'column': 'asset.id'};
    },
};
</script>
