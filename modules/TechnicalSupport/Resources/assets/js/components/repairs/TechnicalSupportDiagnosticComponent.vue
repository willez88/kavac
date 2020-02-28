<template>
    <section id="TechnicalSupportDiagnosticFormComponent">
        <a class="btn btn-default btn-xs btn-icon btn-action" 
           href="#" title="Gestionar diagnóstico" data-toggle="tooltip"
           @click="addRecord('diagnostic-form',route_list, $event)">
            <i class=""></i>
        </a>

        <div class="modal fade text-left" tabindex="-1" role="dialog" id="diagnostic-form">
            <div class="modal-dialog vue-crud" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h6>
                            
                            Diagnóstico de la reparación
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
                                    <strong>Estado de la reparación</strong>
                                    <div class="row" style="margin: 1px 0">
                                        <span class="col-md-12" id="estate_repair">
                                        </span>
                                    </div>
                                </div>        
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <v-client-table :columns="columns" :data="records" :options="table_options">
                                    <div slot="applicanted_by" slot-scope="props">
                                        <span>
                                            {{ (props.row.user.profile)
                                                ? ((props.row.user.profile.first_name
                                                    ? props.row.user.profile.first_name
                                                    : '') + (props.row.user.profile.last_name
                                                        ? (' ' + props.row.user.profile.last_name)
                                                        : ''))
                                                : props.row.user.name
                                            }}
                                        </span>
                                    </div>
                                    <div slot="assigned_to" slot-scope="props">
                                        <span>
                                            {{ (props.row.technical_support_repair)
                                                    ? (props.row.technical_support_repair.user.profile)
                                                        ? ((props.row.technical_support_repair.user.profile.first_name
                                                            ? props.row.technical_support_repair.user.profile.first_name
                                                            : '') + (props.row.technical_support_repair.user.profile.last_name
                                                                ? (' ' + props.row.technical_support_repair.user.profile.last_name)
                                                                : ''))
                                                        : props.row.technical_support_repair.user.name
                                                    : 'No definido'
                                            }}
                                        </span>
                                    </div>
                                    <div slot="state" slot-scope="props">
                                        <span>
                                            {{ (props.row.state)?props.row.state:'N/A' }}
                                        </span>
                                    </div>

                                    <div slot="id" slot-scope="props" class="text-center">
                                        <div class="d-inline-flex">
                                            <technicalsupport-repair-request-info
                                                :route_list="'repairs/requests/vue-info/' + props.row.id">
                                            </technicalsupport-repair-request-info>

                                            <technicalsupport-diagnostic
                                                :route_list="'repairs/requests/vue-info/' + props.row.id">
                                            </technicalsupport-diagnostic>
                                        </div>
                                    </div>
                                </v-client-table>
                            </div>
                        </div>
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

                records: [],
                errors: [],
                columns: ['asset.inventory_serial','asset.serial','asset.marca','asset.model'],
                assets: []
            }
        },
        props: {
            requestid: Number,
        },
        created() {
            const vm = this;
            vm.table_options.headings   = {
                'asset.inventory_serial': 'Código',
                'asset.serial': 'Serial',
                'asset.marca': 'Marca',
                'asset.model': 'Modelo',
            };
            vm.table_options.sortable   = ['asset.inventory_serial','asset.serial','asset.marca','asset.model'];
            vm.table_options.filterable = ['asset.inventory_serial','asset.serial','asset.marca','asset.model'];

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
                vm.loadEquipment();
                axios.get(url).then(response => {
                    if (typeof(response.data.record) !== "undefined") {
                        fields = response.data.record;
                        vm.record = {
                            id: vm.requestid,
                            state: fields.state,
                            user_id: fields.user_id
                        };
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
                axios.patch('/' + url + '/' + vm.requestid, fields).then(response => {
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
            loadEquipment() {
                const vm = this;
                axios.get(vm.route_list).then(response => {
                    vm.records = response.data.record.technical_support_request_repair_assets;
                });
            }
        },
    }
</script>
