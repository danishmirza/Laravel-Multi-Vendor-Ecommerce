<template>
    <li class="list-item cart-wrap">
        <a :href="cartPageLink" class="btn-cart">
            <img :src="baseUrl+'/assets/web/img/backet-icon.svg'" alt="">
            <span class="count">{{cartCount}}</span>
        </a>
    </li>
</template>

<script>
export default {
    name: "cart-bell",
    props: [
        "cartPageLink",
    ],
    data(){
        return {
            baseUrl: window.Laravel.base,
            cartCount: 0,
            isLoading: false,
        }
    },
    created() {
        this.setSocketListeners();
        this.isLoading = true;
        this.getCartCount();

    },
    methods: {
        setSocketListeners() {
            Echo.channel(
                `click-shine-cart-changed-` + window.Laravel.loggedInUserId
            ).listen(".cart-changed", (e) => {
                this.getCartCount();
            });
        },
        getCartCount(){
            axios
                .get(`${window.Laravel.apiUrl}dashboard/cart-count`)
                .then((response) => {
                    if (response.data.success) {
                        this.cartCount = response.data.data.count;
                        this.isLoading = false
                    } else {
                        console.error("Cart Error =>", response);
                    }
                });
        },
    }
}
</script>

<style scoped>

</style>
