<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderTicket;
use Inertia\Inertia;
use Illuminate\Support\Facades\Lang;

class OrderTicketController extends Controller
{
    private const PAGINATE_SIZE = 5;

    public function index(Request $request)
    {
        app()->setLocale(session('locale', app()->getLocale()));  
        $query = OrderTicket::query();

        if ($request->filled('orderTicketId')) {
            $query->where('id', $request->orderTicketId);
        }

        if ($request->filled('orderId')) {
            $query->where('order_id', $request->orderId);
        }

        if ($request->filled('chairId')) {
            $query->where('chair_id', $request->chairId);
        }

        if ($request->filled('timeId')) {
            $query->where('time_id', $request->timeId);
        }

        $orderTickets = $query->orderBy('id', 'desc')->paginate(self::PAGINATE_SIZE);
        return Inertia::render('OrderTicket/Index', [
            'orderTickets' => $orderTickets,
            'langTable' => fn () => Lang::get('tableOrderTickets'),
            'fieldsCanFilter' => [
                ['key' => 'orderTicketId', 'field' => $request->orderTicketId],
                ['key' => 'orderId', 'field' => $request->orderId],
                ['key' => 'chairId', 'field' => $request->chairId],
                ['key' => 'timeId', 'field' => $request->timeId],
            ],
        ]);
    }

    public function show($id){
        $orderTicket = OrderTicket::findOrFail($id);
        return Inertia::render('OrderTicket/Show', ['orderTicket' => $orderTicket]);
    }

    public function create() {
        app()->setLocale(session('locale', app()->getLocale()));          
        $orders_lastID = \App\Models\Order::orderBy('id', 'desc')->first()?->id;
        $times_lastID = \App\Models\Time::orderBy('id', 'desc')->first()?->id;
        $chairs_lastID = \App\Models\Chair::orderBy('id', 'desc')->first()?->id;

        return Inertia::render('OrderTicket/Form', [
         'dataControl' => [
                ['key' => 'order_id', 'field' => '', 'type' => 'number', 'posibilities' => $orders_lastID],
                ['key' => 'time_id', 'field' => '', 'type' => 'number', 'posibilities' => $times_lastID],
                ['key' => 'chair_id', 'field' => '', 'type' => 'number', 'posibilities' => $chairs_lastID],
                ['key' => 'note', 'field' => '', 'type' => 'text', 'posibilities' => ''],
            ],
        ]); 
    }

    public function store(Request $r) { 
        $r->validate([
            'order_id' => 'required|integer|exists:orders,id',  
            'chair_id' => 'required|integer|exists:chairs,id',
            'time_id' => 'required|integer|exists:times,id',
        ]);

        $ot = new OrderTicket();
        $ot->order_id = $r->order_id;
        $ot->chair_id = $r->chair_id;
        $ot->time_id = $r->time_id;
        $ot->save();
        return redirect()->route('order-tickets.index');
    }

    public function edit($id) { 
        app()->setLocale(session('locale', app()->getLocale()));          
        $ot = OrderTicket::find($id);
        $orders_lastID = \App\Models\Order::orderBy('id', 'desc')->first()?->id;
        $times_lastID = \App\Models\Time::orderBy('id', 'desc')->first()?->id;
        $chairs_lastID = \App\Models\Chair::orderBy('id', 'desc')->first()?->id;

        return Inertia::render('OrderTicket/Form', [
         'orderTicket' => $ot,
         'dataControl' => [
                ['key' => 'order_id', 'field' => $ot->order_id, 'type' => 'number', 'posibilities' => $orders_lastID],
                ['key' => 'time_id', 'field' => $ot->time_id, 'type' => 'number', 'posibilities' => $times_lastID],
                ['key' => 'chair_id', 'field' => $ot->chair_id, 'type' => 'number', 'posibilities' => $chairs_lastID],
                ['key' => 'note', 'field' => $ot->note, 'type' => 'text', 'posibilities' => ''],
            ],
        ]);
    }

    public function update($id, Request $r) { 
        $r->validate([
            'order_id' => 'required|integer|exists:orders,id',  
            'chair_id' => 'required|integer|exists:chairs,id',
            'time_id' => 'required|integer|exists:times,id',
        ]);
        
        $ot = OrderTicket::find($id);
        $ot->order_id = $r->order_id;
        $ot->chair_id = $r->chair_id;
        $ot->time_id = $r->time_id;
        $ot->save();
        return redirect()->route('order-tickets.index');
    }

    public function destroy($id) { 
        $ot = OrderTicket::find($id);
        $ot->delete();
        return redirect()->route('order-tickets.index');
    }
}
