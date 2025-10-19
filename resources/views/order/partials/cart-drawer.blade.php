<div class="offcanvas offcanvas-end" tabindex="-1" id="cartDrawer" aria-labelledby="cartDrawerLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title fw-bold" id="cartDrawerLabel"><i class="bi bi-bag-check me-2"></i>Your Cart</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column">
        <div id="cartItems" class="flex-grow-1"></div>
        <div class="border-top pt-3">
            <div class="d-flex justify-content-between mb-2">
                <span class="text-secondary">Subtotal</span>
                <strong id="drawerSubtotal">₹0.00</strong>
            </div>
            <div class="d-grid gap-2">
                <a href="{{ route('order.checkout', ['code' => $vendor->code]) }}" class="btn btn-primary btn-lg" data-bs-dismiss="offcanvas">
                    Review & Checkout
                </a>
                <button id="drawerClearCartBtn" class="btn btn-outline-secondary" type="button">Clear Cart</button>
            </div>
        </div>
    </div>
</div>
