<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Register</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>

        body{
            background:#f5f5f5;
        }

        .register-box{
            max-width:400px;
            margin:40px auto;
        }

    </style>

</head>
<body>

<div class="container">

    <div class="card register-box shadow-sm">

        <div class="card-header">
            Register
        </div>

        <div class="card-body">

            @if($errors->any())

                <div class="alert alert-danger">

                    @foreach($errors->all() as $error)

                        <div>
                            {{ $error }}
                        </div>

                    @endforeach

                </div>

            @endif

            <form action="{{ route('register.store') }}"
                  method="POST">

                @csrf

                <div class="mb-3">

                    <label>
                        Nama Lengkap
                    </label>

                    <input type="text"
                           name="name"
                           class="form-control"
                           required>

                </div>

                <div class="mb-3">

                    <label>
                        Username
                    </label>

                    <input type="text"
                           name="username"
                           class="form-control"
                           required>

                </div>

                <div class="mb-3">

                    <label>
                        Password
                    </label>

                    <input type="password"
                           name="password"
                           class="form-control"
                           required>

                </div>

                <div class="mb-3">

                    <label>
                        Konfirmasi Password
                    </label>

                    <input type="password"
                           name="password_confirmation"
                           class="form-control"
                           required>

                </div>

                <button class="btn btn-success w-100">
                    Daftar
                </button>

            </form>

            <div class="text-center mt-3">

                Sudah punya akun?

                <a href="{{ route('login') }}">
                    Login di sini
                </a>

            </div>

        </div>

    </div>

</div>

</body>
</html>