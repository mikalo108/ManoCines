<?php

namespace App\Http\Controllers;

use App\Models\Cinema;
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
            $query->where('time', 'like', '%' . $request->time . '%');
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

    public function indexForAFilm($cinemaId, $filmId, Request $request)
    {
        app()->setLocale(session('locale', app()->getLocale()));

        $film = Film::findOrFail($filmId);
        $cinema = Cinema::where('id', $cinemaId)->first();

        $roomIds = Time::where('film_id', $filmId)
            ->whereIn('room_id', function ($query) use ($cinemaId) {
                $query->select('room_id')
                    ->from('cinemas_rooms')
                    ->where('cinema_id', $cinemaId);
            })
            ->pluck('room_id')
            ->unique()
            ->toArray();

        $rooms = Room::whereIn('id', $roomIds)->get();

        $times = Time::where('film_id', $filmId)
            ->whereIn('room_id', function ($query) use ($cinemaId) {
                $query->select('room_id')
                    ->from('cinemas_rooms')
                    ->where('cinema_id', $cinemaId);
            })
            ->get();


        if ($request->filled('timeDate')) {
            $times->where('time', 'like',  $request->timeDate . '%');
        }

        return Inertia::render('Time/IndexForAFilm', [
            'langTable' => Lang::get('tableTimes'),
            'timeDate' => $request->timeDate,
            'film' => $film,
            'cinema' => $cinema,
            'rooms' => $rooms,
            'times' => $times,
        ]);
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
            'time' => 'required|date',
            'time_hour' => 'required|integer|min:0|max:23',
            'time_minute' => 'required|integer|min:0|max:59',
        ]);

        $validation = Time::where('room_id', $request->room_id)->where('film_id', $request->film_id);
        if ($validation->exists()) {
            return redirect()->back()
                ->withErrors(['time' => 'Ya existe una relación con esta Room ID y Film ID.'])
                ->withInput();
        }

        $fecha = $request->input('time_fecha');
        $hora = str_pad($request->input('time_hour'), 2, '0', STR_PAD_LEFT);
        $minuto = str_pad($request->input('time_minute'), 2, '0', STR_PAD_LEFT);
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
            'time' => 'required|date',
            'time_hour' => 'required|integer|min:0|max:23',
            'time_minuto' => 'required|integer|min:0|max:59',
        ]);

        $validation = Time::where('room_id', $request->room_id)->where('film_id', $request->film_id);
        if ($validation->exists() && $validation->id != $id) {
            return redirect()->back()
                ->withErrors(['time' => 'Ya existe una relación con esta Room ID y Film ID.'])
                ->withInput();
        }

        $fecha = $request->input('time');
        $hora = str_pad($request->input('time_hour'), 2, '0', STR_PAD_LEFT);
        $minuto = str_pad($request->input('time_minute'), 2, '0', STR_PAD_LEFT);
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
