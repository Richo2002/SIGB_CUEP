@component('mail::message')

{{ $message }}

Cordialement, {{ config('app.name') }}
@endcomponent
