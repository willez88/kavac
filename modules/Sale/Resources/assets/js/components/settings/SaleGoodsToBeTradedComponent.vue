<template>
  <div class="text-center">
    <a class="btn-simplex btn-simplex-md btn-simplex-primary" href="" title="Registros de Bienes a Comercializar" data-toggle="tooltip" @click="addRecord('add_good_to_be_traded', 'sale/good_to_be_traded', $event)">
      <i class="icofont icofont-read-book ico-3x"></i>
      <span>Bienes a Comercializar</span>
    </a>
    <div class="modal fade text-left" tabindex="-1" role="dialog" id="add_good_to_be_traded">
      <div class="modal-dialog vue-crud" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
            <h6><i class="icofont icofont-read-book ico-3x"></i> Bienes a Comercializar</h6>
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
                  <label for="name">Nombre:</label>
                  <input type="text" id="name" placeholder="Nombre" class="form-control input-sm" v-model="record.name" data-toggle="tooltip" title="Indique el nombre (requerido)">
                  <input type="hidden" name="id" id="id" v-model="record.id">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group is-required">
                  <label for="name">Descripción:</label>
                  <input type="text" id="description" placeholder="Descripción" class="form-control input-sm" v-model="record.description" data-toggle="tooltip" title="descripción (requerido)">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group is-required">
                  <label for="name">Precio Unitario:</label>
                  <input type="text" id="name" placeholder="Precio Unitario" class="form-control input-sm" v-model="record.name" data-toggle="tooltip" title="Indique el Precio Unitario (requerido)">
                  <input type="hidden" name="id" id="id" v-model="record.id">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group is-required">
                  <label for="name">Moneda:</label>
                  <input type="text" id="description" placeholder="Moneda" class="form-control input-sm" v-model="record.description" data-toggle="tooltip" title="Moneda (requerido)">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-1">
                <div class="form-group">
                    <a  data-toggle="tooltip" title="Impuesto al valor agregado">
                      <label for="" class="control-label">IVA</label>
                      <div class="col-12">
                        <div class="bootstrap-switch-mini">
                          <input type="checkbox" class="form-control bootstrap-switch" id="define_attributes"
                          name="define_attributes"
                          data-on-label="Si" data-off-label="No" value="true"
                          v-model="record.define_attributes">
                        </div>
                      </div>
                    </a>
                </div>
              </div>
              <div v-show="this.record.define_attributes">
                <div class="col-md-12">
                    <label for="name">Impuesto al valor agregado:</label>
                    <input type="text" id="iva" placeholder="iva" class="form-control input-sm" v-model="record.iva" data-toggle="tooltip" title="iva (Impuesto al valor agregado)">
                </div>
              </div>
              <div class="col-md-4">
                  <div class="form-group is-required">
                      <label>Unidad de medida:</label>
                      <select2 :options="measurement_units" v-model="record.measurement_unit_id"></select2>
                  </div>
              </div>
              <div class="col-md-4">
                <div class="form-group is-required">
                  <label>Departamento:</label>
                  <select2 :options="departments" v-model="record.department_id"
                       id="department"></select2>
                </div>
              </div>

            </div>

          </div>
          <div class="modal-footer">
            <div class="form-group">
              <modal-form-buttons :saveRoute="'sale/good_to_be_traded'"></modal-form-buttons>
            </div>
          </div>
          <div class="modal-body modal-table">
            <v-client-table :columns="columns" :data="records" :options="table_options">
              <div slot="id" slot-scope="props" class="text-center">
                <button @click="initUpdate(props.row.id, $event)" class="btn btn-warning btn-xs btn-icon btn-action" title="Modificar" data-toggle="tooltip" type="button">
                  <i class="fa fa-edit"></i>
                </button>
                <button @click="deleteRecord(props.row.id, 'sale/good_to_be_traded')" class="btn btn-danger btn-xs btn-icon btn-action" title="Eliminar" data-toggle="tooltip" type="button">
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
/**
 * 
 *
 * 
 */
export default {
  data() {
    return {
      record: {
        id: '',
        name: ''
      },
      errors: [],
      records: [],
      columns: ['name', 'id'],
    }
  },
  methods: {
    reset() {
      this.record = {
        id: '',
        name: ''
      };
    },
  },
  created() {
    this.table_options.headings = {
      'name': 'Nombre',
      'id': 'Acción'
    };
    this.table_options.sortable = ['name'];
    this.table_options.filterable = ['name'];
    this.table_options.columnsClasses = {
      'name': 'col-md-5',
      'id': 'col-md-2'
    };
  },
};

/**
 *
 *  campo Unidades y dependencias a cargo =========  Departamento
 * http://localhost:8000/payroll/employments/create 
 *
 * 
 *  * 
 * 
 * 
 * en warehouseProductsFormComponent
 * 
 * <div class="col-md-4">
      <div class="form-group is-required">
          <label>Unidad de medida:</label>
          <select2 :options="measurement_units" v-model="record.measurement_unit_id"></select2>
      </div>
  </div>
 * 
 * 
 * 
 * 
 */
</script>
