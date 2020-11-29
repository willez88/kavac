<template>
    <section>
        <v-client-table :columns="columns" :data="records" :options="table_options">
            <div slot="init_date" slot-scope="props" class="text-center">
                {{ format_date(props.row.init_date) }}
            </div>
            <div slot="end_date" slot-scope="props" class="text-center">
                {{ format_date(props.row.end_date) }}
            </div>
            <div slot="active" slot-scope="props" class="text-center">
                <span class="badge badge-success" v-if="props.row.active">
                    <strong>PROCESADO</strong>
                </span>
                <span class="badge badge-danger" v-else>
                    <strong>NO PROCESADO</strong>
                </span>
            </div>
            <div slot="id" slot-scope="props" class="text-center">
                <div class="d-inline-flex">
                    
                    <purchase-plan-show :id="props.row.id" :route_show="'/purchase/purchase_plans/'+props.row.id" />
                    
                    <purchase-plan-start-diagnosis :id="props.row.id" :route_show="'/purchase/purchase_plans/'+props.row.id" 
                                        v-if="!props.row.active" />

                    <button @click="editForm(props.row.id)"
                            class="btn btn-warning btn-xs btn-icon btn-action"
                            title="Modificar registro"
                            data-toggle="tooltip"
                            >
                        <i class="fa fa-edit"></i>
                    </button>
                    <button @click="deleteRecord(props.index,'/purchase/purchase_plans')"
                            class="btn btn-danger btn-xs btn-icon btn-action" 
                            title="Eliminar registro" 
                            data-toggle="tooltip" 
                            >
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
                    'init_date',
                    'end_date',
                    'purchase_type.name',
                    'purchase_process.name',
                    'active',
                    'id'
                ],
            }
        },
        created(){
            this.table_options.headings = {
                'init_date': 'FECHA DE INICIO',
                'end_date': 'FECHA DE CULMINACIÓN',
                'purchase_type.name':'TIPO DE COMPRA',
                'purchase_process.name': 'PROCESO DE COMPRA',
                'active': 'ESTATUS',
                'id': 'ACCIÓN'
            };
            this.table_options.columnsClasses = {
                'init_date'    : 'col-xs-2 text-center',
                'end_date': 'col-xs-2 text-center',
                'purchase_type.name': 'col-xs-4',
                'purchase_process.name'    : 'col-xs-2',
                'active'    : 'col-xs-1',
                'id'      : 'col-xs-1'
            };
        },
        mounted(){
            this.records = this.record_list;
        }
    };
</script>
