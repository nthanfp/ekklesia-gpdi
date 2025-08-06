<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Sistem Jemaat Ekklesia' }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

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
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: var(--dark);
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
            padding: 2rem 1.5rem 1.5rem 1.5rem;
            text-align: center;
        }

        .logo-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 12px;
            margin-bottom: 0.5rem;
        }

        .sidebar-logo {
            font-size: 2rem;
            color: var(--primary);
            display: flex;
            align-items: center;
        }

        .auth-card h2 {
            font-size: 1.75rem;
            font-weight: 600;
            margin: 0;
            color: var(--primary);
        }

        .auth-card .card-body {
            padding: 2rem 2.5rem;
            background-color: var(--light);
        }

        .form-control {
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
        }

        .form-control:focus {
            border-color: var(--primary-light);
            box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.25);
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            padding: 0.75rem;
            font-weight: 600;
            border-radius: 0.5rem;
            transition: background-color 0.2s ease;
        }

        .btn-primary:hover {
            background-color: #1c347d;
            border-color: #1c347d;
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
    </style>

    @stack('styles')
</head>

<body>

    <div class="card auth-card mt-4 mb-4">
        <div class="card-header">
            <div class="logo-container">
                <div class="sidebar-logo">
                    {{-- <i class="fas fa-church"></i> --}}
                </div>
                <h2>Ekklesia</h2>
            </div>
            <p class="text-muted mb-0">{{ $subtitle ?? 'Silakan login untuk melanjutkan.' }}</p>
        </div>

        <div class="card-body">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
