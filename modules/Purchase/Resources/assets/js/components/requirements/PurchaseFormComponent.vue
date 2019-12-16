<template>
    <div class="form-horizontal">
        <div class="card-body">
            <div class="alert alert-danger" v-if="errors.length > 0">
                <ul>
                    <li v-for="error in errors">{{ error }}</li>
                </ul>
            </div>
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
            </div>

            <hr>
            <v-client-table :columns="columns" :data="record_products" :options="table_options" class="row">
                <div slot="name" slot-scope="props" class="text-center">
                    <span>
                        {{ props.row.text }}
                    </span>
                </div>
                <div slot="measurement_unit" slot-scope="props" class="text-center">
                    <select2 :options="measurement_units" v-model="props.row.measurement_unit_id"
                            @input="changeMeasurementUnit(props.index, props.row.measurement_unit_id)"></select2>
                </div>
                <div slot="technical_specifications" slot-scope="props" class="text-center">
                    <span>
                        <input type="text" :id="props.index" 
                            v-model="props.row.technical_specifications" 
                            class="form-control" 
                            @input="changeTecnicalSpecifications">
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
        props:['date','institutions','purchase_supplier_types', 'fiscal_years','measurement_units'],
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
                product:{},
                products:[],
                warehouses:[],
                compare_warehouse_id: '',
                departments:[],
                record_products:[],
                errors:[],
                columns: ['name','measurement_unit','technical_specifications', 'quantity', 'id'],
            }
        },
        created(){
            this.table_options.headings = {
                'name': 'Producto',
                'measurement_unit': 'Unidad de Medida',
                'technical_specifications': 'Especificaciones tecnicas',
                'quantity': 'Cantidad',
                'id': 'ACCIÓN'
            };
            this.table_options.columnsClasses = {
                'name'    : 'col-xs-4',
                'measurement_unit': 'col-xs-1',
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
                const vm = this;
                vm.record.products = vm.record_products;
                vm.loading = true;
                axios.post('/purchase/requirements',vm.record).then(response=>{
                    vm.loading = false;
                    vm.showMessage('store');
                    setTimeout(function() {
                        location.href = '/purchase/requirements';
                    }, 2000);
                }).catch(error=>{
                    this.errors = [];
                    if (typeof(error.response) != 'undefined') {
                        for (var index in error.response.data.errors) {
                            if (error.response.data.errors[index]) {
                                this.errors.push(error.response.data.errors[index][0]);
                            }
                        }
                    }
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
            changeTecnicalSpecifications({ type, target }){
                this.record_products[target.id-1].technical_specifications = target.value;
            },
            changeMeasurementUnit(index, id){
                this.record_products[index-1].measurement_unit_id = id;
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
                                measurement_unit_id:'',
                            });
                        }
                    }
                }
            },
        }
    };
</script>
