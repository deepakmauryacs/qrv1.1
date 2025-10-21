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
        <div class="filter-bar shadow-sm p-4 rounded-4 bg-white border border-light-subtle mb-4">
            <div class="d-flex flex-column flex-lg-row align-items-lg-end gap-4">
                <div class="flex-grow-1 w-100">
                    <label for="searchInput" class="form-label text-uppercase fw-semibold small text-secondary mb-2">Search the menu</label>
                    <div class="input-icon-wrapper">
                        <span class="input-icon"><i class="bi bi-search"></i></span>
                        <input id="searchInput" type="text" class="form-control form-control-lg" placeholder="Search for dishes or ingredients">
                    </div>
                    <p class="text-secondary small mb-0 mt-2">Find dishes instantly by name or ingredient to speed up ordering.</p>
                </div>
                <div class="d-flex flex-column flex-sm-row flex-lg-column flex-xxl-row gap-3 w-100 w-lg-auto">
                    <div class="flex-grow-1">
                        <label for="categorySelect" class="form-label text-uppercase fw-semibold small text-secondary mb-2">Category</label>
                        <div class="input-icon-wrapper">
                            <span class="input-icon"><i class="bi bi-grid-1x2"></i></span>
                            <select id="categorySelect" class="form-select form-select-lg">
                                <option value="all">All categories</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <label for="sortSelect" class="form-label text-uppercase fw-semibold small text-secondary mb-2">Sort by</label>
                        <div class="input-icon-wrapper">
                            <span class="input-icon"><i class="bi bi-funnel"></i></span>
                            <select id="sortSelect" class="form-select form-select-lg">
                                <option value="recommended">Recommended</option>
                                <option value="price-asc">Price: Low to High</option>
                                <option value="price-desc">Price: High to Low</option>
                                <option value="name-asc">Name: A → Z</option>
                            </select>
                        </div>
                    </div>
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
    <div class="container">
        <div class="cart-bar__content">
            <div class="cart-bar__meta">
                <span class="cart-bar__icon"><i class="bi bi-basket"></i></span>
                <div>
                    <p class="cart-bar__title mb-0">Your cart</p>
                    <p class="text-secondary small mb-0">Items: <span id="cartItemsCount">0</span></p>
                </div>
            </div>
            <div class="cart-bar__subtotal">Subtotal: <span id="cartSubtotal">₹0.00</span></div>
            <div class="cart-bar__actions">
                <button class="btn btn-outline-secondary" id="clearCartBtn" type="button">Clear cart</button>
                <a class="btn btn-primary" href="{{ route('order.checkout', ['code' => $vendor->code]) }}">Review & Checkout</a>
            </div>
        </div>
    </div>
</section>
@endsection
