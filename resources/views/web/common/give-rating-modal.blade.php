<!-- Modal Box Start-->
<div class="modal fade mt-modal-wrap" id="add-review" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form class="modal-content" method="post" action="{{route($route)}}" id="add-review-form" >
            @csrf
            <div class="modal-header">
                <input type="hidden" name="review_id" value="{{$reviewId}}">
                <h5 class="modal-title" id="exampleModalLongTitle">Rate {{$title}}</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="rating-add-mt d-flex mb-1">
                    <fieldset class="rating float-left">
                        <input type="radio"  name="rating" value="5" required data-parsley-errors-container="#rating-errors"><label class="full xyz m-0" for="star5" title="Awesome - 5 stars"></label>
                        <input type="radio"  name="rating" value="4.5" ><label class="half xyz m-0" for="star4half" title="Pretty good - 4.5 stars"></label>
                        <input type="radio"  name="rating" value="4" ><label class="full xyz m-0" for="star4" title="Pretty good - 4 stars"></label>
                        <input type="radio"  name="rating" value="3.5" ><label class="half xyz m-0" for="star3half" title="Meh - 3.5 stars"></label>
                        <input type="radio"  name="rating" value="3" ><label class="full xyz m-0" for="star3" title="Meh - 3 stars"></label>
                        <input type="radio"  name="rating" value="2.5" ><label class="half xyz m-0" for="star2half" title="Kinda bad - 2.5 stars"></label>
                        <input type="radio"  name="rating" value="2" ><label class="full xyz m-0" for="star2" title="Kinda bad - 2 stars"></label>
                        <input type="radio"  name="rating" value="1.5" ><label class="half xyz m-0" for="star1half" title="Meh - 1.5 stars"></label>
                        <input type="radio"  name="rating" value="1" ><label class="full xyz m-0" for="star1" title="Sucks big time - 1 star"></label>
                        <input type="radio"  name="rating" value="0.5" ><label class="half xyz m-0" for="starhalf" title="Sucks big time - 0.5 stars"></label>
                    </fieldset>
{{--                    <input name="rating" id="rating" required>--}}
                    <!-- <span class="rating-count">4.5</span> -->
                </div>
                <div id="rating-errors"></div>
                <div class="input-style">
                    <label class="d-block">Comment
                    </label>
                    <textarea class="ctm-textarea" placeholder="Write Here..." name="comment" required></textarea>
                </div>
            </div>
            <div class="modal-footer modal-btn-wrap">
                <button class="btn-style w-100" type="submit">Add</button>
            </div>
        </form>
    </div>
</div><!-- Modal Box End-->

@push('script-end')
    <script src="{{asset('assets/web/js/parsley.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('#add-review-form').parsley();
            $("body").on("click", ".xyz", function () {
                $(this).prev().prop("checked", true);
                // $('#rating').prop('value', $(this)
                //     .prev()
                //     .val()
                // )
                $(this).prev().parsley().validate();
            });
        });
    </script>
@endpush

