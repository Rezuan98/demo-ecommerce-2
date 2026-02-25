@php
    use App\Models\Cart;
    $wishlistCount = auth()->check() ? auth()->user()->wish()->count() : 0;
@endphp



<!-- Desktop Navbar -->
<nav class="main-navbar" id="mainNavbar">

    <!-- Upper Row: Logo (left) + Icons (right) -->
    <div class="navbar-upper">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between">

                <!-- Left: Logo -->
                <div class="logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('storage/' . $settings->logo) }}"
                            alt="{{ $settings->site_name ?? 'Logo' }}">
                    </a>
                </div>

                <!-- Right: Icons -->
                <div class="nav-icons d-flex align-items-center">

                    <!-- Search Icon -->
                    <a href="#" class="nav-icon" id="desktop-search-toggle" title="Search">
                        <img style="height:20px;" src="{{ asset('frontend/images/search.png') }}" alt="Search">
                    </a>

                    <!-- Wishlist Icon -->
                    <a href="{{ route('wishlist.index') }}" class="nav-icon wishlist-nav-icon" title="Wishlist">
                        <img style="height:20px;" src="{{ asset('frontend/images/like.png') }}" alt="Wishlist">
                        @if($wishlistCount > 0)
                            <span class="wishlist-count">{{ $wishlistCount }}</span>
                        @endif
                    </a>

                    <!-- User Icon -->
                    <div class="position-relative">
                        <a href="#" class="nav-icon user-icon" title="Account">
                            <img style="height:23px;" src="{{ asset('frontend/images/user3.png') }}" alt="">
                        </a>
                        <div class="user-dropdown">
                            <ul>
                                @auth
                                    <li><a href="{{ route('user.dashboard') }}">Profile</a></li>
                                    <li><a href="{{ route('user.dashboard') }}">Orders</a></li>
                                    <li><a href="{{ route('wishlist.index') }}">Wishlist</a></li>
                                    <li><a href="{{ route('track.order') }}">Track Order</a></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <a href="#"
                                                onclick="event.preventDefault(); this.closest('form').submit();">Logout</a>
                                        </form>
                                    </li>
                                @else
                                    <li><a href="{{ route('user.dashboard') }}">My Account</a></li>
                                    <li><a href="{{ route('user.dashboard') }}">Orders</a></li>
                                    <li><a href="{{ route('wishlist.index') }}">Wishlist</a></li>
                                    <li><a href="{{ route('track.order') }}">Track Order</a></li>
                                    <li><a href="{{ route('user.login') }}">Login</a></li>
                                @endauth
                            </ul>
                        </div>
                    </div>

                    <!-- Cart Icon -->
                    <a href="#" class="nav-icon cart-icon" onclick="toggleCart(); return false;" title="Cart">
                        <img style="height:25px;" src="{{ asset('frontend/images/market.png') }}" alt="">
                        <span class="cart-count">{{ auth()->check() ?
    Cart::where('user_id', auth()->id())->sum('quantity') :
    collect(session('cart', []))->sum('quantity')
                        }}</span>
                    </a>

                </div>
            </div>
        </div>
    </div>

    <!-- Lower Row: Category Dropdowns (centered, max 12) -->
    <div class="navbar-lower">
        <div class="container-fluid">
            <ul class="category-list category-list-center">
                @foreach ($categories->take(12) as $category)
                    <li class="category-item">
                        <a href="{{ $category->subcategories->count() > 0 ? '#' : route('category.products', $category->id) }}"
                            class="{{ $category->subcategories->count() > 0 ? 'has-dropdown' : '' }}">
                            {{ $category->name }}
                        </a>
                        @if($category->subcategories->count() > 0)
                            <div class="subcategory-dropdown">
                                <div class="mega-inner">
                                    <ul>
                                        @foreach($category->subcategories->take(30) as $subcategory)
                                            <li>
                                                <a href="{{ route('subcategory.products', $subcategory->id) }}">{{ $subcategory->name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

</nav>

<!-- Search Overlay -->
<div class="search-overlay" id="search-overlay">
    <div class="search-overlay-inner">
        <button class="close-search-overlay" id="close-search-overlay" title="Close">
            <i class="fas fa-times"></i>
        </button>
        <div class="search-overlay-box">
            <div class="search-overlay-input-wrap">
                <i class="fas fa-search search-overlay-icon"></i>
                <input
                    type="text"
                    class="search-overlay-input"
                    placeholder="Search for products..."
                    id="overlay-search-input"
                    autocomplete="off"
                >
            </div>
            <ul id="overlay-search-results" class="search-overlay-results"></ul>
        </div>
    </div>
</div>

<!-- Mobile Navbar -->
<nav class="mobile-navbar">
    <div class="container">
        <div class="row align-items-center" id="mobile-nav-row">
            <!-- Left Icons -->
            <div class="col-4 d-flex" id="mobile-left-icons">
                <a href="#" class="nav-icon me-3" id="mobile-menu-toggle">
                    <img style="height:25px;" src="{{ asset('frontend/images/hamburger.png') }}" alt="">
                </a>
                <a href="#" class="nav-icon" id="mobile-search-toggle">
                    <img style="height:25px;" src="{{ asset('frontend/images/search.png') }}" alt="">
                </a>
            </div>

            <!-- Center Logo -->
            <div class="col-4 text-center" id="mobile-logo">
                <div class="logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('storage/' . $settings->logo) }}" alt="{{ $settings->site_name ?? 'Logo' }}"
                            style="height: 40px;">
                    </a>
                </div>
            </div>

            <!-- Right Icons -->
            <div class="col-4 d-flex justify-content-end align-items-center" id="mobile-right-icons">
                <div class="position-relative">
                    <a href="#" class="nav-icon mobile-user-icon">
                        <img style="height:23px;" src="{{ asset('frontend/images/user.png') }}" alt="User">
                    </a>
                    <div class="user-dropdown mobile-user-dropdown">
                        <ul>
                            @auth
                                <li><a href="{{ route('user.dashboard') }}">Profile</a></li>
                                <li><a href="{{ route('user.dashboard') }}">Orders</a></li>
                                <li><a href="{{ route('wishlist.index') }}">Wishlist</a></li>
                                <li><a href="{{ route('track.order') }}">Track Order</a></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a href="#"
                                            onclick="event.preventDefault(); this.closest('form').submit();">Logout</a>
                                    </form>
                                </li>
                            @else
                                <li><a href="{{ route('user.dashboard') }}">My Account</a></li>
                                <li><a href="{{ route('user.dashboard') }}">Orders</a></li>
                                <li><a href="{{ route('wishlist.index') }}">Wishlist</a></li>
                                <li><a href="{{ route('track.order') }}">Track Order</a></li>
                                <li><a href="{{ route('user.login') }}">Login</a></li>
                            @endauth
                        </ul>
                    </div>
                </div>
                <a style="color: #000000;" href="#" class="nav-icon mobile-cart-icon"
                    onclick="toggleCart(); return false;">
                    <img style="height:25px;" src="{{ asset('frontend/images/market.png') }}" alt="">
                    <span class="cart-count">{{ auth()->check() ?
    Cart::where('user_id', auth()->id())->sum('quantity') :
    collect(session('cart', []))->sum('quantity')
                    }}</span>
                </a>
            </div>
        </div>

        <!-- Mobile Search Row -->
        <div class="mobile-search" id="mobile-search">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-10">
                        <input type="text" class="search-input" placeholder="Search for products..."
                            id="mobile-search-input">
                        <ul id="mobile-search-results" class="search-results" style="margin-top: 5px;"></ul>
                    </div>
                    <div class="col-2 text-end">
                        <button class="btn" id="close-search">
                            <i class="fas fa-times" style="color: #000000;"></i>
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
        @foreach ($categories->take(8) as $category)
            <li class="category-item">
                @if($category->subcategories && $category->subcategories->count() > 0)
                    <!-- Category with subcategories -->
                    <div class="category-link">
                        <div class="category-info">
                            @if($category->icon)
                                <img src="{{ asset('storage/' . $category->icon) }}" alt="{{ $category->name }}"
                                    class="category-icon-img"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='inline';">
                                <i class="fas fa-folder category-icon-fallback" style="display: none;"></i>
                            @else
                                <i class="fas fa-folder category-icon-fallback"></i>
                            @endif
                            <span class="category-name">{{ $category->name }}</span>
                        </div>
                        <button class="category-toggle" onclick="toggleSubcategory(this)">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                    <ul class="subcategory-list">
                        @foreach($category->subcategories as $subcategory)
                            <li class="subcategory-item">
                                <a href="{{ route('subcategory.products', $subcategory->id) }}" class="subcategory-link">
                                    @if($subcategory->icon)
                                        <img src="{{ asset('storage/' . $subcategory->icon) }}" alt="{{ $subcategory->name }}"
                                            class="subcategory-icon-img"
                                            onerror="this.style.display='none'; this.nextElementSibling.style.display='inline';">
                                        <i class="fas fa-tag subcategory-icon-fallback" style="display: none;"></i>
                                    @else
                                        <i class="fas fa-tag subcategory-icon-fallback"></i>
                                    @endif
                                    <span class="subcategory-name">{{ $subcategory->name }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <!-- Category without subcategories -->
                    <a href="{{ route('category.products', $category->id) }}" class="category-link">
                        <div class="category-info">
                            @if($category->icon)
                                <img src="{{ asset('storage/' . $category->icon) }}" alt="{{ $category->name }}"
                                    class="category-icon-img"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='inline';">
                                <i class="fas fa-folder category-icon-fallback" style="display: none;"></i>
                            @else
                                <i class="fas fa-folder category-icon-fallback"></i>
                            @endif
                            <span class="category-name">{{ $category->name }}</span>
                        </div>
                    </a>
                @endif
            </li>
        @endforeach
    </ul>
</div>

<!-- Cart Sidebar -->
<div id="cart-sidebar" class="cart-sidebar">
    <div class="cart-header">
        <h5>Shopping Cart</h5>
        <button class="close-cart" onclick="toggleCart()">×</button>
    </div>
    <div class="cart-content">
        <div class="cart-items">
            <!-- Cart items will be dynamically populated here -->
        </div>
    </div>
    <div class="cart-footer">
        <div class="cart-subtotal">
            <span>Subtotal:</span>
            <span id="cart-subtotal-amount">Tk0.00</span>
        </div>
        <div class="cart-buttons">
            <a href="{{ route('cart.index') }}" class="view-cart-btn">View Cart</a>
            <a href="{{ route('shipping') }}" class="checkout-btn">Checkout</a>
        </div>
    </div>
</div>

<!-- WhatsApp Float Button -->
<div class="whatsapp-float">
    <a href="https://wa.me/{{ str_replace(['+', ' ', '-'], '', $settings->phone) }}?text=Hello%20{{ $settings->site_name ?? 'Scinan' }}%2C%20I%20need%20help%20with..."
        target="_blank" class="whatsapp-btn">
        <i class="fab fa-whatsapp"></i>
    </a>
</div>

@push('ecomjs')
    <script>
        function updateCartCount(count) {
            const cartCountElements = document.querySelectorAll('.cart-count');
            cartCountElements.forEach(element => {
                element.textContent = count || 0;
                element.style.display = 'flex';
                if (count === 0 || count === '0') {
                    element.classList.add('empty-cart');
                } else {
                    element.classList.remove('empty-cart');
                }
            });
        }

        // ── Search Overlay ──────────────────────────────────────────────
        const searchOverlay      = document.getElementById('search-overlay');
        const overlaySearchInput = document.getElementById('overlay-search-input');
        const overlayResults     = document.getElementById('overlay-search-results');

        document.getElementById('desktop-search-toggle').addEventListener('click', function (e) {
            e.preventDefault();
            openSearchOverlay();
        });

        document.getElementById('close-search-overlay').addEventListener('click', closeSearchOverlay);

        searchOverlay.addEventListener('click', function (e) {
            // Close when clicking the dark backdrop (not the box itself)
            if (e.target === searchOverlay || e.target === document.querySelector('.search-overlay-inner')) {
                closeSearchOverlay();
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeSearchOverlay();
        });

        function openSearchOverlay() {
            searchOverlay.classList.add('active');
            setTimeout(() => overlaySearchInput.focus(), 50);
        }

        function closeSearchOverlay() {
            searchOverlay.classList.remove('active');
            overlaySearchInput.value = '';
            overlayResults.innerHTML = '';
            overlayResults.style.display = 'none';
        }

        // Live search for overlay
        overlaySearchInput.addEventListener('input', function () {
            const query = this.value.trim();
            if (query.length > 2) {
                fetch(`/live-search?query=${encodeURIComponent(query)}`)
                    .then(r => r.json())
                    .then(data => {
                        overlayResults.innerHTML = '';
                        if (data.length > 0) {
                            data.forEach(product => {
                                const li = document.createElement('li');
                                li.innerHTML = `
                                    <a href="/product/details/${product.id}" class="overlay-result-item">
                                        <img src="${location.origin}/uploads/products/${product.product_image}"
                                             alt="${product.product_name}"
                                             onerror="this.src='/path/to/placeholder.jpg';">
                                        <div class="overlay-result-info">
                                            <span class="overlay-result-name">${product.product_name}</span>
                                            <span class="overlay-result-price">Tk${product.sale_price}</span>
                                        </div>
                                    </a>`;
                                overlayResults.appendChild(li);
                            });
                            overlayResults.style.display = 'block';
                        } else {
                            overlayResults.innerHTML = '<li class="overlay-no-results">No results found</li>';
                            overlayResults.style.display = 'block';
                        }
                    })
                    .catch(() => { overlayResults.style.display = 'none'; });
            } else {
                overlayResults.innerHTML = '';
                overlayResults.style.display = 'none';
            }
        });

        // ── Mobile Menu Toggle ──────────────────────────────────────────
        document.getElementById('mobile-menu-toggle').addEventListener('click', function (e) {
            e.preventDefault();
            document.getElementById('mobile-menu').classList.add('open');
        });

        document.getElementById('close-mobile-menu').addEventListener('click', function () {
            document.getElementById('mobile-menu').classList.remove('open');
        });

        // ── Mobile Search Toggle ────────────────────────────────────────
        document.getElementById('mobile-search-toggle').addEventListener('click', function (e) {
            e.preventDefault();
            document.getElementById('mobile-left-icons').classList.add('hidden-no-space');
            document.getElementById('mobile-right-icons').classList.add('hidden-no-space');
            document.getElementById('mobile-logo').classList.add('hidden-no-space');
            document.querySelector('.mobile-cart-icon .cart-count')?.classList.add('hidden-no-space');
            document.getElementById('mobile-search').style.display = 'block';
            document.getElementById('mobile-search-input').focus();
        });

        document.getElementById('close-search').addEventListener('click', function () {
            document.getElementById('mobile-left-icons').classList.remove('hidden-no-space');
            document.getElementById('mobile-right-icons').classList.remove('hidden-no-space');
            document.getElementById('mobile-logo').classList.remove('hidden-no-space');
            document.querySelector('.mobile-cart-icon .cart-count')?.classList.remove('hidden-no-space');
            document.getElementById('mobile-search').style.display = 'none';
            document.getElementById('mobile-search-results').style.display = 'none';
        });

        // ── Cart Toggle ─────────────────────────────────────────────────
        function toggleCart() {
            const cart = document.getElementById('cart-sidebar');
            cart.classList.toggle('open');
            updateCartSidebar();
        }

        // ── User Dropdown ───────────────────────────────────────────────
        document.querySelectorAll('.user-icon, .mobile-user-icon').forEach(function (icon) {
            icon.addEventListener('click', function (e) {
                e.preventDefault();
                const dropdown = this.nextElementSibling;
                dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
            });
        });

        document.addEventListener('click', function (e) {
            if (!e.target.closest('.user-icon') && !e.target.closest('.mobile-user-icon')) {
                document.querySelectorAll('.user-dropdown').forEach(d => d.style.display = 'none');
            }
        });

        // ── Close menus on outside click ────────────────────────────────
        document.addEventListener('click', function (e) {
            const menu   = document.getElementById('mobile-menu');
            const toggle = document.getElementById('mobile-menu-toggle');
            if (!menu.contains(e.target) && !toggle.contains(e.target)) {
                menu.classList.remove('open');
            }
        });

        document.addEventListener('click', function (e) {
            const cart      = document.getElementById('cart-sidebar');
            const cartIcons = document.querySelectorAll('.cart-icon, .mobile-cart-icon');
            let clickedCart = false;
            cartIcons.forEach(icon => { if (icon.contains(e.target)) clickedCart = true; });
            if (!cart.contains(e.target) && !clickedCart) {
                cart.classList.remove('open');
            }
        });

        // ── Mobile Live Search ──────────────────────────────────────────
        function setupSearch(inputId, resultsId) {
            const searchInput   = document.getElementById(inputId);
            const searchResults = document.getElementById(resultsId);
            if (!searchInput || !searchResults) return;

            searchInput.addEventListener('input', function () {
                const query = searchInput.value.trim();
                if (query.length > 2) {
                    fetch(`/live-search?query=${encodeURIComponent(query)}`)
                        .then(r => r.json())
                        .then(data => {
                            searchResults.innerHTML = '';
                            if (data.length > 0) {
                                data.forEach(product => {
                                    const li = document.createElement('li');
                                    li.className = 'list-group-item p-2';
                                    li.innerHTML = `
                                        <div style="display:flex;align-items:center;">
                                            <img src="${location.origin}/uploads/products/${product.product_image}"
                                                 alt="${product.product_name}"
                                                 style="width:50px;height:50px;object-fit:cover;margin-right:10px;border-radius:5px;"
                                                 onerror="this.src='/path/to/placeholder.jpg';">
                                            <div>
                                                <a href="/product/details/${product.id}" style="text-decoration:none;font-weight:bold;color:#4f0808;">${product.product_name}</a>
                                                <div style="color:#4f0808;font-size:14px;">Price: Tk${product.sale_price}</div>
                                            </div>
                                        </div>`;
                                    searchResults.appendChild(li);
                                });
                                searchResults.style.display = 'block';
                            } else {
                                const li = document.createElement('li');
                                li.className = 'list-group-item';
                                li.textContent = 'No results found';
                                searchResults.appendChild(li);
                                searchResults.style.display = 'block';
                            }
                        })
                        .catch(() => { searchResults.style.display = 'none'; });
                } else {
                    searchResults.style.display = 'none';
                }
            });
        }
        setupSearch('mobile-search-input', 'mobile-search-results');

        document.addEventListener('click', function (e) {
            const searchContainers = document.querySelectorAll('.search-container, .mobile-search');
            searchContainers.forEach(container => {
                if (!container.contains(e.target)) {
                    const results = container.querySelector('.search-results');
                    if (results) results.style.display = 'none';
                }
            });
        });

        // ── Cart Sidebar ────────────────────────────────────────────────
        function updateCartSidebar() {
            fetch('/cart/items')
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        const cartItemsContainer  = document.querySelector('.cart-items');
                        const cartSubtotalElement = document.getElementById('cart-subtotal-amount');
                        const cartFooter          = document.querySelector('.cart-footer');
                        cartItemsContainer.innerHTML = '';
                        const cartItemsArray = Array.isArray(data.cartItems) ? data.cartItems : Object.values(data.cartItems);

                        if (cartItemsArray.length > 0) {
                            cartItemsArray.forEach(item => {
                                const price        = parseFloat(item.price) || 0;
                                const productImage = item.product?.product_image || item.product_image || 'default.png';
                                const productName  = item.product?.product_name  || item.product_name  || 'N/A';
                                const variantSize  = item.variant?.size?.name    || item.variant?.size  || 'N/A';
                                const variantColor = item.variant?.color?.name   || item.variant?.color || 'N/A';

                                cartItemsContainer.insertAdjacentHTML('beforeend', `
                                    <div class="cart-item">
                                        <img src="/uploads/products/${productImage}" alt="Product Image" class="cart-item-image">
                                        <div class="cart-item-details">
                                            <h6 class="cart-item-title">${productName}</h6>
                                            <p class="cart-item-variant">${variantSize}-${variantColor}</p>
                                            <div class="cart-item-price">Tk${price.toFixed(2)}</div>
                                            <div class="cart-item-actions">
                                                <div class="quantity-controls">
                                                    <button onclick="updateSidebarQuantity('${item.id}', 'decrease')">-</button>
                                                    <span class="sidebar-quantity" data-id="${item.id}">${item.quantity || 1}</span>
                                                    <button onclick="updateSidebarQuantity('${item.id}', 'increase')">+</button>
                                                </div>
                                                <button class="remove-item" onclick="removeSidebarItem('${item.id}')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>`);
                            });
                            cartSubtotalElement.textContent = `Tk${data.subtotal.toFixed(2)}`;
                            cartFooter.style.display = 'block';
                        } else {
                            cartItemsContainer.innerHTML = `
                                <div class="empty-cart">
                                    <i class="fas fa-shopping-cart"></i>
                                    <p>Your cart is empty</p>
                                </div>`;
                            cartSubtotalElement.textContent = 'Tk0.00';
                            cartFooter.style.display = 'none';
                        }
                    }
                })
                .catch(error => console.error('Error fetching cart items:', error));
        }

        async function updateSidebarQuantity(itemId, action) {
            const quantityElement = document.querySelector(`.sidebar-quantity[data-id="${itemId}"]`);
            let newValue = parseInt(quantityElement.textContent);
            if (action === 'increase' && newValue < 10) newValue++;
            else if (action === 'decrease' && newValue > 1) newValue--;
            else return;

            try {
                const response = await fetch('/cart/update', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                    body: JSON.stringify({ cart_id: itemId, quantity: newValue })
                });
                const data = await response.json();
                if (data.success) {
                    quantityElement.textContent = newValue;
                    document.querySelectorAll('.cart-count').forEach(el => el.textContent = data.cartCount);
                    updateCartSubtotal();
                }
            } catch (error) { console.error('Error updating quantity:', error); }
        }

        async function removeSidebarItem(itemId) {
            if (!confirm('Are you sure you want to remove this item?')) return;
            try {
                const response = await fetch('/cart/remove', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                    body: JSON.stringify({ cart_id: itemId })
                });
                const data = await response.json();
                if (data.success) {
                    document.querySelector(`.sidebar-quantity[data-id="${itemId}"]`).closest('.cart-item').remove();
                    document.querySelectorAll('.cart-count').forEach(el => el.textContent = data.cartCount);
                    updateCartSubtotal();
                    if (!document.querySelectorAll('.cart-item').length) {
                        document.querySelector('.cart-items').innerHTML = `
                            <div class="empty-cart">
                                <i class="fas fa-shopping-cart"></i>
                                <p>Your cart is empty</p>
                            </div>`;
                        document.querySelector('.cart-footer').style.display = 'none';
                    }
                }
            } catch (error) { console.error('Error removing item:', error); }
        }

        function updateCartSubtotal() {
            let subtotal = 0;
            document.querySelectorAll('.cart-item').forEach(item => {
                const price    = parseFloat(item.querySelector('.cart-item-price').textContent.replace('Tk', '').replace(',', ''));
                const quantity = parseInt(item.querySelector('.sidebar-quantity').textContent);
                subtotal += price * quantity;
            });
            const el = document.getElementById('cart-subtotal-amount');
            if (el) el.textContent = 'Tk' + subtotal.toFixed(2);
        }

        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.textContent = message;
            notification.style.cssText = `
                position:fixed;top:20px;right:20px;
                background:${type === 'success' ? '#28a745' : '#dc3545'};
                color:white;padding:15px 20px;border-radius:5px;z-index:9999;
                box-shadow:0 4px 12px rgba(0,0,0,0.15);
                transform:translateX(100%);transition:transform 0.3s ease;`;
            document.body.appendChild(notification);
            setTimeout(() => notification.style.transform = 'translateX(0)', 10);
            setTimeout(() => {
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => document.body.removeChild(notification), 300);
            }, 3000);
        }

        document.addEventListener('DOMContentLoaded', function () {
            fetch('/cart/count')
                .then(r => r.json())
                .then(data => { if (data.success) updateCartCount(data.count); })
                .catch(error => console.error('Error loading cart count:', error));
        });

        function toggleSubcategory(button) {
            const subcategoryList = button.parentElement.nextElementSibling;
            const isOpen = subcategoryList.classList.contains('show');
            document.querySelectorAll('.subcategory-list').forEach(l => l.classList.remove('show'));
            document.querySelectorAll('.category-toggle').forEach(t => t.classList.remove('active'));
            if (!isOpen) {
                subcategoryList.classList.add('show');
                button.classList.add('active');
            }
        }

        // ── Scroll: collapse upper row on scroll-down, restore on scroll-up ──
        (function () {
            const navbar   = document.getElementById('mainNavbar');
            let lastScrollY = window.scrollY;

            window.addEventListener('scroll', function () {
                const currentScrollY = window.scrollY;

                if (currentScrollY > lastScrollY && currentScrollY > 60) {
                    // Scrolling down — hide upper row, lower row sticks at top
                    navbar.classList.add('nav-scrolled');
                } else if (currentScrollY < lastScrollY) {
                    // Scrolling up — restore full navbar
                    navbar.classList.remove('nav-scrolled');
                }

                lastScrollY = currentScrollY;
            }, { passive: true });
        })();
    </script>
@endpush
