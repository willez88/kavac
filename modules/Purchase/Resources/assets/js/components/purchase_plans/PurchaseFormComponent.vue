<template>
    <div class="form-horizontal">
        <div class="card-body">
            
            <purchase-show-errors refs="PurchaseFormComponent" />

            <div class="row">
                <div class="col-3">
                    <div class="form-group is-required">
                        <label class="control-label" for="purchase_types">Tipo de compra</label><br>
                        <select2 :options="purchase_types" id="purchase_types" @input="loadPurchaseProcess()" v-model="record.purchase_type_id"></select2>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group is-required">
                        <label class="control-label" for="purchase_process">Proceso de compra</label><br>
                        <select2 :options="purchase_process" :disabled="disabledInputProcess" id="purchase_process" v-model="record.purchase_processes_id"></select2>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group is-required">
                        <label class="control-label" for="responsable">Responsable</label><br>
                        <select2 :options="users" id="responsable" v-model="record.user_id"></select2>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group is-required">
                        <label class="control-label">Fecha Inicial</label>
                        <input type="date" class="form-control" v-model="record.init_date"
                                tabindex="1">
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group is-required">
                        <label class="control-label">Fecha de culminación</label>
                        <input type="date" class="form-control" v-model="record.end_date"
                                tabindex="1">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-right">
            <buttonsDisplay route_list="/purchese/purchase_plans" display="false" />
        </div>
    </div>

</template>
<script>
    export default{
        props:{
            purchase_types:{
                type:Array,
                default: function(){
                    return [];
                }
            },
            purchase_process:{
                type:Array,
                default: function(){
                    return [];
                }
            },
            users:{
                type:Array,
                default: function(){
                    return [];
                }
            },
            record_edit:{
                type:Object,
                default: function(){
                    return null;
                }
            },
        },
        data(){
            return {
                record:{
                    end_date:'',
                    init_date:'',
                    purchase_type_id:'',
                    purchase_processes_id:'',
                    user_id:'',
                },
                disabledInputProcess:false,
            }
        },
        mounted(){
            if (this.record_edit) {
                this.record = this.record_edit;
            }
        },
        methods:{
            reset(){
                this.record = {
                    end_date:'',
                    init_date:'',
                    purchase_type_id:'',
                    purchase_processes_id:'',
                    user_id:'',
                };
                this.$refs.PurchaseFormComponent.reset();
            },

            createRecord(){
                const vm = this;

                vm.loading = true;
                if (!vm.record_edit) {
                    axios.post('/purchase/purchase_plans', vm.record).then(response=>{
                        vm.loading = false;
                        vm.showMessage('store');
                        setTimeout(function() {
                            location.href = '/purchase/purchase_plans';
                        }, 2000);
                    }).catch(error=>{
                        vm.loading = false;
                        vm.$refs.PurchaseFormComponent.reset();
                        vm.errors = [];
                        if (typeof(error.response) != 'undefined') {
                            for (var index in error.response.data.errors) {
                                if (error.response.data.errors[index]) {
                                    vm.errors.push(error.response.data.errors[index][0]);
                                }
                            }
                        }
                    });
                }else{
                    axios.put('/purchase/purchase_plans/'+this.record_edit.id, vm.record).then(response=>{
                        vm.loading = false;
                        vm.showMessage('update');
                        setTimeout(function() {
                            location.href = '/purchase/purchase_plans';
                        }, 2000);
                    }).catch(error=>{
                        vm.loading = false;
                        vm.$refs.PurchaseFormComponent.reset();
                        vm.errors = [];
                        if (typeof(error.response) != 'undefined') {
                            for (var index in error.response.data.errors) {
                                if (error.response.data.errors[index]) {
                                    vm.errors.push(error.response.data.errors[index][0]);
                                }
                            }
                        }
                    });
                }
            },
            loadPurchaseProcess(){
                for (var i = 0; i < this.purchase_types.length; i++) {
                    if(this.purchase_types[i].id == this.record.purchase_type_id){
                        if (this.record.purchase_processes_id != this.purchase_types[i].purchase_processes_id) {
                            this.record.purchase_processes_id = this.purchase_types[i].purchase_processes_id;

                            this.disabledInputProcess = true;

                            if (!this.purchase_types[i].purchase_processes_id) {
                                this.disabledInputProcess = false;    
                            }
                            break;
                        }
                    }
                }
            },

        },
        watch: {

        }
    };
</script>
