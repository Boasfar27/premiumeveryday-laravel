<!DOCTYPE html>
<html>
<head>
    <title>Verifikasi Email Premium Everyday</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .container {
            background-color: #f8f9fa;
            border-radius: 5px;
            padding: 20px;
            margin-top: 20px;
        }
        .code {
            background-color: #fff;
            padding: 15px;
            border-radius: 5px;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            letter-spacing: 5px;
            margin: 20px 0;
            color: #ec4899;
            border: 2px solid #ec4899;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #666;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Verifikasi Email Premium Everyday</h2>
        <p>Halo!</p>
        <p>Terima kasih telah mendaftar di Premium Everyday. Untuk menyelesaikan pendaftaran, silakan masukkan kode verifikasi berikut:</p>
        
        <div class="code">{{ $code }}</div>
        
        <p>Kode ini akan kadaluarsa dalam 60 menit.</p>
        <p>Jika Anda tidak merasa mendaftar di Premium Everyday, Anda dapat mengabaikan email ini.</p>
        
        <div class="footer">
            <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
            <p>&copy; {{ date('Y') }} Premium Everyday. All rights reserved.</p>
        </div>
    </div>
</body>
</html> 