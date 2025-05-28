<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use Inertia\Inertia;
use Illuminate\Support\Facades\Lang;

class CityController extends Controller
{
    private const PAGINATE_SIZE = 5;
    
    public function index(Request $request)
    {
        app()->setLocale(session('locale', app()->getLocale()));  
        $query = City::query();

        if ($request->filled('cityId')) {
            $query->where('id', $request->cityId);
        }

        if ($request->filled('cityName')) {
            $query->where('name', 'like', '%' . $request->cityName . '%');
        }

        $cityList = $query->orderBy('id', 'desc')->paginate(self::PAGINATE_SIZE);

        return Inertia::render('City/Index', [
            'cities' => $cityList,
            'cityName' => $request->cityName ?? '',
            'filters' => $request->all('search', 'trashed'),
            'langTable' => fn () => Lang::get('tableCities'),
            'fieldsCanFilter' => [
                ['key' => 'cityId', 'field' => $request->cityId],
                ['key' => 'cityName', 'field' => $request->cityName],
            ],
        ]);
    }   

    public function show($id){
        $city = City::findOrFail($id);
        return Inertia::render('City/Show', ['city' => $city]);
    }

    public function create() { 
        app()->setLocale(session('locale', app()->getLocale()));          

        return Inertia::render('City/Form', [
         'dataControl' => [
                ['key' => 'name', 'field' => '', 'type' => 'text', 'posibilities' => ''],
            ],
        ]); 
    }

    public function store(Request $r) { 
        $r->validate([
            'name' => 'required|string|max:255', 
        ]);

        $c = new City();
        $c->name = $r->name;
        $c->cinema_id = $r->cinema_id;
        $c->save();
        return redirect()->route('cities.index');
    }

    public function edit($id) { 
        app()->setLocale(session('locale', app()->getLocale()));          
        $c = City::find($id);

        return Inertia::render('City/Form', [
            'city' => $c,
            'dataControl' => [
                ['key' => 'name', 'field' => $c->name, 'type' => 'text', 'posibilities' => ''],
            ],
        ]); 
    }

    public function update($id, Request $r) { 
        $r->validate([
            'name' => 'required|string|max:255', 
        ]);
        
        $c = City::find($id);
        $c->name = $r->name;
        $c->cinema_id = $r->cinema_id;
        $c->save();
        return redirect()->route('cities.index');
    }

    public function destroy($id) { 
        $c = City::find($id);
        $c->delete();
        return redirect()->route('cities.index');
    }
}
