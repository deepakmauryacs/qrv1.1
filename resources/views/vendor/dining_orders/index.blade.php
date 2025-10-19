@extends('vendor.layouts.default')
@section('pageTitle', 'Dining Orders')
@section('content')

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 text-gray-800">Dining Orders</h1>
    </div>

    <!-- Search Bar -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('vendor.dining-orders.index') }}">
                <div class="row">
                    <!-- Search Input -->
                    <div class="col-sm-4">
                        <div class="search-box">
                            <input type="text" name="search" class="form-control" id="searchMemberList"
                                placeholder="Search for name or contact..." value="{{ request('search') }}">
                        </div>
                    </div>

                    <!-- Search & Reset Buttons -->
                    <div class="col-sm-auto ms-auto">
                        <div class="list-grid-nav hstack gap-1">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-search"></i> Search
                            </button>

                            <!-- Reset Button -->
                            <a href="{{ route('vendor.dining-orders.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-clockwise"></i> Reset
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Orders in Card View -->
    <div class="row">
        @forelse($orders as $order)
            <div class="col-md-4 col-sm-12 mb-3"> <!-- 2 Items per Row -->
                <div class="card order-card">
                    <div class="card-header">
                        Table: {{ $order->table_number }}
                    </div>
                    <div class="card-body">
                        <p class="order-info">
                            <strong>Customer:</strong> {{ $order->customer_name }}
                            <strong>Contact:</strong> {{ $order->contact_no }}
                        </p>
                        <p class="order-info">
                            <strong>Order Date:</strong> {{ \Carbon\Carbon::parse($order->order_date)->format('d-m-Y') }}
                            <strong>Order Time:</strong> {{ \Carbon\Carbon::parse($order->order_time)->format('h:i A') }}
                        </p>
                        <p class="order-info">
                            <strong>Total Amount:</strong> ₹{{ number_format($order->total_amount, 2) }}
                        </p>

                        <!-- Status Dropdown -->
                        <!-- Status Dropdown -->
<!-- Status Dropdown -->
<p class="order-info">
    <div class="dropdown">
        <button class="btn btn-light dropdown-toggle custom-dropdown order-status" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-id="{{ $order->id }}">
            {{ ucfirst($order->status) }}
        </button>
        <div class="dropdown-menu">
            @foreach(['pending', 'accepted', 'preparing', 'served', 'completed', 'cancelled'] as $status)
                <a class="dropdown-item status-option" href="#" data-status="{{ $status }}" data-id="{{ $order->id }}">
                    {{ ucfirst($status) }}
                </a>
            @endforeach
        </div>
    </div>
</p>



                        <p class="order-info">
                            <strong>Payment Status:</strong>
                            <span class="badge badge-status {{ $order->payment_status == 'paid' ? 'bg-success' : ($order->payment_status == 'partial' ? 'bg-warning' : 'bg-danger') }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p>No Orders Found</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {!! $orders->links('vendor.bootstrap-4') !!}
    </div>
</div>

<!-- JavaScript to Handle Status Change -->
<script>
    $(document).ready(function () {
        // Enable Bootstrap 4 dropdowns
        $('.dropdown-toggle').dropdown();

        // Handle status update
        $('.status-option').click(function (event) {
            event.preventDefault();

            let orderId = $(this).data('id');
            let newStatus = $(this).data('status');

            let dropdownButton = $('.order-status[data-id="' + orderId + '"]');
            dropdownButton.text(newStatus.charAt(0).toUpperCase() + newStatus.slice(1));

            $.ajax({
                url: "{{ route('vendor.dining-orders.updateStatus') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    order_id: orderId,
                    status: newStatus
                },
                success: function (response) {
                    alert(response.message);
                },
                error: function () {
                    alert("Error updating status!");
                }
            });
        });
    });
</script>



@endsection
