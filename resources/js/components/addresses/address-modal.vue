<template>
    <div class="modal fade mt-modal-wrap" id="address-modal" tabindex="-1" role="dialog"
         aria-labelledby="addressModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form @submit.prevent="editmode ? updateAddress() : createAddress()">
                    <div class="modal-header">
                        <h5 class="modal-title"  v-if="!editmode">Add Address</h5>
                        <h5 class="modal-title" v-if="editmode">Update Address</h5>
                        <button type="button" class="close" >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-12 col-md-12 col-sm-12 mb-2">
                            <div class="input-style">
                                <label class="d-block">Name <span class="text-danger">*</span></label>
                                <input type="text" class="ctm-input" placeholder="Name" v-model="name">
                                <div v-if="$v.name.$error">This field is required</div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 mb-2">
                            <div class="input-style">
                                <label class="d-block">Phone Number <span class="text-danger">*</span></label>
                                <input type="tel" class="ctm-input" placeholder="Phone Number" v-model="phone">
                                <div v-if="$v.phone.$error">This field is required</div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-2" v-if="allCities.length > 0">
                            <div class="input-style custom-drop-contact">
                                <label class="d-block">Select City <span class="text-danger">*</span></label>
                                <div class="custom-selct-icons-arow position-relative height-select-2-custom">
                                    <!--                                <img src="images/arrow-down.png" class="img-fluid arrow-abs">-->
                                    <select class="form-control" v-model="city_id" @change="populateArea()">
                                        <option value="">Select City</option>
                                        <option  v-for="city of allCities" :value="city.id">{{city.title | language}}</option>
                                    </select>
                                </div>
                                <div v-if="$v.city_id.$error">This field is required</div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-2" v-if="areas.length > 0">
                            <div class="input-style custom-drop-contact">
                                <label class="d-block">Select Area <span class="text-danger">*</span></label>
                                <div class="custom-selct-icons-arow position-relative height-select-2-custom">
                                    <!--                                <img src="images/arrow-down.png" class="img-fluid arrow-abs">-->
                                    <select class="form-control" v-model="area_id" @change="initMap()">
                                        <option value="">Select Area</option>
                                        <option  v-for="area of areas" :value="area.id">{{area.title | language}}</option>
                                    </select>
                                </div>
                                <div v-if="$v.area_id.$error">This field is required</div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-2  d-none" id="map-div">
                            <div class="input-style custom-drop-contact">
                                <label class="d-block">Select Address From Map <span class="text-danger">*</span></label>
                                <div class="custom-selct-icons-arow position-relative">
                                    <input type="text" class="ctm-input" placeholder="Address" v-model="address" readonly>
                                    <div v-if="$v.address.$error">This field is required</div>
                                    <div id="map" class="map-height-hah mt-2" style="height: 400px"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                            <div class="input-style">
                                <label class="d-block">Details
                                </label>
                                <textarea class="ctm-textarea" placeholder="Write Here..." v-model="detail"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn-style btn-add w-100 " type="submit">Save</button>
                    </div>
                </form>
<!--                <p v-for="error of v.$errors" :key="error.$uid">-->
<!--                    {{ error.$message }}-->
<!--                </p>-->
            </div>
        </div>
    </div>
</template>

<script>
import { required } from 'vuelidate/lib/validators'


