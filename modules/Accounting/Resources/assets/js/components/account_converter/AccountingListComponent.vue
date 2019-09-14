<template>
<div>
    <v-client-table :columns="columns" :data="records" :options="table_options">

        <div slot="codeBudget" slot-scope="props" class="text-center">
            {{ props.row.budget_account.group+'.'+
                props.row.budget_account.item+'.'+
                props.row.budget_account.generic+'.'+
                props.row.budget_account.specific+'.'+
                props.row.budget_account.subspecific }}
        </div>
        <div slot="budget_account" slot-scope="props" class="text-center">
            {{ props.row.budget_account.denomination }}
        </div>
        <div slot="codeAccounting" slot-scope="props" class="text-center">
            {{ props.row.accounting_account.group+'.'+
                props.row.accounting_account.subgroup+'.'+
                props.row.accounting_account.item+'.'+
                props.row.accounting_account.generic+'.'+
                props.row.accounting_account.specific+'.'+
                props.row.accounting_account.subspecific }}
        </div>
        <div slot="accounting_account" slot-scope="props" class="text-center">
            {{ props.row.accounting_account.denomination }}
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
                'codeBudget': 'CÓDIGO PRESUPUESTAL',
                'budget_account': 'DENOMINACIÓN',
                'codeAccounting': 'CÓDIGO PATRIMONIAL',
                'accounting_account': 'DENOMINACIÓN',
                'id': 'ACCIÓN'
            };
            this.table_options.sortable = [];
            this.table_options.filterable = ['budget_account', 'accounting_account'];


            EventBus.$on('list:conversions',(data)=>{
                this.records = data;
            });
        }
    };
</script>
