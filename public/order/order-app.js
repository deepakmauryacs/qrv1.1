(function ($) {
    'use strict';

    const config = window.orderAppConfig || {};
    const currency = new Intl.NumberFormat('en-IN', { style: 'currency', currency: 'INR' });
    const storageKeys = {
        profile: 'orderAppProfile',
        cart: 'orderAppCart',
        orderType: 'orderAppOrderType'
    };

    function loadFromStorage(key, fallback) {
        try {
            const value = localStorage.getItem(key);
            if (!value) {
                return fallback;
            }
            return JSON.parse(value);
        } catch (error) {
            console.warn('Unable to read from storage', error);
            return fallback;
        }
    }

    function saveToStorage(key, value) {
        try {
            localStorage.setItem(key, JSON.stringify(value));
        } catch (error) {
            console.warn('Unable to persist data', error);
        }
    }

    function loadOrderType() {
        try {
            return localStorage.getItem(storageKeys.orderType) || 'dine-in';
        } catch (error) {
            console.warn('Unable to read order type', error);
            return 'dine-in';
        }
    }

    function saveOrderType(value) {
        try {
            localStorage.setItem(storageKeys.orderType, value);
        } catch (error) {
            console.warn('Unable to save order type', error);
        }
    }

    const state = {
        orderType: loadOrderType(),
        menu: [],
        flatMenu: [],
        vendor: config.vendor || {},
        cart: loadFromStorage(storageKeys.cart, []),
        profile: loadFromStorage(storageKeys.profile, {
            name: '',
            email: '',
            contact: '',
            table: ''
        }),
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
        orders: [],
        ordersLoaded: false
    };

    function showToast(message) {
        const toastEl = document.getElementById('toast');
        if (!toastEl) {
            return;
        }
        toastEl.querySelector('.toast-body').innerHTML = message;
        const toast = new bootstrap.Toast(toastEl);
        toast.show();
    }

    function showAlert(message, type = 'success') {
        const container = $('#alertContainer');
        if (!container.length) {
            showToast(message);
            return;
        }
        container.html(`
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `);
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function saveProfile() {
        saveToStorage(storageKeys.profile, state.profile);
    }

    function saveCart() {
        saveToStorage(storageKeys.cart, state.cart);
    }

    function updateHeaderCart(totalItems) {
        $('#headerCartCount').text(totalItems);
        $('#cartCountBadge').text(totalItems);
    }

    function renderProfileDetails() {
        const { name, email, contact, table } = state.profile;
        const displayName = name || 'Guest';
        const displayEmail = email || 'Add your email';
        const displayContact = contact || 'Add your contact number';

        $('#profileNameDisplay').text(displayName);
        $('#profileEmailDisplay').text(displayEmail);
        $('#profilePhoneDisplay').text(displayContact);

        if ($('#profileAvatar').length) {
            const initials = (displayName.charAt(0) || 'G').toUpperCase();
            $('#profileAvatar').text(initials);
            if (table) {
                $('#profileAvatar').attr('title', `Preferred table ${table}`);
            }
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
        const vendor = state.vendor || {};
        if (vendor.name) {
            $('#vendorName').text(vendor.name);
        }
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
        if (contactBits.length) {
            $('#vendorContact').html(contactBits.join(''));
        }
        if (vendor.logo) {
            $('#vendorLogoHolder').html(`<img src="${vendor.logo}" alt="${vendor.name}" class="img-fluid rounded-circle" style="width:72px;height:72px;object-fit:cover;">`);
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
        state.flatMenu = flat;
    }

    function renderCategoryOptions() {
        const select = $('#categorySelect');
        if (!select.length) {
            return;
        }
        select.empty();
        select.append('<option value="all">All categories</option>');
        state.menu.forEach(category => {
            select.append(`<option value="${category.id}">${category.name}</option>`);
        });
    }

    function getFilteredItems() {
        const { search, category, sort } = state.filters;
        let items = [...state.flatMenu];

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
        if (!grid.length) {
            return;
        }
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
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                    <div class="item-card p-3 d-flex flex-column gap-2">
                        <div class="item-media">${image}</div>
                        <div class="text-uppercase small text-secondary">${item.category_name || ''}</div>
                        <h5 class="fw-semibold mb-0">${item.name}</h5>
                        ${description}
                        <div class="mt-auto d-flex align-items-center justify-content-between gap-2">
                            <span class="fw-bold">${priceText}</span>
                            <button class="btn btn-sm btn-primary add-to-cart-btn" data-menu-key="${menuKey}" ${disabled ? 'disabled' : ''}>Add</button>
                        </div>
                    </div>
                </div>
            `);
        });
    }

    function getCartKey(item) {
        return `${item.id || 'custom'}::${item.variant || 'default'}`;
    }

    function renderCart() {
        const cartItemsContainer = $('#cartItems');
        const totalItems = state.cart.reduce((sum, item) => sum + item.quantity, 0);
        const subtotal = state.cart.reduce((sum, item) => sum + item.price * item.quantity, 0);

        updateHeaderCart(totalItems);
        $('#cartItemsCount').text(totalItems);
        $('#cartSubtotal').text(currency.format(subtotal));
        $('#drawerSubtotal').text(currency.format(subtotal));

        if (!cartItemsContainer.length) {
            saveCart();
            return;
        }

        cartItemsContainer.empty();
        if (!state.cart.length) {
            cartItemsContainer.html(`
                <div class="text-center text-secondary py-4">
                    <i class="bi bi-bag-dash display-6 d-block mb-3"></i>
                    <p class="mb-0">Your cart is empty. Add some items from the menu.</p>
                </div>
            `);
            saveCart();
            return;
        }

        state.cart.forEach(item => {
            cartItemsContainer.append(`
                <div class="cart-item-row py-3 border-bottom" data-cart-key="${item.key}">
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
        saveCart();
    }

    function renderCheckout() {
        const container = $('#checkoutItems');
        if (!container.length) {
            return;
        }
        container.empty();
        const subtotal = state.cart.reduce((sum, item) => sum + item.price * item.quantity, 0);
        $('#checkoutSubtotal').text(currency.format(subtotal));
        $('#checkoutTotal').text(currency.format(subtotal));

        if (!state.cart.length) {
            container.html('<div class="alert alert-info">Your cart is empty. Add items from the menu to place an order.</div>');
            $('#placeOrderBtn').prop('disabled', true);
            return;
        }

        $('#placeOrderBtn').prop('disabled', false);
        state.cart.forEach(item => {
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

    function addItemToCart(item) {
        const key = getCartKey(item);
        const existing = state.cart.find(cartItem => cartItem.key === key);
        if (existing) {
            existing.quantity += 1;
        } else {
            state.cart.push({
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
        const index = state.cart.findIndex(item => item.key === key);
        if (index === -1) {
            return;
        }
        state.cart[index].quantity += delta;
        if (state.cart[index].quantity <= 0) {
            state.cart.splice(index, 1);
        }
        renderCart();
        renderCheckout();
    }

    function clearCart() {
        state.cart = [];
        renderCart();
        renderCheckout();
    }

    function setOrderType(value) {
        state.orderType = value;
        saveOrderType(value);
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
        if (!config.endpoints || !config.endpoints.menu) {
            return;
        }
        $.getJSON(config.endpoints.menu)
            .done(data => {
                state.vendor = data.vendor || state.vendor;
                state.menu = data.categories || [];
                flattenMenu(state.menu);
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
        if (!state.cart.length) {
            showAlert('Please add items to your cart before placing an order.', 'warning');
            return;
        }
        const payload = {
            order_type: state.orderType,
            customer_name: $('#checkoutName').val(),
            contact_no: $('#checkoutContact').val(),
            email: $('#checkoutEmail').val(),
            table_number: state.orderType === 'dine-in' ? $('#checkoutTable').val() : null,
            special_request: $('#checkoutNotes').val(),
            items: state.cart.map(item => ({
                id: item.id,
                name: item.name,
                price: item.price,
                quantity: item.quantity,
                variant: item.variant
            }))
        };

        if (state.orderType === 'dine-in' && !payload.table_number) {
            showAlert('Please provide a table number for dine-in orders.', 'warning');
            return;
        }

        state.profile = {
            name: payload.customer_name,
            contact: payload.contact_no,
            email: payload.email,
            table: state.orderType === 'dine-in' ? $('#checkoutTable').val() : state.profile.table
        };
        saveProfile();
        renderProfileDetails();

        const button = $('#placeOrderBtn');
        button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Placing');

        $.ajax({
            url: config.endpoints.store,
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(payload),
            headers: {
                'X-CSRF-TOKEN': config.csrf
            }
        })
            .done(response => {
                const orderId = response?.data?.order_id ? ` ${response.data.order_id}` : '';
                showAlert(`Order${orderId} placed successfully!`);
                state.cart = [];
                renderCart();
                renderCheckout();
                state.ordersLoaded = false;
                setTimeout(() => {
                    window.location.href = config.routes?.profile || window.location.href;
                }, 1200);
            })
            .fail(xhr => {
                const errors = xhr.responseJSON?.errors || ['Unable to place order. Please try again.'];
                showAlert(errors.join('<br>'), 'danger');
            })
            .always(() => {
                button.prop('disabled', false).html('<i class="bi bi-check2-circle me-1"></i>Place order');
            });
    }

    function fetchOrders() {
        if (!config.endpoints || !config.endpoints.history) {
            return;
        }
        if (!state.profile.contact) {
            $('#ordersNotice').removeClass('d-none').text('Add your contact number to fetch order history.');
            $('#ordersTableBody').empty();
            $('#ordersEmptyState').addClass('d-none');
            return;
        }

        $('#ordersNotice').addClass('d-none');
        $('#ordersTableBody').html('<tr><td colspan="6" class="text-center py-4"><div class="spinner-border text-primary"></div><p class="mt-2 mb-0">Loading orders…</p></td></tr>');

        const params = { contact: state.profile.contact };
        if (state.profile.email) {
            params.email = state.profile.email;
        }

        $.get(config.endpoints.history, params)
            .done(response => {
                state.orders = response.orders || [];
                state.ordersLoaded = true;
                renderOrders();
            })
            .fail(() => {
                $('#ordersTableBody').html('<tr><td colspan="6" class="text-center py-4 text-danger">Unable to load orders. Please try again later.</td></tr>');
            });
    }

    function renderOrders() {
        const { search, status, type } = state.orderFilters;
        let orders = [...state.orders];

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
        if (!tbody.length) {
            return;
        }
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

        const totalOrders = state.orders.length;
        const activeOrders = state.orders.filter(order => ['placed', 'preparing', 'ready'].includes(order.status)).length;
        const cancelledOrders = state.orders.filter(order => order.status === 'cancelled').length;

        $('#totalOrdersCount').text(totalOrders);
        $('#activeOrdersCount').text(activeOrders);
        $('#cancelledOrdersCount').text(cancelledOrders);
    }

    function initLanding() {
        $('.option-card').attr('tabindex', 0);
        $('.option-card').on('click keydown', function (event) {
            if (event.type === 'keydown' && !['Enter', ' '].includes(event.key)) {
                return;
            }
            const value = $(this).data('value');
            setOrderType(value);
        });

        $('#orderTypeForm').on('submit', function (event) {
            event.preventDefault();
            const selected = $('input[name="order_type"]:checked').val() || state.orderType;
            setOrderType(selected);
            window.location.href = config.routes?.items || window.location.href;
        });
    }

    function initItems() {
        fetchMenu();
        $('#searchInput').on('input', function () {
            state.filters.search = $(this).val();
            renderItems();
        });
        $('#categorySelect').on('change', function () {
            state.filters.category = $(this).val();
            renderItems();
        });
        $('#sortSelect').on('change', function () {
            state.filters.sort = $(this).val();
            renderItems();
        });
    }

    function initCheckout() {
        $('#checkoutForm').on('submit', submitOrder);
    }

    function initProfile() {
        $('#profileForm').on('submit', function (event) {
            event.preventDefault();
            state.profile = {
                name: $('#profileNameInput').val(),
                email: $('#profileEmailInput').val(),
                contact: $('#profileContactInput').val(),
                table: $('#profileTableInput').val()
            };
            saveProfile();
            renderProfileDetails();
            showToast('Profile updated successfully.');
            state.ordersLoaded = false;
        });

        $('#refreshOrdersBtn').on('click', function () {
            state.ordersLoaded = false;
            fetchOrders();
        });

        $('#ordersSearch').on('input', function () {
            state.orderFilters.search = $(this).val();
            renderOrders();
        });
        $('#ordersStatus').on('change', function () {
            state.orderFilters.status = $(this).val();
            renderOrders();
        });
        $('#ordersType').on('change', function () {
            state.orderFilters.type = $(this).val();
            renderOrders();
        });

        if (!state.ordersLoaded) {
            fetchOrders();
        }
    }

    function attachGlobalHandlers() {
        $(document).on('click', '.add-to-cart-btn', function () {
            const key = $(this).data('menu-key');
            const item = state.flatMenu.find(menuItem => getMenuItemKey(menuItem) === key);
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
            state.cart = state.cart.filter(item => item.key !== key);
            renderCart();
            renderCheckout();
        });

        $(document).on('click', '#clearCartBtn, #drawerClearCartBtn', function () {
            clearCart();
        });
    }

    $(function () {
        renderProfileDetails();
        renderCheckout();
        renderCart();
        setOrderType(state.orderType);
        attachGlobalHandlers();

        const page = document.body.dataset.page;
        switch (page) {
            case 'items':
                initItems();
                break;
            case 'checkout':
                initCheckout();
                break;
            case 'profile':
                initProfile();
                break;
            case 'index':
            default:
                initLanding();
                break;
        }
    });
})(jQuery);
