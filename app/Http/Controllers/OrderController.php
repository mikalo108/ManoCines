<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Inertia\Inertia;
use Illuminate\Support\Facades\Lang;

class OrderController extends Controller
{
    private const PAGINATE_SIZE = 10;

    // Función para devolver a la página principal del elemento
    public function index()
    {
        app()->setLocale(session('locale', app()->getLocale()));  
        $orders = Order::paginate(self::PAGINATE_SIZE);
        return Inertia::render('Order/Index', ['orders' => $orders, 'langTable' => fn () => Lang::get('tableOrders'),]);
    }

    // Show the form for creating a new order
    public function create()
    {
        return Inertia::render('Order/Form');
    }

    // Store a newly created order in storage
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'subtotal' => 'required|numeric',
            'total' => 'required|numeric',
            'products' => 'array',
            'products.*' => 'integer|exists:products,id',
        ]);

        $order = new Order();
        $order->user_id = $request->user_id;
        $order->subtotal = $request->subtotal;
        $order->total = $request->total;
        $order->save();

        if ($request->has('products')) {
            $order->products()->attach($request->products);
        }

        return redirect()->route('orders.index');
    }

    // Display the specified order
    public function show($id)
    {
        $order = Order::findOrFail($id);
        return Inertia::render('Order/Show', ['order' => $order]);
    }

    // Show the form for editing the specified order
    public function edit($id)
    {
        $order = Order::findOrFail($id);
        return Inertia::render('Order/Form', ['order' => $order]);
    }

    // Update the specified order in storage
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'subtotal' => 'required|numeric',
            'total' => 'required|numeric',
            'products' => 'array',
            'products.*' => 'integer|exists:products,id',
        ]);

        $order->user_id = $request->user_id;
        $order->subtotal = $request->subtotal;
        $order->total = $request->total;
        $order->save();

        $order->products()->sync($request->products ?? []);

        return redirect()->route('orders.index');
    }

    // Remove the specified order from storage
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('orders.index');
    }
}
