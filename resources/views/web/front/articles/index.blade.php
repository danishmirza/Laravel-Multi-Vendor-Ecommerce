@extends('web.layouts.app')

@section('content')
    <section class="section blog-section pd-tb100">
        <div class="container">
            <div class="row">
                @forelse($articles as $article)
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <!--Blog Item Start-->
                    <div class="blog-item">
                        <figure class="mt-thumb">
                            <img src="{{imageUrl($article->image, 370,236,95,2)}}" alt="">
                        </figure>
                        <div class="text-wrap">
                            <h5 class="sub-title">
                                <a href="{{route('web.front.article.detail', ['article' => $article->id])}}">
                                    {{$article->title[app()->getLocale()]}}
                                </a>
                            </h5>
                            <ul class="listed d-flex justify-content-end">
                                <li>
                                    <i class="fas fa-calendar-alt"></i>
                                    {{\Carbon\Carbon::parse($article->updatedAt)->format('M d, Y')}}
                                </li>
                            </ul>
                        </div>
                    </div><!--Blog Item Start-->
                </div>
                @empty
                    @include('web.common.alerts', ['message' => 'No Blogs found'])
                @endforelse

                    {!! $articles->onEachSide(0)->links() !!}
            </div>

        </div>
    </section>

@endsection
