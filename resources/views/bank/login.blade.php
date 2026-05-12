<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MyBank</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; }
        .bg-image-side {
            background-image: url('https://images.unsplash.com/photo-1550439062-609e1531270e?q=80&w=2560&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            position: relative;
        }
        .bg-overlay {
            position: absolute; top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(135deg, rgba(13, 110, 253, 0.85), rgba(15, 23, 42, 0.95));
            z-index: 1;
        }
        .content-overlay { z-index: 2; position: relative; }
        .icon-box {
            width: 80px; height: 80px;
            background-color: rgba(255, 255, 255, 0.15); backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 20px;
            display: inline-flex; align-items: center; justify-content: center;
        }
        .form-control:focus { border-color: #0d6efd; box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25); }
        .btn-brand { background: linear-gradient(to right, #0d6efd, #0dcaf0); border: none; color: white; transition: all 0.3s ease; }
        .btn-brand:hover { background: linear-gradient(to right, #0b5ed7, #0bacbe); color: white; transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(13, 110, 253, 0.3); }
        .text-brand { color: #0d6efd; }
        .text-brand:hover { color: #0b5ed7; }
    </style>
</head>
<body>
    <div class="container-fluid vh-100 p-0">
        <div class="row g-0 h-100">
            <div class="col-lg-6 d-none d-lg-flex bg-image-side align-items-center justify-content-center">
                <div class="bg-overlay"></div>
                <div class="content-overlay text-center text-white px-5" style="max-width: 600px;">
                    <div class="icon-box mb-4 shadow-sm">
                        <i class="bi bi-bank2 fs-1"></i>
                    </div>
                    <h1 class="display-4 fw-bolder mb-4">Welcome to MyBank</h1>
                    <p class="lead text-white-50 fs-5">
                        Experience seamless integration and manage your finances efficiently. Sign in to continue your journey with us.
                    </p>
                </div>
            </div>

            <div class="col-lg-6 d-flex align-items-center justify-content-center p-4 p-sm-5 bg-white">
                <div class="w-100" style="max-width: 420px;">
                    <div class="mb-5 text-center text-lg-start">
                        <h2 class="fw-bolder text-dark fs-1 mb-2">Sign In</h2>
                        <p class="text-secondary">Please enter your credentials to access your account.</p>
                    </div>

                    @if(session('error'))
                    <div class="alert alert-danger d-flex align-items-center rounded-4 border-0 bg-danger bg-opacity-10 text-danger shadow-sm mb-4" role="alert">
                        <i class="bi bi-exclamation-octagon-fill me-3 fs-5"></i>
                        <div class="fw-semibold small">
                            {{ session('error') }}
                        </div>
                    </div>
                    @endif

                    <form action="{{ url('/login') }}" method="POST">
                        @csrf
                        <div class="form-floating mb-4">
                            <input type="text" class="form-control rounded-4 bg-light border-0 px-4 fw-medium" id="username" name="username" placeholder="Username" required>
                            <label for="username" class="text-secondary px-4">Username</label>
                        </div>

                        <div class="form-floating mb-3 position-relative">
                            <input type="password" class="form-control rounded-4 bg-light border-0 px-4 fw-medium" id="password" name="password" placeholder="Password" required>
                            <label for="password" class="text-secondary px-4">Password</label>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4 px-1">
                            <div class="form-check">
                                <input class="form-check-input border-secondary" type="checkbox" id="remember-me" name="remember-me">
                                <label class="form-check-label text-secondary small user-select-none" for="remember-me">
                                    Remember me
                                </label>
                            </div>
                            <a href="#" class="text-decoration-none small fw-bold text-brand">Forgot password?</a>
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="btn btn-brand w-100 py-3 rounded-4 fw-bold fs-6 d-flex justify-content-center align-items-center gap-2">
                                Submit Login
                                <i class="bi bi-box-arrow-in-right fs-5"></i>
                            </button>
                        </div>
                    </form>

                    <div class="mt-5 pt-4 border-top text-center d-flex justify-content-center align-items-center gap-2">
                        <span class="text-secondary small">Belum punya akun?</span>
                        <a href="{{ url('/register') }}" class="text-decoration-none small fw-bold text-brand d-inline-flex align-items-center">
                            Register disini <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>