<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cinema;
use App\Models\City;
use Inertia\Inertia;
use Illuminate\Support\Facades\Lang;

class CinemaController extends Controller
{
    private const PAGINATE_SIZE = 5;

    public function index(Request $request){
        app()->setLocale(session('locale', app()->getLocale()));  
        $query = Cinema::query();

        if ($request->filled('cinemaId')) {
            $query->where('id', $request->cinemaId);
        }

        if ($request->filled('cinemaCityName')) {
            $query->whereHas('city', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->cinemaCityName . '%');
            });
        }

        if($request->filled('cinemaCityId')){
            $query->where('city_id', $request->cinemaCityId);
        }

        $cinemas = $query->orderBy('id', 'desc')->paginate(self::PAGINATE_SIZE);
        $citiesAvailable = City::orderBy('name')->pluck('name')->toArray();

        // Get products selected from session if any
        $selectedProducts = session()->get('selectedProducts', []);
        // Get chairs and products selected from session if any
        $chairsSelected = session()->get('chairsSelected', []);
        
        return Inertia::render('Cinema/Index', [
            'citiesAvailable' => $citiesAvailable,
            'cinemas' => $cinemas,
            'selectedProducts' => $selectedProducts,
            'chairsSelected' => $chairsSelected,
            'filters' => $request->all('search', 'trashed'),
            'langTable' => fn () => Lang::get('tableCinemas'),
            'langTableChair' => fn () => Lang::get('tableChairs'),
            'lang' => fn () => Lang::get('general'),
            'fieldsCanFilter' => [
                ['key' => 'cinemaId', 'field' => $request->cinemaId],
                ['key' => 'cinemaCityId', 'field' => $request->cinemaCityId],
                ['key' => 'cinemaCityName', 'field' => $request->cinemaCityName],
            ],
        ]);
    }

    public function create() {
        app()->setLocale(session('locale', app()->getLocale()));          
        $cities_lastID = City::orderBy('id', 'desc')->first()?->id;

        return Inertia::render('Cinema/Form', [
         'dataControl' => [
                ['key' => 'name', 'field' => '', 'type' => 'text', 'posibilities' => ''],
                ['key' => 'location', 'field' => '', 'type' => 'text', 'posibilities' => ''],
                ['key' => 'description', 'field' => '', 'type' => 'text', 'posibilities' => ''],
                ['key' => 'city_id', 'field' => '', 'type' => 'number', 'posibilities' => $cities_lastID],
            ],
        ]);
    }

    public function store(Request $r) { 
        $r->validate([
            'name' => 'required|string|max:255',  
            'location' => 'required|string|max:255',  
            'description' => 'nullable|string|max:1000',  
            'city_id' => 'required|integer|exists:cities,id',
        ]);

        $c = new Cinema();
        $c->name = $r->name;
        $c->location = $r->location;
        $c->description = $r->description;
        $c->city_id=$r->city_id;
        $c->save();

        return redirect()->route('cinemas.index');
    }

    public function edit($id) { 
        $c = Cinema::findOrFail($id);
        app()->setLocale(session('locale', app()->getLocale()));          
        $cities_lastID = City::orderBy('id', 'desc')->first()?->id;

        return Inertia::render('Cinema/Form', [ 
            'cinema' => $c,
            'dataControl' => [
                ['key' => 'name', 'field' => $c->name, 'type' => 'text', 'posibilities' => ''],
                ['key' => 'location', 'field' => $c->location, 'type' => 'text', 'posibilities' => ''],
                ['key' => 'description', 'field' => $c->description, 'type' => 'text', 'posibilities' => ''],
                ['key' => 'city_id', 'field' => $c->city_id, 'type' => 'number', 'posibilities' => $cities_lastID],
            ],
        ]);
    }

    public function update($id, Request $r) { 
        $r->validate([
            'name' => 'required|string|max:255',  
            'location' => 'required|string|max:255',  
            'description' => 'nullable|string|max:1000',  
            'city_id' => 'required|integer|exists:cities,id',
        ]);
        
        $c = Cinema::find($id);
        $c->name = $r->name;
        $c->location = $r->location;
        $c->description = $r->description;
        $c->city_id=$r->city_id;
        $c->save();

        return redirect()->route('cinemas.index');
    }

    public function destroy($id) { 
        $c = Cinema::find($id);
        $c->delete();
        return redirect()->route('cinemas.index');
    }
}
