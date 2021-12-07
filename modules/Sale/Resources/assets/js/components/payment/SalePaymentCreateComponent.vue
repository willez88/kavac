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
                <div class="form-group" v-show="show_service">
                    <label>Servicio:</label>
                    <select2 :options="sale_service_list"
                             v-model="record.sale_service_id" @input="getSaleService(); show();" ></select2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group" v-show="show_order">
                    <label>Pedido:</label>
                    <select2 :options="sale_order_list"
                             v-model="record.sale_order_id" @input="getSaleService(); show();" ></select2>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group is-required">
                    <label>Código de la solicitud:</label>
                    <input type="text" class="form-control input-sm" 
                        data-toggle="tooltip" title="Código de Solicitud" 
                        v-model="sale_service.code" id="code" :disabled="true"></input>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group is-required">
                    <label>Monto Total del pedido o servicio:</label>
                    <input type="text" class="form-control input-sm" 
                        data-toggle="tooltip" title="Total" 
                        v-model="sale_service.total" id="total" :disabled="true" ></input>
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
                            data-on-label="SI" data-off-label="NO" value="true" data-record="advance" v-model="record.advance">
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
                sale_service_id: '',
                sale_order_id: '',
                currency_id: '',
                bank_id: '',
                number_reference: '',
                payment_date: '',
                advance: '',
            },
            show_service: true,
            show_order: true,
            sale_order_list: [],
            sale_service_list: [],
            bank: [],
            currencies: [],
            sale_goods_to_be_traded: [],
            services: [],
            records: [],
            errors: [],
            sale_service: {
                code : '',
                total : '',
            },
            sale_order: {
                code : '',
                total : '',
            },
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
                sale_service_id: '',
                sale_order_id: '',
                currency_id: '',
                bank_id: '',
                number_reference: '',
                payment_date: '',
                advance: '',
            };
            this.sale_service = [];
        },
        /**
         * Método que oculta el campo servicio o pedido no seleccionado.
         *
         *
         */        
        show() {
            const vm = this;
            if (vm.record.sale_service_id > 0) {
                vm.show_service=true;
                vm.show_order=false;
            };
            if (vm.record.sale_order_id > 0) {
                vm.show_order=true;
                vm.show_service=false;
            };
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
                    vm.sale_service.code = response.data.sale_service.code;
                    vm.sale_service.total = response.data.sale_service.total;
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
