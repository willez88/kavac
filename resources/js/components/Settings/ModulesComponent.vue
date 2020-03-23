<template>
    <div class="row">
        <div class="col-3">
            <div class="card mb-4" style="min-height:100%">
                <div class="card-header text-center" style="padding-bottom: 15px;color: #0073b7;">
                    Estatus
                </div>
                <div class="list-group list-group-flush log-menu">
                    <a href="javascript:void(0)" data-toggle="tooltip" title=""
                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center active" data-original-title="Todos los módulos">
                        <span class="level-name">
                            <i class="fa fa-fw fa-list"></i> Todos
                        </span>
                    </a>
                    <a href="javascript:void(0)" data-toggle="tooltip" title=""
                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" data-original-title="Módulos sin instalar">
                        <span class="level-name">
                            <i class="fa fa-fw fa-list"></i> Sin Instalar
                        </span>
                    </a>
                    <a href="javascript:void(0)" data-toggle="tooltip" title=""
                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" data-original-title="Módulos instalados">
                        <span class="level-name">
                            <i class="fa fa-fw fa-list"></i> Instalados
                        </span>
                    </a>
                    <a href="javascript:void(0)" data-toggle="tooltip" title=""
                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" data-original-title="Módulos instalados">
                        <span class="level-name">
                            <i class="fa fa-fw fa-list"></i> Inhabilitados
                        </span>
                    </a>
                    <a href="javascript:void(0)" data-toggle="tooltip" title=""
                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" data-original-title="Módulos instalados">
                        <span class="level-name">
                            <i class="fa fa-fw fa-list"></i> Habilitados
                        </span>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-9">
            <div class="card mb-4" style="min-height:100%">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="input-group input-sm">
                                <input placeholder="Buscar módulo..." data-toggle="tooltip" type="text"
                                data-original-title="Escriba el nombre o descripción del módulo que desea buscar"
                                class="form-control">
                                <span class="input-group-addon">
                                    <i class="now-ui-icons ui-1_zoom-bold"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-6 mb-4" v-for="module in modules">
                            <div class="list-group list-group-modules">
                                <a href="javascript:void(0);" class="list-group-item" data-toggle="tooltip"
                                   :data-original-title="'Ver detalles del módulo de ' + module.name"
                                   @click="viewDetails(module.alias)">
                                    <div class="media">
                                        <div class="media-left">
                                            <img src="/images/default-avatar.png" alt="" class="img-responsive">
                                        </div>
                                        <div class="media-middle media-body">
                                            <h5 class="media-heading">{{ module.name }}</h5>
                                            <small class="text-muted">{{ module.description }}</small>
                                        </div>
                                        <div class="media-middle media-right">
                                            <!--<button data-toggle="tooltip" type="button"
                                                    class="btn btn-info btn-xs btn-icon btn-action"
                                                    data-original-title="Ver detalles del módulo">
                                                <i class="fa fa-eye"></i>
                                            </button>-->
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a class="btn btn-primary btn-show-modal" data-toggle="modal" href='#modal_details'></a>
        <div class="modal fade" id="modal_details">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h6 class="modal-title card-title">{{ details.name }}</h6>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-2">
                                <img src="/images/default-avatar.png" alt="" class="img-responsive">
                            </div>
                            <div class="col-10">
                                <div class="row">
                                    <div class="col-12">
                                        <b>Versión:</b> {{ details.version }}
                                    </div>
                                    <div class="col-12">
                                        <b>Descripción:</b> {{ details.description }}
                                    </div>
                                    <div class="col-12">
                                        <b>Requerimientos:</b>
                                        <ul>
                                            <li v-for="(requirement, index) in details.requirements">
                                                {{ index }} - v{{ requirement }}
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-12">
                                        <b>Autor(es):</b>
                                        <ul>
                                            <li v-for="author in details.authors">
                                                {{ author.name }}
                                                [<span v-for="email in author.email" class="span-email">({{ email }})</span>]
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-12" v-if="(details.links!=='')">
                                        <b>Sitio Web:</b>
                                        <a :href="details.link" target="_blank" data-toggle="tooltip"
                                           data-original-title="Sitio web del módulo">{{ details.link }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <b>Estatus:</b>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary">Instalar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
    .list-group-item:hover {
        text-decoration: none
    }
    .list-group-item .media .media-left img {
        height:60px;
    }
    small {
        font-size: 70%;
    }
    .btn-show-modal {
        display:none;
    }
    #modal_details .modal-dialog {
        max-width: 60%;
        margin:10% auto;
    }
    #modal_details .modal-title {
        margin-top: 0
    }
    #modal_details img {
        height: 80px;
    }
    .span-email {
        margin-left: 5px;
        margin-right: 5px;
    }
</style>

<script>
    export default {
        data() {
            return {
                details: {}
            }
        },
        props: ['modules'],
        methods: {
            viewDetails(module) {
                let vm = this;
                axios.post(`${window.app_url}/modules/details`, {
                    module: module
                }).then(response => {
                    vm.details = response.data.details;
                    $(".btn-show-modal").click();
                }).catch(error => {
                    console.warn(error);
                });
            }
        },
        created() {

        },
        mounted() {

        }
    };
</script>
