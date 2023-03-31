@component('mail::message')
    # Congratulations, {{ $mailData['company_name'] }}!
    Hello {{ $mailData['name'] }},
    Good news! You were hired by {{ $mailData['company_name'] }}.
    Thanks,
    {{ config('app.name') }}
@endcomponent