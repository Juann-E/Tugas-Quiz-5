{{-- resources/views/auth/register.blade.php --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Pinjam Petir</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: flex-start;   /* ← ubah dari center */
            overflow-y: auto;          /* ← ubah dari hidden */
            padding: 40px 0;           /* ← beri ruang atas bawah */
        }   

        .bg-blur-1{

            position:absolute;

            width:320px;
            height:320px;

            background:#1d4ed8;

            filter:blur(140px);

            opacity:.18;

            top:-80px;
            left:-60px;
        }

        .bg-blur-2{

            position:absolute;

            width:280px;
            height:280px;

            background:#facc15;

            filter:blur(140px);

            opacity:.08;

            bottom:-80px;
            right:-50px;
        }

        .register-card {
            width: 100%;
            /* Diubah dari 460px ke 380px agar lebih ramping */
            max-width: 380px; 
            
            /* Warna Deep Slate sesuai gambar */
            background: #333c4d; 
            
            /* Hapus backdrop-filter jika ingin warna solid seperti gambar */
            backdrop-filter: none; 
            
            border: 1px solid rgba(255,255,255,.05);
            border-radius: 28px;
            
            /* Padding diperkecil agar tidak terlalu memakan ruang */
            padding: 30px; 
            
            position: relative;
            z-index: 10;
            box-shadow: 0 20px 50px rgba(0,0,0,.3);
        }

        .logo-box{

            width:78px;
            height:78px;

            border-radius:24px;

            background:
            rgba(250,204,21,.12);

            display:flex;
            justify-content:center;
            align-items:center;

            margin:auto auto 25px;

            font-size:2rem;
        }

        .title{

            text-align:center;

            color:white;

            font-size:2rem;

            font-weight:700;

            margin-bottom:8px;
        }

        .subtitle{

            text-align:center;

            color:#94a3b8;

            margin-bottom:35px;

            font-size:.95rem;
        }

        .form-label{
            color:#e2e8f0;
            font-weight:500;
            margin-bottom:10px;
        }

        .form-control {
            height: 48px; /* Diubah dari 56px */
            background: #1e293b;
            border: 1px solid rgba(255,255,255,.05);
            border-radius: 12px;
            color: white;
            padding: 0 15px;
        }

        .form-control:focus{

            background:#0f172a;

            color:white;

            border-color:#facc15;

            box-shadow:
            0 0 0 .15rem rgba(250,204,21,.15);
        }

        .form-control::placeholder{
            color:#64748b;
        }

        .btn-register {
            height: 48px; /* Diubah dari 56px */
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, #facc15, #eab308);
            color: #111827;
            font-weight: 700;
            margin-top: 10px;
        }

        .btn-register:hover{

            transform:translateY(-2px);

            opacity:.95;
        }

        .bottom-text{

            text-align:center;

            color:#94a3b8;

            margin-top:25px;

            font-size:.95rem;
        }

        .bottom-text a{

            color:#facc15;

            text-decoration:none;

            font-weight:600;
        }

        @media(max-width:576px){

            .register-card{
                margin:20px;
                padding:32px 24px;
            }

            .title{
                font-size:1.7rem;
            }

        }

    </style>

</head>
<body>

<div class="bg-blur-1"></div>
<div class="bg-blur-2"></div>

<div class="register-card">

    <div class="logo-box">
        🏦
    </div>

    <div class="title">
        Pinjam Petir
    </div>

    <div class="subtitle">
        Buat akun baru
    </div>

    <form action="{{ route('register.post') }}"
          method="POST">

        @csrf

        <div class="mb-3">

            <label class="form-label">
                Nama Lengkap
            </label>

            <input type="text"
                   name="name"
                   class="form-control"
                   placeholder="Masukkan nama lengkap">

        </div>

        <div class="mb-3">

            <label class="form-label">
                Username
            </label>

            <input type="text"
                   name="username"
                   class="form-control"
                   placeholder="Masukkan username">

        </div>

        <div class="mb-3">

            <label class="form-label">
                Password
            </label>

            <input type="password"
                   name="password"
                   class="form-control"
                   placeholder="Masukkan password">

        </div>

        <div class="mb-4">

            <label class="form-label">
                Konfirmasi Password
            </label>

            <input type="password"
                   name="password_confirmation"
                   class="form-control"
                   placeholder="Ulangi password">

        </div>

        <button type="submit"
                class="btn btn-register w-100">

            Daftar

        </button>

    </form>

    <div class="bottom-text">

        Sudah punya akun?
        <a href="{{ route('login') }}">
            Login
        </a>

    </div>

</div>

</body>
</html>