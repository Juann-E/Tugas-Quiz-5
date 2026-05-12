<!DOCTYPE html>
<html>
<head>
    <title>Registrasi User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow border-0">
                <div class="card-body">
                    <h4 class="text-center font-weight-bold">REGISTER</h4>
                    <form action="{{ route('register.post') }}" method="POST">
                        @csrf
                        <div class="form-group"><label>Nama</label><input type="text" name="name" class="form-control" required></div>
                        <div class="form-group"><label>Email</label><input type="email" name="email" class="form-control" required></div>
                        <div class="form-group"><label>Password</label><input type="password" name="password" class="form-control" required></div>
                        <button type="submit" class="btn btn-success btn-block">DAFTAR SEKARANG</button>
                        <hr>
                        <p class="text-center">Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>