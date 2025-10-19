@extends('order.layouts.app')

@section('title', (optional($settings)->store_name ?? $vendor->name) . ' – Menu')
@section('page-id', 'items')

@section('content')
<section class="py-5 bg-white border-bottom">
    <div class="container d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-4">
        <div>
            <span class="badge text-bg-primary-subtle text-primary mb-2">Our menu</span>
            <h1 class="fw-bold mb-2">Discover what {{ optional($settings)->store_name ?? $vendor->name }} is serving today</h1>
            <p class="text-secondary mb-0">Order type: <span class="fw-semibold" id="orderTypeBadge">Dining</span></p>
        </div>
        <div class="d-flex gap-2">
            <a class="btn btn-outline-secondary" href="{{ route('order.index', ['code' => $vendor->code]) }}"><i class="bi bi-arrow-left me-1"></i>Change order type</a>
            <button class="btn btn-primary position-relative" data-bs-toggle="offcanvas" data-bs-target="#cartDrawer">
                <i class="bi bi-bag-check me-1"></i> Cart
                <span id="cartCountBadge" class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle">0</span>
            </button>
        </div>
    </div>
</section>

<section class="py-4">
    <div class="container">
        <div class="filter-bar shadow-sm p-3 rounded-4 bg-white border border-light-subtle mb-4">
            <div class="row g-3 align-items-center">
                <div class="col-12 col-lg-6">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input id="searchInput" type="text" class="form-control" placeholder="Search for dishes or ingredients">
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <label class="form-label small text-secondary mb-1">Category</label>
                    <select id="categorySelect" class="form-select">
                        <option value="all">All categories</option>
                    </select>
                </div>
                <div class="col-6 col-lg-3">
                    <label class="form-label small text-secondary mb-1">Sort by</label>
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
</section>

<section class="cart-bar bg-white border-top shadow-sm py-3">
    <div class="container d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div class="small text-secondary">Items: <span id="cartItemsCount">0</span></div>
        <div class="fw-bold">Subtotal: <span id="cartSubtotal">₹0.00</span></div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary btn-sm" id="clearCartBtn" type="button">Clear cart</button>
            <a class="btn btn-primary btn-sm" href="{{ route('order.checkout', ['code' => $vendor->code]) }}">Review & Checkout</a>
        </div>
    </div>
</section>
@endsection
