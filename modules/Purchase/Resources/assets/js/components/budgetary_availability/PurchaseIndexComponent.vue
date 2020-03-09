<template>
    <section>
        <div class="row">
            <div class="col-12">
                <v-client-table :columns="columns" :data="records" :options="table_options">
                    <!-- <div slot="base_price" slot-scope="props">
                        <input type="number" v-model="record_items[props.index-1].unit_price" class="form-control"
                                :step="cualculateLimitDecimal()" @input="CalculateTot(record_items[props.index-1], props.index-1)">
                    </div>
                    <div slot="suppliers_price" slot-scope="props">
                        <h6 align="right">{{ CalculateQtyPrice(record_items[props.index-1].qty_price) }}</h6>
                    </div> -->
                </v-client-table>
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
        }
    },
    created(){
        this.table_options.headings = {
            'code':            'Código de requerimiento',
            'name':            'Nombre',
            'description':     'Descripción',
            'qty':             'Cantidad',
            'base_price':      'Precio Base',
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
    },
};
</script>
