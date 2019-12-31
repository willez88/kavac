<template>
    <li class="nav-item dropdown dropdown-notify">
        <a href="#" class="nav-link dropdown-toggle btn btn-sm btn-info btn-notify" data-toggle="dropdown"
           aria-expanded="false" title="Notificaciones del sistema" id="list_notifications">
            <i class="now-ui-icons ui-1_bell-53"></i>
            <!-- Mensajes de Notificación de procesos o usuarios -->
            <span class="badge badge-primary badge-notify" v-show="count > 0">{{ count }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="list_notifications">
            <a class="dropdown-header text-center">Notificaciones</a>
            <div class="dropdown-item">
                <ul class="media-list msg-list" v-if="notifications.length">
                    <li class="media unread" v-for="notify in notifications">
                        <div class="media-body">
                            <strong>
                                {{ notify.data.title }}{{ (notify.data.module) ? ' / ' + notify.data.module : '' }}
                            </strong><br>
                            {{ notify.data.description }}
                            <small class="date">
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
                count: 0,
                notifications: []
            }
        },
        methods: {
            /**
             * Método que permite obtener las notificaciones no leídas
             *
             * @method     getUnreaded
             *
             * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             */
            getUnreaded: function() {
                let vm = this;
                axios.get('/notifications/unreaded').then(response => {
                    if (response.data.result) {
                        vm.notifications = response.data.notifications;
                        vm.count = vm.notifications.length;
                    }
                }).catch(error => {
                    vm.logs('NotificationsComponent', 63, error, 'getUnreaded');
                });
            }
        },
        created() {
            this.getUnreaded();
        },
        mounted() {

        }
    };
</script>
