@extends('admin.layouts.app')
{{--@section('breadcrumb')--}}
{{--    @include('admin.common.breadcrumbs')--}}
{{--@endsection--}}

@push('stylesheet-page-level')
@endpush

@push('script-page-level')


@endpush

@section('content')
    <div class="m-portlet ">
        <div class="m-portlet__body  m-portlet__body--no-padding">
            <div class="row m-row--no-padding m-row--col-separator-xl">

                <div class="col-md-12 col-lg-6 col-xl-3">
                    <!--begin::New Feedbacks-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                Users
                            </h4>
                            <br>
                            <span class="m-widget24__desc">
                                Total Users
                            </span>
                            <span class="m-widget24__stats m--font-info">
                                {{$users}}
                            </span>
                            <div class="m--space-10"></div>

                        </div>
                    </div>

                    <!--end::New Feedbacks-->
                </div>

                <div class="col-md-12 col-lg-6 col-xl-3">
                    <!--begin::New Orders-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                Service Providers
                            </h4>
                            <br>
                            <span class="m-widget24__desc">
                                Total Service Providers
                            </span>
                            <span class="m-widget24__stats m--font-info ">
                               {{$stores}}
                            </span>
                            <div class="m--space-10"></div>

                        </div>
                    </div>
                    <!--end::New Orders-->
                </div>
                <div class="col-md-12 col-lg-6 col-xl-3">
                    <!--begin::New Orders-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                Services
                            </h4>
                            <br>
                            <span class="m-widget24__desc">
                                Total Services
                            </span>
                            <span class="m-widget24__stats m--font-info">
                              {{$services}}
                            </span>
                            <div class="m--space-10"></div>

                        </div>
                    </div>
                    <!--end::New Orders-->
                </div>


                <div class="col-md-12 col-lg-6 col-xl-3">
                    <!--begin::New Feedbacks-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                Cities
                            </h4>
                            <br>
                            <span class="m-widget24__desc">
                                Total Cities
                            </span>
                            <span class="m-widget24__stats m--font-info">
                               {{$cities}}
                            </span>
                            <div class="m--space-10"></div>

                        </div>
                    </div>
                    <!--end::New Feedbacks-->
                </div>




                <div class="col-md-12 col-lg-6 col-xl-3">
                    <!--begin::New Feedbacks-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                Categories
                            </h4>
                            <br>
                            <span class="m-widget24__desc">
                                Total Categories
                            </span>
                            <span class="m-widget24__stats m--font-info">
                              {{$categories}}
                            </span>
                            <div class="m--space-10"></div>

                        </div>
                    </div>
                    <!--end::New Feedbacks-->
                </div>

                <div class="col-md-12 col-lg-6 col-xl-3">
                    <!--begin::New Feedbacks-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                FAQS
                            </h4>
                            <br>
                            <span class="m-widget24__desc">
                                Total FAQS
                            </span>
                            <span class="m-widget24__stats m--font-info">
                              {{$faqs}}
                            </span>
                            <div class="m--space-10"></div>

                        </div>
                    </div>
                    <!--end::New Feedbacks-->
                </div>

                <div class="col-md-12 col-lg-6 col-xl-3">
                    <!--begin::New Feedbacks-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                Articles
                            </h4>
                            <br>
                            <span class="m-widget24__desc">
                                Total Articles
                            </span>
                            <span class="m-widget24__stats m--font-info">
                              {{$articles}}
                            </span>
                            <div class="m--space-10"></div>

                        </div>
                    </div>
                    <!--end::New Feedbacks-->
                </div>
            </div>


        </div>
    </div>

@endsection

@section('custom_js')

@endsection
