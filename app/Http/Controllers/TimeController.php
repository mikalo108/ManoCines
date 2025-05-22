<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Time;
use App\Models\Room;
use App\Models\Film;

class TimeController extends Controller
{
    private const PAGINATE_SIZE = 10;

    // Display a listing of times
    public function index()
    {
        $times = Time::paginate(self::PAGINATE_SIZE);
        return view('time.index', compact('times'));
    }

    // Show the form for creating a new time
    public function create()
    {
        $rooms = Room::all();
        $films = Film::all();
        return view('time.form', compact('rooms', 'films'));
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

        return redirect()->route('time.index');
    }

    // Display the specified time
    public function show($id)
    {
        $time = Time::findOrFail($id);
        return view('time.show', compact('time'));
    }

    // Show the form for editing the specified time
    public function edit($id)
    {
        $time = Time::findOrFail($id);
        $rooms = Room::all();
        $films = Film::all();
        return view('time.form', compact('time', 'rooms', 'films'));
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

        return redirect()->route('time.index');
    }

    // Remove the specified time from storage
    public function destroy($id)
    {
        $time = Time::findOrFail($id);
        $time->delete();

        return redirect()->route('time.index');
    }
}
