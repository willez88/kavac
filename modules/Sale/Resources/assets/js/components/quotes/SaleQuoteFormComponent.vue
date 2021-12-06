<template>
  <section id="SaleQuoteViewClients">
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
      <h6 class="card-title">I Datos del solicitante:
        <a class="btn btn-info btn-xs btn-icon btn-action display-inline" 
          href="#" title="Ver información del registro" data-toggle="tooltip" 
          @click.prevent="showModal('view_sale_quote')">
          <i class="icofont icofont-business-man ico-2x"></i>
        </a>
      </h6>
      <div class="client-list">
        <div class="modal fade text-left" tabindex="-1" role="dialog" id="view_sale_quote" ref="clients-modal">
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
      <div class="row">
        <div class="col-md-4">
          <div class="form-group is-required">
            <label for="type_person">Tipo de persona:</label>
            <select2 :options="types_person" id='type_person' v-model="record.type_person"></select2>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group is-required">
            <label v-show="record.type_person == ''" for="name">Nombre de la Empresa:</label>
            <label v-show="record.type_person == 'Jurídica'" for="name">Nombre de la Empresa:</label>
            <label v-show="record.type_person == 'Natural'" for="name">Nombre y Apellido:</label>
            <input type="text" id="name" class="form-control input-sm" data-toggle="tooltip"
              title="Nombre" v-model="record.name">
            <input type="hidden" name="id" id="id" v-model="record.id">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group is-required">
            <label v-show="record.type_person == ''" for="id_number">RIF</label>
            <label v-show="record.type_person == 'Jurídica'" for="id_number">RIF</label>
            <label v-show="record.type_person == 'Natural'" for="id_number">Identificación</label>
            <input type="text" id="id_number" class="form-control input-sm" data-toggle="tooltip"
              title="Indique la identificación del cliente" v-model="record.id_number">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group is-required">
            <label for="phone">Teléfono de contacto:</label>
            <input type="text" id="phone" class="form-control input-sm" data-toggle="tooltip" required
              title="Número de teléfono" v-model="record.phone" placeholder="00-000-0000000">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group is-required">
            <label for="email">Correo Electrónico:</label>
            <input type="text" id="email" class="form-control input-sm" data-toggle="tooltip" required
              title="Correo electrónico del solicitante" v-model="record.email">
          </div>
        </div>
      </div>
      <h6 class="card-title">II Descripción de productos:</h6>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group is-required">
            <label for="product_type">Tipo de Producto:</label>
            <input type="hidden" name="product_position_value" id="product_position_value" v-model="record.product_position_value">
            <select2 :options="type_products" id='product_type' v-model="record.product_type"></select2>
          </div>
        </div>
        <div v-show="record.product_type == ''" class="col-md-6">
        </div>
        <div v-show="record.product_type == 'Producto'" class="col-md-6">
          <div class="form-group is-required">
            <label for="product_type">Producto:</label>
            <select2 :options="quote_inventory_products_list" id="sale_warehouse_inventory_product_id" v-model="record.sale_warehouse_inventory_product_id" @input="updateProduct"></select2>
          </div>
        </div>
        <div v-show="record.product_type == 'Servicio'" class="col-md-3">
          <div class="form-group is-required">
            <label for="sale_type_good_id">Servicio:</label>
            <select2 :options="quote_good_to_be_traded" id="sale_type_good_id" v-model="record.sale_type_good_id" @input="updateProduct"></select2>
          </div>
        </div>
        <div v-show="record.product_type == 'Servicio'" class="col-md-3">
          <div class="form-group is-required">
            <label for="sale_list_subservices_id">Subservicios:</label>
            <select2 :options="quote_subservices_list" id="sale_list_subservices_id" v-model="record.sale_list_subservices_id"></select2>
          </div>
        </div>
        <div class="col-md-2" id="SaleHelpProductMeasurementUnit">
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
            <label v-show="record.has_quantity_max">Cantidad disponible en inventario: {{ record.quantity_max_value }} </label>
            <input type="hidden" name="has_quantity_max" id="has_quantity_max" v-model="record.has_quantity_max">
            <input type="hidden" name="quantity_max_value" id="quantity_max_value" v-model="record.quantity_max_value">
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label>Precio total:</label>
            <input type="text" disabled placeholder="Total" id="total" title="Cantidad total" v-model="record.total" class="form-control input-sm" required>
            <input type="hidden" name="history_tax_id" id="history_tax_id" v-model="record.history_tax_id">
            <input type="hidden" name="history_tax_value" id="history_tax_value" v-model="record.history_tax_value">
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group is-required">
            <label>Moneda:</label>
            <select2 :options="currencies" v-model="record.currency_id" id="currency_id"></select2>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 text-center">
          <div class="d-inline-flex mt-4">
            <button type="button" @click="resetProductClean($event)" class="btn btn-sm btn-primary btn-custom" 
              title="Limpiar información del producto" data-toggle="tooltip">
              <i class="fa fa-eraser"></i>
              Cancelar
            </button>
            <button type="button" @click="addProductToQuote($event)" class="btn btn-sm btn-primary btn-custom" 
              title="Agregar producto a la lista" data-toggle="tooltip">
              <i class="fa fa-plus-circle"></i>
              Agregar
            </button>
          </div>
        </div>
      </div>

      <v-client-table :columns="columns" :data="record.sale_quote_products" :options="table_options">
        <div slot="sale_warehouse_inventory_product_id" slot-scope="props" class="text-center">
          <span>
            {{ (props.row.sale_warehouse_inventory_product_id)? props.row.inventory_product.name : props.row.sale_type_good.name }}
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
              title="Modificar Producto" data-toggle="tooltip" type="button">
              <i class="fa fa-edit"></i>
            </button>
            <button @click="removeProduct(props.index, $event)" 
              class="btn btn-danger btn-xs btn-icon btn-action" 
              title="Eliminar producto" data-toggle="tooltip" 
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
            <div class="form-group">
              <input type="text" disabled placeholder="Total Sin IVA" id="quote_total_without_tax" title="Total sin IVA" v-model="record.quote_total_without_tax" class="form-control input-sm">
            </div>
          </div>
        </div>
        <div class="col-md-12 text-right">
          <div class="d-inline-flex align-items-center">
            <label class="font-weight-bold">IVA:</label>
            <div class="form-group">
              <input type="text" disabled placeholder="Total IVA" id="total_iva" title="Total IVA" v-model="(record.quote_total - record.quote_total_without_tax).toFixed(2)" class="form-control input-sm">
            </div>
          </div>
        </div>
        <div class="col-md-12 text-right">
          <div class="d-inline-flex align-items-center">
            <label class="font-weight-bold">Total a pagar:</label>
            <div class="form-group">
              <input type="text" disabled placeholder="Total a pagar" id="quote_total" title="Total" v-model="record.quote_total" class="form-control input-sm">
            </div>
          </div>
        </div>
      </div>
      <h6 class="card-title">III Complementarios:</h6>
      <div class="row">
        <div class="col-md-3" id="SaleHelpPaymentMethod">
          <div class="form-group is-required">
            <label>Forma de cobro:</label>
            <select2 :options="quote_payments" v-model="record.sale_form_payment_id" id="sale_form_payment_id"></select2>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group is-required">
            <label>Fecha límite de respuesta</label>
            <input type="date" class="form-control input-sm no-restrict min-now" v-model="record.deadline_date" id="deadline_date"/>
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
          <button type="button" @click="createQuote('sale/quotes')"
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
        quote:{
            type:Object,
            default: function() {
                return null;
            }
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
          phone: '',
          email: '',
          quote_clients: [],
          //Descripción de productos
          product_type: '',
          sale_warehouse_inventory_product_id: '',
          quote_edit: false,
          sale_type_good_id: '',
          measurement_unit_id: '',
          value: 0,
          quantity: 0,
          total: 0,
          quote_total_without_tax: '0',
          quote_total: '0',
          currency_id: '',
          history_tax_id: '',
          history_tax_value: 0,
          has_quantity_max: 0,
          quantity_max_value: '',
          product_position_value: 0,
          sale_quote_products: [],
          //Complementarios
          sale_form_payment_id: '',
          deadline_date: this.dateNow(),
        },
        sale_quote_products: [],
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
        quote_good_to_be_traded : [],
        quote_subservices_list : [],
        currencies : [],
        quote_taxes : [],
        quote_measurement_units : [],
        quote_payments : [],
        quote_good_to_be_traded : [],
      }
    },
    methods: {
      /**
       * Agrega la informacion del cliente desde el modal de clientes
       *
       * @author Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
      */
      addClient(index, client) {
        this.record.type_person = client.type_person_juridica;
        this.record.name = client.name_client? client.name_client : client.name;
        this.record.id_number = client.rif? client.rif : client.id_number;
        this.record.id_number = this.record.id_number.replace(/\D/g, "");
        this.record.phone = client.phones && client.phones.length? client.phones[0].area_code + '-' + client.phones[0].number : '';
        this.record.email = client.sale_clients_email && client.sale_clients_email.length? client.sale_clients_email[0].email : '';
        $("#view_sale_quote").modal('hide');
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
          sale_quote_products: [],
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
        vm.record.sale_type_good_id = '';
        vm.record.sale_list_subservices_id = '';
        vm.resetProduct();
        vm.record.quote_total_without_tax = 0;
        vm.record.quote_total = 0;
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
        vm.record.has_quantity_max = 0;
        vm.record.quantity_max_value = '';
        vm.updateTotalProduct();
      },
      /**
       * Limpia el formulario de productos completamente
       *
       * @author Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
      */
      resetProductClean(event) {
        const vm = this;
        vm.record.product_position_value = 0;
        vm.record.product_type = '';
        vm.record.sale_warehouse_inventory_product_id = '';
        vm.record.sale_type_good_id = '';
        vm.record.sale_list_subservices_id = '';
        vm.resetProduct();
      },
      /**
       * Agrega la informacion de un producto al formulario para su edicion
       *
       * @author Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
      */
      editProduct(index, event) {
        const vm = this;
        vm.resetProduct();
        let product = vm.record.sale_quote_products[index - 1];
        vm.record.product_type = product.product_type;
        vm.record.sale_warehouse_inventory_product_id = product.sale_warehouse_inventory_product_id;
        vm.record.sale_type_good_id = product.sale_type_good_id;
        vm.record.sale_list_subservices_id = product.sale_list_subservices_id;
        vm.record.measurement_unit_id = product.measurement_unit_id;
        vm.record.currency_id = product.currency_id;
        vm.record.value = product.value;
        vm.record.quantity = product.quantity;
        vm.record.history_tax_id = product.history_tax_id;
        vm.record.history_tax_value = product.history_tax_value;
        vm.record.has_quantity_max = product.has_quantity_max;
        vm.record.quantity_max_value = product.quantity_max_value;
        vm.updateTotalProduct();
        vm.record.product_position_value = index;
        event.preventDefault();
      },
      /**
       * Elimina un producto de la tabla del formulario
       *
       * @author Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
      */
      removeProduct(index, event) {
        const vm = this;
        let previos_total = parseFloat(vm.record.sale_quote_products[index - 1].total);
        let previos_total_without_tax = parseFloat(vm.record.sale_quote_products[index - 1].total_without_tax);
        vm.record.quote_total -= previos_total;
        vm.record.quote_total_without_tax -= previos_total_without_tax;
        this.record.sale_quote_products.splice(index - 1, 1);
      },
      /**
       * Actualiza el total de los productos
       *
       * @author Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
      */
      updateTotalProduct() {
        const vm = this;
        vm.record.quantity = parseInt(vm.record.quantity);
        if (isNaN(vm.record.quantity)) {
          vm.record.quantity = 0;
        }
        vm.record.value = parseFloat(vm.record.value);
        if (isNaN(vm.record.value)) {
          vm.record.value = 0;
        }
        vm.record.total = vm.record.value * vm.record.quantity;
      },
      /**
       * Actualiza la informacion de un producto (desde inventario o bienes para comercializar)
       *
       * @author Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
      */
      updateProduct() {
        const vm = this;
        var entity_load = 'service';
        var id = 0;
        if (vm.record.product_type == 'Producto') {
          entity_load = 'product';
          vm.record.sale_type_good_id = '';
          id = vm.record.sale_warehouse_inventory_product_id;
        }
        else {
          entity_load = 'service';
          vm.record.sale_warehouse_inventory_product_id = '';
          id = vm.record.sale_type_good_id;
        }
        if (id) {
          axios.get('/sale/get-quote-price-' + entity_load + '/' + id).then(function (response) {
            let product = response.data.record;
            if (product) {
              let product_value = product.unit_value? product.unit_value : vm.record.value;
              vm.record.value = product_value;
              product_value = product.measurement_unit_id? product.measurement_unit_id : vm.record.measurement_unit_id;
              vm.record.measurement_unit_id = product_value;
              product_value = product.currency_id? product.currency_id : vm.record.currency_id;
              vm.record.currency_id = product_value;
              product_value = product.history_tax_id? product.history_tax_id : vm.record.history_tax_id;
              vm.record.history_tax_id = product_value;
              let tax_value = 0;
              if (product_value > 0) {
                let tax = vm.quote_taxes.find(o => o.id == product_value);
                if (typeof tax !== "undefined") {
                  tax_value = tax.text;
                }
              }
              vm.record.history_tax_value = parseFloat(tax_value) / 100;
              vm.record.has_quantity_max = 0;
              vm.record.quantity_max_value = '';
              product_value = product.exist? product.exist : 0;
              if (product_value) {
                vm.record.has_quantity_max = 1;
                vm.record.quantity_max_value = product_value;
              }

              vm.updateTotalProduct();
            }
          });
        }
      },
      /**
       * Agrega un producto al formulario
       *
       * @author Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
      */
      addProductToQuote(event) {
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

          product.sale_type_good_id = '';
          product.sale_list_subservices_id = '';
        }
        else if (vm.record.product_type == 'Servicio') {
          if (vm.record.sale_type_good_id == '') {
            bootbox.alert("Debe seleccionar un servicio");
            return false;
          }
          product.sale_warehouse_inventory_product_id = '';
          product.sale_type_good_id = vm.record.sale_type_good_id;
          option_name = product.sale_type_good_id;
          let good_to_be_traded = vm.quote_good_to_be_traded.find(o => o.id == product.sale_type_good_id);
          if (typeof good_to_be_traded !== "undefined") {
            option_name = good_to_be_traded.text;
          }
          product.sale_type_good = {
            'id': product.sale_type_good_id,
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

        if (vm.record.has_quantity_max && vm.record.quantity > vm.record.quantity_max_value) {
          bootbox.alert("La cantidad de productos (" + vm.record.quantity + ") debe ser menor o igual a la cantidad disponible en inventario (" + vm.record.quantity_max_value + ")");
          return false;
        }

        product.quantity = vm.record.quantity;
        //math total without tax
        product.total_without_tax = product.quantity * product.value;
        
        if (vm.record.currency_id == '') {
          bootbox.alert("La cantidad de productos debe ser mayor que 0");
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
        product.product_tax_value = (product.total_without_tax * product.history_tax_value);
        product.total = product.total_without_tax + product.product_tax_value;
        let product_index = parseInt(vm.record.product_position_value);
        let previos_total = 0;
        let previos_total_without_tax = 0;
        if (product_index > 0) {
          previos_total = parseFloat(vm.record.sale_quote_products[product_index - 1].total);
          previos_total_without_tax = parseFloat(vm.record.sale_quote_products[product_index - 1].total_without_tax);
          vm.record.sale_quote_products.splice(product_index - 1, 1);
        }
        vm.record.sale_quote_products.push(product);
        vm.record.quote_total = parseFloat(vm.record.quote_total) + parseFloat(product.total) - previos_total;
        vm.record.quote_total_without_tax = parseFloat(vm.record.quote_total_without_tax) + parseFloat(product.total_without_tax) - previos_total_without_tax;
        vm.record.quote_total = vm.record.quote_total.toFixed(2);
        vm.record.quote_total_without_tax = vm.record.quote_total_without_tax.toFixed(2);
        vm.record.product_position_value = 0;
        vm.record.product_type = '';
        vm.record.sale_warehouse_inventory_product_id = '';
        vm.record.sale_type_good_id = '';
        vm.record.sale_list_subservices_id = '';
        vm.record.quantity = 0;
        this.resetProduct();
      },
      /**
       * Crea o actualiza una cotización
       *
       * @author Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
      */
      createQuote(url) {
        const vm = this;
        if (vm.record.id) {
          vm.updateRecord(url);  
        } 
        else{
          vm.createRecord(url);
        }
      },
      /**
       * Obtiene la fecha actual
       *
       * @author Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
      */
      dateNow() {
        let today = new Date();
        let dd = today.getDate();
        let mm = today.getMonth() + 1;
        let yyyy = today.getFullYear();
        if(dd < 10) {
            dd = '0' + dd;
        }
        if(mm < 10) {
            mm = '0' + mm;
        }
        return `${yyyy}-${mm}-${dd}`;
      },
      /**
       * Muestra el modal de clientes en el formulario
       *
       * @author Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
      */
      showModal(modal_id = '') {
        if ($("#" + modal_id).length) {
          $("#" + modal_id).modal('show');
        }
      },
      /**
       * Agrega los campos de la cotización al formulario
       *
       * @author Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
      */
      extractQuote() {
        const vm = this;
        if (vm.quote) {
          vm.quote_edit = true;
          vm.record.id = vm.quote.id;
          //extract client data
          vm.record.type_person = vm.quote.type_person;
          vm.record.name = vm.quote.name;
          vm.record.id_number = vm.quote.id_number;
          vm.record.phone = vm.quote.phone;
          vm.record.quote_total_without_tax = vm.quote.total_without_tax;
          vm.record.quote_total = vm.quote.total;
          //extract products data
          vm.record.sale_quote_products = [];
          $.each(vm.quote.sale_quote_product, function(index, product_load) {
            vm.productToList(product_load);
          });
          vm.record.email = vm.quote.email;
          vm.record.email = vm.quote.email;
          //extract complement data
          vm.record.sale_form_payment_id = vm.quote.sale_form_payment_id;
          vm.record.deadline_date = vm.quote.deadline_date;
        }
      },
      /**
       * Agrega los productos de una cotización al formulario
       *
       * @author Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
      */
      productToList(product_load = {}) {
        const vm = this;
        let product = {};
        let option_name;
        product.product_type = product_load.product_type;
        product.has_quantity_max = 0;
        product.quantity_max_value = '';
        if (product.product_type == 'Producto') {
          product.sale_warehouse_inventory_product_id = product_load.sale_warehouse_inventory_product_id;
          option_name = product.sale_warehouse_inventory_product_id;
          let inventory_product = product_load.sale_warehouse_inventory_product;
          if (typeof inventory_product !== "undefined" && inventory_product) {
            option_name = inventory_product.code;
            if (inventory_product.exist) {
              product.has_quantity_max = 1;
              product.quantity_max_value = inventory_product.exist;
            }
          }
          product.inventory_product = {
            'id': product.sale_warehouse_inventory_product_id,
            'name': option_name,
          };

          product.sale_type_good_id = '';
          product.sale_list_subservices_id = '';
        }
        else if (product.product_type == 'Servicio') {
          product.sale_warehouse_inventory_product_id = '';
          product.sale_type_good_id = product_load.sale_type_good_id;
          option_name = product.sale_type_good_id;
          let good_to_be_traded = product_load.sale_type_good;
          if (typeof good_to_be_traded !== "undefined" && good_to_be_traded) {
            option_name = good_to_be_traded.name;
          }
          product.sale_type_good = {
            'id': product.sale_type_good_id,
            'name': option_name,
          };
          product.sale_list_subservices_id = ''
          if (product_load.sale_list_subservices_id != '') {
            product.sale_list_subservices_id = product_load.sale_list_subservices_id;
            option_name = product.sale_list_subservices_id;
            let subservices_list = product_load.sale_list_subservices;
            if (typeof subservices_list !== "undefined" && subservices_list) {
              option_name = subservices_list.name;
            }
            product.sale_list_subservices = {
              'id': product.sale_list_subservices_id,
              'name': option_name,
            };
          }
        }
        product.value = product_load.value;
        product.measurement_unit_id = product_load.measurement_unit_id;
        option_name = product.measurement_unit_id;
        let measurement_unit = product_load.measurement_unit;
        if (typeof measurement_unit !== "undefined") {
          option_name = measurement_unit.name;
        }
        product.measurement_unit = {
          'id': product.measurement_unit_id,
          'name': option_name,
        };
        product.quantity = product_load.quantity;
        //math total without tax
        product.total_without_tax = product_load.total_without_tax;
        product.total = product_load.total; 
        product.currency_id = product_load.currency_id;
        option_name = product.currency_id;
        let currency = product_load.currency;
        if (typeof currency !== "undefined") {
          option_name = currency.name;
        }
        product.currency = {
          'id': product.currency_id,
          'name': option_name,
        };
        product.history_tax_id = product_load.history_tax_id;

        //product.history_tax_value = product_load.history_tax? parseFloat(product_load.history_tax.percentage) : 0;
        product.product_tax_value = product.total - product.total_without_tax;
        product.product_tax_value = product.product_tax_value.toFixed(2);
        //product.total = product.total_without_tax + product.product_tax_value;
        let product_index = parseInt(vm.record.product_position_value);
        if (product_index > 0) {
          vm.record.sale_quote_products.splice(product_index - 1, 1);
        }
        vm.record.sale_quote_products.push(product);
      },
    },
    created() {
      this.record.sale_quote_products = [];
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
      this.table_options_clients = {};
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
       * Método que supervisa los cambios en el objeto record y actualiza el metodo de pago seleccionado
       * Contraresta el problema de racing condition (https://es.wikipedia.org/wiki/Condici%C3%B3n_de_carrera)
       *
       * @author Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
      */
      record: {
        deep: true,
        handler: function() {
          const vm = this;
          //el select del metodo de pago ya cuenta con opciones
          //es posible en este momento seleccionar una opcion
          if (vm.quote_edit && $('#sale_form_payment_id option').length > 1) {
            if (vm.record.sale_form_payment_id != vm.quote.sale_form_payment_id) {
              $("#sale_form_payment_id").val(vm.quote.sale_form_payment_id).select2();
              vm.record.sale_form_payment_id = vm.quote.sale_form_payment_id;
            }
            else {
              vm.quote_edit = false;
            }
          }
          //editar una cotizacion y el metodo de pago es diferente al del formulario
          //se modifica el valor del pago de record para que este continuamente viendo cambios (watch)
          if (vm.quote_edit && vm.record.sale_form_payment_id != vm.quote.sale_form_payment_id) {
            vm.record.sale_form_payment_id = vm.quote.sale_form_payment_id;
          }
        }
      }
    },
    mounted() {
      const vm = this;
      vm.product_position_value = 0;
      vm.record.quote_total_without_tax = '0';
      vm.record.quote_total = '0';
      vm.resetProduct();
      vm.getCurrencies();
      vm.getQuoteTaxes();
      vm.getQuoteListSubservices();
      vm.getQuoteGoodsToBeTraded();
      vm.getQuoteMeasurementUnits();
      vm.getQuotePayments();
      vm.getQuoteInventoryProducts();
      vm.getQuoteClients();
      vm.extractQuote();
    },
  };
  $(document).ready(function() {
    let today = new Date();
    let dd = today.getDate();
    let mm = today.getMonth() + 1;
    let yyyy = today.getFullYear();
    if(dd < 10) {
      dd = '0' + dd;
    }
    if(mm < 10) {
      mm = '0' + mm;
    }
    let now = `${yyyy}-${mm}-${dd}`;
    $('#deadline_date').attr('min', now);
  });
</script>

