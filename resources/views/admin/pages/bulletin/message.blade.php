@component('mail::message')
# Merhaba {{ $email }},

{{ $message }}

@component('vendor.mail.html.footer')
<h5>{{ env('APP_NAME') }} ekibi</h5>
@endcomponent
@endcomponent
