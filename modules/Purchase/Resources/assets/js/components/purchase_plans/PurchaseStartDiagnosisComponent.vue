<template>
    <div>
        <button @click="addRecord('show_purchase_start_diagnosis_'+id, route_show, $event)"
                class="btn btn-success btn-xs btn-icon btn-action" 
                title="Iniciar Diagnostico" 
                data-toggle="tooltip" >
            <i class="fa fa-check"></i>
        </button>

        <div class="modal fade text-left" tabindex="-1" role="dialog" :id="'show_purchase_start_diagnosis_'+id">
            <div class="modal-dialog vue-crud" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="reset" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h6>
                            <i class="fa fa-list inline-block"></i>
                            Plan de compra
                        </h6>
                    </div>
                    <!-- Fromulario -->
                    <div class="modal-body">
                        <hr>
                        <h6>INFORMACIÓN DEL PLAN DE COMPRA</h6>
                        <br>
                        <div class="row">
                            <div class="col-3"><strong>Fecha de inicio:</strong> {{ format_date(records.init_date) }}</div>
                            <div class="col-3"><strong>Fecha de culminación:</strong> {{ format_date(records.end_date) }}</div>
                            <div class="col-3"><strong>Tipo de compra:</strong> {{ purchase_type }}</div>
                            <div class="col-3"><strong>Proceso de compra:</strong> {{ purchase_process }}</div>
                            <div class="col-3"><strong>Responsable:</strong> Empleado de nomina </div>
                        </div>
                        <hr>
                        <h6 class="text-center text-info">DOCUMENTO A CONSIGNAR</h6>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-body">
                                            <ul class="feature-list list-group list-group-flush">
                                                <li class="list-group-item"
                                                    >
                                                    <div class="feature-list-indicator bg-info"></div>
                                                    <div class="feature-list-content p-0">
                                                        <div class="feature-list-content-wrapper">
                                                            <div class="feature-list-content-left mr-2">
                                                                <label class="custom-control">

                                                                    <button type="button" data-toggle="tooltip"
                                                                            class="btn btn-sm btn-danger btn-import"
                                                                            title="Presione para subir el archivo."
                                                                            @click="setFile('file')">
                                                                        <i class="fa fa-upload"></i>
                                                                    </button>
                                                                    <input type="file" 
                                                                            id="file" 
                                                                            @change="uploadFile($event)"
                                                                            style="display:none;">
                                                                </label>
                                                            </div>
                                                            <div class="feature-list-content-left">
                                                                <div class="feature-list-subheading">
                                                                    <div v-if="files">
                                                                        {{ files.name }}
                                                                    </div>
                                                                    <div v-show="!files">
                                                                        Cargar documento de plan de compras
                                                                    </div>
                                                                </div>
                                                                <div class="feature-list-subheading" id="status_file"
                                                                        style="display:none;">
                                                                    <span class="badge badge-success">
                                                                        <strong>Documento Cargado.</strong>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                            </div>
                        </div>

                        <div class="card-footer text-right">
                            <button type="button" class="btn btn-default btn-sm btn-round btn-modal-close" 
									@click="clearFilters" data-dismiss="modal">
								Cerrar
							</button>
							<button type="button" class="btn btn-warning btn-sm btn-round btn-modal btn-modal-clear" 
									@click="reset()">
								Cancelar
							</button>
							<button type="button" @click="createRecord('purchase/purchase_plans/start_diagnosis')" 
									class="btn btn-primary btn-sm btn-round btn-modal-save">
								Guardar
							</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
export default{
    props:['id'],
    data(){
        return{
            records:[],
            record: {
                id: '',
                name: '',
                description: '',
                require_documents: false,
                list_documents: []
            },
            listSelectDocuments: [],
            files:null,
        }
    },
    created(){
        // 
    },
    mounted(){
        if (this.records.purchase_process) {
            this.record = this.records.purchase_process;
        }
    },
    methods:{

        /**
         * Método que borra todos los datos del formulario
         *
         * @author  Juan Rosas <jrosas@cenditel.gob.ve> | <juan.rosasr01@gmail.com>
         */
        reset() {
            // 
        },

        uploadFile(e){

            let vm = this;
            const files = e.target.files;

            Array.from(files).forEach(file => vm.addFile(file));
        },
        addFile(file) {
            if (!file.type.match('application/pdf')) {
                this.showMessage(
                    'custom', 'Error', 'danger', 'screen-error', 'Solo se permiten archivos pdf.'
                );
                return;
            }else{
                this.files = file;
                $('#status_file').show("slow");
                console.log(file)
            }
        },

        createRecord(){
            let vm = this;
            // if (document.querySelector(`#${input_id}`)) {
                vm.loading = true;
                // vm.files[input_id] = document.querySelector(`#${input_id}`).files[0];

                /** Se obtiene y da formato para enviar el archivo a la ruta */
                var formData = new FormData();
                
                formData.append('file', vm.files, vm.files.name);
                formData.append("purchase_plan_id", vm.records.id);

                axios.post('/purchase/purchase_plans/start_diagnosis', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(response => {
                    vm.showMessage('update');
                    vm.loading = false;
                    location.reload();
                }).catch(error => {
                    if (typeof(error.response) !== "undefined") {
                        if (error.response.status == 422 || error.response.status == 500) {
                            for (const i in error.response.data.errors){
                                vm.showMessage(
                                    'custom', 'Error', 'danger', 'screen-error', error.response.data.errors[i][0]
                                );
                            }
                        }
                    }
                    vm.loading = false;
                });
            // }
        },
    },
    computed:{
        purchase_type: function(){
            if (this.records.purchase_type) {
                return this.records.purchase_type.name;
            }
        },
        purchase_process: function(){
            if (this.records.purchase_process) {
                return this.records.purchase_process.name;
            }
        },
    }
};
</script>
