<template>
    <div>
        <button @click="addRecord('show_requirement_'+id, route_show, $event)"
                class="btn btn-info btn-xs btn-icon btn-action" 
                title="Visualizar requerimiento" 
                data-toggle="tooltip" >
            <i class="fa fa-eye"></i>
        </button>

        <div class="modal fade text-left" tabindex="-1" role="dialog" :id="'show_requirement_'+id">
            <div class="modal-dialog vue-crud" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="reset" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h6>
                            <i class="fa fa-list inline-block"></i>
                            Requerimiento
                        </h6>
                    </div>
                    <!-- Fromulario -->
                    <div class="modal-body">
                        <purchase-show-errors ref="accountingAccountForm" />
                        <hr>
                        <h6>INFORMACIÓN DEL REQUERIMIENTO</h6>
                        <br>
                        <div class="row">
                            <div class="col-3"><strong>Código del requerimiento:</strong> {{ records.code }}</div>
                            <div class="col-3"><strong>Fecha de generación:</strong> {{ format_date(records.created_at) }}</div>
                            <div class="col-3"><strong>Año Fiscal:</strong> {{ fiscal_year }}</div>
                            <div class="col-3"><strong>Unidad contratante:</strong> {{ contracting_department }}</div>
                            <div class="col-3"><strong>Unidad usuario:</strong> {{ user_department }}</div>
                            <div class="col-3"><strong>Tipo:</strong> {{ purchase_supplier_type }}</div>
                            <div class="col-3"><strong>Estatus:</strong>
                                <span class="badge badge-danger"  v-if="records.requirement_status == 'WAIT'">     <strong>EN ESPERA</strong></span>
                                <span class="badge badge-info"    v-if="records.requirement_status == 'PROCESSED'"><strong>PROCESADO</strong></span>
                                <span class="badge badge-success" v-if="records.requirement_status == 'BOUGHT'">   <strong>COMPRADO </strong></span>
                            </div>
                            <div class="col-12"><strong>Descripción: </strong>{{ description }}</div>
                        </div>
                        <hr>
                        <v-client-table :columns="columns" :data="purchase_requirement_items" :options="table_options">
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
            columns: ['name','measurement_unit.name','technical_specifications', 'quantity'],
        }
    },
    created(){
        this.table_options.headings = {
                'name': 'Producto',
                'measurement_unit.name': 'Unidad de Medida',
                'technical_specifications': 'Especificaciones tecnicas',
                'quantity': 'Cantidad',
            };
        this.table_options.columnsClasses = {
            'name'    : 'col-xs-4',
            'measurement_unit.name': 'col-xs-2',
            'technical_specifications'    : 'col-xs-4',
            'quantity': 'col-xs-2',
        };
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
        contracting_department: function(){
            if (this.records.contrating_department) {
                return this.records.contrating_department.name;
            }
        },
        user_department: function(){
            if (this.records.user_department) {
                return this.records.user_department.name;
            }
        },
        purchase_supplier_type: function(){
            if (this.records.purchase_supplier_type) {
                return this.records.purchase_supplier_type.name;
            }
        },
        fiscal_year: function(){
            if (this.records.fiscal_year) {
                return this.records.fiscal_year.year;
            }
        },
        description: function(){
            if (this.records.description) {
                return this.records.description;
            }
        },
        purchase_requirement_items: function(){
            if (this.records.purchase_requirement_items) {
                return this.records.purchase_requirement_items;
            }
            return [];
        },
    }
};
</script>
