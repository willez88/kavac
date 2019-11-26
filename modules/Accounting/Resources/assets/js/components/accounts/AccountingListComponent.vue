<template>
    <v-client-table :columns="columns" :data="accRecords" :options="table_options">
        <div slot="status" slot-scope="props" class="text-center">
            <div v-if="props.row.active">
                <span class="badge badge-success"><strong>Activa</strong></span>
            </div>
            <div v-else>
                <span class="badge badge-warning"><strong>Inactiva</strong></span>
            </div>
        </div>
        <div slot="id" slot-scope="props" class="text-center">

            <button @click="loadData(props.row)"
                    class="btn btn-warning btn-xs btn-icon btn-action" 
                    title="Modificar registro" data-toggle="tooltip">
                <i class="fa fa-edit"></i>
            </button>
            <button @click="deleteRecord(props.index,'/accounting/accounts')" 
                    class="btn btn-danger btn-xs btn-icon btn-action" 
                    title="Eliminar registro" data-toggle="tooltip">
                <i class="fa fa-trash-o"></i>
            </button>
        </div>
    </v-client-table>
</template>

<script>
    export default {
        props:{
            records:{
                type:Array,
                default: []
            },
        },
        data(){
            return {
                accRecords: [],
                columns: ['code', 'denomination', 'status', 'id']
            }
        },
        created() {
            this.table_options.headings = {
                'code': 'CÓDIGO',
                'denomination': 'DENOMINACIÓN',
                'status': 'ESTADO DE LA CUENTA',
                'id': 'ACCIÓN'
            };
            this.table_options.sortable   = ['code', 'denomination'];
            this.table_options.filterable = ['code', 'denomination'];
            this.table_options.columnsClasses = {
                'code': 'col-xs-1',
                'denomination': 'col-xs-7',
                'status': 'col-xs-2',
                'id': 'col-xs-2'
            };
        },
        methods:{
            loadData:function(data) {
                EventBus.$emit('load:data-account-form', data);
            }
        },
        watch:{
            records:function(res){
                this.accRecords = res;
            }
        }
    };
</script>
