<template>
    <li class="nav-item dropdown dropdown-notify">
        <a href="#" class="nav-link dropdown-toggle btn btn-sm btn-info btn-notify" data-toggle="dropdown"
           aria-expanded="false" title="Notificaciones del sistema" id="list_notifications">
            <i class="now-ui-icons ui-1_bell-53"></i>
            <!-- Mensajes de Notificación de procesos o usuarios -->
            <span class="badge badge-primary badge-notify" v-show="notifications.length > 0" id="notifyCount">
                {{ notifications.length }}
            </span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="list_notifications">
            <a class="dropdown-header text-center">Notificaciones</a>
            <div class="dropdown-item">
                <ul class="media-list msg-list" v-if="notifications.length">
                    <li class="media unread" v-for="(notify, index) in notifications" :key="index" v-if="index<5">
                        <div class="media-body" v-if="notify.data.title && notify.data.message">
                            <strong>
                                <i class="fa fa-envelope-o cursor-pointer" title="Marcar como leído"
                                   data-toggle="tooltip" @click.prevent="markAsReaded(notify.id)"></i>
                                {{ notify.data.title }}
                            </strong><br>
                            <p v-html="notify.data.message.replace(/(?:\r\n|\r|\n)/g, '<br>')"></p>
                            <small class="date" v-if="(typeof(notify.created_at)!=='undefined')">
                                <i class="icofont icofont-clock-time"></i>{{ format_timestamp(notify.created_at) }}
                            </small>
                        </div>
                    </li>
                </ul>
                <ul class="media-list msg-list" v-else>
                    <li class="media">
                        <div class="media-body text-center">Sin notificaciones</div>
                    </li>
                </ul>
            </div>
            <a class="dropdown-item dropdown-footer text-center" :href="listNotificationsUrl"
               title="Ver todas las notificaciones" data-toggle="tooltip" data-placement="left">
                Ver todas las notificaciones
            </a>
        </div>
    </li>
</template>

<script>
    export default {
        data() {
            return {
                notifications: this.unreads
            }
        },
        props: ['unreads', 'userId', 'listNotificationsUrl'],
        methods: {
            /**
             * Marca una notificación como leida
             *
             * @method    markAsReaded
             *
             * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             *
             * @param     {integer}        id    Identificador de la notificación a ser marcada como leida
             */
            markAsReaded: function(id) {
                const vm = this;
                axios.post(`${window.app_url}/notifications/mark`, {
                    notifyId: id,
                    asRead: true
                }).then(response => {
                    if (response.data.result) {
                        vm.notifications = response.data.notifications;
                        vm.showMessage(
                            'custom', 
                            'Éxito!', 
                            'success', 
                            'screen-ok', 
                            `Notificación marcada como ${(response.data.markAs!=='read')?'no':''} ĺeída`
                        );
                    }
                }).catch(error => {
                    console.error(error);
                });
            },
        },
        created() {
            let vm = this;
        },
        mounted() {
            let vm = this;
            window.Echo.private(`App.User.${vm.userId}`).notification((notification) => {
                let newNotifications = {
                    id: notification.id,
                    data: {
                        title: notification.title,
                        message: notification.message
                    }
                };
                vm.notifications.push(newNotifications);
            });
        }
    };
</script>
