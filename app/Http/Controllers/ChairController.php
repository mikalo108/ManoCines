<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chair;
use Inertia\Inertia;

class ChairController extends Controller
{
    private const PAGINATE_SIZE = 10;

    // Función para devolver a la página de detalles del elemento que se pide
    public function show($id){
        $chair = Chair::findOrFail($id);
        return Inertia::render('Chair/Show', ['chair' => $chair]);
    }

    // Función para devolver a la página de creación del elemento
    public function create() {
        return Inertia::render('Chair/Form');  
    }

    // Función para guardar el elemento en la base de datos
    public function store(Request $r) { 
        $r->validate([
            'room_id' => 'required|integer|exists:rooms,id',  
            'row' => 'required|string|max:10',  
            'column' => 'required|string|max:10',
            'state' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        $ch = new Chair();
        $ch->room_id = $r->room_id;
        $ch->row = $r->row;
        $ch->column = $r->column;
        $ch->state = $r->state;
        $ch->price = $r->price;
        $ch->save();
        return redirect()->route('chair.index');
    }

    // Función para devolver a la página de edición del elemento
    public function edit($id) { 
        $ch = Chair::find($id);
        return Inertia::render('Chair/Form', ['chair' => $ch]);
    }

    // Función para actualizar el elemento en la base de datos
    public function update($id, Request $r) { 
        $r->validate([
            'room_id' => 'required|integer|exists:rooms,id',  
            'row' => 'required|string|max:10',  
            'column' => 'required|string|max:10',
            'state' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);
        
        $ch = Chair::find($id);
        $ch->room_id = $r->room_id;
        $ch->row = $r->row;
        $ch->column = $r->column;
        $ch->state = $r->state;
        $ch->price = $r->price;
        $ch->save();
        return redirect()->route('chair.index');
    }

    // Funcion para eliminar el elemento de la base de datos
    public function destroy($id) { 
        $ch = Chair::find($id);
        $ch->delete();
        return redirect()->route('chair.index');
    }
}
