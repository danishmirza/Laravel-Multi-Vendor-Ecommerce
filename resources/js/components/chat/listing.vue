<template>
    <div class="chat-box chat-left-box" v-if="conversations.length > 0">
        <div class="chat-clear d-flex">
            <h4 class="tittle-name">Messages</h4>
            <a class="clear-tittle ml-auto" href="" @click="deleteAllConversations()">Clear All</a>
        </div>
        <ul class="rating-listed">
            <li class="rating-item" v-for="conversation of conversations">
                <div class="content-top d-flex align-items-center">
                    <figure class="thumb" v-if="userType === 'user'" @click="redirectToMessages(conversation.id)">
                        <img :src="conversation.store.image | timthumb" alt="">
                    </figure>
                    <figure class="thumb" v-if="userType === 'store'" @click="redirectToMessages(conversation.id)">
                        <img :src="conversation.user.image | timthumb" alt="">
                    </figure>
                    <div class="text-holder w-100" @click="redirectToMessages(conversation.id)">
                        <div class="top d-flex">
                            <h5 v-if="userType === 'user'">{{conversation.store.store_name | language}}</h5>
                            <h5 v-if="userType === 'store'">{{conversation.user.name}}</h5>
                            <a class="close-chat ml-auto" @click="deleteConversation(conversation.id)">
                                <i class="fas fa-times-circle"></i>
                            </a>
                        </div>
                        <div class="content-bottom d-flex">
                            <p v-if="conversation.lastMessage">{{ (conversation.lastMessage.message_type == 'text') ? conversation.lastMessage.message : 'Image'}}</p>
                            <span class="ml-auto content-right" v-if="!conversation.lastMessage"> {{conversation.created_at | elapsed}}</span>
                            <span class="ml-auto content-right" v-if="conversation.lastMessage"> {{conversation.lastMessage.created_at | elapsed}}</span>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>


</template>

<script>

export default {
    name: "conversations",
    props: ["conversationId", 'userId', 'userType'],
    data() {
        return {
            base: window.Laravel.base,
            conversations: [],
            isLoading: false,
        };
    },
    mounted() {
        this.$nextTick(() => {
            setTimeout(() => {
                Echo.channel(`click-shine-chat-message-` + this.userId).listen(
                    ".new-message",
                    (e) => {
                      let conversationFiltered = this.conversations.filter(conversation => conversation.id == e.message.connversation_id)
                      console.log(conversationFiltered)
                      if(conversationFiltered.length > 0){
                        conversationFiltered[0].lastMessage = e.message;
                      }  else{
                        this.getConversations();
                      }
                      console.log("Chat =>",e)
                    }
                );
            }, 500);
        });
        this.isLoading = true;
        this.getConversations();
    },
    methods: {
        getConversations() {
            axios.get(`${window.Laravel.apiUrl}dashboard/conversations`).then((response) => {
                if (response.data.success) {
                    this.conversations = response.data.data.collection;
                    if(this.conversationId){
                        this.conversations = this.conversations.map(conversation => {
                            conversation.active = conversation.id === this.conversationId;
                            return conversation
                        })
                    }
                    this.isLoading = false;
                    console.log(this.conversations);
                } else {
                    console.error("Conversations Error =>", response);
                }
            });

        },
        redirectToMessages(conversationId){
            window.location.href = `${window.Laravel.baseUrl}dashboard/chats/messages/${conversationId}`
        },
        deleteAllConversations(){
            this.$swal(
                {
                    title: 'Are you sure?',
                    text: 'Do you want to delete all chats',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes Delete it!',
                    cancelButtonText: 'No, Keep it!',
                    showCloseButton: true,
                    showLoaderOnConfirm: true
                }).then((result) => {
                if (result.value) {
                    window.location.href = `${window.Laravel.baseUrl}dashboard/conversations/delete-all`
                }else {
                    this.$swal.close();
                }
            });
        },
        deleteConversation(conversationId){
            this.$swal(
                {
                    title: 'Are you sure?',
                    text: 'Do you want to delete this chat',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes Delete it!',
                    cancelButtonText: 'No, Keep it!',
                    showCloseButton: true,
                    showLoaderOnConfirm: true
                }).then((result) => {
                if (result.value) {
                    console.log(`${window.Laravel.baseUrl}dashboard/conversation/delete/${conversationId}`)
                    window.location.href = `${window.Laravel.baseUrl}dashboard/conversation/delete/${conversationId}`
                }else {
                    this.$swal.close();
                }
            });
        }
    }
};
</script>

<style scoped>
</style>
