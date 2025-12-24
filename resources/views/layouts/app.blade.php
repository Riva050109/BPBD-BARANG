<!DOCTYPE html>
<html lang="id" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIPERDA BPBD')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --bpbd-primary: #4361ee;
            --bpbd-primary-dark: #3a56d4;
            --bpbd-secondary: #7209b7;
            --bpbd-accent: #f72585;
            --bpbd-success: #4cc9f0;
            --bpbd-info: #4895ef;
            --bpbd-warning: #f8961e;
            --bpbd-danger: #e63946;
            --bpbd-light: #f8f9fa;
            --bpbd-dark: #1d3557;
            --bpbd-gray: #6c757d;
            --bpbd-border: #e9ecef;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
            min-height: 100vh;
            line-height: 1.6;
            color: #2d3748;
        }
        
        /* ===== NAVBAR ===== */
        .navbar-bpbd {
            background: linear-gradient(135deg, var(--bpbd-primary) 0%, var(--bpbd-secondary) 100%);
            backdrop-filter: blur(10px);
            border: none;
            box-shadow: 0 2px 30px rgba(67, 97, 238, 0.15);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .navbar-brand {
            font-weight: 800;
            font-size: 1.4rem;
            color: white !important;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .navbar-brand i {
            background: rgba(255, 255, 255, 0.15);
            padding: 0.5rem;
            border-radius: 12px;
            backdrop-filter: blur(10px);
        }
        
        .navbar-toggler {
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 0.5rem 0.75rem;
        }
        
        .navbar-toggler:focus {
            box-shadow: none;
        }
        
        /* ===== SIDEBAR ===== */
        .sidebar {
            background: linear-gradient(180deg, var(--bpbd-dark) 0%, #14213d 100%);
            min-height: calc(100vh - 80px);
            position: relative;
            overflow: hidden;
        }
        
        .sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--bpbd-accent) 0%, var(--bpbd-warning) 100%);
        }
        
        .sidebar-content {
            padding: 2rem 0;
            height: 100%;
        }
        
        .nav-section {
            margin-bottom: 2rem;
        }
        
        .table th {
            font-weight: 600;
            background-color: #f8f9fa;
        }

        .card.bg-primary { background: linear-gradient(135deg, var(--bpbd-primary) 0%, var(--bpbd-info) 100%) !important; }
        .card.bg-success { background: linear-gradient(135deg, var(--bpbd-success) 0%, #38b000 100%) !important; }
        .card.bg-info { background: linear-gradient(135deg, var(--bpbd-info) 0%, #0077b6 100%) !important; }
        
        .section-title {
            color: #a0aec0;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 0 1.5rem 0.5rem;
            margin-bottom: 0.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .nav-link-custom {
            color: #e2e8f0;
            padding: 0.875rem 1.5rem;
            margin: 0.125rem 0.75rem;
            border-radius: 12px;
            border: 1px solid transparent;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            position: relative;
            overflow: hidden;
        }
        
        .nav-link-custom::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.6s;
        }
        
        .nav-link-custom:hover::before {
            left: 100%;
        }
        
        .nav-link-custom:hover {
            background: rgba(255, 255, 255, 0.08);
            color: white;
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateX(4px);
        }
        
        .nav-link-custom.active {
            background: linear-gradient(135deg, var(--bpbd-primary) 0%, var(--bpbd-info) 100%);
            color: white;
            border-color: rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 20px rgba(67, 97, 238, 0.3);
        }
        
        .nav-link-custom i {
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }
        
        /* ===== MAIN CONTENT ===== */
        .main-content {
            background: transparent;
            min-height: calc(100vh - 80px);
            padding: 0;
        }
        
        .content-container {
            background: white;
            margin: 1.5rem;
            border-radius: 20px;
            box-shadow: 
                0 4px 25px rgba(0, 0, 0, 0.08),
                0 2px 4px rgba(0, 0, 0, 0.02);
            border: 1px solid rgba(0, 0, 0, 0.04);
            min-height: calc(100vh - 110px);
            overflow: hidden;
        }
        
        .page-header {
            background: linear-gradient(135deg, #ffffff 0%, #fafbfc 100%);
            padding: 2rem 2.5rem;
            border-bottom: 1px solid var(--bpbd-border);
            position: relative;
        }
        
        .page-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--bpbd-border), transparent);
        }
        
        .page-title {
            color: var(--bpbd-dark);
            font-weight: 700;
            font-size: 1.75rem;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .page-title i {
            background: linear-gradient(135deg, var(--bpbd-primary) 0%, var(--bpbd-secondary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 1.5em;
        }
        
        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .content-body {
            padding: 2.5rem;
            background: #ffffff;
        }
        
        /* ===== ALERTS ===== */
        .alert-custom {
            border: none;
            border-radius: 16px;
            padding: 1.25rem 1.5rem;
            margin: 0 2.5rem 1.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border-left: 4px solid;
            backdrop-filter: blur(10px);
        }
        
        .alert-success {
            background: linear-gradient(135deg, #f0fff4 0%, #e6fffa 100%);
            border-left-color: var(--bpbd-success);
            color: #2d3748;
        }
        
        .alert-danger {
            background: linear-gradient(135deg, #fff5f5 0%, #fed7d7 100%);
            border-left-color: var(--bpbd-danger);
            color: #2d3748;
        }
        
        .alert-custom i {
            margin-right: 0.75rem;
            font-size: 1.2em;
        }
        
        /* ===== FOOTER ===== */
        .footer-bpbd {
            background: linear-gradient(135deg, var(--bpbd-dark) 0%, #14213d 100%);
            color: white;
            padding: 1.5rem 0;
            margin-top: auto;
            border-top: 3px solid var(--bpbd-accent);
        }
        
        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .footer-text {
            margin: 0;
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        .footer-text i {
            color: var(--bpbd-accent);
            margin-right: 0.5rem;
        }
        
        /* ===== USER BADGE ===== */
        .user-profile {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .user-badge {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            padding: 0.5rem 1rem;
            border-radius: 25px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .role-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
        }
        
        /* ===== BUTTONS ===== */
        .btn-outline-light {
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        
        .btn-outline-light:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-1px);
        }
        
        /* ===== RESPONSIVE DESIGN ===== */
        @media (max-width: 768px) {
            .sidebar {
                min-height: auto;
            }
            
            .content-container {
                margin: 1rem;
                border-radius: 16px;
            }
            
            .page-header {
                padding: 1.5rem;
            }
            
            .page-title {
                font-size: 1.5rem;
            }
            
            .content-body {
                padding: 1.5rem;
            }
            
            .alert-custom {
                margin: 0 1.5rem 1rem;
            }
            
            .footer-content {
                flex-direction: column;
                text-align: center;
            }
        }
        
        /* ===== ANIMATIONS ===== */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .content-body {
            animation: fadeInUp 0.6s ease-out;
        }
        
        /* ===== SCROLLBAR ===== */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }
        
        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 3px;
        }
        
        .sidebar::-webkit-scrollbar-thumb {
            background: var(--bpbd-primary);
            border-radius: 3px;
        }
        
        .sidebar::-webkit-scrollbar-thumb:hover {
            background: var(--bpbd-primary-dark);
        }
        
        /* ===== UTILITY CLASSES ===== */
        .text-gradient {
            background: linear-gradient(135deg, var(--bpbd-primary) 0%, var(--bpbd-secondary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .shadow-soft {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }
        
        .border-light-custom {
            border-color: rgba(0, 0, 0, 0.06) !important;
        }
        
        /* ===== BADGE COLORS ===== */
        .badge-pakai-habis {
            background: linear-gradient(135deg, var(--bpbd-success) 0%, #38b000 100%);
        }
        
        .badge-aset-tetap {
            background: linear-gradient(135deg, var(--bpbd-info) 0%, #0077b6 100%);
        }
        
        /* ===== DISABLED MENU STYLE ===== */
        .nav-link-custom.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .nav-link-custom.disabled:hover {
            background: transparent;
            border-color: transparent;
            transform: none;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-bpbd">
        <div class="container-fluid px-3">
            <!-- Brand -->
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="fas fa-landmark"></i>
                <span>BPBD BARANG</span>
            </a>
            
            <!-- Mobile Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Navbar Content -->
            <div class="collapse navbar-collapse" id="navbarMain">
                <!-- Navigation Menu -->
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
                           href="{{ route('dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i>
                            Dashboard
                        </a>
                    </li>
                </ul>
                
                <!-- User Section -->
<div class="navbar-nav ms-auto">
    <div class="user-profile">
        <span class="navbar-text me-3 d-none d-md-block">
            <div class="user-badge">
                <i class="fas fa-user-circle"></i>
                <span>{{ Auth::user()->name }}</span>
                @if(Auth::user()->email === 'admin@bpbd.com')
                    <span class="badge role-badge bg-light text-dark">Admin</span>
                @else
                    <span class="badge role-badge bg-secondary">User</span>
                @endif
            </div>
        </span>
        
        <!-- Form Logout yang Diperbaiki -->
        <form method="POST" action="{{ route('logout') }}" class="d-inline" id="logoutForm">
            @csrf
            <!-- Tambahkan method field untuk memastikan method POST -->
            @method('POST')
            <button type="submit" class="btn btn-outline-light btn-sm">
                <i class="fas fa-sign-out-alt me-1"></i>
                Logout
            </button>
        </form>
    </div>
</div>
            </div>
        </div>
    </nav>

    <!-- MAIN LAYOUT -->
    <div class="container-fluid flex-grow-1">
        <div class="row h-100">
            <!-- SIDEBAR -->
            <div class="col-md-3 col-lg-2 sidebar d-none d-md-block p-0">
                <div class="sidebar-content">
                    <!-- Data Entry Section -->
                    <div class="nav-section">
                        <div class="section-title">Data Entry</div>
                        <div class="nav-links">
                            <a class="nav-link-custom {{ request()->routeIs('users.*') ? 'active' : '' }}" 
                               href="{{ route('users.index') }}">
                                <i class="fas fa-users"></i>
                                <span>Nama Pengguna</span>
                            </a>
                            <a class="nav-link-custom {{ request()->routeIs('barang.*') ? 'active' : '' }}" 
                               href="{{ route('barang.index') }}">
                                <i class="fas fa-box"></i>
                                <span>Kartu Barang</span>
                            </a>
                            <a class="nav-link-custom {{ request()->routeIs('barang-masuk.*') ? 'active' : '' }}" 
                               href="{{ route('barang-masuk.index') }}">
                                <i class="fas fa-arrow-down"></i>
                                <span>Barang Masuk</span>
                            </a>
                            <a class="nav-link-custom {{ request()->routeIs('barang-keluar.*') ? 'active' : '' }}" 
                            href="{{ route('barang-keluar.index') }}">
                            <i class="fas fa-arrow-up"></i>
                            <span>Barang Keluar</span>
                        </a>
                    </div>
                </div>
                    
                   
                    
                  <!-- Laporan Section -->
@if(Auth::user()->email === 'admin@bpbd.com')
<div class="nav-section">
    <div class="section-title">Laporan</div>
    <div class="nav-links">
        <a class="nav-link-custom {{ request()->routeIs('laporan.saldo-awal') ? 'active' : '' }}" 
           href="{{ route('laporan.saldo-awal') }}">
            <i class="fas fa-file-alt"></i>
            <span>Saldo Awal</span>
        </a>

        <a class="nav-link-custom {{ request()->routeIs('laporan.rekap-masuk') ? 'active' : '' }}" 
           href="{{ route('laporan.rekap-masuk') }}">
            <i class="fas fa-file-import"></i>
            <span>Rekap Masuk</span>
        </a>

        <a class="nav-link-custom {{ request()->routeIs('laporan.rekap-keluar') ? 'active' : '' }}" 
           href="{{ route('laporan.rekap-keluar') }}">
            <i class="fas fa-file-export"></i>
            <span>Rekap Keluar</span>
        </a>

        @php
            $laporanBAPenyerahanRouteExists = Route::has('laporan.ba-penyerahan');
        @endphp

        <a class="nav-link-custom {{ $laporanBAPenyerahanRouteExists && request()->routeIs('laporan.ba-penyerahan') ? 'active' : '' }} {{ !$laporanBAPenyerahanRouteExists ? 'disabled' : '' }}" 
           href="{{ $laporanBAPenyerahanRouteExists ? route('laporan.ba-penyerahan') : '#' }}"
           @if(!$laporanBAPenyerahanRouteExists) onclick="return false;" @endif>
            <i class="fas fa-file-invoice"></i>
            <span>B.A Penyerahan</span>
            @if(!$laporanBAPenyerahanRouteExists)
                <small class="ms-1">(Segera)</small>
            @endif
        </a>
    </div>
</div>
@endif

                </div>
            </div>
            
            <!-- MAIN CONTENT -->
            <main class="col-md-9 ms-sm-auto col-lg-10 main-content p-0">
                <div class="content-container">
                    <!-- Page Header -->
                    <div class="page-header">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                            <h1 class="page-title">
                                @yield('icon', '<i class="fas fa-home"></i>')
                                @yield('title', 'Dashboard')
                            </h1>
                            <div class="header-actions">
                                @yield('actions')
                            </div>
                        </div>
                    </div>
                    
                    <!-- Alert Messages -->
                    @if(session('success'))
                    <div class="alert alert-success alert-custom alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-custom alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Content Area -->
                    <div class="content-body">
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="footer-bpbd">
        <div class="container-fluid px-3">
            <div class="footer-content">
                <p class="footer-text">
                    <i class="fas fa-copyright"></i>
                    2024 BPBD BARANG- Sistem Informasi Persediaan Barang
                </p>
                <p class="footer-text">
                    <i class="fas fa-user"></i>{{ Auth::user()->name }}
                    | <i class="fas fa-clock"></i>{{ now()->format('d/m/Y H:i') }}
                </p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>