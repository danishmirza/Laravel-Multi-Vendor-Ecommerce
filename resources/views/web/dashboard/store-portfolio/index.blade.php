@extends('web.dashboard.layouts.dashboard')

@push('style-end')
    <link href="{{asset('lightbox/css/lightbox.min.css')}}" rel="stylesheet" />
@endpush

@section('content-dashboard')
    @include('web.common.alerts')
    <div class="tab-content profile-tabs-content">
        <div class="tab-pane-wrap">
            <div class="user-profile portfolio-wrap-outer">
                <div class="row add-service-btn-wrap">
                    <div class="col-lg-12 col-md-12 col-sm-12 mb-3 d-flex">
                        <a class="btn-style btn-portfolio btn-middle-wrap ml-auto" href="{{route('web.dashboard.portfolios.create')}}" >Add Portfolio</a>
                    </div>
                </div>
                <div class="row">
                    @forelse($images as $key => $image)
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="portfolio-item manage-portfolio">
                            <figure class="thumb">
                                <a href="{{asset($image->image)}}" data-lightbox="portfolio-image" data-title="Portfolio Image">
                                    <img class="img-fluid" src="{{imageUrl($image->image, 520,520,95,2)}}" alt="">
                                </a>
                                <figcaption class="caption">
                                    <div class="btns-wrap">
                                        <a href="{{route('web.dashboard.portfolios.delete', ['portfolio' => $image->id])}}" class="btn btn-trash delete-confirm" data-message="Do you want to delete this image?">
                                            <img src="{{asset('assets/web/img/trash-icon.svg')}}" alt="">
                                        </a>
                                    </div>
                                </figcaption>
                            </figure>
                        </div>
                    </div>
                    @empty
                        <div class="col-12">
                            @include('web.common.not-found', ['message' => 'No portfolio images added.'])
                        </div>
                    @endforelse
                </div>
                <div class="row">
                    <div class="col-12 text-right mt-1">
                        {!! $images->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script-end')
    <script src="{{asset('lightbox/js/lightbox.min.js')}}" ></script>
    <script src="{{asset('assets/web/js/website.js')}}" ></script>
@endpush
