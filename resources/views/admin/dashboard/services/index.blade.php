@extends('admin.layouts.app')

@push('stylesheet-page-level')
@endpush

@push('script-page-level')
    <script>
        var storeId = '{{$storeId}}'
    </script>
    <script src="{{asset('assets/admin/js/adv_datatables/csrf_token.js')}}" type="text/javascript"></script>
    @if($storeId > 0)
    <script src="{{asset('assets/admin/js/adv_datatables/services.js')}}" type="text/javascript"></script>
    @else
        <script src="{{asset('assets/admin/js/adv_datatables/services-all.js')}}" type="text/javascript"></script>
    @endif
@endpush

@section('content')

    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Services
                        <small>
                            Here You Can Add, Edit or Delete Services
                        </small>
                    </h3>
                </div>
            </div>
            @if($storeId > 0)
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" data-dropdown-toggle="hover" aria-expanded="true">
                            <a href="{!! route('admin.dashboard.stores.services.create', ['store' => $storeId]) !!}" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                                <span>
                                    <i class="la la-plus"></i>
                                    <span>
                                        Add Service
                                    </span>
                                </span>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
                @endif
        </div>
        <div class="m-portlet__body">
            <!--begin: Search Form -->
{{--            <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">--}}
{{--                <div class="row align-items-center">--}}
{{--                    <div class="col-xl-12 order-2 order-xl-1">--}}
{{--                        <form class="form-group m-form__group row align-items-center" action="" id="manage-store-search">--}}
{{--                            <div class="col-md-12" style="margin-top: -22px;margin-bottom: 15px;">--}}
{{--                                <h3>Advance Search for Services</h3>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-4 m--margin-bottom-10">--}}
{{--                                <div class="m-form__group m-form__group--inline">--}}
{{--                                    <div class="m-form__label">--}}
{{--                                        <label>--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                    <div class="m-form__control">--}}
{{--                                        <input type="text" class="form-control m-bootstrap-select" name="titleEn" placeholder="Name">--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}


{{--                            <div class="col-md-4">--}}
{{--                                <div class="m-form__group m-form__group--inline">--}}
{{--                                    <div class="m-form__label">--}}
{{--                                        <label class="m-label m-label--single" for="show-user-gender">--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                    <div class="m-form__control">--}}
{{--                                        <select class="form-control" id="show-email-status" name="discountStatus">--}}
{{--                                            <option value="">Has Offer</option>--}}
{{--                                            <option value="1">Yes</option>--}}
{{--                                            <option value="0">No</option>--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            --}}{{--Active status--}}
{{--                            <div class="col-md-4">--}}
{{--                                <div class="m-form__group m-form__group--inline">--}}
{{--                                    <div class="m-form__label">--}}
{{--                                        <label class="m-label m-label--single" for="show-user-gender">--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                    <div class="m-form__control">--}}
{{--                                        <select class="form-control" id="show-active-status" name="activeStatus">--}}
{{--                                            <option value="">Active Status</option>--}}
{{--                                            <option value="1">Is Active</option>--}}
{{--                                            <option value="0">Not Active</option>--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-12 mt-3 text-right">--}}
{{--                                <button type="submit" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">Submit</button>--}}
{{--                                <button id="store-reset" class="btn btn-success m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">Reset</button>--}}
{{--                            </div>--}}
{{--                        </form>--}}
{{--                    </div>--}}

{{--                </div>--}}
{{--            </div>--}}
            <!--end: Search Form -->
            <!--begin: Datatable -->
            <div class="manage-users" id="manage-services"></div>
            <!--end: Datatable -->
        </div>
    </div>

@endsection




