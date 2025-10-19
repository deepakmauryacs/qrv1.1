<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ optional($settings)->store_name ?? $vendor->name }} - Order</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --brand: #0d6efd;
            --muted: #6b7280;
        }

        body {
            font-family: 'DM Sans', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
            background: #f8f9fb;
            color: #111827;
            min-height: 100vh;
        }

        .top-navbar {
            background: #fff;
            border-bottom: 1px solid #eef2f7;
        }

        .top-navbar .navbar-brand {
            font-weight: 700;
            color: var(--brand);
        }

        .nav-action {
            border-radius: 999px;
            font-weight: 600;
        }

        .nav-action.active {
            background: var(--brand);
            color: #fff;
        }

        .view-section {
            display: none;
        }

        .view-section.active {
            display: block;
        }

        /* Order type */
        .order-type-wrap {
            min-height: calc(100vh - 120px);
            display: grid;
            place-items: center;
            padding: 24px 16px 64px;
        }

        .card-chooser {
            max-width: 920px;
            width: 100%;
            border-radius: 20px;
        }

        .option-card {
            cursor: pointer;
            border: 2px solid transparent;
            transition: transform .15s ease, box-shadow .15s ease, border-color .15s ease;
            border-radius: 16px !important;
            height: 100%;
            user-select: none;
        }

        .option-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(15, 23, 42, 0.08);
        }

        .option-card.active {
            border-color: var(--brand);
            box-shadow: 0 0 0 6px rgba(13, 110, 253, 0.12);
        }

        .option-icon {
            font-size: 56px;
            line-height: 1;
            color: var(--brand);
        }

        /* Items */
        .items-wrap {
            min-height: calc(100vh - 120px);
            display: flex;
            flex-direction: column;
        }

        .filter-bar {
            position: sticky;
            top: 80px;
            z-index: 10;
            background: #fff;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
        }

        .item-card {
            border: 1px solid #edf1f7;
            border-radius: 16px;
            transition: transform .15s ease, box-shadow .15s ease;
            height: 100%;
            background: #fff;
        }

        .item-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(15, 23, 42, 0.08);
        }

        .item-card .card-body {
            display: flex;
            flex-direction: column;
            gap: .35rem;
        }

        .item-media {
            width: 100%;
            aspect-ratio: 1 / 1;
            border-radius: 14px 14px 0 0;
            overflow: hidden;
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .item-media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .item-placeholder {
            color: var(--muted);
            font-size: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
        }

        .cart-bar {
            position: sticky;
            bottom: 0;
            z-index: 20;
            background: #fff;
            border-top: 1px solid #e5e7eb;
            padding: .75rem;
            box-shadow: 0 -10px 30px rgba(15, 23, 42, 0.06);
        }

        .cart-item-row + .cart-item-row {
            border-top: 1px dashed #e5e7eb;
        }

        /* Checkout */
        .checkout-card {
            border-radius: 16px;
        }

        .summary-line {
            display: flex;
            justify-content: space-between;
            margin: .35rem 0;
        }

        .summary-line.total {
            font-size: 1.05rem;
            font-weight: 700;
        }

        .sticky-cta {
            position: sticky;
            bottom: 0;
            z-index: 15;
            background: #fff;
            border-top: 1px solid #e5e7eb;
            padding: .85rem;
        }

        /* Profile */
        .profile-card {
            border-radius: 18px;
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: #eef2ff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            color: var(--brand);
            box-shadow: 0 8px 24px rgba(79, 70, 229, 0.12);
        }

        .kpi-card {
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 16px;
            background: #fff;
            text-align: center;
        }

        .order-table thead {
            background: #f9fafc;
        }

        @media (max-width: 768px) {
            .top-navbar {
                position: sticky;
                top: 0;
                z-index: 30;
            }

            .filter-bar {
                top: 70px;
            }
        }
    </style>
</head>
<body>
<nav class="navbar top-navbar py-3">
    <div class="container d-flex align-items-center justify-content-between">
        <a class="navbar-brand" href="#" data-view-target="order-type" id="vendorBrand">
            <i class="bi bi-bag-heart-fill me-2"></i>{{ optional($settings)->store_name ?? $vendor->name }}
        </a>
        <div class="d-flex flex-wrap gap-2">
            <button class="btn btn-light nav-action active" data-view-target="order-type">Start</button>
            <button class="btn btn-outline-secondary nav-action" data-view-target="items"><i class="bi bi-basket2 me-1"></i>Menu</button>
            <button class="btn btn-outline-secondary nav-action" data-view-target="checkout">
                <i class="bi bi-bag-check me-1"></i>Checkout
                <span class="badge bg-danger ms-2" id="navCartCount">0</span>
            </button>
            <button class="btn btn-outline-secondary nav-action" data-view-target="profile"><i class="bi bi-person-circle me-1"></i>Profile</button>
        </div>
    </div>
</nav>

<div class="container my-3" id="alertContainer"></div>

<main>
    <section class="view-section active" data-view="order-type">
        <div class="order-type-wrap">
            <div class="card shadow card-chooser border-0">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <div class="mb-3" id="vendorLogoHolder" style="height: 72px;"></div>
                        <h1 class="fw-bold mb-1" id="vendorName">{{ optional($settings)->store_name ?? $vendor->name }}</h1>
                        <p class="text-secondary mb-1" id="vendorAddress">{{ optional($settings)->store_address }}</p>
                        <div class="small text-secondary" id="vendorContact"></div>
                    </div>

                    <div class="text-center mb-4">
                        <span class="badge rounded-pill text-bg-light px-3 py-2">Choose how you'd like to place your order</span>
                    </div>

                    <form id="orderTypeForm" class="mt-3">
                        <input type="radio" name="order_type" id="orderTypePickup" value="pickup" class="d-none">
                        <input type="radio" name="order_type" id="orderTypeDining" value="dine-in" class="d-none" checked>

                        <div class="row g-4">
                            <div class="col-12 col-md-6">
                                <label for="orderTypePickup" class="option-card card h-100 p-4" data-value="pickup">
                                    <div class="d-flex flex-column align-items-center text-center h-100">
                                        <div class="option-icon mb-3"><i class="bi bi-bag-check"></i></div>
                                        <h3 class="h5 fw-bold mb-2">Pickup Order</h3>
                                        <p class="text-secondary mb-0">Order now and collect it at the counter.</p>
                                    </div>
                                </label>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="orderTypeDining" class="option-card card h-100 p-4" data-value="dine-in">
                                    <div class="d-flex flex-column align-items-center text-center h-100">
                                        <div class="option-icon mb-3"><i class="bi bi-shop"></i></div>
                                        <h3 class="h5 fw-bold mb-2">Dining Order</h3>
                                        <p class="text-secondary mb-0">Stay with us and we'll serve it at your table.</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3 mt-4">
                            <div id="selectionText" class="text-secondary">Selected: Dining Order</div>
                            <button type="submit" class="btn btn-primary btn-lg px-4">Continue to Menu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="view-section" data-view="items">
        <div class="items-wrap">
            <div class="container py-3">
                <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-3">
                    <div>
                        <h2 class="fw-bold mb-1">Menu</h2>
                        <div class="text-secondary">Order type: <span class="fw-semibold" id="orderTypeBadge">Dining</span></div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <button class="btn btn-outline-secondary" data-view-target="order-type"><i class="bi bi-arrow-left me-1"></i>Change order type</button>
                        <button class="btn btn-primary position-relative" data-bs-toggle="offcanvas" data-bs-target="#cartDrawer">
                            <i class="bi bi-bag-check me-1"></i> Cart
                            <span id="cartCountBadge" class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle">0</span>
                        </button>
                    </div>
                </div>

                <div class="filter-bar shadow-sm p-3 mb-4">
                    <div class="row g-3 align-items-center">
                        <div class="col-12 col-md-6">
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                                <input id="searchInput" type="text" class="form-control" placeholder="Search items…">
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label small text-secondary mb-1">Category</label>
                            <select id="categorySelect" class="form-select">
                                <option value="all">All Categories</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label small text-secondary mb-1">Sort By</label>
                            <select id="sortSelect" class="form-select">
                                <option value="recommended">Recommended</option>
                                <option value="price-asc">Price: Low to High</option>
                                <option value="price-desc">Price: High to Low</option>
                                <option value="name-asc">Name: A → Z</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="pb-5">
                    <div id="itemsGrid" class="row g-3"></div>
                    <div id="itemsEmptyState" class="text-center text-secondary py-5 d-none">
                        <i class="bi bi-emoji-neutral display-6 d-block mb-3"></i>
                        <p class="mb-0">No items match your filters. Try adjusting your search.</p>
                    </div>
                </div>
            </div>

            <div class="cart-bar">
                <div class="container d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="small text-secondary">Items: <span id="cartItemsCount">0</span></div>
                    <div class="fw-bold">Subtotal: <span id="cartSubtotal">₹0.00</span></div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-secondary btn-sm" id="clearCartBtn">Clear Cart</button>
                        <button class="btn btn-primary btn-sm" data-view-target="checkout">Review & Checkout</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="view-section" data-view="checkout">
        <div class="container py-4">
            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-2 mb-4">
                <div>
                    <h3 class="fw-bold mb-1"><i class="bi bi-receipt-cutoff text-primary me-2"></i>Checkout</h3>
                    <div class="text-secondary small">Order type: <span class="fw-semibold" id="checkoutOrderType">Dining</span></div>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary" data-view-target="items"><i class="bi bi-arrow-left me-1"></i>Back to menu</button>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-12 col-lg-7">
                    <div class="card checkout-card shadow-sm border-0">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3">Your Cart</h5>
                            <div id="checkoutItems" class="mb-3"></div>
                            <div class="summary-line"><span>Subtotal</span><span id="checkoutSubtotal">₹0.00</span></div>
                            <div class="summary-line total"><span>Total</span><span id="checkoutTotal">₹0.00</span></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-5">
                    <div class="card checkout-card shadow-sm border-0">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3">Customer Details</h5>
                            <form id="checkoutForm" class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="checkoutName" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Contact Number</label>
                                    <input type="tel" class="form-control" id="checkoutContact" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Email (optional)</label>
                                    <input type="email" class="form-control" id="checkoutEmail">
                                </div>
                                <div class="col-12" id="tableNumberGroup">
                                    <label class="form-label">Table Number</label>
                                    <input type="text" class="form-control" id="checkoutTable" placeholder="e.g., T5">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Special Request</label>
                                    <textarea class="form-control" id="checkoutNotes" rows="3" placeholder="Any special instructions..."></textarea>
                                </div>
                                <div class="col-12 sticky-cta">
                                    <button type="submit" class="btn btn-primary w-100 btn-lg" id="placeOrderBtn">
                                        <i class="bi bi-check2-circle me-1"></i>Place Order
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="view-section" data-view="profile">
        <div class="container py-4">
            <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
                <div>
                    <h3 class="fw-bold mb-1"><i class="bi bi-person-lines-fill text-primary me-2"></i>Profile & Orders</h3>
                    <p class="text-secondary mb-0 small">Keep your details updated to review order history and checkout faster.</p>
                </div>
                <button class="btn btn-outline-secondary" data-view-target="items"><i class="bi bi-basket2 me-1"></i>Back to menu</button>
            </div>

            <div class="row g-4">
                <div class="col-12 col-lg-4">
                    <div class="card profile-card shadow-sm border-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="profile-avatar" id="profileAvatar"><i class="bi bi-person-fill"></i></div>
                                <div>
                                    <div class="h5 fw-bold mb-1" id="profileNameDisplay">Guest</div>
                                    <div class="text-secondary small" id="profileEmailDisplay">Add your email</div>
                                    <div class="text-secondary small" id="profilePhoneDisplay">Add your contact number</div>
                                </div>
                            </div>
                            <hr>
                            <h6 class="fw-bold mb-3">Edit Details</h6>
                            <form id="profileForm" class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="profileNameInput" placeholder="Your name">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" id="profileEmailInput" placeholder="Email address">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Contact Number</label>
                                    <input type="tel" class="form-control" id="profileContactInput" placeholder="Mobile number">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Default Table Number</label>
                                    <input type="text" class="form-control" id="profileTableInput" placeholder="Table number for dine-in">
                                </div>
                                <div class="col-12 d-grid">
                                    <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Save Profile</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="row g-3 mt-3">
                        <div class="col-6">
                            <div class="kpi-card">
                                <div class="text-secondary small">Orders</div>
                                <div class="fw-bold fs-5" id="ordersCount">0</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="kpi-card">
                                <div class="text-secondary small">Total Spent</div>
                                <div class="fw-bold fs-5" id="totalSpent">₹0.00</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="kpi-card">
                                <div class="text-secondary small">Active</div>
                                <div class="fw-bold fs-5" id="activeOrdersCount">0</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="kpi-card">
                                <div class="text-secondary small">Cancelled</div>
                                <div class="fw-bold fs-5" id="cancelledOrdersCount">0</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-8">
                    <div class="card profile-card shadow-sm border-0 mb-3">
                        <div class="card-body">
                            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-3">
                                <h5 class="fw-bold mb-0">Order History</h5>
                                <button class="btn btn-outline-primary btn-sm" id="refreshOrdersBtn"><i class="bi bi-arrow-clockwise me-1"></i>Refresh</button>
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-12 col-lg-5">
                                    <label class="form-label small text-secondary mb-1">Search</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                                        <input type="text" class="form-control" id="ordersSearch" placeholder="Search order or item">
                                    </div>
                                </div>
                                <div class="col-6 col-lg-3">
                                    <label class="form-label small text-secondary mb-1">Status</label>
                                    <select class="form-select" id="ordersStatus">
                                        <option value="all">All</option>
                                        <option value="placed">Placed</option>
                                        <option value="preparing">Preparing</option>
                                        <option value="ready">Ready</option>
                                        <option value="completed">Completed</option>
                                        <option value="cancelled">Cancelled</option>
                                    </select>
                                </div>
                                <div class="col-6 col-lg-3">
                                    <label class="form-label small text-secondary mb-1">Order Type</label>
                                    <select class="form-select" id="ordersType">
                                        <option value="all">All</option>
                                        <option value="dine-in">Dine-in</option>
                                        <option value="pickup">Pickup</option>
                                    </select>
                                </div>
                            </div>
                            <div id="ordersNotice" class="alert alert-info d-none"></div>
                            <div class="table-responsive order-table">
                                <table class="table align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                            <th>Total</th>
                                            <th>Placed At</th>
                                            <th>Items</th>
                                        </tr>
                                    </thead>
                                    <tbody id="ordersTableBody"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div id="ordersEmptyState" class="alert alert-info d-none">No orders found for the provided details.</div>
                </div>
            </div>
        </div>
    </section>
</main>

<div class="offcanvas offcanvas-end" tabindex="-1" id="cartDrawer" aria-labelledby="cartDrawerLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title fw-bold" id="cartDrawerLabel"><i class="bi bi-bag-check me-2"></i>Your Cart</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column">
        <div id="cartItems" class="flex-grow-1"></div>
        <div class="border-top pt-3">
            <div class="d-flex justify-content-between mb-2">
                <span class="text-secondary">Subtotal</span>
                <strong id="drawerSubtotal">₹0.00</strong>
            </div>
            <div class="d-grid gap-2">
                <button id="drawerCheckoutBtn" class="btn btn-primary btn-lg" data-bs-dismiss="offcanvas">Review & Checkout</button>
                <button id="drawerClearCartBtn" class="btn btn-outline-secondary">Clear Cart</button>
            </div>
        </div>
    </div>
</div>

<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1080;">
    <div id="toast" class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body"></div>
            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const orderAppState = {
        orderType: 'dine-in',
        menu: [],
        flatMenu: [],
        vendor: {},
        cart: [],
        profile: {
            name: '',
            contact: '',
            email: '',
            table: ''
        },
        orders: [],
        endpoints: {
            menu: "{{ route('order.menu', ['code' => $vendor->code]) }}",
            store: "{{ route('order.store', ['code' => $vendor->code]) }}",
            history: "{{ route('order.history', ['code' => $vendor->code]) }}"
        },
        csrf: "{{ csrf_token() }}",
        filters: {
            search: '',
            category: 'all',
            sort: 'recommended'
        },
        orderFilters: {
            search: '',
            status: 'all',
            type: 'all'
        },
        ordersLoaded: false
    };

    const currency = new Intl.NumberFormat('en-IN', { style: 'currency', currency: 'INR' });

    function switchView(view) {
        $('[data-view]').removeClass('active');
        const target = $(`[data-view="${view}"]`);
        target.addClass('active');
        $('.nav-action').removeClass('active');
        $(`.nav-action[data-view-target="${view}"]`).addClass('active');

        if (view === 'profile' && orderAppState.profile.contact) {
            if (!orderAppState.ordersLoaded) {
                fetchOrders();
            }
        }
        if (view === 'checkout') {
            renderCheckout();
        }
        if (view === 'items') {
            renderItems();
        }
    }

    function showToast(message) {
        const toastEl = document.getElementById('toast');
        toastEl.querySelector('.toast-body').innerHTML = message;
        const toast = new bootstrap.Toast(toastEl);
        toast.show();
    }

    function showAlert(message, type = 'success') {
        $('#alertContainer').html(`
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `);
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function loadProfileFromStorage() {
        try {
            const stored = localStorage.getItem('orderAppProfile');
            if (stored) {
                orderAppState.profile = JSON.parse(stored);
            }
        } catch (error) {
            console.warn('Unable to load profile', error);
        }
    }

    function saveProfileToStorage() {
        localStorage.setItem('orderAppProfile', JSON.stringify(orderAppState.profile));
    }

    function renderProfileDetails() {
        const { name, email, contact, table } = orderAppState.profile;
        $('#profileNameDisplay').text(name || 'Guest');
        $('#profileEmailDisplay').text(email || 'Add your email');
        $('#profilePhoneDisplay').text(contact || 'Add your contact number');
        if (table) {
            $('#profileAvatar').attr('title', `Preferred table ${table}`);
        }

        $('#profileNameInput').val(name);
        $('#profileEmailInput').val(email);
        $('#profileContactInput').val(contact);
        $('#profileTableInput').val(table);

        $('#checkoutName').val(name);
        $('#checkoutEmail').val(email);
        $('#checkoutContact').val(contact);
        $('#checkoutTable').val(table);
    }

    function renderVendorDetails() {
        const vendor = orderAppState.vendor;
        $('#vendorName').text(vendor.name || '{{ optional($settings)->store_name ?? $vendor->name }}');
        $('#vendorBrand').html(`<i class="bi bi-bag-heart-fill me-2"></i>${vendor.name || '{{ optional($settings)->store_name ?? $vendor->name }}'}`);
        $('#orderTypeBadge').text(orderAppState.orderType === 'pickup' ? 'Pickup' : 'Dining');
        $('#checkoutOrderType').text(orderAppState.orderType === 'pickup' ? 'Pickup' : 'Dining');

        if (vendor.address) {
            $('#vendorAddress').text(vendor.address);
        }
        const contactBits = [];
        if (vendor.contact) {
            contactBits.push(`<i class="bi bi-telephone me-1"></i>${vendor.contact}`);
        }
        if (vendor.email) {
            contactBits.push(`<i class="bi bi-envelope ms-2 me-1"></i>${vendor.email}`);
        }
        $('#vendorContact').html(contactBits.join(''));

        if (vendor.logo) {
            $('#vendorLogoHolder').html(`<img src="${vendor.logo}" alt="${vendor.name}" class="img-fluid rounded-circle" style="width: 72px; height: 72px; object-fit: cover;">`);
        }
    }

    function flattenMenu(categories) {
        const flat = [];
        let index = 0;
        categories.forEach(category => {
            (category.items || []).forEach(item => {
                flat.push({
                    ...item,
                    category_id: category.id,
                    category_name: category.name,
                    sortIndex: index++
                });
            });
        });
        orderAppState.flatMenu = flat;
    }

    function renderCategoryOptions() {
        const select = $('#categorySelect');
        select.empty();
        select.append('<option value="all">All Categories</option>');
        const categoryNames = orderAppState.menu.map(category => ({ value: category.id, label: category.name }));
        categoryNames.forEach(cat => {
            select.append(`<option value="${cat.value}">${cat.label}</option>`);
        });
    }

    function getFilteredItems() {
        const { search, category, sort } = orderAppState.filters;
        let items = [...orderAppState.flatMenu];

        if (category !== 'all') {
            items = items.filter(item => String(item.category_id) === String(category));
        }

        if (search) {
            const query = search.toLowerCase();
            items = items.filter(item => item.name.toLowerCase().includes(query) || (item.description || '').toLowerCase().includes(query));
        }

        switch (sort) {
            case 'price-asc':
                items.sort((a, b) => (a.display_price || 0) - (b.display_price || 0));
                break;
            case 'price-desc':
                items.sort((a, b) => (b.display_price || 0) - (a.display_price || 0));
                break;
            case 'name-asc':
                items.sort((a, b) => a.name.localeCompare(b.name));
                break;
            default:
                items.sort((a, b) => a.sortIndex - b.sortIndex);
        }

        return items;
    }

    function getMenuItemKey(item) {
        return `${item.id || 'custom'}::${item.default_variant || 'default'}`;
    }

    function renderItems() {
        const grid = $('#itemsGrid');
        const emptyState = $('#itemsEmptyState');
        grid.empty();

        const filtered = getFilteredItems();
        if (!filtered.length) {
            emptyState.removeClass('d-none');
            return;
        }
        emptyState.addClass('d-none');

        filtered.forEach(item => {
            const priceText = item.display_price ? currency.format(item.display_price) : 'Unavailable';
            const disabled = !item.display_price || item.display_price <= 0;
            const description = item.description ? `<p class="text-secondary small mb-2">${item.description}</p>` : '';
            const image = item.image_url
                ? `<img src="${item.image_url}" alt="${item.name}">`
                : `<div class="item-placeholder"><i class="bi bi-image"></i></div>`;
            const menuKey = getMenuItemKey(item);
            grid.append(`
                <div class="col-6 col-md-4 col-xl-3">
                    <div class="item-card h-100 d-flex flex-column">
                        <div class="item-media">${image}</div>
                        <div class="card-body">
                            <div class="card-title" title="${item.name}">${item.name}</div>
                            <div class="meta text-uppercase small text-secondary mb-1">${item.category_name}</div>
                            ${description}
                            <div class="mt-auto d-flex align-items-center justify-content-between gap-2">
                                <span class="price fw-bold">${priceText}</span>
                                <button class="btn btn-sm btn-primary add-btn add-to-cart-btn" data-menu-key="${menuKey}" ${disabled ? 'disabled' : ''}>Add</button>
                            </div>
                        </div>
                    </div>
                </div>
            `);
        });
    }

    function getCartKey(item) {
        return `${item.id || 'custom'}::${item.variant || 'default'}`;
    }

    function addItemToCart(item) {
        const key = getCartKey(item);
        const existing = orderAppState.cart.find(cartItem => cartItem.key === key);
        if (existing) {
            existing.quantity += 1;
        } else {
            orderAppState.cart.push({
                key,
                id: item.id,
                name: item.name,
                price: item.display_price,
                quantity: 1,
                variant: item.default_variant,
                image_url: item.image_url
            });
        }
        renderCart();
        renderCheckout();
        showToast(`${item.name} added to cart.`);
    }

    function updateCartQuantity(key, delta) {
        const index = orderAppState.cart.findIndex(item => item.key === key);
        if (index === -1) {
            return;
        }
        orderAppState.cart[index].quantity += delta;
        if (orderAppState.cart[index].quantity <= 0) {
            orderAppState.cart.splice(index, 1);
        }
        renderCart();
        renderCheckout();
    }

    function clearCart() {
        orderAppState.cart = [];
        renderCart();
        renderCheckout();
    }

    function renderCart() {
        const cartItemsContainer = $('#cartItems');
        cartItemsContainer.empty();
        const totalItems = orderAppState.cart.reduce((sum, item) => sum + item.quantity, 0);
        const subtotal = orderAppState.cart.reduce((sum, item) => sum + item.price * item.quantity, 0);

        $('#cartItemsCount').text(totalItems);
        $('#cartSubtotal').text(currency.format(subtotal));
        $('#drawerSubtotal').text(currency.format(subtotal));
        $('#cartCountBadge').text(totalItems);
        $('#navCartCount').text(totalItems);

        if (!orderAppState.cart.length) {
            cartItemsContainer.html(`
                <div class="text-center text-secondary py-4">
                    <i class="bi bi-bag-dash display-6 d-block mb-3"></i>
                    <p class="mb-0">Your cart is empty. Add some items from the menu.</p>
                </div>
            `);
            return;
        }

        orderAppState.cart.forEach(item => {
            cartItemsContainer.append(`
                <div class="cart-item-row py-3" data-cart-key="${item.key}">
                    <div class="d-flex align-items-start justify-content-between gap-3">
                        <div class="d-flex align-items-start gap-3">
                            ${item.image_url ? `<img src="${item.image_url}" alt="${item.name}" class="rounded" style="width:60px;height:60px;object-fit:cover;">` : '<div class="rounded bg-light" style="width:60px;height:60px;"></div>'}
                            <div>
                                <div class="fw-semibold">${item.name}</div>
                                ${item.variant ? `<span class="badge bg-light text-dark border">${item.variant}</span>` : ''}
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="btn-group btn-group-sm mb-2" role="group">
                                <button type="button" class="btn btn-outline-secondary cart-decrement" data-cart-key="${item.key}">-</button>
                                <button type="button" class="btn btn-light" disabled>${item.quantity}</button>
                                <button type="button" class="btn btn-outline-secondary cart-increment" data-cart-key="${item.key}">+</button>
                            </div>
                            <div class="fw-semibold">${currency.format(item.price * item.quantity)}</div>
                            <button class="btn btn-link text-danger p-0 cart-remove" data-cart-key="${item.key}">Remove</button>
                        </div>
                    </div>
                </div>
            `);
        });
    }

    function renderCheckout() {
        const container = $('#checkoutItems');
        container.empty();
        const subtotal = orderAppState.cart.reduce((sum, item) => sum + item.price * item.quantity, 0);
        $('#checkoutSubtotal').text(currency.format(subtotal));
        $('#checkoutTotal').text(currency.format(subtotal));

        if (!orderAppState.cart.length) {
            container.html('<div class="alert alert-info">Your cart is empty. Add items from the menu to place an order.</div>');
            $('#placeOrderBtn').prop('disabled', true);
            return;
        }

        $('#placeOrderBtn').prop('disabled', false);

        orderAppState.cart.forEach(item => {
            container.append(`
                <div class="d-flex align-items-start justify-content-between border-bottom py-2">
                    <div>
                        <div class="fw-semibold">${item.name}</div>
                        ${item.variant ? `<div class="small text-secondary">${item.variant}</div>` : ''}
                        <div class="small text-secondary">Qty: ${item.quantity}</div>
                    </div>
                    <div class="fw-semibold">${currency.format(item.price * item.quantity)}</div>
                </div>
            `);
        });
    }

    function setOrderType(value) {
        orderAppState.orderType = value;
        $('#orderTypeBadge').text(value === 'pickup' ? 'Pickup' : 'Dining');
        $('#checkoutOrderType').text(value === 'pickup' ? 'Pickup' : 'Dining');
        $('#selectionText').text(`Selected: ${value === 'pickup' ? 'Pickup Order' : 'Dining Order'}`);
        $(`input[name="order_type"][value="${value}"]`).prop('checked', true);
        $('.option-card').removeClass('active');
        $(`.option-card[data-value="${value}"]`).addClass('active');
        if (value === 'pickup') {
            $('#tableNumberGroup').hide();
        } else {
            $('#tableNumberGroup').show();
        }
    }

    function fetchMenu() {
        $.getJSON(orderAppState.endpoints.menu)
            .done(data => {
                orderAppState.vendor = data.vendor || {};
                orderAppState.menu = data.categories || [];
                flattenMenu(orderAppState.menu);
                renderCategoryOptions();
                renderItems();
                renderVendorDetails();
            })
            .fail(() => {
                showAlert('Unable to load menu details. Please try again later.', 'danger');
            });
    }

    function submitOrder(event) {
        event.preventDefault();
        if (!orderAppState.cart.length) {
            showAlert('Please add items to your cart before placing an order.', 'warning');
            return;
        }

        const payload = {
            order_type: orderAppState.orderType,
            customer_name: $('#checkoutName').val(),
            contact_no: $('#checkoutContact').val(),
            email: $('#checkoutEmail').val(),
            table_number: orderAppState.orderType === 'dine-in' ? $('#checkoutTable').val() : null,
            special_request: $('#checkoutNotes').val(),
            items: orderAppState.cart.map(item => ({
                id: item.id,
                name: item.name,
                price: item.price,
                quantity: item.quantity,
                variant: item.variant
            }))
        };

        if (orderAppState.orderType === 'dine-in' && !payload.table_number) {
            showAlert('Please provide a table number for dine-in orders.', 'warning');
            return;
        }

        orderAppState.profile = {
            name: payload.customer_name,
            contact: payload.contact_no,
            email: payload.email,
            table: orderAppState.orderType === 'dine-in' ? $('#checkoutTable').val() : orderAppState.profile.table
        };
        saveProfileToStorage();
        renderProfileDetails();

        $('#placeOrderBtn').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Placing');

        $.ajax({
            url: orderAppState.endpoints.store,
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(payload),
            headers: {
                'X-CSRF-TOKEN': orderAppState.csrf
            }
        })
            .done(response => {
                const orderId = response?.data?.order_id ? ` ${response.data.order_id}` : '';
                showAlert(`Order${orderId} placed successfully!`);
                orderAppState.cart = [];
                renderCart();
                renderCheckout();
                orderAppState.ordersLoaded = false;
                if (orderAppState.profile.contact) {
                    fetchOrders();
                }
                switchView('profile');
            })
            .fail(xhr => {
                const errors = xhr.responseJSON?.errors || ['Unable to place order. Please try again.'];
                showAlert(errors.join('<br>'), 'danger');
            })
            .always(() => {
                $('#placeOrderBtn').prop('disabled', false).html('<i class="bi bi-check2-circle me-1"></i>Place Order');
            });
    }

    function fetchOrders() {
        if (!orderAppState.profile.contact) {
            $('#ordersNotice').removeClass('d-none').text('Add your contact number to fetch order history.');
            $('#ordersTableBody').empty();
            $('#ordersEmptyState').addClass('d-none');
            return;
        }

        $('#ordersNotice').addClass('d-none');
        $('#ordersTableBody').html('<tr><td colspan="6" class="text-center py-4"><div class="spinner-border text-primary"></div><p class="mt-2 mb-0">Loading orders…</p></td></tr>');

        const params = { contact: orderAppState.profile.contact };
        if (orderAppState.profile.email) {
            params.email = orderAppState.profile.email;
        }

        $.get(orderAppState.endpoints.history, params)
            .done(response => {
                orderAppState.orders = response.orders || [];
                orderAppState.ordersLoaded = true;
                renderOrders();
            })
            .fail(() => {
                $('#ordersTableBody').html('<tr><td colspan="6" class="text-center py-4 text-danger">Unable to load orders. Please try again later.</td></tr>');
            });
    }

    function renderOrders() {
        const { search, status, type } = orderAppState.orderFilters;
        let orders = [...orderAppState.orders];

        if (status !== 'all') {
            orders = orders.filter(order => order.status === status);
        }
        if (type !== 'all') {
            orders = orders.filter(order => order.order_type === type);
        }
        if (search) {
            const query = search.toLowerCase();
            orders = orders.filter(order => {
                const inId = (order.order_id || '').toLowerCase().includes(query);
                const inItems = (order.items || []).some(item => item.name.toLowerCase().includes(query));
                return inId || inItems;
            });
        }

        const tbody = $('#ordersTableBody');
        tbody.empty();

        if (!orders.length) {
            $('#ordersEmptyState').removeClass('d-none');
        } else {
            $('#ordersEmptyState').addClass('d-none');
        }

        orders.forEach(order => {
            const statusBadgeClass = order.status === 'completed'
                ? 'bg-success'
                : order.status === 'cancelled'
                    ? 'bg-danger'
                    : 'bg-warning text-dark';
            const itemsList = (order.items || []).map(item => `<div>${item.name} <span class="text-secondary">× ${item.quantity}</span></div>`).join('');
            tbody.append(`
                <tr>
                    <td class="fw-semibold">${order.order_id || '--'}</td>
                    <td><span class="badge rounded-pill text-bg-light text-uppercase">${order.order_type || '--'}</span></td>
                    <td><span class="badge ${statusBadgeClass} text-uppercase">${order.status || '--'}</span></td>
                    <td>${currency.format(order.total_amount || 0)}</td>
                    <td>
                        <div>${order.order_date || ''}</div>
                        <small class="text-secondary">${order.order_time || ''}</small>
                    </td>
                    <td>${itemsList}</td>
                </tr>
            `);
        });

        const totalOrders = orderAppState.orders.length;
        const totalSpent = orderAppState.orders.reduce((sum, order) => sum + (order.total_amount || 0), 0);
        const activeOrders = orderAppState.orders.filter(order => ['placed', 'preparing', 'ready'].includes(order.status)).length;
        const cancelledOrders = orderAppState.orders.filter(order => order.status === 'cancelled').length;

        $('#ordersCount').text(totalOrders);
        $('#totalSpent').text(currency.format(totalSpent));
        $('#activeOrdersCount').text(activeOrders);
        $('#cancelledOrdersCount').text(cancelledOrders);
    }

    $(document).ready(function () {
        loadProfileFromStorage();
        renderProfileDetails();
        renderCheckout();
        renderCart();
        fetchMenu();

        $('[data-view-target]').on('click', function (event) {
            event.preventDefault();
            const target = $(this).data('view-target');
            if (target) {
                switchView(target);
            }
        });

        $('.option-card').on('click keydown', function (event) {
            if (event.type === 'keydown' && !['Enter', ' '].includes(event.key)) {
                return;
            }
            const value = $(this).data('value');
            $(`input[name="order_type"][value="${value}"]`).prop('checked', true);
            $('.option-card').removeClass('active');
            $(this).addClass('active');
            setOrderType(value);
        });

        $('#orderTypeForm').on('submit', function (event) {
            event.preventDefault();
            const selected = $('input[name="order_type"]:checked').val();
            setOrderType(selected);
            switchView('items');
        });

        $('#searchInput').on('input', function () {
            orderAppState.filters.search = $(this).val();
            renderItems();
        });

        $('#categorySelect').on('change', function () {
            orderAppState.filters.category = $(this).val();
            renderItems();
        });

        $('#sortSelect').on('change', function () {
            orderAppState.filters.sort = $(this).val();
            renderItems();
        });

        $(document).on('click', '.add-to-cart-btn', function () {
            const key = $(this).data('menu-key');
            const item = orderAppState.flatMenu.find(menuItem => getMenuItemKey(menuItem) === key);
            if (item) {
                addItemToCart(item);
            }
        });

        $(document).on('click', '.cart-increment', function () {
            updateCartQuantity($(this).data('cart-key'), 1);
        });

        $(document).on('click', '.cart-decrement', function () {
            updateCartQuantity($(this).data('cart-key'), -1);
        });

        $(document).on('click', '.cart-remove', function () {
            const key = $(this).data('cart-key');
            orderAppState.cart = orderAppState.cart.filter(item => item.key !== key);
            renderCart();
            renderCheckout();
        });

        $('#clearCartBtn, #drawerClearCartBtn').on('click', function () {
            clearCart();
        });

        $('#drawerCheckoutBtn').on('click', function () {
            switchView('checkout');
        });

        $('#checkoutForm').on('submit', submitOrder);

        $('#profileForm').on('submit', function (event) {
            event.preventDefault();
            orderAppState.profile = {
                name: $('#profileNameInput').val(),
                email: $('#profileEmailInput').val(),
                contact: $('#profileContactInput').val(),
                table: $('#profileTableInput').val()
            };
            saveProfileToStorage();
            renderProfileDetails();
            showToast('Profile updated successfully.');
            orderAppState.ordersLoaded = false;
        });

        $('#refreshOrdersBtn').on('click', function () {
            orderAppState.ordersLoaded = false;
            fetchOrders();
        });

        $('#ordersSearch').on('input', function () {
            orderAppState.orderFilters.search = $(this).val();
            renderOrders();
        });

        $('#ordersStatus').on('change', function () {
            orderAppState.orderFilters.status = $(this).val();
            renderOrders();
        });

        $('#ordersType').on('change', function () {
            orderAppState.orderFilters.type = $(this).val();
            renderOrders();
        });

        setOrderType(orderAppState.orderType);
    });
</script>
</body>
</html>
