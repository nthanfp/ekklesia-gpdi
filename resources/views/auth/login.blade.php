@extends('layouts.layout-auth')

@section('content')
    <div class="card auth-card">
        <div class="card-header">
            <div class="header-container">
                <div class="text-content">
                    <div class="logo-container">
                        <h2>Ekklesia</h2>
                        <p class="subtitle">Aplikasi Data Jemaat GPdl Kopo Permai</p>
                    </div>
                </div>
                <div class="icon-content">
                    <div class="church-icon">
                        <i class="fas fa-church"></i>
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
@endsection