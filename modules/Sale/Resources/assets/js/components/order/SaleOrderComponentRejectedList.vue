<template>
    <v-client-table :columns="columns" :data="records" :options="table_options">
        <div slot="state" slot-scope="props">
            <span>
                {{ (props.row.state)?props.row.state:'N/A' }}
            </span>
        </div>
        
        <div slot="id" slot-scope="props" class="text-center">
            <div class="d-inline-flex">
                <button @click="deleteOrden(props.index)" 
                        class="btn btn-danger btn-xs btn-icon btn-action" title="Eliminar Solicitud"
                        data-toggle="tooltip" type="button"
                        :disabled="props.row.status != 'rechazado'">
                    <i class="fa fa-ban"></i>
                </button>
            </div>
        </div>
    </v-client-table>
</template>

<script>
    export default {
        data() {
            return {
                records: [],
                columns: ['name', 'email', 'phone', 'products', 'id']
            }
        },
        created() {
            this.table_options.headings = {
                'name': 'Nombre y apellido',
                'email': 'Correo',
                'phone': 'Teléfono',
                'products': 'Productos',
                'id': 'Acción'
            };
            this.table_options.sortable = ['name', 'email', 'phone', 'products'];
            this.table_options.filterable = ['name', 'email', 'phone', 'products'];
            this.table_options.columnsClasses = {
                'name': 'col-md-2',
                'email': 'col-md-2',
                'phone': 'col-md-2',
                'products': 'col-md-4',
                'id': 'col-md-2'
            };
        },
        mounted () {
            this.initRecords(this.route_list, '');
        },
        methods: {
            reset() {
                
            },
            deleteOrden(index)
            {
                const vm = this;
                var dialog = bootbox.confirm({
                    title: 'Eliminar orden solicitada?',
                    message: "<p>¿Seguro que desea eliminar esta solicitud?. Una vez eliminada la operación no se podrán realizar cambios en la misma.<p>",
                    size: 'medium',
                    buttons: {
                        cancel: {
                            label: '<i class="fa fa-times"></i> Cancelar'
                        },
                        confirm: {
                            label: '<i class="fa fa-check"></i> Confirmar'
                        }
                    },
                    callback: function (result) {
                        if (result) {
                            var fields = vm.records[index-1];
                            var id = vm.records[index-1].id;

                            axios.put('/'+vm.route_update+'/delete/'+id, fields).then(response => {
                                if (typeof(response.data.redirect) !== "undefined")
                                    location.href = response.data.redirect;
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
                        }
                    }
                });
            },
        }
    };
</script>
