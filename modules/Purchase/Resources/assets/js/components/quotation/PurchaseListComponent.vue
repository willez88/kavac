<template>
    <section>
        <v-client-table :columns="columns" :data="records" :options="table_options">
            <div slot="purchase_supplier.purchase_supplier_object" slot-scope="props" class="text-center">
                <div v-if="props.row.purchase_supplier.purchase_supplier_object">
                        <div v-if="props.row.purchase_supplier.purchase_supplier_object.type == 'S'">
                            <strong>Servicios / {{ props.row.purchase_supplier.purchase_supplier_object.name }}</strong>
                        </div>
                        <div v-else-if="props.row.purchase_supplier.purchase_supplier_object.type == 'O'">
                            <strong>Obras / {{ props.row.purchase_supplier.purchase_supplier_object.name }}</strong>
                        </div>
                        <div v-else-if="props.row.purchase_supplier.purchase_supplier_object.type == 'B'">
                            <strong>Bienes / {{ props.row.purchase_supplier.purchase_supplier_object.name }}</strong>
                        </div>
                    </div>
            </div>
            <div slot="id" slot-scope="props" class="text-center">
                <div class="d-inline-flex">
                    
                    <!-- <purchase-plan-show :id="props.row.id" :route_show="'/purchase/purchase_order/'+props.row.id" /> -->

                    <button @click="editForm(props.row.id)"
                            class="btn btn-warning btn-xs btn-icon btn-action"
                            title="Modificar registro"
                            data-toggle="tooltip">
                        <i class="fa fa-edit"></i>
                    </button>
                    <button @click="deleteRecord(props.index,'/purchase/purchase_order')"
                            class="btn btn-danger btn-xs btn-icon btn-action" 
                            title="Eliminar registro" 
                            data-toggle="tooltip" >
                        <i class="fa fa-trash-o"></i>
                    </button>
                </div>
            </div>
        </v-client-table>
        <hr>
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
        },
        data(){
            return {
                columns: [
                            'purchase_supplier.name',
                            'purchase_supplier.purchase_supplier_object',
                            'currency.name',
                            'id'
                        ],
            }
        },
        created(){
            this.table_options.headings = {
                'purchase_supplier.name': 'Proveedor',
                'purchase_supplier.purchase_supplier_object': 'tipo de proveedor',
                'currency.name': 'tipo de moneda',
                'id': 'ACCIÓN'
            };
            this.table_options.columnsClasses = {
                'purchase_supplier.name'    : 'col-xs-3',
                'purchase_supplier.purchase_supplier_object': 'col-xs-5 text-center',
                'currency.name': 'col-xs-3 text-center',
                'id'      : 'col-xs-1'
            };
        },
        mounted(){
            // 
        }
    };
</script>
