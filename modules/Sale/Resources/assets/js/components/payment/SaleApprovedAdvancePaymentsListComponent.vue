<template>
<div>
    <v-client-table :columns="columns" :data="records" :options="table_options">

        <div slot="date_of_payment" slot-scope="props" class="text-center">
            {{ props.row.date_of_payment }}
        </div>
        <div slot="social_reason" slot-scope="props" class="text-justify">
            {{ props.row.social_reason }}
        </div>
        <div slot="payment_associated_products" slot-scope="props" class="text-center">
            {{ props.row.payment_associated_products }}
        </div>
        <div slot="payment_amount" slot-scope="props" class="text-justify">
            {{ props.row.payment_amount }}
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
                columns: ['date_of_payment', 'social_reason','payment_associated_products', 'payment_amount','reference_number','id'],
            }
        },
        created(){
            this.table_options.headings = {
                'date_of_payment': 'Fecha del pago',
                'social_reason': 'Nombre o razón social',
                'payment_associated_products': 'Productos o servicios asociados al pago',
                'payment_amount': 'Monto del pago',
                'reference_number': 'Número de referencia de la operación',
                'id': 'ACCIÓN'
            };
            this.table_options.sortable = ['date_of_payment', 'social_reason', 'payment_associated_products', 'payment_amount', 'reference_number'];
            this.table_options.filterable = ['date_of_payment', 'social_reason', 'payment_associated_products', 'payment_amount', 'reference_number'];
            this.table_options.columnsClasses = {
                'date_of_payment': 'col-xs-2',
                'social_reason': 'col-xs-2',
                'payment_associated_products': 'col-xs-2',
                'payment_amount': 'col-xs-2',
                'reference_number': 'col-xs-2',
                'id': 'col-xs-2'
            };

            EventBus.$on('list:conversions',(data)=>{
                this.records = data;
            });
        }
    };
</script>
