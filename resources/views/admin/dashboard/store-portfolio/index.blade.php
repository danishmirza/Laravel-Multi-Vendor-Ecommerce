@extends('admin.layouts.app')


@push('script-page-level')
    <script>
        $(document).ready(function () {
            // $('#car-image-input').hide();
            $('#add-car-image').on('click', function () {
                $('#car-image-input').click();
            });
        });
        $(document).on('change', '#car-image-input', function () {
            $('#car-images-form').submit();
        });

        $('.delete-record-button').on('click', function(e){
            var url = $(this).data('url');
            swal({
                    title: "Are you sure to delete this?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Delete",
                    cancelButtonText: "No",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm){
                    if (isConfirm) {
                        $.ajax({
                            type: 'delete',
                            url: url,
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': window.Laravel.csrfToken
                            }
                        })
                            .done(function(res){
                                if(res.success){
                                    toastr.success(res.message); location.reload();
                                }else{
                                    toastr.error(res.message);
                                }
                            })
                            .fail(function(res){  toastr.error(res.message);  });
                    } else {
                        swal("Cancelled", "Your imaginary file is safe", "error");
                    }
                });
        });
    </script>
@endpush

@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Store Portfolio Images
                        <small>
                            Here You Can Add or Delete Store Portfolio Images
                        </small>
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <form action="{!! route('admin.dashboard.stores.portfolio.store', ['store' => $storeId]) !!}" method="POST" enctype="multipart/form-data" id="car-images-form">
                            {!! csrf_field() !!}
                            <input type="file" name="images[]" id="car-image-input" multiple>
                            <div class="dimention-img">
                                <p  style="color: #969393;     margin-left: -103px; display: inline-block;  margin-top: 5px; font-size: 11px;">Image Size (W x H) = 478.75 x 464.25</p>
                            </div>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="container">
                <div class="row">
                    @forelse($images as $key=>$car)
                        <div class="col-sm-4 card">
                            <a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-record-button"
                               href="javascript:{};" data-url="{!! route('admin.dashboard.stores.portfolio.destroy', ['store' => $car->store_id, 'portfolio' => $car->id]) !!}"><i class="fa fa-trash"></i></a>
                            <img src="{!! imageUrl(asset($car->image), 200, 200) !!}" alt="">
                        </div>
                    @empty
                        No Record Found
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection

