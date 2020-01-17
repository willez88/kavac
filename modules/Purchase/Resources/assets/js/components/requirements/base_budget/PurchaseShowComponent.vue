<template>
    <div>
        <button @click="addRecord('show_base_budget_'+id, route_show, $event)"
                class="btn btn-info btn-xs btn-icon btn-action" 
                title="Visualizar requerimiento" 
                data-toggle="tooltip" >
            <i class="fa fa-eye"></i>
        </button>

        <div class="modal fade text-left" tabindex="-1" role="dialog" :id="'show_base_budget_'+id">
            <div class="modal-dialog vue-crud" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="reset" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h6>
                            <i class="fa fa-list inline-block"></i>
                            presupuesto base
                        </h6>
                    </div>
                    <!-- Fromulario -->
                    <div class="modal-body">
                        <purchase-show-errors ref="accountingAccountForm" />
                        <h6>INFORMACIÓN DE LOS REQUERIMIENTOS</h6>
                        <hr>
                        <v-client-table :columns="column_requirements" :data="purchase_requirement" :options="table_option_requirements">
                            <div slot="requirement_status" slot-scope="props" class="text-center">
                                <div class="d-inline-flex">
                                    <span class="badge badge-danger"  v-show="props.row.requirement_status == 'WAIT'">     <strong>EN ESPERA</strong></span>
                                    <span class="badge badge-info"    v-show="props.row.requirement_status == 'PROCESSED'"><strong>PROCESADO</strong></span>
                                    <span class="badge badge-success" v-show="props.row.requirement_status == 'BOUGHT'">   <strong>COMPRADO </strong></span>
                                </div>
                            </div>
                        </v-client-table>
                    </div>
                    <hr>
                    <div class="modal-body">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr class="row">
                                    <th tabindex="0" class="col-2" style="border: 1px solid #dee2e6; position: relative;">Código de requerimiento</th>
                                    <th tabindex="0" class="col-3" style="border: 1px solid #dee2e6; position: relative;">Nombre</th>
                                    <th tabindex="0" class="col-2" style="border: 1px solid #dee2e6; position: relative;">Unidad de medida</th>
                                    <th tabindex="0" class="col-1" style="border: 1px solid #dee2e6; position: relative;">Cantidad</th>
                                    <th tabindex="0" class="col-2" style="border: 1px solid #dee2e6; position: relative;">Precio Unitario sin IVA</th>
                                    <th tabindex="0" class="col-2" style="border: 1px solid #dee2e6; position: relative;">cantidad * Precio unitario</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="varr in purchase_requirement_items" class="row">
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" class="col-2">
                                        {{ varr.requirement_code }}
                                    </td>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" class="col-3">
                                        {{ varr.name }}
                                    </td>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" class="col-2">
                                        {{ varr.measurement_unit.acronym }}
                                    </td>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" class="col-1">
                                        {{ varr.quantity }}
                                    </td>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" class="col-2">
                                        {{ varr.unit_price }}
                                    </td>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" class="col-2">
                                        <h6 align="right">{{ CalculateQtyPrice(varr.qty_price) }}</h6>
                                    </td>
                                </tr>
                                <tr class="row">
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" class="col-8"></td>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" class="col-2">
                                        <h6 align="right">SUB TOTAL {{ currency_symbol }}</h6>
                                    </td>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" class="col-2">
                                        <h6 align="right">{{ (sub_total).toFixed((currency)?currency.decimal_places:'') }}</h6>
                                    </td>
                                </tr>
                                <tr class="row">
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" class="col-8"></td>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" class="col-2">
                                        <h6 align="right">{{ (record_tax)?record_tax.percentage:'' }} % IVA {{ currency_symbol }}</h6>
                                    </td>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" class="col-2">
                                        <h6 align="right">{{ (tax).toFixed((currency)?currency.decimal_places:'') }}</h6>
                                    </td>
                                </tr>
                                <tr class="row">
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" class="col-8"></td>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" class="col-2">
                                        <h6 align="right">TOTAL {{ currency_symbol }}</h6>
                                    </td>
                                    <td style="border: 1px solid #dee2e6;" tabindex="0" class="col-2">
                                        <h6 align="right">{{ (total).toFixed((currency)?currency.decimal_places:'') }}</h6>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
            column_requirements: [  'code',
                                'description',
                                'fiscal_year.year',
                                'contrating_department.name',
                                'user_department.name',
                                'purchase_supplier_type.name',
                                'requirement_status'
                            ],
            columns: ['name','measurement_unit.name','technical_specifications', 'unit_price', 'quantity'],
            table_option_requirements: {
                pagination: { edge: true },
                //filterByColumn: true,
                highlightMatches: true,
                texts: {
                    filter: "Buscar:",
                    filterBy: 'Buscar por {column}',
                    //count:'Página {page}',
                    count: ' ',
                    first: 'PRIMERO',
                    last: 'ÚLTIMO',
                    limit: 'Registros',
                    //page: 'Página:',
                    noResults: 'No existen registros',
                },
                sortIcon: {
                    is: 'fa-sort cursor-pointer',
                    base: 'fa',
                    up: 'fa-sort-up cursor-pointer',
                    down: 'fa-sort-down cursor-pointer'
                },
            },
            sub_total:0,
            tax:0,
            total:0,
            record_items:[],
        }
    },
    created(){
        this.table_option_requirements.headings = {
            'code': 'Código',
            'description': 'Descripción',
            'fiscal_year.year':'Año fiscal',
            'contrating_department.name': 'Departamento contatante',
            'user_department.name': 'Departamento Usuario',
            'purchase_supplier_type.name': 'Tipo de Proveedor',
            'requirement_status': 'Estado del requerimiento'
        };
        this.table_option_requirements.columnsClasses = {
            'code'    : 'col-xs-1',
            'description': 'col-xs-3',
            'fiscal_year.year': 'col-xs-1',
            'contrating_department.name'    : 'col-xs-2',
            'user_department.name': 'col-xs-2',
            'purchase_supplier_type.name': 'col-xs-2',
            'requirement_status': 'col-xs-1',
        };

        this.table_options.headings = {
                'name': 'Producto',
                'measurement_unit.name': 'Unidad de Medida',
                'technical_specifications': 'Especificaciones tecnicas',
                'unit_price':'Precio unitario sin IVA',
                'quantity': 'Cantidad',
            };
        this.table_options.columnsClasses = {
            'name'    : 'col-xs-3',
            'measurement_unit.name': 'col-xs-2',
            'technical_specifications'    : 'col-xs-3',
            'unit_price':'col-xs-2',
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

        CalculateQtyPrice(qty_price){
            return (qty_price)?(qty_price).toFixed((this.currency)?this.currency.decimal_places:''):0;
        },

        /**
        * Calcula el total del debe y haber del asiento contable
        *
        * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
        */
        CalculateTot(){
            this.sub_total = 0;
            this.tax       = 0;
            for (var i = this.record_items.length - 1; i >= 0; i--) {
                var r = this.record_items[i];
                r['qty_price'] = r.quantity * r.unit_price;
                this.sub_total += r['qty_price'];
            }

            var percentage = 1;
            if (this.records.tax && this.records.tax.histories) {
                percentage = this.records.tax.histories[0].percentage;
            }

            this.tax = this.sub_total * (parseFloat(percentage)/100);
            this.total = this.sub_total + this.tax;
        },

        /**
        * Establece la cantidad de decimales correspondientes a la moneda que se maneja
        *
        * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
        */
        cualculateLimitDecimal(){
            var res = "0.";
            if (this.currency) {
                for (var i = 0; i < this.currency.decimal_places-1; i++) {
                    res += "0";
                }
            }
            res += "1";
            return res;
        },
    },
    computed:{
        record_tax: function(){
            if (this.records.tax && this.records.tax.histories) {
                return (this.records.tax)?this.records.tax.histories[0]:null;
            }
        },
        currency_symbol: function(){
            return (this.records.currency)?this.records.currency.symbol:'';
        },
        currency:function(){
            return (this.records.currency)?this.records.currency:null;
        },
        currency_id:function(){
            return (this.records.currency)?this.records.currency.id:null;
        },
        contracting_department: function(){
            if (this.records.purchase_requirement.contrating_department) {
                return this.records.purchase_requirement.contrating_department.name;
            }
        },
        user_department: function(){
            if (this.records.purchase_requirement.user_department) {
                return this.records.purchase_requirement.user_department.name;
            }
        },
        purchase_supplier_type: function(){
            if (this.records.purchase_requirement.purchase_supplier_type) {
                return this.records.purchase_requirement.purchase_supplier_type.name;
            }
        },
        fiscal_year: function(){
            if (this.records.purchase_requirement.fiscal_year) {
                return this.records.purchase_requirement.fiscal_year.year;
            }
        },
        description: function(){
            if (this.records.purchase_requirement.description) {
                return this.records.purchase_requirement.description;
            }
        },
        purchase_requirement: function(){
            if (this.records.purchase_requirement) {
                return this.records.purchase_requirement;
            }
            return [];
        },
        purchase_requirement_items: function(){
            var pur_req_items = [];
            if (this.records.purchase_requirement) {
                for (var i = 0; i < this.records.purchase_requirement.length; i++) {
                    if (this.records.purchase_requirement[i].purchase_requirement_items) {
                        var purchase_requirement_items = this.records.purchase_requirement[i].purchase_requirement_items;
                        for (var x = 0; x < purchase_requirement_items.length; x++) {
                            purchase_requirement_items[x].requirement_code = this.records.purchase_requirement[i].code;
                            purchase_requirement_items[x].qty_price = purchase_requirement_items[x].quantity * purchase_requirement_items[x].unit_price;
                        }
                        pur_req_items = pur_req_items.concat(this.records.purchase_requirement[i].purchase_requirement_items)
                    }
                }
            }
            this.record_items = pur_req_items;
            this.CalculateTot();
            return pur_req_items;
        },
    }
};
</script>
