<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Lisensi - {{ config('app.name') }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            font-size: 12px;
            line-height: 1.4;
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 1px solid #e2e8f0;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            color: #2563eb;
            font-size: 24px;
            font-weight: bold;
        }

        .header p {
            margin: 5px 0 0;
            color: #64748b;
            font-size: 14px;
        }

        .user-info {
            margin-bottom: 20px;
            padding: 0 20px;
        }

        .user-info table {
            width: 100%;
        }

        .user-info td {
            padding: 3px 0;
        }

        .user-info .label {
            font-weight: bold;
            width: 150px;
        }

        .section-title {
            background-color: #f1f5f9;
            padding: 10px 20px;
            margin: 0 0 15px;
            font-size: 14px;
            font-weight: bold;
            color: #334155;
        }

        .licenses-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .licenses-table th {
            background-color: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            padding: 10px;
            text-align: left;
            font-weight: bold;
            color: #475569;
            font-size: 11px;
        }

        .licenses-table td {
            padding: 10px;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: top;
        }

        .license-key {
            font-family: 'Courier New', monospace;
            font-size: 10px;
            word-break: break-all;
        }

        .status {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-active {
            background-color: #dcfce7;
            color: #166534;
        }

        .status-expired {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .status-max-activations {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-other {
            background-color: #f1f5f9;
            color: #475569;
        }

        .footer {
            margin-top: 30px;
            padding: 15px 20px;
            border-top: 1px solid #e2e8f0;
            font-size: 10px;
            text-align: center;
            color: #64748b;
        }

        .page-break {
            page-break-after: always;
        }

        @page {
            margin: 50px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>{{ config('app.name') }}</h1>
            <p>Laporan Lisensi</p>
        </div>

        <div class="user-info">
            <table>
                <tr>
                    <td class="label">Nama:</td>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <td class="label">Email:</td>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <td class="label">Tanggal Cetak:</td>
                    <td>{{ $generated_at->format('d M Y, H:i') }}</td>
                </tr>
                <tr>
                    <td class="label">Jumlah Lisensi:</td>
                    <td>{{ count($licenses) }}</td>
                </tr>
            </table>
        </div>

        <h2 class="section-title">Daftar Lisensi</h2>

        <table class="licenses-table">
            <thead>
                <tr>
                    <th style="width: 5%">No</th>
                    <th style="width: 25%">Produk</th>
                    <th style="width: 40%">Kunci Lisensi</th>
                    <th style="width: 15%">Status</th>
                    <th style="width: 15%">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($licenses as $index => $license)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $license['product'] }}</td>
                        <td class="license-key">{{ $license['key'] }}</td>
                        <td>
                            @if ($license['status'] == 'active')
                                <span class="status status-active">Aktif</span>
                            @elseif($license['status'] == 'expired')
                                <span class="status status-expired">Kadaluarsa</span>
                            @elseif($license['status'] == 'max-activations')
                                <span class="status status-max-activations">Batas Aktivasi</span>
                            @else
                                <span class="status status-other">{{ ucfirst($license['status']) }}</span>
                            @endif
                        </td>
                        <td>{{ $license['date'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            <p>
                Dokumen ini dihasilkan secara otomatis oleh sistem {{ config('app.name') }}.<br>
                Laporan ini berisi informasi pribadi dan bersifat rahasia.
            </p>
        </div>
    </div>
</body>

</html>
