<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Sistem Jemaat</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Icons (Fontawesome & Bootstrap Icon) --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.13.1/font/bootstrap-icons.min.css"
        rel="stylesheet">

    {{-- Custom Styles --}}
    <style>
        :root {
            --primary: #1E3A8A;
            --primary-light: #3B82F6;
            --secondary: #f6c90e;
            --dark: #1a1a2e;
            --light: #f9f9f9;
            --success: #28a745;
            --warning: #fd7e14;
            --danger: #dc3545;
            --gray: #6c757d;
            --white: #ffffff;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            flex-direction: row;
            background-color: var(--light);
            color: var(--dark);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            width: 300px;
            background: linear-gradient(180deg, var(--primary), var(--primary-light));
            padding: 2rem 1.5rem;
            color: var(--white);
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            min-height: 100vh;
            z-index: 1000;
        }

        .sidebar.collapsed {
            width: 80px;
        }

        /* .sidebar.collapsed .sidebar-logo { */
        /* display: none; */
        /* } */

        .sidebar.collapsed .sidebar-header h2,
        .sidebar.collapsed .menu-text {
            display: none;
        }

        .sidebar.collapsed .sidebar-menu a {
            justify-content: center;
            padding: 1rem 0;
        }

        .sidebar.collapsed .menu-icon {
            margin-right: 0;
            font-size: 1.3rem;
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-header h2 {
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0;
        }

        .sidebar-logo {
            font-size: 1.8rem;
        }

        .toggle-sidebar {
            background: transparent;
            border: none;
            color: var(--white);
            font-size: 1.5rem;
            cursor: pointer;
        }

        .sidebar-menu {
            /* margin-top: 1rem; */
        }

        .sidebar-menu a {
            display: flex;
            align-items: flex-start;
            margin-bottom: 0.8rem;
            color: var(--white);
            text-decoration: none;
            font-weight: 500;
            padding: 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .sidebar-menu a:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateX(5px);
        }

        .sidebar.collapsed .sidebar-menu a:hover {
            transform: translateX(0);
        }

        .sidebar-menu a.active {
            background: rgba(255, 255, 255, 0.25);
            font-weight: 600;
        }

        .menu-icon {
            font-size: 1.2rem;
            margin-right: 15px;
            margin-top: 3px;
            min-width: 20px;
        }

        .menu-text {
            flex: 1;
        }

        .menu-title {
            font-weight: 600;
            margin-bottom: 3px;
        }

        .menu-desc {
            font-size: 0.85rem;
            opacity: 0.9;
            font-weight: 400;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 2rem;
            background-color: #f5f7fa;
            transition: margin-left 0.3s ease;
            max-width: 100%;
            /* ⬅️ Ini penting */
            overflow-x: hidden;
            /* Opsional, untuk extra safety */
        }

        .card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            margin-bottom: 1.5rem;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: white;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .card-value {
            font-size: 2.25rem;
            font-weight: 700;
            color: var(--dark);
        }

        .card-detail {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .badge-primary {
            background-color: var(--primary);
        }

        .badge-success {
            background-color: var(--secondary);
        }

        .table th {
            background-color: #f8f9fa;
            border-top: none;
        }

        .page-header {
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 1rem;
            margin-bottom: 1.5rem;
        }

        /* DESKTOP ONLY */
        @media (min-width: 992px) {
            .sidebar.collapsed .sidebar-logo {
                display: none;
            }
        }

        /* Responsive Sidebar */
        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }

            .sidebar {
                position: fixed;
                top: 0;
                left: -300px;
                height: 100%;
                transform: translateX(-100%);
                width: 300px;
                transition: transform 0.3s ease;
            }

            .sidebar.show {
                transform: translateX(0);
                left: 0;
            }

            .main-content {
                padding: 1rem;
            }

            #sidebar-overlay {
                display: none;
            }

            .sidebar.show+#sidebar-overlay {
                display: block;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.4);
                z-index: 999;
            }
        }
    </style>

    @stack('styles')

    @yield('styles')

</head>

<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <div class="logo-container">
                <div class="sidebar-logo">
                    <i class="fas fa-church"></i>
                </div>
                <h2>Ekklesia</h2>
            </div>
            <button class="toggle-sidebar d-none d-md-block" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <div class="sidebar-menu">

            <div class="dropdown">
                <a href="#"
                    class="d-flex align-items-start text-white text-decoration-none dropdown-toggle py-3 px-3"
                    id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 8px;">
                    <div class="menu-icon">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <div class="menu-text">
                        <div class="menu-title">{{ Auth::user()->name ?? 'Pengguna' }}</div>
                        <div class="menu-desc">{{ Auth::user()->email ?? '' }}</div>
                    </div>
                </a>
                <ul class="dropdown-menu shadow w-100 mt-1" aria-labelledby="userDropdown">
                    <li>
                        <form action="{{ route('auth.logout') }}" method="POST"
                            onsubmit="return confirm('Keluar dari sistem?')">
                            @csrf
                            <button class="dropdown-item d-flex align-items-center" type="submit">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>

            <hr class="my-1" style="border-color: rgba(255,255,255,0.2);">

            <a href="{{ route('dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">
                <div class="menu-icon"><i class="fas fa-chart-pie"></i></div>
                <div class="menu-text">
                    <div class="menu-title">Dashboard</div>
                    <div class="menu-desc">Statistik dan Analisis Jemaat</div>
                </div>
            </a>

            <a href="{{ route('rayons.index') }}" class="{{ request()->is('rayon*') ? 'active' : '' }}">
                <div class="menu-icon"><i class="fas fa-map"></i></div>
                <div class="menu-text">
                    <div class="menu-title">Rayon</div>
                    <div class="menu-desc">Kelompok Wilayah Jemaat</div>
                </div>
            </a>

            <a href="{{ route('kartu-keluarga.index') }}"
                class="{{ request()->is('kartu-keluarga*') ? 'active' : '' }}">
                <div class="menu-icon"><i class="fas fa-users"></i></div>
                <div class="menu-text">
                    <div class="menu-title">Kartu Keluarga</div>
                    <div class="menu-desc">Data Keluarga Jemaat</div>
                </div>
            </a>

            <a href="{{ route('jemaats.index') }}" class="{{ request()->is('jemaat*') ? 'active' : '' }}">
                <div class="menu-icon"><i class="fas fa-user-friends"></i></div>
                <div class="menu-text">
                    <div class="menu-title">Jemaat</div>
                    <div class="menu-desc">Data Individu Jemaat</div>
                </div>
            </a>

        </div>
    </div>

    <div id="sidebar-overlay" onclick="toggleMobileSidebar()"></div>

    <main class="main-content">
        <!-- Mobile Toggle Button -->
        <button class="btn btn-outline-primary d-md-none mb-3" onclick="toggleMobileSidebar()">
            <i class="fas fa-bars"></i> Menu
        </button>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">@yield('title')</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                @yield('action-buttons')
            </div>
        </div>

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('collapsed');

            if (sidebar.classList.contains('collapsed')) {
                localStorage.setItem('sidebarState', 'collapsed');
            } else {
                localStorage.setItem('sidebarState', 'expanded');
            }
        }

        function toggleMobileSidebar() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('show');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.sidebar');
            const savedState = localStorage.getItem('sidebarState');
            if (savedState === 'collapsed') {
                sidebar.classList.add('collapsed');
            }
        });
    </script>
    @stack('scripts')
    @yield('scripts')
</body>

</html>
