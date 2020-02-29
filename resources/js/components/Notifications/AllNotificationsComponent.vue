<template>
    <div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <ul class="media-list msg-list">
                        <li class="media unread" v-for="notify in notifications">
                            <div class="float-left">
                                <input type="checkbox" name="checkbox1" id="checkbox1" class="form-control">
                                <label for="checkbox1"></label>
                            </div>
                            <div class="media-body">
                                <div class="float-right media-option">
                                    <i class="fa fa-paperclip mr5"></i>
                                    <small>{{ notify.created_at }}</small>
                                </div>
                                <p>
                                    <strong class="subject">{{ notify.data.title }}</strong>
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
                notifications: []
            }
        },
        methods: {
            getNotifications() {
                let vm = this;
                axios.get('/notifications/all').then(response => {
                    if (response.data.result) {
                        vm.notifications = response.data.notifications;
                    }
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
