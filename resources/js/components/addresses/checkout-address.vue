<template>
  <div class="order-list-wrap order-checkout-wrap add-address-wrap border-bottom">
    <div class="d-flex align-items-baseline">
      <h4 class="order-main-title">Add Address</h4>
      <a  class="ml-auto btn-address" @click="$eventBus.$emit('open-addresses-modal')">
        Select/Change Address
      </a>

    </div>
     <ul class="user-profile-detail-mt check-out-show-adress-uss" v-if="defaultAddress">
        <li>
          <h5 class="profile-title d-flex">

            <span class="span-col">Name: </span>
            <span class="text">{{defaultAddress.name}}</span>
          </h5>
        </li>

        <li>
          <h5 class="profile-title d-flex">
            <span class="span-col">Phone No:</span>
            <span class="text">
                                  <a href="tel:+9681773265">{{defaultAddress.phone}}</a>
                                </span>
          </h5>
        </li>
        <li>
          <h5 class="profile-title d-flex">
            <span class="span-col">Address: </span>
            <span class="text">
                                  {{defaultAddress.address}}
                                </span>
          </h5>
        </li>
        <li>
          <h5 class="profile-title d-flex">
            <span class="span-col">City And Area: </span>
            <span class="text">
                                  {{defaultAddress.city.title | language}}, {{defaultAddress.area.title | language}}
                                </span>
          </h5>
        </li>
        <li>
          <h5 class="profile-title d-flex">
            <span class="span-col">Detail: </span>
            <span class="text">
                                   {{defaultAddress.detail}}
                                </span>
          </h5>
        </li>
      </ul>
    <addresses-modal :selected-area="area"  :addresses-cities="cities" :default-address="defaultAddress"></addresses-modal>
  </div>

</template>

<script>
export default {
  name: "checkout-address",
  props:[
    'cities',
      'defaultAddressProp',
      'area'
  ],
  data(){
    return {
      defaultAddress: (this.defaultAddressProp) ? {...this.defaultAddressProp}: null
    }
  },
  created() {
    // this.$eventBus.$on('addresses-changed', this.getAddresses);
    this.$eventBus.$on('default-address-changed', this.setDefaultAddress);
  },
  beforeDestroy() {
    this.$eventBus.$off('default-address-changed');
  },
  methods:{

    setDefaultAddress(event){
      this.defaultAddress = event
    }
  }
}
</script>

<style scoped>

</style>
