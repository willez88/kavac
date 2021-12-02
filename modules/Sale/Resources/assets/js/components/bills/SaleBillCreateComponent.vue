<template>
    <section id="SaleBillForm">
        <div class="card-body">
            <div class="alert alert-danger" v-if="errors.length > 0">
                <ul><li v-for="error in errors">{{ error }}</li></ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <b>Datos del solicitante</b>
                    <a class="btn btn-info btn-xs btn-icon btn-action display-inline" 
                        href="#" title="Ver información del registro" data-toggle="tooltip" 
                        @click.prevent="showModal('view_sale_bill_clients')">
                        <i class="icofont icofont-business-man ico-2x"></i>
                    </a>
                </div>
                </h6>
                <div class="client-list">
                    <div class="modal fade text-left" tabindex="-1" role="dialog" id="view_sale_bill_clients" ref="clients-modal">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <h6><i class="icofont icofont-business-man ico-2x"></i> Clientes</h6>
                                </div>
                                <div class="modal-body modal-table">
                                    <v-client-table :columns="columns_clients" :data="quote_clients" :options="table_options_clients">
                                        <div slot="id" slot-scope="props" class="text-center">
                                            <span>
                                                <i class="fa fa-plus-circle cursor-pointer" @click="addClient(props.index, props.row)"></i>
                                            </span>
                                        </div>
                                        <div slot="name_client" slot-scope="props" class="text-center">
                                            <span>
                                                {{ (props.row.name_client)? props.row.name_client : props.row.name }}
                                            </span>
                                        </div>
                                        <div slot="rif" slot-scope="props" class="text-center">
                                            <span>
                                                {{ (props.row.rif)? props.row.rif : props.row.id_type + props.row.id_number }}
                                            </span>
                                        </div>
                                        <div slot="phones" slot-scope="props">
                                            <div v-if="props.row.phones">
                                                <ul v-for="phone in props.row.phones">
                                                    <li>{{ phone.type }}: ({{ phone.area_code }}) {{ phone.number }} ext: {{ phone.extension }}</li>
                                                </ul>
                                            </div>
                                            <div v-else>
                                                <span>N/A</span>
                                            </div>
                                        </div>
                                        <div slot="sale_clients_email" slot-scope="props">
                                            <div v-if="props.row.sale_clients_email">
                                                <ul v-for="client_email in props.row.sale_clients_email">
                                                    <li>{{ client_email.email }}</li>
                                                </ul>
                                            </div>
                                            <div v-else>
                                                <span>N/A</span>
                                            </div>
                                        </div>
                                    </v-client-table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group is-required">
                        <label for="type_person">Tipo de persona:</label>
                        <select2 :options="types_person" id='type_person' v-model="record.type_person"></select2>
                    </div>
                </div>
                <div v-if="record.type_person" class="col-md-3">
                    <div class="form-group is-required">
                        <label v-show="record.type_person == ''" for="name">Nombre de la Empresa:</label>
                        <label v-show="record.type_person == 'Jurídica'" for="name">Nombre de la Empresa:</label>
                        <label v-show="record.type_person == 'Natural'" for="name">Nombre y Apellido:</label>
                        <input type="text" id="name" class="form-control input-sm" data-toggle="tooltip"
                            title="Nombre" v-model="record.name">
                        <input type="hidden" name="id" id="id" v-model="record.id">
                    </div>
                </div>
                <div v-if="record.type_person == 'Jurídica'" class="col-md-3">
                    <div class="form-group is-required">
                        <label for="rif">RIF</label>
                        <input type="text" id="rif" class="form-control input-sm" data-toggle="tooltip"
                            title="Indique la identificación del cliente" v-model="record.rif">
                    </div>
                </div>
                <div v-if="record.type_person == 'Natural'" class="col-md-3">
                    <div class="form-group is-required">
                        <label for="id_number">Identificación</label>
                        <input type="text" id="id_number" class="form-control input-sm" data-toggle="tooltip"
                            title="Indique la identificación del cliente" v-model="record.id_number">
                    </div>
                </div>
                <div v-if="record.type_person" class="col-md-3">
                    <div class="form-group is-required">
                        <label for="phone">Teléfono de contacto:</label>
                        <input type="text" id="phone" class="form-control input-sm" data-toggle="tooltip" required
                            title="Número de teléfono" v-model="record.phone" placeholder="00-000-0000000">
                    </div>
                </div>
                <div v-if="record.type_person" class="col-md-3">
                    <div class="form-group is-required">
                        <label for="email">Correo Electrónico:</label>
                        <input type="text" id="email" class="form-control input-sm" data-toggle="tooltip" required
                            title="Correo electrónico del solicitante" v-model="record.email">
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <b>Descripción de productos</b>
                </div>
                <div class="col-md-3">
                    <div class="form-group is-required">
                        <label for="product_type">Tipo de Producto:</label>
                        <input type="hidden" name="product_position_value" id="product_position_value" v-model="record.product_position_value">
                        <select2 :options="type_products" id='product_type' v-model="product_type"></select2>
                    </div>
                </div>
                <div v-show="record.product_type == 'Producto'" class="col-md-3">
                    <div class="form-group is-required">
                        <label for="product_type">Producto:</label>
                        <select2 :options="quote_inventory_products_list" id="sale_warehouse_inventory_product_id" v-model="record.sale_warehouse_inventory_product_id" @input="updateProduct"></select2>
                    </div>
                </div>
                <div v-show="record.product_type == 'Servicio'" class="col-md-3">
                    <div class="form-group is-required">
                        <label for="sale_goods_to_be_traded_id">Servicio:</label>
                        <select2 :options="bill_good_to_be_traded" id="sale_goods_to_be_traded_id" v-model="record.sale_goods_to_be_traded_id" @input="updateProduct"></select2>
                    </div>
                </div>
                <div v-show="record.product_type == 'Servicio'" class="col-md-3">
                    <div class="form-group is-required">
                        <label for="sale_list_subservices_id">Subservicios:</label>
                        <select2 :options="quote_subservices_list" id="sale_list_subservices_id" v-model="record.sale_list_subservices_id"></select2>
                    </div>
                </div>
                <div class="col-md-3" id="SaleHelpProductMeasurementUnit">
                    <div class="form-group is-required">
                        <label>Unidad de medida</label>
                        <select2 :options="quote_measurement_units" id='measurement_unit_id'
                         v-model="record.measurement_unit_id"></select2>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group is-required">
                        <label>Precio unitario:</label>
                        <input type="text" placeholder="Precio unitario" id="value" title="Precio unitario" v-model="record.value" class="form-control input-sm" required @change="updateTotalProduct()">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group is-required">
                        <label>Cantidad de productos:</label>
                        <input type="text" placeholder="Cantidad de productos" id='quantity' title="Cantidad de productos" v-model="record.quantity" class="form-control input-sm" required @input="updateTotalProduct()">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group is-required">
                        <label>Precio total:</label>
                        <input type="text" disabled placeholder="Total" id="total" title="Cantidad total" v-model="record.total" class="form-control input-sm" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group is-required">
                        <label>Moneda:</label>
                        <select2 :options="currencies" v-model="record.currency_id" id="currency_id"></select2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-right">
                    <div class="d-inline-flex mt-4">
                        <button type="button" @click="addProduct($event)" class="btn btn-sm btn-primary btn-custom" 
                            title="Agregar producto a la lista" data-toggle="tooltip">
                            <i class="fa fa-plus-circle"></i>
                            Agregar
                        </button>
                    </div>
                </div>
            </div>
            <br>
            <v-client-table :columns="columns" :data="record.sale_bill_products" :options="table_options">
                <div slot="sale_warehouse_inventory_product_id" slot-scope="props" class="text-center">
                    <span>
                        {{ (props.row.sale_warehouse_inventory_product_id)? props.row.inventory_product.name : props.row.sale_goods_to_be_traded.name }}
                    </span>
                </div>
                <div slot="sale_list_subservices_id" slot-scope="props" class="text-center">
                    <span>
                        {{ (props.row.sale_list_subservices_id)? props.row.sale_list_subservices.name : 'N/A' }}
                    </span>
                </div>
                <div slot="id" slot-scope="props" class="text-center">
                    <div class="d-inline-flex">
                        <button @click="editProduct(props.index, $event)" 
                            class="btn btn-warning btn-xs btn-icon btn-action" 
                            title="Modificar registro" data-toggle="tooltip" type="button">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button @click="removeProduct(props.index, $event)" 
                            class="btn btn-danger btn-xs btn-icon btn-action" 
                            title="Eliminar registro" data-toggle="tooltip" 
                            type="button">
                            <i class="fa fa-trash-o"></i>
                        </button>
                    </div>
                </div>
            </v-client-table>
            <div class="row">
                <div class="col-md-12 text-right">
                    <div class="d-inline-flex align-items-center">
                        <label class="font-weight-bold">Total sin iva:</label>
                        <div class="form-group is-required">
                            <input type="text" disabled placeholder="Total Sin IVA" id="bill_total_without_tax" title="Total sin IVA" v-model="record.bill_total_without_tax" class="form-control input-sm">
                        </div>
                    </div>
                </div>
                <div class="col-md-12 text-right">
                    <div class="d-inline-flex align-items-center">
                        <label class="font-weight-bold">IVA:</label>
                        <div class="form-group is-required">
                            <input type="text" disabled placeholder="Total IVA" id="total_iva" title="Total IVA" v-model="(record.bill_total - record.bill_total_without_tax).toFixed(2)" class="form-control input-sm">
                        </div>
                    </div>
                </div>
                <div class="col-md-12 text-right">
                    <div class="d-inline-flex align-items-center">
                        <label class="font-weight-bold">Total a pagar:</label>
                        <div class="form-group is-required">
                            <input type="text" disabled placeholder="Total a pagar" id="bill_total" title="Total" v-model="record.bill_total" class="form-control input-sm">
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <b>Complementarios</b>
                </div>
                <div class="col-md-3" id="SaleHelpPaymentMethod">
                    <div class="form-group is-required">
                        <label>Forma de cobro:</label>
                        <select2 :options="bill_payments" v-model="record.sale_payment_method_id" id="sale_payment_method_id"></select2>
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
                    <button type="button" @click="createBill('sale/bills')"
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
        props:{
                billid:{
                    type:Number,
                },
        },
        data() {
            return {
                record: {
                    id: '',
                    //Datos del solicitante
                    type_person: '',
                    name: '',
                    id_number: '',
                    rif: '',
                    phone: '',
                    email: '',
                    bill_clients: [],
                    //Descripción de productos
                    product_type: '',
                    sale_warehouse_inventory_product_id: '',
                    bill_edit: false,
                    sale_goods_to_be_traded_id: '',
                    measurement_unit_id: '',
                    value: 0,
                    quantity: 0,
                    total: 0,
                    bill_total_without_tax: '0',
                    bill_total: '0',
                    currency_id: '',
                    history_tax_id: '',
                    history_tax_value: 0,
                    product_position_value: 0,
                    sale_bill_products: [],
                    //Complementarios
                    sale_payment_method_id: '',
                },
                product_type: '',
                sale_bill_products: [],
                product_position_value: 0,
                quote_clients: [],
                errors: [],
                columns: [
                    'product_type',
                    'sale_warehouse_inventory_product_id',
                    'sale_list_subservices_id',
                    'measurement_unit.name',
                    'value',
                    'quantity',
                    'total_without_tax',
                    'product_tax_value',
                    'total',
                    'currency.name',
                    'id',
                ],
                columns_clients: ['id', 'type_person_juridica', 'rif', 'name_client', 'phones', 'sale_clients_email'],
                types_person:  [
                    {'id' : '', 'text' : "Seleccione..."},
                    {'id' : 'Natural', 'text' : 'Natural'},
                    {'id' : 'Jurídica', 'text' : 'Jurídica'}
                ],
                type_products:  [
                    {'id' : '', 'text' : "Seleccione..."},
                    {'id' : 'Producto', 'text' : 'Producto'},
                    {'id' : 'Servicio', 'text' : 'Servicio'}
                ],
                quote_inventory_products_list : [],
                bill_good_to_be_traded : [],
                quote_subservices_list : [],
                currencies : [],
                quote_taxes : [],
                quote_measurement_units : [],
                bill_payments : [],
            }
        },
        methods: {
            /**
             * Método que carga la información del formulario al editar
             *
             * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
             */
            async loadForm(id){
                const vm = this;

                await axios.get('/sale/bills/info/'+id).then(response => {
                    if(typeof(response.data.records != "undefined")){
                        vm.record = response.data.records;

                        for (let product of response.data.records.sale_bill_inventory_product) {
                            if (product.sale_warehouse_inventory_product_id) {
                                product.inventory_product = {
                                    'id': product.sale_warehouse_inventory_product_id,
                                    'name': product.sale_warehouse_inventory_product.sale_setting_product.name,
                                };
                            }

                            if(product.history_tax_id) {
                                product.total_without_tax = product.quantity * product.value;
                                product.product_tax_value = (product.total_without_tax * parseFloat(product.history_tax.percentage)) / 100;
                                product.total = product.total_without_tax + product.product_tax_value;
                            } else {
                                product.total_without_tax = product.quantity * product.value;
                                product.product_tax_value = 0;
                                product.total = product.total_without_tax + product.product_tax_value;
                            }

                            vm.record.sale_bill_products.push(product);                            
                        }
                    }
                });
            },

            /**
             * Agrega la informacion del cliente desde el modal de clientes
             *
             * @author Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
            */
            addClient(index, client) {
                this.record.type_person = client.type_person_juridica;
                this.record.name = client.name_client? client.name_client : client.name;
                this.record.id_number = client.rif? client.rif : client.id_type + '-' + client.id_number;
                this.record.phone = client.phones && client.phones.length? client.phones[0].area_code + '-' + client.phones[0].number : '';
                this.record.email = client.sale_clients_email && client.sale_clients_email.length? client.sale_clients_email[0].email : '';
                $("#view_sale_bill_clients").modal('hide');
            },
            /**
             * Limpia el formulario por completo
             *
             * @author Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
            */
            reset() {
                const vm = this;
                vm.record = {
                    id: '',
                    sale_bill_products: [],
                    type_person: '',
                    name: '',
                    id_number: '',
                    email: '',
                    phone: '',
                    product_position_value: 0,
                };
                vm.record.product_position_value = 0;
                vm.record.product_type = '';
                vm.record.sale_warehouse_inventory_product_id = '';
                vm.record.sale_goods_to_be_traded_id = '';
                vm.record.sale_list_subservices_id = '';
                vm.resetProduct();
                vm.record.bill_total_without_tax = 0;
                vm.record.bill_total = 0;
            },
            /**
             * Limpia el formulario de productos cuando hay un cambio en los selects
             *
             * @author Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
            */
            resetProduct() {
                const vm = this;
                vm.record.quantity = 0;
                vm.record.value = 0;
                vm.record.total = 0;
                vm.record.measurement_unit_id = '';
                vm.record.currency_id = '';
                vm.record.history_tax_id = '';
                vm.record.history_tax_value = 0;
                vm.updateTotalProduct();
            },

            /**
             * Agrega la informacion de un producto al formulario para su edicion
             *
             * @author Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
            */
            editProduct(index, event) {
                const vm = this;
                vm.resetProduct();
                let product = vm.record.sale_bill_products[index - 1];
                vm.record.product_type = product.product_type;
                vm.record.sale_warehouse_inventory_product_id = product.sale_warehouse_inventory_product_id;
                vm.record.sale_goods_to_be_traded_id = product.sale_goods_to_be_traded_id;
                vm.record.sale_list_subservices_id = product.sale_list_subservices_id;
                vm.record.measurement_unit_id = product.measurement_unit_id;
                vm.record.currency_id = product.currency_id;
                vm.record.value = product.value;
                vm.record.quantity = product.quantity;
                vm.record.history_tax_id = product.history_tax_id;
                vm.record.history_tax_value = product.history_tax_value;
                vm.updateTotalProduct();
                vm.record.product_position_value = index;
                event.preventDefault();
            },
            /**
             * Elimina un producto de la tabla del formulario
             *
             * @author Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
             * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
            */
            removeProduct(index, event) {
                const vm = this;
                let previos_total = parseFloat(vm.record.sale_bill_products[index - 1].total);
                let previos_total_without_tax = parseFloat(vm.record.sale_bill_products[index - 1].total_without_tax);
                vm.record.bill_total -= previos_total;
                vm.record.bill_total_without_tax -= previos_total_without_tax;
                this.record.sale_bill_products.splice(index - 1, 1);
            },
            /**
             * Actualiza el total de los productos
             *
             * @author Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
            */
            updateTotalProduct() {
                const vm = this;
                vm.record.quantity = parseInt(vm.record.quantity);
                vm.record.value = parseFloat(vm.record.value);
                vm.record.total = vm.record.value * vm.record.quantity;
            },
            /**
             * Actualiza la informacion de un producto (desde inventario o bienes para comercializar)
             *
             * @author Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
             * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
            */
            updateProduct() {
                const vm = this;
                let entity_load = '';
                let id = 0;
                if (vm.record.product_type == 'Producto') {
                    entity_load = 'Producto';
                    vm.record.sale_goods_to_be_traded_id = '';
                    id = vm.record.sale_warehouse_inventory_product_id;
                }
                else {
                    entity_load = 'Servicio';
                    vm.record.sale_warehouse_inventory_product_id = '';
                    id = vm.record.sale_goods_to_be_traded_id;
                }
                if (id) {
                    axios.get('/sale/get-bill-product' + '/' + entity_load + '/' + id).then(function (response) {
                        let product = response.data.record;
                        let tax_percentage = '';

                        if (entity_load == 'Producto' && product) {
                            let product_value = product.unit_value ? product.unit_value : vm.record.value;
                            vm.record.value = product_value;
                            product_value = product.measurement_unit_id ? product.measurement_unit_id : vm.record.measurement_unit_id;
                            vm.record.measurement_unit_id = product_value;
                            product_value = product.currency_id ? product.currency_id : vm.record.currency_id;
                            vm.record.currency_id = product_value;
                            product_value = product.history_tax_id ? product.history_tax_id : vm.record.history_tax_id;
                            vm.record.history_tax_id = product_value;
                            vm.record.history_tax_value = vm.quote_taxes[product_value] ? parseFloat(quote_taxes[product_value].text) : vm.record.history_tax_value;
                            vm.updateTotalProduct();
                        }

                        if (entity_load == 'Servicio' && product) {
                            let product_value = product.unit_price ? product.unit_price : vm.record.value;
                            vm.record.value = product_value;
                            product_value = product.measurement_unit_id ? product.measurement_unit_id : vm.record.measurement_unit_id;
                            vm.record.measurement_unit_id = product_value;
                            product_value = product.currency_id ? product.currency_id : vm.record.currency_id;
                            vm.record.currency_id = product_value;
                            product_value = product.history_tax_id ? product.history_tax_id : vm.record.history_tax_id;
                            vm.record.history_tax_id = product_value;
                            vm.record.history_tax_value = product.history_tax_id ? parseFloat(product.history_tax.percentage) : vm.record.history_tax_value;
                            vm.updateTotalProduct();
                        }
                    });
                }
            },
            /**
             * Agrega un producto al formulario
             *
             * @author Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
             * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
            */
            addProduct(event) {
                const vm = this;
                let product = {}
                //validate product
                let option_name;
                if (vm.record.product_type == '') {
                    bootbox.alert("Debe seleccionar un tipo de producto");
                    return false;
                }
                product.product_type = vm.record.product_type;
                if (vm.record.product_type == 'Producto') {
                    if (vm.record.sale_warehouse_inventory_product_id == '') {
                        bootbox.alert("Debe seleccionar un producto");
                        return false;
                    }
                    product.sale_warehouse_inventory_product_id = vm.record.sale_warehouse_inventory_product_id;
                    option_name = product.sale_warehouse_inventory_product_id;
                    let inventory_product = vm.quote_inventory_products_list.find(o => o.id == product.sale_warehouse_inventory_product_id);
                    if (typeof inventory_product !== "undefined") {
                        option_name = inventory_product.text;
                    }
                    product.inventory_product = {
                        'id': product.sale_warehouse_inventory_product_id,
                        'name': option_name,
                    };

                    product.sale_goods_to_be_traded_id = '';
                    product.sale_list_subservices_id = '';
                }
                else if (vm.record.product_type == 'Servicio') {
                    if (vm.record.sale_goods_to_be_traded_id == '') {
                        bootbox.alert("Debe seleccionar un servicio");
                        return false;
                    }
                    product.sale_warehouse_inventory_product_id = '';
                    product.sale_goods_to_be_traded_id = vm.record.sale_goods_to_be_traded_id;
                    option_name = product.sale_goods_to_be_traded_id;
                    let good_to_be_traded = vm.bill_good_to_be_traded.find(o => o.id == product.sale_goods_to_be_traded_id);
                    if (typeof good_to_be_traded !== "undefined") {
                        option_name = good_to_be_traded.text;
                    }
                    product.sale_goods_to_be_traded = {
                        'id': product.sale_goods_to_be_traded_id,
                        'name': option_name,
                    };
                    product.sale_list_subservices_id = ''
                    if (vm.record.sale_list_subservices_id != '') {
                        product.sale_list_subservices_id = vm.record.sale_list_subservices_id;
                        option_name = product.sale_list_subservices_id;
                        let subservices_list = vm.quote_subservices_list.find(o => o.id == product.sale_list_subservices_id);
                        if (typeof subservices_list !== "undefined") {
                            option_name = subservices_list.text;
                        }
                        product.sale_list_subservices = {
                            'id': product.sale_list_subservices_id,
                            'name': option_name,
                        };
                    }
                }
                if (vm.record.measurement_unit_id == '') {
                    bootbox.alert("Debe seleccionar una unidad de medida");
                    return false;
                }
                product.measurement_unit_id = vm.record.measurement_unit_id;
                option_name = product.measurement_unit_id;
                let measurement_unit = vm.quote_measurement_units.find(o => o.id == product.measurement_unit_id);
                if (typeof measurement_unit !== "undefined") {
                    option_name = measurement_unit.text;
                }
                product.measurement_unit = {
                    'id': product.measurement_unit_id,
                    'name': option_name,
                };

                if (vm.record.value <= 0) {
                    bootbox.alert("El precio unitario debe ser mayor que 0");
                    return false;
                }
                product.value = vm.record.value;
                if (vm.record.quantity <= 0) {
                    bootbox.alert("La cantidad de productos debe ser mayor que 0");
                    return false;
                }
                product.quantity = vm.record.quantity;
                //math total without tax
                product.total_without_tax = product.quantity * product.value;
                
                if (vm.record.currency_id == '') {
                    bootbox.alert("Debe seleccionar un tipo de moneda");
                    return false;
                }
                product.currency_id = vm.record.currency_id;
                option_name = product.currency_id;
                let currency = vm.currencies.find(o => o.id == product.currency_id);
                if (typeof currency !== "undefined") {
                    option_name = currency.text;
                }
                product.currency = {
                    'id': product.currency_id,
                    'name': option_name,
                };
                product.history_tax_id = vm.record.history_tax_id;
                product.history_tax_value = vm.record.history_tax_value;
                product.product_tax_value = (product.total_without_tax * product.history_tax_value) / 100;
                product.total = product.total_without_tax + product.product_tax_value;
                let product_index = parseInt(vm.record.product_position_value);
                let previos_total = 0;
                let previos_total_without_tax = 0;
                if (product_index > 0) {
                    previos_total = parseFloat(vm.record.sale_bill_products[product_index - 1].total);
                    previos_total_without_tax = parseFloat(vm.record.sale_bill_products[product_index - 1].total_without_tax);
                    vm.record.sale_bill_products.splice(product_index - 1, 1);
                }
                vm.record.sale_bill_products.push(product);
                vm.record.bill_total = parseFloat(vm.record.bill_total) + parseFloat(product.total) - previos_total;
                vm.record.bill_total_without_tax = parseFloat(vm.record.bill_total_without_tax) + parseFloat(product.total_without_tax) - previos_total_without_tax;
                vm.product_type = '';
                vm.record.product_position_value = 0;
                vm.record.product_type = '';
                vm.record.sale_warehouse_inventory_product_id = '';
                vm.record.sale_goods_to_be_traded_id = '';
                vm.record.sale_list_subservices_id = '';
                vm.record.quantity = 0;
                this.resetProduct();
            },
            /**
             * Crea o actualiza una cotización
             *
             * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
            */
            createBill(url) {
                const vm = this;
                if (vm.record.id) {
                    vm.updateRecord(url);  
                } 
                else{
                    vm.createRecord(url);
                }
            },
            /**
             * Muestra el modal de clientes en el formulario
             *
             * @author Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
             * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
            */
            showModal(modal_id = '') {
                if ($("#" + modal_id).length) {
                    $("#" + modal_id).modal('show');
                }
            },

            /**
             * Método que carga las formas de cobro para los select
             *
             * @author  Daniel Contreras <dcontreras@cenditel.gob.ve>
             */
            getSalePayments() {
                const vm = this;
                vm.bill_payments = [];

                axios.get('/sale/get-form-payments/').then(response => {
                        vm.bill_payments = response.data;
                });
            },

            /**
             * Obtiene un arreglo con la lista los productos para ser comercializados en facturas
             *
             * @author  Daniel Contreras <dcontreras@cenditel.gob.ve>
             */
            getBillGoodsToBeTraded() {
                const vm = this;
                vm.bill_good_to_be_traded = [];
                axios.get('/sale/get-sale-goods').then(response => {
                    vm.bill_good_to_be_traded = response.data.records;
                });
            },
        },
        created() {
            this.record.sale_bill_products = [];
            this.table_options.headings = {
                'product_type': 'Tipo de Producto',
                'sale_warehouse_inventory_product_id': 'Producto',
                'sale_list_subservices_id': 'Subservicio',
                'measurement_unit.name': 'Unidad de medida',
                'value': 'Precio unitario',
                'quantity': 'Cantidad de productos',
                'total_without_tax': 'Total sin iva',
                'product_tax_value': 'Iva',
                'total': 'Total',
                'currency.name': 'Moneda',
                'id': 'Acción'
            };
            this.table_options.sortable = [];
            this.table_options.filterable = [];
            this.table_options.columnsClasses = {
                'product_type': 'col-xs-1',
                'sale_warehouse_inventory_product_id': 'col-xs-1',
                'sale_list_subservices_id': 'col-xs-1',
                'measurement_unit.name': 'col-xs-1',
                'value': 'col-xs-1',
                'quantity': 'col-xs-1',
                'total_without_tax': 'col-xs-1',
                'product_tax_value': 'col-xs-1',
                'total': 'col-xs-1',
                'currency_id': 'col-xs-1',
                'id': 'col-xs-2'
            };
            this.table_options_clients = {
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
            this.table_options_clients.headings = {
                'id': 'Acción',
                'type_person_juridica': 'Tipo de Persona',
                'rif': 'Identificación del Cliente',
                'name_client': 'Nombre',
                'phones': 'Telefonos',
                'sale_clients_email': 'Correo Electrónico'
            };
            this.table_options_clients.sortable = [
                'type_person_juridica',
            ];
            this.table_options_clients.filterable = [
                'type_person_juridica',
                'rif',
                'id_number',
                'name',
                'name_client',
            ];
        },
        watch: {
            /**
             * Método que supervisa los cambios en el selector de tipo de producto para limpiar la información
             * dependiendo de si es un producto, un servicio, o esta vacio
             *
             * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
            */
            product_type() {
                const vm = this;
                if (vm.product_type == 'Producto') {
                    vm.record.product_type = 'Producto';
                    vm.record.sale_goods_to_be_traded_id = '';
                    vm.record.sale_list_subservices_id = '';
                    vm.record.value = 0;
                    vm.record.measurement_unit_id = '';
                    vm.record.currency_id = '';
                    vm.record.quantity = 0;
                    vm.record.total = 0;
                } else if (vm.product_type == 'Servicio') {
                    vm.record.product_type = 'Servicio';
                    vm.record.sale_warehouse_inventory_product_id = '';
                    vm.record.value = 0;
                    vm.record.measurement_unit_id = '';
                    vm.record.currency_id = '';
                    vm.record.quantity = 0;
                    vm.record.total = 0;
                } else {
                    vm.record.product_type = '';
                    vm.record.sale_goods_to_be_traded_id = '';
                    vm.record.sale_list_subservices_id = '';
                    vm.record.value = 0;
                    vm.record.measurement_unit_id = '';
                    vm.record.currency_id = '';
                    vm.record.quantity = 0;
                    vm.record.total = 0;
                }
            }
        },
        mounted() {
            const vm = this;
            vm.product_position_value = 0;
            vm.record.bill_total_without_tax = '0';
            vm.record.bill_total = '0';
            vm.resetProduct();
            vm.getCurrencies();
            vm.getQuoteTaxes();
            vm.getQuoteListSubservices();
            vm.getQuoteMeasurementUnits();
            vm.getQuotePayments();
            vm.getQuoteInventoryProducts();
            vm.getQuoteClients();
            /*vm.extractQuote();*/
            vm.getSalePayments();
            vm.getBillGoodsToBeTraded();

            if(vm.billid){
                vm.loadForm(vm.billid);
            }
        },
    };
    //$(document).ready(function() {
    //    let today = new Date();
    //    let dd = today.getDate();
    //    let mm = today.getMonth() + 1;
    //    let yyyy = today.getFullYear();
    //    if(dd < 10) {
    //        dd = '0' + dd;
    //    }
    //    if(mm < 10) {
    //        mm = '0' + mm;
    //    }
    //    let now = `${yyyy}-${mm}-${dd}`;
    //    $('#deadline_date').attr('min', now);
    //});
</script>

