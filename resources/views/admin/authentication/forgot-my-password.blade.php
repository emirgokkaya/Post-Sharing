@component('mail::message')
# Merhaba {{ $user->name }},

Hesabınızın şifresini değiştirmek için aşağıdaki bağlantıya tıklayın.

@component('mail::button', ['url' => route('forgot_password_get', ['email' => $user->email, 'email_token' => $user->email_token])])
Şifre Değiştir
@endcomponent

@endcomponent
