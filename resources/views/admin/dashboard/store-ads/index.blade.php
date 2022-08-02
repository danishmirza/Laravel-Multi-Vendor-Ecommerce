@extends('admin.layouts.app')

@push('stylesheet-page-level')
@endpush

@push('script-page-level')
    <script>
        var storeId = '{{$storeId}}'
    </script>
<script src="{{asset('assets/admin/js/adv_datatables/csrf_token.js')}}" type="text/javascript"></script>
    @if($storeId > 0)
        <script src="{{asset('assets/admin/js/adv_datatables/store-ads.js')}}" type="text/javascript"></script>
    @else
        <script src="{{asset('assets/admin/js/adv_datatables/ads-all.js')}}" type="text/javascript"></script>
    @endif
@endpush

@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                      Store Ads
                        <small>
                            Here you can edit or delete Store Ads
                        </small>
                    </h3>
                </div>
            </div>

        </div>
        <div class="m-portlet__body">
            <!--begin: Datatable -->
            <div class="manage-settings" id="manage-store-ads"></div>
            <!--end: Datatable -->
        </div>
    </div>

@endsection




