<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pesanan Berubah</title>
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
            font-size: 24px;
            margin-bottom: 20px;
        }

        .button {
            display: inline-block;
            background-color: #4361ee;
            color: white;
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
        }

        .link {
            word-break: break-all;
            color: #4361ee;
        }

        .status-box {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .approved {
            background-color: #e8f5e9;
            border-left: 4px solid #4caf50;
            color: #2e7d32;
        }

        .rejected {
            background-color: #fef1f2;
            border-left: 4px solid #f44336;
            color: #d32f2f;
        }

        .pending {
            background-color: #fff8e1;
            border-left: 4px solid #ffc107;
            color: #ff8f00;
        }

        .info-box {
            background-color: #f8f8f8;
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
            <h1
                style="{{ $newStatus === 'approved' ? 'color: #4caf50;' : ($newStatus === 'rejected' ? 'color: #f44336;' : 'color: #ffc107;') }}">
                Status Pesanan Anda Telah Berubah
            </h1>

            <div class="status-box {{ $newStatus }}">
                <strong style="font-size: 16px;">Status pesanan Anda telah berubah menjadi
                    {{ $newStatusLabel }}</strong><br>
                Pesanan #{{ $order->order_number }} telah diperbarui dari {{ $oldStatusLabel }} menjadi
                {{ $newStatusLabel }}.
            </div>

            @if ($newStatus === 'rejected')
                <p>
                    Mohon maaf, pesanan Anda tidak dapat diproses. Hal ini mungkin terjadi karena beberapa alasan,
                    seperti:
                </p>
                <ul>
                    <li>Produk yang Anda pesan tidak tersedia</li>
                    <li>Pembayaran belum dapat dikonfirmasi</li>
                    <li>Alasan teknis lainnya</li>
                </ul>
                <p>
                    Jika Anda telah melakukan pembayaran, dana Anda akan dikembalikan dalam waktu 24 jam kerja.
                </p>
                <p>
                    Jika Anda memiliki pertanyaan, silakan hubungi tim layanan pelanggan kami untuk informasi lebih
                    lanjut.
                </p>
            @elseif ($newStatus === 'approved')
                <p>
                    Selamat! Pesanan Anda telah disetujui dan sedang kami proses. Anda akan menerima informasi akun dan
                    detail produk dalam waktu dekat.
                </p>
            @endif

            <hr>

            <h2 style="font-size: 18px; color: #333;">Detail Pesanan #{{ $order->order_number }}:</h2>

            @foreach ($order->items as $item)
                <div class="info-box">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <strong style="font-size: 16px;">{{ $item->orderable->name ?? 'Produk' }}</strong>
                    </div>

                    <div style="margin-bottom: 10px; font-size: 14px; color: #555;">
                        ID Produk: {{ $item->product_id ?? 'P-' . str_pad($item->id, 5, '0', STR_PAD_LEFT) }}
                    </div>

                    <table style="width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 14px;">
                        <tr>
                            <td style="padding: 8px 0; border-bottom: 1px solid #eee;"><strong>Harga</strong></td>
                            <td style="padding: 8px 0; border-bottom: 1px solid #eee; text-align: right;">
                                {{ $item->formatted_price ?? 'Rp ' . number_format($item->price, 0, ',', '.') }}
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0; border-bottom: 1px solid #eee;"><strong>Jumlah</strong></td>
                            <td style="padding: 8px 0; border-bottom: 1px solid #eee; text-align: right;">
                                {{ $item->quantity }}
                            </td>
                        </tr>
                        @if (isset($item->duration))
                            <tr>
                                <td style="padding: 8px 0; border-bottom: 1px solid #eee;"><strong>Durasi</strong></td>
                                <td style="padding: 8px 0; border-bottom: 1px solid #eee; text-align: right;">
                                    {{ $item->duration ?? 1 }} bulan
                                </td>
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

            <p>
                Anda dapat melihat status pesanan Anda melalui halaman akun Anda.
            </p>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ $orderUrl }}" class="button" style="color: white;">Lihat Pesanan</a>
            </div>

            <hr>

            <div style="text-align: center; color: #666; font-size: 14px;">
                <p>
                    Jika Anda memiliki pertanyaan, silakan hubungi tim layanan pelanggan kami.
                </p>
                <p>
                    Terima kasih atas pengertian Anda.
                </p>
            </div>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Premium Everyday. Semua hak dilindungi.</p>
        </div>
    </div>
</body>

</html>
