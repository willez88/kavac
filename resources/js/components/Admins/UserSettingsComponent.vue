<template>
    <div class="modal fade" id="modalUserSettings" tabindex="-1" role="dialog" 
         aria-labelledby="modalUserSettingsTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUserSettingsTitle">Configuración del usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <label for="">
                                <div class="bootstrap-switch-mini">
                                    Bloquear / Desbloquear usuario
                                    <input type="checkbox" class="form-control bootstrap-switch"
                                           name="blocked_at" id="blocked_at" data-toggle="tooltip"
                                           data-on-label="SI" data-off-label="NO"
                                           title="Bloquear / Desbloquear usuario"
                                           v-model="record.blocked_at" value="true"
                                           data-record="blocked_at">
                                </div>
                            </label>
                        </div>
                        <div class="col-12 col-md-4">
                            <label for="">
                                <div class="bootstrap-switch-mini">
                                    Activar / Desactivar usuario
                                    <input type="checkbox" class="form-control bootstrap-switch"
                                           name="active" id="active" data-toggle="tooltip"
                                           data-on-label="SI" data-off-label="NO"
                                           title="Bloquear / Desactivar usuario"
                                           v-model="record.active" value="true"
                                           data-record="active">
                                </div>
                            </label>
                        </div>
                        <div class="col-12 col-md-4"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" @click="setRecord()">Guardar</button>
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
                    userId: '',
                    blocked_at: false,
                    active: false
                }
            }
        },
        methods: {
            getUserInfo(id) {
                const vm = this;
                if (!id) {
                    return false;
                }
                axios.get(`${window.app_url}/user-info/${id}`).then(response => {
                    vm.record.userId = id;
                    vm.record.blocked_at = (response.data.user.blocked_at !== null) ? true : false;
                    vm.record.active = (response.data.user.active===true)?true:false;
                    $("#blocked_at").bootstrapSwitch('state', vm.record.blocked_at);
                    $("#active").bootstrapSwitch('state', vm.record.active);
                }).catch(error => {
                    console.error(error);
                });
            },
            async setRecord() {
                const vm = this;
                vm.loading = true;
                await axios.post(`${window.app_url}/auth/settings/users`, {
                    user_id: vm.record.userId,
                    blocked_at: vm.record.blocked_at,
                    active: vm.record.active
                }).then(response => {
                    vm.showMessage(
                        'custom', 'Éxito', 'success', 'screen-ok', 'Configuración establecida'
                    );
                    $("#modalUserSettings").find('.close').click();
                }).catch(error => {
                    console.error(error);
                });
                vm.loading = false;
            }
        },
        mounted() {
            const vm = this;
            vm.switchHandler('blocked_at');
            vm.switchHandler('active');
            $("#modalUserSettings").on("show.bs.modal", function () {
                vm.getUserInfo(window.userId || '');
            });
            $('#modalUserSettings').on('hidden.bs.modal', function (e) {
                vm.record = {
                    userId: '',
                    blocked_at: false,
                    active: false
                };
                $("#blocked_at").bootstrapSwitch('state', false);
                $("#active").bootstrapSwitch('state', false);
            });
        }
    };
</script>