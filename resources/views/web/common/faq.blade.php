<div class="card">
    <div class="card-header" id="heading{{$loop->iteration}}">
        <button class="btn btn-link" data-toggle="collapse" data-target="#collapse{{$loop->iteration}}" aria-expanded="{{($loop->first == true)}}"
                aria-controls="collapse{{$loop->iteration}}">
                                  <span class="faq-title">
                                    {{$faq->question[app()->getLocale()]}}
                                  </span>
            <i class="fas fa-{{$loop->first ? 'minus': 'plus'}} ml-auto"></i>
        </button>
    </div>
    <div id="collapse{{$loop->iteration}}" class="collapse {{$loop->first ? 'show': ''}}" aria-labelledby="heading{{$loop->iteration}}" data-parent="#accordion">
        <div class="card-body">
            {!! $faq->answer[app()->getLocale()] !!}
        </div>
    </div>
</div>