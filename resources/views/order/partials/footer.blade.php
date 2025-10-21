@php
    $storeName = optional($settings)->store_name ?? $vendor->name;
@endphp

<footer class="py-3 mt-5 text-center border-top">
    <div class="container">
        <p class="mb-0 small text-muted">
            © {{ now()->year }} {{ $storeName }}. All rights reserved.
        </p>
    </div>
</footer>
