@extends('order.layouts.app')

@section('title', (optional($settings)->store_name ?? $vendor->name) . ' – Profile & Orders')
@section('page-id', 'profile')

@section('content')
<section class="py-5 bg-white border-bottom">
    <div class="container d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
        <div>
            <span class="badge text-bg-primary-subtle text-primary mb-2">Your hub</span>
            <h1 class="fw-bold mb-2"><i class="bi bi-person-lines-fill text-primary me-2"></i>Profile & history</h1>
            <p class="text-secondary small mb-0">Keep details updated for a faster checkout and personalised recommendations.</p>
        </div>
        <button class="btn btn-outline-secondary" id="refreshOrdersBtn" type="button"><i class="bi bi-arrow-clockwise me-1"></i>Refresh orders</button>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-12 col-lg-4">
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div id="profileAvatar" class="profile-avatar"></div>
                            <div>
                                <h5 class="fw-semibold mb-1" id="profileNameDisplay">Guest</h5>
                                <div class="small text-secondary" id="profileEmailDisplay">Add your email</div>
                                <div class="small text-secondary" id="profilePhoneDisplay">Add your contact number</div>
                            </div>
                        </div>
                        <form id="profileForm" class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Full name</label>
                                <input type="text" class="form-control" id="profileNameInput" placeholder="Your name">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" id="profileEmailInput" placeholder="you@example.com">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Contact number</label>
                                <input type="tel" class="form-control" id="profileContactInput" placeholder="Mobile number">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Preferred table</label>
                                <input type="text" class="form-control" id="profileTableInput" placeholder="e.g., T5">
                            </div>
                            <div class="col-12 d-grid">
                                <button type="submit" class="btn btn-primary rounded-pill">Save profile</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-8">
                <div class="row g-3 mb-4">
                    <div class="col-12 col-md-4">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body">
                                <p class="text-secondary small mb-1">Orders placed</p>
                                <h4 class="fw-bold mb-0" id="totalOrdersCount">0</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body">
                                <p class="text-secondary small mb-1">Active orders</p>
                                <h4 class="fw-bold mb-0 text-warning" id="activeOrdersCount">0</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body">
                                <p class="text-secondary small mb-1">Cancelled</p>
                                <h4 class="fw-bold mb-0 text-danger" id="cancelledOrdersCount">0</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-body p-4">
                        <div class="row g-3 mb-3">
                            <div class="col-12 col-lg-6">
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
                                <label class="form-label small text-secondary mb-1">Order type</label>
                                <select class="form-select" id="ordersType">
                                    <option value="all">All</option>
                                    <option value="dine-in">Dine-in</option>
                                    <option value="pickup">Pickup</option>
                                </select>
                            </div>
                        </div>
                        <div id="ordersNotice" class="alert alert-info d-none"></div>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th>Placed at</th>
                                        <th>Items</th>
                                    </tr>
                                </thead>
                                <tbody id="ordersTableBody"></tbody>
                            </table>
                        </div>
                        <div id="ordersEmptyState" class="alert alert-info d-none mt-3">No orders found for the provided details.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
