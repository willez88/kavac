<template>
    <div class="form-horizontal">
        <div class="card-body">
            
            <purchase-show-errors ref="PurchaseFormComponent" />

            <div class="row">
                <div class="col-3">
                    <div class="form-group is-required">
                        <label class="control-label" for="purchase_types">Modo de compra</label><br>
                        <select2 :options="purchase_types" id="purchase_types" v-model="record.purchase_type_id"></select2>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group is-required">
                        <label class="control-label" for="purchase_proccess">Proceso de compra</label><br>
                        <select2 :options="purchase_proccess" id="purchase_proccess" v-model="record.purchase_proccess_id"></select2>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group is-required">
                        <label class="control-label" for="empelados_responsable">Responsable</label><br>
                        <select2 :options="empelados_responsable" id="empelados_responsable" v-model="record.empelados_responsable_id"></select2>
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
            purchase_proccess:{
                type:Array,
                default: function(){
                    return [];
                }
            },
            empelados_responsable:{
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
                    purchase_proccess_id:'',
                    empelados_responsable_id:'',
                },
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
                    purchase_proccess_id:'',
                    empelados_responsable_id:'',
                };
                this.$refs.PurchaseFormComponent.reset();
            },

            createRecord(){
                if (!this.record_edit) {
                    console.log('crear registro');
                }else{
                    console.log('editar registro');
                }
            },

        },
        watch: {

        }
    };
</script>
