<template>
    <form class='form-horizontal'>
        <div class='card-body'>
            <div class='row'>
                <div class='col-md-6'>
                    <div class='form-group'>
                        <label class='control-label'>Cuenta de nivel superior</label>
                        <select2 :options='accRecords' v-model='record_select'></select2>
                    </div>
                </div>
                <div class='col-md-6'>
                    <div class='form-group'>
                        <label class='control-label'>Código</label>
                        <div class='row inline-inputs'>
                            <div class="col-6">
                                <input id="code" type="text" class="form-control input-sm" placeholder="0.0.0.00.00.00.000" data-toggle="tooltip" title="Código de la cuenta patrimonial" v-model='record.code'>
                            </div>
                        </div>
                        <!-- :onkeyup="record.code=justAllow(record.code)" -->
                    </div>
                </div>
                <div class='col-md-6'>
                    <div class='form-group'>
                        <label class='control-label'>Denominación</label>
                        <input type='text' class='form-control input-sm' id='denomination' name='denomination'
                               data-toggle='tooltip' placeholder='Descripción de la cuenta'
                               title='Denominación o concepto de la cuenta' v-model='record.denomination'>
                    </div>
                </div>
                <div class='col-6'>
                    <div class='row'>
                        <div class='col-3'>
                            <div class='form-group'>
                                <label class='control-label'>Activa</label>
                                <div class='col-12'>
                                    <div class="col-12 bootstrap-switch-mini">
                                        <input id='active' data-on-label='SI' data-off-label='NO' name='active'
                                               type='checkbox' class='form-control bootstrap-switch'
                                               v-model='record.active'>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

</template>

<script>

//import Inputmask from "inputmask";
    export default {
        props:{
            records:{
                type:Array,
                default: []
            },
        },
        data(){
            return{
                accRecords:[],
                record_select:'',
                record:{
                    id:'',
                    code:'',
                    group:'',
                    subgroup:'',
                    item:'',
                    generic:'',
                    specific:'',
                    subspecific:'',
                    denomination:'',
                    active:false,
                },
                urlPrevious:'/accounting/accounts',
            }
        },
        created(){

            EventBus.$on('register:account',(data)=>{
                this.createRecord(data);
            });
            EventBus.$on('load:data-account-form',(data)=>{
                if (data == null) {
                    this.reset(false);
                }
                else{
                    this.record = {
                        id:data.id,
                        code:data.code,
                        denomination:data.denomination,
                        active:data.active,
                    };
                    if (data.parent) {
                        this.record_select = data.parent.id;
                    }

                }

                $('input[name=active]').bootstrapSwitch('state', this.record.active);
            });
        },
        mounted(){
            var selector = document.getElementById("code");
            Inputmask("9.9.9.99.99.99.999").mask(selector);

            this.switchHandler('active');
            this.reset();
        },
        methods:{
            /**
            * Limpia los valores de las variables del formulario
            *
            * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
            */
            reset:function(resetRecords = true){
                if (resetRecords) {
                    this.accRecords = [];
                }

                this.record={
                    id:'',
                    group:'',
                    subgroup:'',
                    item:'',
                    generic:'',
                    specific:'',
                    subspecific:'',
                    denomination:'',
                    active:false,
                };
            },
            /**
            * Valida que los campos del código sean validos
            *
            * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
            * @return {boolean} retorna falso si algun campo no cumple el formato correspondiente
            */
            FormatCode:function(){
                var res = true;
                var errors = [];

                if (!this.record.code || this.record.code.split('_').length > 1) {
                    errors.push('El campo código es obligatorio y debe ser llenado completamente');
                    res = false;
                }
                if (!this.record.denomination) {
                    errors.push('El campo denominación es obligatorio.');
                    res = false;
                }
                this.$parent.$refs.accountingAccountForm.showAlertMessages(errors);
                return res;
            },
            /**
            * Envia la información a ser almacenada de la cuenta patrimonial
            * en caso de que se este actualizando la cuenta, se envia la información a la ruta para ser actualizada
            *
            * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
            */
            createRecord:function(url){

                const vm = this;
                if (!vm.FormatCode()) { return; }

                var dt = vm.record;

                var auxRecord = {
                    id:'',
                    group:'',
                    subgroup:'',
                    item:'',
                    generic:'',
                    specific:'',
                    subspecific:'',
                    institutional:'',
                    denomination:'',
                    active:false,
                };
                /**
                 * Se formatean los ultimos tres campos del codigo de ser necesario
                 */
                auxRecord.id            = dt.id;

                auxRecord.group         = dt.code.split('.')[0];
                auxRecord.subgroup      = dt.code.split('.')[1];
                auxRecord.item          = dt.code.split('.')[2];
                auxRecord.generic       = dt.code.split('.')[3];
                auxRecord.specific      = dt.code.split('.')[4];
                auxRecord.subspecific   = dt.code.split('.')[5];
                auxRecord.institutional = dt.code.split('.')[6];

                auxRecord.denomination  = dt.denomination;

                auxRecord.active        = $('#active').prop('checked');

                vm.loading              = true;

                if (auxRecord.id) {
                    axios.put(url+auxRecord.id, auxRecord).then(response=>{

                        /** Se emite un evento para actualizar el listado de cuentas en el select */
                        vm.accRecords = [];
                        vm.accRecords = response.data.records;

                        /** Se emite un evento para actualizar el listado de cuentas de la tablas del componente accounting-accounts-list */
                        EventBus.$emit('reload:list-accounts',response.data.records);
                        vm.showMessage('update');
                        vm.loading = false;
                    }).catch(error=>{
                        var errors = [];
                        if (typeof(error.response) != 'undefined') {
                            for (var index in error.response.data.errors) {
                                if (error.response.data.errors[index]) {
                                    errors.push(error.response.data.errors[index][0]);
                                }
                            }
                            vm.$parent.$refs.accountingAccountForm.showAlertMessages(errors);
                        }
                    });
                } else {
                    axios.post(url, auxRecord).then(response=>{

                        /** Se emite un evento para actualizar el listado de cuentas en el select */
                        vm.accRecords = [];
                        vm.accRecords = response.data.records;

                        /** Se emite un evento para actualizar el listado de cuentas de la tablas del componente accounting-accounts-list */
                        EventBus.$emit('reload:list-accounts',response.data.records);
                        vm.showMessage('store');

                        vm.loading = false;

                    }).catch(error=>{
                        var errors = [];
                        if (typeof(error.response) !='undefined') {
                            for (var index in error.response.data.errors) {
                                if (error.response.data.errors[index]) {
                                    errors.push(error.response.data.errors[index][0]);
                                }
                            }
                            vm.$parent.$refs.accountingAccountForm.showAlertMessages(errors);
                        }
                    });
                }

                vm.reset();
            },
        },
        watch:{
            /**
            * Obtiene el código disponible para la subcuenta y carga la información en el formulario
            *
            * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
            */
            record_select:function(res, ant) {
                if (res != '' && res != ant) {
                    // esta validacion es para el caso de cargar datos en el formulario
                    // evitando que realize la consulta axios
                    if (typeof res == 'number') {
                        return;
                    }
                    axios.get('/accounting/get-children-account/' + res).then(response => {
                            var account = response.data.account;
                            /**
                             * Selecciona en pantalla la nueva cuentas
                             */
                            this.record = {
                                code:account.code,
                                denomination:account.denomination,
                                active:account.active
                            };
                            $('input[name=active]').bootstrapSwitch('state', this.record.active);
                    });
                }
            },
            records:function(res){
                this.accRecords = res;
            }
        }

    };

</script>
