<template>
    <section id="TechnicalSupportAssignRepairManagerFormComponent">
        <a class="btn btn-default btn-xs btn-icon btn-action" 
           href="#" title="Asignar reparación" data-toggle="tooltip"
           @click="addRecord('assign_repair_manager','repairs/assign-repair-manager', $event)">
            <i class="fa fa-user-plus"></i>
        </a>

        <div class="modal fade text-left" tabindex="-1" role="dialog" id="assign_repair_manager">
            <div class="modal-dialog modal-xs">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h6>
                            
                            Asignación de Responsable de la reparación
                        </h6>
                    </div>
                    
                    <div class="modal-body">

                        <div class="alert alert-danger" v-if="errors.length > 0">
                            <div class="container">
                                <div class="alert-icon">
                                    <i class="now-ui-icons objects_support-17"></i>
                                </div>
                                <strong>Cuidado!</strong> Debe verificar los siguientes errores antes de continuar:
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                                        @click.prevent="errors = []">
                                    <span aria-hidden="true">
                                        <i class="now-ui-icons ui-1_simple-remove"></i>
                                    </span>
                                </button>
                                <ul>
                                    <li v-for="error in errors">{{ error }}</li>
                                </ul>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Responsable de la reparación</label>
                                    <select2 :options="technicalSupportStaffs"
                                             v-model="technical_support_repair.user_id"></select2>
                                    <input type="hidden" v-model="record.id">
                                </div>        
                            </div>
                        </div>  
                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-default btn-sm btn-round btn-modal-close" 
                                data-dismiss="modal">
                            Cerrar
                        </button>
                        <button type="button" @click="createRecord('technicalsupport/repairs/assign-repair-manager')"
                                class="btn btn-primary btn-sm btn-round btn-modal-save">
                            Guardar
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        data() {
            return {
                record: {
                    id: '',
                    state: '',
                    user_id: '',
                },
                technical_support_repair: {
                    id: '',
                    state: '',
                    result: '',
                    start_date: '',
                    end_date: '',
                    user_id: '',
                    technical_support_request_repair_id: ''  
                },
                technicalSupportStaffs: [],
                records: [],
                errors: [],
            }
        },
        props: {
            requestid: Number,
        },
        created() {
            const vm = this;
            vm.getTechnicalSupportStaff();

        },
        methods: {
            /**
             * Método que borra todos los datos del formulario
             * 
             * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             */
            reset() {
                this.record = {
                    id: '',                    
                    state: '',
                    user_id: '',
                };
            },
            /**
             * Inicializa los registros base del formulario
             *
             * @author Henry Paredes <hparedes@cenditel.gob.ve>
             */
            initRecords(url,modal_id){
                const vm = this;
                vm.errors = [];
                var fields = {};
                var url = 'repairs/requests/vue-info/' + this.requestid;
                axios.get(url).then(response => {
                    if (typeof(response.data.records) !== "undefined") {
                        fields = response.data.record;
                        vm.record = {
                            id: fields.id,
                            state: fields.state,
                            user_id: fields.user_id
                        };
                        vm.technical_support_repair = fields.technical_support_repair;
                    }
                    if ($("#" + modal_id).length) {
                        $("#" + modal_id).modal('show');
                    }
                }).catch(error => {
                    if (typeof(error.response) !== "undefined") {
                        if (error.response.status == 403) {
                            vm.showMessage(
                                'custom', 'Acceso Denegado', 'danger', 'screen-error', error.response.data.message
                            );
                        }
                        else {
                            vm.logs('resources/js/all.js', 343, error, 'initRecords');
                        }
                    }
                });
            },
            createRecord(url, list = true, reset = true) {
                const vm = this;
                var fields = {
                    id: vm.record.id,
                    state: vm.record.state,
                    user_id: vm.record.user_id,
                    technical_support_repair: vm.technical_support_repair
                };
                vm.loading = true;
                axios.post('/' + url, fields).then(response => {
                    if (typeof(response.data.redirect) !== "undefined") {
                        location.href = response.data.redirect;
                    }
                    else {
                        vm.errors = [];
                        if (reset) {
                            vm.reset();
                        }
                        if (list) {
                            vm.readRecords(url);
                        }
                        vm.loading = false;
                        vm.showMessage('store');
                    }

                }).catch(error => {
                    vm.errors = [];

                    if (typeof(error.response) !="undefined") {
                        for (var index in error.response.data.errors) {
                            if (error.response.data.errors[index]) {
                                vm.errors.push(error.response.data.errors[index][0]);
                            }
                        }
                    }

                    vm.loading = false;
                });
            },
            getTechnicalSupportStaff() {
                const vm = this;
                axios.get('/technicalsupport/get-technicalsupport-staff').then(response => {
                    vm.technicalSupportStaffs = response.data;
                });
            },
        },
    }
</script>
