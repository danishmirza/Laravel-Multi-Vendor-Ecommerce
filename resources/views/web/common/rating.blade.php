<div class="star-rating-area {{(isset($noExtraClasses)) ? '' : 'justify-content-flex-start'}}  mb-1">
    <div class="rating-static clearfix" rel="{{$rating}}">
        <label class="full" title="Awesome - 5 stars"></label>
        <label class="half" title="Pretty good - 4.5 stars"></label>
        <label class="full" title="Pretty good - 4 stars"></label>
        <label class="half" title="Meh - 3.5 stars"></label>
        <label class="full" title="Meh - 3 stars"></label>
        <label class="half" title="Kinda bad - 2.5 stars"></label>
        <label class="full" title="Kinda bad - 2 stars"></label>
        <label class="half" title="Meh - 1.5 stars"></label>
        <label class="full" title="Sucks big time - 1 star"></label>
        <label class="half" title="Sucks big time - 0.5 stars"></label>
    </div>
    <div class="ratilike ng-binding">{{$rating}}</div>
</div>