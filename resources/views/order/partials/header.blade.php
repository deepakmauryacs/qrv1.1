@php
    $storeName = optional($settings)->store_name ?? $vendor->name;
    $logo = optional($settings) && $settings->menu_logo ? asset($settings->menu_logo) : null;
@endphp

<header class="shadow-sm bg-white">
    <nav class="navbar navbar-expand-lg navbar-light py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2 fw-bold text-primary" href="{{ route('order.index', ['code' => $vendor->code]) }}">
                @if ($logo)
                    <img src="{{ $logo }}" alt="{{ $storeName }}" class="rounded-circle" style="width:42px;height:42px;object-fit:cover;">
                @else
                    <span class="icon-circle bg-primary-subtle text-primary d-inline-flex align-items-center justify-content-center rounded-circle" style="width:42px;height:42px;">
                        <i class="bi bi-bag-heart"></i>
                    </span>
                @endif
                <span>{{ $storeName }}</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#orderNav" aria-controls="orderNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="orderNav">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">
                    <li class="nav-item">
                        <a class="nav-link @if (request()->routeIs('order.index')) active fw-semibold @endif" href="{{ route('order.index', ['code' => $vendor->code]) }}">Home</a>
                    </li>
                   
                  
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle @if (request()->routeIs('order.login') || request()->routeIs('order.signup')) active fw-semibold @endif" href="#" id="authDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Account
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="authDropdown">
                            <li><a class="dropdown-item" href="{{ route('order.login', ['code' => $vendor->code]) }}"><i class="bi bi-box-arrow-in-right me-2"></i>Login</a></li>
                            <li><a class="dropdown-item" href="{{ route('order.signup', ['code' => $vendor->code]) }}"><i class="bi bi-person-plus me-2"></i>Sign up</a></li>
                        </ul>
                    </li>
                </ul>
                <div class="d-flex align-items-center mt-3 mt-lg-0">
                    <a href="{{ route('order.checkout', ['code' => $vendor->code]) }}" class="btn btn-primary rounded-pill d-flex align-items-center gap-2 px-3">
                        <i class="bi bi-bag-check"></i>
                        <span>Cart</span>
                        <span class="badge bg-white text-primary rounded-pill" id="headerCartCount">0</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>
</header>
