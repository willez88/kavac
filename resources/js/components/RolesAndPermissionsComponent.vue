<template>
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
                               data-toggle="tooltip" type="text" class="form-control">
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
                    <!--<div class="collapse show" :id="'perm' + moduleGroup">-->
                        <tr v-for="filteredPermission in filterGroupPermissions(moduleGroup)">
                            <td class="text-uppercase">
                                {{ filteredPermission.short_description || filteredPermission.name }}
                                {{ filteredPermission }}
                            </td>
                            <td v-for="cellRole in roles" class="text-center">
                                <p-check class="p-icon p-plain" :class="'role_' + cellRole.id" color="text-success"
                                         off-color="text-gray" data-toggle="tooltip" :title="'Rol: ' + cellRole.name"
                                         :value="cellRole.id + '_' + filteredPermission.id"
                                         :checked="roleHasPermission(cellRole.id, filteredPermission)"
                                         :name="cellRole.id + '_' + filteredPermission.id"
                                         v-model="record.roles_attach_permissions" toggle>
                                    <i class="fa fa-unlock" slot="extra"></i>
                                    <i class="fa fa-lock" slot="off-extra"></i>
                                    <label slot="off-label"></label>
                                </p-check>
                            </td>
                        </tr>
                    <!--</div>-->
                </tbody>
            </table>
        </div>
    </div>
</template>

<style>
    .text-module {font-weight: bold;}
    .btn-collapse, .btn-collapse:hover {
        background-color: transparent;
    }
    .btn-collapse {
        padding:4px;font-size:0.7em;color:#0073b7;
    }
</style>

<script>
    export default {
        data() {
            return {
                record: {
                    roles_attach_permissions: []
                },
                moduleGroups: [],
                allPermissionByRol: []
            }
        },
        props: ['roles', 'permissions'],
        methods: {
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
            roleHasPermission: function(roleId, permission) {
                let vm = this;
                let hasPerm = vm.roles.filter(function(role) {
                    return role.id === roleId && role.permissions.filter(function(perm) {
                        return perm.id === permission.id;
                    });
                }).length > 0;

                /*if (hasPerm) {
                    vm.record.roles_attach_permissions.push(`${roleId}_${permission.id}`);
                }*/
            },
        },
        mounted() {
            let vm = this;
            vm.setModuleGroups();
            vm.record.roles_attach_permissions = [];
            vm.allPermissionByRol = [];
        }
    };
</script>
