@extends('admin.layouts.app')

@push('stylesheet-page-level')
@endpush

@push('script-page-level')
    <script>
        var packageType = '{{$type}}'
    </script>
    <script src="{{asset('assets/admin/js/adv_datatables/csrf_token.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/admin/js/adv_datatables/packages.js')}}" type="text/javascript"></script>
@endpush

@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        {{ucfirst($type)}} Packages
                        <small>
                            Here you can add,edit or delete {{ucfirst($type)}} Packages
                        </small>
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" data-dropdown-toggle="hover" aria-expanded="true">
                            <a href="{!! route('admin.dashboard.packages.create', $type) !!}" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                                <span>
                                    <i class="la la-plus"></i>
                                    <span>
                                        {{ucfirst($type)}} Package
                                    </span>
                                </span>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="m-portlet__body">

            <!--begin: Datatable -->
            <div class="manage-subscription-packages" id="manage-packages"></div>
            <!--end: Datatable -->
        </div>
    </div>

@endsection




