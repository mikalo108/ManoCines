<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chair;

class ChairController extends Controller
{
    private const PAGINATE_SIZE = 10;

    // Función para devolver a la página de detalles del elemento que se pide
    public function show($id){
        $chair = Chair::findOrFail($id);
        return view('chair.show', compact('chair'));
    }

    // Función para devolver a la página de creación del elemento
    public function create() {
        return view('chair.form');  
    }

    // Función para guardar el elemento en la base de datos
    public function store(Request $r) { 
        $r->validate([
            'room_id' => 'required|integer|exists:rooms,id',  
            'number' => 'required|integer|min:1',  
            'row' => 'required|string|max:10',  
        ]);

        $ch = new Chair();
        $ch->room_id = $r->room_id;
        $ch->number = $r->number;
        $ch->row = $r->row;
        $ch->save();
        return redirect()->route('chair.index');
    }

    // Función para devolver a la página de edición del elemento
    public function edit($id) { 
        $ch = Chair::find($id);
        return view('chair.form', ['chair' => $ch]);
    }

    // Función para actualizar el elemento en la base de datos
    public function update($id, Request $r) { 
        $r->validate([
            'room_id' => 'required|integer|exists:rooms,id',  
            'number' => 'required|integer|min:1',  
            'row' => 'required|string|max:10',  
        ]);
        
        $ch = Chair::find($id);
        $ch->room_id = $r->room_id;
        $ch->number = $r->number;
        $ch->row = $r->row;
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
