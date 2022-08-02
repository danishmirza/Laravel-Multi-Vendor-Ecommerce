@extends('admin.layouts.app')

@push('stylesheet-page-level')
@endpush

@section('content')

    <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
            <div class="m-portlet m-portlet--full-height m-portlet--tabs  ">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-tools">
                        <ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--primary" role="tablist">
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_user_profile_tab_1" role="tab">
                                    <i class="flaticon-share m--hide"></i>
                                    Edit Profile
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="tab-content">
                    <div class="tab-pane active" id="m_user_profile_tab_1">
                        <form action="{{route('admin.dashboard.update-profile')}}" method="POST" class="m-form m-form--fit m-form--label-align-right" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group row">
                                <label for="example-text-input" class="col-3 col-form-label">
                                    {!! __('Full Name') !!}
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-7">
                                    <input type="text" name="name" value="{{old('name',$admin['name'])}}" class="form-control" id="full_name" placeholder="{{__('Full Name')}}" required>
                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                                <label for="example-text-input" class="col-3 col-form-label">
                                    {!! __('Email') !!}
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-7">
                                    <input type="text" name="email" value="{{old('email',$admin['email'])}}" class="form-control" id="email" placeholder="{{__('Email')}}" required readonly>
                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                                <label for="example-text-input" class="col-3 col-form-label">
                                    {!! __('Password') !!}
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-7">
                                    <input type="password" name="password" class="form-control" id="password" placeholder="{{__('Password')}}">
                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                                <label for="example-text-input" class="col-3 col-form-label">
                                    {!! __('Confirm Password') !!}
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-7">
                                    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="{{__('Password Confirmation')}}">
                                </div>
                            </div>
                            <div class="form-group m-form__group row" style="display: none">
                                <label for="example-text-input" class="col-3 col-form-label">
                                    {!! __('Change Position') !!}
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-7">
                                    <div id="map{!! $languageId !!}" style="height:500px; width:auto;margin-top: 48px"></div>
                                </div>
                            </div>

                            @include('admin.common.upload-image',[
                            'imagePath'=>'admin',
                            'image_name'=> 'imageUrl',
                            'current_image' =>old('imageUrl', $admin['image']),
                            'title'=>'Profile Image',
                            'image_size'=>'Recommended size 150 x 150',
                            'image_number'=>1
                            ])
                        </div>


                        <div class="m-portlet__foot m-portlet__foot--fit">
                            <div class="m-form__actions">
                                <div class="row">
                                    <input type="hidden" value="PUT" name="_method">
                                    <input type="hidden" value="{{$admin['id']}}" name="id">
                                    <div class="col-4"></div>
                                    <div class="col-7">
                                        <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">
                                            Save changes
                                        </button>
                                        &nbsp;&nbsp;
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
