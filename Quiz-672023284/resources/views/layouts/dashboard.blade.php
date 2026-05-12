<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Aplikasi Simpan Pinjam</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>

        body{
            background:#f3f3f3;
            color:black;
        }

        .header-app{
            background:#000000;
            color:white;
            padding:18px 25px;
            font-size:24px;
            font-weight:bold;
            margin-bottom:35px;
        }

        .top-card{
            background:#0d6efd;
            color:white;
            padding:30px;
            border-radius:8px;
            text-align:center;
            box-shadow:0 2px 6px rgba(0,0,0,0.1);
        }

        .top-card small{
            font-size:16px;
        }

        .top-card h1{
            font-size:48px;
            margin-top:10px;
            font-weight:bold;
        }

        .menu-btn{
            width:100%;
            border:none;
            padding:14px;
            border-radius:6px;
            color:white;
            font-weight:bold;
            font-size:16px;
        }

        .green{
            background:#198754;
        }

        .red{
            background:#dc3545;
        }

        .yellow{
            background:#ffc107;
            color:black;
        }

        .blue{
            background:#0dcaf0;
        }

        .card{
            background:white;
            border:none;
            border-radius:8px;
            box-shadow:0 2px 6px rgba(0,0,0,0.1);
        }

        .card-header{
            background:#111111;
            color:white;
            border:none;
            padding:15px 20px;
            font-weight:bold;
        }

        .table{
            margin-bottom:0;
            background:white;
        }

        .table th{
            background:#f8f9fa;
        }

    </style>

</head>
<body>

<div class="header-app">

    Aplikasi Simpan Pinjam

</div>

<div class="container pb-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>
            Dashboard
        </h2>

        <form action="{{ route('logout') }}"
              method="POST">

            @csrf

            <button class="btn btn-danger">

                Logout

            </button>

        </form>

    </div>

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    @if(session('error'))

        <div class="alert alert-danger">

            {{ session('error') }}

        </div>

    @endif

    <div class="top-card mb-4">

        <small>

            Saldo Anda

        </small>

        <h1>

            Rp {{ number_format($saldo ?? 0) }}

        </h1>

    </div>

    <div class="row mb-4">

        <div class="col-md-3 mb-2">

            <a href="/tabung"
               class="text-decoration-none">

                <button class="menu-btn green">

                    Tabung

                </button>

            </a>

        </div>

        <div class="col-md-3 mb-2">

            <a href="/ambil"
               class="text-decoration-none">

                <button class="menu-btn red">

                    Ambil

                </button>

            </a>

        </div>

        <div class="col-md-3 mb-2">

            <a href="/pinjam"
               class="text-decoration-none">

                <button class="menu-btn yellow">

                    Pinjam

                </button>

            </a>

        </div>

        <div class="col-md-3 mb-2">

            <a href="/bayar"
               class="text-decoration-none">

                <button class="menu-btn blue">

                    Bayar Pinjaman

                </button>

            </a>

        </div>

    </div>

    @yield('content')

</div>

</body>
</html>