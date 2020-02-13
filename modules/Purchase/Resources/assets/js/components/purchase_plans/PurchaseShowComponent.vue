<template>
    <div>
        <button @click="addRecord('show_purchase_plan_'+id, route_show, $event)"
                class="btn btn-info btn-xs btn-icon btn-action" 
                title="Visualizar registro" 
                data-toggle="tooltip" >
            <i class="fa fa-eye"></i>
        </button>

        <div class="modal fade text-left" tabindex="-1" role="dialog" :id="'show_purchase_plan_'+id">
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
                        <h6 class="text-center text-info">DOCUMENTOS A CONSIGNAR</h6>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="accordion" id="documentsList" v-for="(list, index) in listSelectDocuments">
                                    <h6 class="mb-0" style="text-transform:uppercase;font-weight:bold;">
                                        <button class="btn btn-link" type="button" data-toggle="collapse" rel="tooltip"
                                                :data-target="'#collapseDocumentsList'+index"
                                                aria-expanded="true" :aria-controls="'collapseDocumentsList'+index"
                                                title="Presione para mostrar u ocultar la lista de documentos">
                                            {{ index+1 }}. {{ list.title }} 
                                        </button>
                                    </h6>
                                    <hr>
                                    <div :id="'collapseDocumentsList'+index" class="collapse" :class="{'show': (index===0)}" :aria-labelledby="'heading'+index" data-parent="#documentsList">
                                        <div class="card-body">
                                            <ul class="feature-list list-group list-group-flush">
                                                <li class="list-group-item" v-for="(document, idx) in list.documents"
                                                    v-if="showListDocuments((index+1)+'_'+idx)">
                                                    <div class="feature-list-indicator bg-info"></div>
                                                    <div class="feature-list-content p-0">
                                                        <div class="feature-list-content-wrapper">
                                                            <div class="feature-list-content-left mr-2">
                                                                <label class="custom-control">

                                                                    <button type="button" data-toggle="tooltip"
                                                                            class="btn btn-sm btn-info btn-import"
                                                                            title="Presione para subir el archivo del documento."
                                                                            @click="setFile('file_document_'+(index+1)+'_'+idx)">
                                                                        <i class="fa fa-upload"></i>
                                                                    </button>
                                                                    <input type="file" 
                                                                            :id="'file_document_'+(index+1)+'_'+idx" 
                                                                            @change="uploadFile('file_document_'+(index+1)+'_'+idx)"
                                                                            style="display:none;">
                                                                </label>
                                                            </div>
                                                            <div class="feature-list-content-left">
                                                                <div class="feature-list-subheading">
                                                                    {{ document }}
                                                                </div>
                                                                <div class="feature-list-subheading" :id="'status_file_document_'+(index+1)+'_'+idx"
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
                            </div>
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
            files:{},
        }
    },
    created(){
        // 
    },
    mounted(){
        if (this.records.purchase_process) {
            this.record = this.records.purchase_process;
            this.getListDocuments();
        }
    },
    methods:{

        /**
         * Método que borra todos los datos del formulario
         *
         * @author  Juan Rosas <jrosas@cenditel.gob.ve> | <juan.rosasr01@gmail.com>
         */
        reset() {
            this.getListDocuments();
        },

        /**
         * Método que obtiene un listado de documentos a solicitar para los procesos de compras
         *
         * @method     getListDocuments
         *
         * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
         */
        getListDocuments() {
            const vm = this;
            vm.loading = true;
            vm.record.list_documents = [];
            axios.post('/purchase/get-process-documents', {id: vm.record.id}).then(response => {
                vm.listSelectDocuments = response.data.records;
                vm.record.list_documents = [];

                if (response.data.selected !== null) {
                    vm.record.list_documents = JSON.parse(response.data.selected);
                }
                vm.loading = false;
            }).catch(error => {
                console.log(error);
            })
        },

        /**
         * [showListDocuments carga en variables el listado de los documentos del proceso de compra]
         * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
         * @param  {[type]} idx [description]
         * @return {[type]}     [description]
         */
        showListDocuments(idx){
            const vm = this;
            if (vm.records.purchase_process) {
                if (typeof vm.records.purchase_process.list_documents === 'string') {
                    vm.records.purchase_process.list_documents = JSON.parse(vm.records.purchase_process.list_documents);
                }
                var obj = vm.records.purchase_process.list_documents
                for (const i in obj){
                    if (obj[i] == idx) {
                        return true;
                    }
                }
                return false;
            }
        },
        uploadFile(input_id){
            let vm = this;
            if (document.querySelector(`#${input_id}`)) {
                vm.loading = false;
                vm.files[input_id] = document.querySelector(`#${input_id}`).files[0];

                /** Se obtiene y da formato para enviar el archivo a la ruta */
                var formData = new FormData();
                var inputFile = document.querySelector('#'+input_id);
                formData.append("file", inputFile.files[0]);
                formData.append("purchase_plan_id", vm.id);

                axios.post('/purchase/purchase_plan_upload_file', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(response => {
                    vm.showMessage('update');
                    vm.loading = false;
                    $('#status_'+input_id).show("slow");

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
            }
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
