<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Pesan Kontak Baru</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 20px;
        }

        .header {
            background-color: #e83e8c;
            color: white;
            padding: 15px;
            text-align: center;
        }

        .content {
            padding: 20px;
        }

        .footer {
            background-color: #f5f5f5;
            padding: 15px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }

        h1 {
            margin: 0;
            font-size: 24px;
        }

        .message-box {
            background-color: #f9f9f9;
            border-left: 4px solid #e83e8c;
            padding: 15px;
            margin: 15px 0;
        }

        .contact-info {
            margin-bottom: 20px;
        }

        .contact-info p {
            margin: 5px 0;
        }

        .message-content {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-top: 15px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Pesan Kontak Baru</h1>
        </div>

        <div class="content">
            <p>Anda telah menerima pesan baru dari formulir kontak website Premium Everyday.</p>

            <div class="contact-info">
                <p><strong>Nama:</strong> {{ $name }}</p>
                <p><strong>Email:</strong> {{ $email }}</p>
                <p><strong>Subjek:</strong> {{ $subject }}</p>
            </div>

            <h3>Isi Pesan:</h3>
            <div class="message-content">
                <p><strong>Pesan:</strong></p>
                <div class="message-box">
                    <p>{{ $message }}</p>
                </div>
            </div>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Premium Everyday. Semua Hak Dilindungi.</p>
        </div>
    </div>
</body>

</html>
