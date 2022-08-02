<form action="{{$action}}" method="POST" class="m-form m-form--fit m-form--label-align-right">
    {{csrf_field()}}
<div class="m-portlet__body">
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Select City
            <span class="text-danger">*</span>
        </label>
        <div class="col-9">
            <select name="city_id" id="" class="form-control" required>
                <option value="">Select</option>
                @forelse($cities as $city)
                    <option value="{{$city->id}}" {{(old('city_id', $store->city_id) == $city->id) ? 'selected': ''}}>{{$city->title['en']}}</option>
                @empty
                @endforelse
            </select>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Store Name In English
            <span class="text-danger">*</span>
        </label>
        <div class="col-9">
            <input type="text" name="store_name[en]" value="{{old('store_name.en', $store->store_name["en"])}}" class="form-control" placeholder="Name" required />
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Store Name In Arabic
            <span class="text-danger">*</span>
        </label>
        <div class="col-9">
            <input type="text" name="store_name[ar]" value="{{old('store_name.ar', $store->store_name["ar"])}}" class="form-control" placeholder="Name" required />
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Phone
            <span class="text-danger">*</span>
        </label>
        <div class="col-9">
            <input type="tel" name="phone" value="{{old('phone',$store->phone)}}"
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
            <input type="email" name="email" value="{{old('email',$store->email)}}"
                   class="form-control  f-input-cls dir rt-phone"
                   placeholder="e.g johndoe@example.com" required autocomplete="off"  />
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Is Active
            <span class="text-danger"></span>
        </label>
        <div class="col-9 d-flex">
            <label class="check text-capitalize black gothic-normel option-g mr-3 mb-0 p-c d-flex align-items-center">
                <input type="radio" {!! (old('is_active',$store->is_active) == '1')?'checked':'' !!} name="is_active" checked value="1">
                <span class="log checkmark ml-1"></span>Yes
            </label>
            <label class="check mr-3 text-capitalize black gothic-normel option-g mb-0 p-c d-flex align-items-center">
                <input type="radio" {!! (old('is_active',$store->is_active) == '0')?'checked':'' !!} name="is_active"  value="0">
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
                <input type="radio" {!! (old('email_verified',$store->email_verified) == '1')?'checked':'' !!} name="email_verified" checked value="1">
                <span class="log checkmark ml-1"></span>Yes
            </label>
            <label class="check mr-3 text-capitalize black gothic-normel option-g mb-0 p-c d-flex align-items-center">
                <input type="radio" {!! (old('email_verified',$store->email_verified) == '0')?'checked':'' !!} name="email_verified"  value="0">
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
            <input type="password" name="password"  class="form-control" placeholder="Password" {{($storeId == 0) ? 'required': ''}}>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Confirm Password
            <span class="text-danger">*</span>
        </label>
        <div class="col-9">
            <input type="password" name="password_confirmation"  class="form-control" placeholder="Password Confirmation" {{($storeId == 0) ? 'required': ''}}>
        </div>
    </div>
    @include('admin.common.upload-image',[
    'imagePath' => 'stores',
    'image_name'=> 'image',
    'current_image' =>old('image', $store->image),
    'title'=>'Display picture',
    'image_size'=>'','image_number'=>1
    ])
    @include('admin.common.upload-image',[
    'imagePath' => 'trade-license',
    'image_name'=> 'trade_license',
    'current_image' =>old('trade_license', $store->trade_license),
    'title'=>'Trade License',
    'image_size'=>'',
    'image_number'=>2
    ])
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Trade License Verified
            <span class="text-danger"></span>
        </label>
        <div class="col-9 d-flex">
            <label class="check text-capitalize black gothic-normel option-g mr-3 mb-0 p-c d-flex align-items-center">
                <input type="radio" {!! (old('trade_license_verified',$store->trade_license_verified) == '1')?'checked':'' !!} name="trade_license_verified" checked value="1">
                <span class="log checkmark ml-1"></span>Yes
            </label>
            <label class="check mr-3 text-capitalize black gothic-normel option-g mb-0 p-c d-flex align-items-center">
                <input type="radio" {!! (old('trade_license_verified',$store->trade_license_verified) == '0')?'checked':'' !!} name="trade_license_verified"  value="0">
                <span class="log checkmark ml-1"></span>No
            </label>
        </div>
    </div>


    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Address
            <span class="text-danger">*</span>
        </label>
        <div class="col-9">
            <input type="text" name="address" value="{{old('address', $store->address)}}" class="form-control" placeholder="Address" required id="searchmap">
            <input type="hidden" name="longitude" value="{{old('longitude', $store->longitude)}}" class="form-control" id="longitude">
            <input type="hidden" name="latitude" value="{{old('latitude', $store->latitude)}}" class="form-control" id="latitude">
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

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Detail In English
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            <textarea name="detail[en]" id="" cols="30" rows="10" class="form-control">{{old('detail.en',$store->detail['en'])}}</textarea>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Detail In English
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            <textarea name="detail[ar]" id="" cols="30" rows="10" class="form-control">{{old('detail.ar',$store->detail['ar'])}}</textarea>
        </div>
    </div>

</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions">
        <div class="row">
            <input type="hidden" value="PUT" name="_method">
            <input type="hidden" value="{{$storeId}}" name="user_id">
            <div class="col-4"></div>
            <div class="col-7 mb-3 mt-3">
                @if($store->id > 0)
                    <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom mx-4">
                        Update Supplier
                    </button>
                @else
                    <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom mx-4">
                        Add Supplier
                    </button>
                @endif
                <a href="{!! route('admin.dashboard.stores.index') !!}" class="btn btn-secondary m-btn m-btn--air m-btn--custom">{!! __('Cancel') !!}</a>

            </div>
        </div>
    </div>
</div>
</form>



