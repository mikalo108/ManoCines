<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use Inertia\Inertia;
use Illuminate\Support\Facades\Lang;

class RoomController extends Controller
{
    private const PAGINATE_SIZE = 5;

    public function index(Request $request) {
        app()->setLocale(session('locale', app()->getLocale()));  
        $query = Room::query();

        if ($request->filled('roomId')) {
            $query->where('id', $request->roomId);
        }

        if ($request->filled('cinemaId')) {
            $query->where('cinema_id', $request->cinemaId);
        }

        $rooms = $query->orderBy('created_at', 'desc')->paginate(self::PAGINATE_SIZE);
        return Inertia::render('Room/Index', [
            'rooms' => $rooms,
            'langTable' => fn () => Lang::get('tableRooms'),
            'fieldsCanFilter' => [
                ['key' => 'roomId', 'field' => $request->roomId],
                ['key' => 'cinemaId', 'field' => $request->cinemaId],
            ],
        ]);
    }

    public function show($id){
        $room = Room::findOrFail($id);
        return Inertia::render('Room/Show', ['room' => $room]);
    }

    public function create() {
        $cinemas = \App\Models\Cinema::all();
        $chairs = \App\Models\Chair::all();
        return Inertia::render('Room/Form', ['cinemas' => $cinemas, 'chairs' => $chairs]);  
    }

    public function store(Request $r) { 
        $r->validate([
            'cinema_id' => 'required|integer|exists:cinemas,id',
            'name' => 'required|string|max:255',  
            'capacity' => 'required|integer|min:1',  
            'chairs' => 'array',
            'chairs.*' => 'integer|exists:chairs,id',
        ]);

        $rModel = new Room();
        $rModel->cinema_id = $r->cinema_id;
        $rModel->name = $r->name;
        $rModel->capacity = $r->capacity;
        $rModel->save();

        if ($r->has('chairs')) {
            $rModel->chairs()->attach($r->chairs);
        }

        return redirect()->route('rooms.index');
    }

    public function edit($id) { 
        $rModel = Room::with('chairs')->find($id);
        $cinemas = \App\Models\Cinema::all();
        $chairs = \App\Models\Chair::all();
        return Inertia::render('Room/Form', ['room' => $rModel, 'cinemas' => $cinemas, 'chairs' => $chairs]);
    }

    public function update($id, Request $r) { 
        $r->validate([
            'cinema_id' => 'required|integer|exists:cinemas,id',
            'name' => 'required|string|max:255',  
            'capacity' => 'required|integer|min:1',  
            'chairs' => 'array',
            'chairs.*' => 'integer|exists:chairs,id',
        ]);
        
        $rModel = Room::find($id);
        $rModel->cinema_id = $r->cinema_id;
        $rModel->name = $r->name;
        $rModel->capacity = $r->capacity;
        $rModel->save();

        if ($r->has('chairs')) {
            $rModel->chairs()->sync($r->chairs);
        }

        return redirect()->route('rooms.index');
    }

    public function destroy($id) { 
        $rModel = Room::find($id);
        $rModel->delete();
        return redirect()->route('rooms.index');
    }
}
