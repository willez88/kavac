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
            <div class="col-12">
                <v-client-table :columns="columns" :data="requirements" :options="table_options">
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
                                         :checked="indexOf(requirement_list, props.row.id, true)"
                                         @change="requirementCheck(props.row)">
                                    <i slot="extra" class="icon fa fa-check"></i>
                                </p-check>
                            </label>
                        </div>
                    </div>
                </v-client-table>
            </div>
            <div class="col-12">
                <div class="VueTables VueTables--client">
                    <div class="table-responsive">
                        <table class="VueTables__table table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th tabindex="0" width="8%" style="border: 1px solid #dee2e6; position: relative;">Código de requerimiento</th>
                                    <th tabindex="0" width="24%" style="border: 1px solid #dee2e6; position: relative;">Nombre</th>
                                    <th tabindex="0" width="16%" style="border: 1px solid #dee2e6; position: relative;">Cantidad</th>
                                    <th tabindex="0" width="16%" style="border: 1px solid #dee2e6; position: relative;">Unidad de medida</th>
                                    <th tabindex="0" width="16%" style="border: 1px solid #dee2e6; position: relative;">Precio Unitario sin IVA</th>
                                    <th tabindex="0" width="20%" style="border: 1px solid #dee2e6; position: relative;">cantidad * Precio unitario</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="varr in record_items">
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" width="8%" class="text-center">
                                        {{ varr.requirement_code }}
                                    </td>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" width="24%">
                                        {{ varr.name }}
                                    </td>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" width="16%">
                                        {{ varr.quantity }}
                                    </td>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" width="16%">
                                        {{ varr.measurement_unit.acronym }}
                                    </td>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" width="16%">
                                        <h6 align="right">{{ addDecimals(varr.unit_price) }}</h6>
                                    </td>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" width="20%">
                                        <h6 align="right">{{ CalculateQtyPrice(varr.qty_price) }}</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" width="8%"></td>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" width="24%"></td>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" width="16%"></td>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" width="16%"></td>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" width="16%">
                                        <h6 align="right">SUB TOTAL {{ currency_symbol }}</h6>
                                    </td>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" width="20%">
                                        <h6 align="right">{{ sub_total.toFixed((record.currency)?currency_decimal_places:'') }}</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" width="8%"></td>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" width="24%"></td>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" width="16%"></td>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" width="16%"></td>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" width="16%">
                                        <h6 align="right">{{ tax?tax.percentage:'' }} % IVA {{ currency_symbol }}</h6>
                                    </td>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" width="20%">
                                        <h6 align="right">{{ tax_value.toFixed((record.currency)?currency_decimal_places:'') }}</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" width="8%"></td>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" width="24%"></td>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" width="16%"></td>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" width="16%"></td>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" width="16%">
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

        
        <div class="modal fade text-left" tabindex="-1" role="dialog" id="modal-upload-file">
            <div class="modal-dialog vue-crud" role="document" style="min-width: 50% !important;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="reset" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h6>
                            <i class="fa fa-list inline-block"></i>
                            Cargar archivo proforma / cotización
                        </h6>
                    </div>
                    <!-- Fromulario -->
                    <div class="modal-body">
                        <div>
                            <label class="custom-control">
                                Cargar archivo
                                <button type="button" data-toggle="tooltip"
                                        class="btn btn-sm btn-info btn-import"
                                        title="Presione para subir el archivo del documento."
                                        @click="setFile('file_document')">
                                    <i class="fa fa-upload"></i>
                                </button>
                                <input type="file" 
                                        id="file_document" 
                                        @change="uploadFile('file_document')"
                                        style="display:none;">
                            </label>
                        </div>
                    </div>
                </div>
            </div>
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
        requirements:{
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
            records:[],
            record:{
                purchase_supplier_id:'',
                purchase_supplier_object:'',
                currency:null,
            },
            record_items:[],
            columns: [  'code',
                        'description',
                        'fiscal_year.year',
                        'contrating_department.name',
                        'user_department.name',
                        'purchase_supplier_type.name',
                        'purchase_base_budget.currency.name',
                        'id'
                    ],
            requirement_list:[],
            requirement_list_deleted:[],
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
            'code': 'Código',
            'description': 'Descripción',
            'fiscal_year.year':'Año fiscal',
            'contrating_department.name': 'Departamento contatante',
            'user_department.name': 'Departamento Usuario',
            'purchase_supplier_type.name': 'Tipo de Proveedor',
            'purchase_base_budget.currency.name': 'Moneda',
            'id': 'ACCIÓN'
        };
        this.table_options.columnsClasses = {
            'code'    : 'col-xs-1 text-center',
            'description': 'col-xs-2',
            'fiscal_year.year': 'col-xs-1 text-center',
            'contrating_department.name'    : 'col-xs-2',
            'user_department.name': 'col-xs-2',
            'purchase_supplier_type.name': 'col-xs-2',
            'purchase_base_budget.currency.name': 'col-xs-1',
            'id'      : 'col-xs-1'
        };
    },
    mounted(){
        this.records = this.requirements;
        if (this.record_edit) {
            this.load_data_edit = true;
            this.currency_id = this.record_edit.currency_id;
            this.purchase_supplier_id = this.record_edit.purchase_supplier_id;

            for (var i = 0; i < this.record_edit.purchase_requirement.length; i++) {
                this.addToList(this.record_edit.purchase_requirement[i]);
            }
        }
    },
    methods:{

        reset(){
            this.record_items             = [];
            this.requirement_list         = [];
            this.requirement_list_deleted = [];
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

        requirementCheck(record){
            axios.get('/purchase/get-convertion/'+this.currency_id+'/'+record.purchase_base_budget.currency_id)
            .then(response=>{
                if (record.purchase_base_budget.currency_id != this.currency_id && !response.data.record) {

                    if ($('#requirement_check_'+record.id+' input:checkbox').prop('checked')) {
                        this.showMessage(
                            'custom', 'Error', 'danger', 'screen-error',
                            "Imposible realizar la conversión de "+this.record.currency.name
                            +" a "+record.purchase_base_budget.currency.name
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

        addToList:function(record) {
            var pos = this.indexOf(this.requirement_list, record.id);
                // se agregan a la lista a guardar
                if (pos == -1) {
                    for (var i = 0; i < record.purchase_requirement_items.length; i++) {
                        record.purchase_requirement_items[i].requirement_code = record.code;
                    }

                    // saca de la lista de registros eliminar
                    pos = this.indexOf(this.requirement_list_deleted, record.id);
                    if (pos != -1) {
                        this.requirement_list_deleted.splice(pos,1);
                    }

                    this.requirement_list.push(record);
                    this.record_items = this.record_items.concat(record.purchase_requirement_items);
                }else{
                    // se sacan de la lista a guardar
                    var record_copy = this.requirement_list.splice(pos,1)[0];
                    var pos = this.indexOf(this.requirement_list_deleted, record_copy.id); 

                    // agrega a la lista de registros a eliminar
                    if (pos == -1) {
                        this.requirement_list_deleted.push(record_copy);
                    }

                    for (var i = 0; i < record.purchase_requirement_items.length; i++) {
                        for (var x = 0; x < this.record_items.length; x++) {
                            if (this.record_items[x].id == record.purchase_requirement_items[i].id) {
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
        * Calcula el total del debe y haber del asiento contable
        *
        * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
        */
        CalculateTot(){
            this.sub_total = 0;
            this.tax_value = 0;
            for (var i = this.record_items.length - 1; i >= 0; i--) {
                var r = this.record_items[i];
                r['qty_price'] = r.quantity * r.unit_price;
                this.sub_total += r['qty_price'];
            }
            this.tax_value = this.sub_total * (parseFloat(this.tax.percentage)/100);
            this.total = this.sub_total + this.tax_value;
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
            const vm = this;
            vm.record.products = vm.record_products;

            $("#modal-upload-file").modal("show");
        },

        uploadFile(id){

            /** Se obtiene y da formato para enviar el archivo a la ruta */
            let vm = this;
            var formData = new FormData();
            var inputFile = document.querySelector('#'+id);
            formData.append("file", inputFile.files[0]);
            formData.append("purchase_supplier_id", this.purchase_supplier_id);
            formData.append("currency_id", this.currency_id);
            formData.append("requirement_list", JSON.stringify(this.requirement_list) );
            formData.append("requirement_list_deleted", JSON.stringify(this.requirement_list_deleted));
            // vm.loading = true;
             
            if (!this.record_edit) {
                axios.post('/purchase/purchase_order', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(response => {
                    vm.showMessage('store');
                    vm.loading = false;

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
                axios.post('/purchase/purchase_order/'+this.record_edit.id, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(response => {
                    vm.showMessage('update');
                    vm.loading = false;

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

                this.requirement_list_deleted = [];
                if (this.requirement_list.length > 0) {
                    this.requirement_list_deleted = this.requirement_list;    
                }
                this.requirement_list         = [];

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
    }
};
</script>
