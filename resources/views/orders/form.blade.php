@php
    $menus = ["Original", "Sambal Matah", "Mentai", "Egg Mayo", "Cabe Garam", "Salted Egg"];
@endphp

<label>Menu</label>
<select name="menu">
    @foreach ($menus as $menu)
        <option value="{{ $menu }}" {{ old('menu', $order->menu ?? '') == $menu ? 'selected' : '' }}>
            {{ $menu }}
        </option>
    @endforeach
</select><br>

<label>Quantity</label>
<input type="number" name="quantity" value="{{ old('quantity', $order->quantity ?? 1) }}"><br>

<label>Notes</label>
<input type="text" name="notes" value="{{ old('notes', $order->notes ?? '') }}"><br>

<label>Order Date</label>
<input type="date" name="order_date" value="{{ old('order_date', $order->order_date ?? date('Y-m-d')) }}"><br>

<button type="submit">Submit</button>
