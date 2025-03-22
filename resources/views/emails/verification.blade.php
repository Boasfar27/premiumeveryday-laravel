@component('mail::message')
    <div style="text-align: center; margin-bottom: 30px;">
        <img src="{{ asset('images/logo.webp') }}" alt="{{ config('app.name') }}" style="max-width: 200px; height: auto;">
    </div>

    # Verifikasi Email Anda

    Halo {{ $user->name }},

    Terima kasih telah mendaftar di Premium Everyday. Untuk melanjutkan, silakan verifikasi email Anda dengan mengklik
    tombol di bawah ini:

    @component('mail::button', ['url' => route('verification.verify', ['code' => $user->verification_code])])
        Verifikasi Email
    @endcomponent

    Link verifikasi ini akan kadaluarsa dalam 24 jam.

    Jika Anda tidak merasa mendaftar di Premium Everyday, Anda dapat mengabaikan email ini.

    Terima kasih,<br>
    {{ config('app.name') }}

    <small>Jika Anda mengalami masalah dengan tombol di atas, salin dan tempel URL berikut ke browser Anda:<br>
        {{ route('verification.verify', ['code' => $user->verification_code]) }}</small>
@endcomponent
