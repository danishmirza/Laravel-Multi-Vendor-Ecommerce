<li class="rating-item">
    <div class="content-top d-flex justify-content-between align-items-end">
        <div class="img-txt d-flex align-items-center review-thumb">
            <figure class="thumb">
                <img src="{{imageUrl($review->user->image, 57,57,95,2)}}" alt="">
            </figure>

            <div class="text-holder">
                <h5 class="d-flex">
                    {{$review->user->name}}
                    <span class="rating-time ml-auto content-righ">{{elaspedTime($review->updated_at)}} ago</span>
                </h5>
                @include('web.common.rating', ['rating' => $review->rating])
            </div>
        </div>
    </div>
    <div class="content-bottom d-flex">
        <p>{{$review->comment}}
        </p>
    </div>
</li>