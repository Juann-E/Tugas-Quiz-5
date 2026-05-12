{{-- resources/views/layouts/koperasi.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Koperasi Simpan Pinjam')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('/images/background.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        .navbar {
            background-color: #1565C0 !important;
        }
        .content-wrapper {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
        }
        .saldo-card {
            background: linear-gradient(135deg, #b733ec, #1565C0);
            color: white;
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            margin-bottom: 20px;
            border: none !important;
        }
        .saldo-card .label  { 
            font-size: 1rem; 
            font-weight: 600; 
            letter-spacing: 1px; 
        }
        .saldo-card .amount { 
            font-size: 2.5rem; 
            font-weight: 700; 
        }
        .card-form {
            background: #ffffff !important;
            border: none !important;
            border-radius: 12px !important;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1) !important;
            overflow: hidden;
        }
        .table {
            background: transparent !important;
            border: none !important;
            margin-bottom: 0 !important;
        }
        .table > :not(caption) > * > * {
            background: transparent !important;
            border-bottom: 1px solid #f0f0f0 !important; 
            border-left: none !important;
            border-right: none !important;
            border-top: none !important;
        }
        .table thead th {
            border-bottom: 2px solid #e8e8e8 !important;
            border-top: none !important;
            font-weight: 600;
            color: #333;
        }
        .table tbody tr:last-child td {
            border-bottom: none !important;
        }
        .btn-tabung { 
            background-color: #4CAF50; 
            color: white; 
            border: none; 
            border-radius: 8px; 
            padding: 12px; 
            font-weight: 600; 
        }
        .btn-ambil  { 
            background-color: #F44336; 
            color: white; 
            border: none; 
            border-radius: 8px; 
            padding: 12px; 
            font-weight: 600; 
        }
        .btn-pinjam { 
            background-color: #FF9800; 
            color: white; 
            border: none; 
            border-radius: 8px; 
            padding: 12px; 
            font-weight: 600; 
        }
        .btn-bayar  { 
            background-color: #00BCD4; 
            color: white; 
            border: none; 
            border-radius: 8px;
            padding: 12px; 
            font-weight: 600; 
        }
        .btn-tabung:hover { 
            background-color: #388E3C;
            color: white; 
        }
        .btn-ambil:hover  { 
            background-color: #C62828; 
            color: white; 
        }
        .btn-pinjam:hover { 
            background-color: #E65100; 
            color: white; 
        }
        .btn-bayar:hover  { 
            background-color: #00838F; 
            color: white; 
        }
        .action-grid { 
            display: grid; 
            grid-template-columns: repeat(4, 1fr); 
            gap: 10px; 
            margin-bottom: 20px; 
        }
        @media (max-width: 576px) { .action-grid { grid-template-columns: repeat(2, 1fr); } }
        .badge-active { 
            background-color: #FF9800; 
            color: white; 
            padding: 4px 10px; 
            border-radius: 20px; 
            font-size: 0.8rem; 
        }
        .badge-lunas  { 
            background-color: #4CAF50; 
            color: white; 
            padding: 4px 10px; 
            border-radius: 20px; 
            font-size: 0.8rem; 
        }
        .navbar-brand { 
            font-weight: 700; 
            font-size: 1.2rem; 
        }
        .alert-success {
            background: #d1e7dd !important;
            border: 1px solid #a3cfbb !important;
            color: #0a3622 !important;
            backdrop-filter: none !important;
        }
        .alert-danger {
            background: #f8d7da !important;
            border: 1px solid #f1aeb5 !important;
            color: #58151c !important;
            backdrop-filter: none !important;
        }
        .form-control, .form-select {
            background: rgba(255, 255, 255, 0.85) !important;
            border: 1px solid #ddd !important;
        }
        .form-control:focus, .form-select:focus {
            background: #ffffff !important;
            border-color: #1565C0 !important;
            box-shadow: 0 0 0 0.2rem rgba(21, 101, 192, 0.2);
        }
    </style>
</head>
<body>

@auth
<nav class="navbar navbar-dark" style="background-color: #1565C0;">
    <div class="container">
        <span class="navbar-brand">BANK CENTRAL SALATIGA</span>
        <div class="d-flex align-items-center gap-3">
            <span class="text-white small">Halo, <strong>{{ Auth::user()->name }}</strong></span>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
            </form>
        </div>
    </div>
</nav>
@endauth

<div class="container py-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="content-wrapper">
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>