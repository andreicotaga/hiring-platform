@component('mail::message')
    # You were contacted by {{ $mailData['company_name'] }}!
    Hello {{ $mailData['name'] }},
    Good news! {{ $mailData['company_name'] }} is interested in your profile.
    Thanks,
    {{ config('app.name') }}
@endcomponent