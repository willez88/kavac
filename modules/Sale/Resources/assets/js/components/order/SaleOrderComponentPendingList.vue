<template>
  <v-client-table :columns="columns" :data="records" :options="table_options">
    <div slot="state" slot-scope="props">
      <span>
        {{ (props.row.state)?props.row.state:'N/A' }}
      </span>
    </div>
    <div slot="id" slot-scope="props" class="text-center">
      <div class="d-inline-flex">
        <button @click="showOrderDetailt(props.row.id)" v-if="route_show"
          class="btn btn-info btn-xs btn-icon btn-action btn-tooltip"
          title="Ver registro" data-toggle="tooltip" data-placement="bottom" type="button">
          <i class="fa fa-eye"></i>
        </button>
		<button @click="editForm(props.row.id)"
		  class="btn btn-warning btn-xs btn-icon btn-action"
		  title="Modificar registro" data-toggle="tooltip" data-placement="bottom" type="button">
		  <i class="fa fa-edit"></i>
		</button>
        <button @click="approvedOrden(props.index)" 
          class="btn btn-success btn-xs btn-icon btn-action" title="Aceptar Solicitud"
          data-toggle="tooltip" type="button"
          :disabled="props.row.status != 'pending'">
          <i class="fa fa-check"></i>
        </button>
        <button @click="rejectedOrden(props.index)" 
          class="btn btn-warning btn-xs btn-icon btn-action" title="Rechazar Solicitud"
          data-toggle="tooltip" type="button"
          :disabled="props.row.status != 'pending'">
          <i class="fa fa-ban"></i>
        </button>
        <button @click="deleteRecord(props.row.id)"
          class="btn btn-danger btn-xs btn-icon btn-action"
          title="Eliminar registro" data-toggle="tooltip"
          type="button">
          <i class="fa fa-trash-o"></i>
        </button>
      </div>
      <div class="modal fade text-left" tabindex="-1" role="dialog" id="show_order_detail_pending">
	    <div class="modal-dialog modal-lg">
	      <div class="modal-content">
		    <div class="modal-header">
		      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			    <span aria-hidden="true">×</span>
			  </button>
		      <h6>
			    <i class="icofont icofont-read-book ico-2x"></i> Información del pedido
		      </h6>
		    </div>
            <div class="modal-body">
              <div class="row">        
                <div class="col-md-6">
                  <div class="form-group">
                    <strong>Nombre</strong>
                    <div class="row" style="margin: 1px 0">
                      <span class="col-md-12" id="name">{{ props.row.name }}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <strong>Email</strong>
                    <div class="row" style="margin: 1px 0">
                      <span class="col-md-12" id="email">{{ props.row.email }}</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">        
                <div class="col-md-6">
                  <div class="form-group">
                    <strong>Telefono</strong>
                    <div class="row" style="margin: 1px 0">
                      <span class="col-md-12" id="phone">{{ props.row.phone }}</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <strong>Descripción</strong>
                    <div class="row" style="margin: 1px 0">
                      <span class="col-md-12" id="description" v-html="props.row.description"></span>
                    </div>
                  </div>
                </div>
              </div>
              <h6 class="card-title mt-4">Descripción de productos:</h6>
              <v-client-table :columns="columns_products" :data="order_load.list_products" :options="table_options_products">
                <div slot="tipo_producto" slot-scope="props" class="text-center">
                  <span>
                   {{ props.row.tipo_producto }}
                  </span>
                </div>
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
          'tipo_producto',
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
        'products': 'col-md-2',
        'id': 'col-md-2'
      };
      this.table_options_products = {};
      this.table_options_products.headings = {
        'tipo_producto': 'Tipo de producto',
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
      reset() { },
      showOrderDetailt(id) {
        const vm = this;
        if (id) {
          var url = (url)? url : vm.route_show;
          url = (!url.includes('http://') || !url.includes('http://'))
            ? `${window.app_url}${(url.startsWith('/'))?'':'/'}${url}` : url;
          url = url.indexOf("{id}") >= 0? url.replace("{id}", id) : url + '/' + id;
          axios.get(url).then(response => {
          vm.order_load = response.data.record;
          $('#show_order_detail_pending').modal('show');
        });
      }
    },
    rejectedOrden(index)
    {
      const vm = this;
      var dialog = bootbox.confirm({
        title: 'Rechazar orden solicitada?',
        message: "<p>¿Seguro que desea rechazar esta solicitud?. Una vez rechazada la operación no se podrán realizar cambios en la misma.<p>",
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
            console.log(id);
            axios.put('/'+vm.route_update+'/rejected/'+id, fields).then(response => {
              if (typeof(response.data.redirect) !== "undefined")
                location.href = response.data.redirect;
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
      approvedOrden(index)
      {
        const vm = this;
        var dialog = bootbox.confirm({
          title: 'Aprobar orden solicitada?',
          message: "<p>¿Seguro que desea aprobar esta solicitud?. Una vez aprobada la operación no se podrán realizar cambios en la misma.<p>",
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
               axios.put('/'+vm.route_update+'/approved/'+id, fields).then(response => {
                 if (typeof(response.data.redirect) !== "undefined")
                   location.href = response.data.redirect;
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
      }
    };
</script>
