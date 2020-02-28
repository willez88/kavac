<template>
    <div class="card">
        <div class="card-header">
            <h6 class="card-title text-uppercase">Diagnóstico de Equipos en Reparación</h6>
            <div class="card-btns">
                <a href="#" class="btn btn-sm btn-primary btn-custom" @click="redirect_back(route_list)"
                   title="Ir atrás" data-toggle="tooltip">
                    <i class="fa fa-reply"></i>
                </a>
                <a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar"
                   data-toggle="tooltip">
                    <i class="now-ui-icons arrows-1_minimal-up"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
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
                        <strong>Descripción de la avería.</strong>
                        <div class="row" style="margin: 1px 0">
                            <span class="col-md-12" id="breakdown_description">
                            </span>
                        </div>
                        <input type="hidden" v-model="record.id">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <strong>Estado de la reparación.</strong>
                        <div class="row" style="margin: 1px 0">
                            <span class="col-md-12" id="repair_state">
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <b>Equipos en reparación</b>
                </div>
            </div>
            <hr>
            <v-client-table :columns="columns" :data="records" :options="table_options">
                <div slot="id" slot-scope="props" class="text-center">
                    <div class="d-inline-flex">
                        <asset-info
                                :route_list="'/asset/registers/info/'
                                    + props.row.technical_support_request.asset.id">
                        </asset-info>

                        <technicalsupport-diagnostic-asset
                                :route_list="'/technicalsupport/repair-diagnostics/asset/'
                                    + props.row.id">
                        </technicalsupport-diagnostic-asset>

                    </div>
                </div>
            </v-client-table>
        </div>

        <div class="card-footer text-right">
            <button type="button" @click="reset()"
                    class="btn btn-default btn-icon btn-round"
                    title ="Borrar datos del formulario">
                    <i class="fa fa-eraser"></i>
            </button>

            <button type="button"
                    class="btn btn-warning btn-icon btn-round btn-modal-close"
                    data-dismiss="modal"
                    title="Cancelar y regresar">
                    <i class="fa fa-ban"></i>
            </button>

            <button type="button"  @click="createRecord('technicalsupport/repair-diagnostics')"
                    class="btn btn-success btn-icon btn-round btn-modal-save"
                    title="Guardar registro">
                <i class="fa fa-save"></i>
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                record: {
                    id: '',
                    state: '',
                    result: '',
                    start_date: '',
                    end_date: '',
                    user_id: '',
                    technical_support_repair_request_id: ''
                },
                repairRequest: {
                    id: '',
                    state: '',
                    user_id: ''
                },
                diagnostic: {
                    id: '',
                    description: '',
                    technical_support_repair_request_asset_id: ''
                },

                records: [],
                errors: [],
                columns: [
                    'technical_support_request.asset.inventory_serial',
                    'technical_support_request.description',
                    'id'
                ],
            }
        },
        props: {
            repair_id: {
                type: Number,
                required: true
            }
        },
        created() {
            const vm = this;
            vm.table_options.headings = {
                'technical_support_request.asset.inventory_serial': 'Código del equipo',
                'technical_support_request.description': 'Descripción de avería',
                'id': 'Acción'
            };
            vm.table_options.sortable = [
                'technical_support_request.asset.inventory_serial',
                'technical_support_request.description',
                'technical_support_request.asset.model'
            ];
            vm.table_options.filterable = [
                'technical_support_request.asset.inventory_serial',
                'technical_support_request.description',
                'technical_support_request.asset.model'
            ];
        },
        mounted() {
            const vm = this;
            vm.loadForm();
        },
        methods: {
            reset() {
                this.record = {
                    id: ''
                };

            },
            loadForm()
            {
                const vm = this;
                axios.get(`/technicalsupport/repairs/vue-info/${vm.repair_id}`).then(response => {
                    if(typeof(response.data.record != "undefined")){
                        vm.record = response.data.record;
                        vm.records = response.data.record.technical_support_request_repairs;
                    }
                });
            },
        }
    };
</script>
