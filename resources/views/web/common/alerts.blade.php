
@if (count($errors->messages()) > 0)
    <div class="alert alert-danger alert-dismissable text-left alert-danger-admin">
        <ul>
            @foreach($errors->messages() as $key => $message)
                <li>{!! __($message[0]) !!}</li>
            @endforeach
        </ul>
    </div>
@endif
