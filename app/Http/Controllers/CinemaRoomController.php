<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CinemaRoom;
use Inertia\Inertia;
use Illuminate\Support\Facades\Lang;

class CinemaRoomController extends Controller
{
    private const PAGINATE_SIZE = 5;

    public function index(Request $request){
        app()->setLocale(session('locale', app()->getLocale()));  
        $query = CinemaRoom::query();

        if ($request->filled('cinemaRoomId')) {
            $query->where('id', $request->cinemaRoomId);
        }

        if ($request->filled('cinema_id')) {
            $query->where('id', $request->cinema_id);
        }

        if ($request->filled('room_id')) {
            $query->where('id', $request->room_id);
        }
        

        $cinemaRooms = $query->orderBy('id', 'desc')->paginate(self::PAGINATE_SIZE);

        return Inertia::render('CinemaRoom/Index', [
            'cinemaRooms' => $cinemaRooms,
            'filters' => $request->all('search', 'trashed'),
            'langTable' => fn () => Lang::get('tableCinemaRooms'),
            'fieldsCanFilter' => [
                ['key' => 'cinemaRoomId', 'field' => $request->cinemaRoomId],
                ['key' => 'cinema_id', 'field' => $request->cinema_id],
                ['key' => 'room_id', 'field' => $request->room_id],
            ],
        ]);
    }

    public function show($id){
        $cinemaRoom = CinemaRoom::findOrFail($id);
        return Inertia::render('CinemaRoom/show', ['cinemaRoom' => $cinemaRoom]);
    }

    public function create() {
        app()->setLocale(session('locale', app()->getLocale()));          
        $cinemas_lastID = \App\Models\Cinema::orderBy('id', 'desc')->first()?->id;
        $rooms_lastID = \App\Models\Room::orderBy('id', 'desc')->first()?->id;

        return Inertia::render('CinemaRoom/Form', [
         'dataControl' => [
                ['key' => 'cinema_id', 'field' => '', 'type' => 'number', 'posibilities' => $cinemas_lastID],
                ['key' => 'room_id', 'field' => '', 'type' => 'number', 'posibilities' => $rooms_lastID],
            ],
        ]);
    }

    public function store(Request $r) { 
        $r->validate([
            'cinema_id' => 'required|integer|exists:cinemas,id',
            'room_id' => 'required|integer|exists:rooms,id',
        ]);

        $validation = CinemaRoom::where('cinema_id', $r->cinema_id)->where('room_id', $r->room_id);
        if ($validation->exists()) {
            return redirect()->back()
                ->withErrors(['cinema_room' => 'Ya existe una relación con este Cinema ID y Room ID.'])
                ->withInput();
        }

        $c = new CinemaRoom();
        $c->cinema_id=$r->cinema_id;
        $c->room_id=$r->room_id;
        $c->save();

        return redirect()->route('cinema-rooms.index');
    }

    public function edit($id) { 
        $cr = CinemaRoom::findOrFail($id);
        app()->setLocale(session('locale', app()->getLocale()));          
        $cinemas_lastID = \App\Models\Cinema::orderBy('id', 'desc')->first()?->id;
        $rooms_lastID = \App\Models\Room::orderBy('id', 'desc')->first()?->id;

        return Inertia::render('CinemaRoom/Form', [
         'cinemaRoom' => $cr,
         'dataControl' => [
                ['key' => 'cinema_id', 'field' => $cr->cinema_id, 'type' => 'number', 'posibilities' => $cinemas_lastID],
                ['key' => 'room_id', 'field' => $cr->room_id, 'type' => 'number', 'posibilities' => $rooms_lastID],
            ],
        ]);
    }

    public function update($id, Request $r) { 
        $r->validate([
            'cinema_id' => 'required|integer|exists:cinemas,id',
            'room_id' => 'required|integer|exists:rooms,id',
        ]);

        $validation = CinemaRoom::where('cinema_id', $r->cinema_id)->where('room_id', $r->room_id);
        if ($validation->exists() && $validation->id != $id) {
            return redirect()->back()
                ->withErrors(['cinema_room' => 'Ya existe una relación con este Cinema ID y Room ID.'])
                ->withInput();
        }

        $c = CinemaRoom::find($id);
        $c->cinema_id=$r->cinema_id;
        $c->room_id=$r->room_id;
        $c->save();

        return redirect()->route('cinema-rooms.index');
    }

    public function destroy($id) { 
        $c = CinemaRoom::find($id);
        $c->delete();
        return redirect()->route('cinema-rooms.index');
    }
}
