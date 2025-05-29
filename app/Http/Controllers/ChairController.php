<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chair;
use Inertia\Inertia;
use Illuminate\Support\Facades\Lang;
use App\Models\Room;

class ChairController extends Controller
{
    private const PAGINATE_SIZE = 10;

    public function index(Request $request)
    {
        app()->setLocale(session('locale', app()->getLocale()));  
        $query = Chair::query();
        
        if ($request->filled('chairId')) {
            $query->where('id',  $request->chairId);
        }

        if ($request->filled('roomId')) {
            $query->where('room_id', $request->roomId);
        }

        if ($request->filled('cinemaId')) {
            $query->where('cinema_id', $request->cinemaId);
        }

        $chairList = $query->orderBy('id', 'desc')->paginate(self::PAGINATE_SIZE);

        return Inertia::render('Chair/Index', [
            'chairs' => $chairList,
            'filters' => $request->all('search', 'trashed'),
            'langTable' => fn () => Lang::get('tableChairs'),
            'fieldsCanFilter' => [['key'=>'chairId', 'field'=>$request->chairId], ['key'=>'roomId', 'field'=>$request->roomId], ['key'=>'cinemaId', 'field'=>$request->roomId]],
        ]);
    }

    public function indexForATime($cinema_id, $film_id, $room_id, $time_id){
        app()->setLocale(session('locale', app()->getLocale()));

        $chairs = Chair::where('room_id', $room_id)->orderBy('id', 'desc')->get();

        return Inertia::render('Chair/IndexForATime', [
            'chairs' => $chairs,
            'cinema_id' => $cinema_id,
            'film_id' => $film_id,
            'room_id' => $room_id,
            'time_id' => $time_id,
            'langTable' => fn () => Lang::get('tableChairs'),
        ]);
    }

    public function create() {
        app()->setLocale(session('locale', app()->getLocale()));
        $rooms_lastID = Room::orderBy('id', 'desc')->first()?->id;
        return Inertia::render('Chair/Form', [
            'dataControl' => [
                ['key' => 'room_id', 'field' => '', 'type' => 'number', 'posibilities' => $rooms_lastID],
                ['key' => 'row', 'field' => '', 'type' => 'number', 'posibilities' => '15'],
                ['key' => 'column', 'field' => '', 'type' => 'select', 'posibilities' => [
                    'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'
                ]],
                ['key' => 'state', 'field' => '', 'type' => 'select', 'posibilities' => ['Available', 'Occupied']],
                ['key' => 'price', 'field' => '', 'type' => 'number', 'posibilities' => ''],
            ],
        ]);
    }

    public function store(Request $r) { 
        $r->validate([
            'room_id' => 'required|integer|exists:rooms,id',  
            'row' => 'required|numeric|max:10',  
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
        return redirect()->route('chairs.index');
    }

    public function edit($id) { 
        app()->setLocale(session('locale', app()->getLocale()));  
        $ch = Chair::find($id);
        return Inertia::render('Chair/Form', [
            'chair' => $ch,
            'dataControl' => [
                ['key' => 'room_id', 'field' => $ch->room_id, 'type' => 'hidden', 'posibilities' => ''],
                ['key' => 'row', 'field' => $ch->row, 'type' => 'hidden', 'posibilities' => ''],
                ['key' => 'column', 'field' => $ch->column, 'type' => 'hidden', 'posibilities' =>''],
                ['key' => 'state', 'field' => $ch->state, 'type' => 'select', 'posibilities' => ['Available', 'Occupied']],
                ['key' => 'price', 'field' => $ch->price, 'type' => 'number', 'posibilities' => ''],
            ],
        ]);
    }

    public function update($id, Request $r) { 
        $r->validate([
            'state' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);
        
        $ch = Chair::find($id);
        $ch->state = $r->state;
        $ch->price = $r->price;
        $ch->save();
        return redirect()->route('chairs.index');
    }

    public function destroy($id) { 
        $ch = Chair::find($id);
        $ch->delete();
        return redirect()->route('chairs.index');
    }
}
