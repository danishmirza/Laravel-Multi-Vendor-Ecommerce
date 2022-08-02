<template>
    <li class="list-item notification-wrap">
        <a  class="btn-notification" id="dropdownMenuLink" data-toggle="dropdown" @click="seenAll()">
            <img :src="baseUrl+'/assets/web/img/notification-icon.svg'" alt="">
            <span class="count">{{unreadCount}}</span>
        </a>
        <div class="dropdown-menu notif-drop" aria-labelledby="dropdownMenuLink">
            <div class="dropdown-item notify-drop">
                <div class="drop-notifications">
                    <div class="row">
                        <!-- Notification list -->
                        <div class="col-12" v-if="notifications.length > 0">
                            <div class="notification-box d-flex border-bottom py-2" v-for="notification of notifications">
                                <div class="img-box">
                                    <a @click="redirectOnAction(notification)">
                                        <img :src="baseUrl+'/assets/web/img/notification-img.png'" class="img-fluid" alt="">
                                    </a>
                                </div>
                                <div
                                    class="not-detail d-flex align-items-center justify-content-between w-100">
                                    <div>
                                        <a @click="redirectOnAction(notification)">
                                            <div class="title">{{notification.data.title | language}}</div>
                                            <div class="time-noti">{{notification.data.created_at | elapsed }}</div>
                                            <div class="des">{{notification.data.detail | language}}</div>
                                        </a>
                                    </div>
                                    <div class="text-right">
                                        <button class="time-del btn-style-none p-0" @click="deleteNotification(notification.id)">
                                            <i class="fas fa-times-circle"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div><!-- notification list -->
                        <div class="col-12" v-if="notifications.length <=0">
                            <div class="alert alert-danger col-12" role="alert">
                                You have not received any notifications.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="view-clear-notif" v-if="notifications.length > 0">
                    <a :href="viewAllPageLink" class="btn-style view-clear-btn">View All</a>
                    <a @click="deleteAllNotification()" class="btn-style view-clear-btn">Clear All</a>
                </div>
            </div>
        </div>
    </li>
</template>

<script>
export default {
    name: "notification-bell",
    props: [
        "viewAllPageLink",
    ],
    data(){
        return {
            baseUrl: window.Laravel.base,
            unreadCount: 0,
            notifications: [],
            isLoading: false
        }
    },
    created() {
        this.setSocketListeners();
        this.isLoading = true;
        this.unreadNotificationCount();

    },
    methods: {
        setSocketListeners() {
            Echo.channel(
                `click-shine-new-notification-` + window.Laravel.loggedInUserId
            ).listen(".new-notification", (e) => {
                this.unreadNotificationCount();
                console.log(e);
            }).listen(".new-message", (e) => {
              this.unreadNotificationCount();
              console.log(e);
            });
        },
        list() {
            console.log(1);
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
        unreadNotificationCount(){
            axios
                .get(`${window.Laravel.apiUrl}dashboard/unread-notifications-count`)
                .then((response) => {
                    if (response.data.success) {
                        this.unreadCount = response.data.data.count;
                        this.list();
                    } else {
                        console.error("Notifications Error =>", response);
                    }
                });
        },
        seenAll() {
            if(this.unreadCount <= 0){
                return;
            }
            axios
                .get(`${window.Laravel.apiUrl}dashboard/read-all-notifications`)
                .then((response) => {
                    if (response.data.success) {
                        this.unreadCount = 0;
                    } else {
                        console.error("Seen Notifications Eerror =>", response);
                    }
                });
        },
        deleteNotification(notificationId){
            this.$swal(
                {
                    title: 'Are you sure?',
                    text: 'You want to deleted this notification',
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
                        swal.close();
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
