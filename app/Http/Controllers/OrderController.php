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
        app()->setLocale(session('locale', app()->getLocale()));          
        $users_lastID = \App\Models\User::orderBy('id', 'desc')->first()?->id;

        return Inertia::render('Order/Form', [
         'dataControl' => [
                ['key' => 'user_id', 'field' => '', 'type' => 'number', 'posibilities' => $users_lastID],
            ],
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
        ]);

        $order = new Order();
        $order->user_id = $request->user_id;
        $order->total=0;
        $order->subtotal=0;
        $order->save();

        return redirect()->route('orders.index');
    }

    public function edit($id)
    {
        $order = Order::findOrFail($id);
        app()->setLocale(session('locale', app()->getLocale()));          
        $users_lastID = \App\Models\User::orderBy('id', 'desc')->first()?->id;

        return Inertia::render('Order/Form', [
         'order' => $order,
         'dataControl' => [
                ['key' => 'user_id', 'field' => $order->user_id, 'type' => 'number', 'posibilities' => $users_lastID],
                ['key' => 'total', 'field' => isset($order->total) && $order->total >= 1 ? $order->total : 0, 'type' => 'hidden', 'posibilities' => ''],
                ['key' => 'subtotal', 'field' => isset($order->subtotal) && $order->subtotal >= 1 ? $order->subtotal : 0, 'type' => 'hidden', 'posibilities' => ''],
            ],
        ]);
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
        ]);

        $order = Order::findOrFail($id);
        $order->user_id = $request->user_id;
        $order->save();

        return redirect()->route('orders.index');
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('orders.index');
    }
}
