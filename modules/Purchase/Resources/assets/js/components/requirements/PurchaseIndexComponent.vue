<template>
    <section>
        <v-client-table :columns="columns" :data="records" :options="table_options">
            <div slot="purchase_supplier_object" slot-scope="props" class="text-center">
                <div class="d-inline-flex">

                    <strong v-if="props.row.purchase_supplier_object.type == 'B'">
                        Bienes
                    </strong>
                    <strong v-else-if="props.row.purchase_supplier_object.type == 'O'">
                        Obras
                    </strong>
                    <strong v-else-if="props.row.purchase_supplier_object.type == 'S'">
                        Servicios
                    </strong>
                     - {{ props.row.purchase_supplier_object.name }}
                </div>
            </div>
            <div slot="requirement_status" slot-scope="props" class="text-center">
                <div class="d-inline-flex">
                    <span class="badge badge-danger"  v-show="props.row.requirement_status == 'WAIT'">     <strong>EN ESPERA</strong></span>
                    <span class="badge badge-info"    v-show="props.row.requirement_status == 'PROCESSED'"><strong>PROCESADO</strong></span>
                    <span class="badge badge-success" v-show="props.row.requirement_status == 'BOUGHT'">   <strong>COMPRADO </strong></span>
                </div>
            </div>
            <div slot="id" slot-scope="props" class="text-center">
                <div class="d-inline-flex">
                    <purchase-requirements-show :id="props.row.id" :route_show="'/purchase/requirements/'+props.row.id" />
                    <a class="btn btn-primary btn-xs btn-icon"
                            :href="'/purchase/requirements/pdf/'+props.row.id"
                            title="Imprimir Registro"
                            data-toggle="tooltip"
                            target="_blank">
                            <i class="fa fa-print" style="text-align: center;"></i>
                    </a>
                    <button v-if="props.row.requirement_status == 'WAIT'"
                            @click="editForm(props.row.id)"
                            class="btn btn-warning btn-xs btn-icon btn-action"
                            title="Modificar registro"
                            data-toggle="tooltip">
                        <i class="fa fa-edit"></i>
                    </button>
                    <button v-if="props.row.requirement_status == 'WAIT'"
                            @click="deleteRecord(props.index,'/purchase/requirements')"
                            class="btn btn-danger btn-xs btn-icon btn-action" 
                            title="Eliminar registro" 
                            data-toggle="tooltip" >
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
                columns: [  'code',
                            'description',
                            'fiscal_year.year',
                            'contrating_department.name',
                            'user_department.name',
                            'purchase_supplier_object',
                            'requirement_status',
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
                'purchase_supplier_object': 'Tipo',
                'requirement_status': 'Estado del requerimiento',
                'id': 'ACCIÓN'
            };
            this.table_options.columnsClasses = {
                'code'    : 'col-xs-1',
                'description': 'col-xs-2',
                'fiscal_year.year': 'col-xs-1',
                'contrating_department.name'    : 'col-xs-2',
                'user_department.name': 'col-xs-2',
                'purchase_supplier_object': 'col-xs-2',
                'requirement_status': 'col-xs-1',
                'id'      : 'col-xs-1'
            };
        },
        mounted(){
            this.records = this.record_list;
        }
    };
</script>
