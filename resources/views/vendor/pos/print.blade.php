<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>POS Receipt #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</title>
    <style>
        @page {
            size: 100mm auto;
            margin: 4mm;
        }

        body {
            font-family: 'DM Sans', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #ffffff;
            color: #000000;
            margin: 0;
        }

        .receipt-wrapper {
            width: 100mm;
            margin: 0 auto;
            padding: 6mm 4mm;
        }

        h1, h2, h3, h4, h5, h6 {
            margin: 0;
            font-weight: 600;
        }

        .text-center {
            text-align: center;
        }

        .meta {
            font-size: 12px;
            margin-bottom: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        th, td {
            font-size: 12px;
            padding: 4px 0;
        }

        th {
            border-bottom: 1px dashed #333;
            text-align: left;
        }

        td {
            border-bottom: 1px dashed #e0e0e0;
        }

        .totals td {
            border: none;
        }

        .totals tr td:last-child {
            text-align: right;
        }

        .footer-note {
            margin-top: 10px;
            font-size: 11px;
            text-align: center;
        }

        @media print {
            body {
                width: 100mm;
            }

            .receipt-wrapper {
                margin: 0;
            }
        }
    </style>
</head>
<body>
    <div class="receipt-wrapper">
        <div class="text-center">
            <h2>{{ $vendor->business_name ?? $vendor->name }}</h2>
            <div class="meta">Order #: {{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</div>
            <div class="meta">{{ $order->created_at->format('d M Y H:i') }}</div>
        </div>

        <div class="meta">
            <strong>Customer:</strong> {{ $order->customer_name }}<br>
            <strong>Email:</strong> {{ $order->customer_email ?? '-' }}<br>
            <strong>Contact:</strong> {{ $order->customer_contact }}
        </div>

        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th style="text-align: center; width: 20mm;">Qty</th>
                    <th style="text-align: right; width: 25mm;">Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $item->item_name }}</td>
                        <td style="text-align: center;">{{ $item->quantity }}</td>
                        <td style="text-align: right;">₹ {{ number_format($item->line_total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <table class="totals">
            <tbody>
                <tr>
                    <td><strong>Subtotal</strong></td>
                    <td>₹ {{ number_format($order->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td><strong>Discount</strong></td>
                    <td>₹ {{ number_format($order->discount_amount, 2) }}</td>
                </tr>
                <tr>
                    <td><strong>Total</strong></td>
                    <td><strong>₹ {{ number_format($order->total_amount, 2) }}</strong></td>
                </tr>
            </tbody>
        </table>

        <div class="footer-note">
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
