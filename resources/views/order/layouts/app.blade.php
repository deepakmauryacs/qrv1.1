<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', (optional($settings)->store_name ?? $vendor->name) . ' - Order')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'DM Sans', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
            background: #f8f9fb;
            color: #111827;
        }
        .app-gradient {
            background: linear-gradient(135deg, rgba(13, 110, 253, 0.08), rgba(99, 102, 241, 0.1));
        }
        .glass-card {
            backdrop-filter: blur(24px);
            background: rgba(255, 255, 255, 0.82);
            border-radius: 24px;
            box-shadow: 0 30px 80px rgba(15, 23, 42, 0.12);
        }
        .option-card {
            cursor: pointer;
            border: 2px solid transparent;
            border-radius: 20px !important;
            transition: transform .15s ease, box-shadow .15s ease, border-color .15s ease;
        }
        .option-card:hover,
        .option-card:focus {
            transform: translateY(-2px);
            box-shadow: 0 16px 40px rgba(15, 23, 42, 0.12);
        }
        .option-card.active {
            border-color: #0d6efd;
            box-shadow: 0 0 0 6px rgba(13, 110, 253, 0.12);
        }
        .profile-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: #eef2ff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            color: #0d6efd;
            box-shadow: 0 12px 32px rgba(79, 70, 229, 0.16);
        }
        .filter-bar {
            position: sticky;
            top: 120px;
            z-index: 10;
        }
        .item-card {
            border: 1px solid #edf1f7;
            border-radius: 18px;
            transition: transform .2s ease, box-shadow .2s ease;
            background: #fff;
            height: 100%;
        }
        .item-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.12);
        }
        .item-media {
            width: 100%;
            aspect-ratio: 1 / 1;
            border-radius: 16px;
            overflow: hidden;
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .item-media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .item-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6b7280;
            font-size: 2rem;
        }
        .cart-bar {
            position: sticky;
            bottom: 0;
            z-index: 20;
        }
        @media (max-width: 768px) {
            .filter-bar {
                top: 90px;
            }
        }
        footer {
            background: #0b1220;
            color: rgba(255, 255, 255, 0.78);
        }
        footer a {
            color: rgba(255, 255, 255, 0.78);
            text-decoration: none;
        }
        footer a:hover {
            color: #fff;
        }
    </style>
    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100" data-page="@yield('page-id', 'index')">
    @include('order.partials.header', ['vendor' => $vendor, 'settings' => $settings ?? null])

    <div id="alertContainer" class="container my-3"></div>

    <main class="flex-grow-1">
        @yield('content')
    </main>

    @include('order.partials.footer', ['vendor' => $vendor, 'settings' => $settings ?? null])
    @include('order.partials.cart-drawer')

    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1080;">
        <div id="toast" class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body"></div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.orderAppConfig = {
            vendor: @json([
                'name' => optional($settings)->store_name ?? $vendor->name,
                'address' => optional($settings)->store_address,
                'contact' => optional($settings)->store_contact,
                'email' => optional($settings)->store_email,
                'logo' => optional($settings) && $settings->menu_logo ? asset($settings->menu_logo) : null,
            ]),
            routes: {
                index: "{{ route('order.index', ['code' => $vendor->code]) }}",
                items: "{{ route('order.items', ['code' => $vendor->code]) }}",
                checkout: "{{ route('order.checkout', ['code' => $vendor->code]) }}",
                profile: "{{ route('order.profile', ['code' => $vendor->code]) }}",
                login: "{{ route('order.login', ['code' => $vendor->code]) }}",
                signup: "{{ route('order.signup', ['code' => $vendor->code]) }}"
            },
            endpoints: {
                menu: "{{ route('order.menu', ['code' => $vendor->code]) }}",
                store: "{{ route('order.store', ['code' => $vendor->code]) }}",
                history: "{{ route('order.history', ['code' => $vendor->code]) }}"
            },
            csrf: "{{ csrf_token() }}"
        };
    </script>
    <script src="{{ asset('order/order-app.js') }}"></script>
    @stack('scripts')
</body>
</html>
