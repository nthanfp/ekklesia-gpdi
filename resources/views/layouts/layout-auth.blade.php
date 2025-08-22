<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Ekklesia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #1E3A8A;
            --primary-light: #3B82F6;
            --dark: #1a1a2e;
            --white: #ffffff;
            --light: #f9f9f9;
            --gray: #6c757d;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: var(--dark);
            margin: 0;
            padding: 20px;
        }

        .auth-card {
            width: 100%;
            max-width: 450px;
            border-radius: 0.75rem;
            border: none;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .auth-card .card-header {
            background-color: var(--white);
            border-bottom: none;
            padding: 1.5rem;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .text-content {
            flex: 1;
        }

        .logo-container {
            display: flex;
            flex-direction: column;
            gap: 5px;
            text-align: left;
        }

        .auth-card h2 {
            font-size: 1.75rem;
            font-weight: 600;
            margin: 0;
            color: var(--primary);
            text-align: left;
        }

        .auth-card .subtitle {
            color: var(--gray);
            margin: 0;
            text-align: left;
            font-size: 0.9rem;
        }

        .logo-content {
            margin-left: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .gpdi-logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #1E3A8A, #3B82F6);
            border-radius: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            box-shadow: 0 4px 10px rgba(30, 58, 138, 0.3);
            padding: 5px;
            text-align: center;
            line-height: 1;
        }

        .gpdi-logo .top-text {
            font-size: 12px;
            margin-bottom: 2px;
        }

        .gpdi-logo .middle-text {
            font-size: 14px;
            margin-bottom: 2px;
        }

        .gpdi-logo .bottom-text {
            font-size: 10px;
        }

        .card-body {
            padding: 2rem;
            background-color: var(--light);
        }

        .form-control {
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            border: 1px solid #ced4da;
        }

        .form-control:focus {
            border-color: var(--primary-light);
            box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.25);
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: var(--dark);
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            padding: 0.75rem;
            font-weight: 600;
            border-radius: 0.5rem;
            transition: background-color 0.2s ease;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: #1c347d;
            border-color: #1c347d;
        }

        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .extra-links {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.9rem;
        }

        .extra-links a {
            color: var(--primary);
            text-decoration: none;
        }

        .extra-links a:hover {
            text-decoration: underline;
        }

        .alert {
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
        }
        
        .img-logo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 4px 10px rgba(30, 58, 138, 0.3);
        }
        
        .logo-fallback {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #1E3A8A, #3B82F6);
            border-radius: 50%;
            color: white;
            font-weight: bold;
            box-shadow: 0 4px 10px rgba(30, 58, 138, 0.3);
            padding: 5px;
            text-align: center;
            line-height: 1;
        }
        
        .logo-fallback .top-text {
            font-size: 12px;
            margin-bottom: 2px;
        }
        
        .logo-fallback .middle-text {
            font-size: 14px;
            margin-bottom: 2px;
        }
        
        .logo-fallback .bottom-text {
            font-size: 10px;
        }

        @media (max-width: 500px) {
            .header-container {
                flex-direction: column;
                text-align: center;
            }
            
            .logo-content {
                margin-left: 0;
                margin-top: 15px;
            }
            
            .logo-container {
                text-align: center;
            }
            
            .auth-card h2,
            .auth-card .subtitle {
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="card auth-card">
        <div class="card-header">
            <div class="header-container">
                <div class="text-content">
                    <div class="logo-container">
                        <h2>Ekklesia</h2>
                        <p class="subtitle">Aplikasi Data Jemaat GPdl Kopo Permai</p>
                    </div>
                </div>
                <div class="logo-content">
                    <!-- Opsi 1: path  -->
                    <img src="/images/gpdi-logo.png" alt="Logo GPDI" class="img-logo" onerror="this.style.display='none'; document.getElementById('logo-fallback').style.display='flex';">
                    
                    <!-- Opsi 2: Fallback jika gambar tidak ditemukan -->
                    <div id="logo-fallback" class="logo-fallback">
                        <div class="top-text">GREAT</div>
                        <div class="middle-text">PENIEL</div>
                        <div class="bottom-text">di INDONESIA</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('auth.login.submit') }}">
                @csrf

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="mb-3">
                    <label for="email" class="form-label fw-medium">Alamat Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                        value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-medium">Kata Sandi</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                        name="password" required>
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember"
                        {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">Ingat Saya</label>
                </div>

                <button type="submit" class="btn btn-primary w-100">Masuk</button>
            </form>

            <div class="extra-links mt-3">
                <a href="#">Lupa Kata Sandi?</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        
        document.getElementById('logo-fallback').style.display = 'none';

    </script>
</body>
</html>