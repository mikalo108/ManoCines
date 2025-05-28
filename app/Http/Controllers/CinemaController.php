<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cinema;
use Inertia\Inertia;
use Illuminate\Support\Facades\Lang;

class CinemaController extends Controller
{
    private const PAGINATE_SIZE = 5;

    public function index(Request $request){
        $query = Cinema::query();

        if ($request->filled('cinemaId')) {
            $query->where('id', $request->cinemaId);
        }

        if ($request->filled('cinemaCity')) {
            $query->whereHas('cities', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->cinemaCity . '%');
            });
        }

        $cinemas = $query->orderBy('id', 'desc')->paginate(self::PAGINATE_SIZE);

        return Inertia::render('Cinema/Index', [
            'cinemas' => $cinemas,
            'langTable' => fn () => Lang::get('tableCinemas'),
            'fieldsCanFilter' => ['cinemaId', 'cinemaCity'],
        ]);
    }

    public function show($id){
        $cinema = Cinema::with(['products', 'rooms'])->findOrFail($id);
        return Inertia::render('Cinema/show', ['cinema' => $cinema]);
    }

    public function create() {
        $cities = \App\Models\City::all();
        $products = \App\Models\Product::all();
        $chairs = \App\Models\Chair::all();
        return Inertia::render('Cinema/form', ['cities' => $cities, 'products' => $products, 'chairs' => $chairs]);
    }

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

        $c->cities()->attach($r->city_id);

        if ($r->has('products')) {
            $c->products()->attach($r->products);
        }
        if ($r->has('chairs')) {
            $c->chairs()->attach($r->chairs);
        }

        return redirect()->route('cinemas.index');
    }

    public function edit($id) { 
        $c = Cinema::with(['products', 'chairs'])->find($id);
        $cities = \App\Models\City::all();
        $products = \App\Models\Product::all();
        $chairs = \App\Models\Chair::all();
        return Inertia::render('Cinema/form', ['cinema' => $c, 'cities' => $cities, 'products' => $products, 'chairs' => $chairs]);
    }

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

        $c->cities()->sync([$r->city_id]);

        $c->products()->sync($r->products ?? []);
        $c->chairs()->sync($r->chairs ?? []);

        return redirect()->route('cinemas.index');
    }

    public function destroy($id) { 
        $c = Cinema::find($id);
        $c->delete();
        return redirect()->route('cinemas.index');
    }
}
