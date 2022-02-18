<template>
  <div class="text-center">
    <a class="btn-simplex btn-simplex-md btn-simplex-primary" href="" title="Registros de Costos Comunes" data-toggle="tooltip"  @click="addRecord('add_sale_setting_periodic_cost', 'sale/periodic-cost', $event)">
      <i class="icofont icofont-ui-calendar ico-3x"></i>
      <span>Costos Fijos</span>
    </a>
    <div class="modal fade text-left" tabindex="-1" role="dialog" id="add_sale_setting_periodic_cost">
      <div class="modal-dialog vue-crud" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
            <h6><i class="icofont icofont-ui-calendar ico-3x"></i>Costos Fijos</h6>
          </div>
          <div class="modal-body">
            <div class="alert alert-danger" v-if="errors.length > 0">
              <div class="container">
                <div class="alert-icon">
                  <i class="now-ui-icons objects_support-17"></i>
                </div>
                <strong>Cuidado!</strong> Debe verificar los siguientes errores antes de continuar:
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                  @click.prevent="errors = []">
                  <span aria-hidden="true">
                    <i class="now-ui-icons ui-1_simple-remove"></i>
                  </span>
                </button>
                <ul>
                  <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
                </ul>
              </div>
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
                  <label>Descripción:</label>
                  <textarea id="description" :class="'form-control'" @input="delete errors['description'];" type="text" name="description" aria-labelledby="description_label"   aria-describedby=""       value="" data-toggle="tooltip" title="Indique una breve descripción del tipo de bien (requerido)" tabindex="1" rows="3" required v-model="record.description">
                  </textarea>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group is-required">
                  <label for="name">Valor monetario:</label>
                  <input type="text" id="value" placeholder="Costo" class="form-control input-sm" v-model="record.value" data-toggle="tooltip" title="Indique el nombre (requerido)">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group is-required">
                  <label>Moneda:</label>
                    <select2 :options="currencies" v-model="record.currency_id" id="currency_id"></select2>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group is-required">
                  <label>Periodicidad de pago:</label>
                  <select2 :options="frecuencies" v-model="record.frecuency_id" id="frecuency_id"></select2>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <a  data-toggle="tooltip" title="Establecer los atributos del tipo de bien para gestionar las variantes">
                    <label for="" class="control-label">Atributos Personalizados</label>
                    <div class="col-12">
                      <div class="bootstrap-switch-mini">
                        <input type="checkbox" class="form-control bootstrap-switch" name="attributes" data-on-label="Si" data-off-label="No" value="true" v-model="record.attributes">
                      </div>
                    </div>
                  </a>
                </div>
              </div>
            </div>
            <div v-show="this.record.attributes">
              <div class="row" style="my-4">
                <h6 class="card-title cursor-pointer" @click="addAttribute()" >Gestionar nuevo atributo <i class="fa fa-plus-circle"></i></h6>
              </div>
              <div class="row" style="my-5">
                <div class="col-6" v-for="(attribute, index) in record.periodic_cost_attribute" :key="index">
                  <div class="d-inline-flex">
                    <div class="col-10">
                      <div class="form-group">
                        <input type="text" placeholder="Nombre del nuevo atributo" data-toggle="tooltip" title="Indique el nombre del atributo del tipo de bien que desee hacer seguimiento (opcional)" v-model="attribute.name" class="form-control input-sm">
                      </div>
                    </div>
                    <div class="col-2">
                      <div class="form-group">
                        <button class="btn btn-sm btn-danger btn-action" type="button" @click="removeRow(index, record.periodic_cost_attribute)" title="Eliminar atributo" data-toggle="tooltip">
                          <i class="fa fa-minus-circle"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <div class="form-group">
              <button type="button" class="btn btn-default btn-sm btn-round btn-modal-close" 
									@click="clearFilters" data-dismiss="modal">
								Cerrar
							</button>
							<button type="button" class="btn btn-warning btn-sm btn-round btn-modal btn-modal-clear" 
									@click="reset()">
								Cancelar
							</button>
							<button type="button" @click="createRecord('sale/periodic-cost')" 
									class="btn btn-primary btn-sm btn-round btn-modal-save">
								Guardar
							</button>
            </div>
          </div>
          <div class="modal-body modal-table">
            <v-client-table :columns="columns" :data="records" :options="table_options">
              <div slot="attributes" slot-scope="props">
                <div v-if="props.row.attributes">
                  <ul v-for="(att, index) in props.row.periodic_cost_attribute" :key="index">
                    <li>{{ att.name }}</li>
                  </ul>
                </div>
                <div v-else>
                  <span>N/A</span>
                </div>
              </div>
              <div slot="id" slot-scope="props" class="text-center">
                <button @click="initUpdate(props.row.id, $event)" class="btn btn-warning btn-xs btn-icon btn-action" title="Modificar costo" data-toggle="tooltip" type="button">
                  <i class="fa fa-edit"></i>
                </button>
                <button @click="deleteRecord(props.row.id, 'sale/periodic-cost')" class="btn btn-danger btn-xs btn-icon btn-action" title="Eliminar costo" data-toggle="tooltip" type="button">
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
 * Define la interfaz para la gestión de costos fijos
 *
 * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
 */
export default {
  data() {
    return {
      record: {
        id: '',
        name: '',
        description: '',
        value: '',
        currency_id: '',
        frecuency_id: '',
        attributes: false,
        sale_type_good_attribute: [],
      },
      errors: [],
      currencies: [],
      frecuencies: [],
      records: [],
      columns: ['name', 'description', 'value', 'currency.name', 'frecuency.name', 'attributes', 'id'],
    }
  },
  methods: {
    reset() {
      this.record = {
        id: '',
        name: '',
        description: '',
        value: '',
        currency_id: '',
        frecuency_id: '',
        attributes: false,
        periodic_cost_attribute: [],
        errors: [],
      };
    },
    addAttribute() {
      var field = {id: '', name: '', periodic_cost_id: ''};
     this.record.periodic_cost_attribute.push(field);
    },
    deleteAttribute(index) {
      this.record.periodic_cost_attribute.splice(index, 1);
    },
  },
  created() {
    this.table_options.headings = {
      'name': 'Nombre',
      'description': 'Descripción',
      'value': 'Valor monetario',
      'currency.name': 'Moneda',
      'frecuency.name': 'Periodicidad de pago',
      'attributes': 'Atributos',
      'id': 'Acción'
    };
    this.table_options.sortable = ['name', 'value', 'currency.name', 'frecuency.name'];
    this.table_options.filterable = ['name', 'value'];
    this.table_options.columnsClasses = {
      'name': 'col-md-5',
      'id': 'col-md-2'
    };
  },
  mounted() {
    const vm = this;
    vm.switchHandler('attributes');
    this.getCurrencies();
    this.getFrecuencies();
  },
};
</script>
