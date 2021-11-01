<template>
  <v-client-table :columns="columns" :data="records" :options="table_options">
    <div slot="state" slot-scope="props">
      <span>
        {{ (props.row.state)?props.row.state:'N/A' }}
      </span>
    </div>
    <div slot="id" slot-scope="props" class="text-center">
      <div class="d-inline-flex">
		<a class="btn btn-info btn-xs btn-icon btn-action"
		   href="" title="Ver información del Bien" data-toggle="tooltip" v-has-tooltip
		   @click="addRecord('show_order_detail', 'sale/order/info/' + props.row.id , $event)">
			<i class="fa fa-info-circle"></i>
		</a>
		<button @click="editForm(props.row.id)"
		  class="btn btn-warning btn-xs btn-icon btn-action"
		  title="Modificar registro" data-toggle="tooltip" type="button" v-has-tooltip>
		  <i class="fa fa-edit"></i>
		</button>
        <button @click="approvedOrden(props.index)" 
          class="btn btn-success btn-xs btn-icon btn-action" title="Aceptar Solicitud"
          data-toggle="tooltip" type="button"
          :disabled="props.row.status != 'pending'">
          <i class="fa fa-check"></i>
        </button>
        <button @click="rejectedOrden(props.index)" 
          class="btn btn-danger btn-xs btn-icon btn-action" title="Rechazar Solicitud"
          data-toggle="tooltip" type="button"
          :disabled="props.row.status != 'pending'">
          <i class="fa fa-ban"></i>
        </button>
      </div>

    <div class="modal fade text-left" tabindex="-1" role="dialog" id="show_order_detail">
	  <div class="modal-dialog modal-lg">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">×</span>
			</button>
		    <h6>
			  <i class="icofont icofont-read-book ico-2x"></i>
				Información del Bien Registrado
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
                    <span class="col-md-12" id="description" v-htlm="html">{{ props.row.description }}</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">        
              <div class="col-md-6">
                <div class="form-group">
                  <strong>Productos</strong>
                  <div class="row" v-for="product in props.row.list_products">
                    <div class="col-md-3">
                      <label for="product_name">Nombre:</label>
                      <span class="col-md-12" id="product_name">{{ product.name }}</span>
                    </div>
                    <div class="col-md-2">
                      <label for="product_quantity">Cantidad:</label>
                      <span class="col-md-12" id="product_quantity">{{ product.quantity }}</span>
                    </div>
                    <div class="col-md-2">
                      <label for="product_price">Precio:</label>
                      <span class="col-md-12" id="product_price">{{ product.price_product }}</span>
                    </div>
                    <div class="col-md-3">
                      <label for="product_total">Total:</label>
                      <span class="col-md-12" id="product_total">{{ product.total }}</span>
                    </div>
                  </div>
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
    </div>
  </v-client-table>
</template>

<script>
  export default {
    data() {
      return {
        records: [],
          columns: ['name', 'email', 'phone', 'id']
        }
     },
     created() {
       this.table_options.headings = {
         'name': 'Nombre y apellido',
         'email': 'Correo',
         'phone': 'Teléfono',
         'id': 'Acción'
       };
       this.table_options.sortable = ['name', 'email', 'phone'];
            this.table_options.filterable = ['name', 'email', 'phone'];
            this.table_options.columnsClasses = {
                'name': 'col-md-4',
                'email': 'col-md-3',
                'phone': 'col-md-3',
                'id': 'col-md-2'
            };
        },
        mounted () {
            this.initRecords(this.route_list, '');
        },
        methods: {
            reset() {
                
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
