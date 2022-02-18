<template>
  <div class="text-center">
    <a class="btn-simplex btn-simplex-md btn-simplex-primary" href=""
      title="Aprobar Pedidos" data-toggle="tooltip"
      @click="addRecord('add_sale_clients', 'sale/order-register', $event);">
      <i class="icofont icofont-check-circled ico-3x"></i>
      <span>Aprobar Pedidos</span>
    </a>
    <div class="modal fade text-left" tabindex="-1" role="dialog" id="add_sale_clients">
      <div class="modal-dialog vue-crud" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
            <h6><i class="icofont icofont-check-circled ico-3x"></i>Aprobar Pedidos</h6>
          </div>
          <div class="modal-body">
            <div class="alert alert-danger" v-if="errors.length > 0">
              <ul>
                <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
              </ul>
            </div>
            <h6 class="card-title">Datos del solicitante:</h6>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group is-required">
                  <label for="name">Nombre y apellido del solicitante:</label>
                  <input type="text" id="name_client" class="form-control input-sm" data-toggle="tooltip"
                    title="Nombre y apellido del solicitante" v-model="record.name_client">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group is-required">
                  <label for="name">Correo electrónico del solicitante:</label>
                  <input type="text" id="mail_client" class="form-control input-sm" data-toggle="tooltip"
                    title="Correo electrónico del solicitante" v-model="record.mail_client">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group is-required">
                  <label for="name">Número de teléfono:</label>
                  <input type="text" id="phone_client" class="form-control input-sm" data-toggle="tooltip"
                    title="Número de teléfono" v-model="record.phone_client">
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
            <div class="row" v-for="(product, index) in record.list_products" :key="index">
              <div class="col-md-5">
                <div class="form-group is-required">
                  <select2 :options="sale_setting_products"
                    v-model="product.name"></select2>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group is-required">
                  <input type="text" placeholder="Cantidad de productos" title="Cantidad de productos" v-model="product.quantity" class="form-control input-sm" required>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group is-required">
                  <input type="text" placeholder="Cantidad total" title="Cantidad total" v-model="product.total" class="form-control input-sm" required>
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
              <button type="button" class="btn btn-default btn-sm btn-round btn-modal-close" 
									@click="clearFilters" data-dismiss="modal">
								Cerrar
							</button>
							<button type="button" class="btn btn-warning btn-sm btn-round btn-modal btn-modal-clear" 
									@click="reset()">
								Cancelar
							</button>
							<button type="button" @click="createRecord('sale/register-clients')" 
									class="btn btn-primary btn-sm btn-round btn-modal-save">
								Guardar
							</button>
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
          name_client: '',
          mail_client: ''
        },
        sale_setting_products: [],
        errors: [],
        records: [],
        columns: ['name_client', 'mail_client', 'phone_client', 'id'],
      }
    },
    methods: {
      reset() {
        this.record = {
          id: '',
          list_products: [],
          name_client: '',
          mail_client: '',
          phone_client: ''
        };
      },
      getSaleSettingProducts() {
        const vm = this;
        axios.get('/sale/get-setting-product').then(response => {
          vm.sale_setting_products = response.data;
        });
      },
      addProductFormPayment() {
        this.record.list_products.push({
          name: '',
          quantity: ''
        });
      },
      deleteProductFormPayment(index) {
        this.record.list_products.splice(index, 1);
      },
    },
    created() {
      this.table_options.headings = {
        'name_client': 'Nombre y apellido del solicitante',
        'mail_client': 'Correo del solicitante',
        'phone_client': 'Correo del solicitante',
        'id': 'Acción'
      };
      this.table_options.sortable = ['name_client'];
      this.table_options.filterable = ['name_client'];
      this.table_options.columnsClasses = {
        'name_client': 'col-xs-4',
        'mail_client': 'col-xs-3',
        'phone_client': 'col-xs-3',
        'id': 'col-xs-2'
      };
    },
    mounted() {
      this.getSaleSettingProducts();
    },
  };
</script>