export default {
    name: "address-modal",
    props: [
        'cities'
    ],
    data(){
        return {
            allCities: [],
            areas: [],
            editmode: false,
            id: 0,
            name: '',
            phone: '',
            city_id: '',
            area_id: '',
            address: '',
            latitude: '',
            longitude: '',
            detail: '',
        }
    },
    validations () {
        return {
            name: { required }, // Matches this.firstName
            phone: { required }, // Matches this.lastName
            city_id: { required }, // Matches this.lastName
            area_id: { required }, // Matches this.lastName
            address: {required},
        }
    },
    created() {
        this.processCities();
        this.$eventBus.$on('open-new-address-modal', this.showModal);
        this.$eventBus.$on('open-new-address-modal-edit', this.editAddress);
    },
    beforeDestroy() {
        this.$eventBus.$off('open-new-address-modal');
    },
    methods: {
        reset(){
            $('#map-div').addClass('d-none')
            this.id = 0
            this.name = ''
            this.phone = ''
            this.city_id = ''
            this.area_id = ''
            this.address = ''
            this.latitude = ''
            this.longitude = ''
            this.detail = ''
            this.areas = []
            this.$v.$reset()
        },
        showModal($event){
            console.log("Event=>",  $event)
            this.editmode = false;
            this.reset();
            $('#address-modal').modal('show');
        },
        editAddress(event){
            console.log(event)
            this.editmode = true;
            this.id = event.id
            this.name = event.name
            this.phone = event.phone
            this.city_id = event.city.id
            this.area_id = event.area.id
            this.address = event.address
            this.latitude = event.latitude
            this.longitude = event.longitude
            this.detail = event.detail
            this.populateArea(() => {
                this.initMap()
                $('#address-modal').modal('show');
            })
        },
        createAddress(){
            this.$v.$touch()
            // console.log(isFormCorrect)
            if (!this.$v.$invalid) {
                console.log(this.name, this.phone, this.address, this.city_id, this.area_id, this.detail);
                axios
                    .post(`${window.Laravel.apiUrl}dashboard/addresses/save`, {
                        name: this.name,
                        phone: this.phone,
                        address: this.address,
                        city_id: this.city_id,
                        area_id: this.area_id,
                        longitude: this.longitude,
                        latitude: this.latitude,
                        detail: this.detail,
                    })
                    .then((response) => {
                        if (response.data.success) {
                            $('#address-modal').modal('hide');
                            this.$eventBus.$emit('addresses-changed')
                        } else {
                            console.error("Seen Notifications Eerror =>", response);
                        }
                    });
            }

        },
        updateAddress(){
            this.$v.$touch()
            // console.log(isFormCorrect)
            if (!this.$v.$invalid) {
                console.log(this.name, this.phone, this.address, this.city_id, this.area_id, this.detail);
                axios
                    .post(`${window.Laravel.apiUrl}dashboard/addresses/update/${this.id}`, {
                        name: this.name,
                        phone: this.phone,
                        address: this.address,
                        city_id: this.city_id,
                        area_id: this.area_id,
                        longitude: this.longitude,
                        latitude: this.latitude,
                        detail: this.detail,
                    })
                    .then((response) => {
                        if (response.data.success) {
                            $('#address-modal').modal('hide');
                            this.$eventBus.$emit('addresses-changed')
                        } else {
                            console.error("Seen Notifications Eerror =>", response);
                        }
                    });
            }

        },
        processCities(){
          console.log("cities =>", this.cities);
          console.log(this.cities.constructor === "test".constructor)
          if(this.cities.constructor === "test".constructor){
            this.allCities = JSON.parse(this.cities)
          }else{
            this.allCities = [...this.cities]
              console.log(this.allCities);
          }
        },
        populateArea(callback = null){
            let city = this.allCities.filter(city => city.id === this.city_id);
            console.log(city)
            if(city.length > 0 && city[0].areas && city[0].areas.length > 0){
                this.areas = city[0].areas
                // this.initMap()
                if(callback){
                    callback()
                }
            }

        },
        checkPolygon(count_point, polygon_x, polygon_y, lat, long) {
            let i = 0;
            let j = 0;
            let c = 0;
            for (i = 0,  j = count_point; i < count_point; j = i++) {
                if (((polygon_y[i] > lat != (polygon_y[j] > lat)) &&
                    (long < (polygon_x[j] - polygon_x[i]) * (lat - polygon_y[i]) / (polygon_y[j] - polygon_y[i]) + polygon_x[i])))
                    c = !c;
            }
            console.log(c)
            return c;
        },
        initMap() {
            $('#map-div').removeClass('d-none')
            let area = this.areas.filter(area => area.id == this.area_id)[0]
            let polygon = JSON.parse(area.polygon);
            let polygon_x = polygon.map(latlng => latlng.lng)
            let polygon_y = polygon.map(latlng => latlng.lat)
            let count_point = polygon.length -1;
            let lat = polygon[0].lat
            let lng = polygon[0].lng
            if(this.id > 0){
                lat = parseFloat(this.latitude)
                lng = parseFloat(this.longitude)
            }
            console.log(lat, lng);
            var lastPosition = new google.maps.LatLng(lat, lng);
            var map = new google.maps.Map(
                document.getElementById("map"), {
                    center: new google.maps.LatLng(lat, lng),
                    zoom: 13,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });
            var marker = new google.maps.Marker({
                position: {
                    lat:lat, lng: lng
                },
                map: map,
                draggable: true
            });
            const region = new google.maps.Polygon({
                map: map,
                clickable: false,
                paths:polygon,
            });
            var bounds = new google.maps.LatLngBounds();
            for(let latlng of polygon){
                bounds.extend(new google.maps.LatLng(latlng.lat, latlng.lng));
            }
            map.fitBounds(bounds);
            setTimeout(() => {
                map.setZoom(15)
            }, 200)
            let that = this
            google.maps.event.addListener(marker, 'dragend', function () {
                var position = marker.getPosition();
                if(bounds.contains(position) && that.checkPolygon(count_point,polygon_x, polygon_y , marker.getPosition().lat(), marker.getPosition().lng())){
                    lastPosition = position
                    var lat = marker.getPosition().lat();
                    var lng = marker.getPosition().lng();
                    const latlng = {
                        lat: parseFloat(lat),
                        lng: parseFloat(lng),
                    };

                    const geocoder = new google.maps.Geocoder();
                    geocoder.geocode({location: latlng}, (results, status) => {
                        if (status === "OK") {
                            if (results[0]) {
                                that.address = results[0].formatted_address;
                                that.latitude =marker.getPosition().lat();
                                that.longitude =marker.getPosition().lng();
                            } else {
                                window.alert("No results found");
                            }
                        } else {
                            window.alert("Geocoder failed due to: " + status);
                        }
                    });
                }
                else{
                    // map.setZoom(15);
                    marker.setPosition(lastPosition)

                }

            });

        }

    }
}
</script>

<style scoped>

</style>
