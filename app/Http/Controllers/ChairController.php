<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chair;
use Inertia\Inertia;
use Illuminate\Support\Facades\Lang;

class ChairController extends Controller
{
    private const PAGINATE_SIZE = 10;

    public function index(Request $request)
    {
        app()->setLocale(session('locale', app()->getLocale()));  
        $query = Chair::query();
        
        if ($request->filled('chairId')) {
            $query->where('name',  $request->chairId);
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
            'fieldsCanFilter' => ['chairId', 'roomId', 'cinemaId'],
        ]);
    }

    public function show($id){
        $chair = Chair::findOrFail($id);
        return Inertia::render('Chair/Show', ['chair' => $chair]);
    }

    public function create() {
        return Inertia::render('Chair/Form');  
    }

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
        return redirect()->route('chairs.index');
    }

    public function edit($id) { 
        $ch = Chair::find($id);
        return Inertia::render('Chair/Form', ['chair' => $ch]);
    }

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
        return redirect()->route('chairs.index');
    }

    public function destroy($id) { 
        $ch = Chair::find($id);
        $ch->delete();
        return redirect()->route('chairs.index');
    }
}
