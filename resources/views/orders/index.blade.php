<!DOCTYPE html>
<html>
<head>
    
    <title>Orders</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter&family=Montserrat&display=swap" rel="stylesheet">
    <style>
        body {
            font-family:  sans-serif;
            background-color: #EDECE7;
            margin: 0;
            padding: 20px;
        }
        h1, h2 {
            color: #333;
        }
        .button {
            background-color: #28a745;
            border: none;
            color: white;
            padding: 10px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 8px 4px 0;
            cursor: pointer;
            border-radius: 4px;
        }
        .order-item {
            background-color: #fff;
            margin-bottom: 8px;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            width: 60%;
        }
        .order-actions {
            margin-top: 5px;
        }
        form {
            display: inline;
        }
        .button-group {
            margin-bottom: 10px;
            
        }
    </style>
</head>
<body>

<a href="{{ route('orders.index') }}">
    <img src="{{ asset('images/logo.png') }}" alt="Company Logo" style="width: 259px; margin-bottom: 10px;">
</a>

<h1>All Orders</h1>


<div class="button-group">
    <a class="button" href="{{ route('orders.create') }}" style="margin-bottom: 20px; display: inline-block;">Create Order</a>
    <a class="button" style="background-color:#17a2b8" href="{{ route('orders.export.csv') }}">Export CSV</a>
</div>

<div>
    @foreach ($orders as $order)
        <div class="order-item">
            {{ $order->name }} - {{ date('Y-m-d H:i', strtotime($order->order_date)) }} <br>
            {{ $order->menu }} x {{ $order->quantity }} (Rp{{ number_format($order->price, 0, ',', '.') }}) <br>
            Notes: {{ $order->notes }}<br>
            <div class="order-actions">
                <a class="button" href="{{ route('orders.edit', $order) }}">Edit</a>
                <form method="POST" action="{{ route('orders.destroy', $order) }}">
                    @csrf @method('DELETE')
                    <button class="button" style="background-color:#dc3545" type="submit">Delete</button>
                </form>
            </div>
        </div>
    @endforeach
</div>

<h2>Revenue: Rp{{ number_format($totalPrice, 0, ',', '.') }}</h2>
</body>
</html>
