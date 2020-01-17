<template>
    <div>
        <button @click="addRecord('show_entry_'+id, route_show, $event)"
                class="btn btn-info btn-xs btn-icon btn-action" 
                title="Visualizar requerimiento" 
                data-toggle="tooltip" >
            <i class="fa fa-eye"></i>
        </button>

        <div class="modal fade text-left" tabindex="-1" role="dialog" :id="'show_entry_'+id">
            <div class="modal-dialog vue-crud" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="reset" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h6>
                            <i class="fa fa-list inline-block"></i>
                            Asiento contable
                        </h6>
                    </div>
                    <!-- Fromulario -->
                    <div class="modal-body">
                        <accounting-show-errors ref="accountingAccountForm" />
                        <h6>INFORMACIÓN DEL ASIENTO CONTABLE</h6>
                        <br>
                        <div class="row">
                            <div class="col-2"><strong>Código:</strong> {{ records.reference }}</div>
                            <div class="col-2"><strong>Fecha:</strong> {{ format_date(records.from_date) }}</div>
                            <div class="col-2"><strong>Estatus:</strong>
                                <span class="badge badge-success" v-if="records.approved"> <strong>APROBADO </strong></span>
                                <span class="badge badge-danger"  v-if="!records.approved">   <strong>NO APROBADO</strong></span>
                            </div>
                            <div class="col-3"><strong>Categoria:</strong> {{ accounting_entry_category }}</div>
                            <div class="col-3"><strong>Tipo de moneda:</strong> {{ currency }}</div>
                            <div class="col-4"><strong>Institición:</strong> {{ institution }}</div>
                            <div class="col-4"><strong>Descripción ó concepto:</strong> {{ concept }}</div>
                            <div class="col-4"><strong>Observaciones:</strong> {{ observations }}</div>
                        </div>
                        <hr>
                        <v-client-table :columns="columns" :data="accounting_accounts" :options="table_options">
                            <div slot="debit" slot-scope="props" class="text-center">
                                {{ props.debit.toFixed(currency_decimal_places) }}
                            </div>
                            <div slot="assets" slot-scope="props" class="text-center">
                                {{ props.debit.toFixed(currency_decimal_places) }}
                            </div>
                        </v-client-table>
                        
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
export default{
    props:['id'],
    data(){
        return{
            records:[],
            columns: ['account.denomination','debit','assets'],
        }
    },
    created(){
        this.table_options.headings = {
                'account.denomination': 'Denominación',
                'debit': 'Debe',
                'assets': 'Haber',
            };
        this.table_options.columnsClasses = {
            'account.denomination': 'col-xs-8',
            'debit': 'col-xs-2',
            'assets': 'col-xs-2',
        };
    },
    mounted(){
        
    },
    methods:{

        /**
         * Método que borra todos los datos del formulario
         *
         * @author  Juan Rosas <jrosas@cenditel.gob.ve> | <juan.rosasr01@gmail.com>
         */
        reset() {
            
        },
    },
    computed:{
        reference: function(){
            if (this.records.reference) {
                return this.records.reference;
            }
        },
        accounting_entry_category: function(){
            if (this.records.accounting_entry_category) {
                return this.records.accounting_entry_category.name;
            }
        },
        institution: function(){
            if (this.records.institution) {
                return this.records.institution.name;
            }
        },
        currency: function(){
            if (this.records.currency) {
                return this.records.currency.name;
            }
        },
        currency_decimal_places: function(){
            if (this.records.currency) {
                return this.records.currency.decimal_places;
            }
        },
        currency_symbol: function(){
            if (this.records.currency) {
                return this.records.currency.symbol;
            }
        },
        concept: function(){
            if (this.records.concept) {
                return this.records.concept;
            }
        },
        observations: function(){
            if (this.records.observations) {
                return this.records.observations;
            }
            return [];
        },
        accounting_accounts: function(){
            if (this.records.accounting_accounts) {
                return this.records.accounting_accounts;
            }
            return [];
        },
        
    }
};
</script>
