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
                  <div class='row'>
                    <div class="col-6">
                      <label for="tipoformato">Jurídica:</label>
                      <div class="col-12 bootstrap-switch-mini">
                        <input id='type_person_juridica' data-on-label='SI' data-off-label='NO' name='type_person_juridica'
                          type='checkbox' class='form-control bootstrap-switch'
                          v-model='record.type_person_juridica'>
                      </div>
                    </div>
                    <div class="col-6">
                      <label for="tipoformato">Natural:</label>
                       <div class="col-12 bootstrap-switch-mini">
                        <input id='type_person_natural' data-on-label='SI' data-off-label='NO' name='type_person_natural'
                          type='checkbox' class='form-control bootstrap-switch'
                          v-model='record.type_person_natural'>
                      </div>
                    </div>
                  </div>
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
                  <label for="name_client">Nombre o razón social:</label>
                  <input type="text" id="name_client" class="form-control input-sm" data-toggle="tooltip"
                    title="Nombre o razón social" v-model="record.name_client">
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
                  <ckeditor :editor="ckeditor.editor" id="direction" data-toggle="tooltip"
                    title="Indique dirección física del bien" :config="ckeditor.editorConfig"
                    class="form-control" name="direction" tag-name="textarea" rows="3"
                    v-model="record.address"></ckeditor>
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
                      <label for="name_client">Correo electrónico:</label>
                      <input type="text" id="email_client" class="form-control input-sm" data-toggle="tooltip"
                        title="Correo electrónico" v-model="record.name_client">
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
                      <div class="col-3">
                        <div class="form-group is-required">
                          <input type="text" placeholder="Número" data-toggle="tooltip" title="Indique el número telefónico" v-model="phone.number" class="form-control input-sm">
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
          country_id: '',
          estate_id: '',
          city_id: '',
          municipality_id: '',
          parish_id: '',
          address: '',
          phones: []
        },
        errors: [],
        records: [],
        countries: [],
        estates: ['0'],
        cities: ['0'],
        municipalities: ['0'],
        parishes: ['0'],
      }
    },
    methods: {
      reset() {
        this.record = {
          country_id: '',
          estate_id: '',
          city_id: '',
          municipality_id: '',
          parish_id: '',
          address: '',
          phones: []
        };
      },
    },
    created() {
      this.getCountries();
      this.getEstates();
      this.getMunicipalities();
      this.getParishes();
    }
  };
</script>
