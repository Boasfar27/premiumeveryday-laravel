<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f0f3f9;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 0;
        }

        .header {
            background-color: #f0f3f9;
            padding: 20px;
            text-align: center;
        }

        .content {
            background-color: white;
            padding: 40px 30px;
            border-radius: 5px;
        }

        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #666;
        }

        h1 {
            color: #e91e63;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .button {
            display: inline-block;
            background-color: #ff4081;
            color: white;
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
        }

        .link {
            word-break: break-all;
            color: #e91e63;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="content">
            <h1>Verifikasi email Anda</h1>

            <p>Halo {{ $user->name }},</p>

            <p>Klik tombol di bawah ini untuk memverifikasi email Anda.</p>

            <div style="text-align: center;">
                <a href="{{ route('verification.verify', ['code' => $user->verification_code]) }}"
                    class="button">Verifikasi Email</a>
            </div>

            <p>Link verifikasi ini akan kadaluarsa dalam 24 jam.</p>

            <p>Jika Anda tidak merasa mendaftar di Premium Everyday, Anda dapat mengabaikan email ini.</p>

            <p>Terima kasih,<br>
                Premium Everyday</p>

            <p style="font-size: 12px; margin-top: 30px;">
                Jika Anda mengalami masalah dengan tombol di atas, salin dan tempel URL berikut ke browser Anda:<br>
                <a href="{{ route('verification.verify', ['code' => $user->verification_code]) }}"
                    class="link">{{ route('verification.verify', ['code' => $user->verification_code]) }}</a>
            </p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} Premium Everyday. All rights reserved.
        </div>
    </div>
</body>

</html>
