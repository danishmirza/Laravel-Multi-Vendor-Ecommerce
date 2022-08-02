<template>
    <div class="chat-box chat-left-box">
        <div class="messages-content">
            <div class="messages-area" v-if="messages.length > 0">
                <template v-for="message of messages">
                    <template v-if="message.sender.id != userId">
                        <div class="sender-msg media">
                            <div>
                                <div class="media-left media-top">
                                </div>
                                <div class="media-body Oswald-Light">
                                    <div class="msg-1">
                                        <div class="single-msg">
                                            <span v-if="message.message_type == 'text'">{{message.message}}</span>
                                            <span v-if="message.message_type == 'image'"><img :src="message.message | timthumb(100,100,95,2)" alt=""></span>
                                        </div>
                                        <span class="send-time OpenSans-Regular text-left">{{message.created_at | elapsed}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template v-if="message.sender.id == userId">
                        <div class="msg-2">
                            <span v-if="message.message_type == 'text'">{{message.message}}</span>
                            <span v-if="message.message_type == 'image'"><img :src="message.message | timthumb(100,100,95,2)" alt=""></span>
                            <span class="received-time OpenSans-Regular font-16 text-right">{{message.created_at | elapsed}}</span>
                        </div>
                    </template>
                </template>



                <div class="clearfix"></div>
            </div>

            <div class="clearfix"></div>

            <div>
                <div class="msg-form d-flex align-items-center">
                    <div class="input-file">
                        <input type="file" id="attachment" name="input-file-preview" @change="uploadImage($event)">
                        <img :src="base+'/assets/web/img/pin.png'">
                    </div>
                    <div class="position-relative msg-form-mt w-100">
                        <input type="text" name="content" class="form-control" placeholder="Write message..." v-model="form.message">

                    </div>
                    <button class="btn btn-arr border-0 right-white" @click="sendMessage()" :disabled="formSubmitting">
                        <img :src="base+'/assets/web/img/right-white.png'" class="img-fluid " alt="image" v-if="!formSubmitting">
                        <i class="fa fa-spinner fa-spin d-none" v-if="formSubmitting"></i>
                    </button>
                    <div v-if="$v.form.message.$error">This field is required</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {required} from "vuelidate/lib/validators";

export default {
name: "messages",
    props: ["conversationId", 'userId', 'userType'],
    data() {
        return {
            base: window.Laravel.base,
            messages: [],
            skip: 0,
            isLoading: false,
            formSubmitting:false,
            form:{
                conversation_id: this.conversationId,
                message: '',
                message_type: 'text'
            }
        };
    },
    validations () {
        return {
            form: {
                message: { required },
            }

        }
    },
    mounted() {
      setTimeout(() => {
        Echo.channel(`click-shine-new-message-` + this.userId).listen(
            ".new-message",
            (e) => {
              console.log("Message =>",e)
              this.messages.push(e.message)
              this.skip++
            }
        );
      }, 500);
        this.isLoading = true;
        this.getMessages();
    },
    methods: {
        getMessages() {
            axios.get(`${window.Laravel.apiUrl}dashboard/messages/${this.conversationId}/${this.skip}`).then((response) => {
                if (response.data.success) {
                    if(this.skip > 0){
                        this.messages = this.messages.concat(response.data.data);
                    }else{
                        this.messages = response.data.data;
                    }
                    this.skip = this.messages.length;
                    this.isLoading = false;
                } else {
                    console.error("Messages Error =>", response);
                }
            });

        },
        uploadImage(event) {
            this.formSubmitting = true;
            let data = new FormData();
            data.append('image', event.target.files[0]);

            axios.post(
                `${window.Laravel.apiUrl}upload-image/media`,
                data,
            ).then(
                response => {
                   if(response.data.success){
                       this.form.message = response.data.data.file_name;
                       this.form.message_type = 'image'
                       event.target.value = ''
                       this.sendMessage();
                   }else{
                       toastr.error(response.data.message);
                       this.formSubmitting = false;
                   }
                }
            )
        },
        sendMessage(){
            this.$v.$touch()
            // console.log(isFormCorrect)
            if (!this.$v.$invalid) {
                this.formSubmitting = true;
                axios
                    .post(`${window.Laravel.apiUrl}dashboard/message/send-message`, this.form)
                    .then((response) => {
                        if (response.data.success) {
                            this.resetForm()
                            this.messages.push(response.data.data);
                            this.skip++
                            this.formSubmitting = false;
                        } else {
                            toastr.error(response.data.message);
                            this.formSubmitting = false;
                        }
                    })
            }
        },
        resetForm(){
            this.form.message = '';
            this.form.message_type = 'text'
            this.$v.$reset()
        }
    }
}
</script>

<style scoped>

</style>
