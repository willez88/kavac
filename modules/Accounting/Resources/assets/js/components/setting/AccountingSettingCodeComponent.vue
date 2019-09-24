<template>
    <div>
        <h6>Asientos contables</h6>
        <form @submit.prevent="">
            <div class="card-body">
                <accounting-show-errors />
                <div class="row">
                    <div class="col-3">
                        <label for="seats_reference" class="control-label">Código de referencia</label>
                        <input type="text" class="form-control" data-toggle="tooltip"
                                title="Formato para el código de los reportes"
                                name="seats_reference" 
                                v-model="code"
                                placeholder="Ej. XXX-00000000-YYYY"
                                :readonly="(ref_code)? true : false">
                    </div>
                </div>

                <hr>
                <div class="row">
                    <div class="col-12">
                        <span class="form-text">
                            <strong>Formato:</strong> prefijo-digitos-año
                            <ul>
                                <li>prefijo (requerido): 1 a 3 carácteres</li>
                                <li>digitos (requerido): 6 carácteres (mínimo), 8 carácteres (máximo)</li>
                                <li>año (requerido): 2 o 4 caracteres (YY o YYYY)</li>
                            </ul>
                            <strong>Longitud total máxima:</strong> 20 carácteres<br>
                            <strong>Ej.</strong> XXX-000000000-YYYY
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <buttonsDisplay route_list="/accounting/settings" display="false" />
            </div>
        </form>
    </div>
</template>
<script>
    export default{
        props:{
            ref_code:{
                type:Object,
                default: null
            }
        },
        data(){
            return{
                code:'',
            }
        },
        mounted(){
            if (this.ref_code) {
                this.code = this.ref_code.format_prefix+'-'+this.ref_code.format_digits+'-'+this.ref_code.format_year;
            }
        },
        methods:{
            reset(){
                if(!this.ref_code){
                    this.code = '';
                }
            },
            validatedFormatCode(){
                var res = false;
                var errors = [];
                if (this.code != '') {
                    var prefix = this.code.split('-')[0];
                    var digits = this.code.split('-')[1];
                    var year = this.code.split('-')[2];
                    if ((!prefix || (prefix.length < 1 || prefix.length > 3)) || 
                        (!digits || (digits.length < 6 || digits.length > 8)) || 
                        (!year || (year != 'YY' && year != 'YYYY'))) {
                        errors.push('El campo código de referencia no cumple con el formato valido.');
                        res = true;
                    }
                }else{
                    errors.push('El campo código de referencia es obligatorio.');
                    res = true;
                }
                EventBus.$emit('show:errors', errors);
                return res;
            },
            createRecord(){
                const vm = this;
                if (vm.validatedFormatCode()) {
                    return;
                }
                axios.post('/accounting/settings/code', {seats_reference:vm.code})
                .then(response=>{
                    vm.showMessage('store');
                    vm.redirect_back('/accounting/settings');
                })
                .catch(errors => {
                    console.log(errors)
                });
                
            }
        },
        watch:{
            code:function(res){
                EventBus.$emit('show:errors', []);
            }
        }
    };
</script>
