<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Inertia\Inertia;
use Illuminate\Support\Facades\Lang;

class OrderController extends Controller
{
    private const PAGINATE_SIZE = 5;

    public function index(Request $request)
    {
        app()->setLocale(session('locale', app()->getLocale()));  
        $query = Order::query();

        if ($request->filled('orderId')) {
            $query->where('id', $request->orderId);
        }

        if ($request->filled('userId')) {
            $query->where('user_id', $request->userId);
        }

        $orders = $query->orderBy('id', 'desc')->paginate(self::PAGINATE_SIZE);
        return Inertia::render('Order/Index', [
            'orders' => $orders,
            'langTable' => fn () => Lang::get('tableOrders'),
            'fieldsCanFilter' => [
                ['key' => 'orderId', 'field' => $request->orderId],
                ['key' => 'userId', 'field' => $request->userId],
            ],
        ]);
    }

    public function create()
    {
        return Inertia::render('Order/Form');
    }

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

    public function show($id)
    {
        $order = Order::findOrFail($id);
        return Inertia::render('Order/Show', ['order' => $order]);
    }

    public function edit($id)
    {
        $order = Order::findOrFail($id);
        return Inertia::render('Order/Form', ['order' => $order]);
    }

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

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('orders.index');
    }
}
