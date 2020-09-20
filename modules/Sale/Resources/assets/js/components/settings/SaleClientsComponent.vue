<template>
  <div class="text-center">
    <a class="btn-simplex btn-simplex-md btn-simplex-primary" href=""
      title="Clientes" data-toggle="tooltip"
      @click="addRecord('add_sale_clients', 'register-clients', $event);">
      <i class="icofont icofont-business-man ico-3x"></i>
      <span>Clientes</span>
    </a>
    <div class="modal fade text-left" tabindex="-1" role="dialog" id="add_sale_clients">
      <div class="modal-dialog vue-crud" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
            <h6><i class="icofont icofont-business-man ico-3x"></i>Clientes</h6>
          </div>
          <div class="modal-body">
            <div class="alert alert-danger" v-if="errors.length > 0">
              <ul>
                <li v-for="error in errors">{{ error }}</li>
              </ul>
            </div>
            <h6 class="card-title">Datos del cliente:</h6>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group is-required">
                  <label for="type_person">Tipo de persona:</label>
                  <select2 :options="types_person" id='type_person_juridica' v-model="record.type_person_juridica"></select2>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group is-required">
                  <label for="rif">RIF</label>
                  <input type="text" id="rif" class="form-control input-sm" data-toggle="tooltip"
                    title="Indique el rif del cliente" v-model="record.rif">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group is-required">
                  <label for="name">Nombre o razón social:</label>
                  <input type="text" id="name" class="form-control input-sm" data-toggle="tooltip"
                    title="Nombre o razón social" v-model="record.name">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <label for="direcciondelcliente">Dirección del cliente:</label>
              </div>
              <div class="col-md-4">
                <div class="form-group is-required">
                  <label for="country_id">País</label>
                  <select2 :options="countries" @input="getEstates"
                    v-model="record.country_id"></select2>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group is-required">
                  <label for="estate_id">Estado</label>
                  <select2 :options="estates" @input="getCities" v-model="record.estate_id"></select2>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group is-required">
                  <label>Ciudad</label>
                  <select2 :options="cities" @input="getMunicipalities()" v-model="record.city_id"></select2>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group is-required">
                  <label>Municipio</label>
                  <select2 :options="municipalities" @input="getParishes" v-model="record.municipality_id"></select2>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group is-required">
                  <label for="parish_id">Parroquia</label>
                  <select2 :options="parishes" v-model="record.parish_id"></select2>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group is-required">
                  <label for="direction">Dirección</label>
                  <ckeditor :editor="ckeditor.editor" id="address_tax" data-toggle="tooltip"
                    title="Indique dirección física del bien" :config="ckeditor.editorConfig"
                    class="form-control" name="address_tax" tag-name="textarea" rows="3"
                    v-model="record.address_tax"></ckeditor>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group is-required">
                  <label>Dirección Fiscal</label>
                  <ckeditor :editor="ckeditor.editor" id="direction" data-toggle="tooltip"
                    title="Indique dirección física del bien" :config="ckeditor.editorConfig"
                    class="form-control" name="direction" tag-name="textarea" rows="3"
                    v-model="record.address"></ckeditor>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <h6 class="card-title">Datos del contacto:</h6>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group is-required">
                      <label for="name_client">Nombre y apellido:</label>
                      <input type="text" id="name_client" class="form-control input-sm" data-toggle="tooltip"
                        title="Nombre y apellido" v-model="record.name_client">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group is-required">
                      <label for="email_client">Correo electrónico:</label>
                      <input type="text" id="email_client" class="form-control input-sm" data-toggle="tooltip"
                        title="Correo electrónico" v-model="record.email_client">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <h6 class="card-title">Números Telefónicos <i class="fa fa-plus-circle cursor-pointer" @click="addPhone"></i></h6>
                    <div class="row" v-for="(phone, index) in record.phones">
                      <div class="col-3">
                        <div class="form-group is-required">
                          <select data-toggle="tooltip" v-model="phone.type" class="form-control" title="Seleccione el tipo de número telefónico">
                            <option value="">Seleccione...</option>
                            <option value="M">Móvil</option>
                            <option value="T">Teléfono</option>
                            <option value="F">Fax</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-2">
                        <div class="form-group is-required">
                          <input type="text" placeholder="Cod. Area" data-toggle="tooltip"
                            title="Indique el código de área" v-model="phone.area_code"
                            class="form-control input-sm">
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="form-group is-required">
                          <input type="text" placeholder="Número" data-toggle="tooltip" title="Indique el número telefónico" v-model="phone.number_phones" class="form-control input-sm">
                        </div>
                      </div>
                      <div class="col-2">
                        <div class="form-group is-required">
                          <input type="text" placeholder="Extensión" data-toggle="tooltip"
                            title="Indique la extención telefónica (opcional)"
                            v-model="phone.extension" class="form-control input-sm">
                        </div>
                      </div>
                      <div class="col-1">
                        <div class="form-group">
                          <button class="btn btn-sm btn-danger btn-action" type="button" @click="removeRow(index, record.phones)"
                            title="Eliminar este dato" data-toggle="tooltip">
                              <i class="fa fa-minus-circle"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <div class="form-group">
              <modal-form-buttons :saveRoute="'sale/register-clients'"></modal-form-buttons>
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
                <button @click="deleteRecord(props.row.id, 'register-formatcode')"
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
          rif: '',
          type_person_juridica: '',
          name: '',
          country_id: '',
          estate_id: '',
          city_id: '',
          municipality_id: '',
          parish_id: '',
          address: '',
          address_tax: '',
          name_client: '',
          email_client: '',
          phones: []
        },
        errors: [],
        records: [],
        countries: [],
        estates: ['0'],
        cities: ['0'],
        municipalities: ['0'],
        parishes: ['0'],
        columns: ['type_person_juridica', 'rif', 'name_client', 'id'],
        types_person: ['Seleccione...', 'Jurídica', 'Natural']
      }
    },
    methods: {
      reset() {
        this.record = {
          rif: '',
          type_person_juridica: '',
          name: '',
          country_id: '',
          estate_id: '',
          city_id: '',
          municipality_id: '',
          parish_id: '',
          address: '',
          address_tax: '',
          name_client: '',
          email_client: '',
          phones: []
        };
      },
    },
    created() {
      this.getCountries();
      this.getEstates();
      this.getMunicipalities();
      this.getParishes();
      this.record.phones = [];

      this.table_options.headings = {
        'type_person_juridica': 'Tipo de Persona',
        'rif': 'Rif',
        'name_client': 'Nombre o razón social',
        'id': 'Acción'
      };
      this.table_options.sortable = ['rif'];
      this.table_options.filterable = ['rif'];
      this.table_options.columnsClasses = {
        'type_person_juridica': 'col-xs-3',
        'rif': 'col-xs-3',
        'name_client': 'col-xs-4',
        'id': 'col-xs-2'
      };
    }
  };
</script>
