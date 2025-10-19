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
                    <div><strong>Contact:</strong> <span id="detailContact"></span></div>
                    <div><strong>Email:</strong> <span id="detailEmail"></span></div>
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
                <button type="button" class="btn btn-outline-primary" id="detailPrint">
                    <i class="bi bi-printer"></i> Print
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    const ordersUrl = "{{ route('vendor.pos.orders.list') }}";
    const orderShowTemplate = "{{ route('vendor.pos.orders.show', ['order' => '__ORDER__']) }}";
    const orderPrintTemplate = "{{ route('vendor.pos.orders.print', ['order' => '__ORDER__']) }}";

    const formatMoney = (value) => parseFloat(value || 0).toFixed(2);

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
                    $('#detailContact').text(response.customer_contact);
                    $('#detailEmail').text(response.customer_email || '-');
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
