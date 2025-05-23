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
        $cinemas = \App\Models\Cinema::all();
        $chairs = \App\Models\Chair::all();
        return view('room.form', compact('cinemas', 'chairs'));  
    }

    // Función para guardar el elemento en la base de datos
    public function store(Request $r) { 
        $r->validate([
            'cinema_id' => 'required|integer|exists:cinemas,id',
            'name' => 'required|string|max:255',  
            'capacity' => 'required|integer|min:1',  
            'chairs' => 'array',
            'chairs.*' => 'integer|exists:chairs,id',
        ]);

        $rModel = new Room();
        $rModel->name = $r->name;
        $rModel->capacity = $r->capacity;
        $rModel->save();

        if ($r->has('chairs')) {
            $rModel->chairs()->attach($r->chairs);
        }

        return redirect()->route('room.index');
    }

    // Función para devolver a la página de edición del elemento
    public function edit($id) { 
        $rModel = Room::with('chairs')->find($id);
        $cinemas = \App\Models\Cinema::all();
        $chairs = \App\Models\Chair::all();
        return view('room.form', ['room' => $rModel, 'cinemas' => $cinemas, 'chairs' => $chairs]);
    }

    // Función para actualizar el elemento en la base de datos
    public function update($id, Request $r) { 
        $r->validate([
            'cinema_id' => 'required|integer|exists:cinemas,id',
            'name' => 'required|string|max:255',  
            'capacity' => 'required|integer|min:1',  
            'chairs' => 'array',
            'chairs.*' => 'integer|exists:chairs,id',
        ]);
        
        $rModel = Room::find($id);
        $rModel->name = $r->name;
        $rModel->capacity = $r->capacity;
        $rModel->save();

        if ($r->has('chairs')) {
            $rModel->chairs()->sync($r->chairs);
        }

        return redirect()->route('room.index');
    }

    // Funcion para eliminar el elemento de la base de datos
    public function destroy($id) { 
        $rModel = Room::find($id);
        $rModel->delete();
        return redirect()->route('room.index');
    }
}
