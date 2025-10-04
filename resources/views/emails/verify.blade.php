@component('mail::message')
# Hello {{ $user->name }},

Thanks for registering! Please verify your email to activate your account.

@component('mail::button', ['url' => $verifyUrl])
Verify Email
@endcomponent

This link will expire in 60 minutes.

Thanks,  
{{ config('app.name') }}
@endcomponent
