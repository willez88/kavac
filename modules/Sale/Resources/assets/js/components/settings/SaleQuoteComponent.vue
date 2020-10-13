<template>
  <div class="text-center">
    <a class="btn-simplex btn-simplex-md btn-simplex-primary" href=""
      title="Solicitar cotización" data-toggle="tooltip"
      @click="addRecord('add_sale_quote_method', 'sale/discount-method', $event);">
      <i class="icofont icofont-cart ico-3x"></i>
      <span>Cotización</span>
    </a>
    <div class="modal fade text-left" tabindex="-1" role="dialog" id="add_sale_quote_method">
      <div class="modal-dialog vue-crud" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
            <h6><i class="icofont icofont-business-man ico-3x"></i>Cotización</h6>
          </div>
          <div class="modal-body">
            <div class="alert alert-danger" v-if="errors.length > 0">
              <ul>
                <li v-for="error in errors">{{ error }}</li>
              </ul>
            </div>
            <h6 class="card-title">Datos del solicitante:</h6>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group is-required">
                  <label for="name">Nombre de la Empresa:</label>
                  <input type="text" id="name_enterprise" class="form-control input-sm" data-toggle="tooltip"
                    title="Nombre de la Empresa" v-model="record.name_enterprise">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group is-required">
                  <label for="name">Nombre y Apellido:</label>
                  <input type="text" id="name_applicant" class="form-control input-sm" data-toggle="tooltip"
                    title="Nombre y Apellido" v-model="record.name_applicant">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group is-required">
                  <label for="email_applicant">Correo electrónico:</label>
                  <input type="text" id="email_client" class="form-control input-sm" data-toggle="tooltip"
                  title="Correo electrónico" v-model="record.email_applicant">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <h6 class="card-title">Números Telefónicos <i class="fa fa-plus-circle cursor-pointer" @click="addPhone"></i></h6>
                <div class="row" v-for="(phone, index) in record.phones">
                  <div class="col-3">
                    <div class="form-group is-required">
                      <select data-toggle="tooltip" v-model="phone.type" class="form-control" title="Seleccione el tipo de número telefónico">
                        <option value="">Seleccione...</option>
                        <option value="M">Móvil</option>
                        <option value="T">Teléfono</option>
                        <option value="F">Fax</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-2">
                    <div class="form-group is-required">
                      <input type="text" placeholder="Cod. Area" data-toggle="tooltip"
                        title="Indique el código de área" v-model="phone.area_code"
                        class="form-control input-sm">
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="form-group is-required">
                      <input type="text" placeholder="Número" data-toggle="tooltip" title="Indique el número telefónico" v-model="phone.number_phones" class="form-control input-sm">
                    </div>
                  </div>
                  <div class="col-1">
                    <div class="form-group">
                      <button class="btn btn-sm btn-danger btn-action" type="button" @click="removeRow(index, record.phones)"
                        title="Eliminar este dato" data-toggle="tooltip">
                          <i class="fa fa-minus-circle"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group is-required">
                  <label for="address">Dirección:</label>
                    <input type="text" id="address_applicant" placeholder="Descripción"
                      class="form-control input-sm" v-model="record.address_applicant" data-toggle="tooltip"
                      title="Indique una breve dirección del nuevo almacén (requerido)">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 mt-3">
                <h6 class="card-title">Descripción de productos:</h6>
              </div>
              <div class="col-md-4">
		<div class="form-group is-required">
		  <label>Unidad de Medida:</label>
		  <select2 :options="measurement_units_product" v-model="record.measurement_units"></select2>
		</div>
	      </div>
              <div class="col-md-3" id="quantity">
		<div class="form-group is-required">
		  <label>Cantidad:</label>
		  <input type="number" min="1" placeholder="Cantidad del Producto" data-toggle="tooltip" 			   class="form-control input-sm" v-model="record.quantity_product">
                </div>
              </div>
              <div class="col-md-3" id="product_type">
		<div class="form-group is-required">
                  <label>Típo de producto</label>
                  <select2 :options="sale_setting_product_type"
                    v-model="record.product_type_ids" id="product_type_id">
                  </select2>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 mt-3">
                <h6 class="card-title">Complementarios:</h6>
              </div>
              <div class="col-md-4">
		<div class="form-group is-required">
		  <label>Modalidad de pago:</label>
		  <select2 :options="payment_type_products" v-model="record.payment_type_product"></select2>
		</div>
	      </div>
              <div class="col-md-3" id="quantity">
		<div class="form-group is-required">
		  <label>Fecha límite de respuesta:</label>
                  <input type="date" v-model="record.reply_deadline_product" class="form-control input-sm"
                    data-toggle="tooltip"
                    title="Indique la fecha límite de respuesta">
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <div class="form-group">
              <modal-form-buttons :saveRoute="'sale/register-quote'"></modal-form-buttons>
            </div>
          </div>
          <div class="modal-body modal-table">
            <v-client-table :columns="columns" :data="records" :options="table_options">
              <div slot="id" slot-scope="props" class="text-center">
                <button @click="initUpdate(props.index, $event)"
                  class="btn btn-warning btn-xs btn-icon btn-action"
                  title="Modificar registro" data-toggle="tooltip" type="button">
                    <i class="fa fa-edit"></i>
                </button>
                <button @click="deleteRecord(props.index, 'register-quote')"
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
          company_name: '',
          name: '',
          unit_product: '',
          product_type_id: '',
          payment_type_product: '',
          reply_deadline_product: '',
          quantity_product: '',
          address: '',
          lastname: '',
          email: '',
          phones: []
        },
        errors: [],
        records: [],
        columns: ['company_name', 'lastname', 'email', 'id'],
        measurement_units_product: [],
        product_type_ids: [],
        payment_type_products: ['prueba'],
      }
    },
    methods: {
      reset() {
        this.record = {
          company_name: '',
          name: '',
          unit_product: '',
          product_type_id: '',
          payment_type_product: '',
          reply_deadline_product: '',
          quantity_product: '',
          address: '',
          lastname: '',
          email: '',
          phones: []
        };
      },
      getMeasurementUnits() {
        const vm = this;
        vm.measurement_units_product = [];

        axios.get('/warehouse/get-measurement-units').then(response => {
  	  vm.measurement_units_product = response.data;
        });
      },
    },
    created() {
      const vm = this;
      vm.record.phones = [];

      vm.table_options.headings = {
        'company_name': 'Nombre de la Empresa',
        'lastname': 'Nombre y Apellido',
        'email': 'Correo Electrónico',
        'product_type_id': 'Tipo de producto',
      };
      vm.table_options.columnsClasses = {
        'company_name': 'col-xs-3',
        'lastname': 'col-xs-3',
        'email': 'col-xs-4',
        'id': 'col-xs-2'
      };
      vm.getSaleSettingProductType();
    },
    mounted() {
      const vm = this;
      vm.getMeasurementUnits();
    },
  };
</script>
