<template>
    <div class="text-center">
        <a class="btn-simplex btn-simplex-md btn-simplex-primary" href="" title="Registrar Pedido" data-toggle="tooltip" 
           @click="addRecord('add_sale_order', 'sale/register-quote', $event);">
            <i class="icofont icofont-archive ico-3x"></i>
            <span>Registrar Cotización</span>
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
                                <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
                            </ul>
                        </div>
                        <h6 class="card-title">Datos del solicitante:</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group is-required">
                                    <label for="type_person">Tipo de persona:</label>
                                    <select2 :options="types_person" id='type_person_juridica' 
                                             v-model="record.type_person_juridica"></select2>
                                </div>
                            </div>
                            <div v-show="record.type_person_juridica == 'Jurídica'" class="col-md-4">
                                <div class="form-group is-required">
                                    <label for="rif">RIF</label>
                                    <input type="text" id="rif" class="form-control input-sm" data-toggle="tooltip" 
                                           title="Indique el rif del cliente" v-model="record.rif">
                                </div>
                            </div>
                            <div v-show="record.type_person_juridica == 'Jurídica'" class="col-md-4">
                                <div class="form-group is-required">
                                    <label for="business_name">Razón social:</label>
                                    <input type="text" id="name" class="form-control input-sm" data-toggle="tooltip" 
                                           title="Razón social" v-model="record.business_name">
                                </div>
                            </div>
                            <div v-show="record.type_person_juridica == 'Jurídica'" class="col-md-4">
                                <div class="form-group is-required">
                                    <label for="representative_name">Nombres y apellidos del representante legal:</label>
                                    <input type="text" id="name" class="form-control input-sm" data-toggle="tooltip" 
                                           title="Nombres y Apellidos del representante legal" 
                                           v-model="record.representative_name">
                                </div>
                            </div>
                            <div v-show="record.type_person_juridica == 'Natural'" class="col-md-4">
                                <label for="name">Tipo de identificación:</label>
                                <div class="d-flex">
                                    <div class="col-md-3 form-group is-required">
                                        <select2 data-toggle="tooltip" title="Tipo de identificación" 
                                                 :options="id_types" v-model="record.id_type"></select2>
                                    </div>
                                    <div class="col-md-9 form-group is-required">
                                        <input type="text" id="id_type" class="form-control input-sm" data-toggle="tooltip" 
                                               title="Introduza la identificación" v-model="record.id_number">
                                    </div>
                                </div>
                            </div>
                            <div v-show="record.type_person_juridica == 'Natural'" class="col-md-4">
                                <div class="form-group is-required">
                                    <label for="name">Nombre y apellido:</label>
                                    <input type="text" id="name" class="form-control input-sm" data-toggle="tooltip" 
                                           title="Nombre y apellido" v-model="record.name">
                                </div>
                            </div>
                        </div>
                        <h6 class="card-title">Complementarios:</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group is-required">
                                    <label>Modalidad de pago:</label>
                                    <select2 :options="payment_type_products" v-model="record.payment_type_product"></select2>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group is-required">
                                    <label>Fecha límite de respuesta:</label>
                                    <input type="date" v-model="record.reply_deadline_product" class="form-control input-sm" 
                                           data-toggle="tooltip" title="Indique la fecha límite de respuesta">
                                </div>
                            </div>
                        </div>
                        <h6 class="card-title">Descripción de productos:</h6>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group is-required">
                                    <label for="name">Registro de Productos:</label>
                                </div>
                                <h6 class="card-title">
                                    Agregar nuevo producto 
                                    <i class="fa fa-plus-circle cursor-pointer" @click="addProductFormQuote"></i>
                                </h6>
                            </div>
                        </div>
                        <div class="row" v-for="(product, index) in record.list_products" :key="index">
                            <div class="col-md-4">
                                <div class="form-group is-required">
                                    <label>Producto</label>
                                    <select2 :options="sale_setting_products" v-model="product.name" @input="getPriceProduct" 
                                             class="list-product" :data-index="index"></select2>
                                    <input type="hidden" v-model="product.id">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group is-required">
                                    <label>Estado:</label>
                                    <input type="text" disabled placeholder="Estado del producto" title="" 
                                           v-model="product.status" class="form-control input-sm" required :data-index="index">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group is-required">
                                    <label>Cantidad de productos:</label>
                                    <input type="text" placeholder="Cantidad de productos" title="Cantidad de productos" 
                                           v-model="product.quantity" class="form-control input-sm" required 
                                           :data-index="index" @input="getTotalProduct">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group is-required">
                                    <label>Precio unitario:</label>
                                    <input type="text" disabled placeholder="Precio unitario" title="Precio unitario" 
                                           v-model="product.price_product" class="form-control input-sm" required 
                                           :data-index="index">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group is-required">
                                    <label>Monto total del pedido:</label>
                                    <input type="text" disabled placeholder="Cantidad total" title="Cantidad total" 
                                           v-model="product.total" class="form-control input-sm" required :data-index="index">
                                </div>
                            </div>
                            <div class="col-1">
                                <div class="form-group">
                                    <button class="btn btn-sm btn-danger btn-action" type="button" 
                                            @click="deleteProductFormPayment" title="Eliminar este atributo" 
                                            data-toggle="tooltip">
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
							<button type="button" @click="createRecord('sale/register-order')" 
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
                                        title="Eliminar registro" data-toggle="tooltip" type="button">
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
          email: '',
          description: '',
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
          phone: '',
          description: ''
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
			axios.get('/sale/get-goods-attributes' + '/' + $element.value).then(function (response) {
			  vm.record.list_products[$($element).data('index')].unit_price = response.data.unit_price;
		    });
			axios.get('/sale/get-taxes' + '/' + $element.value).then(function (response) {
			  vm.record.list_products[$($element).data('index')].percentage = response.data.record.percentage;
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
