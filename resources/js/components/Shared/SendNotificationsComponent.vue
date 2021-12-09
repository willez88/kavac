<template>
    <div class="modal fade" id="modalSendNotification" tabindex="-1" role="dialog" 
         aria-labelledby="modalSendNotificationTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSendNotificationTitle">Enviar Notificación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="user" v-model="record.userId">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group is-required">
                                <label>Usuario(s):</label>
                                <span>{{ record.user }}</span>
                            </div>
                            <div class="form-group is-required">
                                <label>Mensaje</label>
                                <input type="text" class="form-control" v-model="record.message">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" @click="sendNotify()">Enviar</button>
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
                    user: '',
                    message: ''
                },
            }
        },
        methods: {
            getUserInfo(id) {
                const vm = this;
                axios.get(`${window.app_url}/user-info/${id}`).then(response => {
                    vm.record.userId = id;
                    vm.record.user = response.data.user.name;
                }).catch(error => {
                    console.error(error);
                });
            },
            async sendNotify() {
                const vm = this;
                vm.loading = true;
                await axios.post(`${window.app_url}/notifications/send`, {
                    user_id: vm.record.userId,
                    title: 'Notificación de proceso',
                    details: vm.record.message
                }).then(response => {
                    vm.showMessage(
                        'custom', 'Enviado', 'success', 'screen-ok', 'Notificación enviada'
                    );
                    $("#modalSendNotification").find('.close').click();
                }).catch(error => {
                    console.error(error);
                });
                vm.loading = false;
            }
        },
        mounted() {
            const vm = this;
            $("#modalSendNotification").on("shown.bs.modal", function () {
                vm.getUserInfo($("#user").val());
            });
            $('#modalSendNotification').on('hidden.bs.modal', function (e) {
                vm.record = {
                    userId: '',
                    user: '',
                    message: ''
                };
            });
        }
    }
</script>