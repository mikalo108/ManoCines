<?php

namespace App\Http\Controllers;

use App\Models\Cinema;
use App\Models\Film;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Room;
use App\Models\Time;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
        app()->setLocale(session('locale', app()->getLocale()));  
        $cinema_id = $request->session()->get('cinema_id');
        $film_id = $request->session()->get('film_id');
        $room_id = $request->session()->get('room_id');
        $time_id = $request->session()->get('time_id');
        $cinema = Cinema::find($cinema_id);
        $time = Time::find($time_id);
        $room = Room::find($room_id);
        $film = Film::find($film_id);
        
        // Get chairs and products selected from session
        $chairsSelected = $request->session()->get('chairsSelected', []);
        $selectedProducts = $request->input('selectedProducts');
        
        // Put products selected to session
        session()->put('selectedProducts',$selectedProducts);

        return Inertia::render('Order/Details', [
            'selectedProducts' => $selectedProducts,
            'cinema' => $cinema,
            'time' => $time,
            'room' => $room,
            'film' => $film,
            'film_id' => $film_id,
            'cinema_id' => $cinema_id,
            'room_id' => $room_id,
            'time_id' => $time_id,
            'chairsSelected' => $chairsSelected,
            'langTable' => fn () => Lang::get('tableOrders'),
            'langTableChair' => fn () => Lang::get('tableChairs'),
            'lang' => fn () => Lang::get('general'),
        ]);
    }

    public function createByClient(Request $request)
    {
        app()->setLocale(session('locale', app()->getLocale()));  
        $user = $request->user();

        // Create new order
        $order = new Order();
        $order->user_id = $user ? $user->id : null; // or assign a default user if needed
        $order->total = $request->input('total', 0);
        $order->subtotal = $request->input('subtotal', 0);
        $order->save();

        // Get chairs and products selected from session
        $chairsSelected = $request->session()->get('chairsSelected', []);
        $selectedProducts = $request->session()->get('selectedProducts', []);

        //

        // Create order products
        foreach ($selectedProducts as $item) {
            $product = $item[0];
            $quantity = $item[1];

            $orderProduct = new \App\Models\OrderProduct();
            $orderProduct->order_id = $order->id;
            $orderProduct->product_id = $product['id'];
            $orderProduct->quantity = $quantity;
            $orderProduct->save();
        }

        // Create order tickets
        foreach ($chairsSelected as $chair) {
            $orderTicket = new \App\Models\OrderTicket();
            $orderTicket->order_id = $order->id;
            $orderTicket->chair_id = $chair['id'];
            $orderTicket->time_id = session('time_id');
            $orderTicket->save();

            // Update chair state to "Occupied"
            $chairModel = \App\Models\Chair::find($chair['id']);
            if ($chairModel) {
                $chairModel->state = 'Occupied';
                $chairModel->save();
            }
        }

        $order->syncChanges();

        // Clear chairsSelected session variable after order creation
        session()->forget(['chairsSelected', 'selectedProducts', 'cinema_id', 'film_id', 'room_id', 'time_id']);

        return Inertia::render('Order/Checkout', [
            'order' => $order,
            'selectedProducts' => $selectedProducts,
            'chairsSelected' => $chairsSelected,
            'langTable' => fn () => Lang::get('tableOrders'),
            'langTableChair' => fn () => Lang::get('tableChairs'),
            'lang' => fn () => Lang::get('general'),
        ]);
    }

    public function myOrders()
    {
        app()->setLocale(session('locale', app()->getLocale()));  
        
        $user = Auth::user();

        $orders = Order::where('user_id', $user->id)
            ->orderBy('id', 'desc')
            ->paginate(self::PAGINATE_SIZE);

        return Inertia::render('Order/MyOrders', [
            'orders' => $orders,
            'user' => $user,
            'langTable' => fn () => Lang::get('tableOrders'),
            'langTableChair' => fn () => Lang::get('tableChairs'),
            'lang' => fn () => Lang::get('general'),
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
