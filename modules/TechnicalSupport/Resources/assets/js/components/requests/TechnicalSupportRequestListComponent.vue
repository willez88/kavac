<template>
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
        <div slot="state" slot-scope="props">
            <span>
                {{ (props.row.state)?props.row.state:'N/A' }}
            </span>
        </div>
        <div slot="id" slot-scope="props" class="text-center">
            <div class="d-inline-flex">
                <technicalsupport-request-info
                    :route_show="'requests/vue-info/' + props.row.id"
                    :id="props.row.id">
                </technicalsupport-request-info>

                <technicalsupport-assign-repair-manager
                    :route_show="'requests/vue-info/' + props.row.id"
                    :id="props.row.id">
                </technicalsupport-assign-repair-manager>
            </div>
        </div>
    </v-client-table>
</template>

<script>
    export default {
        data() {
            return {
                records: [],
                columns: ['created_at', 'applicanted_by', 'state', 'id']
            }
        },
        created() {
            this.table_options.headings = {
                'created_at': 'Fecha de la Solicitud',
                'applicanted_by': 'Solicitante',
                'state': 'Estado de la Solicitud',
                'id': 'Acción'
            };
            this.table_options.sortable = ['created_at', 'applicanted_by', 'state'];
            this.table_options.filterable = ['created_at', 'applicanted_by', 'state'];
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
