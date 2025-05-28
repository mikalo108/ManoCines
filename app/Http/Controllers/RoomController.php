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

        return Inertia::render('Room/Form', [
         'dataControl' => [
                ['key' => 'number', 'field' => '', 'type' => 'number', 'posibilities' => ''],
            ],
        ]); 
    }

    public function store(Request $r) { 
        $r->validate([
            'number' => 'required|string|max:255',
        ]);

        $room = new Room();
        $room->name = $r->name;
        $room->save();

        return redirect()->route('rooms.index');
    }

    public function edit($id) { 
        app()->setLocale(session('locale', app()->getLocale()));  
        $room = Room::findOrFail($id);

        return Inertia::render('Room/Form', [
            'room' => $room,
            'dataControl' => [
                ['key' => 'number', 'field' => $room->number, 'type' => 'text', 'posibilities' => ''],
                ['key' => 'capacity', 'field' => $room->capacity, 'type' => 'hidden', 'posibilities' => ''],
            ],
        ]); 
    }

    public function update($id, Request $r) { 
        $r->validate([
            'cinema_id' => 'required|integer|exists:cinemas,id',
            'name' => 'required|string|max:255',  
        ]);
        
        $room = Room::find($id);
        $room->name = $r->name;
        $room->save();

        return redirect()->route('rooms.index');
    }

    public function destroy($id) { 
        $room = Room::find($id);
        $room->delete();
        return redirect()->route('rooms.index');
    }
}
