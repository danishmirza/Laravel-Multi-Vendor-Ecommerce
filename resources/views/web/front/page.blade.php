@extends('web.layouts.app')

@section('content')

    <section class="section pd-tb100">
        <div class="container">
            <div class="content-box">
                <h2 class="main-title text-center mb-2">{{$page->name[app()->getLocale()]}}</h2>
                {!! $page->content[app()->getLocale()] !!}
            </div>
        </div>
    </section>
@endsection
