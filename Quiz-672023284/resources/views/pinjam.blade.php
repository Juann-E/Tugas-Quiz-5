<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Ajukan Pinjaman</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>

        body{
            background:#f3f3f3;
            color:black;
        }

        .header-app{
            background:#000;
            color:white;
            padding:18px 25px;
            font-size:24px;
            font-weight:bold;
            margin-bottom:40px;
        }

        .card{
            background:white;
            border:none;
            border-radius:8px;
            box-shadow:0 2px 6px rgba(0,0,0,0.1);
        }

        .card-header{
            background:#111;
            color:white;
            padding:15px 20px;
            border:none;
        }

        .form-control{
            padding:12px;
        }

        .info-box{
            background:#cff4fc;
            color:#055160;
            padding:15px;
            border-radius:5px;
            margin-bottom:25px;
        }

    </style>

</head>
<body>

<div class="header-app">

    Aplikasi Simpan Pinjam

</div>

<div class="container">

    <div class="row justify-content-center">

        <div class="col-md-7">

            <div class="card">

                <div class="card-header">

                    Ajukan Pinjaman

                </div>

                <div class="card-body p-4">

                    <div class="info-box">

                        Pinjaman yang diajukan akan langsung
                        ditambahkan ke saldo Anda.

                    </div>

                    <form action="/pinjam"
                          method="POST">

                        @csrf

                        <div class="mb-4">

                            <label class="mb-2">

                                Jumlah Pinjaman (Rp)

                            </label>

                            <input type="number"
                                   name="nominal"
                                   class="form-control form-control-lg"
                                   placeholder="Masukkan jumlah pinjaman"
                                   required>

                        </div>

                        <button class="btn btn-warning w-100 mb-2">

                            Ajukan Pinjaman

                        </button>

                        <a href="/dashboard"
                           class="btn btn-secondary w-100">

                            Batal

                        </a>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>