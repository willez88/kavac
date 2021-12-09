<template>
    <div class="modal fade" id="modalSendMessage" tabindex="-1" role="dialog" aria-labelledby="modalSendMessageTitle" 
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSendMessageTitle">Enviar Mensaje</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="user" v-model="record.userId">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group is-required">
                                <label>Para</label>
                                <input type="text" class="form-control" data-toggle="tooltip" v-model="record.toEmail"
                                       title="Indique la(s) cuenta(s) de correo electrónico a enviar el mensaje">
                            </div>
                            <div class="form-group is-required">
                                <ckeditor :editor="ckeditor.editor" id="description" data-toggle="tooltip"
                                  title="Indique una descripción para el compromiso" :config="ckeditor.editorConfig"
                                  class="form-control" name="description" tag-name="textarea" rows="3"
                                  v-model="record.message"></ckeditor>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" @click="sendMessage()">Enviar</button>
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
                    toEmail: '',
                    message: ''
                }
            }
        },
        methods: {
            getUserInfo(id) {
                const vm = this;
                axios.get(`${window.app_url}/user-info/${id}`).then(response => {
                    vm.record.userId = id;
                    vm.record.toEmail = response.data.user.email;
                }).catch(error => {
                    console.error(error);
                });
            },
            async sendMessage() {
                const vm = this;
                vm.loading = true;
                await axios.post(`${window.app_url}/messages/send`, {
                    toEmail: vm.record.toEmail,
                    subject: 'Mensaje del sistema',
                    message: vm.record.message,
                }).then(response => {
                    vm.showMessage(
                        'custom', 'Enviado', 'success', 'screen-ok', 'Mensaje enviado'
                    );
                    $("#modalSendMessage").find('.close').click();
                }).catch(error => {
                    console.error(error);
                });
                vm.loading = false;
            }
        },
        mounted() {
            const vm = this;
            $("#modalSendMessage").on("shown.bs.modal", function () {
                vm.getUserInfo($("#user").val());
            });
            $('#modalSendMessage').on('hidden.bs.modal', function (e) {
                vm.record = {
                    userId: '',
                    toEmail: '',
                    message: ''
                };
            });
        }
    }
</script>