<template>
  <v-client-table :columns="columns" :data="records" :options="table_options">
    <div slot="state" slot-scope="props">
      <span>
        {{ (props.row.state) ? props.row.state : 'N/A' }}
      </span>
    </div>
    <div slot="id" slot-scope="props" class="text-center">
      <div class="d-inline-flex">
		<button @click="showOrderDetailt(props.row.id)" v-if="route_show"
          class="btn btn-info btn-xs btn-icon btn-action btn-tooltip"
          title="Ver registro" data-toggle="tooltip" data-placement="bottom" type="button">
          <i class="fa fa-eye"></i>
        </button>
      </div>
      <div class="modal fade text-left" tabindex="-1" role="dialog" id="show_order_detail_rejected">
	    <div class="modal-dialog modal-lg">
	      <div class="modal-content">
		    <div class="modal-header">
		      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			    <span aria-hidden="true">×</span>
			  </button>
		      <h6>
			    <i class="icofont icofont-read-book ico-2x"></i> Información del servicio rechazado
		      </h6>
		    </div>
            <div class="modal-body">
              <div class="row">        
                <div class="col-md-6">
                  <div class="form-group">
                    <strong>Tipo de persona</strong>
                    <div class="row" style="margin: 1px 0">
                      <span class="col-md-12" id="type_person">{{ order_load.type_person }}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <strong v-show="order_load.type_person == ''" for="id_number">RIF</strong>
                    <strong v-show="order_load.type_person == 'Jurídica'" for="id_number">RIF</strong>
                    <strong v-show="order_load.type_person == 'Natural'" for="id_number">Identificación</strong>
                    <div class="row" style="margin: 1px 0">
                      <span class="col-md-12" id="id_number">{{ order_load.id_number }}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <strong v-show="order_load.type_person == ''" for="name">Nombre de la Empresa:</strong>
                    <strong v-show="order_load.type_person == 'Jurídica'" for="name">Nombre de la Empresa:</strong>
                    <strong v-show="order_load.type_person == 'Natural'" for="name">Nombre y Apellido:</strong>
                    <div class="row" style="margin: 1px 0">
                      <span class="col-md-12" id="name">{{ order_load.name }}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <strong>Email</strong>
                    <div class="row" style="margin: 1px 0">
                      <span class="col-md-12" id="email">{{ order_load.email }}</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <strong>Telefono</strong>
                    <div class="row" style="margin: 1px 0">
                      <span class="col-md-12" id="phone">{{ order_load.phone }}</span>
                    </div>
                  </div>
                </div>
              </div>
              <h6 class="card-title mt-4">Descripción de productos:</h6>
              <v-client-table :columns="columns_products" :data="order_load.list_products" :options="table_options_products">
                <div slot="name" slot-scope="props" class="text-center">
                  <span>
                   {{ props.row.name }}
                  </span>
                </div>
                <div slot="quantity" slot-scope="props" class="text-center">
                  <span>
                   {{ props.row.quantity }}
                  </span>
                </div>
                <div slot="price_product" slot-scope="props" class="text-center">
                  <span>
                   {{ props.row.price_product }}
                  </span>
                </div>
                <div slot="total" slot-scope="props" class="text-center">
                  <span>
                   {{ props.row.total }}
                  </span>
                </div>
                <div slot="iva" slot-scope="props" class="text-center">
                  <span>
                   {{ props.row.iva }}
                  </span>
                </div>
                <div slot="moneda" slot-scope="props" class="text-center">
                  <span>
                   {{ props.row.moneda }}
                  </span>
                </div>
              </v-client-table>
              <div class="row">
                <div class="col-md-4 text-left">
                  <label class="font-weight-bold">Total sin iva:</label>
                  <div class="data-value"><span>{{ order_load.total_without_tax }}</span></div>
                </div>
                <div class="col-md-4 text-left">
                  <label class="font-weight-bold">IVA:</label>
                  <div class="data-value"><span>{{ (order_load.total - order_load.total_without_tax).toFixed(2) }}</span></div>
                </div>
                <div class="col-md-4 text-left">
                  <label class="font-weight-bold">Total a pagar:</label>
                  <div class="data-value"><span>{{ order_load.total }}</span></div>
                </div>
              </div>
	        </div>
          </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default btn-sm btn-round btn-modal-close"
	          data-dismiss="modal">
	          Cerrar
	        </button>
		  </div>
		</div>
      </div>
    </div>
  </v-client-table>
</template>

<script>
    export default {
        data() {
          return {
            records: [],
            order_load: {},
            columns: ['name', 'id_number', 'email', 'phone', 'total', 'id'],
            columns_products: [
              'name',
              'moneda',
              'quantity',
              'price_product',
              'iva',
              'total',
            ],
          }
        },
        created() {
          this.table_options.headings = {
            'name': 'Nombre y apellido',
            'id_number': 'Identificación',
            'email': 'Correo',
            'phone': 'Teléfono',
            'total': 'Monto',
            'id': 'Acción'
          };
          this.table_options.sortable = ['name', 'id_number', 'email', 'phone', 'total'];
          this.table_options.filterable = ['name', 'id_number', 'email', 'phone', 'total'];
          this.table_options.columnsClasses = {
            'name': 'col-md-2',
            'id_number': 'col-md-2',
            'email': 'col-md-2',
            'phone': 'col-md-2',
            'total': 'col-md-2',
            'id': 'col-md-2'
          };
          this.table_options_products = {};
          this.table_options_products.headings = {
            'name': 'Nombre',
            'moneda': 'Moneda',
            'quantity': 'Cantidad',
            'price_product': 'Precio',
            'iva': 'Iva',
            'total': 'Total',
          };
          this.table_options_products.sortable = [];
          this.table_options_products.filterable = [];
        },
        mounted () {
          this.initRecords(this.route_list, '');
        },
        methods: {
          reset() {},
          showOrderDetailt(id) {
            const vm = this;
            if (id) {
              var url = (url)? url : vm.route_show;
              url = (!url.includes('http://') || !url.includes('http://'))
                ? `${window.app_url}${(url.startsWith('/'))?'':'/'}${url}` : url;
              url = url.indexOf("{id}") >= 0? url.replace("{id}", id) : url + '/' + id;
              axios.get(url).then(response => {
                vm.order_load = response.data.record;
                $('#show_order_detail_rejected').modal('show');
              });
            }
          },
        }
    };
</script>
