<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Time;
use App\Models\Room;
use App\Models\Film;
use Inertia\Inertia;
use Illuminate\Support\Facades\Lang;

class TimeController extends Controller
{
    private const PAGINATE_SIZE = 10;

    // Función para devolver a la página principal del elemento
    public function index()
    {
        app()->setLocale(session('locale', app()->getLocale()));  
        $times = Time::paginate(self::PAGINATE_SIZE);
        return Inertia::render('Time/Index', ['times' => $times,'langTable' => fn () => Lang::get('tableTimes'),]);
    }

    // Función para devolver a la página de detalles del elemento que se pide
    public function show($id){
        $time = Time::findOrFail($id);
        return Inertia::render('Room/Show', ['time' => $time]);
    }

    // Show the form for creating a new time
    public function create()
    {
        $rooms = Room::all();
        $films = Film::all();
        return Inertia::render('Time/Form', ['rooms' => $rooms, 'films' => $films]);
    }

    // Store a newly created time in storage
    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|integer|exists:rooms,id',
            'film_id' => 'required|integer|exists:films,id',
            'time' => 'required|date',
        ]);

        $time = new Time();
        $time->room_id = $request->room_id;
        $time->film_id = $request->film_id;
        $time->time = $request->time;
        $time->save();

        return redirect()->route('times.index');
    }

    // Show the form for editing the specified time
    public function edit($id)
    {
        $time = Time::findOrFail($id);
        $rooms = Room::all();
        $films = Film::all();
        return Inertia::render('Time/Form', ['time' => $time, 'rooms' => $rooms, 'films' => $films]);
    }

    // Update the specified time in storage
    public function update(Request $request, $id)
    {
        $time = Time::findOrFail($id);

        $request->validate([
            'room_id' => 'required|integer|exists:rooms,id',
            'film_id' => 'required|integer|exists:films,id',
            'time' => 'required|date',
        ]);

        $time->room_id = $request->room_id;
        $time->film_id = $request->film_id;
        $time->time = $request->time;
        $time->save();

        return redirect()->route('times.index');
    }

    // Remove the specified time from storage
    public function destroy($id)
    {
        $time = Time::findOrFail($id);
        $time->delete();

        return redirect()->route('times.index');
    }
}
