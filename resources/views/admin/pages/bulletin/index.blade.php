@component('mail::message')
# Merhaba {{ $email }},

Mail adresiniz bültenimize kaydedilmiştir. <br>
Yeni gelişmelerden sizleri haberdar edeceğiz.

@component('vendor.mail.html.footer')
    <h5>{{ env('APP_NAME') }} ekibi</h5>
@endcomponent
@endcomponent
