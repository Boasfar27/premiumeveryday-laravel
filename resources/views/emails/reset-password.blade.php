<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
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
        <div class="header">
            <h2>Premium Everyday</h2>
        </div>

        <div class="content">
            <h1>Reset Password Anda</h1>

            <p>Halo,</p>

            <p>Kami menerima permintaan untuk reset password Anda. Klik tombol di bawah ini untuk melanjutkan:</p>

            <div style="text-align: center;">
                <a href="{{ url('reset-password', $token) }}" class="button">Reset Password</a>
            </div>

            <p>Link reset password ini akan kadaluarsa dalam 60 menit.</p>

            <p>Jika Anda tidak meminta reset password, Anda dapat mengabaikan email ini.</p>

            <p>Terima kasih,<br>
                Premium Everyday</p>

            <p style="font-size: 12px; margin-top: 30px;">
                Jika Anda mengalami masalah dengan tombol di atas, salin dan tempel URL berikut ke browser Anda:<br>
                <a href="{{ url('reset-password', $token) }}" class="link">{{ url('reset-password', $token) }}</a>
            </p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} Premium Everyday. All rights reserved.
        </div>
    </div>
</body>

</html>
