<template>
    <section>
        <v-client-table :columns="columns" :data="records" :options="table_options">
            <div slot="created_at" slot-scope="props" class="text-center">
                <div align="center">
                    {{ format_date(props.row.created_at) }}
                </div>
            </div>
            <div slot="currency.name" slot-scope="props">
                <div align="center">
                    <h6 v-if="props.row.currency">
                        {{ props.row.currency.symbol }} - {{ props.row.currency.name }}
                    </h6>
                    <h6 v-else>
                        Tipo de moneda no asigando
                    </h6>
                </div>
            </div>
            <div slot="status" slot-scope="props">
                <div class="d-inline-flex">
                    <span class="badge badge-danger"  v-show="props.row.status == 'WAIT_QUOTATION'">
                        <strong>EN ESPERA DE COTIZACIÓN</strong>
                    </span>
                    <span class="badge badge-info"    v-show="props.row.status == 'QUOTED'">
                        <strong>COTIZADO</strong>
                    </span>
                    <span class="badge badge-success" v-show="props.row.status == 'BOUGHT'">
                        <strong>COMPRADO </strong>
                    </span>
                </div>
            </div>
            <div slot="id" slot-scope="props" class="text-center">
                <div class="d-inline-flex">
                    <purchase-base-budget-show :id="props.row.id" :route_show="'/purchase/base_budget/'+props.row.id" />
                    <button class="btn btn-warning btn-xs btn-icon btn-action"
                            title="Modificar registro"
                            data-toggle="tooltip"
                            v-on:click="editForm(props.row.id)">
                        <i class="fa fa-edit"></i>
                    </button>
                    <button @click="deleteRecord(props.index,'/purchase/base_budget')"
                            class="btn btn-danger btn-xs btn-icon btn-action" 
                            title="Eliminar registro" data-toggle="tooltip" 
                            type="button">
                        <i class="fa fa-trash-o"></i>
                    </button>
                </div>
            </div>
        </v-client-table>
    </section>

</template>
<script>
    export default{
        data(){
            return {
                records:[],
                columns: [  
                            'created_at',
                            'currency.name',
                            'status',
                            'id'
                        ],
            }
        },
        created(){
            this.table_options.headings = {
                'created_at': 'Fecha',
                'currency.name': 'Tipo de moneda',
                'status':'Estatus',
                'id': 'ACCIÓN'
            };
            this.table_options.columnsClasses = {
                'created_at'    : 'col-xs-2',
                'currency.name': 'col-xs-6 text-center',
                'status':'col-xs-2 text-center',
                'id'      : 'col-xs-2'
            };
        },
        mounted(){
            axios.get('/purchase/base_budget').then(response => {
                this.records = response.data.records;
            });
        }
    };
</script>
