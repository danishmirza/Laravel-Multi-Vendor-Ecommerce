import './bootstrap';
import Vue from 'vue/dist/vue';
import 'sweetalert2/dist/sweetalert2.css';
import VueSweetalert2 from 'vue-sweetalert2';
import Language from './filters/language'
import Elapsed from './filters/elapsed'
import Timthumb from './filters/timthumb'
import Vuelidate from 'vuelidate'


Vue.use(Vuelidate)
Vue.use(VueSweetalert2);
Vue.filter('language', Language);
Vue.filter('elapsed', Elapsed);
Vue.filter('timthumb', Timthumb);
Vue.prototype.$eventBus = new Vue();

Vue.component('cart-bell', require('./components/cart/cart-bell.vue').default);

Vue.component('notification-bell', require('./components/notifications/notification-bell.vue').default);
Vue.component('notification-page', require('./components/notifications/notification-page.vue').default);

Vue.component('address-modal', require('./components/addresses/address-modal.vue').default);
Vue.component('dashboard-addresses', require('./components/addresses/dashboard-addresses.vue').default);
Vue.component('checkout-address', require('./components/addresses/checkout-address.vue').default);
Vue.component('addresses-modal', require('./components/addresses/addresses-modal.vue').default);

Vue.component('add-coupon', require('./components/coupons/add-coupon.vue').default);
Vue.component('coupon-checkout-template', require('./components/coupons/coupon-checkout-template.vue').default);

Vue.component('conversations', require('./components/chat/listing.vue').default);
Vue.component('messages', require('./components/chat/messages.vue').default);

Vue.component('store-locator', require('./components/store-locator/store-locator.vue').default);

const app = new Vue({
    el: '#main-app',
    data: {

    },
});
