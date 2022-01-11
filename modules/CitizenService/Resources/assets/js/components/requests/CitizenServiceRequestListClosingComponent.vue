<template>
    <section>
        <v-client-table ref="tableResults" :columns="columns" :data="records" :options="table_options">
            <div slot="code" slot-scope="props" class="text-center">
                <span>
                    {{ props.row.code }}
                </span>
            </div>
            <div slot="id" slot-scope="props" class="text-center">
                <button class="btn btn-info btn-xs btn-icon btn-action" type="button"
                        title="Cerrar solicitud" data-toggle="modal"
                        data-target="#citizenserviceRequestViewClose"
                        @click.prevent="setDetails('citizenserviceRequestClose', props.row.id)">
                    <i class="icofont icofont-zipped"></i>
                </button>
            </div>

            <div slot="requested_by" slot-scope="props" class="text-center">
                <span>
                    {{
                        props.row.first_name + ' ' + props.row.last_name
                    }}
                </span>
            </div>
        </v-client-table>

        <citizenservice-request-close ref="citizenserviceRequestClose"></citizenservice-request-close>
    </section>
</template>

<script>
    export default {
        data() {
            return {
                records: [],
                errors: [],
                columns: ['requested_by', 'state', 'date', 'id']
            }
        },
        created() {
            this.readRecords(this.route_list);
            this.table_options.headings = {
                'requested_by': 'Solicitado por',
                'state': 'Estado de la solicitud',
                'date': 'Fecha de la solicitud',
                'id': 'Acción'
            };
            this.table_options.sortable = ['requested_by', 'state', 'date'];
            this.table_options.filterable = ['requested_by', 'state', 'date'];

        },
        methods: {

            acceptRequest(index)
            {
                const vm = this;
                var fields = this.records[index-1];
                var id = this.records[index-1].id;

                axios.put(`${this.route_update}/request-approved/${id}`, fields).then(response => {
                    if (typeof(response.data.redirect) !== "undefined") {
                        location.href = response.data.redirect;
                    }
                    else {
                        vm.readRecords(url);
                        vm.reset();
                        vm.showMessage('update');
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
                });
            },


        }
    };
</script>
