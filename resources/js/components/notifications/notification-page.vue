<template>
    <section class="profile-section pd-tb100">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="notificatopn-page">
                        <div class="row">
                            <div class="col-12">
                                <div class="noti-setting d-flex align-items-center">
                                    <div class="seting-t ml-1 mr-3">Notification</div>
                                    <label class="switch" @click="changeNotificationSetting()">
                                        <input type="checkbox" :checked="isNotificationEnabled1" value="1">
                                        <span class="slider round"></span>
                                    </label>

                                    <button v-if="notifications.length > 0" class="clear-all ml-auto" @click="deleteAllNotification()">Clear All</button>
                                </div>
                            </div>
                        </div>

                        <div class="row"  v-if="notifications.length > 0">
                            <!-- notification list -->
                            <div class="col-12" v-for="notification of notifications">
                                <div class="notification-box d-flex border-bottom py-2">
                                    <div class="img-box">
                                        <a @click="redirectOnAction(notification)">
                                            <img :src="baseUrl+'/assets/web/img/notification-img.png'" class="img-fluid" alt="">
                                        </a>
                                    </div>
                                    <div class="not-detail d-flex align-items-center justify-content-between w-100">
                                        <div>
                                            <a @click="redirectOnAction(notification)">
                                                <div class="title">{{notification.data.title | language}}</div>
                                                <div class="time-noti">{{notification.data.created_at | elapsed }}</div>
                                                <div class="des">{{notification.data.detail | language}}</div>
                                            </a>
                                        </div>
                                        <div class="text-right">
                                            <button class="time-del btn-style-none p-0" @click="deleteNotification(notification.id)"><i class="fas fa-times-circle"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- notification list -->

                        </div>
                        <div class="row" v-if="notifications.length <=0">
                            <div class="col-12">
                                <div class="alert alert-danger col-12" role="alert">
                                    You have not received any notifications.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    name: "notification-page",
    props:[
     'isNotificationEnabled'
    ],
    data: function (){
        return {
            baseUrl: window.Laravel.base,
            notifications: [],
            isLoading: false,
            isNotificationEnabled1: this.isNotificationEnabled
        }
    },
    created() {
        this.setSocketListeners();
        this.isLoading = true;
        this.list()
    },
    methods: {
        setSocketListeners() {
            Echo.channel(
                `click-shine-new-notification-` + window.Laravel.loggedInUserId
            ).listen(".new-notification", (e) => {
                this.list();
                console.log(e);
            }).listen(".new-message", (e) => {
              this.unreadNotificationCount();
              console.log(e);
            });
        },
        list() {
            axios
                .get(`${window.Laravel.apiUrl}dashboard/notifications`)
                .then((response) => {
                    if (response.data.success) {
                        this.notifications = response.data.data.collection;
                        this.isLoading = false;
                    } else {
                        console.error("Notifications Error =>", response);
                    }
                });
        },
        deleteNotification(notificationId){
            this.$swal(
                {
                    title: 'Are you sure?',
                    text: 'Do you want to deleted this notification',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes Delete it!',
                    cancelButtonText: 'No, Keep it!',
                    showCloseButton: true,
                    showLoaderOnConfirm: true
                }).then((result) => {
                console.log(result);
                if (result.value) {
                    axios
                        .get(`${window.Laravel.apiUrl}dashboard/delete-notification/${notificationId}`)
                        .then((response) => {
                            if (response.data.success) {
                                this.list();
                            } else {
                                console.error("Seen Notifications Eerror =>", response);
                            }
                        });
                } else {
                    this.$swal.close();
                }
            });

        },
        deleteAllNotification(notificationId){
            this.$swal(
                {
                    title: 'Are you sure?',
                    text: 'Do you want to deleted all notifications',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes Delete it!',
                    cancelButtonText: 'No, Keep it!',
                    showCloseButton: true,
                    showLoaderOnConfirm: true
                }).then((result) => {
                console.log(result);
                if (result.value) {
                    axios
                        .get(`${window.Laravel.apiUrl}dashboard/delete-all-notification`)
                        .then((response) => {
                            if (response.data.success) {
                                this.list();
                            } else {
                                console.error("Seen Notifications Eerror =>", response);
                            }
                        });
                } else {
                    swal.close();
                }
            });

        },
        changeNotificationSetting(){
            this.$swal(
                {
                    title: 'Are you sure?',
                    text: 'Do you want to change notification setting',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes Change it!',
                    cancelButtonText: 'No, Keep it!',
                    showCloseButton: true,
                    showLoaderOnConfirm: true
                }).then((result) => {
                console.log(result);
                if (result.value) {
                    axios
                        .get(`${window.Laravel.apiUrl}dashboard/notification-setting`)
                        .then((response) => {
                            if (response.data.success) {
                                this.isNotificationEnabled1 = (parseInt(response.data.data.is_notification_enabled) === 1) ? true : false
                            } else {
                                console.error("Seen Notifications Eerror =>", response);
                            }
                        });
                } else {
                    this.$swal.close();
                    location.reload()
                }
            });

        },
      redirectOnAction(notification){
        let href = '';
        if(notification.data.action == 'ORDER_CREATED'){
          href = `${window.Laravel.baseUrl}dashboard/orders/detail/${notification.data.extras.orderId}`
        }
        if(notification.data.action == 'ORDER_IN_PROGRESS'){
          href = `${window.Laravel.baseUrl}dashboard/orders/detail/${notification.data.extras.orderId}`
        }
        if(notification.data.action == 'ORDER_COMPLETED'){
          href = `${window.Laravel.baseUrl}dashboard/orders/detail/${notification.data.extras.orderId}`
        }
        if(notification.data.action == 'ORDER_CANCELLED'){
          href = `${window.Laravel.baseUrl}dashboard/orders/detail/${notification.data.extras.orderId}`
        }
        if(notification.data.action == 'AD_REQUEST_STATUS'){
          href = `${window.Laravel.baseUrl}dashboard/store-ads/${notification.data.extras.status}`
        }
        if(notification.data.action == 'NEW_MESSAGE'){
          href = `${window.Laravel.baseUrl}dashboard/chats/messages/${notification.data.extras.conversation_id}`
        }
        window.location.href = href;
      }
    }
}
</script>

<style scoped>

</style>
