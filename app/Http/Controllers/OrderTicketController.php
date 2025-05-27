<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderTicket;
use Inertia\Inertia;
use Illuminate\Support\Facades\Lang;

class OrderTicketController extends Controller
{
    private const PAGINATE_SIZE = 10;

    // Función para devolver a la página principal del elemento
    public function index()
    {
        app()->setLocale(session('locale', app()->getLocale()));  
        $orderTickets = OrderTicket::orderBy('id', 'desc')->paginate(self::PAGINATE_SIZE);
        return Inertia::render('OrderTicket/Index', ['orderTickets' => $orderTickets, 'langTable' => fn () => Lang::get('tableOrderTickets')]);
    }

    // Función para devolver a la página de detalles del elemento que se pide
    public function show($id){
        $orderTicket = OrderTicket::findOrFail($id);
        return Inertia::render('OrderTicket/Show', ['orderTicket' => $orderTicket]);
    }

    // Función para devolver a la página de creación del elemento
    public function create() {
        return Inertia::render('OrderTicket/Form');  
    }

    // Función para guardar el elemento en la base de datos
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

    // Función para devolver a la página de edición del elemento
    public function edit($id) { 
        $ot = OrderTicket::find($id);
        return Inertia::render('OrderTicket/Form', ['orderTicket' => $ot]);
    }

    // Función para actualizar el elemento en la base de datos
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

    // Funcion para eliminar el elemento de la base de datos
    public function destroy($id) { 
        $ot = OrderTicket::find($id);
        $ot->delete();
        return redirect()->route('order-tickets.index');
    }
}
