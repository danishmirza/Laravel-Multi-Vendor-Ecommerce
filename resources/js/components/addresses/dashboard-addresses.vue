<template>
    <div class="tab-content profile-tabs-content">
        <div class="tab-pane-wrap">
            <div class="user-profile profile-manage-address-outer">
                <div class="row">
                    <div class="col-12">
                        <button class="btn-style btn-auth w-100 btn-new-address" @click="$eventBus.$emit('open-new-address-modal')">Add New Address</button>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12" v-if="addresses && addresses.length > 0">
                        <div class="manage-address-item mb-2" v-for="address of addresses">
                            <ul class="manage-btns-wrap justify-content-end">
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
                            <ul class="user-profile-detail-mt">
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
                        <v-pagination v-model="currentPage" :page-count="pagination.total_pages" v-on:input="test($event)"></v-pagination>
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
        <address-modal :cities="cities"></address-modal>
    </div>

</template>

<script>
import vPagination from 'vue-plain-pagination'
export default {
    name: "dashboard-addresses",
    components: { vPagination },
    props: ['cities'],
    data() {
        return {
            isLoading: false,
            addresses: null,
            pagination: null,
            currentPage: 1
        }
    },
    created() {
        this.isLoading = true
        this.loadAddresses();
        this.$eventBus.$on('addresses-changed', this.loadAddresses);
    },
    methods: {
        test(page){
            this.isLoading = true
            this.loadAddresses(page)
        },
        loadAddresses(page = 1) {
            this.addresses = null;
            axios
            .get(`${window.Laravel.apiUrl}dashboard/addresses`,{params: {page: page}})
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
                                this.loadAddresses();
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
    },

}
</script>

<style scoped>

</style>
