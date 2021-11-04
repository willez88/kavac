<template>
    <v-client-table :columns="columns" :data="records" :options="table_options" ref="tableResults">
        <div slot="code" slot-scope="props">
            <span>
                {{ (props.row.code) ? props.row.code : '' }}
            </span>
        </div>
        <div slot="application_date" slot-scope="props">
            <span>
                {{ (props.row.created_at) ? props.row.created_at : '' }}
            </span>
        </div>
        <div slot="sale_client" slot-scope="props">
            <span>
                {{ (props.row.sale_client.name) ? props.row.sale_client.name : '' }}
            </span>
        </div>
        <div slot="department" slot-scope="props">
            <span v-for="sale_good in props.row.sale_goods">
                <span v-for="good in sale_good">
                    {{ (props.row.sale_goods) ? good.department.name : '' }}
                </span>
            </span>
        </div>
        <div slot="id" slot-scope="props" class="text-center">
            <div class="d-inline-flex">
                 <button @click.prevent="setDetails('ServiceInfo', props.row.id, 'SaleServiceInfo')"
                        class="btn btn-info btn-xs btn-icon btn-action btn-tooltip"
                        title="Ver registro" data-toggle="tooltip" data-placement="bottom" type="button">
                    <i class="fa fa-eye"></i>
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
                columns: ['code', 'application_date', 'sale_client', 'department', 'status', 'id']
            }
        },
        created() {
            this.table_options.headings = {
                'code': 'Código',
                'application_date': 'Fecha de solicitud',
                'sale_client': 'Nombre del cliente',
                'department': 'Unidad o departamento responsable',
                'status': 'Estado de la solicitud',
                'id': 'Acción'
            };
            this.table_options.sortable = ['code', 'application_date', 'sale_client', 'department', 'status'];
            this.table_options.filterable = ['code', 'application_date', 'sale_client', 'department', 'status'];
            this.table_options.columnsClasses = {
                'code': 'col-md-2',
                'application_date': 'col-md-2',
                'sale_client': 'col-md-2',
                'department': 'col-md-2',
                'status': 'col-md-2',
                'id': 'col-md-2'
            };
        },
        mounted () {
            const vm = this;
            vm.getSalePendingService()
        },
        methods: {
            /**
             * Inicializa los datos del formulario
             *
             * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
             */
            reset() {
                
            },
            getSalePendingService() {
                const vm = this;

                axios.get('/sale/services/vue-pending-list/Aprobado').then(response => {
                    vm.records = response.data.records;
                });
            },

            /**
             * Método reemplaza el metodo setDetails para usar la referencia del parent por defecto
             *
             * @method    setDetails
             *
             * @author     Daniel Contreras <dcontreras@cenditel.gob.ve>
             *
             * @param     string   ref       Identificador del componente
             * @param     integer  id        Identificador del registro seleccionado
             * @param     object  var_list  Objeto con las variables y valores a asignar en las variables del componente
             */
            setDetails(ref, id, modal ,var_list = null) {
                const vm = this;
                if (var_list) {
                    for(var i in var_list){
                        vm.$parent.$refs[ref][i] = var_list[i];
                    }
                }else{
                    vm.$parent.$refs[ref].record = vm.$refs.tableResults.data.filter(r => {
                        return r.id === id;
                    })[0];
                }
                vm.$parent.$refs[ref].id = id;

                $(`#${modal}`).modal('show');
                document.getElementById("info_general").click();
            },
        }
    };
</script>
