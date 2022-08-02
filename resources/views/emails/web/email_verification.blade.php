@extends('emails.web.layouts.app')

@section('content')
<table border='0' cellpadding='0' cellspacing='0' style="width: 100%;">
    <tr>
        <td style="width: 100%; padding:0 50px 28px;background: #fff; box-sizing: border-box;">
            <div style="text-align: center;margin-bottom: 40px;">
                <a href="{!! url('/') !!}"><img  style="height: 90px " src=" {!! url('/') !!} " border="0" alt=""></a>
            </div>
            <span style="font-size: 22px;margin-bottom: 15px; display: block; color: #7d7d7d;">Hi {!! $receiverName !!},</span>
            <span style="color: #7d7d7d; font-size: 20px; display: block;">Email verification</span>
            <p style="font-size: 12px;line-height: 2; color: #7d7d7d;">Thank you for registering with us.</p>
            <p style="font-size: 12px;line-height: 2; color: #7d7d7d;">To activate your <a href="{!! url('/') !!}" style="color:#20658E !important;text-decoration:none;font-weight:bold;">{!! config('project_settings.project_name') !!}</a> account please use <b style="color:#20658E !important;font-weight:bold;">{!! $code !!}</b> as your email verification code.</p>
{{--            <p style="font-size: 12px;line-height: 2; color: #7d7d7d;">If you did not request a password reset, no further action is required.</p>--}}
            {{--<span style="color: #7d7d7d; font-size: 18px; display: block;padding:15px 0 5px;">Dr. Sawsan</span>--}}
        </td>
    </tr>
</table>
@endsection
