@component('mail::message')
# Merhaba {{ $name }},

{{ env('APP_NAME') }} sitesinde kendi yazılarınızı paylaşmak için aşağıdaki linke tıklayarak hesabınızı aktifleştirin


- Blog paylaşımı
- Yorum yazmak
- Paylaşımları beğenmek

@component('mail::button', ['url' => route('activate_user', ['name' => $name, 'token' => $token])])
Hesabı Aktifleştir
@endcomponent

@endcomponent
