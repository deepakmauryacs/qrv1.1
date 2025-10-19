@php
    $storeName = optional($settings)->store_name ?? $vendor->name;
@endphp

<footer class="mt-5 pt-5 pb-4">
    <div class="container">
        <div class="row g-4">
            <div class="col-12 col-lg-4">
                <h5 class="text-white fw-bold d-flex align-items-center gap-2">
                    <i class="bi bi-stars text-warning"></i>
                    {{ $storeName }}
                </h5>
                <p class="mt-3 mb-2 small">Fresh flavours, quick service, and a delightful dining experience wherever you are.</p>
                <div class="d-flex gap-3">
                    <a href="#" class="fs-5"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="fs-5"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="fs-5"><i class="bi bi-twitter-x"></i></a>
                </div>
            </div>
            <div class="col-6 col-lg-2">
                <h6 class="text-white text-uppercase small fw-semibold">Explore</h6>
                <ul class="list-unstyled mt-3 small">
                    <li class="mb-2"><a href="{{ route('order.items', ['code' => $vendor->code]) }}">Our Menu</a></li>
                    <li class="mb-2"><a href="{{ route('order.checkout', ['code' => $vendor->code]) }}">Checkout</a></li>
                    <li class="mb-2"><a href="{{ route('order.profile', ['code' => $vendor->code]) }}">Order History</a></li>
                    <li class="mb-2"><a href="{{ route('order.login', ['code' => $vendor->code]) }}">Member Login</a></li>
                </ul>
            </div>
            <div class="col-6 col-lg-3">
                <h6 class="text-white text-uppercase small fw-semibold">Visit</h6>
                <ul class="list-unstyled mt-3 small">
                    @if (optional($settings)->store_address)
                        <li class="mb-2"><i class="bi bi-geo-alt me-2"></i>{{ optional($settings)->store_address }}</li>
                    @endif
                    @if (optional($settings)->store_contact)
                        <li class="mb-2"><i class="bi bi-telephone me-2"></i>{{ optional($settings)->store_contact }}</li>
                    @endif
                    @if (optional($settings)->store_email)
                        <li class="mb-2"><i class="bi bi-envelope me-2"></i>{{ optional($settings)->store_email }}</li>
                    @endif
                </ul>
            </div>
            <div class="col-12 col-lg-3">
                <h6 class="text-white text-uppercase small fw-semibold">Stay in the loop</h6>
                <p class="small mt-3">Subscribe for exclusive offers and menu highlights from {{ $storeName }}.</p>
                <form class="d-flex flex-column gap-2">
                    <input type="email" class="form-control form-control-sm" placeholder="Email address">
                    <button type="button" class="btn btn-primary btn-sm rounded-pill">Notify me</button>
                </form>
            </div>
        </div>
        <div class="border-top border-white-25 mt-4 pt-3 d-flex flex-column flex-md-row gap-3 justify-content-between align-items-center small">
            <div>© {{ now()->year }} {{ $storeName }}. All rights reserved.</div>
            <div class="d-flex gap-3">
                <a href="#">Privacy</a>
                <a href="#">Terms</a>
                <a href="#">Support</a>
            </div>
        </div>
    </div>
</footer>
