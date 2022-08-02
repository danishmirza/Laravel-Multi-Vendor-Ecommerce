@extends('web.layouts.app')

@section('content')
    <section class="section about-section pd-tb100">
        <div class="container">
            @forelse($pages as $page)
                @if($page->slug == config('project_settings.about_us_slug'))
            <div class="content-box mb-5">
                <h2 class="main-title text-center mb-2">{{$page->name[app()->getLocale()]}}</h2>
                {!! $page->content[app()->getLocale()] !!}
            </div>
                @else
                    <div class="row about-content">
                        <div class="col-lg-12">
                        <h2 class="main-title text-center mb-3">{{$page->name[app()->getLocale()]}}</h2>
                        </div>
                        {!! $page->content[app()->getLocale()] !!}
                    </div>
                @endif
            @empty
            @endforelse

        </div>
    </section>

@endsection
