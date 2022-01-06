<template>
  <section id="SaleReportForm">
    <div class="card-body">
      <div class="alert alert-danger" v-if="errors.length > 0">
        <ul>
          <li v-for="error in errors">{{ error }}</li>
        </ul>
      </div>
      <div class="row align-items-center">
        <!-- filtrado por fechas -->
        <div class="col-xs-12 col-sm-12">
          <label class="control-label">Filtrar por</label>
        </div>
        <div class="col-xs-6 col-sm-6">
          <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDate" id="flexRadioDateSpecific" value="specific" v-model="record.filterDate">
            <label class="form-check-label" for="flexRadioDateSpecific">Por Período</label>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6">
          <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDate" id="flexRadioDateGeneral" value="general" v-model="record.filterDate">
            <label class="form-check-label" for="flexRadioDateGeneral">Por Meses y Años</label>
          </div>
        </div>
        <div class="col-md-12" v-show="record.filterDate == ''">
        </div>
        <div class="col-md-6" v-show="record.filterDate == 'specific'">
          <div class="form-group is-required">
            <label class="control-label">Fecha inicial</label>
            <input type="date" class="form-control input-sm no-restrict" v-model="record.dateIni" :min="quote_range_dates['min']" :max="quote_range_dates['max']">
          </div>
        </div>
        <div class="col-md-6" v-show="record.filterDate == 'specific'">
          <div class="form-group is-required">
            <label class="control-label">Fecha final</label>
            <input type="date" class="form-control input-sm no-restrict" v-model="record.dateEnd" :min="quote_range_dates['min']" :max="quote_range_dates['max']" :disabled="record.dateIni?false:true">
          </div>
        </div>
        <div class="col-md-6" v-show="record.filterDate == 'general'">
          <div class="is-required">
            <label>Meses</label>
            <v-multiselect :options="months" track_by="text"
              :hide_selected="false" :selected="record.month_init" v-model="record.month_init">
            </v-multiselect>
          </div>
        </div>
        <div class="col-md-6" v-show="record.filterDate == 'general'">
          <div class="is-required">
            <label>Años</label>
            <v-multiselect :options="quote_years" track_by="id"
              :hide_selected="false" :selected="record.year_init" v-model="record.year_init">
            </v-multiselect>
          </div>
        </div>
        <div class="col-md-6 mt-2">
          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="CheckStatus" v-model="record.check_status">
            <label class="form-check-label" for="CheckStatus">Estado de la cotización</label>
          </div>
        </div>
        <div class="col-md-6  mt-2" v-if="!record.check_status">
        </div>
        <div class="col-md-6 mt-2" v-if="record.check_status">
          <div class="form-group is-required">
            <select2 :options="quote_status_list" v-model="record.status"></select2>
          </div>
        </div>
        <div class="col-md-6 mt-2">
          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="CheckClient" v-model="record.check_client">
            <label class="form-check-label" for="CheckClient">Clientes</label>
          </div>
        </div>
        <div class="col-md-6 mt-2" v-if="record.check_client">
          <div class="form-group is-required">
            <v-multiselect :options="quote_with_clients" track_by="id"
              :hide_selected="false" :selected="record.clients" v-model="record.clients">
            </v-multiselect>
          </div>
        </div>
      </div>
    </div>
    <div class="card-footer text-right" >
      <button data-toggle="tooltip" title="Buscar" class="btn btn-info btn-sm" @click="searchRecords">
        Buscar <i class="fa fa-search"></i>
      </button>
    </div>
    <div class="col-12"><hr></div>
    <div class="col-12">
      <v-client-table :columns="columns" :data="records" :options="table_options">
        <div slot="date" slot-scope="props">
          {{ new Date(props.row.created_at).toLocaleString() }}
        </div>
        <div slot="status" slot-scope="props">
          {{ props.row.status_text }}
        </div>
        <div slot="products" slot-scope="props">
          <div v-if="props.row.sale_quote_product">
            <ul v-for="product in props.row.sale_quote_product">
              <li>{{ (product.sale_warehouse_inventory_product_id)? product.sale_warehouse_inventory_product.sale_setting_product.name : product.sale_type_good.name }}</li>
            </ul>
          </div>
          <div v-else>
            <span>N/A</span>
          </div>
        </div>
        <div slot="id" slot-scope="props">
          <input type="checkbox" id="CheckAddToReport" @click="addToReport(props.row.id)" v-model="props.row.selectQuotes">
        </div>
      </v-client-table>
    </div>
    <div class="card-footer text-right" v-if="records.length > 0">
      <button class="btn btn-primary btn-sm" data-toggle="tooltip" title="Generar Reporte" :disabled="recordsToReport.length == 0"
        v-on:click="OpenPdf(getUrlReport(), '_blank')" id="saleOrderGenerateReport">
        <span>Generar reporte</span>
        <i class="fa fa-print"></i>
      </button>
    </div>
  </section>
