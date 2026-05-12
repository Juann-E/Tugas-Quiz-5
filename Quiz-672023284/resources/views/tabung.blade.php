<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Tabung Uang</title>

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
            margin-bottom:40px;
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
        }

        .form-control{
            background:white;
            color:black;
            border:1px solid #ced4da;
            padding:12px;
        }

        .form-control:focus{
            box-shadow:none;
            border-color:#0d6efd;
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

                    Tabung Uang

                </div>

                <div class="card-body p-4">

                    <form action="/tabung"
                          method="POST">

                        @csrf

                        <div class="mb-4">

                            <label class="mb-2">

                                Jumlah Tabungan (Rp)

                            </label>

                            <input type="number"
                                   name="nominal"
                                   class="form-control form-control-lg"
                                   required>

                        </div>

                        <button class="btn btn-success w-100 mb-2">

                            Simpan Tabungan

                        </button>

                        <a href="/dashboard"
                           class="btn btn-secondary w-100">

                            Kembali

                        </a>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>