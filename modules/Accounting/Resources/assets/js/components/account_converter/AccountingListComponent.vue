<template>
<div>
    <v-client-table :columns="columns" :data="records" :options="table_options">

        <div slot="codeBudget" slot-scope="props" class="text-center">
            {{ props.row.codeBudget }}
        </div>
        <div slot="budget_account" slot-scope="props" class="text-justify">
            {{ props.row.budget_account }}
        </div>
        <div slot="codeAccounting" slot-scope="props" class="text-center">
            {{ props.row.codeAccounting }}
        </div>
        <div slot="accounting_account" slot-scope="props" class="text-justify">
            {{ props.row.accounting_account }}
        </div>
        <div slot="id" slot-scope="props" class="text-center">
            <button class="btn btn-warning btn-xs btn-icon btn-action"
                    title="Modificar registro"
                    data-toggle="tooltip"
                    v-on:click="editForm(props.row.id)">
                <i class="fa fa-edit"></i>
            </button>
            <button class="btn btn-danger btn-xs btn-icon btn-action"
                    title="Eliminar registro de la lista de cuentas a convertir"
                    data-toggle="tooltip"
                    v-on:click="deleteRecord(props.index,'/accounting/converter')">
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
                columns: ['codeBudget', 'budget_account','codeAccounting', 'accounting_account','id'],
            }
        },
        created(){
            this.table_options.headings = {
                'codeBudget': 'CÓDIGO PRESUPUESTO',
                'budget_account': 'DENOMINACIÓN',
                'codeAccounting': 'CÓDIGO PATRIMONIAL',
                'accounting_account': 'DENOMINACIÓN',
                'id': 'ACCIÓN'
            };
            this.table_options.sortable = ['codeBudget', 'budget_account', 'codeAccounting', 'accounting_account'];
            this.table_options.filterable = ['codeBudget', 'budget_account', 'codeAccounting', 'accounting_account'];
            this.table_options.columnsClasses = {
                'codeBudget': 'col-xs-2',
                'budget_account': 'col-xs-3',
                'codeAccounting': 'col-xs-2',
                'accounting_account': 'col-xs-3',
                'id': 'col-xs-2'
            };

            EventBus.$on('list:conversions',(data)=>{
                this.records = data;
            });
        }
    };
</script>
