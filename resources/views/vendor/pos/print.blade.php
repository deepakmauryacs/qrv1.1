<!DOCTYPE html>
<html lang="en">
@php
    $format = ($format ?? '80mm') === 'a4' ? 'a4' : '80mm';
    $isA4 = $format === 'a4';
    $orderNumber = str_pad($order->id, 6, '0', STR_PAD_LEFT);
    $currencySymbol = $posSetting->currency ?? '₹';
    $timezoneName = $posSetting->timezone ?? config('app.timezone');
    $displayedTime = ($receiptTime ?? $order->created_at)->copy()->timezone($timezoneName);
    $invoiceLogoUrl = $posSetting->invoice_logo ? asset($posSetting->invoice_logo) : null;
@endphp
<head>
    <meta charset="utf-8">
    <title>POS Receipt #{{ $orderNumber }}</title>
    <style>
        @page {
            size: {{ $isA4 ? 'A4 portrait' : '80mm auto' }};
            margin: {{ $isA4 ? '15mm' : '4mm' }};
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'DM Sans', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #000000;
            margin: 0;
        }

        body.receipt-80mm {
            background-color: #ffffff;
            font-size: 11px;
        }

        body.receipt-a4 {
            background-color: #f5f7fa;
            font-size: 13px;
        }

        .receipt-wrapper {
            margin: 0 auto;
        }

        body.receipt-80mm .receipt-wrapper {
            width: 80mm;
            padding: 6mm 4mm;
            background: #ffffff;
        }

        body.receipt-a4 .receipt-wrapper {
            width: 185mm;
            padding: 18mm 20mm;
            background: #ffffff;
            box-shadow: 0 0 12px rgba(15, 23, 42, 0.12);
            border-radius: 6px;
        }

        h1, h2, h3, h4, h5, h6 {
            margin: 0;
            font-weight: 600;
        }

        .header {
            text-align: center;
            margin-bottom: {{ $isA4 ? '16px' : '8px' }};
        }

        .header h2 {
            font-size: {{ $isA4 ? '26px' : '18px' }};
            margin-bottom: 4px;
        }

        .meta {
            color: #4a5568;
            font-size: {{ $isA4 ? '13px' : '11px' }};
            margin-bottom: {{ $isA4 ? '12px' : '6px' }};
        }

        .meta-grid {
            margin-top: {{ $isA4 ? '16px' : '10px' }};
        }

        body.receipt-a4 .meta-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 8px 18px;
        }

        body.receipt-80mm .meta-grid > div {
            margin-bottom: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: {{ $isA4 ? '18px' : '12px' }};
        }

        th, td {
            text-align: left;
        }

        body.receipt-80mm table thead th,
        body.receipt-80mm table tbody td {
            font-size: 11px;
            padding: 4px 0;
        }

        body.receipt-a4 table thead th,
        body.receipt-a4 table tbody td {
            font-size: 13px;
            padding: 8px 0;
        }

        body.receipt-80mm table thead th {
            border-bottom: 1px dashed #2d3748;
        }

        body.receipt-80mm table tbody td {
            border-bottom: 1px dashed #e2e8f0;
        }

        body.receipt-a4 table thead th {
            border-bottom: 2px solid #2d3748;
        }

        body.receipt-a4 table tbody td {
            border-bottom: 1px solid #e2e8f0;
        }

        .qty {
            text-align: center;
            width: {{ $isA4 ? '70px' : '18mm' }};
        }

        .price {
            text-align: right;
            width: {{ $isA4 ? '110px' : '22mm' }};
        }

        .totals {
            margin-top: {{ $isA4 ? '16px' : '10px' }};
        }

        .totals td {
            border-bottom: none !important;
        }

        .totals tr td:last-child {
            text-align: right;
        }

        body.receipt-a4 .totals tr td {
            padding: 6px 0;
        }

        body.receipt-a4 .totals tr:last-child td {
            font-size: 16px;
        }

        .footer-note {
            text-align: center;
            font-size: {{ $isA4 ? '12px' : '10px' }};
            margin-top: {{ $isA4 ? '24px' : '12px' }};
        }

        .footer-note strong {
            display: block;
            font-size: {{ $isA4 ? '14px' : '11px' }};
            margin-bottom: 4px;
        }

        @media print {
            body.receipt-80mm {
                width: 80mm;
            }

            body.receipt-a4 {
                background: #ffffff;
            }

            body.receipt-a4 .receipt-wrapper {
                box-shadow: none;
                border-radius: 0;
            }
        }
    </style>
</head>
<body class="receipt-{{ $format }}">
    <div class="receipt-wrapper">
        <div class="header">
            @if($invoiceLogoUrl)
                <div class="mb-2">
                    <img src="{{ $invoiceLogoUrl }}" alt="Invoice logo" style="max-height: {{ $isA4 ? '80px' : '60px' }}; max-width: 100%; object-fit: contain;">
                </div>
            @endif
            <h2>{{ $vendor->business_name ?? $vendor->name }}</h2>
            <div class="meta">Order #: {{ $orderNumber }}</div>
            <div class="meta">{{ $displayedTime->format('d M Y H:i') }} ({{ $timezoneName }})</div>
        </div>

        <div class="meta-grid">
            <div><strong>Customer:</strong> {{ $order->customer_name }}</div>
            <div><strong>Contact:</strong> {{ $order->customer_contact ?? '—' }}</div>
            <div><strong>Email:</strong> {{ $order->customer_email ?? '—' }}</div>
            <div><strong>Status:</strong> {{ $order->status ? ucfirst($order->status) : '—' }}</div>
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th class="qty">Qty</th>
                    <th class="price">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $item->item_name }}</td>
                        <td class="qty">{{ $item->quantity }}</td>
                        <td class="price">{{ $currencySymbol }} {{ number_format($item->line_total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <table class="totals">
            <tbody>
                <tr>
                    <td><strong>Subtotal</strong></td>
                    <td>{{ $currencySymbol }} {{ number_format($order->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td><strong>Discount</strong></td>
                    <td>{{ $currencySymbol }} {{ number_format($order->discount_amount, 2) }}</td>
                </tr>
                <tr>
                    <td><strong>Total</strong></td>
                    <td><strong>{{ $currencySymbol }} {{ number_format($order->total_amount, 2) }}</strong></td>
                </tr>
            </tbody>
        </table>

        <div class="footer-note">
            <strong>{{ $vendor->business_name ?? $vendor->name }}</strong>
            Thank you for dining with us!
        </div>
    </div>
    <script>
        window.onload = function () {
            setTimeout(function () {
                window.print();
            }, 300);
        };
    </script>
</body>
</html>
