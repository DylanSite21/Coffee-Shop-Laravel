<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - Coffee Shop</title>
    
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
            padding: 20px 0;
        }
        .auth-card {
            background: white;
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 460px;
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
        .auth-card .form-control.is-invalid {
            border-color: #dc3545;
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
        .password-requirements {
            font-size: 12px;
            color: #8d6e63;
            margin-top: 4px;
        }
        .password-requirements .valid {
            color: #28a745;
        }
        .password-requirements .invalid {
            color: #dc3545;
        }
        .input-group-text {
            background: #f8f4f0;
            border: 2px solid #e8ddd6;
            border-right: none;
        }
        .input-group .form-control {
            border-left: none;
        }
        .input-group .form-control:focus {
            border-color: #d4a24e;
        }
        .input-group:focus-within .input-group-text {
            border-color: #d4a24e;
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
            <p class="subtitle">Buat akun baru untuk mulai memesan</p>

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
                    <ul class="mb-0 mt-1 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <!-- Name -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Lengkap</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-person"></i>
                        </span>
                        <input type="text" 
                               name="name" 
                               class="form-control @error('name') is-invalid @enderror" 
                               placeholder="Masukkan nama lengkap" 
                               value="{{ old('name') }}" 
                               required>
                    </div>
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Email</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <input type="email" 
                               name="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               placeholder="Masukkan email" 
                               value="{{ old('email') }}" 
                               required>
                    </div>
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Password</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input type="password" 
                               name="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               placeholder="Minimal 6 karakter" 
                               id="password"
                               required>
                    </div>
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    <div class="password-requirements mt-1">
                        <span id="password-length" class="invalid">● Minimal 6 karakter</span>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Konfirmasi Password</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-lock-fill"></i>
                        </span>
                        <input type="password" 
                               name="password_confirmation" 
                               class="form-control @error('password') is-invalid @enderror" 
                               placeholder="Ulangi password" 
                               required>
                    </div>
                </div>

                <!-- Terms -->
                <div class="mb-3 form-check">
                    <input type="checkbox" 
                           name="terms" 
                           class="form-check-input @error('terms') is-invalid @enderror" 
                           id="terms" 
                           value="1"
                           {{ old('terms') ? 'checked' : '' }}>
                    <label class="form-check-label" for="terms">
                        Saya setuju dengan <a href="#" class="text-decoration-none" style="color:#d4a24e;">Syarat & Ketentuan</a>
                    </label>
                    @error('terms')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-coffee">
                    <i class="bi bi-person-plus"></i> Daftar
                </button>
            </form>

            <p class="auth-link">
                Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
            </p>
            
            <p class="text-center text-muted small mt-3">
                <a href="{{ route('home') }}" class="text-decoration-none text-muted">
                    <i class="bi bi-arrow-left"></i> Kembali ke Home
                </a>
            </p>
        </div>
    </div>

    <script>
        // Password validation real-time
        document.getElementById('password').addEventListener('input', function() {
            const length = this.value.length;
            const lengthIndicator = document.getElementById('password-length');
            
            if (length >= 6) {
                lengthIndicator.className = 'valid';
                lengthIndicator.textContent = '✅ Minimal 6 karakter';
            } else {
                lengthIndicator.className = 'invalid';
                lengthIndicator.textContent = '● Minimal 6 karakter';
            }
        });
    </script>
</body>
</html>