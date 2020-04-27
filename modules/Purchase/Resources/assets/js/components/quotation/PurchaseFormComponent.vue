<template>
    <section>
        <purchase-show-errors ref="PurchaseOrderFormComponent" />

        <div class="row">
            <div class="col-3">
                <div class="form-group is-required">
                    <label class="control-label" for="suppliers">Proveedor</label><br>
                    <select2 :options="suppliers" id="suppliers" v-model="purchase_supplier_id"></select2>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label class="control-label" for="currencies">Tipo de proveedor</label><br>
                    <div v-if="record.purchase_supplier_object">
                        <div v-if="record.purchase_supplier_object.type == 'S'">
                            <strong>Servicios / {{ record.purchase_supplier_object.name }}</strong>
                        </div>
                        <div v-else-if="record.purchase_supplier_object.type == 'O'">
                            <strong>Obras / {{ record.purchase_supplier_object.name }}</strong>
                        </div>
                        <div v-else-if="record.purchase_supplier_object.type == 'B'">
                            <strong>Bienes / {{ record.purchase_supplier_object.name }}</strong>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group is-required">
                    <label class="control-label" for="currencies">Tipo de moneda</label><br>
                    <select2 :options="currencies" id="currencies" v-model="currency_id"></select2>
                </div>
            </div>
            <div class="col-12 row">
                <div class="col-3">
                    <label for="acta_inicio">Acta de inicio (inhabilitado temporalmente)</label>
                    <label class="custom-control">
                        <button type="button" data-toggle="tooltip"
                                class="btn btn-sm btn-info btn-import mt-4"
                                title="Presione para subir el archivo del documento."
                                @click="setFile('acta_inicio')"
                                disabled="">
                            <i class="fa fa-upload"></i>
                        </button>
                        <input type="file"
                                id="acta_inicio"
                                @change="uploadFile('acta_inicio')"
                                style="display:none;">
                        <span class="badge badge-success" id="status_acta_inicio" style="display:none;">
                            <strong>Documento Cargado.</strong>
                        </span>
                    </label>
                </div>
                <div class="col-3">
                    <label for="invitation_bussiness">Invitación de la empresa (inhabilitado temporalmente)</label>
                    <label class="custom-control">
                        <button type="button" data-toggle="tooltip"
                                class="btn btn-sm btn-info btn-import"
                                title="Presione para subir el archivo del documento."
                                disabled=""
                                @click="setFile('invitation_bussiness')">
                            <i class="fa fa-upload"></i>
                        </button>
                        <input type="file"
                                id="invitation_bussiness"
                                @change="uploadFile('invitation_bussiness')"
                                style="display:none;">
                        <span class="badge badge-success" id="status_invitation_bussiness" style="display:none;">
                            <strong>Documento Cargado.</strong>
                        </span>
                    </label>
                </div>
                <div class="col-3">
                    <label for="invitation_bussiness">Proforma / Cotización (inhabilitado temporalmente)</label>
                    <label class="custom-control">
                        <button type="button" data-toggle="tooltip"
                                class="btn btn-sm btn-info btn-import"
                                title="Presione para subir el archivo del documento."
                                disabled=""
                                @click="setFile('invitation_bussiness')">
                            <i class="fa fa-upload"></i>
                        </button>
                        <input type="file"
                                id="invitation_bussiness"
                                @change="uploadFile('invitation_bussiness')"
                                style="display:none;">
                        <span class="badge badge-success" id="status_invitation_bussiness" style="display:none;">
                            <strong>Documento Cargado.</strong>
                        </span>
                    </label>
                </div>
            </div>
            <div class="col-12">
                <hr>
            </div>
            <div class="col-12">
                <h6 class="card-title">Lista de presupuestos base en espera de cotización</h6>
            </div>
            <div class="col-12">
                <v-client-table :columns="columns" :data="record_base_budgets" :options="table_options">
                    <div slot="requirement_status" slot-scope="props" class="text-center">
                        <div class="d-inline-flex">
                            <span class="badge badge-info"
                                v-show="props.row.requirement_status == 'PROCESSED'">
                                <strong>PROCESADO</strong>
                            </span>
                        </div>
                    </div>
                    <div slot="id" slot-scope="props" class="text-center">
                        <div class="feature-list-content-left mr-2" v-if="record.currency">
                            <label class="custom-control custom-checkbox">
                                <p-check class="p-icon p-smooth p-plain p-curve"
                                         color="primary-o"
                                         :value="'_'+props.row.id"
                                         :id="'requirement_check_'+props.row.id"
                                         :checked="indexOf(base_budget_list, props.row.id, true)"
                                         @change="recordCheck(props.row)">
                                    <i slot="extra" class="icon fa fa-check"></i>
                                </p-check>
                            </label>
                        </div>
                    </div>
                </v-client-table>
            </div>

