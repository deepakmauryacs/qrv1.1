@extends('order.layouts.app')

@section('title', (optional($settings)->store_name ?? $vendor->name) . ' – Checkout')
@section('page-id', 'checkout')

@section('content')
<section class="py-5 bg-white border-bottom">
    <div class="container d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
        <div>
            <span class="badge text-bg-primary-subtle text-primary mb-2">Almost there</span>
            <h1 class="fw-bold mb-2"><i class="bi bi-receipt-cutoff text-primary me-2"></i>Review & confirm</h1>
            <p class="text-secondary small mb-0">Order type: <span class="fw-semibold" id="checkoutOrderType">Dining</span></p>
        </div>
        <a class="btn btn-outline-secondary" href="{{ route('order.items', ['code' => $vendor->code]) }}"><i class="bi bi-arrow-left me-1"></i>Back to menu</a>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-12 col-lg-7">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-4">
                        <h5 class="fw-semibold mb-3">Your cart</h5>
                        <div id="checkoutItems" class="mb-3"></div>
                        <div class="d-flex justify-content-between text-secondary small mb-2"><span>Subtotal</span><span id="checkoutSubtotal">₹0.00</span></div>
                        <div class="d-flex justify-content-between fw-bold fs-5"><span>Total</span><span id="checkoutTotal">₹0.00</span></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-5">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-4">
                        <h5 class="fw-semibold mb-3">Customer details</h5>
                        <form id="checkoutForm" class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Full name</label>
                                <input type="text" class="form-control" id="checkoutName" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Contact number</label>
                                <input type="tel" class="form-control" id="checkoutContact" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Email (optional)</label>
                                <input type="email" class="form-control" id="checkoutEmail">
                            </div>
                            <div class="col-12" id="tableNumberGroup">
                                <label class="form-label">Table number</label>
                                <input type="text" class="form-control" id="checkoutTable" placeholder="e.g., T5">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Special request</label>
                                <textarea class="form-control" id="checkoutNotes" rows="3" placeholder="Any special instructions..."></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary w-100 btn-lg rounded-pill" id="placeOrderBtn">
                                    <i class="bi bi-check2-circle me-1"></i>Place order
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
