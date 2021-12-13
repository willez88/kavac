<template>
    <section id="SaleReportForm">
        <div class="card-body">
            <div class="alert alert-danger" v-if="errors.length > 0">
                <ul>
                    <li v-for="error in errors">{{ error }}</li>
                </ul>
            </div>
            <div class="row">
                <!-- filtrado por fechas -->
                <div class="col-xs-6 col-sm-6 col-md-2">
                    <label class="control-label">Filtrar por</label>
                    <div class="form-check col-xs-12 col-sm-12 col-md-12">
                      <input class="form-check-input" type="radio" name="flexRadioDate" id="flexRadioDateSpecific" value="specific" v-model="filterDate">
                      <label class="form-check-label" for="flexRadioDateSpecific">
                        Por Período
                      </label>
                    </div>
                    <div class="form-check col-xs-12 col-sm-12 col-md-12">
                      <input class="form-check-input" type="radio" name="flexRadioDate" id="flexRadioDateGeneral" value="general" v-model="filterDate">
                      <label class="form-check-label" for="flexRadioDateGeneral">
                        Por Mes
                      </label>
                    </div>
                </div>
                <div class="col-md-3" v-show="filterDate == 'specific'">
                    <div class="form-group is-required">
                        <label class="control-label">Fecha inicial</label>
                        <input type="date" class="form-control input-sm"
                            v-model="record.dateIni">
                    </div>
                </div>
                <div class="col-md-3" v-show="filterDate == 'specific'">
                    <div class="form-group is-required">
                        <label class="control-label">Fecha final</label>
                        <input type="date" class="form-control input-sm"
                            v-model="record.dateEnd" :min="record.dateIni?record.dateIni:''" :disabled="record.dateIni?false:true">
                    </div>
                </div>

                <div class="col-md-3" v-show="filterDate == 'general'">
                    <label class="control-label">Fecha Inicial</label>
                    <div class="is-required">
                        <label>Mes</label>
                        <select2 :options="months" v-model="record.month_init"></select2>
                    </div>
                    <div class="is-required">
                        <label>Año</label>
                        <select2 :options="years" v-model="record.year_init"></select2>
                    </div>
                </div>
                <div class="col-md-3" v-show="filterDate == 'general'">
                    <label class="control-label">Fecha Final</label>
                    <div class="is-required">
                        <label>Mes</label>
                        <select2 :options="months" v-model="record.month_end"></select2>
                    </div>
                    <div class="is-required">
                        <label>Año</label>
                        <select2 :options="years" v-model="record.year_end"></select2>
                    </div>
                </div>

                <div class="col-md-3">
                    <label class="control-label">Estatus</label>
                    <div class="form-group is-required">
                        <select2 :options="status_list" v-model="record.status"></select2>
                    </div>
                </div>
                <div class="col-md-12">
                    <br>
                </div>
                <div class="col-md-2">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="CheckClient" v-model="record.check_client">
                        <label class="form-check-label" for="CheckClient">Clientes</label>
                    </div>
                </div>
                <div class="col-md-6" v-if="record.check_client">
                    <div class="form-group is-required" style="margin-top: -1.5rem;">
                        <v-multiselect :options="client_list" track_by="text"
                            :hide_selected="false" :selected="record.clients" v-model="record.clients">
                        </v-multiselect>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-right" >
            <button data-toggle="tooltip" title="Buscar" class="btn btn-info btn-sm" @click="searchRecords">
                <i class="fa fa-search"></i>
            </button>
            <!-- <button class="btn btn-primary btn-sm" data-toggle="tooltip" title="Generar Reporte"
                    v-on:click="OpenPdf(getUrlReport(), '_blank')" id="saleOrderGenerateReport">
                <span>Generar reporte</span>
                <i class="fa fa-print"></i>
            </button> -->
        </div>
        <div class="col-12"><hr></div>
        <div class="col-12">
            <v-client-table :columns="columns" :data="records" :options="table_options">
                <div slot="id" slot-scope="props">
                </div>
            </v-client-table>
        </div>
    </section>