<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

            <div class="col-12">
                <v-client-table :columns="columns2" :data="record_items" :options="table2_options">
                    <div slot="quantity" slot-scope="props">
                        <h6 align="left">{{ props.row.quantity }} {{ props.row.measurement_unit_acronym }}</h6>
                    </div>
                    <div slot="unit_price" slot-scope="props">
                        <input type="number" v-model="record_items[props.index-1].unit_price" class="form-control"
                                :step="cualculateLimitDecimal()" @input="CalculateTot(record_items[props.index-1], props.index-1)">
                    </div>
                    <div slot="qty_price" slot-scope="props">
                        <h6 align="right">{{ CalculateQtyPrice(record_items[props.index-1].qty_price) }}</h6>
                    </div>
                </v-client-table>
            </div>

<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

            <div class="col-12" v-if="record_items.length > 0">
                <div class="VueTables VueTables--client" style="margin-top: -1rem;">
                    <div class="table-responsive">
                        <table class="VueTables__table table table-striped table-bordered table-hover">
                            <tbody>
                                <tr>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" width="8.2%"></td>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" width="25%"></td>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" width="16.65%"></td>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" width="16.75%"></td>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" width="16.75%">
                                        <h6 align="right">SUB-TOTAL {{ currency_symbol }}</h6>
                                    </td>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" width="20%">
                                        <h6 align="right">{{ sub_total.toFixed((record.currency)?currency_decimal_places:'') }}</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" width="8.2%"></td>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" width="25%"></td>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" width="16.6%"></td>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" width="16.75%"></td>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" width="16.75%">
                                        <h6 align="right">{{ tax?tax.percentage:'' }} % IVA {{ currency_symbol }}</h6>
                                    </td>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" width="20%">
                                        <h6 align="right">{{ tax_value.toFixed((record.currency)?currency_decimal_places:'') }}</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" width="8.2%"></td>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" width="25%"></td>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" width="16.6%"></td>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" width="16.75%"></td>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" width="16.75%">
                                        <h6 align="right">TOTAL {{ currency_symbol }}</h6>
                                    </td>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" width="20%">
                                        <h6 align="right">{{ (total).toFixed((record.currency)?currency_decimal_places:'') }}</h6>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-right">
            <buttonsDisplay route_list="/purchese/purchase_order" display="false" />
        </div>
    </section>
