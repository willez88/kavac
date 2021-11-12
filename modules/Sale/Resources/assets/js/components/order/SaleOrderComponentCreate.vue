<template>
  <section id="SaleOrderCreateForm">
    <div class="card-body">
      <div class="alert alert-danger" v-if="errors.length > 0">
        <ul><li v-for="error in errors">{{ error }}</li></ul>
      </div>
      <h6 class="card-title">Datos del solicitante:</h6>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group is-required">
            <label for="name">Nombre y apellido del solicitante:</label>
            <input type="text" id="name" class="form-control input-sm" data-toggle="tooltip" required
              title="Nombre y apellido del solicitante" v-model="record.name">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group is-required">
            <label for="email">Correo electrónico del solicitante:</label>
            <input type="text" id="email" class="form-control input-sm" data-toggle="tooltip" required
              title="Correo electrónico del solicitante" v-model="record.email">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group is-required">
            <label for="phone">Número de teléfono:</label>
            <input type="text" id="phone" class="form-control input-sm" data-toggle="tooltip" required
              title="Número de teléfono" v-model="record.phone" placeholder="00-000-0000000">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group is-required">
            <label>Descripción de la actividad económica</label>
            <ckeditor :editor="ckeditor.editor" id="direction" data-toggle="tooltip"
              title="Indique la descripción de la actividad económica" :config="ckeditor.editorConfig"
              class="form-control" name="description" tag-name="textarea" rows="3"
              v-model="record.description"></ckeditor>
          </div>
        </div>
      </div>
      <h6 class="card-title">Datos del pedido:</h6>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group is-required">
            <label for="name">Registro de Productos:</label>
          </div>
          <h6 class="card-title cursor-pointer" @click="addProductFormPayment()">
            Agregar nuevo producto <i class="fa fa-plus-circle"></i>
          </h6>
        </div>
      </div>
      <div v-for="(product, index) in record.list_products" :key="index">
        <div class="row">
          <div class="col-md-5">
            <div class="form-group is-required">
              <label>Producto</label>
              <select2 :options="sale_setting_products"
                v-model="product.name" @input="getPriceProduct" class="list-product" :data-index="index"></select2>
              <input type="hidden" v-model="product.id">
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
          <button type="button" @click="createOrder('sale/order')"
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
          list_products: [],
          name: '',
          email: '',
          phone: '',
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
			axios.get('/sale/get-price-product' + '/' + $element.value).then(function (response) {
			  vm.record.list_products[$($element).data('index')].price_product = response.data.record.price;
		    });
	      }
        });
      },
      getSaleSettingProducts() {
        const vm = this;
        axios.get('/sale/get-setting-product').then(response => {
          vm.sale_setting_products = response.data || [];
        });
      },
      addProductFormPayment() {
        const vm = this;

        vm.record.list_products.push({
          id: '',
          name: '',
          quantity: 0,
          price_product: 0,
          total: 0
        });
      },
      deleteProductFormPayment(index) {
        this.record.list_products.splice(index, 1);
      },
      createOrder(url) {
		const vm = this;
		var complete = true;

        if (!vm.record.list_products.length){
          bootbox.alert("Debe agregar almenos un producto al registro de pedidos");
		  return false;
		};

        if (complete == true) {
          if (vm.record.id) {
            vm.updateRecord(url)    
          } else{
       	   vm.createRecord(url)
          }
        }
      },
      /**
       * @param [Integer] $id Identificador único del registro a editar
       */
	  loadForm(id) {
		const vm = this;
        axios.get('/sale/order/info/' + id).then(response => {
	      if (typeof(response.data.records != "undefined")){
	        vm.record = response.data.records;
	      }
        });
      }
    },
	props: {
	  orderid: Number,
    },
    created() {
      this.record.list_products = [];
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
      if (this.orderid) {
		this.loadForm(this.orderid);
	  }
    },
  };
</script>






