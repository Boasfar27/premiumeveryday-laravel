<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Verifikasi Email - Premium Everyday</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            padding: 20px;
            background: linear-gradient(135deg, #B03052 0%, #D76C82 100%);
            color: white;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #fff;
            padding: 30px;
            border-radius: 0 0 10px 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .verification-code {
            text-align: center;
            font-size: 32px;
            letter-spacing: 5px;
            color: #B03052;
            margin: 20px 0;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Premium Everyday</h1>
        <p>Verifikasi Email Anda</p>
    </div>

    <div class="content">
        <p>Halo {{ $user->name }},</p>

        <p>Terima kasih telah mendaftar di Premium Everyday. Untuk melanjutkan, silakan masukkan kode verifikasi berikut:</p>

        <div class="verification-code">
            {{ $user->verification_code }}
        </div>

        <p>Kode verifikasi ini akan kadaluarsa dalam 24 jam. Jika Anda tidak melakukan pendaftaran di Premium Everyday, Anda dapat mengabaikan email ini.</p>

        <p>Salam,<br>Tim Premium Everyday</p>
    </div>

    <div class="footer">
        <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
        <p>&copy; {{ date('Y') }} Premium Everyday. All rights reserved.</p>
    </div>
</body>
</html> 