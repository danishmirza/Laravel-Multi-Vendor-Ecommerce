<template>
    <li class="d-flex">
        Coupon Code
        <span class="enter-code ml-auto" v-if="!coupon">
            <a class="primary-color" @click="$eventBus.$emit('open-coupon-modal')">Enter Code</a>
        </span>
        <span class="enter-code ml-auto" v-if="coupon">
            <a class="primary-color" @click="removeCoupon()">Remove Coupon Code</a>
        </span>
        <p v-if="coupon">{{coupon.discount}}% is applied</p>
        <add-coupon></add-coupon>
    </li>
</template>

<script>
export default {
name: "coupon-checkout-template",
    props:[
        'implementedCoupon'
    ],
    data(){
        return {
            isLoading: false,
            coupon: (this.implementedCoupon) ? {...this.implementedCoupon}: null
        }
    },
    created() {
        console.log(window.location)
        this.$eventBus.$on('coupon-changed', this.couponChanged);
    },
    beforeDestroy() {
        this.$eventBus.$off('coupon-changed');
    },
    methods: {
        couponChanged(coupon) {
            this.coupon = coupon;
        },
        removeCoupon(){
            axios
                .get(`${window.Laravel.apiUrl}dashboard/coupon/remove`)
                .then((response) => {
                    if (response.data.success) {
                        // this.$eventBus.$emit('coupon-changed', null)
                       window.location.reload()
                    } else {
                        toastr.error(response.data.message)
                        console.error("Seen Notifications Eerror =>", response);
                    }
                });
        }
    }
}
</script>

<style scoped>

</style>
