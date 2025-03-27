<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil</title>
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
            color: #4caf50;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .button {
            display: inline-block;
            background-color: #4caf50;
            color: white;
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
        }

        .link {
            word-break: break-all;
            color: #4caf50;
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

        .warning-box {
            background-color: #fff8e1;
            border-left: 4px solid #ffc107;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        hr {
            border: 0;
            height: 1px;
            background-color: #eaeaea;
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="content">
            <h1>Pembayaran Berhasil!</h1>

            <div class="success-box">
                <strong style="font-size: 16px;">Pembayaran Anda telah berhasil!</strong><br>
                Terima kasih atas pembayaran Anda untuk pesanan #{{ $order->order_number }}.
            </div>

            <hr>

            <h2 style="font-size: 18px; color: #333;">Detail Pesanan #{{ $order->order_number }}:</h2>

            @foreach ($order->items as $item)
                <div class="info-box">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <strong style="font-size: 16px;">{{ $item->name }}</strong>
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
                        @if (isset($item->duration))
                            <tr>
                                <td style="padding: 8px 0; border-bottom: 1px solid #eee;"><strong>Durasi</strong></td>
                                <td style="padding: 8px 0; border-bottom: 1px solid #eee; text-align: right;">
                                    {{ $item->duration ?? 1 }} bulan</td>
                            </tr>
                        @endif
                        <tr>
                            <td style="padding: 8px 0;"><strong>Total</strong></td>
                            <td style="padding: 8px 0; text-align: right; font-weight: bold;">
                                {{ $item->formatted_total ?? 'Rp ' . number_format($item->quantity * $item->price, 0, ',', '.') }}
                            </td>
                        </tr>
                    </table>
                </div>
            @endforeach

            <hr>

            <div style="background-color: #f9f9f9; border-radius: 5px; padding: 20px; margin-bottom: 20px;">
                <h3 style="font-size: 16px; margin-top: 0; margin-bottom: 15px; color: #333;">Ringkasan Pesanan</h3>
                <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                    <tr>
                        <td style="padding: 8px 0; border-bottom: 1px solid #eee;"><strong>ID Pesanan</strong></td>
                        <td style="padding: 8px 0; border-bottom: 1px solid #eee; text-align: right;">
                            {{ $order->order_number }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; border-bottom: 1px solid #eee;"><strong>Tanggal Pesanan</strong></td>
                        <td style="padding: 8px 0; border-bottom: 1px solid #eee; text-align: right;">
                            {{ $order->created_at->format('d M Y H:i') }}</td>
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
                    <tr class="font-semibold">
                        <td style="padding: 10px 0; font-weight: bold; font-size: 16px;"><strong>Total</strong></td>
                        <td
                            style="padding: 10px 0; text-align: right; font-weight: bold; font-size: 16px; color: #4caf50;">
                            Rp {{ number_format($order->total, 0, ',', '.') }}
                            <span style="display: block; font-size: 11px; color: #666; font-weight: normal;">(sudah
                                termasuk pajak)</span>
                        </td>
                    </tr>
                </table>
            </div>

            <hr>

            <h2 style="font-size: 18px; color: #333;">Informasi Pembayaran:</h2>

            <div class="info-box">
                <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                    <tr>
                        <td style="padding: 8px 0; border-bottom: 1px solid #eee;"><strong>Metode Pembayaran</strong>
                        </td>
                        <td style="padding: 8px 0; border-bottom: 1px solid #eee; text-align: right;">
                            {{ $paymentType }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; border-bottom: 1px solid #eee;"><strong>Status Pembayaran</strong>
                        </td>
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
                        <td style="padding: 8px 0;"><strong>Tanggal Pembayaran</strong></td>
                        <td style="padding: 8px 0; text-align: right;">{{ $paymentDate }}</td>
                    </tr>
                </table>
            </div>

            <hr>

            <h2 style="font-size: 18px; color: #333;">Status Pesanan:</h2>

            <div class="warning-box">
                <p><strong>Status saat ini:</strong> {{ $statusLabel }}</p>
                <p><strong>Estimasi proses:</strong> 1-2 jam kerja</p>
            </div>

            <div
                style="background-color: #e3f2fd; border-left: 4px solid #2196f3; padding: 15px; border-radius: 5px; margin: 20px 0;">
                <p>Tim kami akan memproses pesanan Anda segera. Anda akan menerima informasi akun melalui email setelah
                    pesanan diproses.</p>
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
