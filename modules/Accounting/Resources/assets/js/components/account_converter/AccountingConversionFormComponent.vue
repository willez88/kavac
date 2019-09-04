<template>
    <div class="form-horizontal">
        <div class="card-body">
            
            <accounting-show-errors :options="errors" />

            <div class="row">
                <div class="col-1"></div>
                <div class="col-5 is-required">
                    <label class="control-label">Cuentas Presupuestales</label>
                    <select2 :options="budgetOptions" v-model="budgetSelect"
                                data-toggle="tooltip"
                                title="Seleccione una cuenta presupuestal"></select2>
                </div>
                <div class="col-5 is-required">
                    <label class="control-label">Cuentas Patrimoniales</label>
                    <select2 :options="accountingOptions" v-model="accountingSelect"
                                data-toggle="tooltip"
                                title="Seleccione una cuenta patrimonial"></select2>
                </div>
                <div class="col-1"></div>
            </div> 
            <br><br>
            <div class="card-footer text-right">
                <button @click="reset" class="btn btn-default btn-icon btn-round" data-toggle="tooltip" 
                        title="Borrar datos del formulario">
                    <i class="fa fa-eraser"></i>
                </button>
                <button @click="redirect_back(urlPrevious)" class="btn btn-warning btn-icon btn-round" data-toggle="tooltip" 
                        title="Cancelar y regresar">
                    <i class="fa fa-ban"></i>
                </button>
                <button @click="createRecord" class="btn btn-success btn-icon btn-round" data-toggle="tooltip" 
                        title="Guardar registro">
                    <i class="fa fa-save"></i>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    export default{
        props:['accounting_list','budget_list', 'account_to_edit'],
        data(){
            return{
                budgetOptions:[],
                accountingOptions:[],
                budgetSelect:'',
                accountingSelect:'',
                urlPrevious:'/accounting/converter'
            }
        },
        created(){
            this.budgetOptions = this.budget_list;
            this.accountingOptions = this.accounting_list;

            // si existe account_to_edit, el formulario esta en modo editar
            if (this.account_to_edit) {
                this.budgetSelect = this.account_to_edit.budget_account_id;
                this.accountingSelect = this.account_to_edit.accounting_account_id;
            }
        },
        methods:{

            reset(){
                this.budgetSelect = '';
                this.accountingSelect = '';
            },

            /**
             * enviar la información de las cuentas a convertir para ser almacenada
             *
             * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
             * @param {int} $indexToConvertion [posición en el array de cuentas a convertir]
            */
            createRecord:function(){

                const vm = this;

                if (vm.budgetSelect == '' || vm.accountingSelect == '') {
                    EventBus.$emit('show:errors', ['Los campos de selección de cuenta son obligatorios.']);
                    return;
                }

                // Se creara
                if (vm.account_to_edit == null) {
                    axios.post('/accounting/converter', {
                                                        'budget_id':vm.budgetSelect,
                                                        'accounting_id':vm.accountingSelect,
                                                        })
                    .then(response=>{
                        
                        vm.budgetSelect = '';
                        vm.accountingSelect = '';

                        vm.accountingOptions = [];
                        vm.budgetOptions = [];
                        vm.accountingOptions = response.data.records_accounting;
                        vm.budgetOptions = response.data.records_busget;
                        EventBus.$emit('show:errors', []);
                        vm.showMessage('store');
                    });
                } else{
                    axios.put('/accounting/converter/'+vm.account_to_edit.id, {
                                                        'budget_account_id':vm.budgetSelect,
                                                        'accounting_account_id':vm.accountingSelect,
                                                        })
                    .then(response=>{
                        vm.showMessage('update');
                        location.href = vm.urlPrevious;
                    });
                }
            },
        },
    };
</script>
