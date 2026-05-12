<!DOCTYPE html>
<html lang='id'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>KoperasiKu - @yield('title')</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background: #F0F4F8; }
        .topbar { background: #fff; border-bottom: 1px solid #ddd;
                  padding: 0 24px; height: 56px; display: flex;
                  align-items: center; justify-content: space-between; }
        .topbar .brand { font-weight: 800; font-size: 18px; color: #1565C0; }
        .btn-logout { padding: 6px 14px; background: #FFEBEE;
                     color: #C62828; border: 1px solid #FFCDD2;
                     border-radius: 6px; cursor: pointer; font-size: 13px; }
        .content { max-width: 700px; margin: 0 auto; padding: 24px; }
        .alert-success { background: #E8F5E9; color: #2E7D32;
                        border: 1px solid #C8E6C9; padding: 10px 14px;
                        border-radius: 8px; margin-bottom: 16px; }
        .alert-error { background: #FFEBEE; color: #C62828;
                      border: 1px solid #FFCDD2; padding: 10px 14px;
                      border-radius: 8px; margin-bottom: 16px; }
    </style>
    @yield('styles')
</head>
<body>
    <div class='topbar'>
        <div class='brand'>&#127970; KoperasiKu</div>
        <div>
            <span style='font-size:13px; margin-right:12px'>
                {{ Session::get('user_nama') }}</span>
            <form method='POST' action='{{ route("logout") }}' style='display:inline'>
                @csrf
                <button class='btn-logout' type='submit'>Keluar</button>
            </form>
        </div>
    </div>
    <div class='content'>
        @if(session('success'))
            <div class='alert-success'>{{ session('success') }}</div>
        @endif
        @yield('content')
    </div>
</body>
</html>
