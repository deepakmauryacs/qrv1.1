<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Invoice - Order #{{ $invoice->invoice_id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        .receipt {
            width: 80mm;
            padding: 6.35mm;
            page-break-after: always;
        }

        .header {
            text-align: center;
            margin-bottom: 3mm;
        }

        .restaurant-logo {
            width: 20px;
            height: 20px;
            margin-top: 3px;
        }

        .restaurant-name {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 5px;
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 1mm;
        }

        .restaurant-info {
            font-size: 9pt;
            margin-bottom: 1mm;
        }

        .order-info {
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            padding: 2mm 0;
            margin-bottom: 3mm;
            font-size: 9pt;
        }

        . {
            font-weight: bold;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 3mm;
            font-size: 9pt;
        }

        .items-table th {
            text-align: left;
            padding: 1mm;
            border-bottom: 1px solid #000;
        }

        .items-table td {
            padding: 1mm 0;
            vertical-align: top;
        }

        .qty {
            width: 10%;
            text-align: center;
        }

        .description {
            width: 50%;
        }

        .price {
            width: 20%;
            text-align: right;
        }

        .amount {
            width: 20%;
            text-align: right;
        }

        .summary {
            font-size: 9pt;
            margin-top: 2mm;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1mm;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            justify-content: space-between;
            gap: 5px 55px;
            margin-bottom: 1mm;

        }

        .total {
            font-weight: bold;
            font-size: 11pt;
            border-top: 1px solid #000;
            padding-top: 1mm;
            margin-top: 1mm;
        }

        .footer {
            text-align: center;
            margin-top: 3mm;

            font-size: 9pt;
            padding-top: 2mm;
            border-top: 1px dashed #000;
        }

        .qr_code {
            margin-top: 5mm;
            margin-bottom: 3mm;
        }

        .modifiers {
            font-size: 8pt;
            color: #555;
        }

        @media print {
            @page {
                margin: 0;
                size: 80mm auto;
            }
        }
    </style>
</head>

<body>
    <div class="receipt">
        <div class="header">
            <div class="restaurant-name">
                <span></span>
                <span>{{ $profile->store_name }}</span>
            </div>

            <div class="restaurant-info">{{ $profile->store_address }}</div>
            <div class="restaurant-info">Phone: {{ $profile->store_contact }}</div>
        </div>

        <div class="order-info">

            <div class="">
                <div class="summary-row">
                    <span>Order #<span class="order-number">{{ $invoice->invoice_id }}</span></span>
                    <span class="space_left">{{ date("d M Y H:i", strtotime($invoice->created_at)) }}</span>
                </div>
                <div class="summary-grid"></div>
                <div class="summary-row"> </div>
                <div class="summary-row"> </div>
            </div>

        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th class="qty">QTY</th>
                    <th class="description">Item Name</th>
                    <th class="price">Price</th>
                    <th class="amount">Amount</th>
                </tr>
            </thead>
            <tbody>
                @php
                $sub_total = 0;
                @endphp
                @if(!empty($invoice->items))
                @foreach($invoice->items as $k => $v )
                <tr>
                    @php
                    $sub_total += $v->price*$v->quantity;
                    @endphp
                    <td class="qty">{{ $v->quantity }}</td>
                    <td class="description">{{ $v->item_name }}</td>
                    <td class="price">₹{{ $v->price }}</td>
                    <td class="amount">₹{{ $v->price*$v->quantity }}</td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>

        <div class="summary">
            <div class="summary-row">
                <span>Sub Total:</span>
                <span>₹{{ $sub_total }}</span>
            </div>
            @if($invoice->discount>0)
            <div class="summary-row">
                <span>Discount:</span>
                <span>{{ $invoice->discount }}%</span>
            </div>
            @endif
            @if($invoice->tax>0)
            <div class="summary-row">
                <span>Tax:</span>
                <span>{{ $invoice->tax }}%</span>
            </div>            
            @endif
            <div class="summary-row total">
                <span>Total:</span>
                <span>₹{{ $invoice->total_amount }}</span>
            </div>
        </div>

        <div class="footer">
            <p>Thank you for your visit!</p>
            <div> </div>
        </div>
    </div>
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>
