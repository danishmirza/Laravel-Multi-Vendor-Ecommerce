<template>
    <div class="modal fade mt-modal-wrap" id="coupon-modal" tabindex="-1" role="dialog"
         aria-labelledby="couponModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form @submit.prevent="applyCoupon" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="couponModalTitle">Coupon Code</h5>
                    <button type="button" class="close" @click="$('#coupon-modal').modal('hide')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-style mb-2">
                        <label class="d-block">Enter Code<span class="text-danger">*</span></label>
                        <div class="type-pass">
                            <input type="text" class="ctm-input" placeholder="Code" v-model="couponCode">
                        </div>
                        <div v-if="$v.couponCode.$error">This field is required</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn-style btn-add w-100 " type="submit">Apply</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import {required} from "vuelidate/lib/validators";

export default {
name: "add-coupon",
    data(){
        return {
            couponCode: 0,
        }
    },
    validations () {
        return {
            couponCode: { required }
        }
    },
    created() {
        this.$eventBus.$on('open-coupon-modal', this.showModal);
    },
    beforeDestroy() {
        this.$eventBus.$off('open-coupon-modal');
    },
    methods: {
        reset() {
            this.couponCode = ''
            this.$v.$reset()
        },
        showModal($event) {
            this.reset();
            $('#coupon-modal').modal('show');
        },
        applyCoupon() {
            this.$v.$touch()
            // console.log(isFormCorrect)
            if (!this.$v.$invalid) {
                axios
                    .post(`${window.Laravel.apiUrl}dashboard/coupon/apply`, {
                        code: this.couponCode,
                    })
                    .then((response) => {
                        if (response.data.success) {
                            window.location.reload()
                            // $('#coupon-modal').modal('hide');
                            // this.$eventBus.$emit('coupon-changed', (Object.keys(response.data.data).length > 0) ? response.data.data : null)
                        } else {
                            toastr.error(response.data.message)
                            console.error("Seen Notifications Eerror =>", response);
                        }
                    });
            }

        },
    }
}
</script>

<style scoped>

</style>
