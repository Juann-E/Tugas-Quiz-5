<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>

        body{
            background:#f5f5f5;
        }

        .login-box{
            max-width:400px;
            margin:50px auto;
        }

    </style>

</head>
<body>

<div class="container">

    <div class="card login-box shadow-sm">

        <div class="card-header">
            Login
        </div>

        <div class="card-body">

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

            <form action="{{ route('login.process') }}"
                  method="POST">

                @csrf

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

                <button class="btn btn-primary w-100">
                    Login
                </button>

            </form>

            <div class="text-center mt-3">

                Belum punya akun?

                <a href="{{ route('register') }}">
                    Register di sini
                </a>

            </div>

        </div>

    </div>

</div>

</body>
</html>