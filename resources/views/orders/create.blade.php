<!DOCTYPE html>
<html>
<head>
    <title>Create/Edit Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .form-group {
        margin-bottom: 10px;
        }

        /* Tambahkan styling khusus untuk radio group */
        .radio-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-top: 5px;
        }
        .radio-option {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .radio-option input[type="radio"] {
            margin: 0;
            width: 16px;
            height: 16px;
        }
        .form-group label:first-child {
            display: block;
            font-weight: 600;
            margin-bottom: 4px;
            color: #333;
        }
        label {
            display: block;
            margin-bottom: 0px;
        }
        input, select {
            padding: 12px;
            width: 50%;
            box-sizing: border-box;
        }
        .button {
            background-color: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
    </style>
</head>
<body>
    <a class="button" href="{{ route('orders.index') }}" style="margin-bottom: 20px;">← Back</a>

    <h1>{{ isset($order) ? 'Edit' : 'Create' }} Order</h1>

    <form method="POST" action="{{ isset($order) ? route('orders.update', $order) : route('orders.store') }}">
        @csrf
        @if(isset($order)) @method('PUT') @endif

        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name', $order->name ?? '') }}">
        </div>

        <div class="form-group">
            <label>Menu</label>
            <select name="menu">
                @foreach (["Original", "Sambal Matah", "Mentai", "Egg Mayo", "Cabe Garam", "Salted Egg"] as $menu)
                    <option value="{{ $menu }}" {{ (old('menu', $order->menu ?? '') == $menu) ? 'selected' : '' }}>{{ $menu }}</option>
                @endforeach
            </select>
        </div>
        
        <!-- Add Egg (Radio Buttons) -->
        <div class="form-group">
            <label for="add_egg">Add Egg?</label>
            <div class="radio-group">
                <div class="radio-option">
                    <input type="radio" id="add_egg_yes" name="add_egg" value="1">
                    <label for="add_egg_yes">Yes</label>
                </div>
                <div class="radio-option">
                    <input type="radio" id="add_egg_no" name="add_egg" value="0" checked>
                    <label for="add_egg_no">No</label>
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <label>Quantity</label>
            <input type="number" name="quantity" value="{{ old('quantity', $order->quantity ?? 1) }}">
        </div>

        <div class="form-group">
            <label>Notes</label>
            <input type="text" name="notes" value="{{ old('notes', $order->notes ?? '') }}">
        </div>

        <div class="form-group">
            <label>Date & Time</label>
            <input type="datetime-local" name="order_date" value="{{ old('order_date', isset($order->order_date) ? date('Y-m-d\TH:i', strtotime($order->order_date)) : date('Y-m-d\TH:i')) }}">
        </div>
        <!-- Payment Method -->
        <div class="form-group">
            <label for="payment_method">Payment Method</label>
            <select name="payment_method" id="payment_method" class="form-control">
                <option value="QRIS">QRIS</option>
                <option value="Cash">Cash</option>
                <option value="Transfer">Transfer</option>
            </select>
        </div>

        <button class="button" type="submit">Submit</button>
    </form>
</body>
</html>
