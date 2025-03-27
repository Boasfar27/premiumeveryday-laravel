<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang di Premium Everyday</title>
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

        .feature-box {
            background-color: #f9f9f9;
            border-left: 4px solid #e91e63;
            padding: 15px;
            margin: 20px 0;
        }

        .link {
            color: #e91e63;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="content">
            <h1>Selamat Datang di Premium Everyday!</h1>

            <p>Halo {{ $user->name }},</p>

            <p>Terima kasih telah bergabung dengan Premium Everyday menggunakan akun Google Anda. Kami senang Anda
                menjadi bagian dari komunitas kami!</p>

            <p>Akun Anda telah sukses dibuat dan telah otomatis terverifikasi. Anda tidak perlu melakukan verifikasi
                email lagi.</p>

            <div class="feature-box">
                <p><strong>Detail Akun Anda:</strong></p>
                <ul>
                    <li>Nama: {{ $user->name }}</li>
                    <li>Email: {{ $user->email }}</li>
                    <li>Status: Terverifikasi (via Google)</li>
                </ul>
            </div>

            <p>Dengan akun Premium Everyday, Anda dapat:</p>
            <ul>
                <li>Membeli produk digital premium</li>
                <li>Mendapatkan akses ke konten eksklusif</li>
                <li>Menikmati promo dan diskon khusus member</li>
                <li>Kelola pesanan dan pembayaran Anda</li>
            </ul>

            <div style="text-align: center;">
                <a href="{{ route('products.index') }}" class="button">Mulai Belanja Sekarang</a>
            </div>

            <p>Jika Anda memiliki pertanyaan atau membutuhkan bantuan, jangan ragu untuk menghubungi tim dukungan kami
                melalui halaman <a href="{{ route('contact') }}" class="link">Kontak</a>.</p>

            <p>Terima kasih telah memilih Premium Everyday!</p>

            <p>Salam,<br>
                Tim Premium Everyday</p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Premium Everyday. All rights reserved.</p>
            <p>Jl. Contoh No. 123, Jakarta Indonesia</p>
        </div>
    </div>
</body>

</html>
