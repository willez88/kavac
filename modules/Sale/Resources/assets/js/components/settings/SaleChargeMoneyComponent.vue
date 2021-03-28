<template>
  <div class="text-center">
    <a class="btn-simplex btn-simplex-md btn-simplex-primary" href=""
      title="Métodos de cobro" data-toggle="tooltip"
      @click="addRecord('add_charge_money', 'sale/register-charge-money', $event);">
      <i class="icofont icofont-pay ico-3x"></i>
      <span>Métodos de cobro</span>
    </a>
    <div class="modal fade text-left" tabindex="-1" role="dialog" id="add_charge_money">
      <div class="modal-dialog vue-crud" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
            <h6><i class="icofont icofont-pay-man ico-3x"></i>Métodos de cobro</h6>
          </div>
          <div class="modal-body">
            <div class="alert alert-danger" v-if="errors.length > 0">
              <ul>
                <li v-for="error in errors">{{ error }}</li>
              </ul>
            </div>
            <h6 class="card-title">Datos del Método de cobro:</h6>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group is-required">
                  <label for="name_charge_money">Nombre del método de cobro:</label>
                  <input type="text" id="name_charge_money" class="form-control input-sm" data-toggle="tooltip"
                   title="Nombre del método de cobro" v-model="record.name_charge_money">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group is-required">
                  <label>Descripción</label>
                  <input type="text" id="description_charge_money" class="form-control input-sm" data-toggle="tooltip"
                   title="Descripción del método de cobro" v-model="record.description_charge_money">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <h6 class="card-title">
                  Agregar nuevo atributo <i class="fa fa-plus-circle cursor-pointer" @click="addAttributeChargeMoney"></i>
                </h6>
              </div>
            </div>
            <div class="row" v-for="(attrib, index) in record.list_attributes">
              <div class="col-6">
                <div class="form-group is-required">
                  <input type="text" placeholder="Nombre del atributo" title="Nuevo atributo" v-model="attrib.attributes" class="form-control input-sm">
                </div>
              </div>
              <div class="col-1">
                <div class="form-group">
                  <button class="btn btn-sm btn-danger btn-action" type="button" @click="deleteAttributeChargeMoney(index)" title="Eliminar este atributo" data-toggle="tooltip">
                    <i class="fa fa-minus-circle"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <div class="form-group">
              <modal-form-buttons :saveRoute="'sale/register-charge-money'"></modal-form-buttons>
            </div>
          </div>
          <div class="modal-body modal-table">
            <v-client-table :columns="columns" :data="records" :options="table_options">
              <div slot="id" slot-scope="props" class="text-center">
                <button @click="initUpdate(props.row.id, $event)"
                  class="btn btn-warning btn-xs btn-icon btn-action"
                  title="Modificar registro" data-toggle="tooltip" type="button">
                    <i class="fa fa-edit"></i>
                </button>
                <button @click="deleteRecord(props.row.id, 'sale/register-charge-money')"
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
          name_charge_money: '',
          description_charge_money: '',
          list_attributes: [],
          id: ''
        },
        errors: [],
        records: [],
        attributes: [],
        columns: ['name_charge_money', 'description_charge_money', 'name_attributes', 'id']
      }
    },
    methods : {
      addAttributeChargeMoney() {
        this.record.list_attributes.push({
          attributes: '',
        });
      },
      deleteAttributeChargeMoney(index) {
        this.record.list_attributes.splice(index, 1);
      },
      reset() {
        this.record = {
          name_charge_money: '',
          description_charge_money: '',
          list_attributes: [],
          id: ''
        };
      },
    },
    created() {
      this.table_options.headings = {
        'name_charge_money': 'Nombre',
        'description_charge_money': 'Descripción',
        'name_attributes': 'Atributos',
        'id': 'Acción'
      };
      this.table_options.sortable = ['name_charge_money'];
      this.table_options.filterable = ['name_charge_money'];
      this.table_options.columnsClasses = {
        'name_charge_money': 'col-xs-4',
        'description_charge_money': 'col-xs-4',
        'name_attributes': 'col-xs-4',
        'id': 'col-xs-2'
      };
    },
  };
</script>
