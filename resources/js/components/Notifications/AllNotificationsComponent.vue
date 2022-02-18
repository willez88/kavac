<template>
    <div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-3">
                    <div class="btn-group" role="group">
                        <button id="mark" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" 
                                aria-expanded="false">
                            <i class="fa fa-envelope-o"></i>
                            Marcar como
                        </button>
                        <div class="dropdown-menu" aria-labelledby="mark">
                            <a class="dropdown-item" href="javascript:void(0)" @click="setMark('read')">Leída</a>
                            <a class="dropdown-item" href="javascript:void(0)" @click="setMark('unread')">No Leída</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mt-3">
                    <ul class="media-list msg-list">
                        <li class="media unread" v-for="(notify, index) in notifications" :key="index">
                            <div class="float-left">
                                <input type="checkbox" name="chkNotify" id="chkNotify" class="form-control" 
                                       v-model="selected" :value="notify.id">
                                <label for="chkNotify"></label>
                            </div>
                            <div class="media-body">
                                <div class="float-right media-option">
                                    <i class="fa fa-paperclip mr5"></i>
                                    <small>{{ format_timestamp(notify.created_at) }}</small>
                                </div>
                                <p>
                                    <strong class="subject" v-if="notify.read_at===null">{{ notify.data.title }}</strong>
                                    <span v-else>{{ notify.data.title }}</span>
                                    {{ notify.data.message }}
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                notifications: [],
                selected: []
            }
        },
        methods: {
            /**
             * Obtiene el listado de notificaciones
             *
             * @method    getNotifications
             *
             * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             */
            async getNotifications() {
                let vm = this;
                await axios.get('/notifications/all').then(response => {
                    if (response.data.result) {
                        vm.notifications = response.data.notifications;
                    }
                }).catch(error => {
                    console.error(error);
                });
            },
            async setMark(mark) {
                const vm = this;
                await axios.post(`${window.app_url}/notifications/mark`, {
                    asRead: (mark==='read')?true:false,
                    multipleMark: vm.selected
                }).then(response => {
                    vm.getNotifications();
                    $('#notifyCount').text(vm.notifications.length);
                }).catch(error => {
                    console.error(error);
                });
            }
        },
        mounted() {
            this.getNotifications();
        }
    };
</script>
