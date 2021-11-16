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
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group is-required">
                                <label>Usuario(s):</label>
                                <v-multiselect :options="users" track_by="name" :hide_selected="true" 
                                               :selected="record.users" v-model="record.users">
                                </v-multiselect>
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
                    <button type="button" class="btn btn-primary">Enviar</button>
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
                    users: [],
                    message: ''
                },
                users: []
            }
        },
        methods: {
            getUsers() {
                const vm = this;
                axios.get(`${window.app_url}/users-all`).then(response => {
                    if (response.data.result) {
                        vm.users = response.data.records;
                    }
                }).catch(error => {
                    console.error(error);
                });
            }
        },
        mounted() {
            const vm = this;
            vm.getUsers();
        }
    }
</script>