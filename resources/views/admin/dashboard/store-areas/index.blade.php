@extends('admin.layouts.app')

@push('stylesheet-page-level')
@endpush

@push('script-page-level')
    <script>
        var storeId = '{{$storeId}}'
    </script>
<script src="{{asset('assets/admin/js/adv_datatables/csrf_token.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/js/adv_datatables/store-areas.js')}}" type="text/javascript"></script>
@endpush

@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                      Store Areas
                        <small>
                            Here you can edit or delete Store Areas
                        </small>
                    </h3>
                </div>
            </div>
           <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <div class="m-dropdown m-dropdown&#45;&#45;inline m-dropdown&#45;&#45;arrow m-dropdown&#45;&#45;align-right m-dropdown&#45;&#45;align-push" data-dropdown-toggle="hover" aria-expanded="true">
                            <a href="{!! route('admin.dashboard.stores.areas.create', ['store' => $storeId]) !!}" class="btn btn-accent m-btn m-btn&#45;&#45;custom m-btn&#45;&#45;icon m-btn&#45;&#45;air m-btn&#45;&#45;pill">
                                <span>
                                    <i class="la la-plus"></i>
                                    <span>
                                        Add Store Area
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
            <div class="manage-settings" id="manage-store-areas"></div>
            <!--end: Datatable -->
        </div>
    </div>

@endsection




