<!DOCTYPE html>
<html>
<head>
    <title>Orders</title>
    <link rel="icon" href="{{ asset('images/logoB.png') }}" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #EDECE7;
            margin: 0;
            padding: 20px;
        }
        .container {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            max-width: 1600px;
            margin: 20px auto; /* tengahin container secara horizontal */
        }

        h2 {
            margin-top: 0;
            font-size: 20px;
            font-weight: 600;
        }
        .button-group {
            margin-bottom: 15px;
        }
        .button {
            background-color: #28a745;
            border: none;
            color: white;
            padding: 8px 12px;
            text-align: center;
            font-size: 14px;
            margin-right: 8px;
            cursor: pointer;
            border-radius: 4px;
            text-decoration: none;
            display: inline-block;
        }
        .button-info {
            background-color: #17a2b8;
        }
        .button-icon {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 16px;
            padding: 4px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 10px;
            overflow: hidden;
            text-align: left;
            margin-left: 0;        /* ini penting */
        }

        th, td {
            padding: 14px;
            text-align: left;
            font-size: 14px;
        }
        thead {
            background-color: #f8f9fa;
            color: #555;
        }
        tbody tr {
            border-top: 1px solid #e0e0e0;
        }
        tbody tr:hover {
            background-color: #f4f4f4;
        }
        .actions {
            white-space: nowrap;
        }
        .revenue {
            margin-top: 20px;
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }
    </style>
</head>
<body>

<a href="{{ route('orders.index') }}">
    <img src="{{ asset('images/logo.png') }}" alt="Company Logo" style="width: 259px; margin-bottom: 10px;">
</a>
<div class="button-group">
        <a class="button" href="{{ route('orders.create') }}">Create Order</a>
        <a class="button button-info" href="{{ route('orders.export.csv') }}">Export CSV</a>
</div>

    <div class="container">
    <h2>All Orders</h2>
    <table>
        <thead>
            <tr>
                <th>Customer</th>
                <th>Order Date</th>
                <th>Menu</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Egg?</th>
                <th>Notes</th>
                <th>Payment</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
            <tr>
                <td>{{ $order->name }}</td>
                <td>{{ date('Y-m-d H:i', strtotime($order->order_date)) }}</td>
                <td>{{ $order->menu }}</td>
                <td>{{ $order->quantity }}</td>
                <td>Rp{{ number_format($order->price, 0, ',', '.') }}</td>
                <td>{{ $order->add_egg ? 'Yes' : 'No' }}</td>
                <td>{{ $order->notes }}</td>
                <td>{{ $order->payment_method }}</td>
                <td class="actions">
                    <a class="button-icon" href="{{ route('orders.edit', $order) }}">✏️</a>
                    <form method="POST" action="{{ route('orders.destroy', $order) }}" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="button-icon" type="submit">🗑️</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>



</div>
<div class="revenue">
    Revenue: Rp{{ number_format($totalPrice, 0, ',', '.') }}
</div>
</body>
</html>
