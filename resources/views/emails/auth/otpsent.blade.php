<x-mail::message>

@if ($type == "register")
    # Welcome to Shramik, Verify your mail
@elseif ($type == "reset")
    # Forgotting is the power of human brain, reset your password.
@endif

Verfication code for email {{$otp['email']}}
@component('mail::panel')
    {{$otp['code']}}
@endcomponent

<x-mail::button :url="'app.client_url'">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
