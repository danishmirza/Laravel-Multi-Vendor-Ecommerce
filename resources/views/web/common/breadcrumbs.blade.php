@unless ($breadcrumbs->isEmpty())
<section class="inner-banner-section" style="background: url('{{asset('assets/web/seeders/breadcrumb/breadcrumb.jpg')}}')">
    <div class="container">
        <div class="inner-banner-content">
            <h2 class="title">{{$breadcrumbs->last()->title}}</h2>
            <ul class="breadcrumb">
                @foreach ($breadcrumbs as $breadcrumb)
                    @if (!is_null($breadcrumb->url) && !$loop->last)
                        <li class="breadcrumb-item"> <a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
                    @else
                        <li class="breadcrumb-item active">
                            {{ $breadcrumb->title }}
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</section>
@endunless
