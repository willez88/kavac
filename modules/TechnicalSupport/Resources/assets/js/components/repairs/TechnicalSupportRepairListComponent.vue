<template>
    <v-client-table :columns="columns" :data="records" :options="table_options">
        <div slot="assigned_to" slot-scope="props">
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
        <div slot="state" slot-scope="props">
            <span>
                {{ (props.row.state)?props.row.state:'N/A' }}
            </span>
        </div>

        <div slot="id" slot-scope="props" class="text-center">
            <div class="d-inline-flex">
                <technicalsupport-repair-info
                    :route_show="'repairs/vue-info/' + props.row.id"
                    :id="props.row.id">
                </technicalsupport-repair-info>
                <button 
                        @click="redirect_back('/technicalsupport/repair-diagnostics/' + props.row.id)"
                        class="btn btn-default btn-xs btn-icon btn-action"
                        title="Gestionar diagnóstico" data-toggle="tooltip" type="button">
                    <i class="fa fa-filter"></i>
                </button>
                <technicalsupport-deliver-equipment
                    :route_show="'repairs/deliver-equipment/' + props.row.id"
                    :repair_id="props.row.id">
                </technicalsupport-deliver-equipment>
            </div>
        </div>
    </v-client-table>
</template>

<script>
    export default {
        data() {
            return {
                records: [],
                columns: ['created_at', 'assigned_to', 'state', 'id']
            }
        },
        created() {
            this.table_options.headings = {
                'created_at': 'Fecha de Asignación',
                'assigned_to': 'Responsable',
                'state': 'Estado de la Reparación',
                'id': 'Acción'
            };
            this.table_options.sortable = ['created_at', 'assigned_to', 'state'];
            this.table_options.filterable = ['created_at', 'assigned_to', 'state'];
        },
        mounted () {
            this.initRecords(this.route_list, '');
        },
        methods: {
            /**
             * Inicializa los datos del formulario
             *
             * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
             */
            reset() {

            },
        }
    };
</script>
