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
        app()->setLocale(session('locale', app()->getLocale()));  
        $cinemas_lastID = \App\Models\Cinema::orderBy('id', 'desc')->first()?->id;

        return Inertia::render('Room/Form', [
         'dataControl' => [
                ['key' => 'cinema_id', 'field' => '', 'type' => 'number', 'posibilities' => $cinemas_lastID],
                ['key' => 'name', 'field' => '', 'type' => 'text', 'posibilities' => ''],
            ],
        ]); 
    }

    public function store(Request $r) { 
        $r->validate([
            'cinema_id' => 'required|integer|exists:cinemas,id',
            'name' => 'required|string|max:255',  
            'capacity' => 'required|integer|min:1',  
            'chairs' => 'array',
            'chairs.*' => 'integer|exists:chairs,id',
        ]);

        $room = new Room();
        $room->cinema_id = $r->cinema_id;
        $room->name = $r->name;
        $room->capacity = $r->capacity;
        $room->save();

        if ($r->has('chairs')) {
            $room->chairs()->attach($r->chairs);
        }

        return redirect()->route('rooms.index');
    }

    public function edit($id) { 
        app()->setLocale(session('locale', app()->getLocale()));  
        $room = Room::findOrFail($id);
        $cinemas_lastID = \App\Models\Cinema::orderBy('id', 'desc')->first()?->id;

        return Inertia::render('Room/Form', [
            'room' => $room,
            'dataControl' => [
                ['key' => 'cinema_id', 'field' => $room->cinema_id, 'type' => 'number', 'posibilities' => $cinemas_lastID],
                ['key' => 'name', 'field' => $room->name, 'type' => 'text', 'posibilities' => ''],
                ['key' => 'quantity', 'field' => $room->quantity, 'type' => 'hidden', 'posibilities' => ''],
            ],
        ]); 
    }

    public function update($id, Request $r) { 
        $r->validate([
            'cinema_id' => 'required|integer|exists:cinemas,id',
            'name' => 'required|string|max:255',  
        ]);
        
        $room = Room::find($id);
        $room->cinema_id = $r->cinema_id;
        $room->name = $r->name;
        $room->capacity = $r->capacity;
        $room->save();

        if ($r->has('chairs')) {
            $room->chairs()->sync($r->chairs);
        }

        return redirect()->route('rooms.index');
    }

    public function destroy($id) { 
        $room = Room::find($id);
        $room->delete();
        return redirect()->route('rooms.index');
    }
}
