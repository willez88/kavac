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
                <div class="form-group is-required">
                    <label class="control-label" for="currencies">Tipo de proveedor</label><br>
                    <div v-if="record.purchase_supplier_object">
                        <div v-if="record.purchase_supplier_object.type == 'S'"><strong>Servicios</strong></div>
                        <div v-else-if="record.purchase_supplier_object.type == 'O'"><strong>Obras</strong></div>
                        <div v-else-if="record.purchase_supplier_object.type == 'B'"><strong>Bienes</strong></div>
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
                <table class="table table-striped table-hover">
                    <thead>
                        <tr class="row">
                            <th tabindex="0" class="col-1" style="border: 1px solid #dee2e6; position: relative;">Código de requerimiento</th>
                            <th tabindex="0" class="col-3" style="border: 1px solid #dee2e6; position: relative;">Nombre</th>
                            <th tabindex="0" class="col-2" style="border: 1px solid #dee2e6; position: relative;">Cantidad</th>
                            <th tabindex="0" class="col-2" style="border: 1px solid #dee2e6; position: relative;">Unidad de medida</th>
                            <th tabindex="0" class="col-2" style="border: 1px solid #dee2e6; position: relative;">Precio Unitario sin IVA</th>
                            <th tabindex="0" class="col-2" style="border: 1px solid #dee2e6; position: relative;">cantidad * Precio unitario</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="varr in record_items" class="row">
                            <td style="border: 1px solid #dee2e6;" tabindex="0" class="col-1">
                                {{ varr.requirement_code }}
                            </td>
                            <td style="border: 1px solid #dee2e6;" tabindex="0" class="col-3">
                                {{ varr.name }}
                            </td>
                            <td style="border: 1px solid #dee2e6;" tabindex="0" class="col-2">
                                {{ varr.quantity }}
                            </td>
                            <td style="border: 1px solid #dee2e6;" tabindex="0" class="col-2">
                                {{ varr.measurement_unit.acronym }}
                            </td>
                            <td style="border: 1px solid #dee2e6;" tabindex="0" class="col-2 text-right">
                                {{ addDecimals(varr.unit_price) }}
                            </td>
                            <td style="border: 1px solid #dee2e6;" tabindex="0" class="col-2">
                                <h6 align="right">{{ CalculateQtyPrice(varr.qty_price) }}</h6>
                            </td>
                        </tr>
                        <tr class="row">
                            <td style="border: 1px solid #dee2e6;" tabindex="0" class="col-8"></td>
                            <td style="border: 1px solid #dee2e6;" tabindex="0" class="col-2">
                                <h6 align="right">SUB TOTAL {{ currency_symbol }}</h6>
                            </td>
                            <td style="border: 1px solid #dee2e6;" tabindex="0" class="col-2">
                                <h6 align="right">{{ sub_total.toFixed((record.currency)?currency_decimal_places:'') }}</h6>
                            </td>
                        </tr>
                        <tr class="row">
                            <td style="border: 1px solid #dee2e6;" tabindex="0" class="col-8"></td>
                            <td style="border: 1px solid #dee2e6;" tabindex="0" class="col-2">
                                <h6 align="right">{{ tax?tax.percentage:'' }} % IVA {{ currency_symbol }}</h6>
                            </td>
                            <td style="border: 1px solid #dee2e6;" tabindex="0" class="col-2">
                                <h6 align="right">{{ tax_value.toFixed((record.currency)?currency_decimal_places:'') }}</h6>
                            </td>
                        </tr>
                        <tr class="row">
                            <td style="border: 1px solid #dee2e6;" tabindex="0" class="col-8"></td>
                            <td style="border: 1px solid #dee2e6;" tabindex="0" class="col-2">
                                <h6 align="right">TOTAL {{ currency_symbol }}</h6>
                            </td>
                            <td style="border: 1px solid #dee2e6;" tabindex="0" class="col-2">
                                <h6 align="right">{{ (total).toFixed((record.currency)?currency_decimal_places:'') }}</h6>
                            </td>
                        </tr>
                    </tbody>
                </table>
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
                    purchase_supplier:null,
                    purchase_supplier_id:'',
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
                requirement_checked:[],
                requirement_list_deleted:[],
                sub_total:0,
                tax_value:0,
                total:0,
                currency_id:'',
                purchase_supplier_id:'',
                convertion_list:[],
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
                            );
                            $('#requirement_check_'+record.id+' input:checkbox').prop('checked',false);
                        }
                    }else{
                        this.convertion_list.push(response.data.record);
                        this.addToList(record)
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
                vm.loading = true;
                if (vm.requirement_edit) {
                    vm.record.toDelete = vm.toDelete;
                    axios.put('/purchase/purchase_order/'+vm.requirement_edit.id, vm.record).then(response=>{
                        vm.loading = false;
                        vm.showMessage('update');
                        setTimeout(function() {
                            location.href = '/purchase/purchase_order';
                        }, 2000);
                    }).catch(error=>{
                        vm.loading = false;
                        this.$refs.PurchaseOrderFormComponent.reset();
                        var  errors = [];
                        if (typeof(error.response) != 'undefined') {
                            for (var index in error.response.data.errors) {
                                if (error.response.data.errors[index]) {
                                    errors.push(error.response.data.errors[index][0]);
                                }
                            }
                        }
                        this.$refs.PurchaseOrderFormComponent.showAlertMessages(errors);
                    });
                }else{
                    axios.post('/purchase/purchase_order',vm.record).then(response=>{
                        vm.loading = false;
                        vm.showMessage('store');
                        setTimeout(function() {
                            location.href = '/purchase/purchase_order';
                        }, 2000);
                    }).catch(error=>{
                        vm.loading = false;
                        this.$refs.PurchaseOrderFormComponent.reset();
                        var errors = [];
                        if (typeof(error.response) != 'undefined') {
                            for (var index in error.response.data.errors) {
                                if (error.response.data.errors[index]) {
                                    errors.push(error.response.data.errors[index][0]);
                                }
                            }
                        }
                        this.$refs.PurchaseOrderFormComponent.showAlertMessages(errors);
                    });
                }
            },
        },
        watch:{
            currency_id:function(res){
                this.record_items             = [];
                this.requirement_list         = [];
                this.requirement_list_deleted = [];
                if (res) {
                    axios.get('/currencies/info/'+res).then(response=>{
                        this.record.currency = response.data.currency;
                    })
                }
            },
            purchase_supplier_id:function(res) {
                if (res) {
                    axios.get('/purchase/get-purchase-supplier-object/'+res).then(response=>{
                        console.log(response.data)
                        this.record.purchase_supplier_object = response.data;
                        this.record.purchase_supplier_id = response.data.id;
                    })
                }
            }
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
