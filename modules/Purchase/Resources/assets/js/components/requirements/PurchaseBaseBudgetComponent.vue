<template>
    <section>
        <v-client-table :columns="columns" :data="records" :options="table_options">
            <div slot="created_at" slot-scope="props" class="text-center">
                <div align="center">
                    {{ format_date(props.row.created_at) }}
                </div>
            </div>
            <div slot="id" slot-scope="props" class="text-center">
                <div class="d-inline-flex">
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
        props:{
            record_list:{
                type:Array,
                default: function() {
                    return [];
                }
            },
        },
        data(){
            return {
                records:[],
                columns: [  
                            'created_at',
                            'currency.name',
                            'id'
                        ],
            }
        },
        created(){
            this.table_options.headings = {
                'created_at': 'Fecha',
                'currency.name': 'Tipo de moneda',
                'id': 'ACCIÓN'
            };
            this.table_options.columnsClasses = {
                'created_at'    : 'col-xs-2',
                'currency_id': 'col-xs-8',
                'id'      : 'col-xs-2'
            };
        },
        mounted(){
            this.records = this.record_list;
        }
    };
</script>
