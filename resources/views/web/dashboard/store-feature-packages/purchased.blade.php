@extends('web.dashboard.layouts.dashboard')

@section('content-dashboard')
    @include('web.common.alerts')
    @extends('web.dashboard.layouts.dashboard')

@section('content-dashboard')
    @include('web.common.alerts')
    <div class="tab-content profile-tabs-content">
        <div class="tab-pane-wrap">
            <!--Profile Sub Tab Start-->
            <div class="profile-sub-tab package-tabs-outer">
                <ul class="nav nav-pills mb-3 profile-tabs profile-tabs-sub justify-content-center" id="sub-tab"
                    role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" href="{{route('web.dashboard.feature-packages.index')}}">All Packages</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" >Purchased Packages</a>
                    </li>
                </ul>
                <div class="tab-content profile-tabs-content">
                    <div class="tab-pane fade show active">
                        <div class="user-profile subscription-wrap">
                            <div class="row">
                                @forelse($packages as $package)
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <!--Subcription Item Start-->
                                    @include('web.dashboard.common.package', ['package' => $package])
                                    <!--Subcription Item End-->
                                    </div>
                                @empty
                                    <div class="col-12">
                                    @include('web.common.not-found', ['message' => 'You have not purchased any package.'])
                                    </div>
                                @endforelse
                                {!! $packages->render() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@endsection