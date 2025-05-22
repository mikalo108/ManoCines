<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cinema;

class CinemaController extends Controller
{
    private const PAGINATE_SIZE = 10;

    // Función para devolver a la página de detalles del elemento que se pide
    public function show($id){
        $cinema = Cinema::with(['products', 'rooms'])->findOrFail($id);
        return view('cinema.show', compact('cinema'));
    }

    // Función para devolver a la página de creación del elemento
    public function create() {
        $cities = \App\Models\City::all();
        $products = \App\Models\Product::all();
        $rooms = \App\Models\Room::all();
        return view('cinema.form', compact('cities', 'products', 'rooms'));  
    }

    // Función para guardar el elemento en la base de datos
    public function store(Request $r) { 
        $r->validate([
            'name' => 'required|string|max:255',  
            'location' => 'required|string|max:255',  
            'description' => 'nullable|string|max:1000',  
            'city_id' => 'required|integer|exists:cities,id',
            'products' => 'array',
            'products.*' => 'integer|exists:products,id',
            'rooms' => 'array',
            'rooms.*' => 'integer|exists:rooms,id',
        ]);

        $c = new Cinema();
        $c->name = $r->name;
        $c->location = $r->location;
        $c->description = $r->description;
        $c->save();

        // Attach city to cinema
        $c->cities()->attach($r->city_id);

        // Attach products and rooms
        if ($r->has('products')) {
            $c->products()->attach($r->products);
        }
        if ($r->has('rooms')) {
            $c->rooms()->attach($r->rooms);
        }

        return redirect()->route('cinema.index');
    }

    // Función para devolver a la página de edición del elemento
    public function edit($id) { 
        $c = Cinema::with(['products', 'rooms'])->find($id);
        $cities = \App\Models\City::all();
        $products = \App\Models\Product::all();
        $rooms = \App\Models\Room::all();
        return view('cinema.form', ['cinema' => $c, 'cities' => $cities, 'products' => $products, 'rooms' => $rooms]);
    }

    // Función para actualizar el elemento en la base de datos
    public function update($id, Request $r) { 
        $r->validate([
            'name' => 'required|string|max:255',  
            'location' => 'required|string|max:255',  
            'description' => 'nullable|string|max:1000',  
            'city_id' => 'required|integer|exists:cities,id',
            'products' => 'array',
            'products.*' => 'integer|exists:products,id',
            'rooms' => 'array',
            'rooms.*' => 'integer|exists:rooms,id',
        ]);
        
        $c = Cinema::find($id);
        $c->name = $r->name;
        $c->location = $r->location;
        $c->description = $r->description;
        $c->save();

        // Sync city to cinema
        $c->cities()->sync([$r->city_id]);

        // Sync products and rooms
        $c->products()->sync($r->products ?? []);
        $c->rooms()->sync($r->rooms ?? []);

        return redirect()->route('cinema.index');
    }

    // Funcion para eliminar el elemento de la base de datos
    public function destroy($id) { 
        $c = Cinema::find($id);
        $c->delete();
        return redirect()->route('cinema.index');
    }
}
