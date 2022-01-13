<template>
  <div>
  <v-client-table :columns="columns" :data="records" :options="table_options">
    <div slot="status" slot-scope="props">
      <span>
        {{ (props.row.status_text)? props.row.status_text : props.row.status }}
      </span>
    </div>
    <div slot="deadline_date" slot-scope="props">
      <span>
        {{ new Date(props.row.deadline_date).toLocaleString() }}
      </span>
    </div>
    <div slot="id" slot-scope="props" class="text-center">
      <div class="d-inline-flex">
        <button @click="showQuote(props.row.id)" v-if="route_show"
          class="btn btn-info btn-xs btn-icon btn-action btn-tooltip"
          title="Ver registro" data-toggle="tooltip" data-placement="bottom" type="button">
          <i class="fa fa-eye"></i>
        </button>
        <button @click="editForm(props.row.id)"
          class="btn btn-warning btn-xs btn-icon btn-action"
          title="Modificar registro" data-toggle="tooltip" type="button"
          v-show="props.row.status == '0'">
          <i class="fa fa-edit"></i>
        </button>
        <button @click="approvedRequest(props.index, 'sale/quotes/quote-approved')"
          class="btn btn-success btn-xs btn-icon btn-action" title="Aceptar Solicitud"
          data-toggle="tooltip" type="button"
          v-show="props.row.status == '0'">
          <i class="fa fa-check"></i>
        </button>
        <button @click="rejectedRequest(props.index, 'sale/quotes/quote-rejected')"
          class="btn btn-danger btn-xs btn-icon btn-action" title="Rechazar Solicitud"
          data-toggle="tooltip" type="button"
          v-show="props.row.status == '0'">
          <i class="fa fa-ban"></i>
        </button>
        <button @click="deleteRecord(props.row.id, 'sale/quotes/delete')"
          class="btn btn-danger btn-xs btn-icon btn-action"
          title="Eliminar registro" data-toggle="tooltip" type="button"
          v-show="props.row.status == '0'">
          <i class="fa fa-trash-o"></i>
        </button>
      </div>
    </div>
  </v-client-table>
  <div class="modal fade" tabindex="-1" role="dialog" id="show_quote">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
          <h5><i class="icofont icofont-read-book ico-2x"></i> Información Detallada de la Cotización</h5>
        </div>
        <div class="modal-body">
          <h6 class="card-title">I Datos del solicitante:</h6>
          <div class="row">
            <div class="col-md-4">
              <label for="type_person">Tipo de persona:</label>
              <div class="data-value"><span>{{ quote_load.type_person }}</span></div>
            </div>
            <div class="col-md-4">
              <label v-show="quote_load.type_person == ''" for="name">Nombre de la Empresa:</label>
              <label v-show="quote_load.type_person == 'Jurídica'" for="name">Nombre de la Empresa:</label>
              <label v-show="quote_load.type_person == 'Natural'" for="name">Nombre y Apellido:</label>
              <div class="data-value"><span>{{ quote_load.name }}</span></div>
            </div>
            <div class="col-md-4">
              <label v-show="quote_load.type_person == ''" for="id_number">RIF</label>
              <label v-show="quote_load.type_person == 'Jurídica'" for="id_number">RIF</label>
              <label v-show="quote_load.type_person == 'Natural'" for="id_number">Identificación</label>
              <div class="data-value"><span>{{ quote_load.id_number }}</span></div>
            </div>
            <div class="col-md-4">
              <label for="phone">Teléfono de contacto:</label>
              <div class="data-value"><span>{{ quote_load.phone }}</span></div>
            </div>
            <div class="col-md-4">
              <label for="email">Correo Electrónico:</label>
              <div class="data-value"><span>{{ quote_load.email }}</span></div>
            </div>
          </div>
          <h6 class="card-title mt-4">II Descripción de productos:</h6>
          <v-client-table :columns="columns_products" :data="quote_load.sale_quote_product" :options="table_options_products">
            <div slot="sale_warehouse_inventory_product_id" slot-scope="props" class="text-center">
              <span>
                {{ (props.row.sale_warehouse_inventory_product_id)? props.row.sale_warehouse_inventory_product.sale_setting_product.name : props.row.sale_type_good.name }}
              </span>
            </div>
            <div slot="sale_list_subservices_id" slot-scope="props" class="text-center">
              <span>
                {{ (props.row.sale_list_subservices_id)? props.row.sale_list_subservices.name : 'N/A' }}
              </span>
            </div>
            <div slot="product_tax_value" slot-scope="props" class="text-center">
              <span>
                {{ (props.row.total - props.row.total_without_tax).toFixed(2) }}
              </span>
            </div>
          </v-client-table>
          <div class="row">
            <div class="col-md-4 text-left">
              <label class="font-weight-bold">Total sin iva:</label>
              <div class="data-value"><span>{{ quote_load.total_without_tax }}</span></div>
            </div>
            <div class="col-md-4 text-left">
              <label class="font-weight-bold">IVA:</label>
              <div class="data-value"><span>{{ (quote_load.total - quote_load.total_without_tax).toFixed(2) }}</span></div>
            </div>
            <div class="col-md-4 text-left">
              <label class="font-weight-bold">Total a pagar:</label>
              <div class="data-value"><span>{{ quote_load.total }}</span></div>
            </div>
          </div>
          <h6 class="card-title mt-4">III Complementarios:</h6>
          <div class="row">
            <div class="col-md-6" id="SaleHelpPaymentMethod">
              <label>Forma de cobro:</label>
              <div class="data-value"><span>{{ quote_load.sale_form_payment.name_form_payment }}</span></div>
            </div>
            <div class="col-md-6">
              <label>Fecha límite de respuesta:</label>
              <div class="data-value"><span>{{ new Date(quote_load.deadline_date).toLocaleString() }}</span></div>
            </div>
          </div>
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
        records: [],
        columns: ['name', 'id_number', 'type_person', 'total', 'deadline_date', 'status', 'id'],
        quote_load: {
          id: '',
          //Datos del solicitante
          type_person: '',
          name: '',
          id_number: '',
          phone: '',
          email: '',
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
          product_position_value: 0,
          sale_quote_product: [],
          //Complementarios
          sale_form_payment_id: '',
          sale_form_payment: {},
          sale_payment_method: {},
          deadline_date: '',
        },
        columns_products: [
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
        ],
      }
    },
    created() {
      this.table_options.headings = {
        'name': 'Nombre del solicitante',
        'id_number': 'Identificación',
        'type_person': 'Tipo de persona',
        'total_without_tax': 'Monto sin Impuesto',
        'deadline_date': 'Fecha límite de respuesta',
        'total': 'Monto',
        'status': 'Estado de la cotización',
        'id': 'Acción',
      };
      this.table_options.sortable = ['name', 'id_number', 'type_person', 'deadline_date', 'total', 'status'];
      this.table_options.filterable = ['name', 'id_number', 'deadline_date', 'total', 'state'];
      this.table_options.columnsClasses = {
        'name': 'col-md-2',
        'id_number': 'col-md-2',
        'type_person': 'col-md-1',
        'deadline_date': 'col-md-2', 
        'total': 'col-md-2',
        'status': 'col-md-1',
        'id': 'col-md-2',
      };
      this.table_options_products = {};
      this.table_options_products.headings = {
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
      };
      this.table_options_products.sortable = [];
      this.table_options_products.filterable = [];
    },
    mounted () {
      this.initRecords(this.route_list, '');
      this.getQuoteStatus();
    },
    methods: {
      reset() {

      },
      /**
       * Elimina una cotizacion
       *
       * @author Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
      */
      deleteRecord(id, url) {
        const vm = this;
        /** @type {string} URL que atiende la petición de eliminación del registro */
        var url = (url)?url:vm.route_delete;
        url = (!url.includes('http://') || !url.includes('http://'))
          ? `${window.app_url}${(url.startsWith('/'))?'':'/'}${url}` : url;
        bootbox.confirm({
          title: "¿Eliminar registro?",
          message: "¿Esta seguro de eliminar este registro?",
          buttons: {
            cancel: {
              label: '<i class="fa fa-times"></i> Cancelar'
            },
            confirm: {
              label: '<i class="fa fa-check"></i> Confirmar'
            }
          },
          callback: function (result) {
            if (result) {
              /** @type {object} Objeto con los datos del registro a eliminar */
              let recordDelete = JSON.parse(JSON.stringify(vm.records.filter((rec) => {
                return rec.id === id;
              })[0]));
              axios.delete(`${url}${url.endsWith('/')?'':'/'}${recordDelete.id}`).then(response => {
                if (typeof(response.data.error) !== "undefined") {
                  /** Muestra un mensaje de error si sucede algún evento en la eliminación */
                  vm.showMessage('custom', 'Alerta!', 'warning', 'screen-error', response.data.message);
                  return false;
                }
                vm.showMessage('destroy');
                if (typeof(response.data.redirect) !== "undefined") {
                  location.href = response.data.redirect;
                }
              }).catch(error => {
                vm.logs('mixins.js', 498, error, 'deleteRecord');
              });
            }
          }
        });
      },
      /**
       * Rechaza una cotizacion
       *
       * @author Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
      */
      rejectedRequest(index, url) {
        const vm = this;
        var url = (url)? url : vm.route_delete;
        url = (!url.includes('http://') || !url.includes('http://'))
          ? `${window.app_url}${(url.startsWith('/'))?'':'/'}${url}` : url;
        var dialog = bootbox.confirm({
          title: 'Rechazar operación?',
          message: "<p>¿Seguro que desea rechazar esta operación?. Una vez rechazada la operación no se podrán realizar cambios en la misma.<p>",
          size: 'medium',
          buttons: {
            cancel: {
              label: '<i class="fa fa-times"></i> Cancelar'
            },
            confirm: {
              label: '<i class="fa fa-check"></i> Confirmar'
            }
          },
          callback: function (result) {
            if (result) {
              var fields = vm.records[index-1];
              var id = vm.records[index-1].id;
              axios.put(url + '/' + id, fields).then(response => {
                if (typeof(response.data.redirect) !== "undefined") {
                  location.href = response.data.redirect;
                }
              }).catch(error => {
                vm.errors = [];
                if (typeof(error.response) !="undefined") {
                  for (var index in error.response.data.errors) {
                    if (error.response.data.errors[index]) {
                      vm.errors.push(error.response.data.errors[index][0]);
                    }
                  }
                }
              });
            }
          }
        });
      },
      /**
       * Aprueba una cotizacion
       *
       * @author Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
      */
      approvedRequest(index, url)  {
        const vm = this;
        var url = (url)? url : vm.route_delete;
        url = (!url.includes('http://') || !url.includes('http://'))
          ? `${window.app_url}${(url.startsWith('/'))?'':'/'}${url}` : url;
        var dialog = bootbox.confirm({
          title: 'Aprobar operación?',
          message: "<p>¿Seguro que desea aprobar esta operación?. Una vez aprobada la operación no se podrán realizar cambios en la misma.<p>",
          size: 'medium',
          buttons: {
            cancel: {
              label: '<i class="fa fa-times"></i> Cancelar'
            },
            confirm: {
              label: '<i class="fa fa-check"></i> Confirmar'
            }
          },
          callback: function (result) {
            if (result) {
              var fields = vm.records[index-1];
              var id = vm.records[index-1].id;
              axios.put(url + '/' + id, fields).then(response => {
                if (typeof(response.data.redirect) !== "undefined") {
                  location.href = response.data.redirect;
                }
              }).catch(error => {
                vm.errors = [];
                if (typeof(error.response) !="undefined") {
                  for (var index in error.response.data.errors) {
                    if (error.response.data.errors[index]) {
                      vm.errors.push(error.response.data.errors[index][0]);
                    }
                  }
                }
              });
            }
          }
        });
      },
      /**
       * Muestra una cotizacion
       *
       * @author Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
      */
      showQuote(id) {
        const vm = this;
        if (id) {
          var url = (url)? url : vm.route_show;
          url = (!url.includes('http://') || !url.includes('http://'))
            ? `${window.app_url}${(url.startsWith('/'))?'':'/'}${url}` : url;
          url = url.indexOf("{id}") >= 0? url.replace("{id}", id) : url + '/' + id;
          axios.get(url).then(response => {
            vm.quote_load = response.data.record;
            $('#show_quote').modal('show');
          });
        }
      },
    }
  };
</script>
