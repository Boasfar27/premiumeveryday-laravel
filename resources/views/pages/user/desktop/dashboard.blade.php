@extends('pages.layouts.app')

@section('title', 'Dashboard User')

@section('styles')
<style>
    :root {
        --primary-dark: #3D0301;
        --primary: #B03052;
        --secondary: #D76C82;
        --accent: #3D0301;
    }

    .dashboard-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .dashboard-card:hover {
        transform: translateY(-5px);
    }

    .stat-card {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        color: white;
        border-radius: 10px;
        padding: 20px;
    }

    .nav-pills .nav-link.active {
        background-color: var(--primary);
    }

    .nav-pills .nav-link {
        color: var(--primary-dark);
    }

    .btn-primary {
        background-color: var(--primary);
        border-color: var(--primary);
    }

    .btn-primary:hover {
        background-color: var(--primary-dark);
        border-color: var(--primary-dark);
    }

    .table-hover tbody tr:hover {
        background-color: rgba(215, 108, 130, 0.1);
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="text-primary-dark mb-4">Selamat Datang, {{ auth()->user()->name }}!</h1>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="stat-card">
                <h3 class="fs-5">Total Pesanan</h3>
                <h2 class="fs-1 mb-0">{{ $totalOrders ?? 0 }}</h2>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="stat-card">
                <h3 class="fs-5">Pesanan Aktif</h3>
                <h2 class="fs-1 mb-0">{{ $activeOrders ?? 0 }}</h2>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="stat-card">
                <h3 class="fs-5">Total Pengeluaran</h3>
                <h2 class="fs-1 mb-0">Rp {{ number_format($totalSpent ?? 0, 0, ',', '.') }}</h2>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <!-- Left Column -->
        <div class="col-md-8">
            <div class="dashboard-card p-4 mb-4">
                <h4 class="mb-4">Pesanan Terbaru</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID Pesanan</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders ?? [] as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>{{ $order->created_at->format('d M Y') }}</td>
                                <td>
                                    <span class="badge bg-{{ $order->status_color }}">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('user.orders.show', $order->id) }}" 
                                       class="btn btn-sm btn-primary">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada pesanan</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="col-md-4">
            <!-- Profile Card -->
            <div class="dashboard-card p-4 mb-4">
                <div class="text-center mb-4">
                    <img src="{{ auth()->user()->profile_photo_url }}" 
                         alt="Profile" 
                         class="rounded-circle mb-3"
                         style="width: 100px; height: 100px; object-fit: cover;">
                    <h5 class="mb-1">{{ auth()->user()->name }}</h5>
                    <p class="text-muted mb-0">{{ auth()->user()->email }}</p>
                </div>
                <div class="d-grid gap-2">
                    <a href="{{ route('user.profile') }}" class="btn btn-primary">
                        Edit Profil
                    </a>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="dashboard-card p-4">
                <h5 class="mb-4">Menu Cepat</h5>
                <div class="d-grid gap-2">
                    <a href="{{ route('products') }}" class="btn btn-outline-primary">
                        Lihat Produk
                    </a>
                    <a href="{{ route('user.orders') }}" class="btn btn-outline-primary">
                        Riwayat Pesanan
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-outline-primary">
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 