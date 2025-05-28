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
            'fieldsCanFilter' => [
                ['key' => 'timeId', 'field' => $request->timeId],
                ['key' => 'roomId', 'field' => $request->roomId],
                ['key' => 'filmId', 'field' => $request->filmId],
                ['key' => 'time', 'field' => $request->time],
            ],
        ]);
    }

    public function show($id)
    {
        $time = Time::findOrFail($id);
        return Inertia::render('Time/Show', ['time' => $time]);
    }

    public function create()
    {
        app()->setLocale(session('locale', app()->getLocale()));        
        $rooms_lastID = Room::orderBy('id', 'desc')->first()?->id;
        $films_lastID = Film::orderBy('id', 'desc')->first()?->id;

        return Inertia::render('Time/Form', [
            'dataControl' => [
                ['key' => 'room_id', 'field' => '', 'type' => 'number', 'posibilities' => $rooms_lastID],
                ['key' => 'film_id', 'field' => '', 'type' => 'number', 'posibilities' => $films_lastID],
                ['key' => 'time', 'field' => ['fecha' => '', 'hora' => '', 'minuto' => ''], 'type' => 'date', 'posibilities' => ''],
            ],
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|integer|exists:rooms,id',
            'film_id' => 'required|integer|exists:films,id',
            'time_fecha' => 'required|date',
            'time_hora' => 'required|integer|min:0|max:23',
            'time_minuto' => 'required|integer|min:0|max:59',
        ]);

        $fecha = $request->input('time_fecha');
        $hora = str_pad($request->input('time_hora'), 2, '0', STR_PAD_LEFT);
        $minuto = str_pad($request->input('time_minuto'), 2, '0', STR_PAD_LEFT);
        $fechaCompleta = "{$fecha} {$hora}:{$minuto}:00";

        $time = new Time();
        $time->room_id = $request->room_id;
        $time->film_id = $request->film_id;
        $time->time = $fechaCompleta;
        $time->save();

        return redirect()->route('times.index');
    }

    public function edit($id)
    {
        app()->setLocale(session('locale', app()->getLocale()));        
        $time = Time::findOrFail($id);
        $rooms_lastID = Room::orderBy('id', 'desc')->first()?->id;
        $films_lastID = Film::orderBy('id', 'desc')->first()?->id;

        $fecha = date('Y-m-d', strtotime($time->time));
        $hora = date('H', strtotime($time->time));
        $minuto = date('i', strtotime($time->time));

        return Inertia::render('Time/Form', [
            'time' => $time,
            'dataControl' => [
                ['key' => 'room_id', 'field' => $time->room_id, 'type' => 'number', 'posibilities' => $rooms_lastID],
                ['key' => 'film_id', 'field' => $time->film_id, 'type' => 'number', 'posibilities' => $films_lastID],
                ['key' => 'time', 'field' => ['fecha' => $fecha, 'hora' => $hora, 'minuto' => $minuto], 'type' => 'date', 'posibilities' => ''],
            ],
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'room_id' => 'required|integer|exists:rooms,id',
            'film_id' => 'required|integer|exists:films,id',
            'time_fecha' => 'required|date',
            'time_hora' => 'required|integer|min:0|max:23',
            'time_minuto' => 'required|integer|min:0|max:59',
        ]);

        $fecha = $request->input('time_fecha');
        $hora = str_pad($request->input('time_hora'), 2, '0', STR_PAD_LEFT);
        $minuto = str_pad($request->input('time_minuto'), 2, '0', STR_PAD_LEFT);
        $fechaCompleta = "{$fecha} {$hora}:{$minuto}:00";

        $time = Time::findOrFail($id);
        $time->room_id = $request->room_id;
        $time->film_id = $request->film_id;
        $time->time = $fechaCompleta;
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
