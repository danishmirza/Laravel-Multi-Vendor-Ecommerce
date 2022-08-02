@extends('web.layouts.app')

@section('content')
    <section class="section categories-section pd-tb100">
        <div class="container">
            <div class="row">
                @forelse($categories as $category)
                <div class="col-lg-3 col-md-4">
                    <a href="{{route('web.front.category.subcategories', ['category'=> $category->id])}}">
                        <figure class="category-item">
                            <img src="{{imageUrl($category->image, 300,350,95,2)}}" alt="">
                            <figcaption class="caption">
                                <h2 class="title">{{$category->title[app()->getLocale()]}}</h2>
                            </figcaption>
                        </figure>
                    </a>
                </div>
                @empty
                    <div class="col-12">
                        @include('web.common.not-found', ['message' => 'No categories found'])
                    </div>
                @endforelse
                {!! $categories->onEachSide(0)->links() !!}
            </div>
        </div>
    </section>

@endsection
