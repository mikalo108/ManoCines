<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use Inertia\Inertia;

class CityController extends Controller
{
    private const PAGINATE_SIZE = 10;

    // Función para devolver a la página de detalles del elemento que se pide
    public function show($id){
        $city = City::findOrFail($id);
        return Inertia::render('City/Show', ['city' => $city]);
    }

    // Función para devolver a la página de creación del elemento
    public function create() {
        return Inertia::render('City/Form');  
    }

    // Función para guardar el elemento en la base de datos
    public function store(Request $r) { 
        $r->validate([
            'name' => 'required|string|max:255',  
            'state' => 'nullable|string|max:255',  
            'country' => 'nullable|string|max:255',  
            'cinema_id' => 'required|integer|exists:cinemas,id',
        ]);

        $c = new City();
        $c->name = $r->name;
        $c->state = $r->state;
        $c->country = $r->country;
        $c->cinema_id = $r->cinema_id;
        $c->save();
        return redirect()->route('city.index');
    }

    // Función para devolver a la página de edición del elemento
    public function edit($id) { 
        $c = City::find($id);
        return Inertia::render('City/Form', ['city' => $c]);
    }

    // Función para actualizar el elemento en la base de datos
    public function update($id, Request $r) { 
        $r->validate([
            'name' => 'required|string|max:255',  
            'state' => 'nullable|string|max:255',  
            'country' => 'nullable|string|max:255',  
            'cinema_id' => 'required|integer|exists:cinemas,id',
        ]);
        
        $c = City::find($id);
        $c->name = $r->name;
        $c->state = $r->state;
        $c->country = $r->country;
        $c->cinema_id = $r->cinema_id;
        $c->save();
        return redirect()->route('city.index');
    }

    // Funcion para eliminar el elemento de la base de datos
    public function destroy($id) { 
        $c = City::find($id);
        $c->delete();
        return redirect()->route('city.index');
    }
}
