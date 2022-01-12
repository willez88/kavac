<template>
<div>

    <v-client-table :columns="columns" :data="records" :options="table_options">
        <div slot="sale_goods_name" slot-scope="props" class="text-center">
            <div v-for="sale_goods in props.row.sale_goods">
                <p v-for="sale_good in sale_goods" >
                    {{ sale_good.name }}
                </p>
            </div>
        </div>
        <div slot="id" slot-scope="props" class="text-center">
            <button class="btn btn-warning btn-xs btn-icon btn-action"
                    title="Modificar registro"
                    data-toggle="tooltip"
                    v-on:click="editForm(props.row.id)">
                <i class="fa fa-edit"></i>
            </button>
            <button class="btn btn-danger btn-xs btn-icon btn-action"
                    title="Eliminar registro"
                    data-toggle="tooltip"
                    v-on:click="deleteRecord(props.index,'/sale/payment')">
                <i class="fa fa-trash-o"></i>
            </button>
        </div>
    </v-client-table>
</div>
</template>
<script>
    export default{
        data(){
            return{
                records:[],
                columns: ['payment_date', 'name','sale_goods_name', 'total_amount','reference_number','id'],
            }
        },
        created(){
            this.table_options.headings = {
                'payment_date': 'Fecha del pago',
                'name': 'Nombre o razón social',
                'sale_goods_name': 'Productos o servicios asociados al pago',
                'total_amount': 'Monto del pago',
                'reference_number': 'Número de referencia de la operación',
                'id': 'ACCIÓN'
            };
            this.table_options.sortable = ['payment_date', 'name', 'sale_goods_name', 'total_amount', 'reference_number'];
            this.table_options.filterable = ['payment_date', 'name', 'sale_goods_name', 'total_amount', 'reference_number'];
            this.table_options.columnsClasses = {
                'payment_date': 'col-xs-2',
                'name': 'col-xs-2',
                'sale_goods_name': 'col-xs-2',
                'total_amount': 'col-xs-2',
                'reference_number': 'col-xs-2',
                'id': 'col-xs-2'
            };
        },
        mounted () {
            this.initRecords(this.route_list, '');
        },
        methods: {
            reset() {
            },
            setDetails(ref, id, modal ,var_list = null) {
                const vm = this;
                if (var_list) {
                    for(var i in var_list){
                        vm.$parent.$refs[ref][i] = var_list[i];
                    }
                }else{
                    vm.$parent.$refs[ref].record = vm.$refs.tableResults.data.filter(r => {
                        return r.id === id;
                    })[0];
                }
                vm.$parent.$refs[ref].id = id;

                $(`#${modal}`).modal('show');
                document.getElementById("info_general").click();
            },
        }
    };
</script>
