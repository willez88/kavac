<template>
  <div class="text-center">
    <a class="btn-simplex btn-simplex-md btn-simplex-primary" href=""
      title="Registrar Pedido" data-toggle="tooltip"
      @click="addRecord('add_sale_order', 'sale/register-order', $event);">
      <i class="icofont icofont-archive ico-3x"></i>
      <span>Registrar Pedido</span>
    </a>
    <div class="modal fade text-left" tabindex="-1" role="dialog" id="add_sale_order">
      <div class="modal-dialog vue-crud" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
            <h6><i class="icofont icofont-archive ico-3x"></i>Clientes</h6>
          </div>
          <div class="modal-body">
            <div class="alert alert-danger" v-if="errors.length > 0">
              <ul>
                <li v-for="error in errors">{{ error }}</li>
              </ul>
            </div>
            <h6 class="card-title">Datos del solicitante:</h6>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group is-required">
                  <label for="name">Nombre y apellido del solicitante:</label>
                  <input type="text" id="name" class="form-control input-sm" data-toggle="tooltip"
                    title="Nombre y apellido del solicitante" v-model="record.name">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group is-required">
                  <label for="email">Correo electrónico del solicitante:</label>
                  <input type="text" id="email" class="form-control input-sm" data-toggle="tooltip"
                    title="Correo electrónico del solicitante" v-model="record.email">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group is-required">
                  <label for="phone">Número de teléfono:</label>
                  <input type="text" id="phone" class="form-control input-sm" data-toggle="tooltip"
                    title="Número de teléfono" v-model="record.phone" placeholder="00-000-0000000">
                </div>
              </div>
            </div>
            <h6 class="card-title">Datos del pedido:</h6>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group is-required">
                  <label for="name">Registro de Productos:</label>
                </div>
                <h6 class="card-title">
                  Agregar nuevo producto <i class="fa fa-plus-circle cursor-pointer" @click="addProductFormPayment"></i>
                </h6>
              </div>
            </div>
            <div class="row" v-for="(product, index) in record.list_products">
              <div class="col-md-4">
                <div class="form-group is-required">
                  <label>Producto</label>
                  <select2 :options="sale_setting_products"
                    v-model="product.name" @input="getPriceProduct" class="list-product" :data-index="index"></select2>
                  <input type="hidden" v-model="product.id">
                </div>
              </div>
              <div class="col-md-1">
                <div class="form-group is-required">
                  <label>Estado:</label>
                  <input type="text" disabled placeholder="Estado del producto" title="" v-model="product.status" class="form-control input-sm" required :data-index="index">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group is-required">
                  <label>Cantidad de productos:</label>
                  <input type="text" placeholder="Cantidad de productos" title="Cantidad de productos" v-model="product.quantity" class="form-control input-sm" required :data-index="index" @input="getTotalProduct">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group is-required">
                  <label>Precio unitario:</label>
                  <input type="text" disabled placeholder="Precio unitario" title="Precio unitario" v-model="product.price_product" class="form-control input-sm" required :data-index="index">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group is-required">
                  <label>Monto total del pedido:</label>
                  <input type="text" disabled placeholder="Cantidad total" title="Cantidad total" v-model="product.total" class="form-control input-sm" required :data-index="index">
                </div>
              </div>
              <div class="col-1">
                <div class="form-group">
                  <button class="btn btn-sm btn-danger btn-action" type="button" @click="deleteProductFormPayment" title="Eliminar este atributo" data-toggle="tooltip">
                    <i class="fa fa-minus-circle"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <div class="form-group">
              <modal-form-buttons :saveRoute="'sale/register-order'"></modal-form-buttons>
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
                <button @click="deleteRecord(props.row.id, 'register-formatcode')"
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
  </div>
</template>

<script>
  export default {
    data() {
      return {
        record: {
          id: '',
          list_products: [],
          name: '',
          email: ''
        },
        sale_setting_products: [],
        errors: [],
        records: [],
        columns: ['name', 'email', 'phone', 'id'],
      }
    },
    methods: {
      reset() {
        this.record = {
          id: '',
          list_products: [],
          name: '',
          email: '',
          phone: ''
        };
      },
      getTotalProduct(event) {
        const vm = this;
        const index = $(event.target).data('index');

        const price = vm.record.list_products[index].price_product;
        vm.record.list_products[index].total = price * $(event.target).val();
      },
      getPriceProduct(value) {
        const vm = this;
        var $element = '';

        $("select.list-product").change(function () {
          $element = this;

          if ($element.value) {
			axios.get('/sale/get-price-product' + '/' + $element.value).then(function (response) {
			  vm.record.list_products[$($element).data('index')].price_product = response.data.record.price;
		    });
	      }
        });
      },
      getSaleSettingProducts() {
        const vm = this;
        axios.get('/sale/get-setting-product').then(response => {
          vm.sale_setting_products = response.data;
        });
      },
      addProductFormPayment() {
        this.record.list_products.push({
          id: '',
          name: '',
          status: '',
          quantity: 0,
          price_product: 0,
          total: 0
        });
      },
      deleteProductFormPayment(index) {
        this.record.list_products.splice(index, 1);
      },
    },
    created() {
      this.table_options.headings = {
        'name': 'Nombre y apellido del solicitante',
        'email': 'Correo del solicitante',
        'phone': 'Telefono del solicitante',
        'id': 'Acción'
      };
      this.table_options.sortable = ['name'];
      this.table_options.filterable = ['name'];
      this.table_options.columnsClasses = {
        'name': 'col-xs-4',
        'email': 'col-xs-3',
        'phone': 'col-xs-3',
        'id': 'col-xs-2'
      };
    },
    mounted() {
      this.getSaleSettingProducts();
    },
  };
</script>
