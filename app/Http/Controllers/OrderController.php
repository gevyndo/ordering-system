<?php
namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Response; // Tambahkan di bagian atas jika belum


class OrderController extends Controller
{
    private $menuPrices = [
        'Original' => 25000,
        'Sambal Matah' => 30000,
        'Mentai' => 30000,
        'Egg Mayo' => 30000,
        'Cabe Garam' => 30000,
        'Salted Egg' => 30000,
    ];
    

    public function index()
    {
        $totalPrice = Order::sum('price');
        
        return view('orders.index', [
            'orders' => Order::all(),
            'totalPrice' => $totalPrice
        ]);
        
    }

    public function create()
    {
        return view('orders.create');
    }
    private function calculatePrice($menu, $quantity, $addEgg)
    {
        $basePrice = $this->menuPrices[$menu] ?? 25000;

        if ($addEgg) {
            $basePrice += 4000;
        }

        return $basePrice * $quantity;
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'menu' => 'required|in:' . implode(',', array_keys($this->menuPrices)),
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
            'order_date' => 'required|date',
            'payment_method' => 'nullable|in:QRIS,Cash,Transfer',
            'add_egg' => 'required|boolean',
        ]);
    
        $validated['price'] = $this->calculatePrice(
            $validated['menu'],
            $validated['quantity'],
            $validated['add_egg']
        );
    
        Order::create($validated);
    
        return redirect()->route('orders.index')->with('success', 'Order created!');
    }
    
    public function edit(Order $order)
    {
        return view('orders.edit', ['order' => $order]);
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'menu' => 'required|in:' . implode(',', array_keys($this->menuPrices)),
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
            'order_date' => 'required|date',
            'payment_method' => 'required|in:QRIS,Cash,Transfer',
            'add_egg' => 'required|boolean',
        ]);
    
        $validated['price'] = $this->calculatePrice(
            $validated['menu'],
            $validated['quantity'],
            $validated['add_egg']
        );
    
        $order->update($validated);
    
        return redirect()->route('orders.index')->with('success', 'Order updated!');
    }
    

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order deleted!');
    }

    public function exportCsv(): StreamedResponse
    {
        $orders = Order::all();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="orders.csv"',
        ];

        $columns = ['ID', 'Name', 'Menu', 'Quantity', 'Notes', 'Price', 'Payment Method', 'Add Egg', 'Order Date', 'Created At', 'Updated At'];

        $callback = function () use ($orders, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->id,
                    $order->name,
                    $order->menu,
                    $order->quantity,
                    $order->notes,
                    $order->price,
                    $order->payment_method,
                    $order->add_egg ? 'Yes' : 'No',
                    $order->order_date,
                    $order->created_at,
                    $order->updated_at,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
