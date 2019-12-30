<template>
    <li class="nav-item dropdown dropdown-notify">
        <a href="#" class="nav-link dropdown-toggle btn btn-sm btn-info btn-notify" data-toggle="dropdown"
           aria-expanded="false" title="Notificaciones del sistema" id="list_notifications">
            <i class="now-ui-icons ui-1_bell-53"></i>
            <!-- Mensajes de Notificación de procesos o usuarios -->
            <span class="badge badge-primary badge-notify">{{ count }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="list_notifications">
            <a class="dropdown-header text-center">Notificaciones</a>
            <div class="dropdown-item">
                <ul class="media-list msg-list">
                    <li class="media" v-for="notify in notifications">
                        <div class="media-body">
                            <strong>
                                {{ notify.data.title }}{{ (notify.data.module) ? ' / ' + notify.data.module : '' }}
                            </strong><br>
                            {{ notify.data.description }}
                            <small class="date">
                                <i class="icofont icofont-clock-time"></i>{{ showNotifyTime(notify.created_at) }}
                            </small>
                        </div>
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
            getUnreaded: function() {
                let vm = this;
                axios.get('/notifications/unreaded').then(response => {
                    if (response.data.result) {
                        vm.notifications = response.data.notifications;
                        vm.count = vm.notifications.length;
                    }
                }).catch(error => {
                    console.log(error);
                });
            },
            showNotifyTime(created_at) {
                let timeData = this.diff_datetimes(created_at);
                var timeText = "Hace ";
                if (timeData.years > 0) {
                    timeText += `${timeData.years} años, `;
                }
                if (timeData.months > 0) {
                    timeText += `${timeData.months} meses, `;
                }
                if (timeData.days > 0) {
                    timeText += `${timeData.days} días, `;
                }
                if (timeData.hours > 0) {
                    timeText += `${timeData.hours} horas, `;
                }
                if (timeData.minutes > 0) {
                    timeText += `${timeData.minutes} minutos, `;
                }
                if (timeData.seconds > 0) {
                    timeText += `${timeData.seconds} segundos, `;
                }
                return timeText;
            }
        },
        created() {
            this.getUnreaded();
        },
        mounted() {

        }
    };
</script>
