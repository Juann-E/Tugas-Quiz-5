<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - MyBank</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f6f9; display: flex; align-items: center; min-height: 100vh; }
        .card-register { border: none; border-radius: 1.5rem; box-shadow: 0 15px 30px rgba(0,0,0,0.05); overflow: hidden; }
        .form-control:focus { border-color: #0d6efd; box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25); }
        .btn-brand { background: linear-gradient(to right, #0d6efd, #6610f2); border: none; color: white; transition: all 0.3s ease; }
        .btn-brand:hover { background: linear-gradient(to right, #0b5ed7, #520dc2); color: white; transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(13, 110, 253, 0.3); }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card card-register bg-white">
                    <div class="card-body p-5">
                        <div class="text-center mb-5">
                            <h2 class="fw-bolder text-dark mb-2">Create an account</h2>
                            <p class="text-muted">Join us and start your journey</p>
                        </div>

                        @if($errors->any())
                        <div class="alert alert-danger border-0 bg-danger bg-opacity-10 text-danger rounded-4 mb-4" role="alert">
                            <ul class="mb-0 ps-3 small fw-medium">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form action="{{ url('/register') }}" method="POST">
                            @csrf
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control rounded-4 bg-light border-0 px-4" id="name" name="name" placeholder="Full Name" value="{{ old('name') }}" required>
                                <label for="name" class="text-secondary px-4">Full Name</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control rounded-4 bg-light border-0 px-4" id="username" name="username" placeholder="Username" value="{{ old('username') }}" required>
                                <label for="username" class="text-secondary px-4">Username</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="password" class="form-control rounded-4 bg-light border-0 px-4" id="password" name="password" placeholder="Password" required>
                                <label for="password" class="text-secondary px-4">Password</label>
                            </div>

                            <div class="form-floating mb-4">
                                <input type="password" class="form-control rounded-4 bg-light border-0 px-4" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required>
                                <label for="password_confirmation" class="text-secondary px-4">Confirm Password</label>
                            </div>

                            <button type="submit" class="btn btn-brand w-100 py-3 rounded-4 fw-bold mb-4 shadow-sm">
                                Submit Register
                            </button>
                        </form>

                        <div class="text-center mb-4">
                            <span class="text-secondary small">Sudah punya akun?</span>
                            <a href="{{ url('/login') }}" class="text-decoration-none small fw-bold text-primary">Login disini</a>
                        </div>
                        
                        <hr class="text-muted opacity-25">

                        <div class="text-center mt-4">
                            <a href="{{ url('/login') }}" class="btn btn-light w-100 py-3 rounded-4 fw-bold text-primary border border-primary border-opacity-25 shadow-sm">
                                Sign in to your account
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>