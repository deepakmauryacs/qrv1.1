@extends('vendor.layouts.default')

@section('pageTitle', 'Restaurant POS')

@section('content')
<style>
    .pos-product-card-body {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .pos-product-card-body #productFeedback {
        flex-shrink: 0;
    }

    .pos-product-card-body #productList {
        flex: 1 1 auto;
        overflow-y: auto;
        overflow-x: hidden;
        margin: 0;
        padding-right: 0.25rem;
        padding-bottom: 0.5rem;
        -webkit-overflow-scrolling: touch;
    }

    .pos-product-card-body #productList::-webkit-scrollbar {
        width: 8px;
    }

    .pos-product-card-body #productList::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    .pos-product-card-body #productList::-webkit-scrollbar-thumb {
        background-color: rgba(0, 0, 0, 0.25);
        border-radius: 4px;
    }

    @media (min-width: 992px) {
        .pos-product-card-body #productList {
            max-height: calc(100vh - 320px);
        }
    }

    @media (max-width: 991.98px) {
        .pos-product-card-body #productList {
            max-height: none;
        }
    }
</style>
<div class="container-fluid">
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Restaurant POS</h1>
        <div class="d-flex align-items-center">
            <button type="button" class="btn btn-outline-secondary btn-sm mr-2 mb-2" id="refreshOrdersTop">
                <i class="bi bi-arrow-clockwise"></i> Refresh Orders
            </button>
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
                        <div class="form-group">
                            <label for="customerEmail">Customer Email</label>
                            <input type="email" class="form-control" id="customerEmail" placeholder="customer@example.com">
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
                                    <th class="text-center" style="width: 120px;">Qty</th>
                                    <th class="text-right" style="width: 90px;">Price</th>
                                    <th class="text-right" style="width: 100px;">Total</th>
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
                            <input type="number" min="0" step="0.01" id="discountAmount" class="form-control form-control-sm text-right" style="width: 120px;" value="0">
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

    <div class="card shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Recent POS Orders</h5>
            <button type="button" class="btn btn-outline-primary btn-sm" id="refreshOrders">
                <i class="bi bi-arrow-clockwise"></i> Refresh
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="orderHistoryTable">
                    <thead class="thead-light">
                        <tr>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th class="text-right">Total</th>
                            <th class="text-right">Created</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="ordersEmptyRow">
                            <td colspan="7" class="text-center text-muted py-3">No orders yet</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="orderDetailsModal" tabindex="-1" role="dialog" aria-labelledby="orderDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderDetailsModalLabel">Order Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <div><strong>Order #:</strong> <span id="detailOrderNumber"></span></div>
                    <div><strong>Customer:</strong> <span id="detailCustomer"></span></div>
                    <div><strong>Email:</strong> <span id="detailEmail"></span></div>
                    <div><strong>Contact:</strong> <span id="detailContact"></span></div>
                    <div><strong>Created At:</strong> <span id="detailCreated"></span></div>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th class="text-center" style="width: 80px;">Qty</th>
                                <th class="text-right" style="width: 90px;">Price</th>
                                <th class="text-right" style="width: 100px;">Total</th>
                            </tr>
                        </thead>
                        <tbody id="detailItems"></tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Subtotal</span>
                    <strong id="detailSubtotal"></strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Discount</span>
                    <strong id="detailDiscount"></strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Total</span>
                    <strong id="detailTotal"></strong>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" id="detailPrint">
                    <i class="bi bi-printer"></i> Print
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    const productsUrl = "{{ route('vendor.pos.products') }}";
    const ordersUrl = "{{ route('vendor.pos.orders') }}";
    const orderStoreUrl = "{{ route('vendor.pos.orders.store') }}";
    const orderShowTemplate = "{{ route('vendor.pos.orders.show', ['order' => '__ORDER__']) }}";
    const orderPrintTemplate = "{{ route('vendor.pos.orders.print', ['order' => '__ORDER__']) }}";
    const csrfToken = "{{ csrf_token() }}";

    let activeCategory = '';
    let cart = [];
    let currentOrderId = null;

    const formatMoney = (value) => parseFloat(value || 0).toFixed(2);

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

    const createProductCard = (item) => {
        const column = $('<div>').addClass('col-md-6 col-xl-4 mb-3');
        const card = $('<div>').addClass('border rounded h-100 d-flex flex-column product-card shadow-sm');
        const body = $('<div>').addClass('p-3 flex-fill');
        const footer = $('<div>').addClass('p-3 border-top bg-light text-right');

        $('<h6>').addClass('mb-1 text-dark').text(item.name).appendTo(body);
        $('<small>').addClass('text-muted d-block mb-2').text(item.description ? item.description.substring(0, 60) : '').appendTo(body);
        $('<span>').addClass('badge badge-light border').text(item.price ? `₹ ${formatMoney(item.price)}` : 'Price unavailable').appendTo(body);

        const button = $('<button>').addClass('btn btn-sm btn-primary add-to-cart')
            .append($('<i>').addClass('bi bi-plus-circle'))
            .append(' Add');
        button.data('id', item.id);
        button.data('name', item.name);
        button.data('price', item.price);

        footer.append(button);
        card.append(body).append(footer);
        column.append(card);
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
        const subtotal = cart.reduce((total, item) => total + (item.price * item.quantity), 0);
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
                $('<td>').text(item.name).appendTo(row);

                const qtyCell = $('<td>').addClass('text-center align-middle');
                const qtyGroup = $('<div>').addClass('input-group input-group-sm justify-content-center flex-nowrap');
                const decrease = $('<button>').attr('type', 'button').addClass('btn btn-outline-secondary quantity-decrease').data('id', item.id).append($('<i>').addClass('bi bi-dash'));
                const increase = $('<button>').attr('type', 'button').addClass('btn btn-outline-secondary quantity-increase').data('id', item.id).append($('<i>').addClass('bi bi-plus'));
                const qtyInput = $('<input>').attr({ type: 'number', min: 1 }).addClass('form-control form-control-sm text-center cart-quantity').css('width', '60px').data('id', item.id).val(item.quantity);
                $('<div>').addClass('input-group-prepend').append(decrease).appendTo(qtyGroup);
                qtyGroup.append(qtyInput);
                $('<div>').addClass('input-group-append').append(increase).appendTo(qtyGroup);
                qtyCell.append(qtyGroup).appendTo(row);

                $('<td>').addClass('text-right').text(`₹ ${formatMoney(item.price)}`).appendTo(row);
                $('<td>').addClass('text-right').text(`₹ ${formatMoney(item.price * item.quantity)}`).appendTo(row);

                const removeCell = $('<td>').addClass('text-right');
                const removeButton = $('<button>').addClass('btn btn-link text-danger p-0 remove-item').data('id', item.id).append($('<i>').addClass('bi bi-trash'));
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
            .done(response => {
                renderProducts(response.data || []);
            })
            .fail(() => {
                $('#productFeedback').text('Unable to load menu items at the moment.');
            });
    };

    const loadOrders = () => {
        $.get(ordersUrl)
            .done(response => {
                const data = response.data || [];
                const body = $('#orderHistoryTable tbody');
                body.find('tr').not('#ordersEmptyRow').remove();

                if (!data.length) {
                    $('#ordersEmptyRow').show();
                    return;
                }

                $('#ordersEmptyRow').hide();
                data.forEach(order => {
                    const row = $('<tr>');
                    $('<td>').html(`<strong>#${order.reference}</strong>`).appendTo(row);
                    $('<td>').text(order.customer_name).appendTo(row);
                    $('<td>').text(order.customer_email || '-').appendTo(row);
                    $('<td>').text(order.customer_contact).appendTo(row);
                    $('<td>').addClass('text-right').text(`₹ ${formatMoney(order.total_amount)}`).appendTo(row);
                    $('<td>').addClass('text-right').text(order.created_at).appendTo(row);

                    const actionCell = $('<td>').addClass('text-right');
                    const group = $('<div>').addClass('btn-group btn-group-sm').attr('role', 'group');
                    const viewBtn = $('<button>').addClass('btn btn-outline-primary view-order').data('id', order.id).append($('<i>').addClass('bi bi-eye'));
                    const printBtn = $('<button>').addClass('btn btn-outline-secondary print-order').data('id', order.id).append($('<i>').addClass('bi bi-printer'));
                    group.append(viewBtn, printBtn);
                    actionCell.append(group).appendTo(row);

                    body.append(row);
                });
            })
            .fail(() => {
                toastr.error('Unable to load orders right now.');
            });
    };

    const resetCart = () => {
        cart = [];
        $('#discountAmount').val(0);
        const form = $('#customerForm')[0];
        if (form) {
            form.reset();
        }
        renderCart();
    };

    $(document).ready(function () {
        loadProducts();
        loadOrders();

        $('#categoryFilter').on('change', function () {
            activeCategory = $(this).val() || '';
            loadProducts();
        });

        $('#productSearch').on('input', debounce(loadProducts, 400));

        $('#productList').on('click', '.add-to-cart', function () {
            const id = parseInt($(this).data('id'), 10);
            const name = $(this).data('name');
            const price = parseFloat($(this).data('price')) || 0;

            if (!price) {
                toastr.warning('Price is not available for this item.');
                return;
            }

            const existing = cart.find(item => item.id === id);
            if (existing) {
                existing.quantity += 1;
            } else {
                cart.push({ id, name, price, quantity: 1 });
            }

            renderCart();
        });

        $('#cartTable').on('click', '.remove-item', function () {
            const id = parseInt($(this).data('id'), 10);
            cart = cart.filter(item => item.id !== id);
            renderCart();
        });

        $('#cartTable').on('click', '.quantity-increase', function () {
            const id = parseInt($(this).data('id'), 10);
            const item = cart.find(entry => entry.id === id);
            if (item) {
                item.quantity += 1;
                renderCart();
            }
        });

        $('#cartTable').on('click', '.quantity-decrease', function () {
            const id = parseInt($(this).data('id'), 10);
            const item = cart.find(entry => entry.id === id);
            if (item && item.quantity > 1) {
                item.quantity -= 1;
                renderCart();
            }
        });

        $('#cartTable').on('change', '.cart-quantity', function () {
            const id = parseInt($(this).data('id'), 10);
            let value = parseInt($(this).val(), 10);
            if (Number.isNaN(value) || value < 1) {
                value = 1;
            }
            const item = cart.find(entry => entry.id === id);
            if (item) {
                item.quantity = value;
                renderCart();
            }
        });

        $('#discountAmount').on('input', function () {
            if (parseFloat($(this).val()) < 0) {
                $(this).val(0);
            }
            refreshTotals();
        });

        $('#clearCart').on('click', function () {
            resetCart();
        });

        $('#startNewOrder').on('click', function () {
            resetCart();
            toastr.info('Ready for a new order.');
        });

        $('#placeOrder').on('click', function () {
            if (!cart.length) {
                toastr.warning('Add at least one item to the cart.');
                return;
            }

            const name = $('#customerName').val().trim();
            const email = $('#customerEmail').val().trim();
            const contact = $('#customerContact').val().trim();

            if (!name || !contact) {
                toastr.error('Customer name and contact are required.');
                return;
            }

            const payload = {
                customer_name: name,
                customer_email: email || null,
                customer_contact: contact,
                discount_amount: parseFloat($('#discountAmount').val()) || 0,
                items: cart.map(item => ({
                    id: item.id,
                    quantity: item.quantity,
                })),
            };

            $('#placeOrder').prop('disabled', true).text('Saving...');

            $.ajax({
                url: orderStoreUrl,
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(payload),
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                },
            })
                .done(response => {
                    toastr.success('Order placed successfully.');
                    resetCart();
                    loadOrders();
                    currentOrderId = response.order_id;
                    const printUrl = orderPrintTemplate.replace('__ORDER__', currentOrderId);
                    window.open(printUrl, '_blank');
                })
                .fail(error => {
                    if (error.responseJSON && error.responseJSON.errors) {
                        error.responseJSON.errors.forEach(message => toastr.error(message));
                    } else {
                        toastr.error('Unable to save the order right now.');
                    }
                })
                .always(() => {
                    $('#placeOrder').prop('disabled', cart.length === 0).html('<i class="bi bi-check-circle"></i> Place Order');
                });
        });

        $('#refreshOrders, #refreshOrdersTop').on('click', function () {
            loadOrders();
        });

        $('#orderHistoryTable').on('click', '.view-order', function () {
            const id = $(this).data('id');
            const url = orderShowTemplate.replace('__ORDER__', id);

            $.get(url)
                .done(response => {
                    currentOrderId = response.id;
                    $('#detailOrderNumber').text(`#${response.reference}`);
                    $('#detailCustomer').text(response.customer_name);
                    $('#detailEmail').text(response.customer_email || '-');
                    $('#detailContact').text(response.customer_contact);
                    $('#detailCreated').text(response.created_at);

                    const itemsBody = $('#detailItems');
                    itemsBody.empty();

                    (response.items || []).forEach(item => {
                        const row = $('<tr>');
                        $('<td>').text(item.item_name).appendTo(row);
                        $('<td>').addClass('text-center').text(item.quantity).appendTo(row);
                        $('<td>').addClass('text-right').text(`₹ ${formatMoney(item.unit_price)}`).appendTo(row);
                        $('<td>').addClass('text-right').text(`₹ ${formatMoney(item.line_total)}`).appendTo(row);
                        itemsBody.append(row);
                    });

                    $('#detailSubtotal').text(`₹ ${formatMoney(response.subtotal)}`);
                    $('#detailDiscount').text(`₹ ${formatMoney(response.discount_amount)}`);
                    $('#detailTotal').text(`₹ ${formatMoney(response.total_amount)}`);

                    $('#orderDetailsModal').modal('show');
                })
                .fail(() => {
                    toastr.error('Unable to fetch order details.');
                });
        });

        $('#orderHistoryTable').on('click', '.print-order', function () {
            const id = $(this).data('id');
            const url = orderPrintTemplate.replace('__ORDER__', id);
            window.open(url, '_blank');
        });

        $('#detailPrint').on('click', function () {
            if (!currentOrderId) {
                return;
            }
            const url = orderPrintTemplate.replace('__ORDER__', currentOrderId);
            window.open(url, '_blank');
        });
    });
</script>
@endsection
