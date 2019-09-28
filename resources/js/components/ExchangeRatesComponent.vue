<template>
    <div class="col-md-2 text-center">
        <a class="btn-simplex btn-simplex-md btn-simplex-primary"
           href="" title="Registros de Tipos de Cambio"
           data-toggle="tooltip" @click="addRecord('add_exchange_rate', 'exchange-rates', $event)">
            <i class="icofont icofont-random ico-3x"></i>
            <span>Tipos de Cambio</span>
        </a>
        <div class="modal fade text-left" tabindex="-1" role="dialog" id="add_exchange_rate">
            <div class="modal-dialog vue-crud" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h6>
                            <i class="icofont icofont-random inline-block"></i>
                            Tipos de Cambio
                        </h6>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" v-if="errors.length > 0">
                            <ul>
                                <li v-for="error in errors">{{ error }}</li>
                            </ul>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group is-required">
                                    <label>De:</label>
                                    <select2 :options="currencies"
                                             v-model="record.from_currency_id"></select2>
                                    <input type="hidden" v-model="record.id">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group is-required">
                                    <label>A:</label>
                                    <select2 :options="currencies" v-model="record.to_currency_id"></select2>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group is-required">
                                    <label>Fecha inicio:</label>
                                    <input type="date" class="form-control input-sm" v-model="record.start_at"
                                           placeholder="dd/mm/aaaa" data-toggle="tooltip"
                                           title="Fecha de inicio del tipo de cambio">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Fecha fin:</label>
                                    <input type="date" class="form-control input-sm" v-model="record.end_at"
                                           placeholder="dd/mm/aaaa" data-toggle="tooltip"
                                           title="Fecha fin del tipo de cambio">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Monto:</label>
                                    <input type="numeric" step="0.01" class="form-control input-sm"
                                           v-model="record.amount" data-toggle="tooltip"
                                           title="monto del tipo de cambio">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group is-required">
                                    <label>Activo:</label>
                                    <div class="col-md-12">
                                        <input type="checkbox" class="form-control bootstrap-switch"
                                               data-toggle="tooltip" data-on-label="SI" data-off-label="NO" value="true"
                                               title="Indique si el tipo de cambio está activo"
                                               v-model="record.active" name="active">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group">
                            <modal-form-buttons :saveRoute="'exchange-rates'"></modal-form-buttons>
                        </div>
                    </div>
                    <div class="modal-body modal-table">
                        <v-client-table :columns="columns" :data="records" :options="table_options">
                            <div slot="start_at" slot-scope="props">
                                {{ format_date(props.row.start_at) }}
                            </div>
                            <div slot="end_at" slot-scope="props">
                                <span v-if="props.row.end_at">{{ format_date(props.row.end_at) }}</span>
                            </div>
                            <div slot="from_currency" slot-scope="props">
                                {{ props.row.from_currency.symbol }} - {{ props.row.from_currency.name }}
                            </div>
                            <div slot="to_currency" slot-scope="props">
                                {{ props.row.to_currency.symbol }} - {{ props.row.to_currency.name }}
                            </div>
                            <div slot="amount" slot-scope="props">
                                {{ props.row.to_currency.symbol }} {{ props.row.amount }}
                            </div>
                            <div slot="active" slot-scope="props" class="text-center">
                                <span v-if="props.row.active === true" class="text-bold text-success">SI</span>
                                <span v-else class="text-bold text-danger">NO</span>
                            </div>
                            <div slot="id" slot-scope="props" class="text-center">
                                <button @click="initUpdate(props.index, $event)"
                                        class="btn btn-warning btn-xs btn-icon btn-action"
                                        title="Modificar registro" data-toggle="tooltip" type="button">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button @click="deleteRecord(props.index, 'exchange-rates')"
                                        class="btn btn-danger btn-xs btn-icon btn-action"
                                        title="Eliminar registro" data-toggle="tooltip"
                                        type="button">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                            </div>
                        </v-client-table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                record: {
                    id: '',
                    start_at: '',
                    end_at: null,
                    active: false,
                    amount: 0,
                    from_currency_id: '0',
                    to_currency_id: '0',
                },
                errors: [],
                records: [],
                currencies: [],
                columns: ['start_at', 'end_at', 'from_currency', 'to_currency', 'amount', 'active', 'id'],
            }
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
                    start_at: '',
                    end_at: null,
                    active: false,
                    amount: 0,
                    from_currency_id: '0',
                    to_currency_id: '0',
                };
            },
        },
        created() {
            this.table_options.headings = {
                'start_at': 'Fecha inicio',
                'end_at': 'Fecha fin',
                'from_currency': 'De',
                'to_currency': 'A',
                'amount': 'Tipo de cambio',
                'active': 'Activo',
                'id': 'Acción'
            };
            this.table_options.sortable = ['start_at', 'end_at', 'from_currency', 'to_currency'];
            this.table_options.filterable = ['start_at', 'end_at', 'from_currency', 'to_currency'];
            this.table_options.columnsClasses = {
                'start_at': 'col-md-1 text-center',
                'end_at': 'col-md-1 text-center',
                'from_currency': 'col-md-2',
                'to_currency': 'col-md-2',
                'amount': 'col-md-2 text-right',
                'active': 'col-md-2 text-center',
                'id': 'col-md-2'
            };
        },
        mounted() {
            let vm = this;
            vm.switchHandler('active');
            $("#add_exchange_rate").on('show.bs.modal', function() {
                vm.getCurrencies();
            });
        }
    };
</script>

