<template>
    <div class="row">
        <div class="col-12 mb-4" v-if="showDetail">
            <div class="row">
                <div class="col-4">
                    <img src="/images/default-avatar.png" alt="" class="img-responsive" style="width:100%">
                    <div class="row">
                        <div class="col-12 mt-4 text-yellow text-center" title="1000 instalaciones"
                             data-toggle="tooltip">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-half-empty"></i>
                            <i class="fa fa-star-o"></i>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="text-center">{{ details.name }}</h2>
                            <p>{{ details.long_description }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">{{ details.description }}</div>
                        <div class="col-4">
                            <ul>
                                <li v-for="author in details.authors">
                                    <a :href="'mailto:'+author.email[0]">{{ author.name }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <button type="button" class="btn btn-info btn-simple btn-block">Instalar</button>
                        </div>
                        <div class="col-4">
                            <button type="button" class="btn btn-primary btn-simple btn-block">
                                {{ (details.enabled) ? 'Deshabilitar' : 'Habilitar' }}
                            </button>
                        </div>
                        <div class="col-4">
                            <button type="button" class="btn btn-success btn-simple btn-block">Configurar</button>
                        </div>
                    </div>
                    <div class="row" v-if="details.requirements">
                        <div class="col-12 mt-4">
                            <h6 class="md-title">Requerimientos:</h6>
                            <ul v-if="details.requirements">
                                <li v-for="(version, require) in details.requirements">
                                    <i :class="checkRequirement(require)"></i>
                                    {{ require }} v{{ version }}
                                </li>
                            </ul>
                            <p v-else>No aplica</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <button type="button" class="btn btn-default btn-simple btn-block" @click="resetDetails">
                        Listar Módulos
                    </button>
                </div>
                <div class="col-8">
                    <h6 class="md-title text-right" title="Versión del módulo" data-toggle="tooltip">
                        v{{ details.version }}
                    </h6>
                </div>
            </div>
        </div>
        <div class="col-12 mb-4" v-else>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <button type="button" class="btn btn-primary btn-simple btn-sm" data-toggle="tooltip"
                            title="Listar todos los módulos disponibles">Todos</button>
                    <button type="button" class="btn btn-primary btn-simple btn-sm" data-toggle="tooltip"
                            title="Listar sólo los módulos que no están instalados en la aplicación">Sin instalar</button>
                    <button type="button" class="btn btn-primary btn-simple btn-sm" data-toggle="tooltip"
                            title="Listar sólo los módulos instalados en la aplicación">Instalados</button>
                    <button type="button" class="btn btn-primary btn-simple btn-sm" data-toggle="tooltip"
                            title="Listar sólo los módulos instalados e inhabilitados">Inhabilitados</button>
                    <button type="button" class="btn btn-primary btn-simple btn-sm" data-toggle="tooltip"
                            title="Listar sólo los módulos instalados y habilitados">Habilitados</button>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
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
                <div class="col-4 mb-4" v-for="module in modules">
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
</template>

<style>
    small {font-size: 70%;}
    .list-group-item:hover {text-decoration: none}
    .list-group-item .media .media-left img {height:60px;}
    .btn-sm {font-size: 0.8571em;}
</style>

<script>
    export default {
        data() {
            return {
                showDetail: false,
                details: {}
            }
        },
        props: ['modules'],
        methods: {
            /**
             * Obtiene información acerca del módulo seleccionado
             *
             * @method     viewDetails
             *
             * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             *
             * @param      {string}         module    Nombre del módulo del cual se desea obtener información
             */
            viewDetails(module) {
                let vm = this;
                axios.post(`${window.app_url}/modules/details`, {
                    module: module
                }).then(response => {
                    vm.details = response.data.details;
                    vm.showDetail = true;
                }).catch(error => {
                    console.warn(error);
                });
            },
            /**
             * Reinicia los valores para ver detalles de los módulos
             *
             * @method     resetDetails
             *
             * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             */
            resetDetails() {
                let vm = this;
                vm.showDetail = false,
                vm.details = {};
            },
            /**
             * Verifica si se cumplen o no los requerimientos del módulo
             *
             * @method     checkRequirement
             *
             * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             *
             * @param      {string}     moduleName    Nombre del módulo del cual se van a verificar los requerimientos
             *
             * @return     {string}     Estilo a mostrar en el icono que representa si se cumple el requerimiento
             */
            checkRequirement(moduleName) {
                return 'fa fa-check-square-o';
            }
        },
        created() {

        },
        mounted() {
            $("[data-toggle=tooltip]").tooltip();
        }
    };
</script>
