<template>
    <div class="form-horizontal">
        <div class="card-body">
            
            <purchase-show-errors refs="PurchaseFormComponent" />

            <div class="row">
                <div class="col-md-12">
                    <b>Información base del requerimiento</b>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label class="control-label">Fecha de generación</label><br>
                        <label class="control-label"><h5>{{ format_date((requirement_edit)?requirement_edit.created_at:date) }}</h5></label>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label class="control-label">Ejercicio económico</label><br>
                        <label class="control-label"><h5>{{ fiscal_years.year }}</h5></label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group is-required">
                        <label class="control-label" for="institutions">Institución</label><br>
                        <select2 :options="institutions" id="institutions" v-model="record.institution_id"
                                @input="getDepartments()"></select2>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group is-required">
                        <label class="control-label" for="departments1">Unidad contratante</label><br>
                        <select2 :options="(requirement_edit)?department_list:departments" id="departments1" v-model="record.contracting_department_id"></select2>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group is-required">
                        <label class="control-label" for="departments2">Unidad usuario</label><br>
                        <select2 :options="(requirement_edit)?department_list:departments" id="departments2" v-model="record.user_department_id"></select2>
                    </div>
                </div>
                <div class="col-6">
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
                <!-- <div slot="measurement_unit_id" slot-scope="props" class="text-center">
                    <select2 :options="measurement_units" v-model="props.row.measurement_unit_id"
                            @input="changeMeasurementUnit(props.index, props.row.measurement_unit_id)"></select2>
                </div> -->
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
                            v-model="props.row.quantity" 
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
            <buttonsDisplay route_list="/purchese/requirements" display="false" />
        </div>
    </div>

</template>
<script>
    export default{
        props:{
            date:{
                type: String,
            },
            fiscal_years:{
                type:Object,
                default: function(){
                    return null
                }
            },
            institutions:{
                type:Array,
                default: function(){
                    return [{ id:'', text:'Seleccione...'}];
                }
            },
            purchase_supplier_types:{
                type:Array,
                default: function(){
                    return [{ id:'', text:'Seleccione...'}];
                }
            },
            measurement_units:{
                type:Array,
                default: function(){
                    return [{ id:'', text:'Seleccione...'}];
                }
            },
            requirement_edit:{
                type:Object,
                default: function(){
                    return null
                }
            },
            department_list:{
                type:Array,
                default: function(){
                    return [{ id:'', text:'Seleccione...'}];
                }
            },
        },
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
                compare_contracting_department_id: '',
                departments:[],
                record_products:[],
                toDelete:[],
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
            if (this.requirement_edit) {
                this.departments = this.department_list;
            }
        },
        mounted(){
            this.record.fiscal_year_id = this.fiscal_years.id;
            if (this.requirement_edit) {
                this.record.description = this.requirement_edit.description;
                // asignara la institucion por medio del usuario
                this.record.institution_id = 1;
                // this.getDepartments();

                this.record.contracting_department_id = this.requirement_edit.contracting_department_id;
                this.record.user_department_id = this.requirement_edit.user_department_id;
                this.record.purchase_supplier_type_id = this.requirement_edit.purchase_supplier_type_id;
                this.record.fiscal_year_id = this.requirement_edit.fiscal_year_id;
                this.record_products = this.requirement_edit.purchase_requirement_items;
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
                this.$refs.PurchaseFormComponent.reset();
            },
            createRecord(){
                const vm = this;
                vm.record.products = vm.record_products;
                vm.loading = true;
                if (vm.requirement_edit) {
                    vm.record.toDelete = vm.toDelete;
                    axios.put('/purchase/requirements/'+vm.requirement_edit.id, vm.record).then(response=>{
                        vm.loading = false;
                        vm.showMessage('update');
                        setTimeout(function() {
                            location.href = '/purchase/requirements';
                        }, 2000);
                    }).catch(error=>{
                        vm.loading = false;
                        this.$refs.PurchaseFormComponent.reset();
                        var  errors = [];
                        if (typeof(error.response) != 'undefined') {
                            for (var index in error.response.data.errors) {
                                if (error.response.data.errors[index]) {
                                    errors.push(error.response.data.errors[index][0]);
                                }
                            }
                        }
                        if (this.$refs.PurchaseFormComponent) {
                            this.$refs.PurchaseFormComponent.showAlertMessages(errors);
                        }
                    });
                }else{
                    axios.post('/purchase/requirements',vm.record).then(response=>{
                        vm.loading = false;
                        vm.showMessage('store');
                        setTimeout(function() {
                            location.href = '/purchase/requirements';
                        }, 2000);
                    }).catch(error=>{
                        vm.loading = false;
                        this.$refs.PurchaseFormComponent.reset();
                        var errors = [];
                        if (typeof(error.response) != 'undefined') {
                            for (var index in error.response.data.errors) {
                                if (error.response.data.errors[index]) {
                                    errors.push(error.response.data.errors[index][0]);
                                }
                            }
                        }
                        if (this.$refs.PurchaseFormComponent) {
                            this.$refs.PurchaseFormComponent.showAlertMessages(errors);
                        }
                    });
                }
            },
            
            // getWarehouses() {
            //     const vm = this;
            //     vm.warehouses = [];

            //     if (vm.record.institution_id != '') {
            //         axios.get('/warehouse/get-warehouses/' + vm.record.institution_id).then(response => {
            //             vm.warehouses = response.data;
            //         });
            //     }
            // },
            getDepartments() {
                const vm = this;
                vm.departments = [];

                if (vm.record.institution_id != '') {
                    axios.get('/get-departments/' + vm.record.institution_id).then(response => {
                        vm.departments = response.data;
                        // vm.getWarehouses();
                        vm.getWarehouseProducts();
                    });
                }
            },
            removeProduct(index, event) {
                var v = this.record_products.splice(index-1, 1)[0];
                if (v['updated_at']) {
                    this.toDelete.push(v['id']);
                }
            },
            getWarehouseProducts() {
                this.products = [];
                axios.get('/warehouse/get-warehouse-products/').then(response => {
                    this.products = response.data;
                });
            },
            changeQty({ type, target }){
                this.record_products[target.id-1].quantity = target.value;
            },
            changeTecnicalSpecifications({ type, target }){
                this.record_products[target.id-1].technical_specifications = target.value;
            },
            changeMeasurementUnit(index, id){
                this.record_products[index-1].measurement_unit_id = id;
            },
            // fetchDataRecord(){
            //     // if (this.record.warehouse_id != '' && this.record.warehouse_id != this.compare_contracting_department_id) {
            //     //     this.compare_contracting_department_id = this.record.warehouse_id;
            //     //     this.getWarehouseProducts();
            //     // }
            // },
        },
        watch: {
            // record: {
            //     deep: true,
            //     handler: 'fetchDataRecord'
            // },
            product(res){
                if (res) {
                    axios.get('/warehouse/get-warehouse-product/'+res).then(response=>{
                        if (response.data.record) {
                            var product = response.data.record;
                            this.record_products.push({
                                id:res,
                                name:product.name,
                                quantity:0,
                                technical_specifications:'',
                                measurement_unit:product.measurement_unit.name,
                            });
                        }
                    });
                }
            },
        }
    };
</script>
