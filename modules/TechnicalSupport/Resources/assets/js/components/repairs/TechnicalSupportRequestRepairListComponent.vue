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
                <technicalsupport-assign-repair-manager :requestid="props.row.id">
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
                columns: ['created_at', 'applicanted_by', 'assigned_to', 'state', 'id']
            }
        },
        created() {
            this.table_options.headings = {
                'created_at': 'Fecha de la Solicitud',
                'applicanted_by': 'Solicitante',
                'assigned_to': 'Responsable',
                'state': 'Estado de la solicitud',
                'id': 'Acción'
            };
            this.table_options.sortable = ['created_at', 'applicanted_by', 'assigned_to', 'state'];
            this.table_options.filterable = ['created_at', 'applicanted_by', 'assigned_to', 'state'];
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
