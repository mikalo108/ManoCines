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
    private const PAGINATE_SIZE = 5;

    public function index(Request $request)
    {
        app()->setLocale(session('locale', app()->getLocale()));  
        $query = Time::query();

        if ($request->filled('timeId')) {
            $query->where('id', $request->timeId);
        }

        if ($request->filled('roomId')) {
            $query->where('room_id', $request->roomId);
        }

        if ($request->filled('filmId')) {
            $query->where('film_id', $request->filmId);
        }

        if ($request->filled('time')) {
            $query->whereDate('time', $request->time);
        }

        $times = $query->orderBy('id', 'desc')->paginate(self::PAGINATE_SIZE);
        return Inertia::render('Time/Index', [
            'times' => $times,
            'langTable' => fn () => Lang::get('tableTimes'),
            'fieldsCanFilter' => ['timeId', 'roomId', 'filmId', 'time'],
        ]);
    }

    public function show($id)
    {
        $time = Time::findOrFail($id);
        return Inertia::render('Time/Show', ['time' => $time]);
    }

    public function create()
    {
        $rooms = Room::all();
        $films = Film::all();
        return Inertia::render('Time/Form', ['rooms' => $rooms, 'films' => $films]);
    }

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

    public function edit($id)
    {
        $time = Time::findOrFail($id);
        $rooms = Room::all();
        $films = Film::all();
        return Inertia::render('Time/Form', ['time' => $time, 'rooms' => $rooms, 'films' => $films]);
    }

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

    public function destroy($id)
    {
        $time = Time::findOrFail($id);
        $time->delete();

        return redirect()->route('times.index');
    }
}
