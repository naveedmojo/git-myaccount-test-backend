
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
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
        .menu-toggle {
            display: none;
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

        /* Responsive Sidebar */
        @media screen and (max-width: 768px) {
            .sidebar {
                width: 0;
                position: fixed;
                height: 100vh;
                z-index: 1000;
                overflow: hidden;
            }
            .sidebar.open {
                width: 250px;
            }
            .content {
                margin-left: 0;
            }
            .content.shift {
                margin-left: 250px;
            }
            .menu-toggle {
                display: block;
            }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark">
        <button class="btn btn-outline-light menu-toggle">☰ Menu</button>
        <span class="navbar-brand mx-auto">Admin Dashboard</span>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <a href="#" onclick="showSection('dashboard', event)" class="active">Dashboard</a>
        <a href="#" onclick="showSection('products', event)">Products</a>
        <a href="#" onclick="showSection('categories', event)">Categories</a>
        <a href="#" onclick="showSection('messages', event)">Messages</a>
        <a href="#" onclick="showSection('reports', event)">Reports</a>

        <!-- Logout Form -->
        <form method="POST" action="{{ route('admin.logout') }}" id="logout-form">
            @csrf
            <button type="submit" class="logout-btn"> 🔓 Sign Out</button>
        </form>
    </div>

    <!-- Content Area -->
    <div class="content">
        <!-- Dashboard Section -->
        <div id="dashboard-section">
            <h2>Admin Dashboard</h2>
            <p>Manage your products, categories, messages, and reports from here.</p>

            <!-- Dashboard Statistics -->
            <div class="row mt-4">
                <div class="col-md-3">
                    <div class="card text-white bg-primary shadow">
                        <div class="card-body">
                            <h5 class="card-title">Total Sales</h5>
                            <p class="card-text fs-3">{{ $totalSales ?? 0 }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-success shadow">
                        <div class="card-body">
                            <h5 class="card-title">Total Inquiries</h5>
                            <p class="card-text fs-3">{{ $totalInquiries ?? 0 }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-warning shadow">
                        <div class="card-body">
                            <h5 class="card-title">Total Products</h5>
                            <p class="card-text fs-3">{{ $totalProducts ?? 0 }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-danger shadow">
                        <div class="card-body">
                            <h5 class="card-title">Total Categories</h5>
                            <p class="card-text fs-3">{{ $totalCategories ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Section -->
        <div id="products-section" style="display: none;">
            <h2>Products</h2>
            <p>Manage your products here.</p>
        </div>

        <!-- Categories Section -->
        <div id="categories-section" style="display: none;">
            <h2>Categories</h2>
            <p>Manage your categories here.</p>
        </div>

        <!-- Messages Section -->
        <div id="messages-section" style="display: none;">
            <h2>Messages</h2>
            <p>View customer messages here.</p>
        </div>

        <!-- Reports Section -->
        <div id="reports-section" style="display: none;">
            <h2>Reports</h2>
            <p>View reports and analytics here.</p>
        </div>
    </div>

    <!-- Bootstrap JS & Sidebar Toggle -->
    <script>
        document.querySelector(".menu-toggle").addEventListener("click", function() {
            let sidebar = document.getElementById("sidebar");
            let content = document.querySelector(".content");

            sidebar.classList.toggle("open");
            content.classList.toggle("shift");
        });

        function showSection(section, event) {
            // Hide all sections
            document.querySelectorAll(".content > div").forEach(div => div.style.display = "none");

            // Show the selected section
            document.getElementById(section + "-section").style.display = "block";

            // Remove active class from all sidebar links
            document.querySelectorAll(".sidebar a").forEach(link => link.classList.remove("active"));

            // Add active class to clicked link
            if (event) event.target.classList.add("active");
        }
    </script>

</body>
</html>
