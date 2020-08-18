<template>
  <div class="text-center">
    <a class="btn-simplex btn-simplex-md btn-simplex-primary" href=""
      title="Formato de códigos" data-toggle="tooltip"
      @click="addRecord('add_sale_formatcode', 'register-formatcode', $event);">
      <i class="icofont icofont-bar-code ico-3x"></i>
      <span>Formato de códigos</span>
    </a>
    <div class="modal fade text-left" tabindex="-1" role="dialog" id="add_sale_formatcode">
      <div class="modal-dialog vue-crud" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
            <h6><i class="icofont icofont-bar-code ico-3x"></i>Formato de códigos</h6>
          </div>
          <div class="modal-body">
            <div class="alert alert-danger" v-if="errors.length > 0">
              <ul>
                <li v-for="error in errors">{{ error }}</li>
              </ul>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group is-required">
                  <label for="entries_reference" class="control-label">Tipo de formato</label>
                  <select2 :options="types_formatcode" id='type_formatcode' v-model="record.type_formatcode"></select2>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group is-required">
                  <label for="entries_reference" class="control-label">Código de referencia</label>
                  <input type="text" class="form-control" data-toggle="tooltip"
                    title="Formato de códigos" id="formatcode" placeholder="Ej. XXX-00000000-YYYY"
                    maxlength="17" v-model="record.formatcode" />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group is-required">
                  <span class="form-text">
                    <strong>Formato:</strong>
                    prefijo-digitos-año
                    <ul>
                      <li>prefijo (requerido): 1 a 3 carácteres</li>
                      <li>digitos (requerido): 4 carácteres (mínimo), 8 carácteres (máximo)</li>
                      <li>año (requerido): 2 o 4 caracteres (YY o YYYY)</li>
                    </ul>
                    <strong>Longitud total máxima:</strong> 17 carácteres<br>
                    <strong>Ej.</strong> XXX-00000000-YYYY
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <div class="form-group">
              <modal-form-buttons :saveRoute="'sale/register-formatcode'"></modal-form-buttons>
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
                <button @click="deleteRecord(props.index, 'register-formatcode')"
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
          formatcode: '',
          type_formatcode: ''
        },
        errors: [],
        records: [],
        columns: ['formatcode', 'type_formatcode', 'id'],
        types_formatcode: [
          'Seleccione...',
          'Proveedores',
          'Clientes',
          'Facturas',
          'Cotizaciones',
          'Pedidos',
        ],
      }
    },
    methods: {
      reset() {
        this.record = {
          id: '',
          formatcode: '',
          type_formatcode: ''
        };
      },
    },
    created() {
      this.table_options.headings = {
        'formatcode': 'Código de referencia',
        'type_formatcode': 'Tipo de formato',
        'id': 'Acción'
      };
      this.table_options.sortable = ['formatcode'];
      this.table_options.filterable = ['formatcode'];
      this.table_options.columnsClasses = {
        'formatcode': 'col-xs-4',
        'type_formatcode': 'col-xs-4',
        'id': 'col-xs-4'
      };
    }
  };
</script>
