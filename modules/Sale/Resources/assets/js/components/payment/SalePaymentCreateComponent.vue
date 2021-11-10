<template>
<section id="SalePaymentForm">
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
                <b>Datos del cliente</b>
            </div>

            <div class="col-md-3">
                <div class="form-group is-required">
                    <label>Servicio:</label>
                    <select2 :options="sale_service_list"
                             v-model="record.sale_service_id" @input="getSaleService"></select2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group is-required">
                    <label>Pedido:</label>
                    <select2 :options="sale_order_list"
                             v-model="record.sale_order_id" @input="getSalesOrder" ></select2>
                </div>
            </div>



            <div class="col-md-3">
                <div v-show="record.sale_client_id != 0" class="form-group">
                    <label for="sale_clients_email">Correo:</label>
                    <p v-for="email in sale_client.sale_clients_email">
                        <input type="text" class="form-control input-sm" :disabled="true" 
                            data-toggle="tooltip" title="Dirección" 
                            id="email" v-model="email.email"></input>
                    </p>
                </div>
            </div>
            <div class="col-md-3">
                <div v-show="record.sale_client_id != 0" class="form-group">
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
                    <label for="applicant_organization">codigo de la solicitud:</label>
                    <input type="text" class="form-control input-sm" 
                        data-toggle="tooltip" title="Dirección" 
                        v-model="record.organization" id="applicant_organization" :disabled="true"></input>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group is-required">
                    <label for="payment">Monto Total del pedido o servicio:</label>
                    <input type="text" class="form-control input-sm" 
                        data-toggle="tooltip" title="Total" 
                        v-model="record.payment" id="payment" :disabled="true"></input>
                </div>
            </div>            
            <div class="col-md-3">
                <div class="form-group is-required">
                    <label>Forma de pago:</label>
                    <select2 :options="currencies"
                              v-model="record.currency_id"></select2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group is-required">
                    <label>Entidad bancaria:</label>
                    <select2 :options="bank"
                              v-model="record.bank_id"></select2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group is-required">
                    <label for="number_reference">Número de referencia de la operación:</label>
                    <input type="text" class="form-control input-sm" 
                        data-toggle="tooltip" title="Número de referencia" 
                        v-model="record.number_reference" id="number_reference"></input>
                </div>
            </div>
            <div class="col-md-3">
                <label>Fecha en que se realizó el pago:</label>
                <div class="input-group input-sm">
                    <span class="input-group-addon">
                        <i class="now-ui-icons ui-1_calendar-60"></i>
                    </span>
                    <input type="date" data-toggle="tooltip"
                           title="Fecha en que se realizó el pago"
                           class="form-control input-sm" v-model="record.payment_date">
                </div>
            </div>
            <div class="col-md-3">
                <label class="control-label">El pago corresponde a un anticipo:</label>
                <div class="col-12">
                    <div class="bootstrap-switch-mini">
                        <input type="checkbox" class="form-control bootstrap-switch"
                            name="advance" data-toggle="tooltip" title="Indique si desea aplicar algún descuento"
                            data-on-label="SI" data-off-label="NO" value="true" data-record="advance">
                    </div>
                </div>
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

                <button type="button"  @click="createRecord('sale/services')"
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
                id: '',
                organization: '',
                description: '',
                resume: '',
                sale_goods_to_be_traded: [],
                requirements: [],
                sale_client_id: '',
            },
            sale_order_list: [],
            sale_service_list: [],
            bank: [],
            currencies: [],
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
         * Método que carga la información del formulario al editar
         *
         *
         */
        async loadForm(id){
            const vm = this;

            await axios.get('/sale/services/info/'+id).then(response => {
                if(typeof(response.data.record != "undefined")){
                    vm.record = response.data.record;

                    vm.sale_goods_to_be_traded = [];
                    vm.record.requirements = [];

                    for (let data of vm.services) {
                        for (let good_id of response.data.record.sale_goods_to_be_traded) {
                            if (good_id == data.id) {
                                vm.sale_goods_to_be_traded.push(data);
                            }
                        }
                    }

                    for (let requirement of response.data.record.sale_service_requirement) {
                        vm.record.requirements.push(requirement);
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
                id: '',
                organization: '',
                description: '',
                resume: '',
                sale_client_id: '',
                sale_goods_to_be_traded: [],
                requirements: [],
            };
            this.sale_goods_to_be_traded = [];
        },

        getSaleOrderList() {
                const vm = this;
                vm.sale_order_list = [];

                axios.get('/sale/get-sale-order-list').then(response => {
                        vm.sale_order_list = response.data;
                });
        },

        getSaleServiceList() {
                const vm = this;
                vm.sale_service_list = [];

                axios.get('/sale/get-sale-service-list').then(response => {
                        vm.sale_service_list = response.data;
                });
        },

        getBank() {
                const vm = this;
                vm.bank = [];

                axios.get('/sale/get-bank').then(response => {
                        vm.bank = response.data;
                });
        },

        getCurrencies() {
                const vm = this;
                vm.currencies = [];

                axios.get('/sale/get-currencie').then(response => {
                        vm.currencies = response.data;
                });
        },

        getSaleService() {
            const vm = this;
            if (vm.record.sale_service_id > 0) {
                axios.get('/sale/get-sales-client/' + vm.record.sale_service_id).then(response => {
                    vm.sales_client.name = response.data.sales_client.name;
                    vm.sales_client.phones = response.data.sales_client.phones;
                    vm.sales_client.sales_clients_email = response.data.sales_client.sales_clients_email;
                });
            }
        },

        getSaleGoods() {
            const vm = this;
            vm.services = [];

            axios.get('/sale/get-sale-goods/').then(response => {
                vm.services = response.data.records;
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
            if (vm.record.sale_client_id > 0) {
                axios.get('/sale/get-sale-client/' + vm.record.sale_client_id).then(response => {
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
    },
    mounted() {
        const vm = this;

        if(this.serviceid){
            this.loadForm(this.serviceid);
        }
        else {
            vm.record.date = moment(String(new Date())).format('YYYY-MM-DD');
        }
    },
    props: {
        serviceid: {
            type: Number
        },
    },
    created() {
        this.getSaleOrderList();
        this.getSaleServiceList();
        this.getBank();
        this.getCurrencies();
        this.getSaleService();
        this.getSaleClientsRif();
        this.getSaleClient();
        this.getSaleGoods();
        this.record.sale_goods_to_be_traded = [];
        this.record.requirements = [];
    },
};
</script>
