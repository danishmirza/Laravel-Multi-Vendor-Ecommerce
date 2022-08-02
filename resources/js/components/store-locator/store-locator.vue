<template>
    <section class="map-section">
        <div class="container">
            <!--Heading Layout Start-->
            <div class="heading-outer heading-outer-white text-center">
                <h2 class="heading-title">Nearby Suppliers</h2>
                <p>Your nearby service providers waiting to serve you</p>
            </div>
            <!--Heading Layout End-->
            <div class="row align-items-center">
                <div class="col-lg-10 col-md-12">
                    <div class="contact-map">
                        <div id="map"></div>
                        <div class="map-inputs">
                            <div
                                class="w-100 d-flex align-items-center justify-content-start justify-content-md-between flex-wrap flex-md-nowrap">
                                <div class="map-search d-flex align-items-center justify-content-between">
                                    <input type="text" class="input-map" placeholder="Search By Location" id="address-input">
                                    <button class="bnt-search srch-btn-m" @click="getNearByStores"><i class="fas fa-search"></i></button>
                                    <div class="close-icon-store-s">
                                        <i class="fa fa-close"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="current-lact" @click="getCurrentLocation()">
                            <img :src="base+'/assets/web/img/target.svg'" class="img-fluid" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-12" v-if="stores.length > 0">

                    <div id="map-slider">
                        <div class="slider-item" v-for="store of stores">
                            <!--Map Item Start-->
                            <div class="map-info-box" >
                                <figure class="mt-thumb">
                                    <img :src="store.image | timthumb(430,222,95,2)" alt="">
                                </figure>
                                <div class="text-wrap text-center">
                                    <span class="item-name">{{store.city.title | language}}</span>
                                    <h4 class="title">
                                        <a :href="goToStore(store.id)">{{store.store_name | language}}</a>
                                    </h4>
                                    <div class="star-rating-area justify-content-center mb-1">
                                        <div class="rating-static clearfix" :rel="store.average_rating">
                                            <label class="full" title="Awesome - 5 stars"></label>
                                            <label class="half" title="Pretty good - 4.5 stars"></label>
                                            <label class="full" title="Pretty good - 4 stars"></label>
                                            <label class="half" title="Meh - 3.5 stars"></label>
                                            <label class="full" title="Meh - 3 stars"></label>
                                            <label class="half" title="Kinda bad - 2.5 stars"></label>
                                            <label class="full" title="Kinda bad - 2 stars"></label>
                                            <label class="half" title="Meh - 1.5 stars"></label>
                                            <label class="full" title="Sucks big time - 1 star"></label>
                                            <label class="half" title="Sucks big time - 0.5 stars"></label>
                                        </div>
                                        <div class="ratilike ng-binding">{{store.average_rating}}</div>
                                    </div>
                                    <ul class="listed">
                                        <li>
                                            <i class="fas fa-map-marker-alt"></i>
                                            {{store.address}}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!--Map Item End-->
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
name: "store-locator.vue",
    props:[
      'siteLatitude',
      'siteLongitude'
    ],
    data(){
        return{
            base: window.Laravel.base,
            map: null,
            isLoading: false,
            stores: [],
            pagination: null,
            searchParams: {
                address: '',
                latitude: null,
                longitude: null,
            },
            storesHighlight: [],
            markers:[]
        }
    },
    mounted() {
        this.getNearByStores()
        this.initMap(this.siteLatitude, this.siteLongitude);
        let autocomplete = new google.maps.places.Autocomplete(document.getElementById('address-input')),
            callback = (location) => {
                this.searchParams.latitude = location.lat();
                this.searchParams.longitude = location.lng();
            };
        autocomplete.addListener("place_changed", () => {
            //get the place result
            let place = autocomplete.getPlace();
            //verify result
            if (place.geometry === undefined || place.geometry === null) {
                this.searchParams.address = '';
                this.searchParams.latitude = this.siteLatitude;
                this.searchParams.longitude = this.siteLongitude;
                return;
            }
            this.searchParams.address = place.formatted_address;
            this.searchParams.latitude = place.geometry.location.lat();
            this.searchParams.longitude = place.geometry.location.lng();
            this.map.setCenter(place.geometry.location);
            // this.setCurrentLocationMarker();
            this.searchParams.longitude = place.geometry.location.lng();
            this.searchParams.latitude = place.geometry.location.lat();
            this.getNearByStores();
        });
        // this.scrollToMainElement();
    },
    methods:{
        initMap(lat, lng){
            console.log(document.getElementById('map-div'))
            let styleMapType = new google.maps.StyledMapType([
                {
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#fcfafa"
                        }
                    ]
                },
                {
                    "elementType": "labels.icon",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#616161"
                        }
                    ]
                },
                {
                    "elementType": "labels.text.stroke",
                    "stylers": [
                        {
                            "color": "#f5f5f5"
                        }
                    ]
                },
                {
                    "featureType": "administrative",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#eeeeee"
                        },
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "administrative.land_parcel",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#bdbdbd"
                        }
                    ]
                },
                {
                    "featureType": "poi",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "poi",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#eeeeee"
                        }
                    ]
                },
                {
                    "featureType": "poi",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#757575"
                        }
                    ]
                },
                {
                    "featureType": "poi.park",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#e5e5e5"
                        }
                    ]
                },
                {
                    "featureType": "poi.park",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#9e9e9e"
                        }
                    ]
                },
                {
                    "featureType": "road",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#eeeeee"
                        },
                        {
                            "visibility": "on"
                        }
                    ]
                },
                {
                    "featureType": "road",
                    "elementType": "labels.icon",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "road.arterial",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#757575"
                        },
                        {
                            "visibility": "on"
                        }
                    ]
                },
                {
                    "featureType": "road.highway",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#e2e2e2"
                        },
                        {
                            "visibility": "on"
                        }
                    ]
                },
                {
                    "featureType": "road.highway",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#616161"
                        }
                    ]
                },
                {
                    "featureType": "road.local",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#9e9e9e"
                        }
                    ]
                },
                {
                    "featureType": "transit",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "transit.station",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#eeeeee"
                        }
                    ]
                },
                {
                    "featureType": "water",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#c9c9c9"
                        }
                    ]
                },
                {
                    "featureType": "water",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#9e9e9e"
                        }
                    ]
                }
            ]);
            let mapProp = {
                center: new google.maps.LatLng(lat, lng),
                zoom: 5,
                disableDefaultUI: true,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
            };
            this.map = new google.maps.Map(document.getElementById('map'), mapProp);
            // this.map.mapTypes.set('styled_map', styleMapType);
            // this.map.setMapTypeId('styled_map');
            this.setCurrentLocationMarker()
        },
        setCurrentLocationMarker() {
            this.clearMarkers();
            let location = new google.maps.LatLng(this.searchParams.latitude, this.searchParams.longitude),
                info = 'Search point';
            this.setMarker(location, info, true);
        },
        getNearByStores() {
            this.isLoading = true;
            this.stores = [];
            axios.get(`${window.Laravel.apiUrl}stores`,{params: this.searchParams}).then((response) => {
                if (response.data.success) {
                    this.isLoading = false;
                    this.stores = response.data.data.collection;
                    console.log(this.stores)
                    this.initStoreSlider();
                    this.pagination = response.data.data.pagination;
                    if (response.data.data.collection.length > 0) {
                        let mapBounds = new google.maps.LatLngBounds(), latlng = null;
                        for (let b in response.data.data.collection) {
                            latlng = new google.maps.LatLng(response.data.data.collection[b].latitude, response.data.data.collection[b].longitude);
                            this.setMarker(latlng, this.getInfoWindowContent(response.data.data.collection[b]), response.data.data.collection[b].id, response.data.data.collection);
                            mapBounds.extend(latlng);
                        }
                        this.map.fitBounds(mapBounds);
                    }
                }else{
                    this.isLoading = false;
                }
            })
        },
        setMarker(location, infoWindowContent, storeId, stores  , self = false) {
            // console.log(`${this.base+'/assets/web/img/location.png'}`)
            let that = this;
            let marker = new google.maps.Marker({
                    position: location,
                    map: this.map,
                    draggable: false,
                    icon: `${this.base+'/assets/web/img/location.png'}`,
                }),
                infowindow = new google.maps.InfoWindow({
                    content: infoWindowContent,
                    // maxWidth: 200
                });
            marker.addListener('click', function () {
                this.storesHighlight = stores.map(store => { return {...store, isHighLighted:false}})
                // for (let b in  this.storesHighlight) {
                //     this.storesHighlight[b].isHighLighted = 'false';
                // }
                console.log('Stores Highlighted =>', this.storesHighlight);

                if(this.storesHighlight.length > 0){
                    let a = this.storesHighlight.findIndex(x => x.id === storeId);
                    if(a){
                        this.HighlightedStore = a;
                        this.storesHighlight[a].isHighLighted = 'true';
                        this.stores = this.storesHighlight;
                    }
                }
                infowindow.open(that.map, marker);
            });
            this.markers.push(marker);
        },
        clearMarkers() {
            if (this.markers.length > 0) {
                for (let i in this.markers) {
                    this.markers[i].setMap(null);
                }
                this.markers = [];
            }
        },
        getCurrentLocation(){
            navigator.geolocation.getCurrentPosition((position) => {
                this.initMap(position.coords.latitude, position.coords.longitude);
                let latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude),
                    geocoder = new google.maps.Geocoder();
                geocoder.geocode({ location: latlng }, (results, status) => {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            this.ngZone.run(() => {
                                this.searchParams.address = results[0].formatted_address;
                                this.searchParams.longitude = position.coords.longitude;
                                this.searchParams.latitude = position.coords.latitude;
                                this.getNearByStores();
                            });
                        }
                    }
                });
            }, (ex) => {
                // this.initMap(environment.location.lat, environment.location.lng);
                // this.params.location[0] = environment.location.lng;
                // this.params.location[1] = environment.location.lat;
                // this.getNearByStores()
            });
        },
        getInfoWindowContent(user) {
            return `
            <a href='${window.Laravel.baseUrl}stores/detail/${user.id}' target="_blank">
            <div class="map-shop-mt-custom">
             <div class="image img-height-uss">
                <img alt="" class="img-fluid" src="${user.image}" class="img-fluid">
              </div>
              <div class="text-map-mt">
                <h3>${user.store_name['en']}</h3>
                <h6>${user.address}</h6>
              </div>

            </div></a>`;
        },
        initStoreSlider(){
            setTimeout(() => {
                $('#map-slider').slick({
                    slidesToScroll: 1,
                    arrows: true,
                    dots: false,
                    vertical: true,
                    verticalSwiping: true,
                    infinite: true,
                    autoplay: false,
                    autoplaySpeed: 1000,
                    speed: 1500,
                    prevArrow: `<div class="slick-prev"><svg xmlns="http://www.w3.org/2000/svg" width="19.632" height="10.708" viewBox="0 0 19.632 10.708">
                                  <path id="down-chevron" d="M18.612,0l-8.8,8.686L1.02,0,0,1.014l9.816,9.694,9.816-9.694Z" transform="translate(19.632 10.708) rotate(180)" fill="rgba(153,153,153,0.5)"/></svg>
                                </div>`,
                    nextArrow: `<div class="slick-next"><svg xmlns="http://www.w3.org/2000/svg" width="19.632" height="10.708" viewBox="0 0 19.632 10.708">
                                  <path id="down-chevron" d="M18.612,0l-8.8,8.686L1.02,0,0,1.014l9.816,9.694,9.816-9.694Z" fill="rgba(153,153,153,0.5)"/></svg>
                                </div>`,
                });

            }, 500);
        },
        goToStore(storeId){
            return `${window.Laravel.baseUrl}stores/detail/${storeId}`
        }
    }
}
</script>

<style scoped>

</style>
