@extends('web.layouts.app')

@section('content')
    <section class="services-section services-latest-section pd-tb100">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-lg-4">
                    <aside class="sidebar">
                        <div class="widget widget-filter">
                            <!-- new code -->
                            <h4 class="widget-title d-flex mb-3">
                                    Filters
                                    @if(count(request()->all()) > 0)
                                    <a href="{{route($route)}}" class="btn-filter ml-auto">
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
                                        <div class="input-style">
                                            <label class="d-block">Min Price</label>
                                            <div class="type-pass">
                                                <input type="text" class="ctm-input" placeholder="Min Price" name="min_price" value="{{request('min_price')}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12 col-sm-12 mb-2">
                                        <div class="input-style">
                                            <label class="d-block">Max Price</label>
                                            <div class="type-pass">
                                                <input type="text" class="ctm-input" placeholder="Max Price" name="max_price" value="{{request('max_price')}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12 col-sm-12 mb-2">
                                        <div class="input-style custom-drop-contact ">
                                            <label class="d-block">Category</label>
                                            <div class="custom-selct-icons-arow position-relative">
                                                <img src="{{asset('assets/web/img/down-chevron.svg')}}" class="img-fluid arrow-abs">
                                                <select id="category-search" class="selectpicker" name="subcategories[]" multiple>
                                                    <option value="">Select Category</option>
                                                    @forelse($categories as $category)
                                                        <optgroup label="{{$category->title['en']}}"></optgroup>
                                                        @forelse($category->subcategories as $subcategory)
                                                            <option value="{{$subcategory->id}}" title="{{$category->title[app()->getLocale()].', '.$subcategory->title[app()->getLocale()]}}" {{( in_array($subcategory->id, request('subcategories', [])) ) ? 'selected': ''}}>{{$subcategory->title['en']}}</option>
                                                        @empty

                                                        @endforelse
                                                    @empty
                                                    @endforelse
                                                </select>
                                            </div>
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
                    <div class="row supplier-row">
                        @forelse($services as $service)
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            @include('web.common.service', ['service' => $service])
                        </div>
                        @empty
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

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
        });
    </script>
@endpush
