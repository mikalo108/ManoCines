<?php

namespace App\Http\Controllers;

use App\Models\Cinema;
use App\Models\Film;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Room;
use App\Models\Time;
use App\Models\User;
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

    public function createClient(Request $request)
    {
        $cinema = Cinema::find($request->input('cinema_id'));
        $time = Time::find($request->input('time_id'));
        $room = Room::find($request->input('room_id'));
        $film = Film::find($request->input('film_id'));
        $selectedProducts = $request->input('selectedProducts');
        $chairsSelected = $request->session()->get('chairsSelected', []);

        return Inertia::render('Order/Details', [
            'selectedProducts' => $selectedProducts,
            'cinema' => $cinema,
            'time' => $time,
            'room' => $room,
            'film' => $film,
            'chairsSelected' => $chairsSelected,
            'langTable' => fn () => Lang::get('tableOrders'),
        ]);
    }

    public function createByClient(Request $request)
    {

        $user = $request->user();

        // Create new order
        $order = new Order();
        $order->user_id = $user ? $user->id : null; // or assign a default user if needed
        $order->total = 0;
        $order->subtotal = 0;
        $order->save();

        $total = 0;
        $subtotal = 0;

        // Create order products
        foreach ($request->input('selectedProducts') as $item) {
            $product = $item[0];
            $quantity = $item[1];

            $orderProduct = new \App\Models\OrderProduct();
            $orderProduct->order_id = $order->id;
            $orderProduct->product_id = $product['id'];
            $orderProduct->quantity = $quantity;
            $orderProduct->save();

            $subtotal += $product['price'] * $quantity;
        }

        // Get chairs selected from session
        $chairsSelected = $request->session()->get('chairsSelected', []);

        // Create order tickets
        foreach ($chairsSelected as $chair) {
            $orderTicket = new \App\Models\OrderTicket();
            $orderTicket->order_id = $order->id;
            $orderTicket->chair_id = $chair['id'];
            $orderTicket->time_id = $request->input('time_id');
            $orderTicket->save();

            // Update chair state to "Occupied"
            $chairModel = \App\Models\Chair::find($chair['id']);
            if ($chairModel) {
                $chairModel->state = 'Occupied';
                $chairModel->save();
            }

            $subtotal += $chair['price'];
        }

        $order->subtotal = $subtotal;
        $order->total = $subtotal*1.21;
        $order->save();

        // Clear chairsSelected session variable after order creation
        $request->session()->forget('chairsSelected');

        return Inertia::render('Order/Checkout', [
            'order' => $order,
            'selectedProducts' => $request->selectedProducts,
            'chairsSelected' => $chairsSelected,
            'langTable' => fn () => Lang::get('tableOrders'),
        ]);
    }

    public function create()
    {
        app()->setLocale(session('locale', app()->getLocale()));          
        $users_lastID = User::orderBy('id', 'desc')->first()?->id;

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
        $users_lastID = User::orderBy('id', 'desc')->first()?->id;

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
