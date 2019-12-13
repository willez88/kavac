<template>
    <div class="form-horizontal">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <b>Información base del requerimiento</b>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label class="control-label">Fecha de generación</label><br>
                        <label class="control-label"><h5>{{ date }}</h5></label>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label class="control-label">Ejercicio económico</label><br>
                        <label class="control-label"><h5>{{ fiscal_years.year }}</h5></label>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group is-required">
                        <label class="control-label" for="institutions">Institución</label><br>
                        <select2 :options="institutions" id="institutions" v-model="record.institution_id"
                                @input="getDepartments()"></select2>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group is-required">
                        <label class="control-label" for="departments1">Unidad contratante</label><br>
                        <select2 :options="departments" id="departments1" v-model="record.contracting_department_id"></select2>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group is-required">
                        <label class="control-label" for="departments2">Unidad usuario</label><br>
                        <select2 :options="departments" id="departments2" v-model="record.user_department_id"></select2>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group is-required">
                        <label for="warehouses">Nombre del Almacén:</label>
                        <select2 :options="warehouses" id="warehouses" v-model="record.warehouse_id"></select2>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="purchase_supplier_types">Tipo</label>
                        <select2 :options="purchase_supplier_types" id="purchase_supplier_types" v-model='record.purchase_supplier_type_id'></select2>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="description">Descripción</label>
                        <input type="text" id="description" v-model="record.description" class="form-control">
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-12">
                    <b>Ingrese los Productos a la solicitud</b>
                </div>
                <div class="col-6">
                    <div class="form-group is-required">
                        <label>Nombre del Producto</label>
                        <select2 :options="products" v-model="product"></select2>
                    </div>
                </div>
                <!-- <div class="col-4"></div> -->
                <!-- <div class="col-2">
                    <button type="button" @click="addProduct()" class="btn btn-sm btn-primary btn-custom float-right" 
                            title="Agregar registro a la lista"
                            data-toggle="tooltip">
                        <i class="fa fa-plus-circle"></i>
                        Agregar
                    </button>
                </div> -->
            </div>

            <hr>
            <v-client-table :columns="columns" :data="record_products" :options="table_options" class="row">
                <div slot="name" slot-scope="props" class="text-center">
                    <span>
                        {{ props.row.text }}
                    </span>
                </div>
                <div slot="technical_specifications" slot-scope="props" class="text-center">
                    <span>
                        <input type="text" :id="props.index" 
                            v-model="props.row.technical_specifications" 
                            class="form-control" 
                            @input="changeDesc" >
                    </span>
                </div>
                <div slot="quantity" slot-scope="props">
                    <span>
                        <input type="number" :id="props.index" 
                            v-model="props.row.qty" 
                            class="form-control" 
                            min="1" 
                            @input="changeQty">
                    </span>
                </div>
                <div slot="id" slot-scope="props" class="text-center">
                    <div class="d-inline-flex">
                        <button @click="removeProduct(props.index, $event)" 
                                class="btn btn-danger btn-xs btn-icon btn-action" 
                                title="Eliminar registro" data-toggle="tooltip" 
                                type="button">
                            <i class="fa fa-trash-o"></i>
                        </button>
                    </div>
                </div>
            </v-client-table>
        </div>
        <div class="card-footer text-right">
            <buttonsDisplay route_list="/purchese/requirements" display="false"/>
        </div>
    </div>

</template>
<script>
    export default{
        props:['supplier_objects','date','institutions','purchase_supplier_types', 'fiscal_years'],
        data(){
            return {
                record:{
                    institution_id            : '',
                    contracting_department_id : '',
                    user_department_id        : '',
                    warehouse_id              : '',
                    purchase_supplier_type_id : '',
                    description               : '',
                    fiscal_year_id            : '',
                    products                  : [],
                },
                aa:0,
                product:{},
                products:[],
                warehouses:[],
                compare_warehouse_id: '',
                departments:[],
                date_recibe:'',
                record_products:[],
                errors:[],
                isWarehouse:false,
                columns: ['name','technical_specifications', 'quantity', 'id'],
            }
        },
        created(){
            this.table_options.headings = {
                'name': 'Producto',
                'technical_specifications': 'Producto',
                'quantity': 'Cantidad',
                'id': 'ACCIÓN'
            };
            this.table_options.columnsClasses = {
                'name'    : 'col-xs-5',
                'technical_specifications'    : 'col-xs-4',
                'quantity': 'col-xs-2',
                'id'      : 'col-xs-1'
            };
        },
        mounted(){
            this.record.fiscal_year_id = this.fiscal_years.id;
        },
        computed: {
            changeFormatDate: function(){
                return (this.date.split('-')[2]+'-'+this.date.split('-')[1]+'-'+this.date.split('-')[0]);
            }
        },
        methods:{
            reset(){
                this.record = {
                    institution_id            : '',
                    contracting_department_id : '',
                    user_department_id        : '',
                    warehouse_id              : '',
                    purchase_supplier_type_id : '',
                    description               : '',
                    products                  : [],
                };
            },
            createRecord(){
                this.record.products = this.record_products;
                axios.post('/purchase/requirements',this.record).then(response=>{
                    console.log("paso")
                });
            },
            
            getWarehouses() {
                const vm = this;
                vm.warehouses = [];

                if (vm.record.institution_id != '') {
                    axios.get('/warehouse/get-warehouses/' + vm.record.institution_id).then(response => {
                        vm.warehouses = response.data;
                    });
                }
            },
            getDepartments() {
                const vm = this;
                vm.departments = [];

                if (vm.record.institution_id != '') {
                    axios.get('/get-departments/' + vm.record.institution_id).then(response => {
                        vm.departments = response.data;
                        vm.getWarehouses();
                    });
                }
            },
            removeProduct(index, event) {
                this.record_products.splice(index-1, 1);
            },
            getWarehouseProducts() {
                this.products = [];
                axios.get('/warehouse/get-warehouse-products/').then(response => {
                    this.products = response.data;
                });
            },
            changeQty({ type, target }){
                this.record_products[target.id-1].qty = target.value;
            },
            fetchDataRecord(){
                if (this.record.warehouse_id != '' && this.record.warehouse_id != this.compare_warehouse_id) {
                    this.compare_warehouse_id = this.record.warehouse_id;
                    this.getWarehouseProducts();
                }
            },
        },
        watch: {
            record: {
                deep: true,
                handler: 'fetchDataRecord'
            },
            product(res){
                if (res) {
                    for (var i = 0; i < this.products.length; i++) {
                        if (this.products[i].id == res) {
                            this.record_products.push({
                                id:res,
                                text:this.products[i].text,
                                qty:0,
                                technical_specifications:'',
                            });
                        }
                    }
                }
            },
        }
    };
</script>
