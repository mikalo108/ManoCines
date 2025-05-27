<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use Inertia\Inertia;
use Illuminate\Support\Facades\Lang;

class RoomController extends Controller
{
    private const PAGINATE_SIZE = 10;

    // Función para devolver a la página principal del elemento
    public function index() {
        
        app()->setLocale(session('locale', app()->getLocale()));  
        $rooms = Room::orderBy('created_at', 'desc')->paginate(self::PAGINATE_SIZE);
        return Inertia::render('Room/Index', ['rooms' => $rooms, 'langTable' => fn () => Lang::get('tableRooms'),]);
    }

    // Función para devolver a la página de detalles del elemento que se pide
    public function show($id){
        $room = Room::findOrFail($id);
        return Inertia::render('Room/Show', ['room' => $room]);
    }

    // Función para devolver a la página de creación del elemento
    public function create() {
        $cinemas = \App\Models\Cinema::all();
        $chairs = \App\Models\Chair::all();
        return Inertia::render('Room/Form', ['cinemas' => $cinemas, 'chairs' => $chairs]);  
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

        return redirect()->route('rooms.index');
    }

    // Función para devolver a la página de edición del elemento
    public function edit($id) { 
        $rModel = Room::with('chairs')->find($id);
        $cinemas = \App\Models\Cinema::all();
        $chairs = \App\Models\Chair::all();
        return Inertia::render('Room/Form', ['room' => $rModel, 'cinemas' => $cinemas, 'chairs' => $chairs]);
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

        return redirect()->route('rooms.index');
    }

    // Funcion para eliminar el elemento de la base de datos
    public function destroy($id) { 
        $rModel = Room::find($id);
        $rModel->delete();
        return redirect()->route('rooms.index');
    }
}