</template>

<script>
export default {
  data() {
    return {
      reportUrl : 'sale/reports/quotes/pdf',
      record: {
        filterDate : '',
        dateIni : '',
        dateEnd : '',
        status : '',
        month_init : [],
        year_ini : [],
        month_end : '',
        year_end : new Date().getFullYear(),
        check_client : false,
        check_status : false,
        clients : [],
      },
      quote_years : [],
      quote_status_list : [],
      quote_with_clients : [],
      quote_range_dates : [],
      months : [
        { id : '', text : 'Seleccione...' },
        { id : 1,  text : 'Enero' },
        { id : 2,  text : 'Febrero' },
        { id : 3,  text : 'Marzo' },
        { id : 4,  text : 'Abril' },
        { id : 5,  text : 'Mayo' },
        { id : 6,  text : 'Junio' },
        { id : 7,  text : 'Julio' },
        { id : 8,  text : 'Agosto' },
        { id : 9,  text : 'Septiembre' },
        { id : 10, text : 'Octubre' },
        { id : 11, text : 'Noviembre' },
        { id : 12, text : 'Diciembre' }
      ],
      years : [],
      errors : [],
      records : [],
      recordsToReport : [],
      columns : [
        'date',
        'name',
        'products',
        'total',
        'status',
        'id'
      ],
    }
  },
  methods: {
    /**
     * Método que borra todos los datos del formulario de reporte
     *
     * @author Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
    */
    reset() {
      const vm = this;
      vm.record = {
        filterDate : '',
        dateIni : '',
        dateEnd : '',
        status : '',
        month_init : [],
        year_init : [],
        month_end : '',
        year_end : new Date().getFullYear(),
        check_client : false,
        clients : [],
      };
      vm.recordsToReport = [];
      vm.records = [];
    },

    /**
     * Consulta y filtra los registros de solicitud de Reporte
     *
     * @author Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
    */
    searchRecords(){
      const vm = this;
      vm.records = [];
      vm.recordsToReport = [];
      axios.post('/sale/reports/quotes/data', this.record).then(response => {
        vm.records = response.data.records;
      });
    },

    /**
     * Método que almacena y elimina los quotes que se agregaran al reporte
     * Mantiene la lista ordenada
     *
     * @author Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @param  {integer} id Identificador del registro
    */
    addToReport(id){
      const vm = this;
      var pos = vm.recordsToReport.indexOf(id);
      if (pos != -1) {
        vm.recordsToReport.splice(pos, 1);
      }
      else {
        vm.recordsToReport.push(id);
      }
      vm.recordsToReport.sort();
    },

    /**
     * Método que obtiene la url con los quotes a mostrar en el reporte
     *
     * @author Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
    */
    getUrlReport(){
      const vm = this;
      return ('/' + vm.reportUrl + '/' + vm.recordsToReport.join('+'));
    },

    /**
     * Método que abre la url del reporte en pdf
     *
     * @author Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @param  {string} url path con direccion del pdf
     * @param  {string} type metodo para abrir el requerimiento
    */
    OpenPdf(url, type){
      const vm = this;
      window.open(url, type);
      vm.reset();
    },
  },
  created() {
    const vm = this;
    vm.table_options.headings = {
      'date': 'Fecha',
      'name': 'Nombre o razón social del cliente',
      'products': 'Nombre del bien',
      'total': 'Monto total',
      'status': 'Estatus solicitud',
      'id': 'Agregar a reporte',
    };
    vm.table_options.sortable = [
      'code',
      'date',
      'organization',
    ];
    vm.table_options.filterable = [];
    vm.table_options.columnsClasses = {
      'id': 'text-center',
      'total': 'text-center',
      'status': 'text-center',
    };
  },
  mounted(){
    const vm = this;
    vm.reset();
    vm.getQuoteWithClients();
    vm.getQuoteStatus();
    vm.getSaleQuoteYear();
    vm.getSaleQuoteRangeDates();
  },
};
</script>
