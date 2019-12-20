<template>
    <div class="form-horizontal">
        <div class="card-body">
            <v-client-table :columns="columns" :data="records" :options="table_options" class="row">
                <div slot="id" slot-scope="props" class="text-center">
                    <div class="d-inline-flex">
                        <button class="btn btn-warning btn-xs btn-icon btn-action"
                                title="Modificar registro"
                                data-toggle="tooltip"
                                v-on:click="editForm(props.row.id)">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button @click="deleteRecord(props.index,'/purchase/requirements')"
                                class="btn btn-danger btn-xs btn-icon btn-action" 
                                title="Eliminar registro" data-toggle="tooltip" 
                                type="button">
                            <i class="fa fa-trash-o"></i>
                        </button>
                    </div>
                </div>
            </v-client-table>
        </div>
    </div>

</template>
<script>
    export default{
        props:{
            requirements:{
                type:Array,
                default: function() {
                    return [];
                }
            },
        },
        data(){
            return {
                records:[],
                columns: [  'code',
                            'description',
                            'fiscal_year.year',
                            'contrating_department.name',
                            'user_department.name',
                            'purchase_supplier_type.name',
                            'id'
                        ],
            }
        },
        created(){
            this.table_options.headings = {
                'code': 'Código',
                'description': 'Descripción',
                'fiscal_year.year':'Año fiscal',
                'contrating_department.name': 'Departamento contatante',
                'user_department.name': 'Departamento Usuario',
                'purchase_supplier_type.name': 'Tipo de Proveedor',
                'id': 'ACCIÓN'
            };
            this.table_options.columnsClasses = {
                'code'    : 'col-xs-1',
                'description': 'col-xs-3',
                'fiscal_year.year': 'col-xs-1',
                'contrating_department.name'    : 'col-xs-2',
                'user_department.name': 'col-xs-2',
                'purchase_supplier_type.name': 'col-xs-2',
                'id'      : 'col-xs-1'
            };
        },
        mounted(){
            this.records = this.requirements;  
        },
    };
</script>
