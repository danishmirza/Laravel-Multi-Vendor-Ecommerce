@extends('web.dashboard.layouts.dashboard')

@section('content-dashboard')
    @include('web.common.alerts')
    <div class="tab-content profile-tabs-content">
        <div class="tab-pane-wrap">
            <div class="user-profile portfolio-wrap-outer">
                <form class="portfolio-inner text-center" action="{{route('web.dashboard.portfolios.store.submit')}}" method="POST" id="portfolio-image">
                    @csrf
                    <div class="col-12 col-md-12 col-sm-12 mb-2">
                        <h4 class="portfolio-title">Add New Portfolio Image</h4>
                        @include('web.common.image-uploader', [
                                   'imageLabel' => 'Upload Image',
                                   'isRequired' => true,
                                   'inputName' => 'image',
                                   'uploadedImage' => old('image', null),
                                   'allowDelete' => true,
                                   'recommendSize' => '250 x 250',
                                   'submitButtonId' => '#submit-id',
                                   'isGallery' => true
                               ])
                    </div>
                    <div class="col-12 col-md-12 col-sm-12">
                        <button class="btn-style btn-add w-100" type="submit">Add <i class="fa fa-spinner fa-spin d-none" id="submit-id"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script-end')
    <script src="{{asset('assets/web/js/parsley.min.js')}}"></script>
    <script src="{{asset('assets/web/js/website.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('#portfolio-image').parsley();
        });
    </script>
@endpush
