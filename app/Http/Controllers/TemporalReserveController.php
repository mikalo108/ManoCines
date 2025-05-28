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
            'fieldsCanFilter' => ['temporalReserveId', 'chairId'],
        ]);
    }

    public function show($id)
    {
        $temporalReserve = TemporalReserve::findOrFail($id);
        return Inertia::render('TemporalReserve/Show', ['temporalReserve' => $temporalReserve]);
    }

    public function create()
    {
        return Inertia::render('TemporalReserve/Form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'chair_id' => 'required|integer|exists:chairs,id',
            'reserve_time' => 'required|date',
        ]);

        $tr = new TemporalReserve();
        $tr->chair_id = $request->chair_id;
        $tr->reserve_time = $request->reserve_time;
        $tr->save();

        return redirect()->route('temporal-reserves.index');
    }

    public function edit($id)
    {
        $tr = TemporalReserve::findOrFail($id);
        return Inertia::render('TemporalReserve/Form', ['temporalReserve' => $tr]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'chair_id' => 'required|integer|exists:chairs,id',
            'reserve_time' => 'required|date',
        ]);

        $tr = TemporalReserve::findOrFail($id);
        $tr->chair_id = $request->chair_id;
        $tr->reserve_time = $request->reserve_time;
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
