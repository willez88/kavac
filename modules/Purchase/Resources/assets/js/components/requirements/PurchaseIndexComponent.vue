<template>
    <section>
        <div class="form-horizontal">
            <div class="card-body">
                <v-client-table :columns="columns" :data="records" :options="table_options" class="row">
                    <div slot="requirement_status" slot-scope="props" class="text-center">
                        <div class="d-inline-flex">
                            <span class="badge badge-danger"  v-show="props.row.requirement_status == 'WAIT'">     <strong>EN ESPERA</strong></span>
                            <span class="badge badge-info"    v-show="props.row.requirement_status == 'PROCESSED'"><strong>PRECESADO</strong></span>
                            <span class="badge badge-success" v-show="props.row.requirement_status == 'BOUGHT'">   <strong>COMPRADO </strong></span>
                        </div>
                    </div>
                    <div slot="id" slot-scope="props" class="text-center">
                        <div class="d-inline-flex" v-if="add_buttons_action == 'true'">
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
                        <div class="feature-list-content-left mr-2" v-else>
                            <label class="custom-control custom-checkbox">
                                <p-check class="p-icon p-smooth p-plain p-curve"
                                         color="primary-o"
                                         :value="'_'+props.row.id"
                                         @change="checked_requirement(props.row)">
                                    <i slot="extra" class="icon fa fa-check"></i>
                                </p-check>
                            </label>
                        </div>
                    </div>
                </v-client-table>
            </div>
        </div>
        <hr>
        <div class="form-horizontal">
            <div class="card-body">
                <table>
                    <thead>
                        <tr class="row">
                            <td class="col-4">Nombre</td>
                            <td class="col-2">Cantidad</td>
                            <td class="col-2">Unidad de medida</td>
                            <td class="col-2">Precio Unitario</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="varr in record_items" class="row">
                            <td class="col-4">
                                {{ varr.name }}
                            </td>
                            <td class="col-2">
                                {{ varr.quantity }}
                            </td>
                            <td class="col-2">
                                {{ varr.measurement_unit.acronym }}
                            </td>
                            <td class="col-2">
                                <input type="number" class="form-control" v-model="varr.unit_price">
                            </td>
                        </tr>
                    </tbody>
                </table>
<!--                 <v-client-table :columns="columns" :data="record_items" :options="table_options" class="row">
                    <div slot="requirement_status" slot-scope="props" class="text-center">
                        <div class="d-inline-flex">
                            <span class="badge badge-danger"  v-show="props.row.requirement_status == 'WAIT'">     <strong>EN ESPERA</strong></span>
                            <span class="badge badge-info"    v-show="props.row.requirement_status == 'PROCESSED'"><strong>PRECESADO</strong></span>
                            <span class="badge badge-success" v-show="props.row.requirement_status == 'BOUGHT'">   <strong>COMPRADO </strong></span>
                        </div>
                    </div>
                    <div slot="id" slot-scope="props" class="text-center">
                        <div class="d-inline-flex" v-if="add_buttons_action == 'true'">
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
                        <div class="feature-list-content-left mr-2" v-else>
                            <label class="custom-control custom-checkbox">
                                <p-check class="p-icon p-smooth p-plain p-curve"
                                         color="primary-o"
                                         :value="'_'+props.row.id"
                                         @change="checked_requirement(props.row)">
                                    <i slot="extra" class="icon fa fa-check"></i>
                                </p-check>
                            </label>
                        </div>
                    </div>
                </v-client-table> -->
                <div class="card-footer text-right" v-show="add_buttons_action != 'true'">
                    <buttonsDisplay route_list="/purchese/requirements" display="false"/>
                </div>
            </div>
        </div>
    </section>

</template>
<script>
    export default{
        props:{
            records:{
                type:Array,
                default: function() {
                    return [];
                }
            },
            add_buttons_action:{
                type:String,
                default: function() {
                    return '';
                }
            },
        },
        data(){
            return {
                record_items:[],
                requirement_list:[],
                columns: [  'code',
                            'description',
                            'fiscal_year.year',
                            'contrating_department.name',
                            'user_department.name',
                            'purchase_supplier_type.name',
                            'requirement_status',
                            'id'
                        ],
            }
        },
        methods:{
            checked_requirement(record){
                var pos = this.requirement_list.indexOf(record);
                if (pos == -1) {
                    this.requirement_list.push(record);
                    this.record_items = this.record_items.concat(record.purchase_requirement_items);
                }else{
                    this.requirement_list.splice(pos,1);

                    for (var i = 0; i < record.purchase_requirement_items.length; i++) {
                        for (var x = 0; x < this.record_items.length; x++) {
                            if (this.record_items[x].id == record.purchase_requirement_items[i].id) {
                                this.record_items.splice(x,1);
                                break;
                            }
                        }
                    }
                }
            },
            createRecord(){
                console.log(this.requirement_list)
                // axios.post('/purchase/requirements/base-budget',{ 'list':this.requirement_list }).then(response=>{
                //     // 
                // }).catch(error=>{
                //     // 
                // });
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
                'requirement_status': 'Estado del requerimiento',
                'id': 'ACCIÓN'
            };
            this.table_options.columnsClasses = {
                'code'    : 'col-xs-1',
                'description': 'col-xs-2',
                'fiscal_year.year': 'col-xs-1',
                'contrating_department.name'    : 'col-xs-2',
                'user_department.name': 'col-xs-2',
                'purchase_supplier_type.name': 'col-xs-2',
                'requirement_status': 'col-xs-1',
                'id'      : 'col-xs-1'
            };
        },
        mounted(){
            // this.records = this.requirements;  
        },
    };
</script>
