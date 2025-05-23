<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cinema;
use Inertia\Inertia;

class CinemaController extends Controller
{
    private const PAGINATE_SIZE = 10;

    // Función para devolver a la página de detalles del elemento que se pide
    public function show($id){
        $cinema = Cinema::with(['products', 'rooms'])->findOrFail($id);
        return Inertia::render('Cinema/show', ['cinema' => $cinema]);
    }

    // Función para devolver a la página de creación del elemento
    public function create() {
        $cities = \App\Models\City::all();
        $products = \App\Models\Product::all();
        $chairs = \App\Models\Chair::all();
        return Inertia::render('Cinema/form', ['cities' => $cities, 'products' => $products, 'chairs' => $chairs]);
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
            'chairs' => 'array',
            'chairs.*' => 'integer|exists:chairs,id',
        ]);

        $c = new Cinema();
        $c->name = $r->name;
        $c->location = $r->location;
        $c->description = $r->description;
        $c->save();

        // Attach city to cinema
        $c->cities()->attach($r->city_id);

        // Attach products and chairs
        if ($r->has('products')) {
            $c->products()->attach($r->products);
        }
        if ($r->has('chairs')) {
            $c->chairs()->attach($r->chairs);
        }

        return redirect()->route('cinema.index');
    }

    // Función para devolver a la página de edición del elemento
    public function edit($id) { 
        $c = Cinema::with(['products', 'chairs'])->find($id);
        $cities = \App\Models\City::all();
        $products = \App\Models\Product::all();
        $chairs = \App\Models\Chair::all();
        return Inertia::render('Cinema/form', ['cinema' => $c, 'cities' => $cities, 'products' => $products, 'chairs' => $chairs]);
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
            'chairs' => 'array',
            'chairs.*' => 'integer|exists:chairs,id',
        ]);
        
        $c = Cinema::find($id);
        $c->name = $r->name;
        $c->location = $r->location;
        $c->description = $r->description;
        $c->save();

        // Sync city to cinema
        $c->cities()->sync([$r->city_id]);

        // Sync products and chairs
        $c->products()->sync($r->products ?? []);
        $c->chairs()->sync($r->chairs ?? []);

        return redirect()->route('cinema.index');
    }

    // Funcion para eliminar el elemento de la base de datos
    public function destroy($id) { 
        $c = Cinema::find($id);
        $c->delete();
        return redirect()->route('cinema.index');
    }
}
