<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">
    <style>
        /* Sidebar Styling */
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            padding-top: 20px;
            transition: 0.3s ease-in-out;
        }
        .sidebar a {
            padding: 10px 20px;
            text-decoration: none;
            font-size: 16px;
            color: white;
            display: block;
            transition: 0.3s;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #495057;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            transition: 0.3s ease-in-out;
        }
        .logout-btn {
            width: 100%;
            text-align: left;
            background: none;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            display: block;
            transition: 0.3s;
            cursor: pointer;
        }
        .logout-btn:hover {
            background-color: #dc3545;
        }

        /* Hide sidebar on mobile */
        @media screen and (max-width: 768px) {
            .sidebar {
                display: none;
            }
            .content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark">
        <button class="btn btn-outline-light menu-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#mobileSidebar">
            ☰ Menu
        </button>
        <span class="navbar-brand mx-auto">Admin Dashboard</span>
    </nav>

    <!-- Mobile Sidebar (Dropdown) -->
    <div class="collapse bg-dark" id="mobileSidebar">
        <div class="p-2">
            <a href="{{ route('admin.dashboard') }}" class="d-block text-white p-2 {{ request()->routeIs('admin.dashboard') ? 'bg-secondary' : '' }}">Dashboard</a>
            <a href="{{ route('admin.products') }}" class="d-block text-white p-2 {{ request()->routeIs('admin.products') ? 'bg-secondary' : '' }}">Products</a>
            <a href="{{ route('admin.categories') }}" class="d-block text-white p-2 {{ request()->routeIs('admin.categories') ? 'bg-secondary' : '' }}">Categories</a>
            <a href="{{ route('admin.messages') }}" class="d-block text-white p-2 {{ request()->routeIs('admin.messages') ? 'bg-secondary' : '' }}">Messages</a>
            <a href="{{ route('admin.reports') }}" class="d-block text-white p-2 {{ request()->routeIs('admin.reports') ? 'bg-secondary' : '' }}">Reports</a>
            
            <!-- Logout Form -->
            <form method="POST" action="{{ route('admin.logout') }}" id="logout-form">
                @csrf
                <button type="submit" class="logout-btn text-white w-100 p-2"> 🔓 Sign Out</button>
            </form>
        </div>
    </div>

    <!-- Sidebar (for large screens) -->
    <div class="sidebar d-none d-md-block">
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
        <a href="{{ route('admin.products') }}" class="{{ request()->routeIs('admin.products') ? 'active' : '' }}">Products</a>
        <a href="{{ route('admin.categories') }}" class="{{ request()->routeIs('admin.categories') ? 'active' : '' }}">Categories</a>
        <a href="{{ route('admin.messages') }}" class="{{ request()->routeIs('admin.messages') ? 'active' : '' }}">Messages</a>
        <a href="{{ route('admin.reports') }}" class="{{ request()->routeIs('admin.reports') ? 'active' : '' }}">Reports</a>

        <!-- Logout Form -->
        <form method="POST" action="{{ route('admin.logout') }}" id="logout-form">
            @csrf
            <button type="submit" class="logout-btn"> 🔓 Sign Out</button>
        </form>
    </div>

    <!-- Content Area -->
    <div class="content">
        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
