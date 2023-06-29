@component('mail::message')

{{ $message }}

Cordialement,<br>
{{ config('app.name') }}
@endcomponent
