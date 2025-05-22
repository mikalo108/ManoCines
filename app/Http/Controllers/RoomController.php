<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller
{
    private const PAGINATE_SIZE = 10;

    // Función para devolver a la página de detalles del elemento que se pide
    public function show($id){
        $room = Room::findOrFail($id);
        return view('room.show', compact('room'));
    }

    // Función para devolver a la página de creación del elemento
    public function create() {
        return view('room.form');  
    }

    // Función para guardar el elemento en la base de datos
    public function store(Request $r) { 
        $r->validate([
            'cinema_id' => 'required|integer|exists:cinemas,id',
            'name' => 'required|string|max:255',  
            'capacity' => 'required|integer|min:1',  
        ]);

        $rModel = new Room();
        $rModel->cinema_id = $r->cinema_id;
        $rModel->name = $r->name;
        $rModel->capacity = $r->capacity;
        $rModel->save();
        return redirect()->route('room.index');
    }

    // Función para devolver a la página de edición del elemento
    public function edit($id) { 
        $rModel = Room::find($id);
        return view('room.form', ['room' => $rModel]);
    }

    // Función para actualizar el elemento en la base de datos
    public function update($id, Request $r) { 
        $r->validate([
            'cinema_id' => 'required|integer|exists:cinemas,id',
            'name' => 'required|string|max:255',  
            'capacity' => 'required|integer|min:1',  
        ]);
        
        $rModel = Room::find($id);
        $rModel->cinema_id = $r->cinema_id;
        $rModel->name = $r->name;
        $rModel->capacity = $r->capacity;
        $rModel->save();
        return redirect()->route('room.index');
    }

    // Funcion para eliminar el elemento de la base de datos
    public function destroy($id) { 
        $rModel = Room::find($id);
        $rModel->delete();
        return redirect()->route('room.index');
    }
}