</template>
<script>
export default{
    props:{
        record_edit:{
            type:Object,
            default: function() {
                return null;
            }
        },
        date:{
            type: String,
            default: '',
        },
        tax:{
            type:Object,
            default: function() {
                return null;
            }
        },
        tax_units:{
            type:Object,
            default: function() {
                return null;
            }
        },
        record_base_budgets:{
            type:Array,
            default: function(){
                return [];
            }
        },
        suppliers:{
            type:Array,
            default: function(){
                return [];
            }
        },
        currencies:{
            type:Array,
            default: function() {
                return [];
            }
        },
    },
    data(){
        return {
            // records:[],
            record:{
                purchase_supplier_id:'',
                purchase_supplier_object:'',
                currency:null,
            },
            record_items:[],
            columns: [
                        'purchase_requirement.code',
                        'created_at',
                        'purchase_requirement.description',
                        'purchase_requirement.fiscal_year.year',
                        'purchase_requirement.user_department.name',
                        'currency.name',
                        'id'
                        // 'contrating_department.name',
                        // 'purchase_supplier_type.name',
                    ],
            columns2:[
                        'requirement_code',
                        'name',
                        'quantity',
                        // 'measurement_unit_acronym',
                        'unit_price',
                        'qty_price',
                    ],
            table2_options: {
                pagination: { edge: true },
                //filterByColumn: true,
                highlightMatches: true,
                texts: {
                    filter: "Buscar:",
                    filterBy: 'Buscar por {column}',
                    //count:'Página {page}',
                    count: ' ',
                    first: 'PRIMERO',
                    last: 'ÚLTIMO',
                    limit: 'Registros',
                    //page: 'Página:',
                    noResults: 'No existen registros',
                },
                sortIcon: {
                    is: 'fa-sort cursor-pointer',
                    base: 'fa',
                    up: 'fa-sort-up cursor-pointer',
                    down: 'fa-sort-down cursor-pointer'
                },
            },
            base_budget_list:[],
            base_budget_list_deleted:[],
            sub_total:0,
            tax_value:0,
            total:0,
            currency_id:'',
            purchase_supplier_id:'',
            convertion_list:[],
            load_data_edit:false,
        }
    },
    created(){
        this.table_options.headings = {
            'purchase_requirement.code':          'Código de requerimeinto',
            'created_at':                         'Fecha',
            'purchase_requirement.description':                        'Descripción',
            'purchase_requirement.fiscal_year.year':                   'Año fiscal',
            'purchase_requirement.user_department.name':               'Departamento Usuario',
            'currency.name':                      'Moneda',
            'id':                                 'Acción'
            // 'contrating_department.name':         'Departamento contatante',
            // 'purchase_supplier_type.name':        'Tipo de Proveedor',
        };

        this.table_options.columnsClasses = {
            'purchase_requirement.code':          'col-xs-1 text-center',
            'created_at':                         'col-xs-1 text-center',
            'purchase_requirement.description':                        'col-xs-4',
            'purchase_requirement.fiscal_year.year':                   'col-xs-1 text-center',
            'purchase_requirement.user_department.name':               'col-xs-2',
            'currency.name':                      'col-xs-2',
            'id':                                 'col-xs-1'
            // 'purchase_supplier_type.name':        'col-xs-2',
            // 'contrating_department.name':         'col-xs-2',
        };

        this.table2_options.headings = {
            'requirement_code':         'Código de requerimiento',
            'name':                     'Nombre',
            'quantity':                 'Cantidad',
            // 'measurement_unit_acronym': 'Unidad de medida',
            'unit_price':               'Precio unitario sin IVA',
            'qty_price':                'Cantidad * precio unitario',
        };

        this.table2_options.columnsClasses = {
            'requirement_code':         'col-xs-1 text-center',
            'name':                     'col-xs-5',
            'quantity':                 'col-xs-2',
            // 'measurement_unit_acronym': 'col-xs-2',
            'unit_price':               'col-xs-2',
            'qty_price':                'col-xs-2',
        };

        this.table2_options.filterable = [];
    },
    mounted(){
        const vm = this;

        // vm.records = vm.record_base_budgets;
        if (vm.record_edit) {
            vm.load_data_edit = true;
            vm.currency_id = vm.record_edit.currency_id;
            vm.purchase_supplier_id = vm.record_edit.purchase_supplier_id;

            var prices = [];
            for (var i = 0; i < vm.record_edit.relatable.length; i++) {
                prices[vm.record_edit.relatable[i].purchase_requirement_item_id] = vm.record_edit.relatable[i].unit_price;
            }

            for (var i = 0; i < vm.record_edit.purchase_base_budgets.length; i++) {
                vm.addToList(vm.record_edit.purchase_base_budgets[i], prices);
            }
        }
    },
    methods:{

        reset(){
            this.record_items             = [];
            this.base_budget_list         = [];
            this.base_budget_list_deleted = [];
            this.record = {
                purchase_supplier_id:'',
                currency:'',
            };
            this.sub_total = 0;
            this.tax_value = 0;
            this.total     = 0;
            this.$refs.PurchaseOrderFormComponent.reset();
        },

        addDecimals(value){
            return parseFloat(value).toFixed(this.currency_decimal_places);
        },

        indexOf(list, id, returnBoolean){
            for (var i = list.length - 1; i >= 0; i--) {
                if (list[i].id == id) {
                    return (returnBoolean) ? true : i;
                }
            }
            return (returnBoolean) ? false : -1;
        },

        recordCheck(record){
            axios.get('/purchase/get-convertion/'+this.currency_id+'/'+record.currency_id)
            .then(response=>{
                if (record.currency_id != this.currency_id && !response.data.record) {

                    if ($('#requirement_check_'+record.id+' input:checkbox').prop('checked')) {
                        this.showMessage(
                            'custom', 'Error', 'danger', 'screen-error',
                            "Imposible realizar la conversión de "+this.record.currency.name
                            +" a "+record.currency.name
                            +". Revisar conversiones configuradas en el sistema."
                        );
                        $('#requirement_check_'+record.id+' input:checkbox').prop('checked',false);
                    }
                }else{
                    this.convertion_list.push(response.data.record);
                    this.addToList(record);
                }
            });
        },

        addToList:function(record, prices) {
            var pos = this.indexOf(this.base_budget_list, record.id);
                // se agregan a la lista a guardar
                if (pos == -1) {
                    for (var i = 0; i < record.relatable.length; i++) {
                        record.relatable[i].name = record.relatable[i].purchase_requirement_item.name;
                        record.relatable[i].quantity = record.relatable[i].purchase_requirement_item.quantity;

                        record.relatable[i].measurement_unit_acronym =
                                record.relatable[i].purchase_requirement_item.measurement_unit.acronym;

                                // +' - '+
                                // record.relatable[i].purchase_requirement_item.measurement_unit.name;

                        record.relatable[i].requirement_code = record.relatable[i].purchase_requirement_item.purchase_requirement.code;
                        record.relatable[i].unit_price = (prices)?prices[record.relatable[i].id]:0;
                    }

                    // saca de la lista de registros eliminar
                    pos = this.indexOf(this.base_budget_list_deleted, record.id);
                    if (pos != -1) {
                        this.base_budget_list_deleted.splice(pos,1);
                    }

                    this.base_budget_list.push(record);
                    this.record_items = this.record_items.concat(record.relatable);
                }else{
                    // se sacan de la lista a guardar
                    var record_copy = this.base_budget_list.splice(pos,1)[0];
                    var pos = this.indexOf(this.base_budget_list_deleted, record_copy.id);

                    // agrega a la lista de registros a eliminar
                    if (pos == -1) {
                        this.base_budget_list_deleted.push(record_copy);
                    }

                    for (var i = 0; i < record.relatable.length; i++) {
                        for (var x = 0; x < this.record_items.length; x++) {
                            if (this.record_items[x].id == record.relatable[i].id) {
                                delete this.record_items[x].qty_price;
                                this.record_items.splice(x,1);
                                break;
                            }
                        }
                    }
                }
                this.CalculateTot();
        },

       /**
        * [CalculateTot Calcula el total del debe y haber del asiento contable]
        * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
        * @param  {[type]} r   [información del registro]
        * @param  {[type]} pos [posición del registro]
        */
        CalculateTot(item, pos){
            const vm = this;
            // console.log(item)
            // vm.record_items[pos] = item;

            vm.sub_total = 0;
            vm.tax_value = 0;
            for (var i = vm.record_items.length - 1; i >= 0; i--) {
                var r = vm.record_items[i];
                r['qty_price'] = r.quantity * r.unit_price;
                vm.sub_total += r['qty_price'];
            }
            vm.tax_value = vm.sub_total * (parseFloat(vm.tax.percentage)/100);
            vm.total = vm.sub_total + vm.tax_value;
        },

        CalculateQtyPrice(qty_price){
            return (qty_price)?(qty_price).toFixed((this.record.currency)?this.currency_decimal_places:''):0;
        },

        /**
        * Establece la cantidad de decimales correspondientes a la moneda que se maneja
        *
        * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
        */
        cualculateLimitDecimal(){
            var res = "0.";
            if (this.currency) {
                for (var i = 0; i < this.currency.decimal_places-1; i++) {
                    res += "0";
                }
            }
            res += "1";
            return res;
        },

        createRecord(){

            // if (id == 'acta_inicio' || id == 'invitation_bussiness') {
            //     $('#status_'+id).show('slow');
            //     return;
            // }

            /** Se obtiene y da formato para enviar el archivo a la ruta */
            let vm = this;
            var formData = new FormData();
            // var inputFile = document.querySelector('#'+id);
            // formData.append("file", inputFile.files[0]);
            formData.append("purchase_supplier_id", this.purchase_supplier_id);
            formData.append("currency_id", this.currency_id);
            formData.append("subtotal", this.sub_total);
            formData.append("record_list", JSON.stringify(this.base_budget_list) );
            vm.loading = true;

            if (!this.record_edit) {
                axios.post('/purchase/quotation', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(response => {
                    vm.showMessage('store');
                    vm.loading = false;
                    location.href = this.route_list;
                }).catch(error => {
                    if (typeof(error.response) !== "undefined") {
                        if (error.response.status == 422 || error.response.status == 500) {
                            for (const i in error.response.data.errors){
                                vm.showMessage(
                                    'custom', 'Error', 'danger', 'screen-error', error.response.data.errors[i][0]
                                );
                            }
                        }
                    }
                    vm.loading = false;
                });
            }else{
                formData.append("list_to_delete", JSON.stringify(this.base_budget_list_deleted));

                axios.post('/purchase/quotation/'+this.record_edit.id, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(response => {
                    vm.showMessage('update');
                    vm.loading = false;
                    location.href = this.route_list;

                }).catch(error => {
                    if (typeof(error.response) !== "undefined") {
                        if (error.response.status == 422 || error.response.status == 500) {
                            for (const i in error.response.data.errors){
                                vm.showMessage(
                                    'custom', 'Error', 'danger', 'screen-error', error.response.data.errors[i][0]
                                );
                            }
                        }
                    }
                    vm.loading = false;
                });
            }
        },
    },
    watch:{
        currency_id:function(res, ant){
            if (res != ant && !this.load_data_edit) {
                this.record_items             = [];

                this.base_budget_list_deleted = [];
                if (this.base_budget_list.length > 0) {
                    this.base_budget_list_deleted = this.base_budget_list;
                }
                this.base_budget_list         = [];

                this.sub_total                = 0;
                this.tax_value                = 0;
                this.total                    = 0;
            }else{
                this.load_data_edit = false;
            }
            if (res) {
                axios.get('/currencies/info/'+res).then(response=>{
                    this.record.currency = response.data.currency;
                })
            }
        },
        purchase_supplier_id:function(res) {
            if (res) {
                axios.get('/purchase/get-purchase-supplier-object/'+res).then(response=>{
                    this.record.purchase_supplier_object = response.data;
                    this.record.purchase_supplier_id = res;
                })
            }
        },
    },
    computed:{
        currency_symbol: function(){
            return (this.record.currency)?this.record.currency.symbol:'';
        },
        currency_decimal_places: function(){
            if (this.record.currency) {
                return this.record.currency.decimal_places;
            }
        },
        currency:function(){
            return (this.record.currency)?this.record.currency:null;
        },
        getRecordItems: function(){
            return this.record_items;
        }
    }
};
</script>
