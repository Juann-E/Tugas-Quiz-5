<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Bayar Pinjaman</title>

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
            background:#e7f1ff;
            border:1px solid #cfe2ff;
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

                    Bayar Pinjaman

                </div>

                <div class="card-body p-4">

                    <div class="info-box">

                        Pilih pinjaman yang ingin dibayar
                        kemudian masukkan nominal pembayaran.

                    </div>

                    <form action="/bayar"
                          method="POST">

                        @csrf

                        <div class="mb-3">

                            <label class="mb-2">

                                Pilih Pinjaman

                            </label>

                            <select name="pinjaman_id"
                                    class="form-control"
                                    required>

                                @foreach($pinjamans as $pinjaman)

                                    <option value="{{ $pinjaman->id }}">

                                        Pinjaman #{{ $pinjaman->id }}
                                        -
                                        Sisa:
                                        Rp {{ number_format($pinjaman->sisa) }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                        <div class="mb-4">

                            <label class="mb-2">

                                Nominal Pembayaran

                            </label>

                            <input type="number"
                                   name="nominal_bayar"
                                   class="form-control form-control-lg"
                                   placeholder="Masukkan nominal pembayaran"
                                   required>

                        </div>

                        <button class="btn btn-info text-white w-100 mb-2">

                            Bayar Sekarang

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