</template>

<script>
export default {
    props:{
        year_old:{
            type:String,
            default: ''
        },
        currencies:{
            type:Array,
            default:function(){
                return [];
            }
        }
    },
    data() {
        return {
            record: {
                id: '',
                name: '',
                description: '',
                dateEnd:'',
                currency:'',
                status:'all',
                month_init:'',
                year_init:new Date().getFullYear(),
                month_end:'',
                year_end:new Date().getFullYear(),
                check_client:false,
                clients:[],
            },
            status_list:[
                { id:'', text:'Seleccione...' },
                { id:'waiting', text:'pendiente' },
                { id:'approved', text:'aprobado' },
                { id:'dismissed', text:'rechazado' },
                { id:'all', text:'todos' },
            ],
            client_list:[
                { id:'waiting', text:'pendiente' },
                { id:'approved', text:'aprobado' },
                { id:'dismissed', text:'rechazado' },
                { id:'all', text:'todos' },
            ],
            months:[
                { id:'', text:'Seleccione...' },
                { id:1,  text:'Enero' },
                { id:2,  text:'Febrero' },
                { id:3,  text:'Marzo' },
                { id:4,  text:'Abril' },
                { id:5,  text:'Mayo' },
                { id:6,  text:'Junio' },
                { id:7,  text:'Julio' },
                { id:8,  text:'Agosto' },
                { id:9,  text:'Septiembre' },
                { id:10, text:'Octubre' },
                { id:11, text:'Noviembre' },
                { id:12, text:'Diciembre' }
            ],
            years:[],
            errors: [],
            records: [],
            columns: ['select', 'code', 'date', 'client', 'description', 'status'],
            filterDate:'specific',
            dateEnd:'',
        }
    },
    methods: {
        /**
        * Método que borra todos los datos del formulario
        *
        * @author  Miguel Narvaez <mnarvaez@cenditel.gob.ve>
        */
        reset() {
            this.record = {
                id: '',
                name: '',
                description: 'specific',
                filterDate:'specific',
                dateEnd:'',
                currency:'',
                status:'all',
            };
        },

        /**
        * Crea un array con los años desde el dado hasta el actual
        *
        * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
        * @param  {integer} year_old fecha del año de inicio
        * @param  {boolean} optionExtra bandera para determinar si agregar un registro extra al pricipio del array de los años
        */
        CalculateOptionsYears:function(year_old, optionExtra = false){
            const vm = this;
            var date = new Date();
            if (optionExtra) {
                vm.years.push({
                    id:0,
                    text:'Todos'
                });
                vm.record.year_init = 0;
            }
            for (var year = date.getFullYear(); year >= year_old; year--) {
                vm.years.push({
                    id:year,
                    text:year
                });
            }
        },

        /**
        * Consulta y filtra los registros de solicitud de servicios
        *
        * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
        */
        searchRecords(){
            axios.post('/sale/reports/service-requests/filter-records', this.record).then(response => {
                console.log(response.data.message);
            });
        },
    },
    created() {
        const vm = this;
        vm.table_options.headings = {
            'select': 'Selección',
            'code': 'Código',
            'date': 'Fecha',
            'client': 'Nombre o Razón social del cliente',
            'description': 'Descripción del servicio',
            'status': 'Estatus solicitud',
        };
        vm.table_options.sortable = ['code', 'date', 'client'];
        vm.table_options.filterable = ['code', 'date', 'client'];
        // vm.table_options.columnsClasses = {
        //     'name': 'col-md-5',
        //     'description': 'col-md-5',
        //     'id': 'col-md-2'
        // };
    },
    mounted(){
        const vm = this;
        vm.CalculateOptionsYears(vm.year_old);
    },
};
</script>