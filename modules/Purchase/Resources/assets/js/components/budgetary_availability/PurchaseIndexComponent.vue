<template>
    <section>
        <div class="row">
            <div class="col-12">
                <v-client-table :columns="columns" :data="records" :options="table_options">
                    <div slot="base_price" slot-scope="props">
                        <h6 align="right"> {{ addDecimals(props.row.base_price) }} </h6>
                    </div>
                    <div slot="suppliers_price" slot-scope="props">
                        <h6 align="right"> {{ addDecimals(props.row.suppliers_price) }} </h6>
                    </div>
                </v-client-table>
            </div>
            <div class="col-12">
                <div class="form-horizontal">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <div class="form-group is-required">
                                    <label class="control-label" for="budget_item_id">Partida presupuestaria</label><br>
                                    <select2 :options="budget_items" id="budget_item_id" v-model="budget_item_id"></select2>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-info btn-sm"
                                    title="Consultar disponibilidad presupuestaria"
                                    :disabled="(budget_item_id)?false:true" 
                                    data-toggle="tooltip"
                                    @click="getBudgetAvailable()">
                                    Consultar
                                <i class="fa fa-search"></i>
                            </button>
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
        records:{
            type:Array,
            default: function() {
                return [];
            }
        },
        currency:{
            type:Object,
            default: function() {
                return null;
            }
        },
        supplier:{
            type:Object,
            default: function() {
                return null;
            }
        },
        budget_items:{
            type:Array,
            default: function(){
                return [{'id':'','text':'Seleccione...'}];
            }
        }
    },
    data(){
        return{
            columns: [  
                        'code',
                        'name',
                        'description',
                        'qty',
                        'base_price',
                        'suppliers_price',
                    ],
            budget_item_id:'',
            budget_available:0,
        }
    },
    created(){
        this.table_options.headings = {
            'code':            'Código de requerimiento',
            'name':            'Nombre',
            'description':     'Descripción',
            'qty':             'Cantidad',
            'base_price':      'Precio base',
            'suppliers_price': 'Precio del proveedor',
        };

        this.table_options.columnsClasses = {
            'code':            'col-xs-1 text-center',
            'name':            'col-xs-2',
            'description':     'col-xs-2',
            'qty':             'col-xs-1',
            'base_price':      'col-xs-2',
            'suppliers_price': 'col-xs-2',
        };

        this.table_options.filterable = ['code', 'name', 'description', 'qty'];
    },
    methods:{
        CalculateQtyPrice(qty_price){
            return (qty_price)?(qty_price).toFixed((this.currency)?this.currency.decimal_places:''):0;
        },

        addDecimals(value){
            return parseFloat(value).toFixed(this.currency.decimal_places);
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

        /**
        * [CalculateTot Calcula el total del debe y haber del asiento contable]
        * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
        * @param  {[type]} r   [información del registro]
        * @param  {[type]} pos [posición del registro]
        */
        CalculateTot(item, pos){
            const vm = this;

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

        /**
         * [getBudgetAvailable Consulta el saldo de la partida presupuestaria]
         * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
         * @return {[type]} [description]
         */
        getBudgetAvailable(){
            this.budget_available = 10000;

            // ---------------------------------------------------------
            // se consultara el saldo disponible de la cuenta
            // ---------------------------------------------------------
            // axiox.get('/budget/getBudgetAvailable'+this.budget_item_id).then(response=>{
            //     this.budget_available = response.data.balance;
            // });
            // ---------------------------------------------------------
        }
    }
};
</script>
