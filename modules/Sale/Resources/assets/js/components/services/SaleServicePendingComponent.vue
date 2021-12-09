<template>
    <section>
        <div>
            <a class="btn btn-success btn-xs btn-icon btn-action"
               href="#" title="Aceptar solicitud" data-toggle="tooltip"
               @click="initPending('view_pending_a', $event)"
               v-if="request_type == 'accept'">
                <i class="fa fa-check"></i>
            </a>
            <a class="btn btn-danger btn-xs btn-icon btn-action"
               href="#" title="Rechazar solicitud" data-toggle="tooltip"
               @click="initPending('view_pending_r', $event)"
               v-else>
                <i class="fa fa-ban"></i>
            </a>
            <div class="modal fade text-left" tabindex="-1" role="dialog" id="view_pending_a">
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
                                <div class="col-md-6">
                                    <div class="form-group is-required">
                                        <label>Encargado del servicio:</label>
                                            <select2 :options="payroll_staffs"
                                                        v-model="record.payroll_staff_id"></select2>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-sm btn-round btn-modal-close"
                                    data-dismiss="modal">
                                Cerrar
                            </button>
                            <button type="button" @click="updateRecord('/sale/services/service-approved/')"
                                    class="btn btn-primary btn-sm btn-round btn-modal-save">
                                Guardar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade text-left" tabindex="-1" role="dialog" id="view_pending_r">
                <div class="modal-dialog modal-xs" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <h6>
                                ¿Seguro que desea rechazar esta solicitud?
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
                                    data-dismiss="modal">
                                Cerrar
                            </button>
                            <button type="button" @click="updateRecord('/sale/services/service-rejected/')"
                                    class="btn btn-primary btn-sm btn-round btn-modal-save">
                                Guardar
                            </button>
                        </div>
                    </div>
                </div>s
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
                    payroll_staff_id: '',
                },
                errors: [],
                payroll_staffs: [],
            }
        },
        props: {
            serviceid: Number,
            request_type: {
                type: String,
                required: true,
                default: 'accept'

            }
        },
        created() {
            this.getPayrollStaffs();
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
                    payroll_staff_id:''
                };
            },
            /**
             * Método que carga los trabajadores registrados para el select 
             *
             * @author  Daniel Contreras <dcontreras@cenditel.gob.ve>
             */
            getPayrollStaffs() {
                const vm = this;
                vm.payroll_staffs = [];

                axios.get('/sale/get-payroll-staffs').then(response => {
                        vm.payroll_staffs = response.data;
                });
            },

            /**
             * Método que carga el modal
             *
             * @author  Daniel Contreras <dcontreras@cenditel.gob.ve>
             */
            initPending(modal_id,event) {

                $(".modal-body #id").val( this.serviceid );
                if ($("#" + modal_id).length) {
                    $('#'+modal_id).modal('show');
                }
                event.preventDefault();
            },

            /**
             * Método que actualiza los registros al ser aprobados o rechazados
             *
             * @author  Daniel Contreras <dcontreras@cenditel.gob.ve>
             */
            updateRecord(url) {
                const vm = this;
                let id = $(".modal-body #id").val();
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
