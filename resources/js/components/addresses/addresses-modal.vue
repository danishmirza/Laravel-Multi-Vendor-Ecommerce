<template>
  <div class="modal fade mt-modal-wrap" id="addresses-modal" tabindex="-1" role="dialog"
       aria-labelledby="addressModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="row">
          <div class="col-12">
            <button class="btn-style btn-auth w-100 btn-new-address mb-5" type="button" @click="$eventBus.$emit('open-new-address-modal')">Add New Address</button>
          </div>
          <div class="col-lg-12 col-md-12 col-sm-12" v-if="addresses && addresses.length > 0">
            <div class="manage-address-item mb-2" v-for="address of addresses">
              <!-- <input type="radio" name="address-checkbox" :checked="defaultAddress && address.id === defaultAddress.id" > -->
              <ul class="manage-btns-wrap justify-content-end">
                <li>
                  <!-- <a @click="selectDefaultAddress(address)" class="address-edit-btn btn-new-address">
                    <i class="far fa-edit"></i>
                  </a> -->
                </li>
                <li>
                  <a @click="$eventBus.$emit('open-new-address-modal-edit', address)" class="address-edit-btn btn-new-address">
                    <i class="far fa-edit"></i>
                  </a>
                </li>
                <li>
                  <a @click="deleteAddress(address.id)" class="address-delete-btn">
                    <i class="fas fa-trash-alt"></i>
                  </a>
                </li>
              </ul>
              <ul class="user-profile-detail-mt custom-radion-stle-pa-check">
                 <label class="custom-radio home-cr"  @click="selectDefaultAddress(address)">
                   <div class="custom-add-li-parent-us">
                         <li>

                  <h5 class="profile-title d-flex">
                    <span class="span-col">Name: </span>
                    <span class="text">{{address.name}}</span>
                  </h5>
                </li>

                <li>
                  <h5 class="profile-title d-flex">
                    <span class="span-col">Phone No:</span>
                    <span class="text">
                                  <a href="tel:+9681773265">{{address.phone}}</a>
                                </span>
                  </h5>
                </li>
                <li>
                  <h5 class="profile-title d-flex">
                    <span class="span-col">Address: </span>
                    <span class="text">
                                  {{address.address}}
                                </span>
                  </h5>
                </li>
                <li>
                  <h5 class="profile-title d-flex">
                    <span class="span-col">City And Area: </span>
                    <span class="text">
                                  {{address.city.title | language}}, {{address.area.title | language}}
                                </span>
                  </h5>
                </li>
                <li>
                  <h5 class="profile-title d-flex">
                    <span class="span-col">Detail: </span>
                    <span class="text">
                                   {{address.detail}}
                                </span>
                  </h5>
                </li>

                   </div>
                  <input type="radio" name="radio-address" :checked="defaultAddress && address.id === defaultAddress.id">
                  <span class="checkmark home-checkmark"></span>
                  </label>

              </ul>
            </div>
          </div>
          <div class="col-12" v-if="addresses && addresses.length <= 0">
            <div class="alert alert-danger col-12" role="alert">
              You have not added any addresses.
            </div>
          </div>
          <div class="col-12" v-if="pagination && pagination.last_page > 1">
            <p>page: {{ currentPage }}</p>
            <v-pagination v-model="currentPage" :page-count="pagination.last_page" v-on:input="test($event)"></v-pagination>
            <!--                        <VuePaginationTw-->
            <!--                            :totalItems="pagination."-->
            <!--                            :currentPage="1"-->
            <!--                            :perPage="6"-->
            <!--                            @pageChanged="functionName"-->
            <!--                            :goButton="false"-->
            <!--                            styled="centered"-->
            <!--                        />-->
          </div>
        </div>
      </div>
    </div>
    <address-modal :cities="addressesCities"></address-modal>
  </div>

</template>

<script>
export default {
  name: "addresses-modal",
  props: [
      'selectedArea',
    'addressesCities',
      'defaultAddress'
  ],
  data(){
    return {
        isLoading: false,
      addresses: null,
        pagination: null
    }
  },
  created() {
    // this.processCities();
      this.$eventBus.$on('addresses-changed', this.getAddresses);
    this.$eventBus.$on('open-addresses-modal', this.showModal);
    this.getAddresses()
  },
  beforeDestroy() {
    this.$eventBus.$off('addresses-changed');
    this.$eventBus.$off('open-addresses-modal');
  },
  methods: {
    showModal($event) {
      $('#addresses-modal').modal('show');
    },
      getAddresses(){
          console.log(1);
          this.addresses = null;
          axios
              .get(`${window.Laravel.apiUrl}dashboard/addresses`,{params: {page: 1, perPage: 20, area_id:this.selectedArea}})
              .then((response) => {
                  if (response.data.success) {
                      this.addresses = response.data.data.collection;
                      this.pagination = response.data.data.pagination;
                      this.isLoading = false;
                  } else {
                      console.error("Addresses Error =>", response);
                  }
              });
      },
    deleteAddress(addressId){
      this.$swal(
          {
            title: 'Are you sure?',
            text: 'Do you want to deleted this address',
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
              .get(`${window.Laravel.apiUrl}dashboard/addresses/delete/${addressId}`)
              .then((response) => {
                if (response.data.success) {
                  toastr.success(response.data.message)
                  this.getAddresses();
                } else {
                  toastr.error(response.data.message)
                  console.error("Seen Notifications Eerror =>", response);
                }
              });
        } else {
          this.$swal.close();
        }
      });

    },
    selectDefaultAddress(address){
        let params = new URLSearchParams(window.location.search);
        params.set('address_id', address.id)
        console.log(window.location.origin + window.location.pathname +'?'+params.toString())
        window.location.href = window.location.origin + window.location.pathname+'?'+params.toString()
      // this.defaultAddress = address
      // axios
      //     .get(`${window.Laravel.apiUrl}dashboard/addresses/default/${address.id}`)
      //     .then((response) => {
      //       if (response.data.success) {
      //
      //         // this.$eventBus.$emit('default-address-changed', address)
      //         // $('#addresses-modal').modal('hide');
      //       } else {
      //         toastr.error(response.data.message)
      //         console.error("Seen Notifications Eerror =>", response);
      //       }
      //     });
    }
  }
}
</script>

<style scoped>

</style>
