<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TemporalReserve;
use Inertia\Inertia;
use Illuminate\Support\Facades\Lang;

class TemporalReserveController extends Controller
{
    private const PAGINATE_SIZE = 5;

    public function index(Request $request)
    {
        app()->setLocale(session('locale', app()->getLocale()));  
        $query = TemporalReserve::query();

        if ($request->filled('temporalReserveId')) {
            $query->where('id', $request->temporalReserveId);
        }

        if ($request->filled('chairId')) {
            $query->where('chair_id', $request->chairId);
        }

        $temporalReserves = $query->orderBy('id', 'desc')->paginate(self::PAGINATE_SIZE);
        return Inertia::render('TemporalReserve/Index', [
            'temporalReserves' => $temporalReserves,
            'langTable' => fn () => Lang::get('tableTemporalReserves'),
            'fieldsCanFilter' => [
                ['key' => 'temporalReserveId', 'field' => $request->temporalReserveId],
                ['key' => 'chairId', 'field' => $request->chairId],
            ],
        ]);
    }

    public function show($id)
    {
        $temporalReserve = TemporalReserve::findOrFail($id);
        return Inertia::render('TemporalReserve/Show', ['temporalReserve' => $temporalReserve]);
    }

    public function create()
    {
        app()->setLocale(session('locale', app()->getLocale()));  
        $chairs_lastID = \App\Models\Chair::orderBy('id', 'desc')->first()?->id;

        return Inertia::render('TemporalReserve/Form', [
            'dataControl' => [
                ['key' => 'chair_id', 'field' => '', 'type' => 'number', 'posibilities' => $chairs_lastID],
                ['key' => 'reserve_time', 'field' => ['fecha' => '', 'hora' => '', 'minuto' => ''], 'type' => 'date', 'posibilities' => ''],
            ],
        ]); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'chair_id' => 'required|integer|exists:chairs,id',
            'reserve_time' => 'required|date',
            'reserve_time_hour' => 'required|integer|min:0|max:23',
            'reserve_time_minute' => 'required|integer|min:0|max:59',
        ]);

        $validation = TemporalReserve::where('chair_id', $request->chair_id);
        if ($validation->exists()) {
            return redirect()->back()
                ->withErrors(['temporal_reseve' => 'Esta Chair ID ya está bloqueada.'])
                ->withInput();
        }

        $fecha = $request->input('reserve_time');
        $hora = str_pad($request->input('reserve_time_hour'), 2, '0', STR_PAD_LEFT);
        $minuto = str_pad($request->input('reserve_time_minute'), 2, '0', STR_PAD_LEFT);
        $fechaCompleta = "{$fecha} {$hora}:{$minuto}:00";

        $tr = new TemporalReserve();
        $tr->chair_id = $request->chair_id;
        $tr->reserve_time = $fechaCompleta;
        $tr->save();

        return redirect()->route('temporal-reserves.index');
    }

    public function edit($id)
    {
        app()->setLocale(session('locale', app()->getLocale()));  
        $tr = TemporalReserve::findOrFail($id);
        $chairs_lastID = \App\Models\Chair::orderBy('id', 'desc')->first()?->id;

        $fecha = date('Y-m-d', strtotime($tr->reserve_time));
        $hora = date('H', strtotime($tr->reserve_time));
        $minuto = date('i', strtotime($tr->reserve_time));

        return Inertia::render('TemporalReserve/Form', [
            'temporalReserve' => $tr,
            'dataControl' => [
                ['key' => 'chair_id', 'field' => $tr->chair_id, 'type' => 'number', 'posibilities' => $chairs_lastID],
                ['key' => 'reserve_time', 'field' => ['fecha' => $fecha, 'hora' => $hora, 'minuto' => $minuto], 'type' => 'date', 'posibilities' => ''],
            ],
        ]); 
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'chair_id' => 'required|integer|exists:chairs,id',
            'reserve_time' => 'required|date',
            'reserve_time_hour' => 'required|integer|min:0|max:23',
            'reserve_time_minute' => 'required|integer|min:0|max:59',
        ]);

        $validation = TemporalReserve::where('chair_id', $request->chair_id);
        if ($validation->exists() && $validation->id != $id) {
            return redirect()->back()
                ->withErrors(['temporal_reseve' => 'Esta Chair ID ya está bloqueada.'])
                ->withInput();
        }

        $fecha = $request->input('reserve_time');
        $hora = str_pad($request->input('reserve_time_hour'), 2, '0', STR_PAD_LEFT);
        $minuto = str_pad($request->input('reserve_time_minute'), 2, '0', STR_PAD_LEFT);
        $fechaCompleta = "{$fecha} {$hora}:{$minuto}:00";

        $tr = TemporalReserve::findOrFail($id);
        $tr->chair_id = $request->chair_id;
        $tr->reserve_time = $fechaCompleta;
        $tr->save();

        return redirect()->route('temporal-reserves.index');
    }

    public function destroy($id)
    {
        $tr = TemporalReserve::findOrFail($id);
        $tr->delete();

        return redirect()->route('temporal-reserves.index');
    }
}
