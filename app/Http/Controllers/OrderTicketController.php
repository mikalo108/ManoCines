<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderTicket;

class OrderTicketController extends Controller
{
    private const PAGINATE_SIZE = 10;

    // Función para devolver a la página de detalles del elemento que se pide
    public function show($id){
        $orderTicket = OrderTicket::findOrFail($id);
        return view('orderTicket.show', compact('orderTicket'));
    }

    // Función para devolver a la página de creación del elemento
    public function create() {
        return view('orderTicket.form');  
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
        return redirect()->route('orderTicket.index');
    }

    // Función para devolver a la página de edición del elemento
    public function edit($id) { 
        $ot = OrderTicket::find($id);
        return view('orderTicket.form', ['orderTicket' => $ot]);
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
        return redirect()->route('orderTicket.index');
    }

    // Funcion para eliminar el elemento de la base de datos
    public function destroy($id) { 
        $ot = OrderTicket::find($id);
        $ot->delete();
        return redirect()->route('orderTicket.index');
    }
}
