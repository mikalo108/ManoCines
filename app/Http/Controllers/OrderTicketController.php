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
        return Inertia::render('OrderTicket/Form');  
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
        $ot = OrderTicket::find($id);
        return Inertia::render('OrderTicket/Form', ['orderTicket' => $ot]);
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
