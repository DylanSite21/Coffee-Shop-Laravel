<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Coffee Shop</title>
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #1a0f0a 0%, #2c1810 50%, #3d241a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .auth-card {
            background: white;
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 420px;
            margin: 0 auto;
        }
        .auth-card .brand {
            text-align: center;
            font-size: 28px;
            font-weight: 800;
            color: #1a0f0a;
        }
        .auth-card .brand span {
            color: #d4a24e;
        }
        .auth-card .subtitle {
            text-align: center;
            color: #8d6e63;
            margin-bottom: 30px;
        }
        .auth-card .form-control {
            padding: 12px 16px;
            border-radius: 12px;
            border: 2px solid #e8ddd6;
        }
        .auth-card .form-control:focus {
            border-color: #d4a24e;
            box-shadow: 0 0 0 3px rgba(212, 162, 78, 0.1);
        }
        .btn-coffee {
            background: linear-gradient(135deg, #d4a24e, #b8860b);
            color: white;
            border: none;
            padding: 14px;
            border-radius: 12px;
            font-weight: 700;
            width: 100%;
            transition: all 0.3s;
        }
        .btn-coffee:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(212, 162, 78, 0.3);
            color: white;
        }
        .auth-link {
            text-align: center;
            margin-top: 20px;
            color: #8d6e63;
        }
        .auth-link a {
            color: #d4a24e;
            font-weight: 600;
            text-decoration: none;
        }
        .auth-link a:hover {
            text-decoration: underline;
        }
        .alert-custom {
            border-radius: 12px;
            padding: 12px 16px;
        }
        .form-check-input:checked {
            background-color: #d4a24e;
            border-color: #d4a24e;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="auth-card">
            <div class="brand">
                ☕ Coffee<span>Shop</span>
            </div>
            <p class="subtitle">Login untuk memesan kopi favoritmu</p>

            <!-- Alert Success -->
            @if(session('success'))
                <div class="alert alert-success alert-custom">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <!-- Alert Error -->
            @if($errors->any())
                <div class="alert alert-danger alert-custom">
                    <i class="bi bi-exclamation-circle"></i>
                    @foreach($errors->all() as $error)
                        <p class="mb-0">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <input type="email" 
                               name="email" 
                               class="form-control" 
                               placeholder="Masukkan email" 
                               value="{{ old('email') }}" 
                               required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input type="password" 
                               name="password" 
                               class="form-control" 
                               placeholder="Masukkan password" 
                               required>
                    </div>
                </div>

                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <div class="form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember">Ingat saya</label>
                    </div>
                </div>

                <button type="submit" class="btn-coffee">
                    <i class="bi bi-box-arrow-in-right"></i> Login
                </button>
            </form>

            <p class="auth-link">
                Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a>
            </p>
            
            <p class="text-center text-muted small mt-3">
                <a href="{{ route('home') }}" class="text-decoration-none text-muted">
                    <i class="bi bi-arrow-left"></i> Kembali ke Home
                </a>
            </p>
        </div>
    </div>
</body>
</html>