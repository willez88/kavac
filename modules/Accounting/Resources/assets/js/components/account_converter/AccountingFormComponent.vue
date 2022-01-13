<template>
    <div class="form-horizontal">
        <div class="card-body">

            <accounting-show-errors ref="accountingConverterForm" />

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 is-required">
                    <label class="control-label">Cuentas Presupuestarias</label>
                    <select2 :options="budgetOptions" v-model="budgetSelect" data-toggle="tooltip"
                             title="Seleccione una cuenta presupuestaria"></select2>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 is-required">
                    <label class="control-label">Cuentas Patrimoniales</label>
                    <select2 :options="accountingOptions" v-model="accountingSelect" data-toggle="tooltip"
                             title="Seleccione una cuenta patrimonial"></select2>
                </div>
            </div>
            <br><br>
            <div class="card-footer text-right">
                <buttonsDisplay :route_list="app_url + '/accounting/converter'" display="false"/>
            </div>
        </div>
    </div>
</template>

<script>
    export default{
        props:{
            accounting_list:{
                type:Array,
                default: []
            },
            budget_list:{
                type:Array,
                default: []
            },
            account_to_edit:{
                type:Object,
                default: null
            },
        },
        data(){
            return{
                budgetOptions:[],
                accountingOptions:[],
                budgetSelect:'',
                accountingSelect:'',
                urlPrevious: `${window.app_url}/accounting/converter`
            }
        },
        created(){

            this.budgetOptions     = this.budget_list;
            this.accountingOptions = this.accounting_list;

            /**
             * si existe account_to_edit, el formulario esta en modo editar
             */
            if (this.account_to_edit) {
                this.budgetSelect     = this.account_to_edit.accountable_id;
                this.accountingSelect = this.account_to_edit.accounting_account_id;
            }

        },
        mounted(){
            if (this.budget_list.length < 2) {
                this.$refs.accountingConverterForm.showAlertMessages(
                    'No se encontraron registros de cuentas presupuestarias.'
                );
            }
            if (this.accounting_list.length < 2) {
                this.$refs.accountingConverterForm.showAlertMessages(
                    'No se encontraron registros de cuentas patrimoniales.'
                );
            }
        },
        methods:{

            reset(){
                this.budgetSelect     = '';
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
                    vm.$refs.accountingConverterForm.showAlertMessages('Los campos de selección de cuenta son obligatorios.');
                    return;
                }

                vm.loading = true;
                if (vm.account_to_edit == null) {
                    axios.post(`${window.app_url}/accounting/converter`, {
                        'module'                : 'Budget',
                        'model'                 : 'Modules\\Accounting\\Models\\BudgetAccount',
                        'accountable_id'        : vm.budgetSelect,
                        'accounting_account_id' : vm.accountingSelect,
                    }).then(response=>{

                        if (response.data.message !== 'Success') {
                            vm.showMessage('custom','Error', 'danger', 'fa-ban', response.data.message);
                        }else{
                            vm.$refs.accountingConverterForm.reset();
                            vm.showMessage('store');

                            vm.budgetSelect      = '';
                            vm.accountingSelect  = '';
                            vm.accountingOptions = [];
                            vm.budgetOptions     = [];
                        }
                        vm.loading           = false;
                    });
                } else{
                    axios.put(`${window.app_url}/accounting/converter/${vm.account_to_edit.id}`, {
                        'module'                : 'Budget',
                        'model'                 : 'Modules\\Accounting\\Models\\BudgetAccount',
                        'accountable_id'        : vm.budgetSelect,
                        'accounting_account_id' : vm.accountingSelect,
                    }).then(response=>{
                        if (response.data.message !== 'Success') {
                            vm.showMessage('custom','Error', 'danger', 'fa-ban', response.data.message);
                        }else{
                            vm.showMessage('update');
                            location.href = vm.urlPrevious;
                        }
                        vm.loading    = false;
                    });
                }
            },
        },
    };
</script>
