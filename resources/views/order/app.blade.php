<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ optional($settings)->store_name ?? $vendor->name }} - Order</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnHOXzcrYwY/fx/n6PvJEa3TBUnIFJQGryuVKyXjH9MuquxYZcQJUO2c+hJ1ytY1/6V2vNh+lX6YsJhBKt3U1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            background-color: #f8f9fa;
        }
        .app-navbar {
            background: linear-gradient(135deg, #f97316, #fb923c);
        }
        .app-navbar .nav-link,
        .app-navbar .navbar-brand {
            color: #fff !important;
            font-weight: 600;
        }
        .app-section {
            display: none;
        }
        .app-section.active {
            display: block;
        }
        .category-card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            margin-bottom: 1.5rem;
        }
        .category-card .card-header {
            background: transparent;
            border-bottom: none;
            font-size: 1.25rem;
            font-weight: 600;
        }
        .menu-item {
            border-radius: 0.75rem;
            border: 1px solid #f1f5f9;
            padding: 1rem;
            margin-bottom: 1rem;
            display: flex;
            gap: 1rem;
            align-items: center;
            background-color: #fff;
        }
        .menu-item img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 0.5rem;
        }
        .menu-item h6 {
            margin-bottom: 0.25rem;
            font-weight: 600;
        }
        .menu-item button {
            white-space: nowrap;
        }
        .summary-card {
            border-radius: 1rem;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.08);
        }
        .profile-avatar {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: #fee2e2;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: #dc2626;
        }
        .order-badge {
            font-size: 0.75rem;
        }
        .cart-empty {
            text-align: center;
            padding: 3rem 0;
            color: #6b7280;
        }
        .cart-empty i {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        .nav-pills .nav-link.active {
            background-color: #fb923c;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg app-navbar">
    <div class="container">
        <a class="navbar-brand" href="#">{{ optional($settings)->store_name ?? $vendor->name }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#orderNav"
                aria-controls="orderNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="orderNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" data-section="home" href="#">Home</a></li>
                <li class="nav-item"><a class="nav-link" data-section="items" href="#">Items</a></li>
                <li class="nav-item"><a class="nav-link" data-section="cart" href="#">Cart</a></li>
                <li class="nav-item"><a class="nav-link" data-section="checkout" href="#">Checkout</a></li>
                <li class="nav-item"><a class="nav-link" data-section="profile" href="#">Profile</a></li>
                <li class="nav-item"><a class="nav-link" data-section="orders" href="#">Orders</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container py-4">
    <div id="alertContainer"></div>

    <section id="section-home" class="app-section active">
        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card summary-card border-0">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="profile-avatar me-3" id="vendorLogoHolder">
                                <i class="fas fa-store"></i>
                            </div>
                            <div>
                                <h3 class="mb-1" id="vendorName">{{ optional($settings)->store_name ?? $vendor->name }}</h3>
                                <p class="mb-0 text-muted" id="vendorAddress">{{ optional($settings)->store_address }}</p>
                                <small class="text-muted d-block" id="vendorContact"></small>
                            </div>
                        </div>
                        <h5 class="mb-3">Choose Order Type</h5>
                        <div class="btn-group" role="group" aria-label="Order Type">
                            <input type="radio" class="btn-check" name="orderType" id="orderTypeDining" value="dine-in" autocomplete="off" checked>
                            <label class="btn btn-outline-primary" for="orderTypeDining"><i class="fas fa-chair me-2"></i>Dine-in</label>

                            <input type="radio" class="btn-check" name="orderType" id="orderTypePickup" value="pickup" autocomplete="off">
                            <label class="btn btn-outline-primary" for="orderTypePickup"><i class="fas fa-bag-shopping me-2"></i>Pickup</label>
                        </div>
                        <div class="mt-4">
                            <h6 class="text-muted">Quick Actions</h6>
                            <div class="d-flex flex-wrap gap-2">
                                <button class="btn btn-sm btn-primary" data-section="items"><i class="fas fa-utensils me-2"></i>View Menu</button>
                                <button class="btn btn-sm btn-outline-primary" data-section="cart"><i class="fas fa-cart-shopping me-2"></i>View Cart</button>
                                <button class="btn btn-sm btn-outline-secondary" data-section="orders"><i class="fas fa-list me-2"></i>Order History</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card border-0 summary-card h-100">
                    <div class="card-body p-4">
                        <h5 class="mb-3">Saved Profile</h5>
                        <p class="text-muted">Keep your profile updated for faster checkout.</p>
                        <div class="border rounded p-3 bg-light">
                            <div class="d-flex align-items-center mb-3">
                                <div class="profile-avatar me-3" id="profileAvatar">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0" id="profileName">Guest</h6>
                                    <small class="text-muted" id="profileContact">Add your details</small>
                                </div>
                            </div>
                            <button class="btn btn-primary w-100" data-section="profile">Update Profile</button>
                        </div>
                        <hr>
                        <h5 class="mb-3">Cart Snapshot</h5>
                        <p class="h4 mb-0" id="cartSummaryTotal">₹0.00</p>
                        <small class="text-muted" id="cartSummaryItems">0 items in cart</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="section-items" class="app-section">
        <div id="menuContainer"></div>
    </section>

    <section id="section-cart" class="app-section">
        <div class="card border-0 summary-card">
            <div class="card-body p-4">
                <h4 class="card-title mb-4">Your Cart</h4>
                <div id="cartContent"></div>
            </div>
        </div>
    </section>

    <section id="section-checkout" class="app-section">
        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card border-0 summary-card">
                    <div class="card-body p-4">
                        <h4 class="mb-4">Checkout</h4>
                        <form id="checkoutForm">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="checkoutName" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="checkoutName" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="checkoutContact" class="form-label">Contact Number</label>
                                    <input type="tel" class="form-control" id="checkoutContact" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="checkoutEmail" class="form-label">Email (optional)</label>
                                    <input type="email" class="form-control" id="checkoutEmail">
                                </div>
                                <div class="col-md-6" id="tableNumberWrapper">
                                    <label for="checkoutTable" class="form-label">Table Number</label>
                                    <input type="text" class="form-control" id="checkoutTable" placeholder="e.g. T5">
                                </div>
                                <div class="col-12">
                                    <label for="checkoutNotes" class="form-label">Special Request</label>
                                    <textarea class="form-control" id="checkoutNotes" rows="3" placeholder="Any special instructions..."></textarea>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <div>
                                    <p class="mb-0 text-muted">Total</p>
                                    <h4 class="mb-0" id="checkoutTotal">₹0.00</h4>
                                </div>
                                <button type="submit" class="btn btn-primary btn-lg" id="placeOrderBtn">
                                    <i class="fas fa-receipt me-2"></i>Place Order
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card border-0 summary-card">
                    <div class="card-body p-4">
                        <h5 class="mb-3">Order Summary</h5>
                        <ul class="list-group list-group-flush" id="checkoutSummaryList"></ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="section-profile" class="app-section">
        <div class="card border-0 summary-card">
            <div class="card-body p-4">
                <h4 class="mb-4">Profile</h4>
                <form id="profileForm" class="row g-3">
                    <div class="col-md-6">
                        <label for="profileNameInput" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="profileNameInput" placeholder="Your name">
                    </div>
                    <div class="col-md-6">
                        <label for="profileContactInput" class="form-label">Contact Number</label>
                        <input type="tel" class="form-control" id="profileContactInput" placeholder="Mobile number">
                    </div>
                    <div class="col-md-6">
                        <label for="profileEmailInput" class="form-label">Email</label>
                        <input type="email" class="form-control" id="profileEmailInput" placeholder="Email address">
                    </div>
                    <div class="col-md-6">
                        <label for="profileTableInput" class="form-label">Default Table Number</label>
                        <input type="text" class="form-control" id="profileTableInput" placeholder="Table number for dine-in">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Save Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <section id="section-orders" class="app-section">
        <div class="card border-0 summary-card">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">Order History</h4>
                    <button class="btn btn-outline-primary" id="refreshOrdersBtn"><i class="fas fa-rotate me-2"></i>Refresh</button>
                </div>
                <div id="ordersContent" class="table-responsive"></div>
            </div>
        </div>
    </section>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-3gJwYp4Zp8F6wU5Z1rGqLZ8WI1Jd2GfX5+7Z2e3Q3C0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const orderAppState = {
        orderType: 'dine-in',
        menu: [],
        vendor: {},
        cart: [],
        profile: {
            name: '',
            contact: '',
            email: '',
            table: ''
        },
        endpoints: {
            menu: "{{ route('order.menu', ['code' => $vendor->code]) }}",
            store: "{{ route('order.store', ['code' => $vendor->code]) }}",
            history: "{{ route('order.history', ['code' => $vendor->code]) }}"
        },
        csrf: "{{ csrf_token() }}"
    };

    const currency = new Intl.NumberFormat('en-IN', { style: 'currency', currency: 'INR' });

    function showSection(section) {
        $('.app-section').removeClass('active');
        $('#section-' + section).addClass('active');
        $('a.nav-link').removeClass('active');
        $(`a.nav-link[data-section="${section}"]`).addClass('active');
    }

    function showAlert(message, type = 'success') {
        const alertHtml = `<div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>`;
        $('#alertContainer').html(alertHtml);
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function loadProfileFromStorage() {
        try {
            const stored = localStorage.getItem('orderAppProfile');
            if (stored) {
                orderAppState.profile = JSON.parse(stored);
            }
        } catch (e) {
            console.warn('Unable to load profile from storage', e);
        }
    }

    function saveProfileToStorage() {
        localStorage.setItem('orderAppProfile', JSON.stringify(orderAppState.profile));
    }

    function renderProfileSummary() {
        const { name, contact } = orderAppState.profile;
        $('#profileName').text(name || 'Guest');
        $('#profileContact').text(contact || 'Add your details');

        $('#profileNameInput').val(orderAppState.profile.name);
        $('#profileContactInput').val(orderAppState.profile.contact);
        $('#profileEmailInput').val(orderAppState.profile.email);
        $('#profileTableInput').val(orderAppState.profile.table);

        $('#checkoutName').val(orderAppState.profile.name);
        $('#checkoutContact').val(orderAppState.profile.contact);
        $('#checkoutEmail').val(orderAppState.profile.email);
        $('#checkoutTable').val(orderAppState.profile.table);
    }

    function renderVendorDetails() {
        const vendor = orderAppState.vendor;
        if (vendor.logo) {
            $('#vendorLogoHolder').html(`<img src="${vendor.logo}" alt="Vendor Logo" class="img-fluid rounded-circle" style="width: 90px; height: 90px; object-fit: cover;">`);
        }
        $('#vendorName').text(vendor.name || '{{ optional($settings)->store_name ?? $vendor->name }}');
        $('#vendorAddress').text(vendor.address || '');
        const contactLines = [];
        if (vendor.contact) contactLines.push(`<i class="fas fa-phone me-1"></i>${vendor.contact}`);
        if (vendor.email) contactLines.push(`<i class="fas fa-envelope ms-2 me-1"></i>${vendor.email}`);
        $('#vendorContact').html(contactLines.join(''));
    }

    function renderMenu() {
        const container = $('#menuContainer');
        container.empty();

        if (!orderAppState.menu.length) {
            container.html('<div class="alert alert-info">Menu is being prepared. Please check back soon.</div>');
            return;
        }

        orderAppState.menu.forEach(category => {
            const card = $('<div class="card category-card"></div>');
            const header = $('<div class="card-header d-flex align-items-center justify-content-between"></div>');
            header.append(`<span>${category.name}</span>`);
            card.append(header);

            const body = $('<div class="card-body"></div>');
            category.items.forEach(item => {
                const itemRow = $('<div class="menu-item"></div>');
                if (item.image_url) {
                    itemRow.append(`<img src="${item.image_url}" alt="${item.name}">`);
                }
                const details = $('<div class="flex-grow-1"></div>');
                details.append(`<h6>${item.name}</h6>`);
                if (item.description) {
                    details.append(`<p class="text-muted mb-1">${item.description}</p>`);
                }
                const priceText = item.display_price ? currency.format(item.display_price) : 'Price on request';
                details.append(`<strong>${priceText}</strong>`);
                itemRow.append(details);
                const button = $('<button class="btn btn-sm btn-primary">Add</button>');
                if (item.display_price <= 0) {
                    button.addClass('btn-outline-secondary').removeClass('btn-primary').prop('disabled', true).text('Unavailable');
                } else {
                    button.on('click', () => addItemToCart(item));
                }
                itemRow.append(button);
                body.append(itemRow);
            });
            card.append(body);
            container.append(card);
        });
    }

    function addItemToCart(item) {
        const existingIndex = orderAppState.cart.findIndex(cartItem => cartItem.id === item.id && cartItem.variant === item.default_variant);
        if (existingIndex >= 0) {
            orderAppState.cart[existingIndex].quantity += 1;
        } else {
            orderAppState.cart.push({
                id: item.id,
                name: item.name,
                price: item.display_price,
                quantity: 1,
                variant: item.default_variant,
            });
        }
        renderCart();
        renderCheckoutSummary();
        updateCartSummaryWidget();
        showAlert(`${item.name} added to cart.`);
    }

    function updateCartSummaryWidget() {
        const totalItems = orderAppState.cart.reduce((sum, item) => sum + item.quantity, 0);
        const totalAmount = orderAppState.cart.reduce((sum, item) => sum + item.price * item.quantity, 0);
        $('#cartSummaryItems').text(`${totalItems} item${totalItems === 1 ? '' : 's'} in cart`);
        $('#cartSummaryTotal').text(currency.format(totalAmount));
    }

    function renderCart() {
        const container = $('#cartContent');
        container.empty();

        if (!orderAppState.cart.length) {
            container.html(`<div class="cart-empty">
                <i class="fas fa-cart-arrow-down"></i>
                <p>Your cart is empty. Explore the menu to add items.</p>
                <button class="btn btn-primary" data-section="items">Browse Menu</button>
            </div>`);
            return;
        }

        const table = $('<table class="table align-middle"></table>');
        table.append('<thead><tr><th>Item</th><th class="text-center">Qty</th><th class="text-end">Price</th><th></th></tr></thead>');
        const tbody = $('<tbody></tbody>');

        orderAppState.cart.forEach((item, index) => {
            const row = $('<tr></tr>');
            row.append(`<td>
                <strong>${item.name}</strong>
                ${item.variant ? `<span class="badge bg-secondary ms-2">${item.variant}</span>` : ''}
            </td>`);
            const qtyCell = $('<td class="text-center"></td>');
            const qtyGroup = $('<div class="input-group input-group-sm justify-content-center" style="max-width: 140px; margin: auto;"></div>');
            const minusBtn = $('<button class="btn btn-outline-secondary" type="button"><i class="fas fa-minus"></i></button>');
            const plusBtn = $('<button class="btn btn-outline-secondary" type="button"><i class="fas fa-plus"></i></button>');
            const qtyInput = $(`<input type="number" class="form-control text-center" value="${item.quantity}" min="1">`);

            minusBtn.on('click', () => updateCartQuantity(index, item.quantity - 1));
            plusBtn.on('click', () => updateCartQuantity(index, item.quantity + 1));
            qtyInput.on('change', (event) => updateCartQuantity(index, parseInt(event.target.value, 10)));

            qtyGroup.append(minusBtn, qtyInput, plusBtn);
            qtyCell.append(qtyGroup);
            row.append(qtyCell);

            row.append(`<td class="text-end">${currency.format(item.price * item.quantity)}</td>`);
            const removeCell = $('<td class="text-end"></td>');
            const removeBtn = $('<button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>');
            removeBtn.on('click', () => removeCartItem(index));
            removeCell.append(removeBtn);
            row.append(removeCell);

            tbody.append(row);
        });

        table.append(tbody);
        container.append(table);
    }

    function updateCartQuantity(index, quantity) {
        if (!Number.isFinite(quantity)) {
            quantity = 1;
        }

        if (quantity <= 0) {
            removeCartItem(index);
            return;
        }
        orderAppState.cart[index].quantity = Math.floor(quantity);
        renderCart();
        renderCheckoutSummary();
        updateCartSummaryWidget();
    }

    function removeCartItem(index) {
        orderAppState.cart.splice(index, 1);
        renderCart();
        renderCheckoutSummary();
        updateCartSummaryWidget();
    }

    function renderCheckoutSummary() {
        const list = $('#checkoutSummaryList');
        list.empty();
        const total = orderAppState.cart.reduce((sum, item) => sum + item.price * item.quantity, 0);
        $('#checkoutTotal').text(currency.format(total));

        if (!orderAppState.cart.length) {
            list.append('<li class="list-group-item">Your cart is empty.</li>');
            $('#placeOrderBtn').prop('disabled', true);
            return;
        }

        $('#placeOrderBtn').prop('disabled', false);

        orderAppState.cart.forEach(item => {
            list.append(`<li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <strong>${item.name}</strong>
                    ${item.variant ? `<span class="badge bg-secondary ms-2">${item.variant}</span>` : ''}
                    <div class="text-muted small">Qty: ${item.quantity}</div>
                </div>
                <span>${currency.format(item.price * item.quantity)}</span>
            </li>`);
        });

        list.append(`<li class="list-group-item d-flex justify-content-between">
            <strong>Total</strong>
            <strong>${currency.format(total)}</strong>
        </li>`);
    }

    function fetchMenu() {
        $.getJSON(orderAppState.endpoints.menu)
            .done(data => {
                orderAppState.vendor = data.vendor || {};
                orderAppState.menu = data.categories || [];
                renderVendorDetails();
                renderMenu();
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

        orderAppState.profile = {
            name: payload.customer_name,
            contact: payload.contact_no,
            email: payload.email,
            table: orderAppState.orderType === 'dine-in' ? $('#checkoutTable').val() : orderAppState.profile.table,
        };
        saveProfileToStorage();
        renderProfileSummary();

        $('#placeOrderBtn').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Placing...');

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
            showAlert(`Order ${response.data.order_id} placed successfully!`, 'success');
            orderAppState.cart = [];
            renderCart();
            renderCheckoutSummary();
            updateCartSummaryWidget();
            fetchOrders();
        })
        .fail(xhr => {
            const errors = xhr.responseJSON?.errors || ['Unable to place order. Please try again.'];
            showAlert(errors.join('<br>'), 'danger');
        })
        .always(() => {
            $('#placeOrderBtn').prop('disabled', false).html('<i class="fas fa-receipt me-2"></i>Place Order');
        });
    }

    function fetchOrders() {
        if (!orderAppState.profile.contact) {
            $('#ordersContent').html('<div class="alert alert-info">Update your profile with a contact number to view your orders.</div>');
            return;
        }

        const params = {
            contact: orderAppState.profile.contact,
        };
        if (orderAppState.profile.email) {
            params.email = orderAppState.profile.email;
        }

        $('#ordersContent').html('<div class="text-center py-4"><div class="spinner-border text-primary"></div><p class="mt-2">Loading orders...</p></div>');

        $.get(orderAppState.endpoints.history, params)
            .done(response => {
                renderOrderHistory(response.orders || []);
            })
            .fail(() => {
                $('#ordersContent').html('<div class="alert alert-danger">Unable to load orders. Please try again later.</div>');
            });
    }

    function renderOrderHistory(orders) {
        if (!orders.length) {
            $('#ordersContent').html('<div class="alert alert-info">No orders found for the provided contact details.</div>');
            return;
        }

        const table = $('<table class="table table-striped align-middle"></table>');
        table.append('<thead><tr><th>Order ID</th><th>Type</th><th>Status</th><th>Amount</th><th>Placed At</th><th>Items</th></tr></thead>');
        const tbody = $('<tbody></tbody>');

        orders.forEach(order => {
            const row = $('<tr></tr>');
            row.append(`<td><span class="fw-semibold">${order.order_id}</span></td>`);
            row.append(`<td><span class="badge bg-primary order-badge text-uppercase">${order.order_type}</span></td>`);
            row.append(`<td><span class="badge bg-${order.status === 'completed' ? 'success' : order.status === 'cancelled' ? 'danger' : 'warning'} text-dark">${order.status}</span></td>`);
            row.append(`<td>${currency.format(order.total_amount)}</td>`);
            row.append(`<td><div>${order.order_date || ''}</div><small class="text-muted">${order.order_time || ''}</small></td>`);
            const itemList = order.items.map(item => `<div>${item.name} <span class="text-muted">× ${item.quantity}</span></div>`).join('');
            row.append(`<td>${itemList}</td>`);
            tbody.append(row);
        });

        table.append(tbody);
        $('#ordersContent').html(table);
    }

    $(document).ready(function () {
        loadProfileFromStorage();
        renderProfileSummary();
        renderCheckoutSummary();
        updateCartSummaryWidget();
        fetchMenu();

        $('a.nav-link, button[data-section]').on('click', function (event) {
            event.preventDefault();
            const section = $(this).data('section');
            if (section) {
                showSection(section);
                if (section === 'orders') {
                    fetchOrders();
                }
            }
        });

        $('input[name="orderType"]').on('change', function () {
            orderAppState.orderType = $(this).val();
            if (orderAppState.orderType === 'pickup') {
                $('#tableNumberWrapper').hide();
            } else {
                $('#tableNumberWrapper').show();
            }
        });

        if (orderAppState.orderType === 'pickup') {
            $('#tableNumberWrapper').hide();
        }

        $('#profileForm').on('submit', function (event) {
            event.preventDefault();
            orderAppState.profile = {
                name: $('#profileNameInput').val(),
                contact: $('#profileContactInput').val(),
                email: $('#profileEmailInput').val(),
                table: $('#profileTableInput').val(),
            };
            saveProfileToStorage();
            renderProfileSummary();
            showAlert('Profile updated successfully.');
            if ($('#section-orders').hasClass('active')) {
                fetchOrders();
            }
        });

        $('#checkoutForm').on('submit', submitOrder);
        $('#refreshOrdersBtn').on('click', fetchOrders);

        showSection('home');
    });
</script>
</body>
</html>
