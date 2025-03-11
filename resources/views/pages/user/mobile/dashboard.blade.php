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
        border-radius: 12px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 15px;
    }

    .stat-card {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        color: white;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
    }

    .nav-pills .nav-link.active {
        background-color: var(--primary);
    }

    .nav-pills .nav-link {
        color: var(--primary-dark);
        padding: 8px 12px;
        font-size: 14px;
    }

    .btn-primary {
        background-color: var(--primary);
        border-color: var(--primary);
    }

    .btn-primary:hover {
        background-color: var(--primary-dark);
        border-color: var(--primary-dark);
    }

    .order-item {
        border-bottom: 1px solid #eee;
        padding: 10px 0;
    }

    .order-item:last-child {
        border-bottom: none;
    }

    .profile-section {
        text-align: center;
        padding: 20px 15px;
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
        color: white;
        border-radius: 0 0 20px 20px;
        margin-bottom: 20px;
    }

    .quick-actions {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
        padding: 15px;
    }

    .action-button {
        background: white;
        border: 1px solid var(--primary);
        color: var(--primary);
        padding: 10px;
        border-radius: 8px;
        text-align: center;
        text-decoration: none;
        font-size: 14px;
    }

    .action-button:hover {
        background: var(--primary);
        color: white;
    }
</style>
@endsection

@section('content')
<!-- Profile Section -->
<div class="profile-section">
    <img src="{{ auth()->user()->profile_photo_url }}" 
         alt="Profile" 
         class="rounded-circle mb-3"
         style="width: 80px; height: 80px; object-fit: cover; border: 3px solid white;">
    <h5 class="mb-1">{{ auth()->user()->name }}</h5>
    <p class="mb-0 small">{{ auth()->user()->email }}</p>
</div>

<div class="container">
    <!-- Stats Cards -->
    <div class="row g-2 mb-3">
        <div class="col-4">
            <div class="stat-card text-center">
                <div class="small">Total</div>
                <h4 class="mb-0">{{ $totalOrders ?? 0 }}</h4>
            </div>
        </div>
        <div class="col-4">
            <div class="stat-card text-center">
                <div class="small">Aktif</div>
                <h4 class="mb-0">{{ $activeOrders ?? 0 }}</h4>
            </div>
        </div>
        <div class="col-4">
            <div class="stat-card text-center">
                <div class="small">Pengeluaran</div>
                <h4 class="mb-0">{{ number_format($totalSpent ?? 0, 0, ',', '.') }}</h4>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="dashboard-card">
        <h6 class="p-3 mb-0 border-bottom">Menu Cepat</h6>
        <div class="quick-actions">
            <a href="{{ route('products') }}" class="action-button">
                <i class="fas fa-shopping-bag mb-1"></i><br>
                Produk
            </a>
            <a href="{{ route('user.orders') }}" class="action-button">
                <i class="fas fa-list mb-1"></i><br>
                Pesanan
            </a>
            <a href="{{ route('user.profile') }}" class="action-button">
                <i class="fas fa-user mb-1"></i><br>
                Profil
            </a>
            <a href="{{ route('contact') }}" class="action-button">
                <i class="fas fa-headset mb-1"></i><br>
                Bantuan
            </a>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="dashboard-card">
        <h6 class="p-3 mb-0 border-bottom">Pesanan Terbaru</h6>
        <div class="p-2">
            @forelse($recentOrders ?? [] as $order)
            <div class="order-item p-2">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <strong>#{{ $order->id }}</strong>
                    <span class="badge bg-{{ $order->status_color }}">
                        {{ $order->status }}
                    </span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">{{ $order->created_at->format('d M Y') }}</small>
                    <div>
                        <span class="me-2">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                        <a href="{{ route('user.orders.show', $order->id) }}" 
                           class="btn btn-sm btn-primary">
                            Detail
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-4">
                <p class="mb-0 text-muted">Belum ada pesanan</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection 