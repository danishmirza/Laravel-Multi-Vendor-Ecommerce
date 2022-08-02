@extends('admin.layouts.app')


@push('stylesheet-page-level')
@endpush



@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Notifications
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push"
                             data-dropdown-toggle="hover" aria-expanded="true">
                            <a href="{!! route('admin.dashboard.notifications.deleteAll') !!}"
                               class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                                <span>
                                    <i class="la la-plus"></i>
                                    <span>
                                        Delete All Notifications
                                    </span>
                                </span>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="m-section">
                <div class="m-section__content">
                    @if(count($notifications) > 0)
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>
                                Title
                            </th>
                            <th>
                                Detail
                            </th>
                            <th>
                                Action
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($notifications as $key =>$notification)
{{--                            @php dd($notification->data) @endphp--}}
                        <tr>
                            <td>
                                {{$notification->data['title']}}
                            </td>
                            <td>
                                {{$notification->data['detail']}}
                            </td>
                            <td>
                               <a target="__blank" href="{{route('admin.dashboard.stores.ads.show', ['store' => $notification->data['storeId'], 'ad' => $notification->data['adId']])}}" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="fa fa-fw fa-eye"></i></a>
                               <a href="{{route('admin.dashboard.notifications.deleteOne', ['id' => $notification->id])}}" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill delete-record-button" title="Edit"><i class="fa fa-fw fa-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                        @else
                        @endif
                </div>
            </div>
        </div>
    </div>
@endsection

