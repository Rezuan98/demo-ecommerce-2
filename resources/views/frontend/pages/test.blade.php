<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Navbar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        /* Desktop Navbar */
        .main-navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1050;
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .navbar-top {
            padding: 15px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .navbar-bottom {
            padding: 10px 0;
        }

        .logo img {
            height: 60px;
        }

        .search-container {
            position: relative;
            max-width: 500px;
            width: 100%;
        }

        .search-input {
            width: 100%;
            padding: 12px 50px 12px 15px;
            border: 2px solid #C54B8C;
            border-radius: 25px;
            outline: none;
            font-size: 14px;
        }

        .search-btn {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            background: #C54B8C;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            color: white;
            cursor: pointer;
        }

        .nav-icons .nav-icon {
            color: #6F1B4C;
            font-size: 20px;
            margin: 0 5px;
            text-decoration: none;
            position: relative;
        }

        .cart-count {
            position: absolute;
            top: -1px;
            right: -1px;
            background: #C54B8C;
            color: white;
            font-size: 10px;
            padding: 1px 3px;
            border-radius: 50%;
        }

        .social-icons .social-link {
            color: #6F1B4C;
            margin: 0 10px;
            font-size: 18px;
            text-decoration: none;
        }

        .category-list {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
            gap: 30px;
        }

        .category-list a {
            color: #6F1B4C;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
        }

        /* Mobile Navbar */
        .mobile-navbar {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1050;
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 15px 0;
        }

        .mobile-search {
            display: none;
            width: 100%;
        }

        .mobile-search .search-input {
            border-radius: 15px;
            padding: 10px 15px;
        }

        .mobile-menu {
            position: fixed;
            top: 0;
            left: -300px;
            width: 300px;
            height: 100vh;
            background: white;
            z-index: 1100;
            transition: left 0.3s ease;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .mobile-menu.open {
            left: 0;
        }

        .mobile-menu-header {
            padding: 20px;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .mobile-category-list {
            list-style: none;
            padding: 20px;
            margin: 0;
        }

        .mobile-category-list li {
            margin-bottom: 15px;
        }

        .mobile-category-list a {
            color: #333;
            text-decoration: none;
            font-size: 16px;
        }

        .close-menu {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
        }

        /* User Dropdown */
        .user-dropdown {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            min-width: 200px;
            z-index: 1000;
        }

        .user-dropdown ul {
            list-style: none;
            margin: 0;
            padding: 10px 0;
        }

        .user-dropdown li a {
            display: block;
            padding: 10px 20px;
            color: #333;
            text-decoration: none;
            font-size: 14px;
        }

        .user-dropdown li a:hover {
            background: #f8f9fa;
        }

        /* Cart Sidebar */
        .cart-sidebar {
            position: fixed;
            top: 0;
            right: -400px;
            width: 400px;
            height: 100vh;
            background: white;
            z-index: 1100;
            transition: right 0.3s ease;
            box-shadow: -2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .cart-sidebar.open {
            right: 0;
        }

        .cart-header {
            padding: 20px;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .close-cart {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
        }

        .cart-content {
            padding: 20px;
            height: calc(100vh - 80px);
            overflow-y: auto;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .main-navbar {
                display: none;
            }
            
            .mobile-navbar {
                display: block;
            }

            .cart-sidebar {
                width: 300px;
            }
        }

        /* Body padding for fixed navbar */
        body {
            padding-top: 120px;
        }

        @media (max-width: 768px) {
            body {
                padding-top: 70px;
            }
        }
    </style>
</head>
<body>
    <!-- Desktop Navbar -->
    <nav class="main-navbar">
        <!-- Top Row -->
        <div class="navbar-top">
            <div class="container">
                <div class="row align-items-center">
                    <!-- Logo -->
                    <div class="col-3">
                        <div class="logo">
                            <a href="/">
                                <img src="https://via.placeholder.com/150x60/6F1B4C/FFFFFF?text=LOGO" alt="Logo">
                            </a>
                        </div>
                    </div>
                    
                    <!-- Search Bar -->
                    <div class="col-6">
                        <div class="search-container">
                            <input type="text" class="search-input" placeholder="Search for products...">
                            <button class="search-btn">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- User & Cart Icons -->
                    <div class="col-3">
                        <div class="nav-icons d-flex justify-content-end align-items-center">
                            <div class="position-relative">
                                <a href="#" class="nav-icon user-icon">
                                    <i class="fas fa-user"></i>
                                </a>
                                <div class="user-dropdown">
                                    <ul>
                                        <li><a href="#">Profile</a></li>
                                        <li><a href="#">Orders</a></li>
                                        <li><a href="#">Login</a></li>
                                    </ul>
                                </div>
                            </div>
                            <a href="#" class="nav-icon cart-icon">
                                <i class="fas fa-shopping-cart"></i>
                                <span class="cart-count">2</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Bottom Row -->
        <div class="navbar-bottom">
            <div class="container">
                <div class="row align-items-center">
                    <!-- Empty Left -->
                    <div class="col-3"></div>
                    
                    <!-- Category List -->
                    <div class="col-6">
                        <ul class="category-list justify-content-center">
                            <li><a href="#">Electronics</a></li>
                            <li><a href="#">Fashion</a></li>
                            <li><a href="#">Home</a></li>
                            <li><a href="#">Beauty</a></li>
                            <li><a href="#">Sports</a></li>
                        </ul>
                    </div>
                    
                    <!-- Social Icons -->
                    <div class="col-3">
                        <div class="social-icons d-flex justify-content-end">
                            <a href="#" class="social-link">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="social-link">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="social-link">
                                <i class="fab fa-twitter"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Navbar -->
    <nav class="mobile-navbar">
        <div class="container">
            <div class="row align-items-center" id="mobile-nav-row">
                <!-- Left Icons -->
                <div class="col-4 d-flex">
                    <a href="#" class="nav-icon me-3" id="mobile-menu-toggle">
                        <i class="fas fa-bars"></i>
                    </a>
                    <a href="#" class="nav-icon" id="mobile-search-toggle">
                        <i class="fas fa-search"></i>
                    </a>
                </div>
                
                <!-- Center Logo -->
                <div class="col-4 text-center" id="mobile-logo">
                    <div class="logo">
                        <a href="/">
                            <img src="https://via.placeholder.com/120x40/6F1B4C/FFFFFF?text=LOGO" alt="Logo" style="height: 40px;">
                        </a>
                    </div>
                </div>
                
                <!-- Right Icons -->
                <div class="col-4 d-flex justify-content-end">
                    <div class="position-relative">
                        <a href="#" class="nav-icon me-3 mobile-user-icon">
                            <i class="fas fa-user"></i>
                        </a>
                        <div class="user-dropdown">
                            <ul>
                                <li><a href="#">Profile</a></li>
                                <li><a href="#">Orders</a></li>
                                <li><a href="#">Login</a></li>
                            </ul>
                        </div>
                    </div>
                    <a href="#" class="nav-icon mobile-cart-icon">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-count">2</span>
                    </a>
                </div>
            </div>
            
            <!-- Mobile Search Row -->
            <div class="mobile-search" id="mobile-search">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-10">
                            <input type="text" class="search-input" placeholder="Search for products...">
                        </div>
                        <div class="col-2 text-end">
                            <button class="btn" id="close-search">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobile-menu">
        <div class="mobile-menu-header">
            <h5>Categories</h5>
            <button class="close-menu" id="close-mobile-menu">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <ul class="mobile-category-list">
            <li><a href="#">Electronics</a></li>
            <li><a href="#">Fashion</a></li>
            <li><a href="#">Home & Garden</a></li>
            <li><a href="#">Beauty & Health</a></li>
            <li><a href="#">Sports & Outdoors</a></li>
            <li><a href="#">Toys & Games</a></li>
            <li><a href="#">Books</a></li>
            <li><a href="#">Automotive</a></li>
        </ul>
    </div>

    <!-- Cart Sidebar -->
    <div class="cart-sidebar" id="cart-sidebar">
        <div class="cart-header">
            <h5>Shopping Cart</h5>
            <button class="close-cart" id="close-cart">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="cart-content">
            <p>Your cart is empty</p>
        </div>
    </div>

    <!-- Demo Content -->
    <div class="container mt-5">
        <h1>Demo Content</h1>
        <p>This is demo content to show the navbar functionality. Scroll down to see the sticky effect on desktop.</p>
        <div style="height: 2000px;">
            <p>Scroll to test sticky navbar...</p>
        </div>
    </div>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-toggle').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('mobile-menu').classList.add('open');
        });

        // Close mobile menu
        document.getElementById('close-mobile-menu').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.remove('open');
        });

        // Mobile search toggle
        document.getElementById('mobile-search-toggle').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('mobile-logo').style.display = 'none';
            document.getElementById('mobile-search').style.display = 'block';
        });

        // Close mobile search
        document.getElementById('close-search').addEventListener('click', function() {
            document.getElementById('mobile-logo').style.display = 'block';
            document.getElementById('mobile-search').style.display = 'none';
        });

        // Cart toggle
        document.querySelectorAll('.cart-icon, .mobile-cart-icon').forEach(function(icon) {
            icon.addEventListener('click', function(e) {
                e.preventDefault();
                document.getElementById('cart-sidebar').classList.toggle('open');
            });
        });

        // Close cart
        document.getElementById('close-cart').addEventListener('click', function() {
            document.getElementById('cart-sidebar').classList.remove('open');
        });

        // User dropdown toggle
        document.querySelectorAll('.user-icon, .mobile-user-icon').forEach(function(icon) {
            icon.addEventListener('click', function(e) {
                e.preventDefault();
                const dropdown = this.nextElementSibling;
                dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
            });
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.user-icon') && !e.target.closest('.mobile-user-icon')) {
                document.querySelectorAll('.user-dropdown').forEach(function(dropdown) {
                    dropdown.style.display = 'none';
                });
            }
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(e) {
            const menu = document.getElementById('mobile-menu');
            const toggle = document.getElementById('mobile-menu-toggle');
            if (!menu.contains(e.target) && !toggle.contains(e.target)) {
                menu.classList.remove('open');
            }
        });

        // Close cart when clicking outside
        document.addEventListener('click', function(e) {
            const cart = document.getElementById('cart-sidebar');
            const cartIcons = document.querySelectorAll('.cart-icon, .mobile-cart-icon');
            let clickedCart = false;
            cartIcons.forEach(function(icon) {
                if (icon.contains(e.target)) clickedCart = true;
            });
            if (!cart.contains(e.target) && !clickedCart) {
                cart.classList.remove('open');
            }
        });
    </script>
</body>
</html>