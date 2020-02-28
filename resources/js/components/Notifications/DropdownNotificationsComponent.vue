<template>
    <li class="nav-item dropdown dropdown-notify">
        <a href="#" class="nav-link dropdown-toggle btn btn-sm btn-info btn-notify" data-toggle="dropdown"
           aria-expanded="false" title="Notificaciones del sistema" id="list_notifications">
            <i class="now-ui-icons ui-1_bell-53"></i>
            <!-- Mensajes de Notificación de procesos o usuarios -->
            <span class="badge badge-primary badge-notify" v-show="notifications.length > 0">
                {{ notifications.length }}
            </span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="list_notifications">
            <a class="dropdown-header text-center">Notificaciones</a>
            <div class="dropdown-item">
                <ul class="media-list msg-list" v-if="notifications.length">
                    <li class="media unread" v-for="notify in notifications">
                        <div class="media-body" v-if="notify.data.title && notify.data.message">
                            <strong>
                                <i class="fa fa-envelope-o cursor-pointer" title="Marcar como leído"
                                   data-toggle="tooltip" @click.prevent="markAsReaded(notify.id)"></i>
                                {{ notify.data.title }}
                            </strong><br>
                            <p v-html="notify.data.message.replace(/(?:\r\n|\r|\n)/g, '<br>')"></p>
                            <small class="date" v-if="(typeof(notify.created_at)!=='undefined')">
                                <i class="icofont icofont-clock-time"></i>{{ notify.created_at }}
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
            <a class="dropdown-item dropdown-footer text-center" href="#"
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
        props: ['unreads', 'userId'],
        methods: {
            markAsReaded: function(id) {
                console.log(id)
            },
        },
        created() {
            let vm = this;
            /*Echo.join(`home`)
                .here((users) => {
                    console.log('presets user ', users);
                })
                .joining((user) => {
                    console.log(user.name);
                })
                .leaving((user) => {
                    console.log(user.name);
                });*/
        },
        mounted() {
            let vm = this;
            window.Echo.private(`App.User.${vm.userId}`).notification((notification) => {
                console.log(notification);

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
