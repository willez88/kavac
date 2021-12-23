<template>
    <section>
        <div id="SaleBillAccept" class="modal fade text-left" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-xs" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h6>
                            ¿Seguro que desea aprobar esta solicitud?
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
                            <div class="col-md-12">
                                <p>
                                    Una vez aprobada la operación no se podrán realizar cambios en la misma.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm btn-round btn-modal-close"
                                data-dismiss="modal" @click="reset()">
                            Cerrar
                        </button>
                        <button type="button" @click="updateRecord('/sale/bills/bill-approved/')"
                                class="btn btn-primary btn-sm btn-round btn-modal-save">
                            Guardar
                        </button>
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
                    id:'',
                },
                errors: [],
            }
        },
        methods: {
            /**
             * Método que borra todos los datos del formulario
             *
             * @author  Daniel Contreras <dcontreras@cenditel.gob.ve>
             */
            reset() {
                this.record = {
                    id: '',
                };
                this.errors = [];
            },

            /**
             * Método que actualiza los registros al ser aprobados o rechazados
             *
             * @author  Daniel Contreras <dcontreras@cenditel.gob.ve>
             */
            updateRecord(url) {
                const vm = this;
                let id = vm.record.id;
                if(typeof(url) != 'undefined'){
                    axios.put(url + id, vm.record).then(response => {
                        if (typeof(response.data.redirect) !== "undefined")
                            location.href = response.data.redirect;
                    }).catch(error => {
                        vm.errors = [];
                        if (typeof(error.response) !="undefined") {
                            for (let index in error.response.data.errors) {
                                if (error.response.data.errors[index]) {
                                    vm.errors.push(error.response.data.errors[index][0]);
                                }
                            }
                        }
                    });
                }
            }
        },
    };
</script>
