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
		   href="" title="Ver información del servicio" data-toggle="tooltip" v-has-tooltip
		   @click="addRecord('show_order_detail_approved', 'sale/order/info/' + props.row.id , $event)">
			<i class="fa fa-info-circle"></i>
		</a>
      </div>
      <div class="modal fade text-left" tabindex="-1" role="dialog" id="show_order_detail_approved">
	    <div class="modal-dialog modal-lg">
	      <div class="modal-content">
		    <div class="modal-header">
		      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			    <span aria-hidden="true">×</span>
			  </button>
		      <h6>
			    <i class="icofont icofont-read-book ico-2x"></i> Información del servicio aprovado
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
              <div class="row">        
                <div class="col-md-12">
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
                'name': 'col-md-3',
                'email': 'col-md-3',
                'phone': 'col-md-4',
                'id': 'col-md-2'
            };
        },
        mounted () {
            this.initRecords(this.route_list, '');
        },
        methods: {
            reset() {
                
            },
        }
    };
</script>
