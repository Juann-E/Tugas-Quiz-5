{{-- resources/views/auth/login.blade.php --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Pinjam Petir</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            min-height:100vh;
            /* Background abu-abu terang kebiruan seperti di gambar */
            background: #f8fafc; 
            font-family:'Segoe UI',sans-serif;
            display:flex;
            justify-content:center;
            align-items:center;
        }

        /* Kita hapus atau sembunyikan dekorasi blur karena di gambar terlihat clean */
        .bg-blur-1, .bg-blur-2 { display: none; }

        .login-card{
            width:100%;
            max-width:400px;
            /* Warna Biru Tua Keabuan (Deep Slate) sesuai gambar */
            background: #333c4d; 
            border-radius:28px;
            padding:40px;
            position:relative;
            z-index:10;
            box-shadow: 0 10px 25px rgba(0,0,0,.1);
        }

        .logo-box{
            width:60px;
            height:60px;
            border-radius:18px;
            /* Background icon yang sedikit lebih terang dari card */
            background: rgba(255,255,255,.1);
            display:flex;
            justify-content:center;
            align-items:center;
            margin:0 auto 20px;
            font-size:1.5rem;
        }

        .title{
            text-align:center;
            color:white;
            font-size:1.8rem;
            font-weight:700;
            margin-bottom:5px;
        }

        .subtitle{
            text-align:center;
            color:#cbd5e1;
            margin-bottom:30px;
            font-size:.9rem;
        }

        .form-label{
            color:#e2e8f0;
            font-weight:500;
            margin-bottom:8px;
            font-size: 0.95rem;
        }

        .form-control{
            height:50px;
            /* Input field lebih gelap (Navy Dark) */
            background:#1e293b; 
            border: 1px solid rgba(255,255,255,.05);
            border-radius:12px;
            color:white;
            padding:0 15px;
        }

        .form-control:focus{
            background:#1e293b;
            color:white;
            border-color:#64748b;
            box-shadow: none;
        }

        .form-control::placeholder{
            color:#64748b;
        }

        .btn-login{
            height: 50px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, #facc15, #eab308);
            color: #111827;
            font-weight: 700;
            margin-top: 10px;
        }

        .btn-login:hover{
            background: #0f172a;
            transform:translateY(-1px);
            color: white;
        }

        .bottom-text{
            text-align:center;
            color:#94a3b8;
            margin-top:25px;
            font-size:.9rem;
        }

        .bottom-text a{
            color:#ffffff;
            text-decoration:none;
            font-weight:600;
        }

        @media(max-width:576px){
            .login-card{
                margin:20px;
                padding:30px 20px;
            }
        }
    </style>

</head>
<body>

<div class="bg-blur-1"></div>
<div class="bg-blur-2"></div>

<div class="login-card">

    <div class="logo-box">
        🏦
    </div>

    <div class="title">
        Pinjam Petir
    </div>

    <div class="subtitle">
        Masuk ke akun Anda
    </div>

    @if(session('error'))
        <div class="alert alert-danger mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('login.post') }}"
          method="POST">

        @csrf

        <div class="mb-3">

            <label class="form-label">
                Username
            </label>

            <input type="text"
                   name="username"
                   class="form-control @error('username') is-invalid @enderror"
                   placeholder="Masukkan username"
                   value="{{ old('username') }}">

        </div>

        <div class="mb-4">

            <label class="form-label">
                Password
            </label>

            <input type="password"
                   name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   placeholder="Masukkan password">

        </div>

        <button type="submit"
                class="btn btn-login w-100">

            Login

        </button>

    </form>

    <div class="bottom-text">

        Belum punya akun?
        <a href="{{ route('register') }}">
            Daftar
        </a>

    </div>

</div>

</body>
</html>