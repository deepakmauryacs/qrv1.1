@extends('vendor.layouts.default')

@section('pageTitle', 'POS Orders')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">POS Orders</h1>
        <a href="{{ route('vendor.pos.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Back to POS
        </a>
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
                            <th>Status</th>
                            <th class="text-right">Created</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="ordersEmptyRow">
                            <td colspan="8" class="text-center text-muted py-3">No orders yet</td>
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
                    <div><strong>Contact:</strong> <span id="detailContact"></span></div>
                    <div><strong>Email:</strong> <span id="detailEmail"></span></div>
                    <div><strong>Status:</strong> <span id="detailStatus" class="badge badge-secondary"></span></div>
                    <div><strong>Created At:</strong> <span id="detailCreated"></span></div>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th class="text-center" style="width:80px;">Qty</th>
                                <th class="text-right" style="width:90px;">Price</th>
                                <th class="text-right" style="width:100px;">Total</th>
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
                <div class="btn-group" role="group" id="detailPrintGroup">
                    <button type="button" class="btn btn-outline-primary detail-print" data-format="80mm">
                        <i class="bi bi-printer"></i>
                        <span class="d-none d-sm-inline"> Print 80mm</span>
                    </button>
                    <button type="button" class="btn btn-outline-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item detail-print" data-format="80mm" href="#">Print 80mm</a>
                        <a class="dropdown-item detail-print" data-format="a4" href="#">Print A4</a>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    const ordersUrl = "{{ route('vendor.pos.orders.list') }}";
    const orderShowTemplate = "{{ route('vendor.pos.orders.show', ['order' => '__ORDER__']) }}";
    const orderPrintTemplate = "{{ route('vendor.pos.orders.print', ['order' => '__ORDER__']) }}";
    const orderUpdateTemplate = "{{ route('vendor.pos.orders.update', ['order' => '__ORDER__']) }}";
    const csrfToken = "{{ csrf_token() }}";

    const formatMoney = (value) => parseFloat(value || 0).toFixed(2);
    const statusLabel = (status) => {
        if (status === 'draft') return 'Draft';
        if (status === 'completed') return 'Completed';
        return status ? status.charAt(0).toUpperCase() + status.slice(1) : '—';
    };
    const statusClass = (status) => {
        if (status === 'draft') return 'badge badge-warning';
        if (status === 'completed') return 'badge badge-success';
        return 'badge badge-secondary';
    };

    const buildPrintUrl = (id, format = '80mm') => {
        const url = orderPrintTemplate.replace('__ORDER__', id);
        const query = `format=${encodeURIComponent(format)}`;
        return url.includes('?') ? `${url}&${query}` : `${url}?${query}`;
    };

    const openPrintWindow = (id, format = '80mm') => {
        if (!id) {
            return;
        }

        const printUrl = buildPrintUrl(id, format);
        window.open(printUrl, '_blank');
    };

    let currentOrderId = null;

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
                    $('<td>').text(order.customer_contact || '-').appendTo(row);
                    $('<td>').addClass('text-right').text(`₹ ${formatMoney(order.total_amount)}`).appendTo(row);
                    const statusBadge = $('<span>').addClass(statusClass(order.status)).text(statusLabel(order.status));
                    $('<td>').append(statusBadge).appendTo(row);
                    $('<td>').addClass('text-right').text(order.created_at).appendTo(row);

                    const actionCell = $('<td>').addClass('text-right');
                    const actionWrapper = $('<div>').addClass('d-inline-flex align-items-center');

                    const viewBtn = $('<button>')
                        .addClass('btn btn-outline-primary btn-sm mr-1 view-order')
                        .attr('title', 'View order details')
                        .data('id', order.id)
                        .append($('<i>').addClass('bi bi-eye'));

                    const printGroup = $('<div>').addClass('btn-group btn-group-sm');
                    const printPrimary = $('<button>')
                        .addClass('btn btn-outline-secondary btn-sm print-order')
                        .attr('title', 'Print 80mm receipt')
                        .data('id', order.id)
                        .data('format', '80mm')
                        .append($('<i>').addClass('bi bi-printer'))
                        .append($('<span>').addClass('d-none d-lg-inline ml-1').text('80mm'));

                    const printToggle = $('<button>')
                        .addClass('btn btn-outline-secondary btn-sm dropdown-toggle dropdown-toggle-split')
                        .attr('data-toggle', 'dropdown')
                        .attr('aria-haspopup', 'true')
                        .attr('aria-expanded', 'false');
                    printToggle.append($('<span>').addClass('sr-only').text('Toggle Dropdown'));

                    const dropdownMenu = $('<div>').addClass('dropdown-menu dropdown-menu-right');
                    $('<a>')
                        .addClass('dropdown-item print-order')
                        .attr('href', '#')
                        .data('id', order.id)
                        .data('format', '80mm')
                        .text('Print 80mm')
                        .appendTo(dropdownMenu);
                    $('<a>')
                        .addClass('dropdown-item print-order')
                        .attr('href', '#')
                        .data('id', order.id)
                        .data('format', 'a4')
                        .text('Print A4')
                        .appendTo(dropdownMenu);

                    printGroup.append(printPrimary, printToggle, dropdownMenu);

                    actionWrapper.append(viewBtn, printGroup);

                    if (order.status === 'draft') {
                        const convertBtn = $('<button>')
                            .addClass('btn btn-success btn-sm ml-1 convert-order')
                            .attr('title', 'Convert to confirmed order')
                            .data('id', order.id)
                            .append($('<i>').addClass('bi bi-check2-circle'));
                        actionWrapper.append(convertBtn);
                    }

                    actionCell.append(actionWrapper).appendTo(row);
                    body.append(row);
                });
            })
            .fail(() => toastr.error('Unable to load orders right now.'));
    };

    $(document).ready(function () {
        loadOrders();

        $('#refreshOrders').on('click', function () {
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
                    $('#detailContact').text(response.customer_contact || '-');
                    $('#detailEmail').text(response.customer_email || '-');
                    $('#detailStatus').attr('class', statusClass(response.status)).text(statusLabel(response.status));
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
                .fail(() => toastr.error('Unable to fetch order details.'));
        });

        $('#orderHistoryTable').on('click', '.print-order', function (event) {
            event.preventDefault();

            const id = $(this).data('id');
            const format = $(this).data('format') || '80mm';
            openPrintWindow(id, format);
        });

        $('#orderHistoryTable').on('click', '.convert-order', function () {
            const id = $(this).data('id');
            const url = orderUpdateTemplate.replace('__ORDER__', id);

            $.ajax({
                url: url,
                method: 'PATCH',
                contentType: 'application/json',
                data: JSON.stringify({ status: 'completed' }),
                headers: { 'X-CSRF-TOKEN': csrfToken }
            })
            .done(response => {
                toastr.success(response.message || 'Order converted successfully.');
                loadOrders();
            })
            .fail(error => {
                if (error.responseJSON && error.responseJSON.errors)
                    error.responseJSON.errors.forEach(m => toastr.error(m));
                else toastr.error('Unable to update the order status.');
            });
        });

        $('#detailPrintGroup').on('click', '.detail-print', function (event) {
            event.preventDefault();

            if (!currentOrderId) {
                return;
            }

            const format = $(this).data('format') || '80mm';
            openPrintWindow(currentOrderId, format);
        });
    });
</script>
@endsection
