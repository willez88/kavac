<template>
    <div class="card-body">
        
        <accounting-show-errors :options="errors" />

        <div class="card-body">
            <h6>EJEMPLO: Formato de hoja de cálculo </h6>
            <table cellpadding="1" border="1">
                <thead>
                    <tr>
                        <td align="center"><strong>CODIGO</strong></td>
                        <td align="center"><strong>DENOMINACION</strong></td>
                        <td align="center"><strong>ACTIVA</strong></td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td align="center">Ej: 9.9.9.99.99.99.999</td>
                        <td align="center">Nombre de denominación</td>
                        <td align="center">SI ó NO</td>
                    </tr>
                </tbody>
            </table>
            <div class="card-footer text-right">
                <div class="form-group">
                    <form method="post" enctype="multipart/form-data" @submit.prevent="">
                        <label>Cargar Hoja de calculo. Formatos permitidos:<strong>.xls .xlsx .csv</strong></label><br>
                        <button type="button" data-toggle="tooltip"
                                class="btn btn-sm btn-info btn-import"
                                title="Presione para importar la información. Los archivos permitidos son: .xls .xlsx .csv .odt .docx"
                                @click="setFile('import_account')">
                            <i class="fa fa-upload"></i>
                        </button>
                        <input type="file" 
                                id="import_account" 
                                name="import_account"
                                @change="onFileChange" style="display:none">
                        <br>
                    </form>
                </div>
            </div>
        </div>
        

    </div>
        
</template>
<script>
    export default{
        data(){
            return {
                records: [],
                columns: ['code', 'denomination', 'status'],
                file:'',
            }
        },
        created() {
            this.table_options.headings = {
                'code': 'CODIGO',
                'denomination': 'DENOMINACION',
                'status': 'ESTADO DE LA CUENTA',
            };
            this.table_options.sortable   = ['code', 'denomination'];
            this.table_options.filterable = ['code', 'denomination'];

            EventBus.$on('reset:import-form',()=>{
                this.reset();
            });
        },
        methods:{

            /**
            * Limpia los valores de las variables del formulario
            *
            * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
            */
            reset(){
                document.getElementById("import_account").value = "";
                this.records = [];
            },

            createRecord(url){
                this.$parent.createRecord(url);
            },

            onFileChange(e) {
              var files = e.target.files || e.dataTransfer.files;
              if (!files.length)
                return;
              this.importCalculo(files[0]);
            },

            importCalculo(file){

                /** Se obtiene y da formato para enviar el archivo a la ruta */
                let vm = this;

                vm.records = [];

                vm.$parent.$refs.accountingAccountForm.reset();
                var formData = new FormData();
                formData.append("file", file);
                vm.loading = true;
                axios.post('/accounting/import', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(response => {

                    vm.showMessage(
                        'custom', 'Éxito', 'success', 'screen-ok', 
                        'Cuentas cargadas de manera existosa.'
                    );
                    vm.records = response.data.records;
                    EventBus.$emit('reload:list-accounts', vm.records);

                    vm.loading = false;

                }).catch(error => {
                    if (typeof(error.response) !== "undefined") {
                        if (error.response.status == 422 || error.response.status == 500) {

                            for(var indexErrors in error.response.data.errors){
                                var messages = error.response.data.errors[indexErrors];
                                for (var indexMsg in messages){
                                    var message = messages[indexMsg].split('. ')[1] +'. ' + messages[indexMsg].split('. ')[2];
                                    vm.showMessage(
                                        'custom', 'Error', 'danger', 'screen-error', message
                                    );
                                }
                            }

                        }
                    }
                    vm.loading = false;
                });
            },
        }

    };
</script>
