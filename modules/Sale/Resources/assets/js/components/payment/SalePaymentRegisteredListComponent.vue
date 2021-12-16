<template>
<div>
    <v-client-table :columns="columns" :data="records" :options="table_options">

        <div slot="payment_date" slot-scope="props" class="text-center">
            {{ record.payment_date }}
        </div>
        <div slot="social_reason" slot-scope="props" class="text-justify">
            {{ props.row.social_reason }}
        </div>
        <div slot="payment_associated_products" slot-scope="props" class="text-center">
            {{ props.row.payment_associated_products }}
        </div>
        <div slot="total_amount" slot-scope="props" class="text-justify">
            {{ props.row.total_amount }}
        </div>
         <div slot="reference_number" slot-scope="props" class="text-justify">
            {{ props.row.reference_number }}
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
                columns: ['payment_date', 'social_reason','payment_associated_products', 'total_amount','reference_number','id'],
            }
        },
        created(){
            this.table_options.headings = {
                'payment_date': 'Fecha del pago',
                'social_reason': 'Nombre o razón social',
                'payment_associated_products': 'Productos o servicios asociados al pago',
                'total_amount': 'Monto del pago',
                'reference_number': 'Número de referencia de la operación',
                'id': 'ACCIÓN'
            };
            this.table_options.sortable = ['payment_date', 'social_reason', 'payment_associated_products', 'total_amount', 'reference_number'];
            this.table_options.filterable = ['payment_date', 'social_reason', 'payment_associated_products', 'total_amount', 'reference_number'];
            this.table_options.columnsClasses = {
                'payment_date': 'col-xs-2',
                'social_reason': 'col-xs-2',
                'payment_associated_products': 'col-xs-2',
                'total_amount': 'col-xs-2',
                'reference_number': 'col-xs-2',
                'id': 'col-xs-2'
            };
        },
        mounted () {
            this.initRecords(this.route_list, '');
        },
        methods: {
            /**
             * Inicializa los datos del formulario
             *
             * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
             */
            reset() {

            },

            /**
             * Método reemplaza el metodo setDetails para usar la referencia del parent por defecto
             *
             * @method    setDetails
             *
             * @author     Daniel Contreras <dcontreras@cenditel.gob.ve>
             *
             * @param     string   ref       Identificador del componente
             * @param     integer  id        Identificador del registro seleccionado
             * @param     object  var_list  Objeto con las variables y valores a asignar en las variables del componente
             */
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
