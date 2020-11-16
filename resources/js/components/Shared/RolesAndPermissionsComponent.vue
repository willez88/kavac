<template>
    <div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-4 panel-legend">
                            <i class="fa fa-lock text-gray" title="Sin permiso de acceso" data-toggle="tooltip"></i>
                            <span>Sin permiso otorgado</span>
                        </div>
                    </div>
                    <div class="row mg-bottom-20">
                        <div class="col-md-4 panel-legend">
                            <i class="fa fa-unlock text-success" title="Permiso de acceso configurado" data-toggle="tooltip"></i>
                            <span>Permiso otorgado</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3 form-group">
                            <div class="input-group input-sm">
                                <span class="input-group-addon">
                                    <i class="fa fa-search"></i>
                                </span>
                                <input placeholder="Filtrar" title="Indique el texto para filtrar los permisos"
                                       data-toggle="tooltip" type="text" class="form-control" v-model="search">
                            </div>
                        </div>
                    </div>
                    <table class="table table-hover table-striped dt-responsive table-roles-permissions">
                        <thead>
                            <tr>
                                <th class="text-center border-right col-2" rowspan="2">PERMISOS</th>
                                <th class="text-center col-10" :colspan="roles.length">ROLES</th>
                            </tr>
                            <tr>
                                <th class="text-center" :title="role.description" data-toggle="tooltip" v-for="role in roles">
                                    <p-check class="p-icon p-plain" color="text-success" off-color="text-gray"
                                             v-model="allPermissionByRol" :value="role.id"
                                             @change="togglePermissionsByRol(role.id)"
                                             data-toggle="tooltip" title="Seleccionar todos los permisos para este rol" toggle>
                                        <i class="fa fa-unlock" slot="extra"></i>
                                        <i class="fa fa-lock" slot="off-extra"></i>
                                        <label slot="off-label"></label>
                                    </p-check>
                                    {{ role.name }}
                                </th>
                            </tr>
                        </thead>
                        <tbody v-for="moduleGroup in moduleGroups">
                            <tr>
                                <td>&#160;</td>
                                <td class="text-center" :colspan="roles.length">
                                    <span class="card-title text-uppercase text-module">
                                        Módulo [{{ getGroupName(moduleGroup) }}]
                                    </span>
                                </td>
                            </tr>
                            <tr v-for="(filteredPermission, index) in filterGroupPermissions(moduleGroup)"
                                v-if="searchResult(filteredPermission, moduleGroup)">
                                <td class="text-uppercase">
                                    {{ filteredPermission.short_description || filteredPermission.name }}
                                </td>
                                <td v-for="(cellRole, idx) in roles" class="text-center">
                                    <p-check class="p-icon p-plain" :class="'role_' + cellRole.id" color="text-success"
                                             off-color="text-gray" data-toggle="tooltip" :title="'Rol: ' + cellRole.name"
                                             :value="cellRole.id + '_' + filteredPermission.id"
                                             :name="cellRole.id + '_' + filteredPermission.id"
                                             v-model="record.roles_attach_permissions" toggle>
                                        <i class="fa fa-unlock" slot="extra"></i>
                                        <i class="fa fa-lock" slot="off-extra"></i>
                                        <label slot="off-label"></label>
                                    </p-check>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer text-right">
            <div class="btn-display">
                <button type="button" @click="reset" class="btn btn-default btn-icon btn-round"
                        data-toggle="tooltip" title="Borrar datos del formulario">
                    <i class="fa fa-eraser"></i>
                </button>
                <button type="button" @click="redirect_back(route_list)"
                        class="btn btn-warning btn-icon btn-round" data-toggle="tooltip"
                        title="Cancelar y regresar">
                    <i class="fa fa-ban"></i>
                </button>
                <button type="button" @click="createRecord(saveUrl, false, false)"
                        class="btn btn-success btn-icon btn-round" data-toggle="tooltip" title="Guardar registro">
                    <i class="fa fa-save"></i>
                </button>
            </div>
            <button type="button" @click="reset" class="btn btn-default btn-icon btn-round"
                    data-toggle="tooltip" title="Borrar datos del formulario">
                <i class="fa fa-eraser"></i>
            </button>
            <button type="button" @click="redirect_back(route_list)"
                    class="btn btn-warning btn-icon btn-round" data-toggle="tooltip"
                    title="Cancelar y regresar">
                <i class="fa fa-ban"></i>
            </button>
            <button type="button" @click="createRecord(saveUrl, false, false)"
                    class="btn btn-success btn-icon btn-round" data-toggle="tooltip" title="Guardar registro">
                <i class="fa fa-save"></i>
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                record: {
                    roles_attach_permissions: []
                },
                moduleGroups: [],
                allPermissionByRol: [],
                search: '',
                showGroups: [],
                roles: [],
                permissions: []
            }
        },
        props: ['rolesPermissionsUrl', 'saveUrl'],
        watch: {
            record: {
                deep: true,
                handler: function(newValue, oldValue) {
                    const vm = this;
                }
            }
        },
        methods: {
            /**
             * Inicializa los valores del componente
             *
             * @method     reset
             *
             * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             */
            reset: function() {
                let vm = this;
                vm.record.roles_attach_permissions = [];
            },
            /**
             * Método que genera un listado de módulos con sus respectivos permisos
             *
             * @method     setModuleGroups
             *
             * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             */
            setModuleGroups: function() {
                let vm = this;
                let moduleName = '';
                vm.moduleGroups = [];
                $.each(vm.permissions, function(index, perm) {
                    if (moduleName !== perm.model_prefix) {
                        moduleName = perm.model_prefix;
                        vm.moduleGroups.push(moduleName);
                    }
                });
            },
            /**
             * Obtiene el nombre de un grupo de conjunto de permisos
             *
             * @method     getGroupName
             *
             * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             *
             * @param      {string}         moduleGroup    Nombre del módulo o grupo al que pertenece un permiso
             *
             * @return     {string}         Nombre del grupo por el cual asociar un conjunto de permisos
             */
            getGroupName: function(moduleGroup) {
                return moduleGroup.substring(0, 1) === '0' ? moduleGroup.substring(1) : moduleGroup;
            },
            /**
             * Método que filtra los permisos según el grupo o modulo al cual pertenecen
             *
             * @method     filterGroupPermissions
             *
             * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             *
             * @param      {string} group   Nombre del grupo o módulo
             *
             * @return     {array}          Arreglo con información de los permisos asociados a un grupo o módulo
             */
            filterGroupPermissions: function(group) {
                let vm = this;
                return vm.permissions.filter((permission) => {
                    return permission.model_prefix === group;
                });
            },
            /**
             * Método que activa o desactiva todos los permisos para un rol seleccionado
             *
             * @method     togglePermissionsByRol
             *
             * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             *
             * @param      {integer}    roleId  Identificador del rol del cual activar o desactivar todos los permisos
             */
            togglePermissionsByRol: function(roleId) {
                let vm = this;
                vm.loading = true;
                let listRol = vm.allPermissionByRol.filter(function(value, index, arr) {
                    return value === roleId;
                });

                if (listRol.length > 0) {
                    $.each(vm.permissions, function(index, perm) {
                        if (vm.record.roles_attach_permissions.indexOf(`${roleId}_${perm.id}`) < 0) {
                            vm.record.roles_attach_permissions.push(`${roleId}_${perm.id}`);
                        }
                    });
                }
                else {
                    let perms = vm.record.roles_attach_permissions.filter(function(value, index) {
                        return value.indexOf(`${roleId}_`) < 0;
                    });
                    vm.record.roles_attach_permissions = perms;
                }
                vm.loading = false;
            },
            /**
             * Método que permite filtrar los permisos de acuerdo a un campo de búsqueda
             *
             * @method     searchResult
             *
             * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>

             * @param      {object}     filteredPermission    Objeto con información del permiso a filtrar
             * @param      {string}     moduleGroup           Nombre del módulo al cual pertenece el permiso a filtrar
             *
             * @return     {boolean}    Devuelve verdadero si el permiso se encuentra en la consulta del usuario
             *                          y lo muestra, de lo contrario retorna falso y lo oculta
             */
            searchResult: function(filteredPermission, moduleGroup) {
                let vm = this;
                let result = vm.search==='' ||
                             filteredPermission.short_description.indexOf(vm.search) >= 0 ||
                             filteredPermission.name.indexOf(vm.search) >= 0;

                if (result && vm.showGroups.indexOf(moduleGroup) < 0) {
                    vm.showGroups.push(moduleGroup);
                }

                return result;
            },
            /**
             * Obtiene los roles y permisos registrados para asignarlo a los datos a mostrar
             *
             * @method     getRolesAndPermissions
             *
             * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             */
            getRolesAndPermissions: async function() {
                let vm = this;
                vm.loading = true;
                await axios.get(vm.rolesPermissionsUrl).then(response => {
                    if (response.data.result) {
                        vm.roles = response.data.roles;
                        vm.permissions = response.data.permissions;
                        vm.roles.forEach(function(role) {
                            role.permissions.forEach(function(perm) {
                                vm.record.roles_attach_permissions.push(`${role.id}_${perm.id}`);
                            });
                        });
                        vm.setModuleGroups();
                    }
                }).catch(error => {
                    vm.logs('RolesAndPermissionsComponent', 264, error, 'getRolesAndPermissions');
                });
                vm.loading = false;
            }
        },
        created() {
            let vm = this;
            vm.getRolesAndPermissions();
        },
        mounted() {
            let vm = this;
            vm.setModuleGroups();
            vm.record.roles_attach_permissions = [];
            vm.allPermissionByRol = [];

            /**
             * Muestra los botones cuando se baja el scroll de la pantalla a una altura predeterminada y
             * los oculta cuando dicha altura es menor a la indicada
             */
            $(window).scroll(function () {
                if ($(this).scrollTop() > 50) {
                    $('.btn-display').fadeIn();
                }
                else {
                    $('.btn-display').fadeOut();
                }
            });
        }
    };
</script>
