@extends('web.layouts.app')

@section('content')

    <section class="section pd-tb100">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-lg-4">
                    <aside class="sidebar">
                        <div class="widget widget-filter">
                            <!-- new code  -->
                            <h4 class="widget-title d-flex mb-3">
                                    Filters
                                    @if(count(request()->all()) > 0)
                                    <a href="{{route('web.front.stores')}}" class="btn-filter ml-auto">
                                        Clear
                                        <span class="icon-box">
                                        <i class="fas fa-times-circle"></i>
                                        </span>
                                    </a>
                                    @endif
                            </h4>

                            <!-- end new code -->

                            <form method="get" class="widget-form">
                                <div class="row">

                                    <div class="col-12 col-md-12 col-sm-12 mb-2">
                                        <div class="input-style">
                                            <label class="d-block">Keyword</label>
                                            <div class="type-pass">
                                                <input type="text" class="ctm-input" placeholder="Keyword" name="keyword" value="{{request('keyword')}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12 col-sm-12 mb-2">
                                        <div class="input-style custom-drop-contact ">
                                            <label class="d-block">Category</label>
                                            <div class="custom-selct-icons-arow position-relative">
                                                <img src="{{asset('assets/web/img/down-chevron.svg')}}" class="img-fluid arrow-abs">
                                                <select id="category-search" class="selectpicker" name="subcategory_id[]" multiple>
                                                    <option value="">Select Category</option>
                                                    @forelse($categories as $category)
                                                        <optgroup label="{{$category->title['en']}}"></optgroup>
                                                        @forelse($category->subcategories as $subcategory)
                                                            <option value="{{$subcategory->id}}" title="{{$category->title[app()->getLocale()].', '.$subcategory->title[app()->getLocale()]}}" {{( in_array($subcategory->id, request('subcategory_id', [])) ) ? 'selected': ''}}>{{$subcategory->title['en']}}</option>
                                                        @empty

                                                        @endforelse
                                                    @empty
                                                    @endforelse
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12 col-sm-12 mb-2">
                                        <div class="input-style">
                                            <label class="d-block">Location</label>
                                          <div class="address-licon-input-us">
                                          <input type="text" class="ctm-input" placeholder="Address" name="address"
                                                   value="{{request('address')}}"
                                                   id="address"
                                                   readonly required
                                                   data-target="#register-map-model"
                                                   data-toggle="modal"
                                                   data-latitude="#latitude"
                                                   data-longitude="#longitude"
                                                   data-address="#address"
                                            />
                                            <div class="icon-eye d-flex align-items-center justify-content-center primary-colorBg"
                                                 data-target="#register-map-model"
                                                 data-toggle="modal"
                                                 data-latitude="#latitude"
                                                 data-longitude="#longitude"
                                                 data-address="#address"
                                            >
                                                <i class="fas fa-map-marker-alt"></i>
                                            </div>

                                          </div>
                                            <input type="hidden" name="latitude" id="latitude" class="latitude"
                                                   value="{{request('latitude')}}">
                                            <input type="hidden" name="longitude" id="longitude" class="longitude"
                                                   value="{{request('longitude')}}">
                                        </div>
                                    </div>
                                    <div class="col-12 mb-4">
                                        <button class="btn-style btn-auth w-100" type="submit">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </aside>
                </div>
                <div class="col-md-8 col-lg-8">
                    <div class="row">
                        @forelse($stores as $store)
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="blog-item service-provider-item">
                                <figure class="mt-thumb">
                                    <a href="{{route('web.front.store.detail', ['user' => $store->id])}}">
                                        <img src="{{imageUrl($store->image, 370,236,95,2)}}" alt="">
                                    </a>
                                </figure>
                                <div class="text-wrap">
                                    <h5 class="sub-title d-flex">
                                        <a href="{{route('web.front.store.detail', ['user' => $store->id])}}">{{$store->store_name[app()->getLocale()]}}</a>
                                        <span class="ml-auto desination">
                                              {{$store->city->title[app()->getLocale()]}}
                                        </span>
                                    </h5>
                                    @include('web.common.rating', ['rating'=> $store->average_rating])
                                    <ul class="listed d-flex">
                                        <li>
                                            <i class="fas fa-map-marker-alt"></i>
                                            {{$store->address}}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @empty
                            <div class="col-12">
                                @include('web.common.not-found', ['message' => "No service providers found"])
                            </div>
                        @endforelse
                            {!! $stores->onEachSide(0)->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('web.common.location-picker')
@endsection

@push('script-end')
    <script>
        function formatState (state) {
            if (!state.id) {
                return state.text;
            }
            return state.title;
        };
        $(document).ready(function() {
            $('#category-search').select2({
                placeholder: "Select Categories",
                minimumResultsForSearch: -1,
                templateSelection: formatState
            });
            $('#subcategory-search').select2({
                minimumResultsForSearch: -1
            });
        });
    </script>
@endpush
