<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TemporalReserve;
use Inertia\Inertia;

class TemporalReserveController extends Controller
{
    private const PAGINATE_SIZE = 10;

    // Función para devolver a la página de detalles del elemento que se pide
    public function show($id){
        $temporalReserve = TemporalReserve::findOrFail($id);
        return Inertia::render('TemporalReserve/Show', ['temporalReserve' => $temporalReserve]);
    }

    // Función para devolver a la página de creación del elemento
    public function create() {
        return Inertia::render('TemporalReserve/Form');  
    }

    // Función para guardar el elemento en la base de datos
    public function store(Request $r) { 
        $r->validate([
            'chair_id' => 'required|integer|exists:chairs,id',  
            'reserve_time' => 'required|date',  
        ]);

        $tr = new TemporalReserve();
        $tr->chair_id = $r->chair_id;
        $tr->save();
        return redirect()->route('temporal-reserves.index');
    }

    // Función para devolver a la página de edición del elemento
    public function edit($id) { 
        $tr = TemporalReserve::find($id);
        return Inertia::render('TemporalReserve/Form', ['temporalReserve' => $tr]);
    }

    // Función para actualizar el elemento en la base de datos
    public function update($id, Request $r) { 
        $r->validate([
            'chair_id' => 'required|integer|exists:chairs,id',  
            'reserve_time' => 'required|date',  
        ]);
        
        $tr = TemporalReserve::find($id);
        $tr->chair_id = $r->chair_id;
        $tr->save();
        return redirect()->route('temporal-reserves.index');
    }

    // Funcion para eliminar el elemento de la base de datos
    public function destroy($id) { 
        $tr = TemporalReserve::find($id);
        $tr->delete();
        return redirect()->route('temporal-reserves.index');
    }
}
