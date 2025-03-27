<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk Dikirim & Informasi Akun Premium</title>
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
            background-color: #673ab7;
            padding: 30px 20px;
            text-align: center;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }

        .header h1 {
            color: white;
            font-size: 24px;
            margin: 0;
            font-weight: bold;
        }

        .content {
            background-color: white;
            padding: 40px 30px;
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
        }

        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #666;
        }

        h2 {
            font-size: 18px;
            color: #333;
            margin-top: 25px;
            margin-bottom: 15px;
        }

        .button {
            display: inline-block;
            background-color: #673ab7;
            color: white;
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
        }

        .link {
            word-break: break-all;
            color: #673ab7;
        }

        .success-box {
            background-color: #e8f5e9;
            border-left: 4px solid #4caf50;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .info-box {
            background-color: #f8f8f8;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .credential-box {
            background-color: #e3f2fd;
            border-left: 4px solid #2196f3;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .instruction-box {
            background-color: #f3e5f5;
            border-left: 4px solid #673ab7;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .warning-box {
            background-color: #ffebee;
            border-left: 4px solid #f44336;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        hr {
            border: 0;
            height: 1px;
            background-color: #eaeaea;
            margin: 20px 0;
        }

        ol,
        ul {
            margin-left: 20px;
            padding-left: 0;
        }

        li {
            margin-bottom: 8px;
        }

        .badge {
            display: inline-block;
            padding: 6px 12px;
            font-size: 12px;
            font-weight: bold;
            border-radius: 20px;
            background-color: #673ab7;
            color: white;
            margin-bottom: 5px;
        }

        .order-summary {
            margin: 20px 0;
            border: 1px solid #eaeaea;
            border-radius: 5px;
            overflow: hidden;
        }

        .order-summary-header {
            background-color: #f3f4f6;
            padding: 10px 15px;
            font-weight: bold;
            border-bottom: 1px solid #eaeaea;
        }

        .order-summary-body {
            padding: 15px;
        }

        .order-summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .order-summary-row:last-child {
            margin-bottom: 0;
            padding-top: 10px;
            border-top: 1px dashed #eaeaea;
            font-weight: bold;
        }

        .product-credential-header {
            background-color: #f0f3f9;
            padding: 10px 15px;
            font-weight: bold;
            border-bottom: 1px solid #e0e0e0;
            color: #333;
            font-size: 15px;
            margin-bottom: 0;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Produk Dikirim & Informasi Akun</h1>
        </div>
        <div class="content">
            <div class="success-box">
                <strong style="font-size: 16px;">Pesanan Anda telah dikirim!</strong><br>
                Berikut adalah informasi akun premium Anda untuk Pesanan #{{ $order->order_number }}.
            </div>

            <hr>

            <h2>Produk Yang Dibeli:</h2>

            @foreach ($order->items as $item)
                <div class="info-box">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <strong style="font-size: 16px;">{{ $item->name }}</strong>
                        <span class="badge"
                            style="
                            @if (strtolower($item->subscription_type ?? 'sharing') == 'private') background-color: #2196f3;
                            @else
                                background-color: #4caf50; @endif
                        ">
                            {{ strtolower($item->subscription_type ?? 'sharing') == 'private' ? 'Private' : 'Sharing' }}
                        </span>
                    </div>

                    <div style="margin-bottom: 10px; font-size: 14px; color: #555;">
                        ID Produk: {{ $item->product_id ?? 'P-' . str_pad($item->id, 5, '0', STR_PAD_LEFT) }}
                    </div>

                    @if ($item->description)
                        <div style="margin-bottom: 12px; font-size: 14px;">
                            {{ $item->description }}
                        </div>
                    @endif

                    <table style="width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 14px;">
                        <tr>
                            <td style="padding: 8px 0; border-bottom: 1px solid #eee;"><strong>Harga</strong></td>
                            <td style="padding: 8px 0; border-bottom: 1px solid #eee; text-align: right;">Rp
                                {{ number_format($item->price, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0; border-bottom: 1px solid #eee;"><strong>Jumlah</strong></td>
                            <td style="padding: 8px 0; border-bottom: 1px solid #eee; text-align: right;">
                                {{ $item->quantity }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0; border-bottom: 1px solid #eee;"><strong>Durasi</strong></td>
                            <td style="padding: 8px 0; border-bottom: 1px solid #eee; text-align: right;">
                                {{ $item->duration ?? 1 }} bulan</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0;"><strong>Total</strong></td>
                            <td style="padding: 8px 0; text-align: right; font-weight: bold;">
                                {{ $item->formatted_total ?? 'Rp ' . number_format($item->quantity * $item->price, 0, ',', '.') }}
                            </td>
                        </tr>
                    </table>
                </div>
            @endforeach

            <div class="order-summary">
                <div class="order-summary-header">Ringkasan Pesanan #{{ $order->order_number }}</div>
                <div class="order-summary-body">
                    <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                        <tr>
                            <td style="padding: 8px 0; border-bottom: 1px solid #eee;"><strong>ID Pesanan</strong></td>
                            <td style="padding: 8px 0; border-bottom: 1px solid #eee; text-align: right;">
                                {{ $order->order_number }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0; border-bottom: 1px solid #eee;"><strong>Tanggal Pesanan</strong>
                            </td>
                            <td style="padding: 8px 0; border-bottom: 1px solid #eee; text-align: right;">
                                {{ $order->created_at->format('d M Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0; border-bottom: 1px solid #eee;"><strong>Metode
                                    Pembayaran</strong></td>
                            <td style="padding: 8px 0; border-bottom: 1px solid #eee; text-align: right;">
                                {{ ucfirst($order->payment_method) }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0; border-bottom: 1px solid #eee;"><strong>Status
                                    Pembayaran</strong></td>
                            <td style="padding: 8px 0; border-bottom: 1px solid #eee; text-align: right;">
                                <span
                                    style="
                                    display: inline-block;
                                    padding: 4px 8px;
                                    border-radius: 4px;
                                    font-size: 12px;
                                    font-weight: bold;
                                    background-color: #4caf50;
                                    color: white;
                                ">
                                    LUNAS
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0; border-bottom: 1px solid #eee;"><strong>Subtotal</strong></td>
                            <td style="padding: 8px 0; border-bottom: 1px solid #eee; text-align: right;">Rp
                                {{ number_format($order->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @if ($order->discount_amount > 0)
                            <tr>
                                <td style="padding: 8px 0; border-bottom: 1px solid #eee;"><strong>Diskon</strong></td>
                                <td
                                    style="padding: 8px 0; border-bottom: 1px solid #eee; text-align: right; color: #f44336;">
                                    - Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</td>
                            </tr>
                        @endif
                        <tr>
                            <td style="padding: 10px 0; font-weight: bold; font-size: 16px;"><strong>Total</strong></td>
                            <td
                                style="padding: 10px 0; text-align: right; font-weight: bold; font-size: 16px; color: #673ab7;">
                                Rp {{ number_format($order->total, 0, ',', '.') }}
                                <span style="display: block; font-size: 11px; color: #666; font-weight: normal;">(sudah
                                    termasuk pajak)</span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <hr>

            <h2>Informasi Akun Premium:</h2>

            @if (is_array($credentials) && isset($credentials[0]))
                {{-- Multiple credentials for multiple products --}}
                @foreach ($credentials as $index => $credential)
                    <div style="margin-bottom: 20px;">
                        <div class="product-credential-header">
                            {{ $credential['product_name'] ?? 'Produk #' . ($index + 1) }}
                            @if (isset($credential['product_id']))
                                <span style="font-size: 12px; font-weight: normal; margin-left: 10px; color: #666;">
                                    ({{ $credential['product_id'] }})
                                </span>
                            @endif
                        </div>
                        <div class="credential-box" style="border-top-left-radius: 0; border-top-right-radius: 0;">
                            <p><strong>Username/Email:</strong> {{ $credential['username'] }}</p>
                            <p><strong>Password:</strong> {{ $credential['password'] }}</p>
                            <p><strong>Tipe Akun:</strong>
                                <span
                                    style="
                                    @if (strtolower($credential['subscription_type'] ?? 'private') == 'private') color: #2196f3;
                                    @else
                                        color: #4caf50; @endif
                                    font-weight: bold;
                                ">
                                    {{ strtolower($credential['subscription_type'] ?? 'private') == 'private' ? 'Private' : 'Sharing' }}
                                </span>
                            </p>
                            <p><strong>Durasi:</strong> {{ $credential['duration'] ?? 1 }} bulan</p>
                            <p><strong>Masa Berlaku:</strong> Hingga {{ $credential['expired_at'] }}</p>

                            @if (!empty($credential['instructions']))
                                <div class="instruction-box" style="margin-top: 10px; margin-bottom: 0;">
                                    <p style="margin-top: 0;"><strong>Petunjuk Penggunaan:</strong></p>
                                    {!! nl2br(e($credential['instructions'])) !!}
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                {{-- Backward compatibility for single credential --}}
                <div class="credential-box">
                    <p><strong>Username/Email:</strong> {{ $credentials['username'] }}</p>
                    <p><strong>Password:</strong> {{ $credentials['password'] }}</p>
                    <p><strong>Tipe Akun:</strong>
                        <span
                            style="
                            @if (strtolower($credentials['type'] ?? 'private') == 'private') color: #2196f3;
                            @else
                                color: #4caf50; @endif
                            font-weight: bold;
                        ">
                            {{ strtolower($credentials['type'] ?? 'private') == 'private' ? 'Private' : 'Sharing' }}
                        </span>
                    </p>
                    <p><strong>Durasi:</strong> {{ $credentials['duration'] ?? 1 }} bulan</p>
                    <p><strong>Masa Berlaku:</strong> Hingga {{ $credentials['expired_at'] }}</p>
                </div>
            @endif

            <hr>

            <h2>Cara Penggunaan:</h2>

            <div class="instruction-box">
                @if (!empty($credentials['instructions']) && !is_array($credentials))
                    {!! nl2br(e($credentials['instructions'])) !!}
                @else
                    <ol>
                        <li>Login ke layanan menggunakan username dan password di atas</li>
                        <li>Setelah login, silakan pilih paket yang telah Anda beli</li>
                        <li>Nikmati semua fitur premium yang tersedia</li>
                        <li>Hubungi kami jika ada kendala dalam penggunaan</li>
                    </ol>
                @endif
            </div>

            <hr>

            <h2 style="color: #f44336;">Catatan Penting:</h2>

            <div class="warning-box">
                <ul>
                    <li>Jangan membagikan informasi akun ini kepada orang lain</li>
                    <li>Penggunaan akun diluar ketentuan dapat menyebabkan penangguhan akun</li>
                    <li>Simpan informasi akun ini di tempat yang aman</li>
                </ul>
            </div>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ $orderUrl }}" class="button">Lihat Detail Pesanan</a>
            </div>

            <p>Terima kasih telah berbelanja di Premium Everyday!</p>

            <hr>

            <p style="font-size: 12px; color: #718096;">
                Butuh bantuan? Hubungi tim support kami melalui <a href="mailto:support@premium-everyday.com"
                    class="link">support@premium-everyday.com</a> atau WhatsApp di +628123456789
            </p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} Premium Everyday. All rights reserved.
        </div>
    </div>
</body>

</html>
