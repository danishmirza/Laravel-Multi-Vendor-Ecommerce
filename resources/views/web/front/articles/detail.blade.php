@extends('web.layouts.app')

@section('content')

    <section class="section blog-section pd-tb100">
        <div class="container">
            <div class="blog-content-wrap">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <figure class="mt-thumb">
                            <img src="{{imageUrl($article->image, 630,402,95,2)}}" alt="">
                        </figure>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="text-wrap">
                            <h4 class="sub-title">
                                <a >{{$article->title[app()->getLocale()]}}
                                </a>
                                <span class="primary-color author-name">By: {{$article->author[app()->getLocale()]}}</span>
                            </h4>
                            <ul class="listed d-flex justify-content-end">
                                <li>
                                    <i class="fas fa-calendar-alt"></i>
                                    {{\Carbon\Carbon::parse($article->updatedAt)->format('M d, Y')}}
                                </li>
                            </ul>
                            {!! $article->content[app()->getLocale()] !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </section>
@endsection
