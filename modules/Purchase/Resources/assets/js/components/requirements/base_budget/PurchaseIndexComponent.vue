<template>
    <section>
        <v-client-table :columns="columns" :data="records" :options="table_options">
            <div slot="created_at" slot-scope="props" class="text-center">
                <div align="center">
                    {{ format_date(props.row.created_at) }}
                </div>
            </div>
            <div slot="currency.name" slot-scope="props">
                <div align="center">
                    <h6 v-if="props.row.currency">
                        {{ props.row.currency.symbol }} - {{ props.row.currency.name }}
                    </h6>
                    <h6 v-else>
                        Tipo de moneda no asigando
                    </h6>
                </div>
            </div>
            <div slot="status" slot-scope="props">
                <div class="d-inline-flex">
                    <span class="badge badge-danger"  v-show="props.row.status == 'WAIT'">
                        <strong>POR COMPLETAR</strong>
                    </span>
                    <span class="badge badge-primary"  v-show="props.row.status == 'WAIT_QUOTATION'">
                        <strong>ESPERA POR COTIZACIÓN</strong>
                    </span>
                    <span class="badge badge-info"    v-show="props.row.status == 'QUOTED'">
                        <strong>COTIZADO</strong>
                    </span>
                    <span class="badge badge-success" v-show="props.row.status == 'BOUGHT'">
                        <strong>COMPRADO </strong>
                    </span>
                </div>
            </div>
            <div slot="id" slot-scope="props" class="text-center">
                <div class="d-inline-flex">
                    <button class="btn btn-success btn-xs btn-icon btn-action"
                            title="Completar presupuesto base"
                            data-toggle="tooltip"
                            v-on:click="editForm(props.row.id)"
                            v-if="props.row.status == 'WAIT'">
                        <i class="fa fa-list"></i>
                    </button>
                    <purchase-base-budget-show :id="props.row.id" :route_show="'/purchase/base_budget/'+props.row.id" />
                    <button class="btn btn-warning btn-xs btn-icon btn-action"
                            title="Modificar registro"
                            data-toggle="tooltip"
                            v-on:click="editForm(props.row.id)"
                            v-if="props.row.status == 'WAIT_QUOTATION'">
                        <i class="fa fa-edit"></i>
                    </button>
                    <button @click="deleteRecord(props.index,'/purchase/base_budget')"
                            class="btn btn-danger btn-xs btn-icon btn-action" 
                            title="Eliminar registro" data-toggle="tooltip" 
                            type="button">
                        <i class="fa fa-trash-o"></i>
                    </button>
                </div>
            </div>
        </v-client-table>
    </section>

</template>
<script>
    export default{
        data(){
            return {
                records:[],
                columns: [  
                            'created_at',
                            'currency.name',
                            'status',
                            'id'
                        ],
            }
        },
        created(){
            this.table_options.headings = {
                'created_at': 'Fecha',
                'currency.name': 'Tipo de moneda',
                'status':'Estatus',
                'id': 'ACCIÓN'
            };
            this.table_options.columnsClasses = {
                'created_at'    : 'col-xs-2',
                'currency.name': 'col-xs-6 text-center',
                'status':'col-xs-2 text-center',
                'id'      : 'col-xs-2'
            };
        },
        mounted(){
            axios.get('/purchase/base_budget').then(response => {
                this.records = response.data.records;
            });
        },
        method:{
            /**
             * Reescribe el metodo para cambiar su comportamiento por defecto
             * Método para la eliminación de registros
             *
             * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             *
             * @param  {integer} id    ID del Elemento seleccionado para su eliminación
             * @param  {string}  url   Ruta que ejecuta la acción para eliminar un registro
             */
            deleteRecord(id, url) {
                const vm = this;
                /** @type {string} URL que atiende la petición de eliminación del registro */
                var url = (url)?url:vm.route_delete;
                url = (!url.includes('http://') || !url.includes('http://'))
                      ? `${window.app_url}${(url.startsWith('/'))?'':'/'}${url}` : url;

                bootbox.confirm({
                    title: "¿Eliminar registro?",
                    message: "¿Esta seguro de eliminar este registro?",
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
                            /** @type {object} Objeto con los datos del registro a eliminar */
                            let recordDelete = JSON.parse(JSON.stringify(vm.records.filter((rec) => {
                                return rec.id === id;
                            })[0]));

                            axios.delete(`${url}${url.endsWith('/')?'':'/'}${recordDelete.id}`).then(response => {
                                if (typeof(response.data.error) !== "undefined") {
                                    /** Muestra un mensaje de error si sucede algún evento en la eliminación */
                                    vm.showMessage('custom', 'Alerta!', 'warning', 'screen-error', response.data.message);
                                    return false;
                                }
                                /** @type {array} Arreglo de registros filtrado sin el elemento eliminado */
                                vm.records = JSON.parse(JSON.stringify(vm.records.filter((rec) => {
                                    return rec.id !== id;
                                })));
                                vm.showMessage('destroy');
                            }).catch(error => {
                                vm.logs('mixins.js', 498, error, 'deleteRecord');
                            });
                        }
                    }
                });
            },
        }
    };
</script>
