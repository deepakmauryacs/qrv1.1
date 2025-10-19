@extends('order.layouts.app')

@section('title', (optional($settings)->store_name ?? $vendor->name) . ' – Welcome')
@section('page-id', 'index')

@section('content')
<section class="py-5 py-lg-6 app-gradient">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-12 col-lg-6">
                <div class="glass-card p-4 p-lg-5">
                    <span class="badge rounded-pill text-bg-primary-subtle text-primary mb-3">Start your order</span>
                    <h1 class="display-5 fw-bold mb-3">Delicious moments from {{ optional($settings)->store_name ?? $vendor->name }}</h1>
                    <p class="text-secondary mb-4">Choose how you'd like to enjoy your meal and browse our carefully curated menu featuring seasonal specials and all-time favourites.</p>
                    <form id="orderTypeForm" class="mt-3">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="option-card card border-0 shadow-sm h-100" data-value="pickup" tabindex="0">
                                    <div class="card-body text-center d-flex flex-column align-items-center gap-2">
                                        <span class="option-icon fs-1 text-primary"><i class="bi bi-bag-check"></i></span>
                                        <h3 class="h5 fw-semibold mb-0">Pickup Order</h3>
                                        <p class="small text-secondary mb-0">Grab and go when you're on the move.</p>
                                        <input type="radio" name="order_type" value="pickup" class="visually-hidden">
                                    </div>
                                </label>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="option-card card border-0 shadow-sm h-100" data-value="dine-in" tabindex="0">
                                    <div class="card-body text-center d-flex flex-column align-items-center gap-2">
                                        <span class="option-icon fs-1 text-primary"><i class="bi bi-shop"></i></span>
                                        <h3 class="h5 fw-semibold mb-0">Dining Order</h3>
                                        <p class="small text-secondary mb-0">Relax while we serve you at your table.</p>
                                        <input type="radio" name="order_type" value="dine-in" class="visually-hidden">
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mt-4">
                            <div id="selectionText" class="text-secondary">Selected: Dining Order</div>
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill px-4 d-flex align-items-center gap-2">
                                Continue to menu
                                <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="p-4 p-lg-5">
                    <div class="rounded-4 overflow-hidden shadow-lg">
                        <img src="https://images.unsplash.com/photo-1552332386-f8dd00dc2f85?auto=format&fit=crop&w=900&q=80" alt="Dining" class="img-fluid">
                    </div>
                    <div class="mt-4 row g-3">
                        <div class="col-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <p class="text-secondary small mb-1">Today's hours</p>
                                    <h5 class="fw-semibold mb-0"><i class="bi bi-clock-history text-primary me-2"></i>11:00 AM – 11:00 PM</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <p class="text-secondary small mb-1">Location</p>
                                    <h5 class="fw-semibold mb-0"><i class="bi bi-geo-alt text-primary me-2"></i>{{ optional($settings)->store_address ?? 'We deliver nearby' }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <span class="badge text-bg-light text-primary mb-3"><i class="bi bi-fire me-1"></i>Signature picks</span>
                        <h5 class="fw-semibold">Chef-curated specials</h5>
                        <p class="text-secondary small">Seasonal produce and bold flavours make every visit memorable.</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <span class="badge text-bg-light text-primary mb-3"><i class="bi bi-emoji-smile me-1"></i>Comfort first</span>
                        <h5 class="fw-semibold">Dining made delightful</h5>
                        <p class="text-secondary small">Savour your favourites in a space designed for conversations.</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <span class="badge text-bg-light text-primary mb-3"><i class="bi bi-lightning-charge me-1"></i>Swift service</span>
                        <h5 class="fw-semibold">Pickup in minutes</h5>
                        <p class="text-secondary small">Perfect for busy schedules without compromising on taste.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
