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
                  <label for="entries_reference" class="control-label">Código de referencia</label>
                  <input type="text" class="form-control" data-toggle="tooltip"
                    title="Formato de códigos" name="formatcode" placeholder="Ej. XXX-00000000-YYYY" />
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
          formatcode: ''
        },
        errors: [],
        records: []
      }
    },
    methods: {
      reset() {
        this.record = {
          formatcode: ''
        };
      },
    },
    created() {

    }
  };
</script>
