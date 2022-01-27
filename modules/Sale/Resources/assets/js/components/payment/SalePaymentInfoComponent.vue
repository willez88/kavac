<template>
    <div id="SalePaymentInfo" class="modal fade" tabindex="-1" role="dialog"
         aria-labelledby="SalePaymentInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="max-width:60rem">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h6>
                        <i class="icofont icofont-read-book ico-2x"></i>
                         Información de los Pagos Registrados
                    </h6>
                </div>

                <div class="modal-body">
                    <ul class="nav nav-tabs custom-tabs justify-content-center" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" id="info_general" href="#general" role="tab">
                                <i class="ion-android-person"></i> Datos del Cliente
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#products" role="tab">
                                <i class="ion-arrow-swap"></i> Datos del Servicio o Pedido
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#products" role="tab">
                                <i class="ion-cash"></i> Datos del Pago
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="general" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>Tipo de persona</strong>
                                        <div class="row" style="margin: 1px 0">
                                            <span class="col-md-12">
                                                {{ record.type_person_juridica }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="record.type_person == 'Natural'" class="col-md-6">
                                    <div class="form-group">
                                        <strong>Nombre y apellido</strong>
                                        <div class="row" style="margin: 1px 0">
                                            <span class="col-md-12">
                                                {{ record.name }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="record.type_person == 'Natural'" class="col-md-6">
                                    <div class="form-group">
                                        <strong>Identificación</strong>
                                        <div class="row" style="margin: 1px 0">
                                            <span class="col-md-12">
                                                {{ record.id_number }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="record.type_person == 'Jurídica'" class="col-md-6">
                                    <div class="form-group">
                                        <strong>Nombre de la empresa</strong>
                                        <div class="row" style="margin: 1px 0">
                                            <span class="col-md-12">
                                                {{ record.organization }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="record.type_person == 'Jurídica'" class="col-md-6">
                                    <div class="form-group">
                                        <strong>RIF</strong>
                                        <div class="row" style="margin: 1px 0">
                                            <span class="col-md-12">
                                                {{ record.rif }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>Teléfono de contacto  </strong>
                                        <div class="row" style="margin: 1px 0">
                                            <span class="col-md-12">
                                                {{ record.phones }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>Correo electrónico</strong>
                                        <div class="row" style="margin: 1px 0">
                                            <span class="col-md-12">
                                                {{ record.emails }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>Fecha de pago</strong>
                                        <div class="row" style="margin: 1px 0">
                                            <span class="col-md-12">
                                                {{ record.payment_date }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6" v-if="record.rejected_reason">
                                    <div class="form-group">
                                        <strong>Pago rechazado</strong>
                                        <div class="row" style="margin: 1px 0">
                                            <span class="col-md-12">
                                                {{ record.payment_refuse }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-default btn-sm btn-round btn-modal-close"
                            data-dismiss="modal">
                        Cerrar
                    </button>
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
                    total_amount:'',
                },
                errors: [],
            }
        },
        created() {
        },
        methods: {            
            /**
             * Método que borra todos los datos del formulario
             * 
             * @author  Daniel Contreras <dcontreras@cenditel.gob.ve>
             */
            reset() {
            },
        },
    }
</script>
