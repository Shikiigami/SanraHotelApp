<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            color: #000;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .hotel-info {
            text-align: right;
        }

        .hotel-logo {
            font-size: 36px;
            color: #d4a017;
            font-weight: bold;
            font-family: 'Georgia', serif;
        }

        h1 {
            font-size: 36px;
            margin: 0;
        }

        .section {
            margin-top: 40px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th {
            background-color: #004d25;
            color: white;
            padding: 8px;
            font-weight: normal;
        }

        td {
            padding: 8px;
            vertical-align: top;
        }

        .no-border {
            border: none;
        }

        .right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        .print-btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 14px;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 20px;
        }

        .print-btn:hover {
            background-color: #0056b3;
        }

        @media print {
            .print-btn {
                display: none;
            }
        }
    </style>
</head>
<body>

    <button class="print-btn" onclick="window.print()">🖨 Print Invoice</button>

    <div class="header">
        <div>
            <div class="hotel-logo"><img src="{{asset('assets/images/logo.png')}}" width="100" height="100" alt=""></div>
            <div style="font-size: 20px; font-family: 'Georgia', serif;">Hospitality Management Hostel</div>
        </div>
        <div class="hotel-info">
            <h1>INVOICE</h1>
            <p>San Rafael Hotel<br>
               Puerto Princesa<br>
               City, 5300</p>
        </div>
    </div>

    <div class="section">
        <div style="display: flex; justify-content: space-between;">
            <div>
                <strong>Billed to</strong><br>
                {{ $billing->guest_name ?? 'John Smith' }}<br>
                {{ $billing->guest_address ?? ' ' }}
            </div>

            <div>
                <strong>Invoice number:</strong> INV-{{ $billing->id}}<br>
                <strong>Invoice date:</strong> {{ \Carbon\Carbon::parse($billing->invoice_date)->format('F j, Y') ?? 'October 29, 2024' }}<br>
                <strong>Due date:</strong> {{ \Carbon\Carbon::parse($billing->due_date)->format('F j, Y') ?? 'November 12, 2024' }}
            </div>
        </div>
    </div>

    <div class="section">
        <table>
            <thead>
                <tr>
                    <th>Item #</th>
                    <th>Description</th>
                    <th>Unit Price</th>
                    <th>Qty</th>
                    <th>Discount(%)</th>
                    <th>Tax(%)</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($details as $index => $item)
                    <tr>
                        <td class="right">{{ $index + 1 }}</td>
                        <td>{{ $item->description }}</td>
                        <td class="right">{{ number_format($item->unit_price, 2) }}</td>
                        <td class="right">{{ $item->quantity }}</td>
                        <td class="right">{{ $item->discount ?? 0 }}</td>
                        <td class="right">{{ $item->tax ?? 0 }}</td>
                        <td class="right">{{ number_format($item->total_amount, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section" style="text-align: right; margin-top: 10px;">
        <p>Subtotal: <strong>{{ number_format($billing->subtotal ?? 0, 2) }}</strong></p>
        <p>Tax: <strong>{{ number_format($billing->tax ?? 0, 2) }}</strong></p>
        <p>Total: <strong>₱{{ number_format($billing->total_amount ?? 0, 2) }}</strong></p>
    </div>

    <div class="section">
        <strong>Please make payment to</strong><br>
        Hospitality Management Hostel bank account<br>
        123456789xx<br>
        San Rafael,Puerto Princesa City
    </div>

    <div class="section">
        <strong>Terms and conditions</strong><br>
        Thank you for staying with us!
    </div>

    <footer style="margin-top: 50px; font-size: 12px; text-align: center;">
        Page 1 of 1
    </footer>

</body>
</html>
