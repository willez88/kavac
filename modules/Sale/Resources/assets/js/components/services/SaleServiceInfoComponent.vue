<template>
        <div id="SaleServiceInfo" class="modal fade" tabindex="-1" role="dialog"
             aria-labelledby="SaleServiceInfoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document" style="max-width:60rem">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h6>
                            <i class="icofont icofont-read-book ico-2x"></i>
                            Información de la Solicitud Registrada
                        </h6>
                    </div>

                    <div class="modal-body">
                        <div class="alert alert-danger" v-if="errors.length > 0">
                            <ul>
                                <li v-for="error in errors">{{ error }}</li>
                            </ul>
                        </div>
                        <div class="row">
                            <ul class="nav nav-tabs custom-tabs justify-content-center" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#general" id="info_general" role="tab">
                                        <i class="ion-android-person"></i> Datos del solicitante
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#service_data" role="tab">
                                        <i class="ion-android-person"></i> Datos de la solicitud de servicios
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#requiremnt" role="tab">
                                        <i class="ion-arrow-person"></i> Requerimientos
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content">
                            <div class="tab-pane active" id="general" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <strong>Cliente</strong>
                                            <div class="row" style="margin: 1px 0">
                                                <span v-if="record.sale_client && record.sale_client.name" class="col-md-12" id="client">
                                                    {{ record.sale_client && record.sale_client.name ? record.sale_client.name : 'No definido' }}
                                                </span>
                                                <span v-if="record.sale_client && record.sale_client.business_name" class="col-md-12" id="client">
                                                    {{ record.sale_client && record.sale_client.business_name ? record.sale_client.business_name : 'No definido' }}
                                                </span>
                                            </div>
                                            <input type="hidden" id="id">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <strong>Cédula de identidad / RIF</strong>
                                            <div class="row" style="margin: 1px 0">
                                                <span v-if="record.sale_client && record.sale_client.id_number" class="col-md-12" id="client">
                                                    {{ record.sale_client && record.sale_client.id_number ? record.sale_client.id_number : 'No definido' }}
                                                </span>
                                                <span v-if="record.sale_client && record.sale_client.rif" class="col-md-12" id="client">
                                                    {{ record.sale_client && record.sale_client.rif ? record.sale_client.rif : 'No definido' }}
                                                </span>
                                            </div>
                                            <input type="hidden" id="id">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <strong>Correo electrónico</strong>
                                            <div class="row" style="margin: 1px 0">
                                                <div v-if="record.sale_client">
                                                    <p v-for="client_email in record.sale_client.sale_clients_email" class="col-md-12" id="client_email">
                                                        {{ record.sale_client && record.sale_client.sale_clients_email ? client_email.email : 'No definido' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <strong>Número telefónico</strong>
                                            <div class="row" style="margin: 1px 0">
                                                <div v-if="record.sale_client && record.sale_client.phones">
                                                    <p v-for="client_phone in record.sale_client.phones" class="col-md-12" id="client_phone">
                                                        {{ record.sale_client && record.sale_client.phones ? client_phone.extension + '-' + client_phone.area_code + client_phone.number : 'No definido' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <strong>Organización</strong>
                                            <div class="row" style="margin: 1px 0">
                                                <span class="col-md-12" id="organization">
                                                    {{ record.organization ? record.organization : 'No definido' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <strong>Descripción de la actividad económica</strong>
                                            <div class="row" style="margin: 1px 0">
                                                <span class="col-md-12" id="description">
                                                    {{ record.description ? record.description : 'No definido' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <div class="tab-pane" id="service_data" role="tabpanel">
                                    <div class="row">
                                        <div v-if="record.payroll_staff_id" class="col-md-4">
                                            <div class="form-group">
                                                <strong>Encargado del servicio</strong>
                                                <div class="row" style="margin: 1px 0">
                                                    <span class="col-md-12" id="service_manager">
                                                        {{
                                                            record.payroll_staff_id
                                                                ? record.payroll_staff.first_name + ' ' + record.payroll_staff.last_name
                                                                    + ' - ' + record.payroll_staff.id_number 
                                                                : 'No definido'
                                                        }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <strong>Servicio</strong>
                                                <div class="row" style="margin: 1px 0">
                                                    <div v-if="record.sale_goods">
                                                        <div v-for="sale_good in record.sale_goods">
                                                            <div v-for="good in sale_good" class="col-md-12" id="service">
                                                                <p>
                                                                    {{ record.sale_goods ? good.name : 'No definido'}}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <strong>Descripción</strong>
                                                <div class="row" style="margin: 1px 0">
                                                    <div v-if="record.sale_goods">
                                                        <div v-for="sale_good in record.sale_goods" class="col-md-12" id="service_description">
                                                            <p v-for="good in sale_good">
                                                                {{ record.sale_goods ? good.description : 'No definido'}} 
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <strong>Resumen de la solicitud</strong>
                                                <div class="row" style="margin: 1px 0">
                                                    <span class="col-md-12" id="service_resume">
                                                        {{ record.resume ? record.resume : 'No definido'}} 
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <strong>Unidad o departamento</strong>
                                                <div class="row" style="margin: 1px 0">
                                                    <div v-if="record.sale_goods">
                                                        <div v-for="sale_good in record.sale_goods" class="col-md-12" id="service_department">
                                                            <p v-for="good in sale_good">
                                                                {{ record.sale_goods && good.department ? good.department.name : 'No definido'}} 
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <strong>Nombre</strong>
                                                <div class="row" style="margin: 1px 0">
                                                    <div v-if="record.sale_goods">
                                                        <div v-for="sale_good in record.sale_goods" class="col-md-12" id="service_name">
                                                            <p v-for="good in sale_good">
                                                                {{ record.sale_goods && good.payroll_staff ? good.payroll_staff.first_name : 'No definido'}} 
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <strong>Apellido</strong>
                                                <div class="row" style="margin: 1px 0">
                                                    <div v-if="record.sale_goods">
                                                        <div v-for="sale_good in record.sale_goods" class="col-md-12" id="service_last_name">
                                                            <p v-for="good in sale_good">
                                                                {{ record.sale_goods && good.payroll_staff ? good.payroll_staff.last_name : 'No definido'}} 
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <strong>Teléfono</strong>
                                                <div class="row" style="margin: 1px 0">
                                                    <div v-if="record.sale_goods">
                                                        <div v-for="sale_good in record.sale_goods">
                                                            <div v-for="good in sale_good">
                                                                <div v-if="good.payroll_staff">
                                                                    <p v-for="phone in good.payroll_staff.phones" class="col-md-12" id="service_phone">
                                                                        {{ record.sale_goods
                                                                            ? phone.extension + '-' + phone.area_code + phone.number : 'No definido'
                                                                        }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <strong>Correo electrónico</strong>
                                                <div class="row" style="margin: 1px 0">
                                                    <div v-if="record.sale_goods">
                                                        <div v-for="sale_good in record.sale_goods" class="col-md-12" id="service_email">
                                                            <p v-for="good in sale_good">
                                                                {{ record.sale_goods && good.payroll_staff ? good.payroll_staff.email : 'No definido'}} 
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="requiremnt" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <strong>Requerimiento</strong>
                                                <div class="row" style="margin: 1px 0">
                                                    <div v-if="record.sale_service_requirement">
                                                        <p v-for="requiremnt in record.sale_service_requirement">
                                                            <span class="col-md-12" id="service_requirement">
                                                                {{ record.sale_service_requirement ? requiremnt.name : 'No definido' }}
                                                            </span>
                                                        </p>
                                                    </div>
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
                record: [],
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
    };
</script>
