<form action="{{$action}}" method="POST" class="m-form m-form--fit m-form--label-align-right">
    {{csrf_field()}}
<div class="m-portlet__body">
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Name
            <span class="text-danger">*</span>
        </label>
        <div class="col-9">
            <input type="text" name="name" value="{{old('name', $user->name)}}" class="form-control" placeholder="Name" required>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Phone
            <span class="text-danger">*</span>
        </label>
        <div class="col-9">
            <input type="tel" name="phone" value="{{old('phone',$user->phone)}}"
                   class="form-control  f-input-cls dir rt-phone" id="#"
                   placeholder="e.g ++97123456789" required autocomplete="off" maxlength="15" minlength="11">
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Email
            <span class="text-danger">*</span>
        </label>
        <div class="col-9">
            <input type="email" name="email" value="{{old('email',$user->email)}}"
                   class="form-control  f-input-cls dir rt-phone"
                   placeholder="e.g johndoe@example.com" required autocomplete="off"  >
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Is Active
            <span class="text-danger"></span>
        </label>
        <div class="col-9 d-flex">
            <label class="check text-capitalize black gothic-normel option-g mr-3 mb-0 p-c d-flex align-items-center">
                <input type="radio" {!! (old('is_active',$user->is_active) == '1')?'checked':'' !!} name="is_active" checked value="1">
                <span class="log checkmark ml-1"></span>Yes
            </label>
            <label class="check mr-3 text-capitalize black gothic-normel option-g mb-0 p-c d-flex align-items-center">
                <input type="radio" {!! (old('is_active',$user->is_active) == '0')?'checked':'' !!} name="is_active"  value="0">
                <span class="log checkmark ml-1"></span>No
            </label>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Is Verified
            <span class="text-danger"></span>
        </label>
        <div class="col-9 d-flex">
            <label class="check text-capitalize black gothic-normel option-g mr-3 mb-0 p-c d-flex align-items-center">
                <input type="radio" {!! (old('email_verified',$user->email_verified) == '1')?'checked':'' !!} name="email_verified" checked value="1">
                <span class="log checkmark ml-1"></span>Yes
            </label>
            <label class="check mr-3 text-capitalize black gothic-normel option-g mb-0 p-c d-flex align-items-center">
                <input type="radio" {!! (old('email_verified',$user->email_verified) == '0')?'checked':'' !!} name="email_verified"  value="0">
                <span class="log checkmark ml-1"></span>No
            </label>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Password
            <span class="text-danger">*</span>
        </label>
        <div class="col-9">
            <input type="password" name="password"  class="form-control" placeholder="Password" {{($userId == 0) ? 'required': ''}}>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Confirm Password
            <span class="text-danger">*</span>
        </label>
        <div class="col-9">
            <input type="password" name="password_confirmation"  class="form-control" placeholder="Password Confirmation" {{($userId == 0) ? 'required': ''}}>
        </div>
    </div>
    @include('admin.common.upload-image',[
    'imagePath' => 'users',
    'image_name'=> 'image',
    'current_image' =>old('image', $user->image),
    'title'=>'Display picture',
    'image_size'=>'',
    'image_number'=>1
    ])



    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Address
            <span class="text-danger">*</span>
        </label>
        <div class="col-9">
            <input type="text" name="address" value="{{old('address', $user->address)}}" class="form-control" placeholder="Address" required id="searchmap">
            <input type="hidden" name="longitude" value="{{old('longitude', $user->longitude)}}" class="form-control" id="longitude">
            <input type="hidden" name="latitude" value="{{old('latitude', $user->latitude)}}" class="form-control" id="latitude">
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Change Position
            <span class="text-danger"></span>
        </label>
        <div class="col-9">
            <div id="map" style="height:400px; width:100%;margin-top: 48px"></div>
        </div>
    </div>

</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions">
        <div class="row">
            <input type="hidden" value="PUT" name="_method">
            <input type="hidden" value="{{$userId}}" name="user_id">
            <div class="col-4"></div>
            <div class="col-7 mb-3 mt-3">
                @if($user->id > 0)
                    <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom mx-4">
                        Update User
                    </button>
                @else
                    <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom mx-4">
                        Add User
                    </button>
                @endif
                <a href="{!! route('admin.dashboard.users.index') !!}" class="btn btn-secondary m-btn m-btn--air m-btn--custom">{!! __('Cancel') !!}</a>

            </div>
        </div>
    </div>
</div>
</form>



