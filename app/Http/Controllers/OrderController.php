<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    private const PAGINATE_SIZE = 10;

    // Display a listing of orders
    public function index()
    {
        $orders = Order::paginate(self::PAGINATE_SIZE);
        return view('order.index', compact('orders'));
    }

    // Show the form for creating a new order
    public function create()
    {
        return view('order.form');
    }

    // Store a newly created order in storage
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'subtotal' => 'required|numeric',
            'total' => 'required|numeric',
        ]);

        $order = new Order();
        $order->user_id = $request->user_id;
        $order->subtotal = $request->subtotal;
        $order->total = $request->total;
        $order->save();

        return redirect()->route('order.index');
    }

    // Display the specified order
    public function show($id)
    {
        $order = Order::findOrFail($id);
        return view('order.show', compact('order'));
    }

    // Show the form for editing the specified order
    public function edit($id)
    {
        $order = Order::findOrFail($id);
        return view('order.form', compact('order'));
    }

    // Update the specified order in storage
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'subtotal' => 'required|numeric',
            'total' => 'required|numeric',
        ]);

        $order->user_id = $request->user_id;
        $order->subtotal = $request->subtotal;
        $order->total = $request->total;
        $order->save();

        return redirect()->route('order.index');
    }

    // Remove the specified order from storage
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('order.index');
    }
}
