@extends('vendor.layouts.default')

@section('pageTitle', 'Restaurant POS')

@section('content')
<style>
    .pos-product-card-body {
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    .pos-product-card-body #productFeedback { flex-shrink: 0; }
    .pos-product-card-body #productList {
        flex: 1 1 auto;
        overflow-y: auto; overflow-x: hidden;
        padding-right: .25rem; padding-bottom: .5rem;
        -webkit-overflow-scrolling: touch;
    }
    .pos-product-card-body #productList::-webkit-scrollbar { width: 8px; }
    .pos-product-card-body #productList::-webkit-scrollbar-track { background:#f1f1f1; border-radius:4px; }
    .pos-product-card-body #productList::-webkit-scrollbar-thumb { background:rgba(0,0,0,.25); border-radius:4px; }

    @media (min-width: 992px){ .pos-product-card-body #productList{ max-height: calc(100vh - 320px);} }
    @media (max-width: 991.98px){ .pos-product-card-body #productList{ max-height: none;} }

    /* ---------- Product card redesign ---------- */
    .pos-card {
        border: 1px solid rgba(0,0,0,.06);
        border-radius: .75rem;
        transition: box-shadow .2s ease, transform .1s ease;
        background: #fff;
    }
    .pos-card:hover { box-shadow: 0 8px 22px rgba(0,0,0,.08); transform: translateY(-1px); }

    .pos-card-body { padding: .875rem .9rem 0 .9rem; display:flex; flex-direction:column; height:100%; }
    .pos-title {
        font-weight: 700; font-size: .98rem; line-height: 1.25rem; margin-bottom:.25rem;
        display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical;
    }
    .pos-desc {
        color:#6c757d; font-size:.82rem; margin-bottom:.5rem;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }

    .pos-price-block {
        display:flex; flex-direction:column; gap:.4rem; margin-bottom:.75rem;
        background:#f8f9fa; border:1px solid rgba(0,0,0,.06); border-radius:.5rem; padding:.55rem .6rem;
    }
    .pos-price-badge {
        display:flex; flex-direction:column; line-height:1.05;
        background:#fff; border:1px solid rgba(0,0,0,.08); border-radius:.35rem;
        padding:.45rem .5rem; width:100%;
    }
    .pos-price-badge .val { font-weight:800; font-size:1rem; color:#111; }
    .pos-price-badge .unit { font-size:.68rem; letter-spacing:.04em; color:#6c757d; text-transform:uppercase; }

    .pos-variant { width:100%; }
    .pos-variant.custom-select-sm { font-size:.88rem; padding:.35rem .6rem; }

    .pos-card-footer {
        margin-top:auto; padding:.65rem .9rem .9rem .9rem; background:transparent; border-top:0;
    }
    .btn-add {
        width:100%;
        display:inline-flex; align-items:center; justify-content:center; gap:.4rem;
        font-weight:600;
    }
</style>

<div class="container-fluid">
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Restaurant POS</h1>
        <div class="d-flex align-items-center">
            <a href="{{ route('vendor.pos.orders') }}" class="btn btn-outline-secondary btn-sm mr-2 mb-2">
                <i class="bi bi-card-list"></i> View Orders
            </a>
            <button type="button" class="btn btn-primary btn-sm mb-2" id="startNewOrder">
                <i class="bi bi-plus-circle"></i> New Order
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-7 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        </div>
                        <input type="text" class="form-control" id="productSearch" placeholder="Search menu items">
                    </div>
                </div>
                <div class="card-body pos-product-card-body">
                    <div class="mb-3">
                        <div class="form-group mb-0">
                            <label for="categoryFilter" class="small text-muted text-uppercase font-weight-bold">Categories</label>
                            <select class="custom-select custom-select-sm" id="categoryFilter">
                                <option value="">All</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div id="productFeedback" class="text-center text-muted py-4">Loading menu items...</div>
                    <div class="row" id="productList"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-5 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Order Summary</h5>
                    <a href="{{ url('vendor/pos') }}" class="small" target="_blank" rel="noopener">
                        {{ url('vendor/pos') }}
                    </a>
                </div>
                <div class="card-body">
                    <form id="customerForm" class="mb-4">
                        <div class="form-group">
                            <label for="customerName">Customer Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="customerName" placeholder="Walk-in Customer" required>
                        </div>
                        <div class="form-group mb-0">
                            <label for="customerContact">Contact Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="customerContact" placeholder="Contact number" required>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-sm align-middle" id="cartTable">
                            <thead class="thead-light">
                                <tr>
                                    <th>Item</th>
                                    <th class="text-center" style="width:120px;">Qty</th>
                                    <th class="text-right" style="width:90px;">Price</th>
                                    <th class="text-right" style="width:100px;">Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="cartEmptyRow">
                                    <td colspan="5" class="text-center text-muted py-3">Cart is empty</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="border-top pt-3">
                        <div class="d-flex justify-content-between">
                            <span>Subtotal</span>
                            <strong id="subtotalAmount">0.00</strong>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <label for="discountAmount" class="mb-0">Discount</label>
                            <input type="number" min="0" step="0.01" id="discountAmount" class="form-control form-control-sm text-right" style="width:120px;" value="0">
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <span>Total</span>
                            <strong id="totalAmount">0.00</strong>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-outline-secondary" id="clearCart">
                            <i class="bi bi-trash"></i> Clear
                        </button>
                        <button type="button" class="btn btn-success" id="placeOrder" disabled>
                            <i class="bi bi-check-circle"></i> Place Order
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
</div>

<script>
    const productsUrl = "{{ route('vendor.pos.products') }}";
    const orderStoreUrl = "{{ route('vendor.pos.orders.store') }}";
    const orderPrintTemplate = "{{ route('vendor.pos.orders.print', ['order' => '__ORDER__']) }}";
    const csrfToken = "{{ csrf_token() }}";

    let activeCategory = '';
    let cart = [];

    const formatMoney = (value) => parseFloat(value || 0).toFixed(2);
    const priceTypeLabel = (type) => type === 'half' ? 'Half' : (type === 'full' ? 'Full' : '');

    const debounce = (func, wait = 300) => {
        let timeout;
        return function (...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    };

    const togglePlaceOrderState = () => {
        $('#placeOrder').prop('disabled', cart.length === 0);
    };

    // ---------- Redesigned Product Card ----------
    const createProductCard = (item) => {
        const column = $('<div>').addClass('col-md-6 col-xl-4 mb-3');

        const card = $('<div>').addClass('pos-card d-flex flex-column product-card');
        const body = $('<div>').addClass('pos-card-body');

        $('<div>').addClass('pos-title').text(item.name).appendTo(body);
        $('<div>').addClass('pos-desc').text(item.description ? item.description.substring(0, 90) : '').appendTo(body);

        // Price block (stacked)
        const priceBlock = $('<div>').addClass('pos-price-block');

        const priceBadge = $('<div>').addClass('pos-price-badge');
        priceBadge.append(`<span class="val">₹ ${formatMoney(item.price_full || item.price_half || 0)}</span>`);
        priceBadge.append(`<span class="unit">${item.price_full != null ? 'FULL' : (item.price_half != null ? 'HALF' : 'PRICE')}</span>`);

        priceBlock.append(priceBadge);

        const priceOptions = [];
        if (item.price_full !== null && item.price_full !== undefined) priceOptions.push({ type: 'full', value: parseFloat(item.price_full) });
        if (item.price_half !== null && item.price_half !== undefined) priceOptions.push({ type: 'half', value: parseFloat(item.price_half) });

        let defaultOption = priceOptions.length ? priceOptions[0] : null;
        let priceSelect = null;

        if (priceOptions.length) {
            priceSelect = $('<select>').addClass('custom-select custom-select-sm pos-variant');
            priceOptions.forEach(option => {
                priceSelect.append(
                    $('<option>')
                        .val(option.type)
                        .data('price', option.value)
                        .text(`${priceTypeLabel(option.type)} - ₹ ${formatMoney(option.value)}`)
                );
            });
            if (defaultOption) priceSelect.val(defaultOption.type);
            if (priceOptions.length === 1) priceSelect.prop('disabled', true);
            priceBlock.append(priceSelect);
        }

        body.append(priceBlock);

        // Footer with full width Add button
        const footer = $('<div>').addClass('pos-card-footer');
        const addBtn = $('<button>')
            .addClass('btn btn-primary btn-sm btn-add add-to-cart')
            .html('<i class="bi bi-plus-circle"></i> Add');

        // store default values
        addBtn.data({
            id: item.id,
            name: item.name,
            price: defaultOption ? defaultOption.value : (item.price_full || item.price_half || 0),
            priceType: defaultOption ? defaultOption.type : (item.price_full != null ? 'full' : (item.price_half != null ? 'half' : null))
        });

        footer.append(addBtn);
        card.append(body).append(footer);
        column.append(card);

        // Update price badge on change
        const updatePriceBadge = () => {
            let priceType = priceSelect ? priceSelect.val() : (defaultOption ? defaultOption.type : null);
            const selectedOption = priceSelect ? priceSelect.find('option:selected') : null;
            const priceValue = selectedOption ? parseFloat(selectedOption.data('price')) : (defaultOption ? defaultOption.value : 0);

            if (priceValue > 0) {
                priceBadge.find('.val').text(`₹ ${formatMoney(priceValue)}`);
                priceBadge.find('.unit').text(priceTypeLabel(priceType).toUpperCase());
                addBtn.data('price', priceValue);
                addBtn.data('priceType', priceType);
            } else {
                priceBadge.find('.val').text('—');
                priceBadge.find('.unit').text('PRICE');
            }
        };
        if (priceSelect) priceSelect.on('change', updatePriceBadge);

        return column;
    };

    const renderProducts = (items) => {
        const list = $('#productList');
        const feedback = $('#productFeedback');
        list.empty();

        if (!items.length) {
            feedback.text('No menu items found for the selected filters.');
            feedback.show();
            return;
        }
        feedback.hide();
        items.forEach(item => list.append(createProductCard(item)));
    };

    const refreshTotals = () => {
        const subtotal = cart.reduce((t, i) => t + (i.price * i.quantity), 0);
        const discountInput = parseFloat($('#discountAmount').val()) || 0;
        const discount = Math.min(discountInput, subtotal);
        const total = subtotal - discount;
        $('#subtotalAmount').text(formatMoney(subtotal));
        $('#totalAmount').text(formatMoney(total));
    };

    const renderCart = () => {
        const body = $('#cartTable tbody');
        body.find('tr').not('#cartEmptyRow').remove();

        if (!cart.length) {
            $('#cartEmptyRow').show();
        } else {
            $('#cartEmptyRow').hide();
            cart.forEach(item => {
                const row = $('<tr>');
                const itemName = item.priceType ? `${item.name} (${priceTypeLabel(item.priceType)})` : item.name;
                $('<td>').text(itemName).appendTo(row);

                const qtyCell = $('<td>').addClass('text-center align-middle');
                const qtyGroup = $('<div>').addClass('input-group input-group-sm justify-content-center flex-nowrap');
                const decrease = $('<button>').attr('type', 'button').addClass('btn btn-outline-secondary quantity-decrease').data('key', item.key).append($('<i>').addClass('bi bi-dash'));
                const increase = $('<button>').attr('type', 'button').addClass('btn btn-outline-secondary quantity-increase').data('key', item.key).append($('<i>').addClass('bi bi-plus'));
                const qtyInput = $('<input>').attr({ type: 'number', min: 1 }).addClass('form-control form-control-sm text-center cart-quantity').css('width','60px').data('key', item.key).val(item.quantity);
                $('<div>').addClass('input-group-prepend').append(decrease).appendTo(qtyGroup);
                qtyGroup.append(qtyInput);
                $('<div>').addClass('input-group-append').append(increase).appendTo(qtyGroup);
                qtyCell.append(qtyGroup).appendTo(row);

                $('<td>').addClass('text-right').text(`₹ ${formatMoney(item.price)}`).appendTo(row);
                $('<td>').addClass('text-right').text(`₹ ${formatMoney(item.price * item.quantity)}`).appendTo(row);

                const removeCell = $('<td>').addClass('text-right');
                const removeButton = $('<button>').addClass('btn btn-link text-danger p-0 remove-item').data('key', item.key).append($('<i>').addClass('bi bi-trash'));
                removeCell.append(removeButton).appendTo(row);
                body.append(row);
            });
        }
        togglePlaceOrderState();
        refreshTotals();
    };

    const loadProducts = () => {
        $('#productFeedback').text('Loading menu items...').show();
        $('#productList').empty();

        $.get(productsUrl, {
            category_id: activeCategory || undefined,
            search: $('#productSearch').val()
        })
        .done(response => renderProducts(response.data || []))
        .fail(() => $('#productFeedback').text('Unable to load menu items at the moment.'));
    };

    const resetCart = () => {
        cart = [];
        $('#discountAmount').val(0);
        const form = $('#customerForm')[0];
        if (form) form.reset();
        renderCart();
    };

    $(document).ready(function () {
        loadProducts();

        $('#categoryFilter').on('change', function () {
            activeCategory = $(this).val() || '';
            loadProducts();
        });

        $('#productSearch').on('input', debounce(loadProducts, 400));

        // Add to cart
        $('#productList').on('click', '.add-to-cart', function () {
            const button = $(this);
            const id = parseInt(button.data('id'), 10);
            const name = button.data('name');
            let price = parseFloat(button.data('price')) || 0;
            let priceType = button.data('priceType') || null;

            const card = button.closest('.product-card');
            const priceSelect = card.find('.pos-variant');
            if (priceSelect.length) {
                priceType = priceSelect.val();
                const selectedOption = priceSelect.find('option:selected');
                price = parseFloat(selectedOption.data('price')) || 0;
            }

            if (!price) { toastr.warning('Price is not available for this item.'); return; }

            const key = `${id}-${priceType || 'default'}`;
            const existing = cart.find(it => it.key === key);
            if (existing) existing.quantity += 1;
            else cart.push({ key, id, name, priceType, price, quantity: 1 });

            renderCart();
        });

        // Cart interactions
        $('#cartTable').on('click', '.remove-item', function () {
            const key = $(this).data('key');
            cart = cart.filter(i => i.key !== key);
            renderCart();
        });
        $('#cartTable').on('click', '.quantity-increase', function () {
            const key = $(this).data('key');
            const item = cart.find(e => e.key === key);
            if (item) { item.quantity += 1; renderCart(); }
        });
        $('#cartTable').on('click', '.quantity-decrease', function () {
            const key = $(this).data('key');
            const item = cart.find(e => e.key === key);
            if (item && item.quantity > 1) { item.quantity -= 1; renderCart(); }
        });
        $('#cartTable').on('change', '.cart-quantity', function () {
            const key = $(this).data('key');
            let value = parseInt($(this).val(), 10);
            if (Number.isNaN(value) || value < 1) value = 1;
            const item = cart.find(e => e.key === key);
            if (item) { item.quantity = value; renderCart(); }
        });

        $('#discountAmount').on('input', function () {
            if (parseFloat($(this).val()) < 0) $(this).val(0);
            refreshTotals();
        });

        $('#clearCart').on('click', function () { resetCart(); });
        $('#startNewOrder').on('click', function () { resetCart(); toastr.info('Ready for a new order.'); });

        $('#placeOrder').on('click', function () {
            if (!cart.length) { toastr.warning('Add at least one item to the cart.'); return; }

            const name = $('#customerName').val().trim();
            const contact = $('#customerContact').val().trim();
            if (!name || !contact) { toastr.error('Customer name and contact are required.'); return; }

            const payload = {
                customer_name: name,
                customer_contact: contact,
                discount_amount: parseFloat($('#discountAmount').val()) || 0,
                items: cart.map(item => ({ id: item.id, quantity: item.quantity, price_type: item.priceType }))
            };

            $('#placeOrder').prop('disabled', true).text('Saving...');
            $.ajax({
                url: orderStoreUrl, method: 'POST', contentType: 'application/json',
                data: JSON.stringify(payload), headers: { 'X-CSRF-TOKEN': csrfToken }
            })
            .done(response => {
                toastr.success('Order placed successfully.');
                resetCart();
                const printUrl = orderPrintTemplate.replace('__ORDER__', response.order_id);
                window.open(printUrl, '_blank');
            })
            .fail(error => {
                if (error.responseJSON && error.responseJSON.errors)
                    error.responseJSON.errors.forEach(m => toastr.error(m));
                else toastr.error('Unable to save the order right now.');
            })
            .always(() => {
                $('#placeOrder').prop('disabled', cart.length === 0).html('<i class="bi bi-check-circle"></i> Place Order');
            });
        });

    });
</script>
@endsection
